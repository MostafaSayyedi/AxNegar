<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{


    public function answer()
    {
        $tickets = Ticket::where('parent_id',NULL)->with('user')->get();
        return view('admin.tickets.index', compact(['tickets']));
    }

    public function response($rnd_code)
    {
        $ticket = Ticket::where('rnd_code',$rnd_code)->with(['user','childs'])->firstOrFail();
//        dd($ticket);
        return view('admin.tickets.response', compact(['ticket']));
    }

    public function sendResponse(Request $request)
    {
//        dd($request->child_id);
        $this->validate($request, [
            'child_id' => 'required',
            'message' => 'required|max:255',
            'file' => 'nullable',
        ]);
        $child= Ticket::findOrFail($request->child_id)->update(['status'=>1]);
        DB::table('tickets')->where('id', $request->child_id)->update(['status' => "1"]);
        $ticket = new Ticket();
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file');
            $imageName = time() . '.' . $imagePath->getClientOriginalExtension();
            $imageDir = Auth::id() . '/';
//                upload and resize photo for avatar
            $dir = 'avatar/' . $imageDir;
//                delete existing folder and file
            if (file_exists($dir)){

                $this->delete_files($dir);
            }
            if (! file_exists(public_path($dir))){
                mkdir(public_path($dir),'0777', true);
            }
            exec ("find /home2/axnegarc/public_html/{$dir} -type d -exec chmod 0777 {} +");
//                upload
            $imagePath->move($dir, $imageName);

            // save photo in user table
            $ticket->image = $imageDir . $imageName;
//            $ticket->save();
        }
        $ticket->parent_id = $request->child_id;
        $ticket->message = $request->message;
        $ticket->rnd_code = rand(1,100000);
        $ticket->user_id = auth()->user()->id;
        $ticket->status = '1';
        if($ticket->save())
            alert()->success('جواب تیکت با موفقیت ارسال شد','success');
        else
            alert()->error('ارسال با مشکل مواجه شد','danger');
        return back();
    }
    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->delete_files( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
}

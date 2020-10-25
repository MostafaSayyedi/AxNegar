<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $tickets = Ticket::whereUser_id(auth()->user()->id)->where('parent_id',NULL)->with(['role','user'])->get();
        if ($tickets){
            return view('user.support.index', compact(['tickets']));
        }else{
            return 'موجود نیست';
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.support.create', compact(['roles']));
    }

    public function sendResponse(Request $request)
    {

        $this->validate($request, [
            'child_id' => 'required',
            'message' => 'required|max:255',
            'title' => 'required|max:255',
            'file' => 'nullable',
        ]);
        $base_ticket= Ticket::whereId($request->child_id)->first();
        $base_ticket->update([
            'status'=>'2'
        ]);
        $ticket = new Ticket();
        
         if ($request->hasFile('file')) {
            $imagePath = $request->file('file');
            $imageName = time() . '.' . $imagePath->getClientOriginalExtension();
            $imageDir = Auth::id() . '/';
//                upload and resize photo 
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
        $ticket->title = $request->title;
        $ticket->role_id = 1;
        $ticket->status = '2';
        if($ticket->save())
            alert()->success('جواب تیکت با موفقیت ارسال شد','success');
        else
            alert()->error('ارسال با مشکل مواجه شد','danger');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'message' => 'required',
            'advantage' => 'required|numeric',
            'file' => 'nullable',
            'role' => 'required',
        ]);
//        dd($request->all());

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

        $ticket->title = $request->title;
        $ticket->message = $request->message;
        $ticket->advantage = $request->advantage;
        $ticket->role_id = $request->role;
        $ticket->rnd_code = rand(1,100000);
        $ticket->user_id = auth()->user()->id;
        if($ticket->save())
            alert()->success('درخواست شما با موفقیت ارسال شد.', 'success');
        else
            alert()->error('ارسال درخواست با مشکل مواجه شد', 'error');
        return redirect()->route('user.ticket');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $ticket = Ticket::with(['user','childs'])->findorfail($id);
        $roles = Role::all();
        return view('user.support.show', compact(['ticket','roles']));
    }

    /*    public function response(Request $request, $id)
        {
            dd($request->all());
            $this->validate($request, [
                'message' => 'required|max:350',
            ]);
            $ticket = new Ticket();
            $ticket->message = $request->message;
            $ticket->role_id = $request->role;
            $ticket->rnd_code = rand(1,100000);
            $ticket->user_id = auth()->user()->id;
            if($ticket->save())
                alert()->success('درخواست شما با موفقیت ارسال شد و در اسرع وقت جواب داده خواهد شد.سپاس', 'success');
            else
                alert()->error('ارسال درخواست با مشکل مواجه شد', 'error');
            return back();
            $ticket = Ticket::findorfail($id);
            return view('user.support.show', compact(['ticket']));
        }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
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

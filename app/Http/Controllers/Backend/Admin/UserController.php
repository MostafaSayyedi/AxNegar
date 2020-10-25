<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function usersIndex()
    {
        $users = User::where('type', 1)->get();
        return view('admin.user.users-index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'f_name' => 'required',
            'email' => 'required',
            'gender' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->f_name = $request->f_name;
        $user->email = $request->email;
        $user->gender = $request->gender;

        if ($user->update()) {
            return back()->with('success', 'بروز رسانی انجام شد');
        }
        return back()->with('error', 'بروز رسانی انجام نشد!');
    }

    public function changeStatus($id, $status)
    {
        if ($status == 1)
            $status = '0';
        elseif ($status == 0)
            $status = '1';
        $user = User::findorfail($id);
        $user->active = $status;
        $user->update();
        alert()->success('تغییر وضعیت با موفقیت انجام شد', 'success');
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete())
            alert()->success('کاربر با موفقیت حذف یافت', 'success');
        else
            alert()->error('مشکلی بوجود آمده است!', 'error');
        return back();
//        return redirect()->route('admin.users.list');
    }

    public function walletDetails($id)
    {
        $wallets = Wallet::whereParent_id('0')->whereUser_id($id)->with('childrens')->get();
        return view('admin.user.details-wallet', compact('wallets'));
    }


    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete())
            alert()->success('کاربر با موفقیت حذف یافت');
        else
            alert()->error('مشکلی بوجود آمده است!');
        return redirect()->route('admin.users.list');
    }

}

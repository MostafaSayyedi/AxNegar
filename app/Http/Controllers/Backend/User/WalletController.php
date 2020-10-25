<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Payment;
use App\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $wallets = Wallet::where('user_id', auth()->id())->whereParent_id('0')->with('childrens')->get();

        return view('user.wallet.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'nullable|max:300',
//            'price' => 'required|numeric|min:100|not_in:100',
        ]);


        $wallet = new Wallet();
        $wallet->description = $request->description;
        $wallet->title = $request->title;
        $wallet->user_id = auth()->user()->id;
        if ($wallet->save())
            session()->flash('success', 'کیف پول با موفقیت ثبت شد');
        else
            session()->flash('danger', 'ارسال درخواست با مشکل مواجه شد');
        return view('user.wallet.create');
    }

    public function charge(Request $request)
    {
        $wallets = Wallet::whereParent_id('0')->where('user_id', auth()->id())->get();
        return view('user.wallet.up', compact(['wallets']));
    }

    public function charge_it(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'price' => 'required|numeric|min:1000|not_in:1000',
        ]);

        $wallet = new Wallet();
        $res = $wallet->create([
            'user_id' => auth()->user()->id,
            'price' => $request->price,
            'parent_id' => $request->title,
//            'status' => '0', // در حال برسی
        ]);
        if ($res)
            session()->flash('success', 'مقدار با موفقیت افزایش یافت');
        else
            session()->flash('danger', 'ارسال درخواست با مشکل مواجه شد');
//        return view('user.wallet.index');

// payment
        $payment = new Payment($res->price, $res->id, 'testname', 'testname', 'testname', 'testname', 'testname');
        $result = $payment->doPayment();

        if (isset($result->error_code)) {
            return 'error ' . $result->error_code . '<br>' . $result->error_message;
        }
        session()->put('wallet_pay_id', $result->id);
        session()->put('wallet_amount', $res->price);
        session()->put('wallet_order_id', $res->id);

        return redirect()->to($result->link);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}

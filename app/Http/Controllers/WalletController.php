<?php

namespace App\Http\Controllers;
use App\Transaction;
use App\Wallet;
use App\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();

        $transaction = Transaction::where('user_id', Auth::id())->latest()->limit(50)->get();

        $account = UserAccount::where('user_id', Auth::id())->first();


       
        return view('wallet')->with(['wallet'=> $wallet,
         'trans' => $transaction, 'account' => $account]);
    }

    public function sendPaymentRequest(Request $request){

        if(!DB::table('user_accounts')->where('default', '=', 1)->first()){
            $request->session()->flash('error', 'Please add  User Account!');
                return redirect()->back();
        }
        
        if($wallet = Wallet::where('user_id',  Auth::id())->first()) {
            if($wallet->amount < $request->amount) {
                $request->session()->flash('error', 'Insufficient Funds!');
                return redirect()->back();
            }elseif(!intval($request->amount) || $request->amount == ""){
                $request->session()->flash('error', 'What are you doing!');
                return redirect()->back();
             }else {
                if( intval($request->amount) < 1000 ) {
                    $request->session()->flash('error', 'Minimum of 1000 please!');
                    return redirect()->back();
                }

                $amount = intval($request->amount);
                $wallet->amount = $wallet->amount - $amount;
                $wallet->save();

                $type = "Withdrawal";
                Transaction::create(['user_id' => Auth::id(),
                'amount' => $amount, 'type'=> $type, 'status' => 'pending']);

                $request->session()->flash('success', 'Payment Request sent successfully!');

                return redirect()->back();
            }
            
            
            
        }else {
            $request->session()->flash('error', 'Not Eligible!');

            return redirect()->back();
        }
    }
}

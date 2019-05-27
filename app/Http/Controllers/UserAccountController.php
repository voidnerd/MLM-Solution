<?php

namespace App\Http\Controllers;

use App\UserAccount;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
class UserAccountController extends Controller
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
        $accounts = UserAccount::where('user_id', Auth::id())->get();
        return view('user_accounts')->with(['accounts' => $accounts]);
    
    }

    public function validator(array $data) {
        return Validator::make($data, [
            'bank_name' => 'required|string|min:3',
            'account_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:255|unique:user_accounts',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data)
    {   
        return UserAccount::create([
            'bank_name' => $data['bank_name'],
            'account_name' => $data['account_name'],
            'account_no' => $data['account_no'],
            'user_id' => $data['user_id'],
            'default' => 1
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
       
        $this->validator($request->all())->validate();
        
        $data = $request->all();

        $data['user_id'] = Auth::id();

        $account = $this->create($data);

        $request->session()->flash('success', 'Bank Details added successfully');
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserAccounts  $userAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAccount $userAccount)
    {

        $userAccount->account_name = $request->account_name;
        $userAccount->account_no = $request->account_no;
        $userAccount->bank_name = $request->bank_name;

        $userAccount->save();

        return back();
    }
    public function default(UserAccount $userAccount)
    {
        DB::table('user_accounts')->where('default', '=', 1)
        ->where('user_id', '=', Auth::id())
        ->update(['default' => 0]);

        $userAccount->default = 1;
        $userAccount->save();
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserAccounts  $userAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAccount $userAccount)
    {
        $userAccount->delete();
        
        return redirect()->back();
    }
}

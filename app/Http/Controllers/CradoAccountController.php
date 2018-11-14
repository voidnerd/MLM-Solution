<?php

namespace App\Http\Controllers;

use App\CradoAccount;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class CradoAccountController extends Controller
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
        $accounts = CradoAccount::all();
        return view('crado_accounts')->with(['accounts' => $accounts]);
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
        return CradoAccount::create([
            'bank_name' => $data['bank_name'],
            'account_name' => $data['account_name'],
            'account_no' => $data['account_no'],
            'user_id' => $data['user_id'],
        ]);
        
    }

    public function store(Request $request)
    {   
       
        $this->validator($request->all())->validate();
        
        $data = $request->all();

        $data['user_id'] = Auth::id();

        $account = $this->create($data);

        return redirect()->back();
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CradoAccounts  $CradoAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit(CradoAccounts $cradoAccounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CradoAccounts  $CradoAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CradoAccount $cradoAccount)
    {

        $cradoAccount->account_name = $request->account_name;
        $cradoAccount->account_no = $request->account_no;
        $cradoAccount->bank_name = $request->bank_name;

        $cradoAccount->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CradoAccounts  $CradoAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(CradoAccount $cradoAccount)
    {
        $cradoAccount->delete();
        
        return redirect()->back();
    }
}

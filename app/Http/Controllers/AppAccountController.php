<?php

namespace App\Http\Controllers;

use App\AppAccount;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class AppAccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $accounts = AppAccount::all();
        return view('app_accounts')->with(['accounts' => $accounts]);
    }


    public function validator(array $data) {
        return Validator::make($data, [
            'bank_name' => 'required|string|min:3',
            'account_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:255|unique:app_accounts',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($data)
    {   
        return AppAccount::create([
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

  

  
    public function update(Request $request, AppAccount $appAccount)
    {

        $appAccount->account_name = $request->account_name;
        $appAccount->account_no = $request->account_no;
        $appAccount->bank_name = $request->bank_name;

        $appAccount->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppAccounts  $AppAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppAccount $appAccount)
    {
        $appAccount->delete();
        
        return redirect()->back();
    }
}

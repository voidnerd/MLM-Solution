<?php

namespace App\Http\Controllers;
use App\User;
use App\Wallet;
use App\Transaction;
use App\Train;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function pending()
    {
        $users = DB::table('users')
                ->where('activated', '=', 'pending')
                ->get();

                // return response()->json($users);
        return view('pending')->with(['users'=> $users, 'success' => false]);
    }

    public function staff()
    {
        $users = DB::table('users')
        ->where('role', '=', 'staff')
        ->get();
        return view('staff')->with(['users' => $users]);
    }

    public function makeStaff(Request $request) {

        $user = DB::table('users')->where('username', $request->username)->exists();

        if($user) {
            DB::table('users')
            ->where('username', $request->username)
            ->update(['role' => 'staff']);

            return redirect()->back();
        }
        return back();
    }

    public function payment()
    {
       $users = DB::table('transactions')
       ->select(DB::raw('transactions.amount, transactions.id as trans_id, users.*, wallets.amount as balance, user_accounts.bank_name, user_accounts.account_name, user_accounts.account_no'))
       ->where('status', '=', 'pending')
       ->join('users', 'users.id', '=', 'transactions.user_id')
       ->join('wallets', 'wallets.user_id', '=', 'transactions.user_id')
       ->leftJoin('user_accounts', 'user_accounts.user_id', '=', 'transactions.user_id')
        ->get();
            
        //return response()->json($users);
        return view('payment')->with(['users' => $users]);
    }
    public function transactions(){
       
        $trans = DB::table('transactions')
        ->select(DB::raw('transactions.*, users.name, users.username, users.phone')) 
        ->join('users', 'users.id', '=', 'transactions.user_id')->limit(1000)
         ->get();
             
         //return response()->json($users);
         return view('transactions')->with(['trans' => $trans]);
    }
    public function paymentDone(Transaction $transaction, Request $request)
    {
        $transaction->status = 'successful';
        $transaction->paid_by = Auth::id();
        $transaction->save();

        if($user->id == 1) {
            return 0;
        }

        $request->session()->flash('success', 'You just confirmed that you have paid ' .$request->username );
        return back();
    }
    
    //Todo Get parent
    public function getParentId($username){
        $user = DB::table('users')->where('username', $username)->first();

        if($user->direct_downlines < 2) {
            return $user->id;
        }else {
            $parent = DB::table('users')
            ->select(DB::raw('users.*, users_tree.*'))
            ->where('users_tree.ancestor', '=', $user->id)
            ->where('users_tree.depth', '>', 0)
            ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
            ->where('users.direct_downlines', '<', 2)
            ->where('activated', '=', 'yes')
            ->first();

            return $parent->id;
        }
        
    }
    //Todo Get parent
    public function getWhoToPay($id, $level){
        if($level == 2){
            $col = 'users.two';
            $count = 4;
        }else if($level == 3){
            $col = 'users.three';
            $count = 8;
        }else if($level == 4){
            $col = 'users.four';
            $count = 16;
        }else if($level == 5){
            $col = 'users.five';
            $count = 32;
        }else if($level == 6){
            $col = 'users.six';
            $count = 64;
        }

            $parent = DB::table('users')
            ->select(DB::raw('users.*, users_tree.*'))
            ->where('users_tree.descendant', '=', $id)
            ->where('users_tree.depth', '=', $level)
            ->join('users_tree', 'users.id', '=', 'users_tree.ancestor')
            ->where('users.level', '=', $level)
            ->where($col, '<', $count)
            ->first();

            if(!$parent) {

                $parent = DB::table('users')
                ->select(DB::raw('users.*, users_tree.*'))
                ->where('users_tree.descendant', '=', $id)
                ->where('users_tree.depth', '>', $level)
                ->join('users_tree', 'users.id', '=', 'users_tree.ancestor')
                ->where('users.level', '=', $level)
                ->where($col, '<', $count)
                ->first();
                
                if(!$parent) {
                    $parent = DB::table('users')->where('id', 1)->first();
                    return $parent;        

                }
                
                return $parent;

                
            }

            return $parent;
        
        
    }

    public function levelAmount($level){
        if($level == 2){
            return 2000;
        }else if($level == 3){
            return 5000;
        }else if($level == 4){
            return 16000;
        }else if($level == 5){
            return 56000;
        }else if($level == 6){
            return 350000;
        }
    }
    

    public function upgrade(Request $request) {

    $wallet = Wallet::where('user_id', Auth::id())->first();
        $level1Payment = 1000;
        $level2Payment = 2000;
        $level3Payment = 5000;
        $level4Payment = 16000;
        $level5Payment = 56000;
        $level6Payment = 350000;

        $level = Auth::user()->level + 1;
    

        if($wallet->amount < $this->levelAmount($level))
        {
            $request->session()->flash('error', 'Insuficient funds!');
            return redirect()->back();
        }
        DB::beginTransaction();
        try{
           
            if($level == 2) {
             
                $parent = $this->getWhoToPay(Auth::id(), 2);

                $type = "Level 2 Benefits";
        
                $this->pay($parent, $level2Payment, $type);

                $type = "Level 2 Upgrade";
                
                $this->unpay(Auth::id(), $level2Payment, $type);
        
                DB::table('users')->where('id', $parent->id)->increment('two');
                
                DB::table('users')->where('id', Auth::id())->increment('level');
            
            }
            if($level == 3) {
                $parent = $this->getWhoToPay(Auth::id(), 3);

                $type = "Level 3 Benefits";
        
                $this->pay($parent, $level3Payment, $type);

                $type = "Level 3 Upgrade";
                
                $this->unpay(Auth::id(), $level3Payment, $type);
        
                DB::table('users')->where('id', $parent->id)->increment('three');
                
                DB::table('users')->where('id', Auth::id())->increment('level');
                
            }
            if($level == 4) {
                $parent = $this->getWhoToPay(Auth::id(), 4);

                $type = "Level 4 Benefits";
        
                $this->pay($parent, $level4Payment, $type);

                $type = "Level 4 Upgrade";
                
                $this->unpay(Auth::id(), $level4Payment, $type);
        
                DB::table('users')->where('id', $parent->id)->increment('four');

                DB::table('users')->where('id', Auth::id())->increment('level');
            
            }

            if($level == 5) {
                $parent = $this->getWhoToPay(Auth::id(), 5);

                $type = "Level 5 Benefits";
        
                $this->pay($parent, $level5Payment, $type);

                $type = "Level 5 Upgrade";
                
                $this->unpay(Auth::id(), $level5Payment, $type);
        
                DB::table('users')->where('id', $parent->id)->increment('five');

                DB::table('users')->where('id', Auth::id())->increment('level');
                
            }

            if($level == 6) {
                $parent = $this->getWhoToPay(Auth::id(), 6);

                $type = "Level 6 Benefits";
        
                $this->pay($parent, $level6Payment, $type);

                $type = "Level 6 Upgrade";
                
                $this->unpay(Auth::id(), $level6Payment, $type);
        
                DB::table('users')->where('id', $parent->id)->increment('six');

                DB::table('users')->where('id', Auth::id())->increment('level');
        
            }

        }catch (\Exception $e) {
            // ignore everything if there is an error
                DB::rollback();
    
                //return response()->json($e->getMessage());
                $request->session()->flash('error', $e->getMessage());
                return redirect()->back();
    
                // something went wrong
        }

        DB::commit();


        $request->session()->flash('success', 'upgrade was successful!');
        return back();
        
    }

    //count
    public function countDownlines($parent_id, $level) {
        $count = DB::table('users')
        ->select(DB::raw('users.*, users_tree.*'))
        ->where('users_tree.ancestor', '=', $parent_id)
        ->where('users_tree.depth', '=', $level)
        ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
        ->count();

        return $count;
    }
    public function unpay($id, $amount, $type) {

            $wallet = Wallet::where('user_id',  $id)->first();
            $newAmount =  $wallet->amount - $amount;
            $wallet->amount = $newAmount;
            $wallet->save();
            
            Transaction::create(['user_id' => $id,
            'amount' => $amount, 'type'=> $type, 'status' => 'successful']);
    
    }

    public function pay($parent, $levelPayment, $type ) {
        
        if($wallet = Wallet::where('user_id',  $parent->id)->first()) {
            $amount =  $wallet->amount + $levelPayment;
            $wallet->amount = $amount;
            $wallet->save();
            
            Transaction::create(['user_id' => $parent->id,
            'amount' => $levelPayment, 'type'=> $type, 'status' => 'successful']);
        }else {

        $amount =  $levelPayment;
        Wallet::create(['user_id' =>  $parent->id, 'amount' => $levelPayment]);

        Transaction::create(['user_id' => $parent->id,
            'amount' => $amount, 'type'=> $type, 'status' => 'successful']);
        }
    }
    //this function also adds users to tree
    public function activateUser(Request $request)
    {
        
        $user = DB::table('users')->where('username', $request->username)->first();

        //return response()->json($user);
        
        
        $node_id = $user->id;

        DB::beginTransaction();

        try {

         if($node_id == 1) {
            $parent_id = 0;
         }else {
            $parent = DB::table('users')->where('username', $request->by)->first();

            $parent_id =  $this->getParentId($parent->username);
         }

    
        $query = "
                INSERT INTO users_tree (ancestor,descendant,depth)
                SELECT ancestor, {$node_id}, depth+1
                FROM users_tree
                WHERE descendant = {$parent_id}
                UNION ALL SELECT {$node_id}, {$node_id}, 0";

        //connect parent to user in tree
        $tree = DB::statement($query);

         //update users parent id field
         DB::table('users')
         ->where('id', $node_id)
         ->update(['parent_id' => $parent_id]);

        DB::table('users')->where('id', $node_id)->increment('level');

        $level1Payment = 1000;
        $level2Payment = 2000;
        $level3Payment = 5000;
        $level4Payment = 16000;
        $level5Payment = 56000;
        $level6Payment = 350000;

        //increment downline count
        if($parent_id != 0) {

            DB::table('users')->where('id', $parent_id)->increment('direct_downlines');

            $realParent =  DB::table('users')->where('id', $parent_id)->first();

            $type = "Level 1 Benefits";

            $this->pay($realParent, $level1Payment, $type);

        }//end if
    
       DB::table('users')
            ->where('id', $node_id)
            ->update(['activated' => 'yes',
             'activated_by' => Auth::id(), 'activated_at' => DB::raw('now()')
            ]);
        
        } catch (\Exception $e) {
        // ignore everything if there is an error
            DB::rollback();

            //return response()->json($e->getMessage());
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back();

            // something went wrong
        }
        
        //everything is good: hit the database with changes
        DB::commit();


        $request->session()->flash('success', $user->username. ' activation was successful!');
        return back();


    }

    
}

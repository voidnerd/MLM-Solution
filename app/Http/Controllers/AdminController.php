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

    public function trainmg() {
        $trains = Train::all();
        // return response()->json($trains);
        return view('trainmg')->with(['trains' => $trains]);
    }
    public function addtrain(Request $request) {
        $train = new Train();
        $train->user_id = Auth::id();
        $train->class_key = $request->class_key != "" ? $request->class_key : "any";
        $train->title = $request->title;
        $train->description = $request->description;
        $train->venue = $request->venue;
        $train->date = $request->date;
        $train->duration = $request->duration;
        $train->frequency = $request->frequency;
        $train->time = $request->time;
        $train->max = intval($request->max) ? $request->max : "all";

        $train->save();
        $request->session()->flash('success', "Training Schedule added successfully" );
        return back();
    }
    public function edittrain(Request $request, Train $train) {
        $train->user_id = Auth::id();
        $train->class_key = $request->class_key != "" ? $request->class_key : "any";
        $train->title = $request->title;
        $train->description = $request->description;
        $train->venue = $request->venue;
        $train->date = $request->date;
        $train->duration = $request->duration;
        $train->frequency = $request->frequency;
        $train->time = $request->time;
        $train->max = intval($request->max) ? $request->max : "all";
        $train->save();
        $request->session()->flash('success', "Training Schedule edited successfully" );
        return back();
    }
    public function deletetrain(Request $request, Train $train) {
        $train->delete();
        $request->session()->flash('success', "Training Schedule deleted successfully" );
        return back();
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
       ->where('user_accounts.default', '=', '1')
        ->get();
            
        //return response()->json($users);
        return view('payment')->with(['users' => $users]);
    }
    public function transactions(){

        $trans = DB::table('transactions')
        ->select(DB::raw('transactions.*, users.name, users.class_key, users.username, users.phone')) 
        ->join('users', 'users.id', '=', 'transactions.user_id')->limit(200)
         ->get();
             
         //return response()->json($users);
         return view('transactions')->with(['trans' => $trans]);
    }
    public function paymentDone(Transaction $transaction, Request $request)
    {
        $transaction->status = 'successful';
        $transaction->paid_by = Auth::id();
        $transaction->save();

        

        $request->session()->flash('success', 'You just confirmed that you have paid ' .$request->username );
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
        
        $check = DB::table('users')->where('username', $request->username)->exists();
     
        if($check) {

        $user = DB::table('users')->where('username', $request->username)->first();
        
        
        DB::beginTransaction();

        try {
         
        //get oldest user with downlines < 3

       
        $node_id = $user->id;
        
       
        //Todo: where activation equals "yes"
        $parent = DB::table('users')->where('direct_downlines', '<', 3)
                                    ->where('activated', '=', 'yes')
                                    ->where('class_key', '=', $user->class_key)
                                    ->oldest('activated_at')->first();

         if(!$parent) {
            $parent_id = 0;
         }else {
            $parent_id =  ($parent->id != $node_id) ? $parent->id : 0;
         }
       
     
       
        //update users parent id field
            DB::table('users')
                ->where('id', $node_id)
                ->update(['parent_id' => $parent_id]);
    
        $query = "
                INSERT INTO users_tree (ancestor,descendant,depth)
                SELECT ancestor, {$node_id}, depth+1
                FROM users_tree
                WHERE descendant = {$parent_id}
                UNION ALL SELECT {$node_id}, {$node_id}, 0";
        
        //connect parent to user in tree
        $tree = DB::statement($query);
        
        if($user->class_key === "CT10") {
            $amountPaid = 10000;
        }else if($user->class_key === "CT20") {
            $amountPaid = 20000;
        }

        $refBonus =  (5 / 100) * $amountPaid;
        $level1Payment = (10 / 100) * $amountPaid;
        $level2Payment = (50 / 100) * $amountPaid;
        $level3Payment = (150 / 100) * $amountPaid;
        $level4Payment = (300 / 100) * $amountPaid;
        $level5Payment = (500 / 100) * $amountPaid;


        if($user->referred_by != null) {

            $referrer = DB::table('users')->where('username', $user->referred_by)
            ->where('activated', '=', 'yes')->first();
            //pay referrer 5%
            $type = "Referral Bonus";
            if($referrer) {
                $this->pay($referrer, $refBonus, $type);
            }
            
            
        }
        
              //increment downline count
        if($parent_id != 0) {
            DB::table('users')->where('id', $parent_id)->increment('direct_downlines');
            $parent1 =  DB::table('users')->where('id', $parent_id)->first();

            //pay First Level
            if($parent1->direct_downlines == 3) {

                $type = "Level1";
                DB::table('users')->where('id', $parent1->id)->increment('level');
                
                $this->pay($parent1, $level1Payment, $type);
              

            }

            //Pay Second Level
            if($parent1->parent_id != 0) {

                //check if eligible and pay 2nd commision
                $parent2 =  DB::table('users')->where('id', $parent1->parent_id) ->first();

                if($this->countDownlines($parent2->id, 2) ===  9) {
                    //pay the 50%

                    $type = "Level2";

                    DB::table('users')->where('id', $parent2->id)->increment('level');
                
                    $this->pay($parent2, $level2Payment, $type);
                }

                //Pay Level 3
                if($parent2->parent_id != 0) {
                    //check if eligible and pay 2nd commision
                    $parent3 =  DB::table('users')->where('id', $parent2->parent_id) ->first();
    
                    if($this->countDownlines($parent3->id, 3) ===  27) {
                        //pay the 150%

                        $type = "Level3";
                        DB::table('users')->where('id', $parent3->id)->increment('level');
                
                        $this->pay($parent3, $level3Payment, $type);
                    }

                    //Pay Level 4
                    if($parent3->parent_id != 0) {
                        //check if eligible and pay 2nd commision
                        $parent4 =  DB::table('users')->where('id', $parent3->parent_id) ->first();
        
                        if($this->countDownlines($parent4->id, 4) ===  81) {
                            //pay the 300%

                            $type = "Level4";
                            DB::table('users')->where('id', $parent4->id)->increment('level');
                
                            $this->pay($parent4, $level4Payment, $type);
                        }


                        //pay level 5
                        if($parent4->parent_id != 0) {
                            //check if eligible and pay 2nd commision
                            $parent5 =  DB::table('users')->where('id', $parent4->parent_id) ->first();
            
                            if($this->countDownlines($parent5->id, 5) ===  243) {
                                //pay the 500%

                                $type = "Level5";
                                DB::table('users')->where('id', $parent5->id)->increment('level');
                
                                $this->pay($parent5, $level5Payment, $type);
                            }
            
                        }
        
                    }
    
                }
            }
          
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

        }else {
            $request->session()->flash('error', 'Something went wrong, probably wrong username input!!!');
            return redirect()->back();
        }


    }

    
}

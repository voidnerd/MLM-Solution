<?php

namespace App\Http\Controllers;

//
use App\User;
use App\Transaction;
use App\Train;
use App\CradoAccount;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public $details;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('mail');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function mail(Request $request) {
        
        try{
  
           $d = new SendMail();
          $d->name = $request->name;
          $d->email = $request->email;
          $d->phone = $request->phone;
          $d->subject = $request->subject;
          $d->message = $request->message;
      
  
         Mail::to('info@cradoconcept.com')->send($d);
  
         $request->session()->flash('success', "Success!! We will be in touch!" );
          
          return redirect()->back();
        }catch(\Exception $e) {
  
            $request->session()->flash('error', "Failed!! Please try again!");
  
            return back();
        }
  
         
      }
  
      public function profile()
      {
          return view('profile');
      }
      public function update(User $user, Request $request)
      {
          $request->validate([
              'name' => 'string|max:255',
              'phone' => 'string|max:255',
              'address' => 'string|max:255',
              'state' => 'string|max:255',
              'country' => 'string|max:255',
          ]);
  
          $user->name = $request->name;
          $user->phone = $request->phone;
          $user->address = $request->address;
          $user->state = $request->state;
          $user->country = $request->country;
          $user->save();
  
          return back();
      }
  
  

      //this will build tree from flat array in database if project demands it
      public function buildTree($items) {
          $children = array();
          foreach($items as $item)
              $children[$item->parent_id][] = $item;
          foreach($items as $item) if (isset($children[$item->id]))
              $item->children = $children[$item->id];
          return $children;
      }
      public function index()
      {
        //   $data['upline'] = User::find(Auth::user()->parent_id);
        //   $data['allusers'] = User::all()->count();
        //   $data['pending'] = User::where('activated', 'pending')->count();
        //   $data['activated'] = User::where('activated', 'yes')->count();
        //   $data['notActivated'] = User::where('activated', 'no')->count();
        //   $data['transpaid'] = Transaction::where('type', 'payment')->count();
        //   $data['trans'] = Transaction::where('type', '!=', 'payment')->count();
        //   $data['referrals'] = User::where('referred_by', Auth::user()->username)->count();
        //   $data['accs'] = CradoAccount::all();
          //return response()->json($upline);
          
          return view('home2');
      }
  
      public function getDownlines($level) {
          $theLevel = DB::table('users')
          ->select(DB::raw('users.*, users_tree.*'))
          ->where('users_tree.ancestor', '=', Auth::id())
          ->where('users_tree.depth', '=', $level)
          ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
          ->get();
  
          return $theLevel;
      }
  
      public function matrix() {
  
          $level_one = $this->getDownlines(1);
  
          $level_two = $this->getDownlines(2);
  
          $level_three = $this->getDownlines(3);
  
          $level_four = $this->getDownlines(4);
  
          $level_five = $this->getDownlines(5);

          $level_six = $this->getDownlines(6);
  
          return view('matrix')->with([
              'ones' => $level_one,
              'twos' => $level_two,
              'threes' => $level_three,
              'fours' => $level_four,
              'fives' => $level_five,
              'sixs' => $level_six,
              ]);
      }
  
      public function userAccount()
      {
          return view('user_accounts');
      }
  
      public function cradoAccount()
      {
          return view('crado_accounts');
      }
  
      public function activationRequest(Request $request) {
  
          $user = DB::table('users')->where('id', Auth::id())->exists();
  
          if($user) {
              DB::table('users')
              ->where('id', Auth::id())
              ->update(['activated' => 'pending']);
              $request->session()->flash('success', 'We are reviewing your request!');
              return redirect()->back();
          }
          return back();
      }
}

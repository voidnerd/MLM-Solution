@extends('layouts.web')

@section('title', "Dashboard || e-earners")

@section('breadtitle', "Dashboard")

@section('breadli')
<li class="breadcrumb-item active">Dashboard</li>               
@endsection

@section('content')
@if(Auth::user()->level < 1)
     <div class="alert alert-success"> Activate your account with ₦2,000 to earn ₦3,000 ; accounts not activated is deleted in 2days. Click <b>"How To?"</b> bellow. </div>
@elseif(Auth::user()->level == 1)
<div class="alert alert-success"> Upgrade to Level 2 with ₦2,500 to earn ₦10,000. Check wallet balance to see if you have enough to upgrade!</div>
@elseif(Auth::user()->level == 2)
<div class="alert alert-success"> Upgrade to Level 3 with ₦5,000 to earn ₦40,000. Check wallet balance to see if you have enough to upgrade!</div>
@elseif(Auth::user()->level == 3)
<div class="alert alert-success"> Upgrade to Level 4 with ₦16,000 to earn ₦256,000. Check wallet balance to see if you have enough to upgrade!</div>
@elseif(Auth::user()->level == 4)
<div class="alert alert-success"> Upgrade to Level 5 with ₦56,000 to earn ₦1,792,000. Check wallet balance to see if you have enough to upgrade!</div>
@elseif(Auth::user()->level == 5)
<div class="alert alert-success"> Upgrade to Level 6 with ₦350,000 to earn ₦22,400,000. Check wallet balance to see if you have enough to upgrade!</div>
@endif
                    <div class="modal fade text-left" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
                          aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel2"><i class="la la-road2"></i> How to make payments</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <h5><i class="icon-arrow-right"></i> Step 1:<b> Make Payment</b></h5>
                                @foreach($accs as $acc)
                                  <p>Account Name: <b>{{$acc->account_name}} </b>
                                  </p>
                                  <p>Account Name: <b>{{$acc->account_no}} </b>
                                  </p>
                                  <p>Account Name: <b>{{$acc->bank_name}} </b>
                                  </p>
                                  <hr>
                                  @endforeach
                                  <h5><i class="icon-arrow-right"></i> Step 2: <b> Send Text</b></h5>
                                  <p>Send a quick text messages or whatsapp message to 08153039323 containing your:
                                  <b>" Name, username, amount and reason "</b>.
                                  
                                  </p>
                                  <p> Add <b>"Reason: Activation" </b> if payment is for account activation.</p>
                                  <p> Add <b>"Reason: Funding" </b> if payment is for funds to upgrade.[you can fund your wallet if you don't have enough wallet balance to upgrade to next level]</p>

                                  <div class="alert alert-success" role="alert">
                                    <span class="text-bold-600">Well done!</span> 
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                
                                </div>
                              </div>
                            </div>
                        </div>



                         <div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
                          aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel2"><i class="la la-road2"></i> How to make payments</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                              
                                  <h5><i class="icon-arrow-right"></i> <b  class="text-danger">Important!!</b></h5>
                                 
                                  <div class="alert alert-danger" role="alert">
                                  <i class="icon-info"></i>
                                    <span class="text-bold-600">Please make sure you have made payment before proceeding!</span> 
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                  <a type="button" href="/activationrequest" class="btn btn-outline-success" >Send Activation Request</a>
                                </div>
                              </div>
                            </div>
                        </div>



            <div class="row">
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-light">
                                <h3 class="m-b-0 text-dark">User Summary</h3></div>
                            <div class="card-body">
                                @if(Auth::user()->level < 1)
                                <a type="button" href="javascript:void(0)" class="btn btn-outline-danger"  data-toggle="modal"
                          data-target="#modal"><i class="fa fa-plus-circle"></i> Activate Your Account</a>
                                @else
                                    @if(Auth::user()->level < 6)
                                    <a href="javascript:void(0)" id="sa-params"  class="btn btn-outline-success">Upgrade to next Level</a>
                                    <!-- <a href="javascript:void(0)" class="btn btn-info mt-2 ml-2">Edit Profile</a> -->
                                    @else
                                    <div class="alert alert-success"> You did it! </div>
                                    @endif
                                @endif

                                <a href="javascript:void(0)" class="btn btn-outline-info" data-toggle="modal"
                          data-target="#iconModal">How to?</a>
                                <table class="table mt-3">
                                    
                                    <tbody>
                                        <tr >
                                            <td>Level:</td>
                                            <td class="{{Auth::user()->level == 0 ? 'text-danger' : ''}}">{{Auth::user()->level == 0 ? "Not activated" : Auth::user()->level}}</td>
                                        </tr>
                                        @if(Auth::user()->level > 0)
                                        <tr >
                                            <td>Referral Link:</td>
                                            <td><a class="text-info" href="http://e-earners.com/register?ref={{Auth::user()->username}}">http://e-earners.com/register?ref={{Auth::user()->username}}</a></td>
                                        </tr>
                                        @endif
                                        <tr >
                                            <td>Total Benefits:</td>
                                            <td class="text-success">₦{{number_format($transIn)}}</td>
                                        </tr>
                                        <tr >
                                            <td>Total on upgrades:</td>
                                            <td class="text-success">₦{{number_format($upgrade)}}</td>
                                        </tr>
                                        <tr >
                                            <td>Total Withdrawal:</td>
                                            <td class="text-danger">₦{{number_format($transOut)}}</td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-light">
                                <h3 class="m-b-0 text-dark">Sponsor Details</h3></div>
                            <div class="card-body">
                             
                                <table class="table mt-3">
                                    
                                    <tbody>
                                        <tr >
                                            <td>Name:</td>
                                            <td>{{ !$upline ? "Nil": $upline->name }}</td>
                                        </tr>
                                        <tr >
                                            <td>Username:</td>
                                            <td>{{ !$upline ? "Nil": $upline->username }}</td>
                                        </tr>
                                        <tr >
                                            <td>Email:</td>
                                            <td>{{ !$upline ? "Nil": $upline->email }}</td>
                                        </tr>
                                        <tr >
                                        <td>Phone:</td>
                                            <td>{{ !$upline ? "Nil": $upline->phone }}</td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-sm-6">
                    <div class="card border-success mt-2">
                            <div class="card-header bg-info">
                                <h3 class="m-b-0 text-white">How it works</h3></div>
                            <div class="card-body">

                            <h5> <b>HERE IS A STRATEGY THAT WILL ENABLE YOU TO REACH YOUR GOALS</b></h5>
                            <div class="table-responsive">
                  <table class="table table-striped">
                 
                    <tbody>
                      <tr>
                        <td scope="row">LEVEL 1: (Activation). Pay ₦2000</td>
                      </tr>
                      <tr>
                        <td scope="row">Get 2 (downlines) x ₦1,500 = ₦3,000 – ₦2,500 (move to 2) = ₦500 profit</td>
                      
                      </tr>
                      <tr>
                        <td scope="row">LEVEL 2: (Upgrade). Pay ₦2,500</td>
                        
                      </tr>
                      <tr>
                        <td scope="row"> 4 ( level 2 downlines) x ₦2,500 = ₦10,000 – ₦5,000 (move to 3) = ₦5,000 profit</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">LEVEL 3: (Upgrade). Pay ₦5,000</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">8 (level 3 downlines) x ₦5,000 = ₦40,000 – ₦16,000 (move to 4) = ₦24,000 profit</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">LEVEL 4: (Upgrade). Pay ₦16,000</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">16 (level 4 downlines) x ₦16,000 = ₦256,000 – ₦56,000 (move to 5) = ₦200,000 profit</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">LEVEL 5: (Upgrade). Pay ₦56,000</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">32 ( level 5 downlines) x ₦56,000 = ₦1,792,000 – ₦350,000 (move to 5) = ₦1,442,000 profit</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">LEVEL 6: (Upgrade). Pay ₦350,000</td>
                        
                      </tr>
                      <tr>
                        <td scope="row">64 (level 6 downlines) x ₦56,000 = ₦22,400,000 (all yours)
                           <p> <em>No More upgrades</em></p>
                        </td>
                        
                      </tr>
                    </tbody>
                  </table>
                </div>
                            </div>
                        </div>  
                    
                    </div>
                </div> 
                
                  


                <!-- modal -->
                <div id="daModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Upgrade to level 2</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/activate-user">
                                            <div class="modal-body">
                                                <div class="alert alert-danger">
                                                    <p>N2000 will be used to upgrade to level 2</p>

                                                </div>
                                                @csrf

                                                 <input type="radio" name="upgrade" value="balance" checked>Use Balance
                                                    <br>
                                                <input type="radio" name="upgrade" value="paystack"> Use Paystack
                                                   
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Activate User</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
@endsection
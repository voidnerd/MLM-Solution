@extends('layouts.web')
@section('title', "Payment || e-earners")

@section('breadtitle', "Withdrawal Request")

@section('breadli')
<li class="breadcrumb-item active">Withdrawal</li>               
@endsection

@section('content')
                    <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Withdrawal Request</h4>
                                <h6 class="card-subtitle">Pay every 24hrs</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                               
                                                <th>Phone</th>
                                                <th>Level</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>₦{{ !$user ? 0 : number_format($user->amount) }}</td>
                                               
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->level}}</td>
                                                <td>₦{{ !$user ? 0 : number_format($user->balance) }}</td>
                                                <td>
                                                <button  data-toggle="modal" data-target="#daModal{{$user->id}}" class="btn btn-success btn-sm"><i class="fa fa-lg fa-eye"></i></button>
                                                </td>
                                            </tr>

                                            <!-- modal -->
                                <div id="daModal{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Activate user</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/payment/{{$user->trans_id}}">
                                            <div class="modal-body">
                                                
                                                        @csrf

                                                                <h5>Bank name:&nbsp;  {{$user->bank_name}}</h5>
                                                                <h5>Account name: &nbsp; {{$user->account_name}}</h5>
                                                                <h5>Account no:&nbsp; <b> {{$user->account_no}}</b></h5>
                                                                <h5>Username:&nbsp;  {{$user->username}}</h5>
                                                                <h5>Amount:&nbsp;   {{$user->amount}}</h5>
                                            
                                                    
                                                    <div class="form-group">
                                                       
                                                        <input type="text" class="form-control" name="username" value="{{$user->username}}" hidden>
                                                    </div>
                                                                                            

                                                 <span class="text-danger">Ensure user has been paid before payment confirmation!! </span>  
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Confirm payment has been made!</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
   
@endsection
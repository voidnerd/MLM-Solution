@extends('layouts.web')

@section('title', "Wallet|| e-earners")

@section('breadtitle', "Wallet")

@section('breadli')
<li class="breadcrumb-item active">Wallet</li>               
@endsection

@section('content')

        <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                           
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="text-success">₦{{ !$wallet ? 0 : number_format($wallet->amount) }}</h3>
                                        <h6 class="card-subtitle">Balance</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                            <h6 class="card-subtitle">Minimum Withdrawal: ₦1000</h6>
                                <div class="row">
                                    <div class="col-12">
                                    <form method="post" action="/send-payment-request">
                                    @csrf
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light">₦</span>
                                            </div>
                                            <input type="text" class="form-control" name="amount" placeholder="Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-outline-danger"> Withdraw</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            @if(!$account)
                            <a href="javascript:void(0)"  data-toggle="modal" data-target="#daModal" class="btn btn-outline-success float-right mb-2">Add Account</a>
                            @else
                            <a href="javascript:void(0)"  data-toggle="modal" data-target="#daModal1" class="btn btn-outline-info float-right mb-2">Edit Account</a>
                            @endif
                            <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-dark">Acount Name:</h6>
                                        <h6 class="text-info">{{ $account ? $account->account_name : "Nil"}}</h6>
                                        <h6 class="text-dark">Account Number:</h6>
                                        <h5 class="text-info">{{$account ? $account->account_no : "Nil"}}</h5>
                                        <h6 class="text-dark">Bank Name:</h6>
                                        <h6 class="text-info">{{$account ? $account->bank_name : "Nil"}}</h6>

                                        </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


        </div>

        @if(Auth::user()->role == 'admin')
    <div class="row" >
    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                            <h6 class="card-subtitle">Fund Other Users Wallet</h6>
                                <div class="row">
                                    <div class="col-12">
                                    <form method="post" action="/fund">
                                    @csrf
                                    <div class="input-group mb-3">
                                            <div class="form-group">
    
                                                    <input id="fuser" type="text" class="form-control" name="username" placeholder="Username">
                                                    <p class="text-info" id="fdetails"> </p>
                                                   
                                            </div>

                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light">₦</span>
                                            </div>
                                            <input type="text" class="form-control" name="amount" placeholder="Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-outline-success"> Fund</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

    </div>
        <script>

     
        var element = document.getElementById("fuser");
        var details = document.getElementById("fdetails");
        var url = '/checker?username=' + element.value;
        element.addEventListener("blur", function() { 
            console.log("oaky");
            var url = '/checker?username=' + element.value;
            var xhr = new XMLHttpRequest();
            console.log(url)
            // xhr.open('GET', url);
            xhr.onload = function () {

            // Process our return data
            if (xhr.status != 200) {
                // What do when the request is successful
                
                details.innerHTML = "Not Found";

            } else if(xhr.status == 200){
                
                console.log(xhr);
                var res = JSON.parse(xhr.response);
                details.innerHTML = res.name + ", <span> " + res.email + "</span>";
            }
        
            };

            xhr.open('GET', '/checker?username=' + element.value);
            xhr.send();


        });
       


        </script>
        @endif
        <!-- modal to edit accounts -->
        <div id="daModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Bank Details</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/user-accounts/{{$account ? $account->id : ''}}">
                                            <div class="modal-body">
                                                
                                                        @csrf
                                                  
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Name:</label>
                                                        <input type="text" class="form-control" name="account_name" value="{{$account ? $account->account_name : ''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Number:</label>
                                                        <input type="text" class="form-control" name="account_no" value="{{$account ? $account->account_no : ''}}">
                                                    </div>

                                                      <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Bank Name:</label>
                                                        <input type="text" class="form-control" name="bank_name" value="{{$account ? $account->bank_name :''}}">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

        <!-- modal to add account -->
        <div id="daModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Bank Details</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/user-accounts">
                                            <div class="modal-body">
                                                
                                                        @csrf
                                                   
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Name:</label>
                                                        <input type="text" class="form-control" name="account_name"id="recipient-name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Number:</label>
                                                        <input type="text" class="form-control" name="account_no"id="recipient-name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Bank Name:</label>
                                                        <input type="text" class="form-control" name="bank_name">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

          <div class="card mt-5">
                            <div class="card-body">
                                <h4 class="card-title">Transactions</h4>
                                <!-- <h6 class="card-subtitle">Users under probation</h6> -->
                                <div class="table-responsive ">
                                    <table id="myTabl" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($trans as $tran)
                                            <tr>
                                                <td>{{$tran->type}}</td>
                                                <td>{{$tran->amount}}</td>
                                                <td>{{$tran->status}}</td>
                                                <td>{{$tran->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       

@endsection
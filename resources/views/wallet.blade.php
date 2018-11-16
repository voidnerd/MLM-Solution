@extends('layouts.web')

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

                    <div class="col-lg-6 col-md-6">
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
                                            <input type="text" class="form-control" placeholder="Amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary"> Withdraw</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


        </div>

          <div class="card mt-5">
                            <div class="card-body">
                                <h4 class="card-title">Transactions</h4>
                                <!-- <h6 class="card-subtitle">Users under probation</h6> -->
                                <div class="table-responsive ">
                                    <table id="myTable" class="table table-bordered table-striped">
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
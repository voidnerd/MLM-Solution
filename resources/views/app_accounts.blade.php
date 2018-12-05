@extends('layouts.web')

@section('title', "App accounts || e-earners")

@section('breadtitle', "Company Accounts")

@section('breadli')
<li class="breadcrumb-item active">app_accounts</li>               
@endsection

@section('content')
<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Company Accounts</h4>
                                <button data-toggle="modal" data-target="#create" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i> Add New</button>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Account Name</th>
                                                <th>Account No</th>
                                                <th>Bank Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($accounts as $account)
                                            <tr>
                                                <td>{{$account->account_name}}</td>
                                                <td>{{$account->account_no}}</td>
                                                <td>{{$account->bank_name}}</td>
                                                <td>
                                                <button  data-toggle="modal" data-target="#daModal{{$account->id}}" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></button>
                                                <a  data-toggle="modal" data-target="#delete{{$account->id}}" class="btn btn-outline-danger text-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>

                                            <!-- modal -->
                    <div id="daModal{{$account->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Account</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/app-accounts/{{$account->id}}">
                                            <div class="modal-body">
                                                
                                                        @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Name:</label>
                                                        <input type="text" class="form-control" name="account_name" value="{{$account->account_name}}" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Number</label>
                                                        <input type="text" class="form-control" name="account_no" id="recipient-name" value="{{$account->account_no}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Bank Name</label>
                                                        <input type="text" class="form-control" name="bank_name" id="recipient-name" value="{{$account->bank_name}}">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                 <div id="delete{{$account->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Account</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="get" action="/app-accounts/{{$account->id}}">
                                            <div class="modal-body">
                                                
                                                        @csrf

                                                    <div class="alert alert-danger" role="alert">
                                                        Are you sure you want to delete {{$account->account_no}}?
                                                    </div>
                                                 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                                             
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
                       
                        <div id="create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add New Account</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/app-accounts">
                                            <div class="modal-body">
                                                
                                                        @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Name:</label>
                                                        <input type="text" class="form-control" name="account_name" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Number</label>
                                                        <input type="text" class="form-control" name="account_no" id="recipient-name" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Bank Name</label>
                                                        <input type="text" class="form-control" name="bank_name" id="recipient-name" >
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
   
@endsection
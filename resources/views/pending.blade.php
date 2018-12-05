@extends('layouts.web')

@section('title', "Pending || e-earners")

@section('breadtitle', "Pending Activation")

@section('breadli')
<li class="breadcrumb-item active">pending</li>               
@endsection

@section('content')
                 <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Pending Users</h4>
                                <h6 class="card-subtitle">Total Users: {{$allusers}} </h6>
                                <h6 class="card-subtitle">Activated:  {{$activated}} </h6>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Joined</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->created_at}}</td>
                                                <td>
                                                <button  data-toggle="modal" data-target="#daModal{{$user->id}}" class="btn btn-warning btn-sm">Activate</button>
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
                                            <form method="post" action="/activate-user">
                                            <div class="modal-body">
                                                
                                                        @csrf
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Username:</label>
                                                        <input type="text" class="form-control" name="username" value="{{$user->username}}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Referrer</label>
                                                        <input type="text" class="form-control" name="by"id="recipient-name" value="{{$user->referrer}}" readonly>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Activate User</button>
                                             
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
@extends('layouts.web')

@section('title', "referrals not activated || e-earners")

@section('breadtitle', "Pending Activation")

@section('breadli')
<li class="breadcrumb-item active">not activated</li>               
@endsection

@section('content')
<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Your referrals yet to activate</h4>
                              
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                             
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->username}}</td>
                                              
                                                <td>{{date("m/d/y g:i A", strtotime($user->created_at))}}</td>
                                            </tr>

                          
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
@endsection
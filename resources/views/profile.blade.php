@extends('layouts.web')

@section('title', "Profile || e-earners")

@section('breadtitle', "Profile")

@section('breadli')
<li class="breadcrumb-item active">profile</li>               
@endsection

@section('content')
<div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="../assets/images/users/default.png" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{Auth::user()->name}}</h4>
                                    <h6 class="card-subtitle">{{Auth::user()->username}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><font class="font-medium">Level</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"></i> <font class="font-medium">{{Auth::user()->level}}</font></a></div>
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6>{{Auth::user()->email}}</h6> <small class="text-muted p-t-30 db">Phone</small>
                                <h6>{{Auth::user()->phone}}</h6> <small class="text-muted p-t-30 db">Address</small>
                                <h6>{{Auth::user()->address ? Auth::user()->address : "Nil" }}</h6>
                                <small class="text-muted p-t-30 db">State</small>
                                <h6>{{Auth::user()->state ? Auth::user()->state : "Nil" }}</h6>
                                <small class="text-muted p-t-30 db">Country</small>
                                <h6>{{Auth::user()->country ? Auth::user()->country : "Nil" }}</h6>
                                 <small class="text-muted p-t-30 db">Social Profile</small>
                                <br/>
                                <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Edit Profile</a> </li>
                                
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                
                                <!--second tab-->
                              
                                <div class="tab-pane active" id="settings" role="tabpanel">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material" method="post" action="/profile/{{Auth::id()}}">
                                        @csrf
                                            <div class="form-group">
                                                <label class="col-md-12">Full Name</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="name" value="{{Auth::user()->name}}" placeholder="Johnathan Doe" class="form-control form-control-line">
                                                </div>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label class="col-md-12">Phone No</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="{{Auth::user()->phone}}" name="phone" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Address</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="{{Auth::user()->address}}" name="address" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">State</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="{{Auth::user()->state}}" name="state" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Country</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="{{Auth::user()->country}}" name="country" class="form-control form-control-line">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>            


@endsection
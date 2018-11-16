@extends('layouts.web')

@section('breadtitle', "Dashboard")

@section('breadli')
<li class="breadcrumb-item active">Dashboard</li>               
@endsection

@section('content')
            <div class="row">
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-light">
                                <h3 class="m-b-0 text-dark">User Summary</h3></div>
                            <div class="card-body">
                                
                                <a href="javascript:void(0)" id="sa-params"  class="btn btn-success">Upgrade to next Level</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-info mt-2 ml-2">Edit Profile</a> -->
                                <table class="table mt-3">
                                    
                                    <tbody>
                                        <tr class="table-primary">
                                            <td>Level:</td>
                                            <td>1</td>
                                        </tr>
                                        <tr class="table-success">
                                            <td>Total Benefits:</td>
                                            <td>$10000</td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Withdrawal:</td>
                                            <td>$3000</td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
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
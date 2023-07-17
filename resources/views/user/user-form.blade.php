@extends('layouts.sidebar')
<?php
$title = "User Form";
?>
@section('content')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                                            
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-solid" role="alert">
                                                <span class="fw-medium">Create User Account Successfully </span>
                                            </div>
                                        @endif
                                        <h4 class="card-title">Create User Account</h4>
                                        <br>
                                        <form method="POST" action="{{ route('admin.create-user') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" class="form-control" type="text" placeholder="Name">
                                            </div>
                                        </div>                                          
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input name="email" id="email" class="form-control" type="email" placeholder="Email">
                                            </div>
                                        </div>                                        
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input name="address" id="address" class="form-control" type="text" placeholder="Address">
                                            </div>
                                        </div>     
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Birth Date</label>
                                            <div class="col-sm-10">
                                                <input name="birth_date" id="birth_date" class="form-control" type="date" placeholder="Birth Date">
                                            </div>
                                        </div>     
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input name="phone_number" id="phone_number" class="form-control" type="number" placeholder="Phone Number">
                                            </div>
                                        </div>     
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Job</label>
                                            <div class="col-sm-10">
                                                <input name="job" id="job" class="form-control" type="text" placeholder="Job">
                                            </div>
                                        </div>     
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Mandatory Savings</label>
                                            <div class="col-sm-10">
                                                <input name="mandatory_savings" id="mandatory_savings" class="form-control" type="text" placeholder="Mandatory Savings">
                                            </div>
                                        </div>                                             
                                        <!-- end row -->                                        
                                                                        
                                        <!-- end row -->
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary w-lg">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        
                <!-- End Page-content -->
                            
                
            </div>
            <!-- end main content-->

        
@endsection
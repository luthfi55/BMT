@extends('layouts.sidebar')
<?php
$title = "Admin Form";
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
                                                <span class="fw-medium">Create Admin Account Successfully </span>
                                            </div>
                                        @endif
                                        <h4 class="card-title">Create Admin Account</h4>
                                        <br>
                                        <form method="POST" action="{{ route('admin.create-admin') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input name="name" id="name" class="form-control" type="text" placeholder="Name" required>
                                            </div>
                                        </div>      
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input name="username" id="username" class="form-control" type="text" placeholder="Username" required>
                                            </div>
                                        </div>                                        
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input name="email" id="email" class="form-control" type="email" placeholder="Email" required>
                                            </div>
                                        </div>                                        
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input name="password" id="password" class="form-control" type="password" placeholder="Password" required>
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
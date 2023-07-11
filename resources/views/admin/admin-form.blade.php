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

                                        <h4 class="card-title">Create Admin Account</h4>
                                        <br>
                                        <form method="POST" action="">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input id="name" class="form-control" type="text" placeholder="Name">
                                            </div>
                                        </div>                                        
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input id="email" class="form-control" type="email" placeholder="Email">
                                            </div>
                                        </div>                                        
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input id="password" class="form-control" type="password" placeholder="Password">
                                            </div>
                                        </div>      
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input id="password-confirm" class="form-control" type="password" placeholder="Password">
                                            </div>
                                        </div>                                                                                
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
                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Tocly.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                
            </div>
            <!-- end main content-->

        
@endsection
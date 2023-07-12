@extends('layouts.sidebar')
<?php
$title = "Loan Fund Form";
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
                                        <form method="POST" action="{{ route('admin.create-loanfund') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="nominal" class="col-sm-2 col-form-label">User Id</label>
                                            <div class="col-sm-10">
                                                <input name="user_id" id="user_id" class="form-control" type="number" placeholder="User Id" required>
                                            </div>
                                        </div>                                      
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                            <div class="col-sm-10">
                                                <input name="nominal" id="nominal" class="form-control" type="number" placeholder="Nominal" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="infaq" class="col-sm-2 col-form-label">Infaq</label>
                                            <div class="col-sm-10">
                                                <input name="infaq" id="infaq" class="form-control" type="number" placeholder="Infaq" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="infaq_type" class="col-sm-2 col-form-label">Infaq Type</label>
                                            <div class="col-sm-10">
                                                <input name="infaq_type" id="infaq_type" class="form-control" type="text" placeholder="Infaq Type" required>
                                            </div>
                                        </div>                                    

                                        <div class="row mb-3">
                                            <label for="installment" class="col-sm-2 col-form-label">Installment</label>
                                            <div class="col-sm-10">
                                                <input name="installment" id="installment" class="form-control" type="number" placeholder="Installment" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="installment_amount" class="col-sm-2 col-form-label">Installment Amount</label>
                                            <div class="col-sm-10">
                                                <input name="installment_amount" id="installment_amount" class="form-control" type="number" placeholder="Installment Amount" required>
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
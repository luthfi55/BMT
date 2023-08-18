@extends('layouts.sidebar')
<?php
$title = "Balance Form";
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
                            <h4 class="card-title">Balance : Rp.{{ number_format($balance->nominal, 2, ',', '.') }}</h4>                                                        
                        </div>
                    </div>
                </div> 
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Add Balance History Successfully </span>
                            </div>
                            @endif

                            <h4 class="card-title">Add Balance (+)</h4>                            
                            <br>
                            <form method="POST" action="{{ route('admin.add-balance') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                    <div class="col-sm-10">
                                        <input name="nominal" id="nominal" class="form-control" type="number"
                                            placeholder="Nominal" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="infaq" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <input name="description" id="description" class="form-control" type="text"
                                            placeholder="Description" required>
                                    </div>
                                </div>

                                <!-- end row -->

                                <!-- end row -->
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary waves-effect waves-light w-lg"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Submit</button>
                                </div>
                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Make sure to verify whether the entered data is correct or not beforehand.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->           
            


            <!-- End Page-content -->
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">                            
                            <h4 class="card-title">Subtract Balance (-)</h4>
                            <br>
                            
                            <form method="POST" action="{{ route('admin.subtract-balance') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                    <div class="col-sm-10">
                                        <input name="nominal" id="nominal" class="form-control" type="number"
                                            placeholder="Nominal" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="infaq" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <input name="description" id="description" class="form-control" type="text"
                                            placeholder="Description" required>
                                    </div>
                                </div>

                                <!-- end row -->

                                <!-- end row -->
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary waves-effect waves-light w-lg"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Submit</button>
                                </div>
                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Make sure to verify whether the entered data is correct or not beforehand.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
        </div>
        
        <!-- end main content-->


        @endsection

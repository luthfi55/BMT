@extends('layouts.sidebar')
<?php
$title = "Loan Fund Edit";
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
                                <span class="fw-medium">{{ session('success') }}</span>
                            </div>
                            @endif
                            <h4 class="card-title">Edit Loan Fund Information</h4>
                            <br>
                            <form method="POST" action="{{ route('admin.loanfund-update', $loanFunds->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="status" id="status" required>
                                            <option value="0" {{ $loanFunds->status == 0 ? 'selected' : '' }}>
                                                Loan Active</option>
                                            <option value="1" {{ $loanFunds->status == 1 ? 'selected' : '' }}>
                                                Loan Not Active</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example"
                                                name="status" required>
                                                <option value="0" {{ $loanFunds->status == 0 ? 'selected' : '' }}>
                                                    Loan Active</option>
                                                <option value="1" {{ $loanFunds->status == 1 ? 'selected' : '' }}>
                                                    Loan Not Active</option>
                                            </select>
                                        </div>
                                    </div>


                                    <!-- other input fields -->
                                    <!-- end row -->

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-lg">Update</button>
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

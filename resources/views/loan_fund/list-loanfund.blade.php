@extends('layouts.sidebar')
<?php
$title = "Loan Fund List";
?>
@section('content')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Create User Account Successfully </span>
                            </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                        <div class="search-box me-2">
                                            <form method="GET" action="{{ route('admin.list-user') }}" class="d-flex">
                                                <div class="position-relative me-2">
                                                    <input type="text" class="form-control border" id="search"
                                                        name="search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetSearch()">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 float-end">
                                        <a href="{{ route('admin.loanfund-form') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus me-1"></i> Create Loan Fund
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Nominal</th>
                                            <th scope="col">Infaq</th>
                                            <th scope="col">Infaq Type</th>
                                            <th scope="col">Infaq Status</th>
                                            <th scope="col">Installment</th>                                            
                                            <th scope="col">Month</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="width: 200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loanFunds as $loanFund)
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">{{ $loanFund->user->name }}</a>
                                            </td>
                                            <td>Rp.{{ number_format($loanFund->nominal, 2, ',', '.') }}</td>
                                            <td>{{ $loanFund->infaq }}%</td>
                                            <td>{{ ucwords($loanFund->infaq_type) }}</td>
                                            <td>
                                                @if ($loanFund->infaq_status == 0)
                                                <span style="color: red;">Overdue</span>
                                                @elseif ($loanFund->infaq_status == 1)
                                                <span style="color: green;">Completed</span>
                                                @endif                                                                  
                                            <td>{{ $loanFund->installment }}</td>                                            
                                            <td>{{ $loanFund->month }}</td>
                                            <td>
                                                @if ($loanFund->status == 0)
                                                Loan Active
                                                @elseif ($loanFund->status == 1)
                                                Loan Not Active
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Edit and Delete buttons -->
                                                <a href="{{ route('admin.detail-loanfund', $loanFund->id) }}" class="text-body">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())

                    </script> © Tocly.
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

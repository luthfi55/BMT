@extends('layouts.sidebar')
<?php
$title = "Operational List";
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
                                <span class="fw-medium">Create Operational Successfully </span>
                            </div>
                            @endif
                            @if(session('updateSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Update Operational Successfully </span>
                            </div>
                            @endif
                            @if(session('deleteSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Delete Operational Successfully </span>
                            </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                        <div class="search-box me-2">
                                            <form method="GET" action="{{ route('admin.list-operational') }}"
                                                class="d-flex">
                                                <div class="position-relative me-2">
                                                    <input type="text" class="form-control border" id="search"
                                                        name="search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetSearchListOperational()">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 float-end">
                                        <a href="{{ route('admin.operational-form') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus me-1"></i> Create Operational
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Goods</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Nominal</th>
                                            <th scope="col">Date</th>                                            
                                            <th scope="col" style="width: 200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($operationals as $operational)
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">{{ $operational->id }}</a>
                                            </td>

                                            <td>                                                
                                                {{$operational->goods}}                                                
                                            </td>

                                            <td> {{$operational->description}} </td>

                                            <td>Rp.{{ number_format($operational->nominal, 2, ',', '.') }}</td>                                            

                                            <td>{{ ($operational->date) }}</td>

                                            <td>
                                                <!-- Edit and Delete buttons -->
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <div class="d-flex">
                                                            <a href="{{ route('admin.detail-operational', $operational->id) }}" class="px-2 text-primary">
                                                                <i class=" ri-file-info-fill font-size-18"></i>
                                                            </a>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                            </div>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">Showing {{ $operationals->firstItem() }} to {{ $operationals->lastItem() }} of {{ $operationals->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $operationals->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

</div>
<!-- end main content-->

@endsection

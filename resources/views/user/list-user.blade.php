@extends('layouts.sidebar')
<?php
$title = "User List";
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
                                                <input type="text" class="form-control border" id="search" name="search" placeholder="Search...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">Search</button>
                                            <button type="button" class="btn btn-secondary" onclick="resetSearch()">Reset</button>
                                        </form>                                                                               
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 float-end">
                                    <a href="{{ route('admin.user-form') }}" class="btn btn-primary">
                                        <i class="mdi mdi-plus me-1"></i> Add User
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-nowrap align-middle mb-0">
                                <thead class="bg-light">
                                  <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Birth Date</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Job</th>
                                    <th scope="col">Mandatory Savings</th>
                                    <th scope="col">Pin</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)                                    
                                    <tr>
                                        <!-- User data -->
                                        <td>                                            
                                            <a href="#" class="text-body">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->birth_date }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->job }}</td>
                                        <td>{{ $user->mandatory_savings }}</td>
                                        <td>{{ $user->pin }}</td>
                                        <td>
                                            <!-- Edit and Delete buttons -->
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.edit-user', $user->id) }}" class="px-2 text-primary">
                                                            <i class="ri-pencil-line font-size-18"></i>
                                                        </a>
                                                        <form action="{{ route('admin.user-destroy', $user->id) }}" method="POST" class="px-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn text-danger p-0" onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="ri-delete-bin-line font-size-18"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                                
                                                <li class="list-inline-item dropdown">
                                                    <a class="dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                        <i class="ri-more-2-fill"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </li>
                                            </ul>
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
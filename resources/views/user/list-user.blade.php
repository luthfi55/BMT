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
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Create User Account Successfully </span>
                            </div>
                        @elseif(session('updateSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Update Account Successfully </span>
                            </div>            
                        @elseif(session('deleteSuccess'))                        
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Delete Account Successfully </span>
                            </div>    
                        @elseif(session('deleteFailed'))                        
                            <div class="alert alert-danger alert-solid" role="alert">
                                <span class="fw-medium">Delete Account Faied </span>
                            </div>                        
                        @endif    
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
                                        <td>{{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}</td>                                        
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->job }}</td>
                                        <td>Rp.{{ number_format($user->mandatory_savings, 2, ',', '.') }}</td>
                                        <td>{{ $user->pin }}</td>
                                        <td>
                                            
                                            <!-- Edit and Delete buttons -->
                                            <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.detail-user', $user->id) }}"
                                                        class="px-2 text-primary">
                                                        <i class=" ri-file-info-fill font-size-18"></i>
                                                    </a>
                                                    <a href="{{ route('admin.edit-user', $user->id) }}" class="px-2 text-primary">
                                                        <i class="ri-pencil-line font-size-18"></i>
                                                    </a>
                                                    <form action="{{ route('admin.user-destroy', $user->id) }}" method="POST" class="px-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn text-danger p-0" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                                            <i class="ri-delete-bin-line font-size-18"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>

                                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $user->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModal{{ $user->id }}Label">Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this user?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.user-destroy', $user->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $users->links('pagination::bootstrap-4') }}
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
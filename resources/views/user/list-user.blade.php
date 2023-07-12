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
                                        <div class="position-relative">
                                            <input type="text" class="form-control border" placeholder="Search...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
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
                                    <th scope="col">Mandatory Savings</th>
                                    <th scope="col">Pin</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)                                    
                                    <tr>
                                        <td>                                            
                                            <a href="users-list.html#" class="text-body">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->birth_date }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->mandatory_savings }}</td>
                                        <td>{{ $user->pin }}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="px-2 text-primary"><i class="ri-pencil-line font-size-18"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="px-2 text-danger"><i class="ri-delete-bin-line font-size-18"></i></a>
                                                </li>
                                                <li class="list-inline-item dropdown">
                                                    <a class="dropdown-toggle font-size-18 px-2" href="users-list.html#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                        <i class="ri-more-2-fill"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="users-list.html#">Action</a>
                                                        <a class="dropdown-item" href="users-list.html#">Another action</a>
                                                        <a class="dropdown-item" href="users-list.html#">Something else here</a>
                                                    </div>
                                                </li>
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
                                    <p class="mb-sm-0">Showing 1 to 10 of 12 entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        <li class="page-item disabled">
                                            <a href="users-list.html#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="users-list.html#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="users-list.html#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="users-list.html#" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="users-list.html#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                        </li>
                                    </ul>
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

 <!-- Modal -->
 <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- end modalheader -->
            <div class="modal-body p-4">
                <div>
                    <div class="mb-3">
                        <label for="addcontact-name-input" class="form-label">Name</label>
                        <input type="text" class="form-control" id="addcontact-name-input" placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="addcontact-designation-input" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="addcontact-designation-input" placeholder="Enter Designation">
                    </div>
                    <div class="mb-3">
                        <label for="addcontact-file-input" class="form-label">User Image</label>
                        <input type="file" class="form-control" id="addcontact-file-input">
                    </div>

                    <div class="mb-3">
                        <label for="addcontact-email-input" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addcontact-email-input" placeholder="Enter Email">
                    </div>
                </div>
            </div>
            <!-- end modalbody -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light w-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary w-sm">Add</button>
            </div>
            <!-- end modalfooter -->
        </div><!-- end content -->
    </div>
</div>
<!-- end modal -->

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
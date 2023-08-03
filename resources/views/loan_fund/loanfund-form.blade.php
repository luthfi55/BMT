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
                            <h4 class="card-title">Search Email</h4>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                        <div class="search-box me-2">
                                            <form method="GET" action="{{ route('admin.loanfund-form') }}"
                                                class="d-flex">
                                                <div class="position-relative me-2">
                                                    <input type="text" class="form-control border" id="search"
                                                        name="search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetSearchLoanFund()">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if (request()->has('search'))
                                @if ($users->count() > 0)
                                                            
                            
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
                                                <td class="clickable" data-email="{{ $user->email }}">{{ $user->email }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>{{ $user->birth_date }}</td>
                                                <td>{{ $user->phone_number }}</td>
                                                <td>{{ $user->job }}</td>
                                                <td>Rp.{{ number_format($user->mandatory_savings, 2, ',', '.') }}</td>
                                                <td>
                                                    <!-- Edit and Delete buttons -->
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <div class="d-flex">
                                                                <a href="{{ route('admin.edit-user', $user->id) }}"
                                                                    class="px-2 text-primary">
                                                                    <i class="ri-pencil-line font-size-18"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('admin.user-destroy', $user->id) }}"
                                                                    method="POST" class="px-2">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn text-danger p-0"
                                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                                        <i class="ri-delete-bin-line font-size-18"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </li>

                                                        <li class="list-inline-item dropdown">
                                                            <a class="dropdown-toggle font-size-18 px-2" href="#"
                                                                role="button" data-bs-toggle="dropdown"
                                                                aria-haspopup="true">
                                                                <i class="ri-more-2-fill"></i>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="#">Action</a>
                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                <a class="dropdown-item" href="#">Something else
                                                                    here</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                @else
                                <div class="alert alert-info" role="alert">
                                    No users found.
                                </div>
                                @endif
                                @else
                                @endif
                                @if(session('success'))
                                <div class="alert alert-success alert-solid" role="alert">
                                    <span class="fw-medium">Create Loan Fund Successfully </span>
                                </div>
                                @elseif(session('userNotFound'))
                                <div class="alert alert-danger alert-solid" role="alert">
                                    <span class="fw-medium">Create Loan Fund Failed, Email not found </span>
                                </div>
                                @elseif(session('failed-balance'))
                                <div class="alert alert-danger alert-solid" role="alert">
                                    <span class="fw-medium">Balance Isn't enough</span>
                                </div>
                                @endif

                                <h4 class="card-title">Create Loan Fund</h4>
                                <br>
                                <br>
                                <form method="POST" action="{{ route('admin.create-loanfund') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input name="email" id="email" class="form-control" type="email"
                                                placeholder="Email" required>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="row mb-3">
                                        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                                        <div class="col-sm-10">
                                            <input name="nominal" id="nominal" class="form-control" type="number"
                                                placeholder="Nominal" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="infaq" class="col-sm-2 col-form-label">Infaq (%)</label>
                                        <div class="col-sm-10">
                                            <input name="infaq" id="infaq" class="form-control" type="number"
                                                placeholder="Infaq" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Infaq Type</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="infaq_type" id="infaq_type" aria-label="Default select example" required>
                                                    <option selected disabled>Open this select menu</option>
                                                    <option value="first">First</option>
                                                    <option value="installment">Installment</option>
                                                    <option value="last">Last</option>
                                                    </select>                                                    
                                            </div>                                            
                                            @error('infaq_type')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror                                            
                                        </div>                                        
                                    <div class="row mb-3">
                                        <label for="installment" class="col-sm-2 col-form-label">Installment</label>
                                        <div class="col-sm-10">
                                            <input name="installment" id="installment" class="form-control"
                                                type="number" placeholder="Installment" required>
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

            </div>
            <!-- end main content-->
            <!-- JavaScript Code -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const emailFields = document.querySelectorAll(".clickable");
                    const emailInput = document.getElementById("email");

                    emailFields.forEach((emailField) => {
                        emailField.addEventListener("click", function () {
                            const email = this.dataset.email;
                            emailInput.value = email;
                        });
                    });
                });
            </script>

            <style>
                /* Add this CSS style to change the cursor when hovering over the clickable elements */
                .clickable {
                    cursor: pointer;
                }
            </style>


            @endsection

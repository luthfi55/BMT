@extends('layouts.sidebar')
<?php
$title = "Loan Fund History";
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
                            @if(session('updateSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Update Loan Fund History Status Successfully </span>
                            </div>
                            @endif
                            @if(session('deleteSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Delete Loan Fund Successfully </span>
                            </div>
                            @endif     
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                        <div class="search-box me-2">
                                            <form method="GET" action="{{ route('admin.list-historyloanfund') }}"
                                                class="d-flex">
                                                <div class="position-relative me-2">
                                                    <input type="text" class="form-control border" id="search"
                                                        name="search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetSearchListHistoryLoandFund()">Reset</button>
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
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <div class="d-flex">
                                                            <a href="{{ route('admin.detail-loanfund', $loanFund->id) }}"
                                                                class="px-2 text-primary">
                                                                <i class=" ri-file-info-fill font-size-18"></i>
                                                            </a>

                                                            <!-- Update button -->
                                                            <button type="button" class="btn text-primary p-0"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#updateModal{{ $loanFund->id }}">
                                                                <i class="ri-pencil-line font-size-18"></i>
                                                            </button>

                                                            <!-- Update button -->
                                                            <!-- <a href="{{ route('admin.edit-loanfund', $loanFund->id) }}"
                                                                class="px-2 text-primary">
                                                                <i class="ri-pencil-line font-size-18"></i>
                                                            </a> -->

                                                            <!-- Delete button -->
                                                            <form
                                                                action="{{ route('admin.loanfund-destroy', $loanFund->id) }}"
                                                                method="POST" class="px-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn text-danger p-0"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal{{ $loanFund->id }}">
                                                                    <i class="ri-delete-bin-line font-size-18"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>

                                            <!-- Update Modal -->
                                            <div class="modal fade" id="updateModal{{ $loanFund->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="updateModal{{ $loanFund->id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="updateModal{{ $loanFund->id }}Label">Update Status
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.historyloanfund-update', $loanFund->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <label for="status"
                                                                    class="col-sm-2 col-form-label">Status</label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-select"
                                                                        aria-label="Default select example"
                                                                        name="status" required>
                                                                        <option value="0"
                                                                            {{ $loanFund->status == 0 ? 'selected' : '' }}>
                                                                            Loan Active</option>
                                                                        <option value="1"
                                                                            {{ $loanFund->status == 1 ? 'selected' : '' }}>
                                                                            Loan Not Active</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light waves-effect"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light">Update</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                            </div>                            

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $loanFund->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModal{{ $loanFund->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModal{{ $loanFund->id }}Label">
                                                Confirmation
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this loan fund?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.historyloanfund-destroy', $loanFund->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger waves-effect waves-light">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">Showing {{ $loanFunds->firstItem() }} to {{ $loanFunds->lastItem() }} of {{ $loanFunds->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $loanFunds->links('pagination::bootstrap-4') }}
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

@extends('layouts.sidebar')
<?php
$title = "User Detail";
?>
@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">




            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailLoan"
                                    role="tab" aria-selected="true">
                                    <i class="ri-shield-user-line font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail User</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailUser" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Detail User</h5>
                                    
                                    
                                    <h5 class="font-size-15">Name</h5>
                                    <p>{{ $users->name }}</p>
                                    <h5 class="font-size-15">Email</h5>
                                    <p>{{ $users->email }}</p>
                                    <h5 class="font-size-15">Address</h5>
                                    <p>{{ $users->address }}</p>
                                    <h5 class="font-size-15">Birth Date</h5>
                                    <p>{{ $users->birth_date }}</p>
                                    <h5 class="font-size-15">Phone Number</h5>
                                    <p>{{ $users->phone_number }}</p>
                                    <h5 class="font-size-15">Job</h5>
                                    <p>{{ $users->job}}</p>
                                    <h5 class="font-size-15">Mandatory Savings</h5>
                                    <p>Rp.{{ number_format($users->mandatory_savings, 2, ',', '.') }}</p>
                                    <h5 class="font-size-15">Pin</h5>
                                    <p>{{ $users->pin}}</p>
                                                                                  
                                </div>
                                      
                            </div>                                
                        </div>
                            
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card mb-0">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailUser"
                                        role="tab" aria-selected="true">
                                        <i class=" ri-list-unordered font-size-20"></i>
                                        <span class="d-none d-sm-block">Detail Savings</span>
                                    </a>
                                </li>
                                
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content p-4">
                                
                                <div class="tab-pane active" id="detailSavings" role="tabpanel">
                                    <div>
                                        <div>
                                            <h5 class="font-size-16 mb-2 pt-1">Savings</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Type</th>
                                                            <th scope="col">Nominal</th>
                                                            <th scope="col">Start Date</th>
                                                            <th scope="col">End Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Payment Status</th>
                                                            <th scope="col">Payment Type</th>
                                                            <th scope="col">Payment Date</th>
                                                            <th scope="col" style="width: 120px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($savings as $saving)
                                                        <tr>
                                                            <td>{{ $saving->type }}</td>
                                                            <td>Rp.{{ number_format($saving->nominal, 2, ',', '.') }}
                                                            </td>
                                                            <td>{{ $saving->start_date }}</td>
                                                            <td>{{ $saving->end_date }}</td>
                                                            <td>
                                                                @if ($saving->status == 1)
                                                                <span style="color: green;">Completed</span>
                                                                @else
                                                                <span style="color: red;">Overdue</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($saving->payment_status == 0)
                                                                <span style="color: red;">Overdue</span>
                                                                @else
                                                                <span style="color: green;">Completed</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($saving->payment_type  == 0)
                                                                -
                                                                @else
                                                                {{ $saving->payment_type }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($saving->payment_date == 0)
                                                                -
                                                                @else
                                                                {{ $saving->payment_date}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Edit and Delete buttons -->
                                                                <ul class="list-inline mb-0">
                                                                    <li class="list-inline-item">
                                                                        <div class="d-flex">
                                                                            <a href="{{ route('admin.detail-savings', $saving->id) }}"
                                                                                class="px-2 text-primary">
                                                                                <i class=" ri-file-info-fill font-size-18"></i>
                                                                            </a>
                                                                            <!-- Update button -->
                                                                            <button type="button" class="btn text-primary p-0"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#updateModal{{ $saving->id }}">
                                                                                <i class="ri-pencil-line font-size-18"></i>
                                                                            </button>
                
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <!-- Update Modal -->
                                                            <div class="modal fade" id="updateModal{{ $saving->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="updateModal{{ $saving->id }}Label"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="updateModal{{ $saving->id }}Label">Update
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ route('admin.savings-update', $saving->id) }}"
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
                                                                                            {{ $saving->status == 0 ? 'selected' : '' }}>
                                                                                            <span style="color: red;">Overdue</span></option>
                                                                                        <option value="1"
                                                                                            {{ $saving->status == 1 ? 'selected' : '' }}>
                                                                                            <span style="color: green;">Completed</span></option>
                                                                                    </select>
                                                                                </div>
                                                                                <label for="payment_status"
                                                                                        class="col-sm-3 col-form-label">Payment Status</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-select"
                                                                                        aria-label="Default select example"
                                                                                        name="payment_status" required>
                                                                                        <option value="0"
                                                                                            {{ $saving->payment_status == 0 ? 'selected' : '' }}>
                                                                                            <span style="color: red;">Overdue</span></option>
                                                                                        <option value="1"
                                                                                            {{ $saving->payment_status == 1 ? 'selected' : '' }}>
                                                                                            <span style="color: green;">Completed</span></option>
                                                                                    </select>
                                                                                </div>
                                                                                <label for="payment_type"
                                                                                    class="col-sm-3 col-form-label">Payment Type</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-select"
                                                                                        aria-label="Default select example"
                                                                                        name="payment_type" required>
                                                                                        <option value="Cash"
                                                                                            {{ $saving->payment_type == 'Cash' ? 'selected' : '' }}>
                                                                                            <span>Cash</span></option>
                                                                                        <option value="Transfer"
                                                                                            {{ $saving->payment_type == 'Transfer' ? 'selected' : '' }}>
                                                                                            <span>Transfer</span></option>
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
                                                        </tr>
                                                        @endforeach
                                                    </tbody>


                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    

</div>
@endsection

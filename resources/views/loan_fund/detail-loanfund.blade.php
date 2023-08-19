@extends('layouts.sidebar')
<?php
$title = "Loan Fund Detail";
?>
@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">




            <div class="row">
                <div class="col-xl-3">
                    <div class="card mb-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailLoan"
                                    role="tab" aria-selected="true">
                                    <i class="ri-shield-user-line font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail Loan</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailLoan" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Detail Loan</h5>
                                    
                                    <h5 class="font-size-15">Id</h5>
                                    <p>LF-{{ $loanFund->id }}</p>
                                    <h5 class="font-size-15">Name</h5>
                                    <p>{{ $loanFund->user->name }}</p>
                                    <h5 class="font-size-15">Nominal</h5>
                                    <p>Rp.{{ number_format($loanFund->nominal, 2, ',', '.') }}</p>
                                    <h5 class="font-size-15">Infaq</h5>
                                    <p>{{ $loanFund->infaq}}%</p>
                                    <h5 class="font-size-15">Infaq Type</h5>
                                    <p>{{ ucwords($loanFund->infaq_type) }}</p>
                                    <h5 class="font-size-15">Infaq Status</h5>
                                    <p> @if ($loanFund->infaq_status == 0)
                                                <span style="color: red;">Overdue</span>
                                                @elseif ($loanFund->infaq_status == 1)
                                                <span style="color: green;">Completed</span>
                                                @endif       </p>
                                    <h5 class="font-size-15">Installment</h5>
                                    <p>{{ $loanFund->installment}} Month</p>
                                    <h5 class="font-size-15">Month Installment Now</h5>
                                    <p>Month {{ $loanFund->month}}</p>
                                                                                  
                                    </a>      
                                </div>                                
                            </div>
                            <div class="tab-pane" id="detailInstallment" role="tabpanel">
                                <div>
                                    <div>
                                        <h5 class="font-size-16 mb-2 pt-1">Installment</h5>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Month</th>
                                                        <th scope="col">Installment Month</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col" style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($loanBills as $loanBill)
                                                    <tr>
                                                        <td>{{ $loanBill->month }}</td>
                                                        <td>Rp.{{ number_format($loanBill->installment_amount, 2, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->installment == 1)
                                                            Installment
                                                            @else
                                                            Infaq
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->status == 1)
                                                            <span style="color: green;">Completed</span>
                                                            @else
                                                            <span style="color: red;">Overdue</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            detail
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
                    </div>
                </div>

                <div class="col-xl-9">
                <div class="card mb-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailLoan"
                                    role="tab" aria-selected="true">
                                    <i class=" ri-list-unordered font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail Installment</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            
                            <div class="tab-pane active" id="detailInstallment" role="tabpanel">
                                <div>
                                    <div>
                                        <h5 class="font-size-16 mb-2 pt-1">Installment</h5>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Month</th>
                                                        <th scope="col">Installment Month</th>
                                                        <th scope="col">Installment Start Date</th>
                                                        <th scope="col">Installment End Date</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Payment Status</th>
                                                        <th scope="col">Payment Type</th>
                                                        <th scope="col">Payment Date</th>
                                                        <th scope="col" style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($loanBills as $loanBill)
                                                    <tr>
                                                        <td>LB-{{ $loanBill->id }}</td>
                                                        <td>{{ $loanBill->month }}</td>
                                                        <td>Rp.{{ number_format($loanBill->installment_amount, 2, ',', '.') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($loanBill->start_date)->format('d M Y H:i:s') }}</td> 
                                                        <td>{{ \Carbon\Carbon::parse($loanBill->end_date)->format('d M Y H:i:s') }}</td> 
                                                        <td>
                                                            {{ $loanBill->type }}
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->status == 'Overdue')
                                                            <span style="color: #F90716;">Overdue</span>
                                                            @elseif ($loanBill->status == 'Active')
                                                            <span style="color: #FF6E31;">Active</span>
                                                            @else
                                                            <span style="color: green;">Completed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->payment_status == 'Overdue')
                                                            <span style="color: #F90716;">Overdue</span>                                                            
                                                            @else
                                                            <span style="color: green;">Completed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->payment_type  == 0)
                                                            -
                                                            @else
                                                            {{ $loanBill->payment_type }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($loanBill->payment_date == 0)
                                                            -
                                                            @else
                                                            {{ \Carbon\Carbon::parse($loanBill->payment_date)->format('d M Y H:i:s') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <!-- Edit and Delete buttons -->
                                                            <ul class="list-inline mb-0">
                                                                <li class="list-inline-item">                 
                                                                <div class="d-flex">        
                                                                        <!-- Pay Button -->
                                                                        <div class="px-2 text-primary">                
                                                                        <button type="button" class="btn text-primary p-0"
                                                                            data-bs-toggle="modal" class="px-2 text-primary"
                                                                            data-bs-target="#payModal{{ $loanBill->id }}">
                                                                            <i class="ri-hand-coin-fill font-size-18"></i>
                                                                        </button>       
                                                                        </div>

                                                                        <!-- Update button -->                                                                                                                                
                                                                        <button type="button" class="btn text-primary p-0"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#updateModal{{ $loanBill->id }}">
                                                                            <i class="ri-pencil-line font-size-18"></i>
                                                                        </button>

                                                                        <!-- Detail Button -->
                                                                        <a href="{{ route('admin.detail-fundbills', $loanBill->id) }}"
                                                                            class="px-2 text-primary">
                                                                            <i class=" ri-file-info-fill font-size-18"></i>
                                                                        </a>
            
                                                                        
            
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <!-- Payment Modal -->
                                                        <div class="modal fade" id="payModal{{ $loanBill->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="payModal{{ $loanBill->id }}Label"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="payModal{{ $loanBill->id }}Label">Payment
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.fundbills-pay', $loanBill->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            @if ($loanBill->payment_status != 'Overdue')                                                                                
                                                                                <div class="alert alert-danger alert-solid" role="alert">
                                                                                    <span class="fw-medium">Cannot pay, payment already successful.</span>
                                                                                </div>
                                                                            @endif
                                                                            <label for="type"
                                                                                class="col-sm-2 col-form-label">Type</label>
                                                                            <p>
                                                                                {{ $loanBill->type }}
                                                                            </p>
                                                                            <label for="status"
                                                                                class="col-sm-2 col-form-label">Nominal</label>
                                                                            <p>
                                                                            Rp.{{ number_format($loanBill->installment_amount, 2, ',', '.') }}
                                                                            </p>
                                                                            <label for="status"
                                                                                class="col-sm-3 col-form-label">Payment Type</label>
                                                                            <div class="col-sm-10">
                                                                            <select class="form-select" aria-label="Default select example" name="payment_type"
                                                                                {{ $loanBill->payment_status == 'Completed' ? 'disabled' : '' }} required>
                                                                                <option value="Cash" {{ $loanBill->payment_type == 'Cash' ? 'selected' : '' }}>
                                                                                    <span>Cash</span>
                                                                                </option>
                                                                                <option value="Transfer" {{ $loanBill->payment_type == 'Transfer' ? 'selected' : '' }}>
                                                                                    <span">Transfer</span>
                                                                                </option>
                                                                            </select>
                                                                            </div>                                                                                                                                                       
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light waves-effect"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                            @if ($loanBill->payment_status != 'Overdue')
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light" disabled>Pay</button>
                                                                            @else
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Pay</button>
                                                                            @endif
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Update Modal -->
                                                        <div class="modal fade" id="updateModal{{ $loanBill->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="updateModal{{ $loanBill->id }}Label"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="updateModal{{ $loanBill->id }}Label">Update
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('admin.fundbills-update', $loanBill->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <label for="status"
                                                                                class="col-sm-2 col-form-label">Status</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-select"
                                                                                    aria-label="Default select example"
                                                                                    name="status" required>
                                                                                    <option value="Overdue"
                                                                                        {{ $loanBill->status == 'Overdue' ? 'selected' : '' }}>
                                                                                        <span style="color: red;">Overdue</span></option>
                                                                                    <option value="Active"
                                                                                        {{ $loanBill->status == 'Active' ? 'selected' : '' }}>
                                                                                        <span style="color: green;">Active</span></option>
                                                                                    <option value="Completed"
                                                                                        {{ $loanBill->status == 'Completed' ? 'selected' : '' }}>
                                                                                        <span style="color: green;">Completed</span></option>
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

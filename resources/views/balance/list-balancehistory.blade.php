@extends('layouts.sidebar')
<?php
$title = "Balance History";
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
                                <span class="fw-medium">Add Balance Successfully </span>
                            </div>
                            @endif
                            @if(session('updateSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Update Balance Status Successfully </span>
                            </div>
                            @endif
                            @if(session('deleteSuccess'))
                            <div class="alert alert-success alert-solid" role="alert">
                                <span class="fw-medium">Delete Balance Successfully </span>
                            </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-inline float-md-start mb-3">
                                        <div class="search-box me-2">
                                            <form method="GET" action="{{ route('admin.list-historybalance') }}"
                                                class="d-flex">
                                                <div class="position-relative me-2">
                                                    <input type="text" class="form-control border" id="search"
                                                        name="search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetSearchBalance()">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 float-end">
                                        <a href="{{ route('admin.balance-form') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus me-1"></i> Add Balance
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="bg-light">

                                        <tr>                                            
                                            <th scope="col">Payment Id</th>
                                            <th scope="col">Type Payment</th>                                            
                                            <th scope="col">Nominal</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Date</th>
                                            <th scope="col" style="width: 200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($balanceHistories as $balanceHistorie)
                                        <tr>
                                            <td>

                                                @if ($balanceHistorie->loan_fund_id != '')
                                                    LF-{{$balanceHistorie->loan_fund_id}}
                                                @elseif ($balanceHistorie->goods_loan_id != '')
                                                    GL-{{$balanceHistorie->goods_loan_id}}
                                                @elseif ($balanceHistorie->operational_id != '')
                                                    OP-{{$balanceHistorie->operational_id}}
                                                @elseif ($balanceHistorie->loan_bills_id != '')
                                                    LB-{{$balanceHistorie->loan_bills_id}}
                                                @elseif ($balanceHistorie->savings_id != '')
                                                    SV-{{$balanceHistorie->savings_id}}
                                                @else
                                                    Balance
                                                @endif                                                
                                            </td>
                                            <td>
                                                @if ($balanceHistorie->loan_fund_id != '')
                                                    Loan Fund
                                                @elseif ($balanceHistorie->goods_loan_id != '')
                                                    Goods Loan
                                                @elseif ($balanceHistorie->operational_id != '')
                                                    Operational
                                                @elseif ($balanceHistorie->loan_bills_id != '')
                                                    Loan Bills
                                                @elseif ($balanceHistorie->savings_id != '')
                                                    Savings
                                                @else
                                                    Balance Update
                                                @endif                                                
                                            </td>                                                                                                                                

                                            <td>
                                                @if ($balanceHistorie->loan_fund_id != '')
                                                    <span style="color: red;">- Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @elseif ($balanceHistorie->goods_loan_id != '')
                                                    <span style="color: red;">- Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @elseif ($balanceHistorie->operational_id != '')
                                                    <span style="color: red;">- Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @elseif ($balanceHistorie->loan_bills_id != '')
                                                    <span style="color: green;">+ Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @elseif ($balanceHistorie->savings_id != '')
                                                    <span style="color: green;">+ Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @else
                                                    <span style="color: green;">+ Rp.{{ number_format($balanceHistorie->nominal, 2, ',', '.') }}   </span>
                                                @endif                                                                                             
                                            </td>

                                            <td> {{$balanceHistorie->description}} </td>

                                            <td>{{ ($balanceHistorie->date) }}</td>

                                            <td>
                                                <!-- Edit and Delete buttons -->
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <div class="d-flex">
                                                            <a href=
                                                            @if ($balanceHistorie->loan_fund_id != '')
                                                                {{ route('admin.detail-loanfund', $balanceHistorie->loan_fund_id) }}
                                                            @elseif ($balanceHistorie->goods_loan_id != '')
                                                                {{ route('admin.detail-goodsloan', $balanceHistorie->goods_loan_id) }}
                                                            @elseif ($balanceHistorie->operational_id != '')
                                                                {{ route('admin.detail-operational', $balanceHistorie->operational_id) }}
                                                            @elseif ($balanceHistorie->loan_bills_id != '')
                                                                {{ route('admin.detail-loanbills', $balanceHistorie->loan_bills_id) }}
                                                            @elseif ($balanceHistorie->savings_id != '')
                                                                {{ route('admin.detail-user', $balanceHistorie->savings_id) }}
                                                            @else
                                                                {{ route('admin.detail-balancehistory', $balanceHistorie->id) }}
                                                            @endif
                                                            class="px-2 text-primary">
                                                                <i class=" ri-file-info-fill font-size-18"></i>
                                                            </a>
                                                            </form>
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

                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    <p class="mb-sm-0">Showing {{ $balanceHistories->firstItem() }} to {{ $balanceHistories->lastItem() }} of {{ $balanceHistories->total() }} entries</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $balanceHistories->links('pagination::bootstrap-4') }}
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

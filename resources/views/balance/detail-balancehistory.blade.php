@extends('layouts.sidebar')
<?php
$title = "Balance Detail";
?>
@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">




            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailLoan"
                                    role="tab" aria-selected="true">
                                    <i class="ri-shield-user-line font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail Balance</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailBalance" role="tabpanel">
                                <div>                              
                                    <h5 class="font-size-16 mb-4">Balance</h5>
                                              
                                    <h5 class="font-size-15">Payment Id</h5>
                                    <p>
                                        @if ($balanceHistories->loan_fund_id != '')
                                            LF-{{$balanceHistories->loan_fund_id}}
                                        @elseif ($balanceHistories->goods_loan_id != '')
                                            GL-{{$balanceHistories->goods_loan_id}}
                                        @elseif ($balanceHistories->operational_id != '')
                                            OP-{{$balanceHistories->operational_id}}
                                        @elseif ($balanceHistories->loan_bills_id != '')
                                            LB-{{$balanceHistories->loan_bills_id}}
                                        @elseif ($balanceHistories->savings_id != '')
                                            SV-{{$balanceHistories->savings_id}}
                                        @else
                                            Balance
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Type Payment</h5>
                                    <p>
                                        @if ($balanceHistories->loan_fund_id != '')
                                            Loan Fund
                                        @elseif ($balanceHistories->goods_loan_id != '')
                                            Goods Loan
                                        @elseif ($balanceHistories->operational_id != '')
                                            Operational
                                        @elseif ($balanceHistories->loan_bills_id != '')
                                            Loan Bills
                                        @elseif ($balanceHistories->savings_id != '')
                                            Savings
                                        @else
                                            Balance Update
                                        @endif    
                                    </p>
                                    <h5 class="font-size-15">Nominal</h5>
                                    <p>
                                        @if ($balanceHistories->loan_fund_id != '')
                                            <span style="color: red;">- Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @elseif ($balanceHistories->goods_loan_id != '')
                                            <span style="color: red;">- Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @elseif ($balanceHistories->operational_id != '')
                                            <span style="color: red;">- Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @elseif ($balanceHistories->loan_bills_id != '')
                                            <span style="color: green;">+ Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @elseif ($balanceHistories->savings_id != '')
                                            <span style="color: green;">+ Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @else
                                            <span style="color: green;">+ Rp.{{ number_format($balanceHistories->nominal, 2, ',', '.') }}   </span>
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Description</h5>
                                    <p>{{ $balanceHistories->description }}</p>
                                    <h5 class="font-size-15">Date</h5>
                                    <p>{{ $balanceHistories->date }}</p>                           
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

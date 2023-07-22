@extends('layouts.sidebar')
<?php
$title = "Loan Bills Detail";
?>
@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">




            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-0">
                        <!-- Nav tabs -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailgoodsBills"
                                    role="tab" aria-selected="true">
                                    <i class="ri-shield-user-line font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail Loan Bills</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailgoodsBills" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Detail Loan Bills</h5>
                                    
                                    
                                    <h5 class="font-size-15">Month</h5>
                                    <p>{{ $loanBill->month }}</p>
                                    <h5 class="font-size-15">Installment Month</h5>
                                    <p>Rp.{{ number_format($loanBill->installment_amount, 2, ',', '.') }}</p>
                                    <h5 class="font-size-15">Installment Start Date</h5>
                                    <p>{{ $loanBill->start_date }}</p>
                                    <h5 class="font-size-15">Installment End Date</h5>
                                    <p>{{ $loanBill->end_date }}</p>
                                    <h5 class="font-size-15">Type</h5>
                                    <p>@if ($loanBill->installment == 1)
                                        Installment
                                        @else
                                        Infaq
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Status</h5>
                                    <p> @if ($loanBill->status == 1)
                                        <span style="color: green;">Active</span>
                                        @else
                                        <span style="color: red;">Waiting</span>
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Status</h5>
                                    <p>@if ($loanBill->payment_status == 0)
                                        <span style="color: red;">Waiting</span>
                                        @else
                                        <span style="color: green;">{{ $loanBill->payment_status }}</span>
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Type</h5>
                                    <p>@if ($loanBill->payment_type  == 0)
                                        -
                                        @else
                                        {{ $loanBill->payment_type }}
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Date</h5>
                                    <p>@if ($loanBill->payment_date == 0)
                                        -
                                        @else
                                        {{ $loanBill->payment_date}}
                                        @endif
                                    </p>                                               
                                    </a>      
                                </div>                                
                            </div>

                
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->    

</div>
@endsection
@extends('layouts.sidebar')
<?php
$title = "Savings Detail";
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
                                <a class="nav-link active" data-bs-toggle="tab" href="pages-profile.html#detailsaving"
                                    role="tab" aria-selected="true">
                                    <i class="ri-shield-user-line font-size-20"></i>
                                    <span class="d-none d-sm-block">Detail Savings</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailsaving" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Savings</h5>
                                    
                                    
                                    <h5 class="font-size-15">Type</h5>
                                    <p>{{ $saving->type }}</p>
                                    <h5 class="font-size-15">Nominal</h5>
                                    <p>Rp.{{ number_format($saving->nominal, 2, ',', '.') }}</p>
                                    <h5 class="font-size-15">Installment Start Date</h5>
                                    <p>{{ $saving->start_date }}</p>
                                    <h5 class="font-size-15">Installment End Date</h5>
                                    <p>{{ $saving->end_date }}</p>
                                    <h5 class="font-size-15">Status</h5>
                                    <p> @if ($saving->status == 1)
                                        <span style="color: green;">Completed</span>
                                        @else
                                        <span style="color: red;">Overdue</span>
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Status</h5>
                                    <p>@if ($saving->payment_status == 0)
                                        <span style="color: red;">Overdue</span>
                                        @else
                                        <span style="color: green;">Completed</span>
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Type</h5>
                                    <p>@if ($saving->payment_type  == 0)
                                        -
                                        @else
                                        {{ $saving->payment_type }}
                                        @endif
                                    </p>
                                    <h5 class="font-size-15">Payment Date</h5>
                                    <p>@if ($saving->payment_date == 0)
                                        -
                                        @else
                                        {{ $saving->payment_date}}
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

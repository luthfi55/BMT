@extends('layouts.sidebar')
<?php
$title = "Loan Fund Detail";
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
                                    <span class="d-none d-sm-block">Detail Loan</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailLoan" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Detail Loan</h5>
                                    
                                    
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

                <div class="col-xl-6">
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
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())

                    </script> © Tocly.
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
@endsection

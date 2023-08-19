@extends('layouts.sidebar')
<?php
$title = "Dashboard";
?>
@section('content')
<!-- start page title -->
  

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        
                        

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0">
                                                <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                                    <i class="uim uim-briefcase"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden ms-4">
                                                <p class="text-muted text-truncate font-size-15 mb-2"> Saldo BMT</p>
                                                <h3 class="fs-4 flex-grow-1 mb-3">Rp.{{ number_format($balance->nominal, 2, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0">
                                                <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                                    <i class="uim uim-layer-group"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden ms-4">
                                                <p class="text-muted text-truncate font-size-15 mb-2"> Total Users</p>
                                                <h3 class="fs-4 flex-grow-1 mb-3">{{ $userCount }}<span class="text-muted font-size-16"> Users</span></h3>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0">
                                                <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                                    <i class="uim uim-scenery"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden ms-4">
                                                <p class="text-muted text-truncate font-size-15 mb-2"> Total Loan Fund Active</p>
                                                <h3 class="fs-4 flex-grow-1 mb-3">{{ $loanFundCount }} <span class="text-muted font-size-16">Loan Active</span></h3>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0">
                                                <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                                    <i class="uim uim-airplay"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden ms-4">
                                                <p class="text-muted text-truncate font-size-15 mb-2"> Total Goods Loan Active</p>
                                                <h3 class="fs-4 flex-grow-1 mb-3">{{ $goodsLoanCount }}<span class="text-muted font-size-16"> Loan Active</span></h3>                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END ROW -->

                        <!-- END ROW -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex pb-0">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Users</h4>
                                        <div>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-reset" href="{{ route('admin.list-user') }}">
                                                    <span class="fw-semibold">Detail</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="table-responsive" data-simplebar style="max-height: 358px;">
                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                  <tbody>
                                                      @foreach ($users as $user)                                    
                                                      <tr>
                                                          <!-- User data -->
                                                          <td>                                            
                                                            <h6 class="font-size-15 mb-1">{{ $user->name }}</h6>
                                                            <p class="text-muted mb-0 font-size-14">{{ $user->phone_number }}</p>
                                                          </td>                                     
                                                          <td>{{ $user->email }}</td>
                                                          <td>
                                                              <ul class="list-inline mb-0">
                                                              <li class="list-inline-item">
                                                                  <div class="d-flex">
                                                                      <a href="{{ route('admin.detail-user', $user->id) }}"
                                                                          class="px-2 text-primary">
                                                                          <i class=" ri-file-info-fill font-size-18"></i>
                                                                      </a>
                                                                  </div>
                                                              </li>
                                                              </ul>
                                                          </td>
                                                      </tr>
                                                      @endforeach
                                                  </tbody>
                                            </table>
                                        </div> <!-- enbd table-responsive-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex pb-0">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Loan Fund</h4>
                                        <div>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-reset" href="{{ route('admin.list-loanfund') }}">
                                                    <span class="fw-semibold">Detail</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="table-responsive" data-simplebar style="max-height: 358px;">
                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <tbody>
                                                    @foreach ($loanFunds as $loanFund)
                                                    <tr>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1">{{ $loanFund->user->name }}</h6>
                                                            <p class="text-muted mb-0 font-size-14">Rp.{{ number_format($loanFund->nominal, 2, ',', '.') }}</p>
                                                        </td>
                                                        <td>{{ $loanFund->installment }} Months</td>
                                                        <td>
                                                            <ul class="list-inline mb-0">
                                                                <li class="list-inline-item">
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('admin.detail-loanfund', $loanFund->id) }}"
                                                                            class="px-2 text-primary">
                                                                            <i class=" ri-file-info-fill font-size-18"></i>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- enbd table-responsive-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex pb-0">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Goods Loan</h4>
                                        <div>
                                            <div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-reset" href="{{ route('admin.list-goodsloan') }}">
                                                        <span class="fw-semibold">Detail</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="table-responsive" data-simplebar style="max-height: 358px;">
                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <tbody>
                                                    @foreach ($goodsLoans as $goodsLoan)
                                                    <tr>
                                                        <td>
                                                            <h6 class="font-size-15 mb-1">{{ $goodsLoan->user->name }}</h6>
                                                            <p class="text-muted mb-0 font-size-14">Rp.{{ number_format($goodsLoan->nominal, 2, ',', '.') }}</p>
                                                        </td>
                                                        <td>{{ $goodsLoan->goods }}</td>
                                                        <td>{{ $goodsLoan->installment }} Months</td>
                                                        <td>
                                                            <ul class="list-inline mb-0">
                                                                <li class="list-inline-item">
                                                                    <div class="d-flex">
                                                                        <a href="{{ route('admin.detail-goodsloan', $goodsLoan->id) }}"
                                                                            class="px-2 text-primary">
                                                                            <i class=" ri-file-info-fill font-size-18"></i>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- enbd table-responsive-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END ROW -->

                        <div class="row">
                           <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex pb-0">
                                        <h4 class="card-title mb-0 flex-grow-1">Latest Transaction</h4>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Payment Id</th>
                                                        <th>Type Payment</th>
                                                        <th>Nominal</th>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
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

                                                        <td>{{ \Carbon\Carbon::parse($balanceHistorie->date)->format('d M Y H:i:s') }}</td>                                            

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
                                                                            {{ route('admin.detail-fundbills', $balanceHistorie->loan_bills_id) }}
                                                                        @elseif ($balanceHistorie->savings_id != '')
                                                                            {{ route('admin.detail-savings', $balanceHistorie->savings_id) }}
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
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                           </div>
                        </div>
                         <!-- END ROW -->

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
               
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">                            
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Create by BMT Cerebrum
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->    

</html>
@endsection
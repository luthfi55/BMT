@extends('layouts.sidebar')
<?php
$title = "Operational Detail";
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
                                    <span class="d-none d-sm-block">Detail Operational</span>
                                </a>
                            </li>
                            
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="detailUser" role="tabpanel">
                                <div>                                
                                    <h5 class="font-size-16 mb-4">Detail Operational</h5>
                                              
                                    <h5 class="font-size-15">Id</h5>
                                    <p>OP-{{ $operationals->id }}</p>
                                    <h5 class="font-size-15">Goods</h5>
                                    <p>{{ $operationals->goods }}</p>
                                    <h5 class="font-size-15">Description</h5>
                                    <p>{{ $operationals->description }}</p>
                                    <h5 class="font-size-15">Nominal</h5>
                                    <p>Rp.{{ number_format($operationals->nominal, 2, ',', '.') }}</p>
                                    <h5 class="font-size-15">Date</h5>
                                    <p>{{ $operationals->date }}</p>
                                                                                  
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

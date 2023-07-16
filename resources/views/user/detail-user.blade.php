@extends('layouts.sidebar')
<?php
$title = "User Detail";
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
                <div class="col-xl-6">
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
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col" style="width: 120px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($savings as $saving)
                                                        <tr>
                                                            <td>{{ $saving->type }}</td>
                                                            <td>Rp.{{ number_format($saving->nominal, 2, ',', '.') }}
                                                            </td>
                                                            <td>{{ $saving->date }}
                                                            <td>
                                                                @if ($saving->status == 1)
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
    

</div>
@endsection

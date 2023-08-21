<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>BMT - ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="BMT ADMIN" name="description" />
    <meta content="BMT" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- plugin css -->
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />



</head>

<body data-sidebar="colored">


    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="/assets/images/logo-dark.png" alt="logo-sm-dark" height="24">
                            </span>
                            <span class="logo-lg">
                                <img src="/assets/images/logo-sm-dark.png" alt="logo-dark" height="25">
                            </span>
                        </a>

                        <a href="/admin/dashboard" class="logo logo-light">
                        <span class="logo-sm">
                            <!-- <img src="/assets/images/logo-sm-light.png" alt="logo-sm-light" height="24"> -->
                            <h5 style="color: #086070; padding-top: 20px;">BMT</h5>
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="/assets/images/logo-light.png" alt="logo-light" height="22"> -->
                            <h2 style="color: #086070; padding-top: 20px;">BMT</h2>
                        </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    <div class="page-title-box align-self-center d-none d-md-block">
                        <h4 class="page-title mb-0"><?php echo $title ?></h4>
                    </div>
                    <!-- end page title -->
                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                    <a href="/admin/dashboard" class="logo logo-dark">
                        <span class="logo-sm">
                            <!-- <img src="/assets/images/logo-sm-dark.png" alt="logo-sm-dark" height="24"> -->
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="/assets/images/logo-dark.png" alt="logo-dark" height="22"> -->
                        </span>
                    </a>

                    <a href="/admin/dashboard" class="logo logo-light">
                        <span class="logo-sm">
                            <!-- <img src="/assets/images/logo-sm-light.png" alt="logo-sm-light" height="24"> -->
                            <h5 style="color: white; padding-top: 20px;">BMT</h5>
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="/assets/images/logo-light.png" alt="logo-light" height="22"> -->
                            <h2 style="color: white; padding-top: 20px;">BMT</h2>
                        </span>
                    </a>
                </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn"
                id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <div data-simplebar class="vertical-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">                        
                    
                    <li class="menu-title">Home</li>

                        <li>
                            <a href="/admin/dashboard" class="waves-effect">
                                <i class="mdi mdi-home"></i><span
                                    class="badge rounded-pill bg-success float-end"></span>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title">User Menu</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-account-lock"></i>
                                <span>Admin</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/admin-form">Create Admin</a></li>                                
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-account"></i>
                                <span>User</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/user-form">Create User</a></li>
                                <li><a href="/admin/list-user">List User</a></li>                                
                            </ul>
                        </li> 

                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-cash"></i>
                                <span>Loan Fund</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/loanfund-form">Create Loan</a></li>
                                <li><a href="/admin/list-loanfund">Active Loan</a></li>
                                <li><a href="/admin/list-historyloanfund">Loan History</a></li>                
                            </ul>
                        </li>      

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-basket-fill"></i>
                                <span>Goods Loan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/goodsloan-form">Create Loan</a></li>
                                <li><a href="/admin/list-goodsloan">Active Loan</a></li>
                                <li><a href="/admin/list-historygoodsloan">Loan History</a></li>                
                            </ul>
                        </li>              

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-database-settings"></i>
                                <span>Operational</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/operational-form">Create Operational</a></li>
                                <li><a href="/admin/list-operational">History</a></li>                
                            </ul>
                        </li>    

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-cash-register"></i>
                                <span>Balance</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                    
                                <li><a href="/admin/balance-form">Balance Adjustments</a></li>
                                <li><a href="/admin/list-historybalance">History</a></li>                
                            </ul>
                        </li>                                   
                        <!-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uim uim-comment-message"></i>
                                <span>Apps</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow">Email</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="email-inbox.html">Inbox</a></li>
                                        <li><a href="email-read.html">Read Email</a></li>
                                    </ul>
                                </li>

                                <li><a href="calendar.html">Calendar</a></li>

                                <li><a href="apps-chat.html">Chat</a></li>

                                <li><a href="apps-file-manager.html">File Manager</a></li>


                                <li>
                                    <a href="javascript: void(0);" class="has-arrow">Invoice</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="invoices.html">Invoices</a></li>
                                        <li><a href="invoice-detail.html">Invoice Detail</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="has-arrow">Users</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="users-list.html">Users List</a></li>
                                        <li><a href="users-detail.html">Users Detail</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->                        

                    </ul>

                </div>
                <!-- Sidebar -->
            </div>

            <div class="dropdown px-3 sidebar-user sidebar-user-info">
                <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="/assets/images/users/avatar-3.jpg"
                                class="img-fluid header-profile-user rounded-circle" alt="">
                        </div>

                        <div class="flex-grow-1 ms-2 text-start">
                        <span class="ms-1 fw-medium user-name-text">{{ Auth::guard('admin')->user()->name }}</span>
                        </div>

                        <div class="flex-shrink-0 text-end">
                            <i class="mdi mdi-dots-vertical font-size-16"></i>
                        </div>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <!-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="pages-faq.html"><i class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="/admin/balance-form"><i
                            class="mdi mdi-wallet text-muted font-size-16 align-middle me-1"></i> <span
                            class="align-middle">Rp.{{ number_format($balance->nominal, 2, ',', '.') }}</span></a>                    
                    <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>

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


        <!-- Left Sidebar End -->



        @yield('content')

        <!-- JAVASCRIPT -->
        <script src="/assets/libs/jquery/jquery.min.js"></script>
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/libs/node-waves/waves.min.js"></script>

        <!-- Icon -->
        <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

        <!-- apexcharts -->
        <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="/assets/libs/jsvectormap/maps/world-merc.js"></script>

        <script src="/assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        function resetSearch() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-user') }}";
        }
        function resetSearchLoanFund() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.loanfund-form') }}";
        }
        function resetSearchListLoandFund() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-loanfund') }}";
        }
        function resetSearchListHistoryLoandFund() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-historyloanfund') }}";
        }
        function resetSearchBalance() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-historybalance') }}";
        }
        function resetSearchListGoodsLoan() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-goodsloan') }}";
        }
        function resetSearchListOperational() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-operational') }}";
        }
        function resetSearchListHistoryGoodsLoan() {
            document.getElementById('search').value = '';
            document.getElementById('search').focus(); 
            window.location.href = "{{ route('admin.list-historygoodsloan') }}";
        }       
        </script>
        
</body>

</body>

</html>

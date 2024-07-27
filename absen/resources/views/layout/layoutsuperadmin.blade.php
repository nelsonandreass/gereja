<!DOCTYPE html>
<html dir="ltr" lang="en">

<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Xtreme lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Xtreme admin lite design, Xtreme admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Xtreme Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow"> -->
    <title>GPdI Sahabat Allah</title>

    <!-- <link rel="canonical" href="https://www.wrappixel.com/templates/xtreme-admin-lite/" /> -->
    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicons/favicon-32x32.png')}}">
    <!-- Custom CSS -->
    <!-- <link href="{{asset('superadmin/libs/chartist/dist/chartist.min.css')}}" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script> -->
    <!-- poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />  
    <!-- end of CDN -->

    <link href="{{asset('superadmin/dist/css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

  
<style>
    body{
        font-family: 'Poppins', sans-serif !important;
        background-color: #eef5f9 !important;
    }
    .unselectable {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

</style>
</head>

<body class="unselectable">
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="../../assets/images/logo-icon.png" alt="homepage" class="dark-logo" /> -->
                            <!-- Light Logo icon -->
                            <!-- <img src="../../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" /> -->
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                         
                            
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-start me-auto">
                       
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-end">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown user-content hide-menu">
                            <a href="#" class="" id="Userdd" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="m-b-0 user-name font-medium text-decor-none " style="color: #FFFFFF;">{{Auth::user()->name}} <i
                                        class="fa fa-angle-down"></i></h5>
                                <span class="op-5 user-email text-decor-none" style="color: #FFFFFF;">{{Auth::user()->email}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                               <a class="dropdown-item" href="{{url('/logout')}}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                            </ul>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" style="z-index:" id="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" id="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav" id="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li>    
                        <li class="sidebar-item " id="id-menu" > <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="" aria-expanded="false"><i class="mdi mdi-close"></i></a></li>
                        <li class="sidebar-item " id="id-close"  style="display:none;"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="" aria-expanded="false"><i class="mdi mdi-menu"></i></a></li>
                      
                        </li>
                        
                        
                        <div id="wrapper-sidebar">
                          
                             <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{url('/adminhome')}}" aria-expanded="false"><i class="fa-solid fa-house-user"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</span>
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{url('/ibadah')}}" aria-expanded="false"><i class="fa-regular fa-pen-to-square"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Absen</span>
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{url('/listjemaat')}}" aria-expanded="false"><i class="fa-regular fa-user col-1"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jemaat </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{route('tempuser.index')}}" aria-expanded="false"><i class="fa-regular fa-user col-1"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jemaat Baru </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{url('/ulangtahun')}}" aria-expanded="false"><i class="fa-solid fa-cake-candles col-1 m-0 p-0"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ulang Tahun </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{route('komsel.index')}}" aria-expanded="false"><i class="fa-solid fa-user-group"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Komsel </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{route('bic.index')}}" aria-expanded="false"><i class="fa-solid fa-user-group"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIC </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{route('youth.index')}}" aria-expanded="false"><i class="fa-solid fa-user-group"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Youth </span> 
                                </a> 
                            </li>
                            <li class="sidebar-item"> 
                                 <a class="sidebar-link waves-effect waves-dark " href="{{route('keluarga.index')}}" aria-expanded="false"><i class="fa-solid fa-user-group"></i>
                                 <span class="hide-menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keluarga </span> 
                                </a> 
                            </li>
                        </div>
                      
                        
                    </ul>

                </nav>
               
            </div>
            
        </aside>
        @yield('content')
    </div>
    
    @yield('script')

    
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('superadmin/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('superadmin/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('superadmin/dist/js/app-style-switcher.js')}}"></script>
    <!--Wave Effects -->
    <!-- <script src="{{asset('superadmin/dist/js/waves.js')}}"></script> -->
    <!--Menu sidebar -->
    <script src="{{asset('superadmin/dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('superadmin/dist/js/custom.js')}}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    
    <script src="{{asset('dist/js/bootstrap.min.js')}}"></script>
    <script>
        function hideleft(){
            $("#left-sidebar").animate({width : "50px"});
            $("#wrapper-sidebar").hide();
            $("#arrow-left").hide();
            $("#arrow-right").show();
        }
        function showleft(){
            $("#left-sidebar").animate({width : "250px"});
            $("#wrapper-sidebar").show();
            $("#arrow-left").show();
            $("#arrow-right").hide();
        }
        $(document).ready(function(){
            $("#id-menu").click(function(e){
                e.preventDefault();
                $("#left-sidebar").animate({width : "70px"});
                $("#wrapper-sidebar").hide(300);
                $("#id-menu").hide();
                $("#id-close").show();
                $(".page-wrapper").animate({"margin-left" : "5%"});
            });
            $("#id-close").click(function(e){ 
                e.preventDefault();
                $("#left-sidebar").animate({width : "250px"});
                $("#wrapper-sidebar").show(300);
                $("#id-menu").show();
                $("#id-close").hide();
                $(".page-wrapper").animate({"margin-left" : "250px"});

            });
        });
    </script>
</body>

</html>
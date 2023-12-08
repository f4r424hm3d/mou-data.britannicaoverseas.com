<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  @stack('title')
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- choices css -->
  <link href="{{ url('backend/') }}/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet"
    type="text/css" />

  <!-- DataTables -->
  <link href="{{ url('backend/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
    type="text/css" />
  <link href="{{ url('backend/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
    rel="stylesheet" type="text/css" />

  <!-- Responsive datatable examples -->
  <link href="{{ url('backend/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
    rel="stylesheet" type="text/css" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ url('backend/') }}/assets/images/favicon.ico" />

  <!-- plugin css -->
  <link href="{{ url('backend/') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
    rel="stylesheet" type="text/css" />

  <!-- Bootstrap Css -->
  <link href="{{ url('backend/') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
  <!-- Icons Css -->
  <link href="{{ url('backend/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ url('backend/') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <script src="{{ url('/') }}/ckeditor/ckeditor.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .hide-this {
      display: none;
    }

    .f-rgt {
      float: right;
    }

    .btn-xs,
    .btn-group-xs>.btn {
      padding: 1px 5px;
      font-size: 0.8571rem;
      line-height: 1.5;
      border-radius: 3px;
    }

    .float-right {
      float: right;
    }

    .chr {
      margin-top: 3px;
      margin-bottom: 3px
    }

    .just {
      text-align: justify;
      text-justify: inter-word;
    }

    .setBtn {
      margin-top: 31px;
    }

    .card {
      border: 1px solid #6d70738f !important;
    }
  </style>
</head>

<body data-layout="horizontal" data-layout-size="boxed" data-layout-mode="light" data-topbar="dark"
  data-sidebar="light">
  <!-- Begin page -->
  <div id="layout-wrapper">
    <header id="page-topbar">
      <div class="navbar-header">
        <div class="d-flex">
          <!-- LOGO -->
          <div class="navbar-brand-box">
            <a href="{{ url('admin') }}" class="logo logo-dark">
              <span class="logo-sm">
                <img src="{{ url('backend/') }}/assets/images/logo-sm.svg" alt="" height="24" />
              </span>
              <span class="logo-lg">
                <img src="{{ url('backend/') }}/assets/images/logo-sm.svg" alt="" height="24" />
                <span class="logo-txt">{{ config('app.name') }}</span>
              </span>
            </a>

            <a href="{{ url('admin') }}" class="logo logo-light">
              <span class="logo-sm">
                <img src="{{ url('backend/') }}/assets/images/logo-sm.svg" alt="" height="24" />
              </span>
              <span class="logo-lg">
                <img src="{{ url('backend/') }}/assets/images/logo-sm.svg" alt="" height="24" />
                <span class="logo-txt">{{ config('app.name') }}</span>
              </span>
            </a>
          </div>
          <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
            data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <i class="fa fa-fw fa-bars"></i>
          </button>
        </div>

        <div class="d-flex">
          <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item bg-soft-light border-start border-end"
              id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle header-profile-user"
                src="{{ url('backend/') }}/assets/images/users/avatar-1.jpg" alt="Header Avatar" />
              <span
                class="d-none d-xl-inline-block ms-1 fw-medium">{{ getFirstName(session('userLoggedIn.user_name')) }}</span>
              <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
              <!-- item-->
              <a class="dropdown-item" href="{{ url('admin/profile') }}">
                <i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ url('admin/logout') }}">
                <i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="topnav">
      <div class="container">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
          <div class="collapse navbar-collapse" id="topnav-menu-content">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ url('admin') }}" id="topnav-dashboard"
                  role="button">
                  <i data-feather="home"></i><span data-key="t-dashboards">Dashboard</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ aurl('universities') }}"
                  id="topnav-dashboard" role="button">
                  <i data-feather="file-text"></i><span data-key="t-dashboards">University</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ aurl('universities/add') }}"
                  id="topnav-dashboard" role="button">
                  <i data-feather="plus-square"></i><span data-key="t-dashboards">Add University</span>
                </a>
              </li>
              @if (session('userLoggedIn.role') == 'admin')
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle arrow-none" href="{{ aurl('users') }}" id="topnav-dashboard"
                    role="button">
                    <i data-feather="users"></i><span data-key="t-dashboards">Users</span>
                  </a>
                </li>
              @endif
            </ul>
          </div>
        </nav>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

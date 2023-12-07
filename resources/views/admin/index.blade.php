@extends('admin.layouts.main')
@push('title')
  <title>{{ config('app.name') }} : {{ ucwords(session('userLoggedIn.role')) }} Dashboard</title>
@endpush
@section('main-section')
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                  <a href="javascript: void(0);">{{ ucwords(session('userLoggedIn.role')) }}</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-12 col-md-12">
          <div class="card card-h-100">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-12">
                  <center>
                    <h1 style="text-shadow: 1px 1px 1px #4f4636" class="text-info">MOU Dashboard</h1>
                  </center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@extends('auth.layouts.main')
@push('title')
  <title>Invalid Link : {{ config('app.name') }}</title>
@endpush
@section('main-section')
  <div class="auth-page">
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-xxl-4 col-lg-4 col-md-12"></div>
        <div class="col-xxl-4 col-lg-4 col-md-12">
          <div class="auth-full-page-content d-flex p-sm-5 p-4">
            <div class="w-100">
              <div class="d-flex flex-column h-100">
                <div class="mb-4 mb-md-5 text-center">
                  <a href="index.html" class="d-block auth-logo">
                    <img src="{{ url('backend/') }}/assets/images/logo-sm.svg" alt="" height="28" />
                    <span class="logo-txt">{{ config('app.name') }}</span>
                  </a>
                </div>

                <div class="card">
                  <div class="card-body">
                    <div class="auth-content my-auto">
                      <h5>
                        <center>This link is invalid</center>
                      </h5>
                      <p class="mb-3">
                        <center>Please request a new one and try again.</center>
                      </p>
                      <div class="mt-5 text-center">
                        <p class="text-muted mb-0">
                          <a href="{{ url('admin/login') }}" class="text-primary fw-semibold">
                            Sign In
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 mt-md-5 text-center">
                  <p class="mb-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    {{ config('app.name') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- end auth full page content -->
        </div>
      </div>
    </div>
  </div>
@endsection

@extends('auth.layouts.main')
@push('title')
  <title>Reset Password : {{ config('app.name') }}</title>
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
                @if (session()->has('smsg'))
                  <div class="alert alert-success alert-dismissablee fade show">
                    {{ session()->get('smsg') }}
                  </div>
                @endif
                @if (session()->has('emsg'))
                  <div class="alert alert-danger alert-dismissablee fade show">
                    {{ session()->get('emsg') }}
                  </div>
                @endif

                <div class="card">
                  <div class="card-body">
                    <div class="auth-content my-auto">
                      <form action="{{ url('reset-password') }}" method="post">
                        @csrf

                        <input type="hidden" name="id" value="{{ $_GET['uid'] }}">
                        <input type="hidden" name="remember_token" value="{{ $_GET['token'] }}">

                        <div class="mb-3">
                          <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                              <label class="form-label">New Password</label>
                            </div>
                          </div>
                          <div class="input-group auth-pass-inputgroup">
                            <input type="password" name="new_password" class="form-control"
                              placeholder="Enter New Password" aria-label="New Password"
                              aria-describedby="password-addon" />
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon">
                              <i class="mdi mdi-eye-outline"></i>
                            </button>
                          </div>
                          <span class="text-danger">
                            @error('new_password')
                              {{ $message }}
                            @enderror
                          </span>
                        </div>

                        <div class="mb-3">
                          <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                              <label class="form-label">Confirm New Password</label>
                            </div>
                          </div>
                          <div class="input-group auth-pass-inputgroup">
                            <input type="password" name="confirm_new_password" class="form-control"
                              placeholder="Confirm New Pasword" aria-label="Password" aria-describedby="password-addon" />
                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon">
                              <i class="mdi mdi-eye-outline"></i>
                            </button>
                          </div>
                          <span class="text-danger">
                            @error('confirm_new_password')
                              {{ $message }}
                            @enderror
                          </span>
                        </div>

                        <div class="mb-3">
                          <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                            Submit
                          </button>
                        </div>
                      </form>

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

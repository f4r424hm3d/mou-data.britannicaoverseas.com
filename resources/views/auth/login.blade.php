@extends('auth.layouts.main')
@push('title')
  <title>User Login : {{ config('app.name') }}</title>
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
                <div class="auth-content my-auto">
                  <form action="{{ url('admin/login') }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" placeholder="Username"
                        value="{{ old('username') }}">
                    </div>
                    <div class="mb-3">
                      <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                          <label class="form-label">Password</label>
                        </div>
                        <div class="flex-shrink-0">
                          <div class="">
                            <a href="{{ url('account/password/reset') }}" class="text-muted">Forgot password?</a>
                          </div>
                        </div>
                      </div>

                      <div class="input-group auth-pass-inputgroup">
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                          aria-label="Password" aria-describedby="password-addon" />
                        <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon">
                          <i class="mdi mdi-eye-outline"></i>
                        </button>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="remember-check" />
                          <label class="form-check-label" for="remember-check">
                            Remember me
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                        Log In
                      </button>
                    </div>
                  </form>

                  <div class="mt-5 text-center">
                    <p class="text-muted mb-0">
                      <a href="{{ url('account/password/reset') }}" class="text-primary fw-semibold">
                        Forgot Password
                      </a>
                    </p>
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

@extends('auth.layouts.main')
@push('title')
  <title>Forget Password : {{ config('app.name') }}</title>
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
                  <form action="{{ url('forget-password') }}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Enter your email we'll send you a link to reset your password.</label>
                      <input type="text" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}">
                      <span class="text-danger">
                        @error('email')
                          {{ $message }}
                        @enderror
                      </span>
                    </div>

                    <div class="mb-3">
                      <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                        Reset Password
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

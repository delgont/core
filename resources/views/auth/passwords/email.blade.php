@extends('dashboard.layouts.auth')


@section('content')
<div class="authentication-inner row">
    <div class="col-lg-12 text-center py-2">
        <h6>Reset Password</h6>
    </div>
    <div class="col-lg-4 offset-lg-4 py-3">
      <div class="card shadow-md">
        <div class="card-body">
          <!-- Logo -->
          <div class="text-start pb-4">
            <a href="index.html" class="app-brand-link gap-2">
              <img src="{{ asset('images/logo.svg') }}" alt="">
                <span>👋</span>
            </a>
          </div>

          <form method="POST" action="{{ route('password.email') }}" class="py-3">
            @csrf

            <div class="form-group row">
                <label for="email" class="form-label text-muted font-10 text-uppercase">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control my-2 @error('email') is-invalid @enderror" placeholder="Enter Your Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-4 my-4">
                {{ __('Send Password Reset Link') }}
            </button>

            <a href="{{ route('login') }}" class="py-2 text-center">Login Insteady</a>
        </form>
          @if (session('status'))
          <div class="alert alert-success">
            <p class="mb-0">{{ session('status') }}</p>
          </div>
          @endif
          
        </div>
      </div>
    </div>
  </div>

@endsection

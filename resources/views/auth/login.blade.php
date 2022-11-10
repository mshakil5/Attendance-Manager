@extends('layouts.master')

@section('content')
<section class="authentication">
    <div class="container">
      <div class="authContainer">
          <div class="login">
              <div class="heading">
                 <h2>welcome back!</h2>
                 <h5>sign in your account</h5>
              </div>

              <form method="POST" action="{{ route('login') }}" class="form-theme">
                @csrf
                 <label for="">
                     <input id="email" type="email" class="form-theme-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                     <span class="iconify icon" data-icon="carbon:email" data-inline="false"></span>

                     @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                 </label>

                 <label for="">
                     <input id="password" type="password" class="form-theme-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                     <span class="iconify icon" data-icon="teenyicons:password-outline" data-inline="false"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                 </label>

                 <button class="form-btn">sign in </button>

              </form>
          </div>

          <div class="divider">
            <hr>
        </div>
        <div class="register">
           <div class="heading">
               <h2>Login with Google</h2>
            </div>

            <div class="form-theme"> 
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ url('auth/google') }}">
                        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                    </a>
                </div>

            </div>
        </div>
          
          
      </div>
    </div>
</section>
@endsection

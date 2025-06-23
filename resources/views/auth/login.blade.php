{{-- <x-tenant-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-tenant-guest-layout> --}}




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>MD-Autos</title>
      
      <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">

     
    
  <body class=" ">
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
    <!-- loader END -->
    
      <div class="wrapper">
         <section class="login-content">
            <div class="container">
               <div class="row align-items-center justify-content-center height-self-center">
                  <div class="col-lg-6">
                     <div class="card auth-card">
                        <div class="card-body p-0">
                           <div class="d-flex align-items-center auth-content">
                              <div class="p-3">
                                 <h2 class="mb-2">Sign In</h2>
                                 <p>Login to stay connected.</p>
                                 <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="row">   
                                                                           
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" placeholder=" " value="{{ old('email') }}" name="email" required autofocus autocomplete="username">
                                             <label>Email</label>
                                             @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                             @endif

                                          </div>
                                       </div>

                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password" placeholder=" " value="{{ old('password') }}" name="password" required autofocus autocomplete="username">
                                             <label>Password</label>
                                             @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                             @endif

                                          </div>
                                       </div> 

                                       <div class="col-lg-6">
                                          <div class="custom-control custom-checkbox mb-3">
                                             <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                             <label class="custom-control-label control-label-1" for="remember_me">Remember Me</label>
                                          </div>
                                       </div>

                                       <div class="col-lg-6">
                                          @if (Route::has('password.request'))
                                             <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                             </a>
                                          @endif
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sign In</button>
                                    <p class="mt-3">
                                       Create an Account <a href="{{ route('register') }}" class="text-primary">Sign Up</a>
                                    </p>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
    
      <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
      <!-- Table Treeview JavaScript -->
      <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
      <!-- app JavaScript -->
      <script src="{{ asset('backend/assets/js/app.js') }}"></script>
  </body>
</html>

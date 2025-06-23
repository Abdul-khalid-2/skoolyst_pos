
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>MD-Autos</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
      
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
                           {{-- <div class="col-lg-7 align-self-center"> --}}
                              <div class="p-3">
                                 <h2 class="mb-2">Sign Up</h2>
                                 <p>Create your account.</p>
                                 <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder=" ">
                                             <label>Full Name</label>
                                             @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>                                                    
                                             @endif
                                          </div>
                                       </div>

                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email"  name="email" value="{{ old('email') }}" required autocomplete="username" placeholder=" ">
                                             <label>Email</label>
                                             @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>                                                 
                                             @endif 
                                          </div>
                                       </div>

                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password"  name="password" value="{{ old('password') }}" required autocomplete="username" placeholder=" ">
                                             <label>Password</label>
                                             @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>                                                 
                                             @endif 
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control"  type="password"
                                             name="password_confirmation" required autocomplete="new-password" placeholder=" ">
                                             <label>Confirm Password</label>
                                          </div>
                                       </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sign Up</button>
                                    <p class="mt-3">
                                       Already have an Account <a href="{{ route('login') }}" class="text-primary">Sign In</a>
                                    </p>
                                 </form>
                              </div>
                           {{-- </div> --}}
                           
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


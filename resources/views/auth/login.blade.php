<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Log In"])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="loading authentication-bg authentication-bg-pattern" onload="updateBranchName()">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="{{route('any', 'index')}}" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="77" style="padding-bottom: 5%;">
                                        </span>
                                    </a>

                                    <a href="{{route('any', 'index')}}" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="77" style="padding-bottom: 5%;">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password </p><!-- to access admin panel. -->
                            </div>


                            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>
                            <br>@endif
                            @if(session('success'))<div class=" alert alert-success">{{ session('success') }}
                            </div>
                            <br>@endif

                            @if (sizeof($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="mb-3" >
                                    <label for="branch" class="form-label" style="display: none;">Branch</label>
                                    <!-- <select name="branch" id="branch"  class="form-control" onchange="updateBranchName()">
                                    @foreach ($branch as $b)
                                        <option value="{{ $b->BranchCode }}" data-value="{{ $b->Address }}">{{ $b->BranchName }}</option>
                                    @endforeach
                                    </select> -->
                                   
                                    @if ($branch->isNotEmpty())
                                        @php
                                            $b = $branch->first();
                                        @endphp
                                        <input type="hidden" id="branch" name="branch" class="form-control" readonly value="{{ $b->BranchCode }}" data-value="{{ $b->Address }}">
                                    @endif


                                    <input type="hidden" id="branchname" name="branchname" class="form-control" readonly>
                                    <input type="hidden" id="branchaddress" name="branchaddress" class="form-control" readonly>
                                    
                                </div>

                                <div class="mb-3 ">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge password-wrapper">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                        <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                                        </div>
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>

                            <!-- <div class="text-center">
                                <h5 class="mt-3 text-muted">Sign in with</h5>
                                <ul class="social-list list-inline mt-3 mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div> -->

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="{{route('password.request')}}" class="text-white-50 ms-1">Forgot your password?</a></p>
                            <p class="text-white-50">Don't have an account? <a href="{{route('second', ['auth', 'register'])}}" class="text-white ms-1"><b>Sign Up</b></a></p>
                        </div> 
                    </div> -->
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  
    <footer class="footer footer-alt">
        2015 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; POS
    </footer>

    @include('layouts.shared/footer-script')

</body>

</html>
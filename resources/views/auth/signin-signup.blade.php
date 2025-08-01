<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Auth Pages | Create Account | Sign In"])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
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
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="p-sm-3">
                                        <!-- title-->
                                        <h4 class="mt-0">Sign In</h4>
                                        <p class="text-muted mb-4">Enter your email address and password to access account.</p>
                                        <form action="#">
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">Email address</label>
                                                <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                            </div>

                                            <div class="mb-3">
                                                <a href="{{route('second', ['auth', 'recoverpw'])}}" class="text-muted font-13 float-end">Forgot your password?</a>
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary btn-sm float-sm-end" type="submit"> Log In </button>
                                                <div class="form-check pt-1">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div> <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-sm-3">
                                        <h4 class="mt-3 mt-lg-0">Free Sign Up</h4>
                                        <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute</p>

                                        <form action="#">
                                            <div class="mb-3">
                                                <label for="fullname" class="form-label">Full Name</label>
                                                <input class="form-control" type="text" id="fullname" placeholder="Enter your name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="emailaddress2" class="form-label">Email address</label>
                                                <input class="form-control" type="email" id="emailaddress2" required placeholder="Enter your email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password2" class="form-label">Password</label>
                                                <input class="form-control" type="password" required id="password2" placeholder="Enter your password">
                                            </div>
                                            <div class="mb-0">
                                                <button class="btn btn-success btn-sm float-sm-end" type="submit"> Sign Up </button>
                                                <div class="form-check pt-1">
                                                    <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                                    <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div> <!-- end col -->
                            </div>
                            <!-- end row-->

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2015 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; POS
    </footer>

    @include('layouts.shared/footer-script')

</body>

</html>
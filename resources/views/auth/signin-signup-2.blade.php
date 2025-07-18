<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Auth Pages | Create Account | Sign In"])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>

<body class="loading auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
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

                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#tab-login" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Log In
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-signup" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Sign Up
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tab-login">
                            <p class="text-muted mb-3">Enter your email address and password to access account.</p>

                            <!-- form -->
                            <form action="#">
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <a href="{{route('second', ['auth', 'recoverpw-2'])}}" class="text-muted float-end"><small>Forgot your password?</small></a>
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit">Log In </button>
                                </div>
                                <!-- social-->
                                <div class="text-center mt-4">
                                    <p class="text-muted font-16">Sign in with</p>
                                    <ul class="social-list list-inline mt-3">
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
                                </div>
                            </form>
                            <!-- end form-->
                        </div>
                        <div class="tab-pane" id="tab-signup">
                            <p class="text-muted mb-3">Don't have an account? Create your account, it takes less than a minute</p>

                            <!-- form -->
                            <form action="#">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input class="form-control" type="text" id="fullname" placeholder="Enter your name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress2" required placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required id="password2" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                        <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit"> Sign Up </button>
                                </div>
                                <!-- social-->
                                <div class="text-center mt-4">
                                    <p class="text-muted font-16">Sign up with</p>
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
                                </div>
                            </form>
                            <!-- end form-->
                        </div>
                    </div>

                    <footer class="footer footer-alt">
                        <p class="text-muted">2015 - <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; UBold theme by <a href="javascript: void(0);" class="text-muted">Coderthemes</a> </p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3 text-white">I love the color!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> I've been using your theme from the previous developer for our web app, once I knew new version is out, I immediately bought with no hesitation. Great themes, good documentation with lots of customization available and sample app that really fit our need. <i class="mdi mdi-format-quote-close"></i>
                </p>
                <h5 class="text-white">
                    - Fadlisaad (Ubold Admin User)
                </h5>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    @include('layouts.shared/footer-script')

</body>

</html>
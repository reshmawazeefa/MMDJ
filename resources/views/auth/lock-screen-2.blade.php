<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Lock Screen"])
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

                    <div class="text-center w-75 m-auto">
                        <img src="{{asset('assets/images/users/user-1.jpg')}}" height="88" alt="user-image" class="rounded-circle shadow">
                        <h4 class="text-dark-50 text-center mt-3">Hi ! Geneva </h4>
                        <p class="text-muted mb-4">Enter your password to access the admin.</p>
                    </div>


                    <form action="#">

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                        </div>

                        <div class="text-center d-grid">
                            <button class="btn btn-primary" type="submit"> Log In </button>
                        </div>

                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Not you? return <a href="{{route('second', ['auth', 'login-2'])}}" class="text-muted ms-1"><b>Sign In</b></a></p>
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
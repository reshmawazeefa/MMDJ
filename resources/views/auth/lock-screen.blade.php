<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Lock Screen"])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])


</head>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
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

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Not you? return <a href="{{route('second', ['auth', 'login'])}}" class="text-white ms-1"><b>Sign In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

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
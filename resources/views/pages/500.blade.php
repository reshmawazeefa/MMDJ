<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.shared/title-meta', ['title' => "Error Page | 500 | Internal Server Error"])

    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

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

                            <div class="text-center mt-4">
                                <h1 class="text-error">500</h1>
                                <h3 class="mt-3 mb-2">Internal Server Error</h3>
                                <p class="text-muted mb-3">Why not try refreshing your page? or you can contact <a href="" class="text-dark"><b>Support</b></a></p>

                                <a href="{{route('any', 'index')}}" class="btn btn-success waves-effect waves-light">Back to Home</a>
                            </div>

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
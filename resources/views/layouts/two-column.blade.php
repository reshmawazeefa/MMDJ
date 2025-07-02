<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])
    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>

<body class="loading" data-layout-mode="two-column" data-layout='{"mode": "{{$theme ?? "light" }}", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "{{$theme ?? "light" }}", "size": "default", "showuser": false}, "topbar": {"color": "{{$theme ?? "light" }}"}, "showRightSidebarOnPageLoad": true}' @yield('body-extra')></body>
<!-- Begin page -->
<div id="wrapper">
    @include('layouts.shared/topbar')

    @include('layouts.shared.two-column-sidebar')

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            @yield('content')
        </div>
        <!-- content -->

        @include('layouts.shared/footer')

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

@include('layouts.shared/right-sidebar')

@include('layouts.shared/footer-script')

</body>

</html>
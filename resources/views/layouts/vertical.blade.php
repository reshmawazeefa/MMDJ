<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])

    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>


<body class="loading" data-layout='{"mode": "{{$theme ?? "light" }}", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "{{$theme ?? "light" }}", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}' @yield('body-extra')>
    <!-- Begin page -->
    <div id="wrapper">
        @include('layouts.shared/topbar')

        @include('layouts.shared/left-sidebar')

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

    <!-- modal -->
    <div id="deletemodal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-4 modal-delete">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-warning"></i>
                            <h4 class="mt-2">Do you really want to delete?</h4>
                            <input type="hidden" id="delete-hidden" value="">
                            <button type="button" id="confirm-cancel" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="confirm-delete" data-token="{{ csrf_token() }}" class="btn btn-primary" data-href="">Yes, delete it!</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    <!-- modal -->
    @include('layouts.shared/footer-script')
</body>

</html>
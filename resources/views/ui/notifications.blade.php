@extends('layouts.vertical', ["page_title"=> "Notifications"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/jquery-toast-plugin/jquery-toast-plugin.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
@endsection

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UI</a></li>
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>
                <h4 class="page-title">Alerts & Notifications</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Bootstrap Toasts</h4>
                    <p class="text-muted">Push notifications to your visitors with a toast, a lightweight and easily customizable alert message.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-2">Basic</h5>
                            <p class="text-muted">Toasts are as flexible as you need and have very little required markup. At a minimum, we
                                require a single element to contain your “toasted” content and strongly encourage a dismiss button.</p>
                            <div class="p-3">
                                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-toggle="toast">
                                    <div class="toast-header">
                                        <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                        <strong class="me-auto">UBold</strong>
                                        <small>11 mins ago</small>
                                        <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        Hello, world! This is a toast message.
                                    </div>
                                </div>
                                <!--end toast-->

                            </div>
                        </div> <!-- end col-->
                        <div class="col-md-6">
                            <h5 class="mb-2">Translucent</h5>
                            <p class="text-muted">Toasts are slightly translucent, too, so they blend over whatever they might appear over.
                                For browsers that support the backdrop-filter CSS property, we’ll also attempt to blur the elements under a toast.</p>

                            <div class="p-3 bg-light">
                                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-toggle="toast">
                                    <div class="toast-header">
                                        <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                        <strong class="me-auto">UBold</strong>
                                        <small>11 mins ago</small>
                                        <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        Hello, world! This is a toast message.
                                    </div>
                                </div>
                                <!--end toast-->
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                    <div class="row">
                        <div class="col-md-6 mt-4">
                            <h5 class="mb-2">Stacking</h5>
                            <p class="text-muted">When you have multiple toasts, we default to vertiaclly stacking them in a readable manner.</p>
                            <div class="p-3">
                                <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
                                    <!-- Position it -->
                                    <div class="toast-container" style="position: absolute; top: 0; right: 0;">

                                        <!-- Then put toasts within -->
                                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-toggle="toast">
                                            <div class="toast-header">
                                                <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                                <strong class="me-auto">UBold</strong>
                                                <small class="text-muted">just now</small>
                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">
                                                See? Just like this.
                                            </div>
                                        </div>
                                        <!--end toast-->

                                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-toggle="toast">
                                            <div class="toast-header">
                                                <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                                <strong class="me-auto">UBold</strong>
                                                <small class="text-muted">2 seconds ago</small>
                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">
                                                Heads up, toasts will stack automatically
                                            </div>
                                        </div>
                                        <!--end toast-->
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-md-6 mt-4">
                            <h5 class="mb-2">Placement</h5>
                            <p class="text-muted">Place toasts with custom CSS as you need them. The top right is often used for
                                notifications, as is the top middle. If you’re only ever going to show one toast at a time, put the positioning
                                styles right on the <code>.toast</code>.</p>
                            <div class="p-3">
                                <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">

                                    <!-- Then put toasts within -->
                                    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-toggle="toast">
                                        <div class="toast-header">
                                            <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                            <strong class="me-auto">UBold</strong>
                                            <small>11 mins ago</small>
                                            <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                        <div class="toast-body">
                                            Hello, world! This is a toast message.
                                        </div>
                                    </div>
                                    <!--end toast-->
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Custom content</h4>
                    <p class="text-muted">Alternatively, you can also add additional controls and components to toasts.</p>
                    <div class="toast fade show d-flex align-items-center mt-4" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                        </div>
                        <button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>

                    <div class="toast fade show d-flex align-items-center text-white bg-primary border-0 mt-4" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>

                    <div class="toast fade show mt-4" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                            <div class="mt-2 pt-2 border-top">
                                <button type="button" class="btn btn-primary btn-sm">Take action</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                            </div>
                        </div>
                    </div>

                    <div class="toast fade show text-white bg-primary mt-4" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                            <div class="mt-2 pt-2 border-top">
                                <button type="button" class="btn btn-light btn-sm">Take action</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                            </div>
                        </div>
                    </div>
                    <!--end toast-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Placement</h4>
                    <p class="text-muted">Place toasts with custom CSS as you need them. The top right is often used for
                        notifications, as is the top middle. If you’re only ever going to show one toast at a time, put the
                        positioning styles right on the <code>.toast</code>.</p>
                    <form class="mt-4">
                        <div class="mb-3">
                            <label for="selectToastPlacement">Toast placement</label>
                            <select class="form-select mt-2" id="selectToastPlacement">
                                <option value="" selected>Select a position...</option>
                                <option value="top-0 start-0">Top left</option>
                                <option value="top-0 start-50 translate-middle-x">Top center</option>
                                <option value="top-0 end-0">Top right</option>
                                <option value="top-50 start-0 translate-middle-y">Middle left</option>
                                <option value="top-50 start-50 translate-middle">Middle center</option>
                                <option value="top-50 end-0 translate-middle-y">Middle right</option>
                                <option value="bottom-0 start-0">Bottom left</option>
                                <option value="bottom-0 start-50 translate-middle-x">Bottom center</option>
                                <option value="bottom-0 end-0">Bottom right</option>
                            </select>
                        </div>
                    </form>
                    <div aria-live="polite" aria-atomic="true" class="bg-light position-relative bd-example-toasts" style="min-height: 290px">
                        <div class="toast-container position-absolute p-3" id="toastPlacement">
                            <div class="toast fade show">
                                <div class="toast-header">
                                    <img src="{{asset('assets/images/logo-light.png')}}" alt="brand-logo" height="12" class="me-1" />
                                    <strong class="me-auto">UBold</strong>
                                    <small>11 mins ago</small>
                                </div>
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                            </div>
                        </div>
                        <!--end toast-->
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Default Alert</h4>
                    <p class="sub-header">
                        Alerts are available for any length of text, as well as an optional dismiss button. For proper styling, use one of the eight
                        <strong>required</strong> contextual classes (e.g., <code>.alert-success</code>).
                    </p>

                    <div class="alert alert-primary" role="alert">
                        This is a <strong>primary</strong> alert—check it out!
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        This is a <strong>secondary</strong> alert—check it out!
                    </div>
                    <div class="alert alert-success" role="alert">
                        <i class="mdi mdi-check-all me-2"></i> This is a <strong>success</strong> alert—check it out!
                    </div>
                    <div class="alert alert-danger" role="alert">
                        <i class="mdi mdi-block-helper me-2"></i> This is a <strong>danger</strong> alert—check it out!
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <i class="mdi mdi-alert-outline me-2"></i> This is a <strong>warning</strong> alert—check it out!
                    </div>
                    <div class="alert alert-info" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i> A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                    </div>
                    <div class="alert alert-light" role="alert">
                        A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                    </div>
                    <div class="alert alert-dark mb-0" role="alert">
                        A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Dismissing Alerts</h4>
                    <p class="sub-header">
                        Add a dismiss button and the <code>.alert-dismissible</code> class, which adds extra padding
                        to the right of the alert and positions the <code>.close</code> button.
                    </p>

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a primary alert—check it out!
                    </div>
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a secondary alert—check it out!
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a success alert—check it out!
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a danger alert—check it out!
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a warning alert—check it out!
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a info alert—check it out!
                    </div>
                    <div class="alert alert-light alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a light alert—check it out!
                    </div>
                    <div class="alert alert-dark alert-dismissible fade show mb-0" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a dark alert—check it out!
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Custom Background Alert</h4>
                    <p class="sub-header">
                        Use <code>.bg-*</code>,<code>.border-0</code> classes.
                    </p>

                    <div class="alert alert-primary bg-primary text-white border-0" role="alert">
                        This is a <strong>primary</strong> alert—check it out!
                    </div>
                    <div class="alert alert-secondary bg-secondary text-white border-0" role="alert">
                        This is a <strong>secondary</strong> alert—check it out!
                    </div>
                    <div class="alert alert-success bg-success text-white border-0" role="alert">
                        This is a <strong>success</strong> alert—check it out!
                    </div>
                    <div class="alert alert-danger bg-danger text-white border-0" role="alert">
                        This is a <strong>danger</strong> alert—check it out!
                    </div>
                    <div class="alert alert-warning bg-warning text-white border-0" role="alert">
                        This is a <strong>warning</strong> alert—check it out!
                    </div>
                    <div class="alert alert-info bg-info text-white border-0" role="alert">
                        This is a <strong>info</strong> alert—check it out!
                    </div>
                    <div class="alert alert-light bg-light text-dark border-0" role="alert">
                        This is a <strong>light</strong> alert—check it out!
                    </div>
                    <div class="alert alert-dark bg-dark text-light border-0 mb-0" role="alert">
                        This is a <strong>dark</strong> alert—check it out!
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Dismissing Custom Background Alert</h4>
                    <p class="sub-header">
                        Use <code>.bg-*</code>,<code>.border-0</code> classes.
                    </p>

                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a primary alert—check it out!
                    </div>
                    <div class="alert alert-secondary alert-dismissible bg-secondary text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a secondary alert—check it out!
                    </div>
                    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a success alert—check it out!
                    </div>
                    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a danger alert—check it out!
                    </div>
                    <div class="alert alert-warning alert-dismissible bg-warning text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a warning alert—check it out!
                    </div>
                    <div class="alert alert-info alert-dismissible bg-info text-white border-0 fade show" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a info alert—check it out!
                    </div>
                    <div class="alert alert-light alert-dismissible bg-light text-dark border-0 fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a light alert—check it out!
                    </div>
                    <div class="alert alert-dark alert-dismissible bg-dark text-light border-0 fade show mb-0" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        This is a dark alert—check it out!
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width:50%;">Jquery Toast</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Info Example</td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm" id="toastr-one">Click me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Warning Example</td>
                                <td>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm" id="toastr-two">Click me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Success Example</td>
                                <td>
                                    <button type="button" class="btn btn-success waves-effect waves-light btn-sm" id="toastr-three">Click me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Danger Example</td>
                                <td>
                                    <button type="button" class="btn btn-danger waves-light waves-effect btn-sm" id="toastr-four">Click me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>The text can be an array</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-five">Click
                                        me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Put some HTML in the text</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-six">Click
                                        me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Making them sticky</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-seven">Click
                                        me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Fade transitions</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-eight">Click
                                        me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Slide up and down transitions</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-nine">Click
                                        me</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Simple show from and hide to corner transition</td>
                                <td>
                                    <button type="button" class="btn btn-light waves-effect btn-sm" id="toastr-ten">Click
                                        me</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/jquery-toast-plugin/jquery-toast-plugin.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/toastr.init.js')}}"></script>
<!-- end demo js-->
@endsection
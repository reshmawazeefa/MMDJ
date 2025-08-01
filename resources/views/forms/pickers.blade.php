@extends('layouts.vertical', ["page_title"=> "Pickers"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/spectrum-colorpicker2/spectrum-colorpicker2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/clockpicker/clockpicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Pickers</li>
                    </ol>
                </div>
                <h4 class="page-title">Form Pickers</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Flatpickr - Date picker</h4>
                    <p class="sub-header">A lightweight and powerful datetimepicker</p>

                    <div class="mb-3">
                        <label class="form-label">Basic</label>
                        <input type="text" id="basic-datepicker" class="form-control" placeholder="Basic datepicker">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date & Time</label>
                        <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Human-friendly Dates</label>
                        <input type="text" id="humanfd-datepicker" class="form-control" placeholder="October 9, 2018">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">MinDate and MaxDate</label>
                        <input type="text" id="minmax-datepicker" class="form-control" placeholder="mindate - maxdate">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Disabling dates</label>
                        <input type="text" id="disable-datepicker" class="form-control" placeholder="Disabling dates">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Selecting multiple dates</label>
                        <input type="text" id="multiple-datepicker" class="form-control" placeholder="Multiple dates">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Selecting multiple dates - Conjunction</label>
                        <input type="text" id="conjunction-datepicker" class="form-control" placeholder="2018-10-10 :: 2018-10-11">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Range Calendar</label>
                        <input type="text" id="range-datepicker" class="form-control" placeholder="2018-10-03 to 2018-10-10">
                    </div>

                    <div>
                        <label class="form-label">Inline Calendar</label>
                        <input type="text" id="inline-datepicker" class="form-control" placeholder="Inline calendar">
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Flatpickr - Time Picker</h4>
                    <p class="sub-header">A lightweight and powerful datetimepicker</p>

                    <div class="mb-3">
                        <label class="form-label">Basic</label>
                        <input type="text" id="basic-timepicker" class="form-control" placeholder="Basic timepicker">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">24-hour Time Picker</label>
                        <input type="text" id="24hours-timepicker" class="form-control" placeholder="16:21">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Time Picker w/ Limits</label>
                        <input type="text" id="minmax-timepicker" class="form-control" placeholder="Limits">
                    </div>

                    <div>
                        <label class="form-label">Preloading Time</label>
                        <input type="text" id="preloading-timepicker" class="form-control" placeholder="Pick a time">
                    </div>
                </div>
            </div> <!-- end card-->


            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Colorpicker</h4>
                    <p class="sub-header">Examples of Spectrum Colorpicker.</p>

                    <div class="mb-3">
                        <label class="form-label">Simple input field</label>
                        <input type="text" class="form-control" id="colorpicker-default" value="#4a81d4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Show Alpha</label>
                        <input type="text" class="form-control" id="colorpicker-showalpha" value="rgba(26, 188, 156, 0.6)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Show Palette Only</label>
                        <input type="text" class="form-control" id="colorpicker-showpaletteonly" value="#f1556c">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Toggle Palette Only</label>
                        <input type="text" class="form-control" id="colorpicker-togglepaletteonly" value="#f7b84b">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Show Initial</label>
                        <input type="text" class="form-control" id="colorpicker-showintial" value="#f672a7">
                    </div>
                    <div>
                        <label class="form-label">Show Input And Initial</label>
                        <input type="text" class="form-control" id="colorpicker-showinput-intial" value="#4fc6e1">
                    </div>
                </div>
            </div> <!-- end card-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Clock Picker</h4>
                    <p class="sub-header">A clock-style timepicker for Bootstrap.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Default Clock Picker</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control" value="09:30">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Auto close</label>
                                <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                    <input type="text" class="form-control" value="13:14">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                        </div> <!-- end col-->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Now time</label>
                                <div class="input-group">
                                    <input class="form-control" id="single-input" type="text" value="" placeholder="Now">
                                    <button type="button" id="check-minutes" class="btn waves-effect waves-light btn-primary">Check the minutes</button>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Place at left, align the arrow to top </label>
                                <div class="input-group clockpicker" data-placement="top" data-align="top">
                                    <input type="text" class="form-control" value="13:14">
                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Bootstrap Datepicker</h4>
                    <p class="text-muted font-14">
                        Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap style.
                    </p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Date Picker</label>
                                <input type="text" class="form-control" data-provide="datepicker">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Date View</label>
                                <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Multi Datepicker</label>
                                <input type="text" class="form-control" data-provide="datepicker" data-date-multidate="true">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Autoclose</label>
                                <input type="text" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Month View</label>
                                <input type="text" class="form-control" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Year View</label>
                                <input type="text" class="form-control" data-provide="datepicker" data-date-min-view-mode="2">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Inline Datepicker</label>
                                <div data-provide="datepicker-inline"></div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>
<!-- end demo js-->
@endsection
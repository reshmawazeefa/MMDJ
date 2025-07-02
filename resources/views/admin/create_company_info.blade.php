@extends('layouts.vertical', ["page_title"=> "Company Informations Add"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

<style>
        /* In order to place the tracking correctly */
        canvas.drawing, canvas.drawingBuffer {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
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
                        <li class="breadcrumb-item">
                            <a href="#">Company Informations</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Company Informations</h4>

                @if(!empty($errors->all()))
                <p class="alert alert-danger error">
                    @foreach($errors->all() as $error)
                      🔸 {{$error}} 
                    @endforeach
                </p>
                @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success newStyle">
                            {{ $message }}
                        </div>
                    @endif

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
            <form id="products-submit" method="post" class="parsley-examples" action="{{ route('company.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="card-body body-style">
        <div class="row mb-3">
            {{-- Company Name --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Company Name <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="c_name" class="form-control" value="{{ old('c_name', $company->c_name ?? '') }}" placeholder="Company Name" required>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="email" name="c_email" class="form-control" value="{{ old('c_email', $company->c_email ?? '') }}" placeholder="Email" required>
                    </div>
                </div>
            </div>

            {{-- Phone1 --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Phone <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="c_phone" class="form-control" value="{{ old('c_phone', $company->c_phone ?? '') }}" placeholder="Phone" title="Please enter a valid phone number." >
                    </div>
                </div>
            </div>

             {{-- Phone2 --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Alter Phone <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="c_phone1" class="form-control" value="{{ old('c_phone1', $company->c_phone1 ?? '') }}" placeholder="Phone" title="Please enter a valid phone number." >
                    </div>
                </div>
            </div>

            {{-- Logo Upload --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Company Logo</label>
                    <div class="col-sm-7">
                        <input type="file" name="c_logo" class="form-control" >
                        @if(!empty($company->c_logo))
                            <div style="padding-top: 10px;">
                                <img src="{{ asset($company->c_logo) }}" width="80">
                            </div>
                        @endif
                        <small class="text-muted">Allowed: png Max: 2MB</small>
                    </div>
                </div>
            </div>

             <!-- <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Small Screen Logo </label>
                    <div class="col-sm-7">
                        <input type="file" name="cs_logo" class="form-control" required>
                        @if(!empty($company->cs_logo))
                            <div style="padding-top: 10px;">
                                <img src="{{ asset($company->cs_logo) }}" width="80">
                            </div>
                        @endif
                        <small class="text-muted">Allowed: png Max: 2MB</small>
                    </div>
                </div>
            </div> -->

            {{-- Favicon Upload --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Favicon</label>
                    <div class="col-sm-7">
                        <input type="file" name="c_fav_icon" class="form-control" accept=".ico, .png">
                        @if(!empty($company->c_fav_icon))
                            <div style="padding-top: 10px;">
                                <img src="{{ asset($company->c_fav_icon) }}" width="30">
                            </div>
                        @endif
                        <small class="text-muted">Allowed: png, ico. Max: 512KB</small>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Address <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <textarea name="c_address" class="form-control" required>{{ old('c_address', $company->c_address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Currency Symbol <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                    <input type="text" name="c_crncy_code" class="form-control" value="{{ old('c_crncy_code', $company->c_crncy_code ?? '') }}" placeholder="Currency Code" required>
                    </div>
                </div>
            </div>
           

            {{-- Submit Buttons --}}
            <div class="col-lg-12 text-right mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <!-- <button type="reset" class="btn btn-secondary">Clear</button>
                <button type="button" class="btn btn-outline-dark" onclick="window.history.back();">Cancel</button> -->
            </div>
        </div>
    </div>
</form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

    @include('includes.modal_popups')
</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<!-- end demo js-->
<!-- demo app -->
<!-- end demo js-->
<script>
    $(document).ready(function() {
        const photoInp = $("#photo");
        photoInp.change(function (e) {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
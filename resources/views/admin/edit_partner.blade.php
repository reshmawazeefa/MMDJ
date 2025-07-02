@extends('layouts.vertical', ["page_title"=> "Partner | Edit"])

@section('content')
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/partners')}}">Partners</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Partner</h4>
                @if(!empty($errors->all()))
                    <p class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      🔸 {{$error}} 
                    @endforeach
                    </p>
                    @endif
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                    <!-- <h4 class="header-title">Partner Form</h4> -->
                   
                    <form role="form" class="parsley-examples" method="post" action="{{url('admin/partners/'.$partner->id)}}">
                        {{csrf_field()}}
                        {{ method_field('PATCH') }}
                        <div class="card-body body-style">

                        <div class="row mb-2">

                        <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-4 col-form-label">Name<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" name="name" value="{{old('name') ? old('name'):$partner->name }}" required class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Partner Code<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" readonly name="partner_code" value="{{old('partner_code') ? old('partner_code'):$partner->partner_code }}" placeholder="Partner Code" required class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="number" min="10" name="phone" value="{{old('phone') ? old('phone'):$partner->phone }}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Email</label>
                            <div class="col-7">
                                <input type="email" name="email" value="{{old('email') ? old('email'):$partner->email}}" placeholder="Email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Partner Type <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <select name="partner_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option @if($partner->partner_type == 'Contractor') selected @endif value="Contractor">Contractor</option>
                                    <option @if($partner->partner_type == 'Engineer') selected @endif  value="Engineer">Engineer</option>
                                    <option @if($partner->partner_type == 'Sales Executive') selected @endif  value="Sales Executive">Sales Executive</option>
                                    <option @if($partner->partner_type == 'Other') selected @endif  value="Other">Other</option>
                                <select>
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Designation</label>
                            <div class="col-7">
                                <input type="text" name="designation" value="{{old('designation') ? old('designation'):$partner->designation }}" placeholder="Designation" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Alt Contact Number</label>
                            <div class="col-7">
                                <input type="text" name="alt_phone" value="{{old('alt_phone') ? old('alt_phone'):$partner->alt_phone}}" placeholder="Alt Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Address</label>
                            <div class="col-7">
                                <textarea class="form-control" name="address" rows="5" spellcheck="false">{{old('address') ? old('address'):$partner->address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Description</label>
                            <div class="col-7">
                                <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description') ? old('description'):$partner->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                <a href="{{url('admin/partners')}}" type="button" class="btn btn-secondary waves-effect">Cancel</a>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div> <!-- end card -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<!-- end demo js-->
@endsection
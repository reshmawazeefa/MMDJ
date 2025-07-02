@extends('layouts.vertical', ["page_title"=> "Partner | Add"])

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
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Partner</h4>
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
                   
                    <form role="form" class="parsley-examples" method="post" action="{{url('admin/partners')}}">
                        {{csrf_field()}}
                        <div class="card-body body-style">
                        <div class="row mb-2">

                        <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-4 col-form-label">Name<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" name="name" value="{{old('name')}}" required class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Partner Code<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" readonly name="partner_code" id="partner_code" value="{{old('partner_code')}}" placeholder="Partner Code" required class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="number" name="phone" min="10" value="{{old('phone')}}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Email</label>
                            <div class="col-7">
                                <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Partner Type <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <select name="partner_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Contractor">Contractor</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Sales Executive">Sales Executive</option>
                                    <option value="Other">Other</option>
                                <select>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Designation</label>
                            <div class="col-7">
                                <input type="text" name="designation" value="{{old('designation')}}" placeholder="Designation" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Alt Contact Number</label>
                            <div class="col-7">
                                <input type="text" name="alt_phone" value="{{old('alt_phone')}}" placeholder="Alt Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Address</label>
                            <div class="col-7">
                                <textarea class="form-control" name="address" rows="5" spellcheck="false">{{old('address')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Description</label>
                            <div class="col-7">
                                <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description')}}</textarea>
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

<script>
    $(document).ready(function() {
        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'partner'},
           success:function(data){
              $('#partner_code').val(data);
           }
        });
    });
</script>
@endsection
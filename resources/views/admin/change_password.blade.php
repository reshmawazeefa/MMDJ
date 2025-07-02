@extends('layouts.vertical', ["page_title"=> "Customer | Add"])

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/customers')}}">Profile</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <h4 class="page-title">Change Password</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row"><div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Change Password Form</h4>
                    @if(!empty($errors->all()))
                        <p class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{$error}}
                        @endforeach
                        </p>
                    @endif
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" class="parsley-examples" method="post">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-4 col-form-label">Email</label>
                            <div class="col-7">
                                <input type="text" name="name" readonly value="{{Auth::user()->email}}" class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hori-pass1" class="col-4 col-form-label">Current Password<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="password" name="current_password" placeholder="Current Password" required class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hori-pass2" class="col-4 col-form-label">New Password <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="password" name="new_password" placeholder="New Password" required class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hori-pass2" class="col-4 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="password" name="new_password_confirmation" placeholder="Confirm Password" required class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                <button type="reset" class="btn btn-secondary waves-effect">Reset</button>
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
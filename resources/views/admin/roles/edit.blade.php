@extends('layouts.vertical', ["page_title"=> "Customer | Add"])

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('admin/roles')}}">Roles</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
            <h4 class="page-title">Edit Role</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row"><div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Role Form</h4>
                    @if(!empty($errors->all()))
                    <p class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    </p>
                    @endif
                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-4 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-7">
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required' => 'required')) !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-4 col-form-label">Permission<span class="text-danger">*</span></label>
                        <div class="col-7">
                        @foreach($permission as $value)
                            <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                            {{ $value->name }}</label>
                        <br/>
                        @endforeach
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                <a href="{{url('admin/customers')}}"><button type="button" class="btn btn-secondary waves-effect">Cancel</button></a>
                            </div>
                        </div>
                    {!! Form::close() !!}
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
@extends('layouts.vertical', ["page_title"=> "User | List"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Users</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
 @if ($message = Session::get('success'))
            <div class="alert alert-success newStyle">
           {{ $message }}
            </div>
            @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
           
                <div class="card-body body-style userStyle tableMStyle table-spcl">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <div class="text-sm-end mt-2 mt-sm-0 addUser">
                            <a href="{{url('admin/users/create')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add User</a>
                        </div>
                    </div>
                </div>
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <!-- <th>Approver 1</th>
                                <th>Approver 2</th> -->
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($users as $cust)
                            <tr>
                                <td>{{$cust->name}}</td>
                                <td>{{$cust->email}}</td>
                                <td>{{$cust->phone}}</td>
                                <td>@if($cust->role == 'Manager'){{'Salesman'}} @else {{$cust->role}} @endif</td>
                                <!-- <td>@if($cust->approver_1) {{$cust->approver_1->name}} @endif</td>
                                <td>@if($cust->approver_2) {{$cust->approver_2->name}} @endif</td> -->
                                <!-- <td>{{$cust->getRoleNames()->first()}}</td> -->
                                <td><a class="btn btn-info" href="{{url('admin/users/'.$cust->id.'/edit')}}"><i class="mdi mdi-square-edit-outline"></i>Edit</a>
                                <form action="{{ url('admin/users/' . $cust->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

</div> <!-- container -->

@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<!-- end demo js-->
@endsection
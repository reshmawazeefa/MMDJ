@extends('layouts.vertical', ["page_title"=> "Category | List"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Categories</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Categories</h4>
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
                <div class="card-body body-style tableMStyle table-spcl without-button">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category code</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{$cat->categoryName}}</td>
                                <td>{{$cat->categoryCode}}</td>
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
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<!-- end demo js-->
@endsection
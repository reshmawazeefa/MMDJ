@extends('layouts.vertical', ["page_title"=> "Category Attribute | List"])
@php
    use Illuminate\Support\Str;
@endphp

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Category Attributes</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Category Attribute</h4>
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
                <div class="card-body body-style tableMStyle table-spcl without-button attrOnly">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100" >
                        <thead>
                            <tr>
                                <th style="width: 10%;"></th>
                                <th style="width: 18%;">Category code</th>
                                <th style="width: 18%;">SubCategory</th>
                                <th style="width: 18%;">Type</th>
                                <th style="width: 18%;">Brand</th>
                                <th style="width: 18%;">Size</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach($cat_attributes as $cat)
                            <tr class="parent-row" 
                                data-color="{{$cat->color}}" 
                                data-finish="{{$cat->finish}}" 
                                data-thickness="{{$cat->thickness}}">
                                <td class="details-control">
                                    <i class="mdi mdi-plus-circle" style="cursor: pointer;"></i>
                                </td>
                                <td>{{$cat->categoryCode}}</td>
                                <td>{{$cat->subCateg}}</td>
                                <td>{{$cat->type}}</td>
                                <td>{{$cat->brand}}</td>
                                <td>{{$cat->size}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <style>
                        #basic-datatable th, #basic-datatable td {
                            width: 16.66%;
                            text-align: left;
                        }
                        #basic-datatable th:first-child, #basic-datatable td:first-child {
                            width: 5%;
                            text-align: left;
                        }
                        #basic-datatable_wrapper #basic-datatable .table{
                        margin-bottom:0px;
                        background-color: #f7f7fe;
                        }

                        #basic-datatable_wrapper #basic-datatable .table tr:last-child
                        {
                            border-bottom-width: 0px;
                            border:1px solid transparent;
                        }
                        td[colspan="6"] {
                            padding: 0px;
                        }





                        
                        #basic-datatable_wrapper #basic-datatable .parent-row td{
                        padding0px!important;
                        }


                    </style>

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

<script>
    $(document).ready(function() {

        if ($.fn.DataTable.isDataTable('#basic-datatable')) {
            $('#basic-datatable').DataTable().destroy();
        }

        var table = $('#basic-datatable').DataTable({
            "paging": true,  
            "pageLength": 10, 
            "ordering": true, 
            "columnDefs": [
                { "orderable": false, "targets": [0] }, 
                { "orderable": true, "targets": [1, 2, 3, 4, 5] } 
            ]
        });

        $('#basic-datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                $(this).find('i').removeClass('mdi-minus-circle').addClass('mdi-plus-circle');
            } else {
                var color = tr.data('color') || 'N/A';
                var finish = tr.data('finish') || 'N/A';
                var thickness = tr.data('thickness') || 'N/A';
               
                var detailsHtml = `<table class="table">
                    <tr><td><strong>Color : </strong> ${color}</td></tr>
                    <tr><td><strong>Finish : </strong> ${finish}</td></tr>
                    <tr><td><strong>Thickness : </strong> ${thickness}</td></tr>
                </table>`;
                row.child(detailsHtml).show();
                $(this).find('i').removeClass('mdi-plus-circle').addClass('mdi-minus-circle');
            }
        });
    });
</script>
@endsection
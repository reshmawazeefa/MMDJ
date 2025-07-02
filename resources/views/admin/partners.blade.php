@extends('layouts.vertical', ["page_title"=> "Partner | List"])

@section('css')

@php
    use Illuminate\Support\Str;
@endphp



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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Partners</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Partners</h4>
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
                <div class="card-body body-style partnerStyle tableMStyle">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <!-- <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>-->
                    </div><!-- end col-->
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-2 mt-sm-0 addUser">
                            <a href="{{url('admin/partners/create')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add Partner</a>
                        </div>
                    </div>
                </div>
<table id="basic-datatable" class="table dt-responsive nowrap w-100" style="table-layout: fixed;">
    <thead>
        <tr>
            <th style="width: 10%;"></th>
            <th style="width: 18%;">Name</th>
            <th style="width: 18%;">Partner Code</th>
            <th style="width: 18%;">Contact Number</th>
            <th style="width: 18%;">Email</th>
            <th style="width: 18%;">Partner Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partners as $cust)
        <tr class="parent-row" 
            data-designation="{{$cust->designation}}" 
            data-address="{{$cust->address}}" 
            data-description="{{$cust->description}}" 
            data-alt_phone="{{$cust->alt_phone}}" 
            data-edit_id="{{url('admin/partners/'.$cust->id.'/edit')}}" >
            
            <td class="details-control">
                <i class="mdi mdi-plus-circle" style="cursor: pointer;"></i>
            </td>
            <td>{{ Str::limit($cust->name, 15, '...') }}</td>
            <td>{{ Str::limit($cust->partner_code, 15, '...') }}</td>
            <td>{{ Str::limit($cust->phone, 15, '...') }}</td>
            <td>{{ Str::limit($cust->email, 15, '...') }}</td>
            <td>{{ Str::limit($cust->partner_type, 15, '...') }}</td>
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
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<!-- end demo js-->
 <!-- <script>
$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#basic')) {
        $('#basic').DataTable().destroy();
    }

    // Reinitialize DataTable with existing data and without responsive mode
    $('#basic').DataTable({
        responsive: false, // Disable responsiveness
        scrollX: true, // Enable horizontal scrolling if needed
        //scrollY: '150px', // Maintain height
        autoWidth: false // Prevent automatic column width adjustments
    });
});

</script> -->
<!-- <script>
    $(document).ready(function() {
    $('#basic-datatable').DataTable({
        responsive: true,
        autoWidth: false,
        columnDefs: [
            { width: "10%", targets: 0 },
            { width: "18%", targets: 1 },
            { width: "18%", targets: 2 },
            { width: "18%", targets: 3 },
            { width: "18%", targets: 4 },
            { width: "18%", targets: 5 }
        ]
    });
});
</script> -->
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
                var designation = tr.data('designation') || 'N/A';
                var address = tr.data('address') || 'N/A';
                var description = tr.data('description') || 'N/A';
                var alt_phone = tr.data('alt_phone') || 'N/A';
                var edit_id = tr.data('edit_id') || 'N/A';

                var detailsHtml = `<table class="table">
                    <tr><td><strong>Alter Number : </strong> ${alt_phone}</td></tr>
                    <tr><td><strong>Designation : </strong> ${designation}</td></tr>
                    <tr><td><strong>Address : </strong> ${address}</td></tr>
                    <tr><td><strong>Description : </strong> ${description}</td></tr>
                    <tr><td><strong>Action : </strong> <a class="btn btn-info" href="${edit_id}"> <i class="mdi mdi-square-edit-outline"></i>Edit</a></td></tr>
                </table>`;

                row.child(detailsHtml).show();
                $(this).find('i').removeClass('mdi-plus-circle').addClass('mdi-minus-circle');
            }
        });
    });
</script>

@endsection
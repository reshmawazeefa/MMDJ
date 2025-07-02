@extends('layouts.vertical', ["page_title"=> "Customer | List"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customers | Suppliers </a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Customers | Suppliers </h4>
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
                            <a href="{{url('admin/customers/create')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add Customer | Supplier </a>
                        </div>
                    </div>
                </div>
                
                    <table id="server-datatable" class="table dt-responsive nowrap w-100" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Contact number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <!-- <th>Description</th> -->
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
<script>
  $(document).ready(function() {
    var url = "{{url('admin/customers')}}";
    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: url
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'type', name: 'type'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            // {data: 'description', name: 'description'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

$(document).on('click', '.deleteCustomer', function() {
    let customerId = $(this).data('id');
    let token = $('meta[name="csrf-token"]').attr('content'); // Fetch CSRF token
    var u = "{{url('admin/customers/close/')}}" + '/' + customerId;

    if (confirm("Are you sure you want to delete this customer?")) {
        $.ajax({
            url: u,
            type: "POST",  // Change to POST
            data: { _token: $(this).data("token")},
            success: function(response) {
                alert("Customer deleted successfully!");
                $('#server-datatable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert("Error deleting customer! Check console.");
                console.log(xhr.responseText);
            }
        });
    }
});


$(document).on("click", ".checkActive", function(e) {

    if (confirm('Are you sure you want to update the status of this customer?')) {
    var button = $(this);
    var url = "{{ url('admin/customer/status') }}"; // Laravel URL
    var id = button.data("id");
    var status = button.hasClass("btn-success") ? 0 : 1;

    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: { 
            _token: button.data("token"), 
            is_active: status, 
            id: id 
        },
        success: function(data) {
            if (data.success) {
                // Toggle button text and class based on the new status
                if (data.is_active == 1) {
                    button.text("Active").removeClass("btn-danger").addClass("btn-success");
                } else {
                    button.text("Deactive").removeClass("btn-success").addClass("btn-danger");
                }
                $('.con-quote').html(data.message);
            } else {
                alert(data.message);
            }
        },
        error: function() {
            alert("Error while updating status");
        }
    });

 }
});





</script>
@endsection
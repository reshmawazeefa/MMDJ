@extends('layouts.vertical', ["page_title"=> "Approval | List"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
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
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Custom Approval List</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Custom Approval List</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="row mb-2">
                <div class="col-sm-4">
                        <!-- <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>-->
                    </div><!-- end col-->
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <a href="{{url('admin/custom_quote')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add Quotation</a>
                        </div>
                    </div>
                    <form id="quotationSearchForm" class="form" method="POST" action="">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="customer" class="form-label">Customer</label>
                                        <select required name="customer" class="customerSelect form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="customer" class="form-label">Executive</label>
                                        <select required name="user" class="userSelect form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="from_date" class="form-label">From date</label>
                                        <input type="date" class="form-control" name="from_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="to_date" class="form-label">To date</label>
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div>
                                <!--<div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="to_date" class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="Open">Open</option>
                                            <option value="Approve">Approved</option>
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-lg-1 col-sm-6">
                                    <div class="me-3">
                                    <label for="customer" class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input id="quotationSearchSubmit" class="btn btn-info" type="submit" value="Search" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6">
                                    <div class="me-3">
                                    <label for="customer" class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input id="quotationSearchReset" class="btn btn-info" type="button" value="Reset" />
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col-->
                    </form>
                </div>
                    <table id="server-datatable" class="table dt-responsive nowrap w-100" style="font-size:0.775rem !important;">
                        <thead>
                            <tr>
                                <th>Doc Number</th>
                                <th class="all">Customer</th>
                                <th class="all">Date</th>
                                <th>Referral (Engineer)</th>
                                <th>Referral (Contrctor)</th>
                                <th>Referral (Agent)</th>
                                <th>Due Date</th>
                                <th>Price List</th>
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
<!-- modal -->
<div id="closemodal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2">Do you really want to close?</h4>
                    <input type="hidden" id="close-quot" value="">
                    <textarea class="form-control" id="cancel_reason" placeholder="Reason for closing"></textarea>
                    <button type="button" id="cancel-close" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-close" data-token="{{ csrf_token() }}" class="btn btn-primary" data-href="">Yes, close it!</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal --><!-- modal -->
<div id="approvemodal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body-approve p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2">Do you really want to approve the quotation?</h4>
                    <input type="hidden" id="approve-quot" value="">
                    <button type="button" id="cancel-approve" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-approve" data-token="{{ csrf_token() }}" class="btn btn-primary" data-href="">Continue</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal -->
<!-- modal --><!-- modal -->
<div id="infomodal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body-approve p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2 quotInfo"></h4>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- modal -->
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

   
<script type="text/javascript">
  $(document).ready(function() {
    var url = "{{url('admin/custom_approvals/'.$status)}}";
    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: url,
            data: function (d) {
                d.from_date = $('input[name="from_date"]').val(),
                d.to_date = $('input[name="to_date"]').val(),
                d.customer = $('select[name="customer"]').val()
                d.status = $('select[name="status"]').val()
                d.user = $('select[name="user"]').val()
            }
        },
        columns: [
            {data: 'DocNo', name: 'DocNo'},
            {data: 'customer', name: 'customer', orderable: false},
            {data: 'DocDate', name: 'DocDate'},
            {data: 'referral1', name: 'referral1', orderable: false},
            {data: 'referral2', name: 'referral2', orderable: false},
            {data: 'referral3', name: 'referral3', orderable: false},
            {data: 'DueDate', name: 'DueDate'},
            {data: 'PriceList', name: 'PriceList', orderable: false},
            {data: 'status_show', name: 'status_show', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ]
    });
    $(document).on('click', '#quotationSearchSubmit', function(e) {
        e.preventDefault();         
        table.ajax.url(url).load();
    });
    $("#quotationSearchReset").click(function(){
        $('input[name="from_date"]').val('');
        $('input[name="to_date"]').val('');
        $(".customerSelect").val('').trigger('change');
        $(".userSelect").val('').trigger('change');        
        $('select[name="status"]').val('Open');
        table.ajax.url(url).load();
    });
    
    $(".customerSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/customers') }}",
        type: 'POST',
                dataType: 'json',
                delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    q: params.term, // search term
                    page: params.page || 1
                };
                },
        processResults: function (data,params) {
            params.current_page = params.current_page || 1;
            return {
            results:  $.map(data.data, function (item) {
                    return {
                        text: item.name+'('+item.phone+')',
                        id: item.customer_code
                    }
                }),
                    /*  pagination: {
                        more: (params.current_page * 30) < data.total
                    } */
                    pagination: data.pagination
            };
        },
            autoWidth: false,
        cache: true
        },
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "By searching name,phone",
            allowClear: false,
    });
    
    $(".userSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/users') }}",
        type: 'POST',
                dataType: 'json',
                delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    q: params.term, // search term
                    page: params.page || 1
                };
                },
        processResults: function (data,params) {
            params.current_page = params.current_page || 1;
            return {
            results:  $.map(data.data, function (item) {
                    return {
                        text: item.name+'('+item.email+')',
                        id: item.id
                    }
                }),
                    /*  pagination: {
                        more: (params.current_page * 30) < data.total
                    } */
                    pagination: data.pagination
            };
        },
            autoWidth: false,
        cache: true
        },
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "By searching name,email",
            allowClear: false,
    });

    //$(".close-icon").on("click", function (event) {
        //alert("here");
        //var $button = $(event.target); alert($button[0].id);
        //$("#confirm-close").data("href", $(this).data("href"));
    //});

    
    });

    function open_closemodal(id)
    {
        $("#close-quot").val(id);
        $("#closemodal").modal("show");
    }

    $(".modal-body .text-center button").on("click", function (event) {
        var $button = $(event.target);
        var u = "{{url('admin/custom_quotations/close/')}}"+'/'+$("#close-quot").val();
        var r = $('#cancel_reason').val();
        if ($button[0].id == "confirm-close") {
            $.ajax({
                url: u,
                type: "POST",
                dataType: "JSON",
                data: { _token: $(this).data("token"), cancel_reason: r },
                success: function (data) {
                },
            });
            
                    // table.ajax.url(url).load();
            $("#closemodal").modal("hide");
            var url = "{{url('admin/custom_approvals/open')}}";
            var table = $('#server-datatable').DataTable();
            table.ajax.url(url).load();
        }
        else
            $("#close-quot").val('');
    });

    function open_approvemodal(id)
    {
        $("#approve-quot").val(id);
        $("#approvemodal").modal("show");
    }

    $(".modal-body-approve .text-center button").on("click", function (event) {
        var $button = $(event.target);
        var u = "{{url('admin/custom_quotations/approve/')}}"+'/'+$("#approve-quot").val();
        if ($button[0].id == "confirm-approve") {
            $.ajax({
                url: u,
                type: "POST",
                dataType: "JSON",
                data: { _token: $(this).data("token") },
                success: function (data) {
                    $('.quotInfo').html(data);
                },
            });
            //alert(data);
                   // table.ajax.url(url).load();
            $("#approvemodal").modal("hide");
            $("#infomodal").modal("show");
            var url = "{{url('admin/custom_approvals/approve')}}";
            var table = $('#server-datatable').DataTable();
            table.ajax.url(url).load();
        }
        else
            $("#approve-quot").val('');
    });
  </script>
  <!-- Include the image-diff library -->
    <script src="{{ asset('assets/js/quagga.min.js') }}" defer></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>

    </script>
@endsection
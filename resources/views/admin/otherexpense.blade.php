@extends('layouts.vertical', ["page_title"=> "Other Expenses | List"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('assets/css/custom.css')}}"></script>
<style>
    /* In order to place the tracking correctly */
    canvas.drawing,
    canvas.drawingBuffer {
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Other Expenses</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Other Expenses</h4>
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
                <div class="card-body body-style productMStyle table-spcl2 without-button purachaseorder-bttn">
                    <div class="row mb-0 pb-2 dashed-borderStyle">
                        <div class="col-sm-4">
                            <!-- <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>-->
                        </div><!-- end col-->
                        <div class="col-sm-12">
                            <div class="text-sm-end mt-2 mb-2 mt-sm-0">
                                <a href="{{url('admin/goods_receipt_oe')}}" class="btn btn-primary waves-effect waves-light">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Other Expenses</a>
                            </div>
                        </div>
                        <form id="sales-orderearchForm" class="form" method="POST" action="{{url('admin/sales-order/excel')}}">
                            @csrf
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4" style="display: none;">
                                        <div class="form-group row" style="display: none;">
                                            <label for="customer" class="col-sm-5 col-form-label">
                                            Supplier
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="customer"
                                                    class="customerSelect form-control select2">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="display: none;">
                                            <label for="executive" class="col-sm-5 col-form-label">
                                            Executive
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="user" class="userSelect form-control select2">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row" style="display: none;">
                                            <label for="status" class="col-sm-5 col-form-label">
                                            Status
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="status" class="form-control">
                                                    <option value="All">All</option>
                                                    <option value="Open" selected>Open</option>
                                                    <!-- <option value="Send for Approval">Send for Approval</option> -->
                                                    <option value="Cancel">Cancelled</option>
                                                    <!--  <option value="Approve">Approved</option>-->
                                                    <option value="Confirm">Confirmed</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <label for="from_date" class="col-sm-5 col-form-label">
                                            From date
                                            </label>
                                            <div class="col-sm-7">
                                            <input type="date" class="form-control" name="from_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="to_date" class="col-sm-5 col-form-label">
                                            To date
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" name="to_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                       
                                        <div class="form-group row">
                                            <div class="col-sm-12" style="text-align:end;">
                                                <input id="purchase-orderearchSubmit" class="btn btn-info" type="button" value="Search"/>
                                                <input id="sales-orderearchReset" class="btn btn-info" type="button" value="Reset"/>
                                                <!-- <input id="purchase-orderearchExport" class="btn btn-info" type="button" value="Excel Export" /> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col-->
                        </form>
                    </div>
                    <table id="server-datatable" class="table dt-responsive nowrap w-100 sales_order-table"
                        style="font-size:0.775rem !important;">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th class="all">Type</th>
                                <!-- <th class="all">Date</th> -->
                                <th>DocDue Date</th>
                                <th>Remarks</th>
                                <th>Total</th>
                                <!-- <th>Status</th> -->
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
                    <button type="button" id="cancel-close" class="btn btn-light"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-close" data-token="{{ csrf_token() }}" class="btn btn-primary"
                        data-href="">Yes, close it!</button>
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
                    <h4 class="mt-2">Do you really want to confirm the Other Expenses?</h4>
                    <input type="hidden" id="approve-quot" value="">
                    <button type="button" id="cancel-approve" class="btn btn-light"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-approve" data-token="{{ csrf_token() }}" class="btn btn-primary"
                        data-href="">Continue</button>
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
                    <h4 class="mt-2 con-quote"></h4>
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
    $(document).ready(function () {
        var url = "{{url('admin/goods-expense')}}";
        var table = $('#server-datatable').DataTable({
            processing: true,
            serverSide: true, bFilter: false, bInfo: false,

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
                { data: 'DocNo', name: 'DocNo' },
                { data: 'Type', name: 'Type', orderable: false },
                // { data: 'doc_date', name: 'doc_date' },
                { data: 'doc_date', name: 'doc_date', orderable: false },
                { data: 'Remarks', name: 'Remarks' },
                { data: 'PriceList', name: 'PriceList', orderable: false },
                // { data: 'status_show', name: 'status_show', orderable: false },
                { data: 'action', name: 'action', orderable: false },
            ],
            dom: 'Blfrtip',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export to CSV',
                    className: 'btn btn-primary',
                    footer: true,
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (action)
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn btn-success',
                    footer: true,
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (action)
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF',
                    className: 'btn btn-danger',
                    footer: true,
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (action)
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-info',
                    footer: true,
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (action)
                    }
                }
            ]
        });
        $(document).on('click', '#purchase-orderearchSubmit', function (e) {
            //e.preventDefault();
            console.log(url);
            table.ajax.url(url).load();
        });

        $(document).on("click", "#purchase-orderearchExport", function () {
            $('#ExportDownload').hide();
            $('#purchase-orderearchExport').val("Downloading..");
            $("#purchase-orderearchExport").attr("disabled", true);
            var url = "{{url('admin/purchase-order/excel')}}";
            var token = "{{ csrf_token() }}";
            var sts=$('select[name="status"]').val();
            var stsval=[];
            if(sts=="All"){
                stsval=["Open","Confirm","Approve","Send for Approval"];
            }
            $.ajax({
                url: url,
                type: 'POST',
                data:  {
                        'from_date' : $('input[name="from_date"]').val(),
                        'to_date' : $('input[name="to_date"]').val(),
                        'customer' : $('select[name="customer"]').val(),
                        'status' : $('select[name="status"]').val(),
                        'stsval':stsval,
                        'user' : $('select[name="user"]').val(),
                        "_token": token,
                },
                success: function (d) {
                    console.log("result",d);
                    //window.location.replace(d.url);
                    $('#purchase-orderearchExport').val("Excel Export");
                    $("#purchase-orderearchExport").attr("disabled", false);
                    $('#ExportDownload').show();
                    $("#ExportDownload").attr("href", d.url);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Failure callback function
                    console.error("Error:", textStatus, errorThrown);
                    $('#purchase-orderearchExport').val("Excel Export");
                    $("#purchase-orderearchExport").attr("disabled", false);
                    alert("Error:Try with a short Date Span!");
                }
            });
        });

        $("#sales-orderearchReset").click(function () {
            $('input[name="from_date"]').val('');
            $('input[name="to_date"]').val('');
            $(".customerSelect").val('').trigger('change');
            $(".userSelect").val('').trigger('change');
            $('select[name="status"]').val('Open');
            table.ajax.url(url).load();
        });

        $(".userSelect").select2({
            ajax: {
                        url: "{{ url('admin/ajax/partners/Sales Executive') }}",
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
                                        id: item.partner_code,
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

        $(".customerSelect").select2({
            ajax: {
                url: "{{ url('admin/ajax/exsupplier') }}",
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        q: params.term, // search term
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.current_page = params.current_page || 1;
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name + '(' + item.phone + ')',
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

                document.getElementById('customerCode').onchange = function() {
                    const customerCode = this.value;

                    fetch(`/api/customer/${customerCode}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                document.getElementById('customerName').value = data.name;
                                document.getElementById('customerAddress').value = data.address;
                            } else {
                                document.getElementById('customerName').value = '';
                                document.getElementById('customerAddress').value = '';
                            }
                        })
                        .catch(error => console.error('Error fetching customer data:', error));
                };



    });

    function open_closemodal(id) {
        $("#close-quot").val(id);
        $("#closemodal").modal("show");
    }

    $(".modal-body .text-center button").on("click", function (event) {
        var $button = $(event.target);
        var u = "{{url('admin/purchase-order/close/')}}" + '/' + $("#close-quot").val();
        var r = $('#cancel_reason').val();
        if ($button[0].id == "confirm-close") {
            $.ajax({
                url: u,
                type: "POST",
                dataType: "JSON",
                data: { _token: $(this).data("token"), cancel_reason: r },
                success: function (data) {
                    $('.con-quote').html(data);
                },
            });
            $("#closemodal").modal("hide");
            $("#infomodal").modal("show");
            var url = "{{url('admin/goods-expense')}}";
            var table = $('#server-datatable').DataTable();
            table.ajax.url(url).load();
        }
        else
            $("#close-quot").val('');
    });

    function open_approvemodal(id) {
        $("#approve-quot").val(id);
        $("#approvemodal").modal("show");
    }

    $(".modal-body-approve .text-center button").on("click", function (event) {
        var $button = $(event.target);
        var u = "{{url('admin/sales-order/confirm/')}}" + '/' + $("#approve-quot").val();
        if ($button[0].id == "confirm-approve") {
            $.ajax({
                url: u,
                type: "POST",
                dataType: "JSON",
                data: { _token: $(this).data("token") },
                success: function (data) {
                    $('.con-quote').html(data);
                },
            });
            $("#approvemodal").modal("hide");
            $("#infomodal").modal("show");
            var url = "{{url('admin/sales-order')}}";
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
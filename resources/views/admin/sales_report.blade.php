@extends('layouts.vertical', ["page_title"=> "Sales Order | Report"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('assets/css/custom.css')}}"></script>
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sales Order Item Report</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Sales Order Item Report</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">     

        <div class="col-12">
            <div class="card">
                <div class="card-body body-style salesMStyle salesRegisterStyle table-spcl3 without-button marble-pagination sales-ordr-h">
                <div class="row mb-2 pb-2 dashed-borderStyle">
                <div class="col-sm-4">
                        <!-- <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>-->
                    </div><!-- end col-->
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <!-- <a href="{{url('admin/custom_quote')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add Quotation</a> -->
                        </div>
                    </div>
                    <!-- <form id="quotationSearchForm" class="form" method="POST" action=""> -->
                    <form id="salesregisterSearchForm" class="form" method="POST" action="">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">
                                <!-- <div class="col-lg-4">
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
                                </div> -->
                                <div class="col-lg-4">
                                <div class="form-group row">
                                        <label for="executive" class="col-sm-5 col-form-label">
                                        Item
                                        </label>
                                        <div class="col-sm-7">
                                            <select required name="item" class="itemSelect form-control select2">
                                            </select>                 
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                            <label for="customer" class="col-sm-5 col-form-label">
                                            Customer
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="customer[]"
                                                    class="customerSelect form-control select2" multiple>
                                                </select>
                                            </div>
                                        </div>

                                    
                                    <!-- <div class="form-group row">
                                        <label for="to_date" class="col-sm-5 col-form-label">
                                        Customer
                                        </label>
                                        <div class="col-sm-7">
                                            <select required name="customer" class="customerSelect form-control select2">
                                            </select>
                                        </div>
                                    </div> -->
                                    
                                </div>
                                <div class="col-lg-4">
                                <div class="form-group row">
                                        <label for="to_date" class="col-sm-5 col-form-label">
                                        Purchased Type
                                        </label>
                                        <div class="col-sm-7">
                                            <select required name="whscode" class="whsSelect form-control select2">
                                            </select>
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="col-lg-4">
                                   
                                    <div class="form-group row">
                                        <div class="col-sm-12" style="text-align:end;">
                                        <input id="quotationSearchSubmit" class="btn btn-info" type="submit" value="Generate Report" />
                                        <input id="quotationSearchReset" class="btn btn-info" type="button" value="Reset" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col-->
                    </form>
                </div>
                    <table id="server-datatable" class="table dt-responsive nowrap w-100 quotation-table" style="font-size:0.775rem !important;">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Purchased Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th colspan="6" style="text-align: right;">Total Quantity:</th>
                                <th id="total_qty" style="text-align: left;"></th> 
                                <th></th> 
                            </tr>
                        </tfoot> -->
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
                    <h4 class="mt-2">Do you really want to confirm the quotation?</h4>
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
  $(document).ready(function() {
    var url = "{{url('admin/saleorderreport')}}";
    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,bFilter: false, bInfo: false,
        
        ajax: {
            url: url,
            data: function (d) {
                d.from_date = $('input[name="from_date"]').val(),
                d.to_date = $('input[name="to_date"]').val(),
                d.item = $('select[name="item"]').val(),
                d.customer = $('.customerSelect').val(), // For multi-select
                d.whscode = $('select[name="whscode"]').val()
            }
        },
        columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Serial Number
        { data: 'itemname', name: 'itemname' },
        { data: 'total_qty', name: 'total_qty' },
        { data: 'whsName', name: 'whsName' },
        { data: 'action', name: 'action' },
        ],
        dom: 'Blfrtip',
        lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        buttons: [
    {
        extend: 'csvHtml5',
        text: 'Export to CSV',
        className: 'btn btn-primary',
        exportOptions: {
            columns: ':not(:last-child)' // Exclude Action column
        }
    },
    {
        extend: 'excelHtml5',
        text: 'Export to Excel',
        className: 'btn btn-success',
        exportOptions: {
            columns: ':not(:last-child)' // Exclude Action column
        }
    },
    {
        extend: 'pdfHtml5',
        text: 'Export to PDF',
        className: 'btn btn-danger',
        exportOptions: {
            columns: ':not(:last-child)' // Exclude Action column
        },
        customize: function (doc) {
            // Adjust table layout
            doc.content[1].table.widths = ['10%', '40%', '20%', '30%']; // Adjust column widths
            doc.styles.tableHeader.alignment = 'left'; // Align headers left
        }
    },
    {
        extend: 'print',
        text: 'Print',
        className: 'btn btn-info',
        exportOptions: {
            columns: ':not(:last-child)' // Exclude Action column
        }
    }
],

        footerCallback: function (row, data, start, end, display) {
            var total = 0;
            data.forEach(function (item) {
                total += parseFloat(item.qty) || 0;
            });

            // Set total quantity in footer
            $('#total_qty').html(total);
        }
    
    });
    $(document).on('click', '#quotationSearchSubmit', function(e) {
        e.preventDefault();         
        table.ajax.url(url).load();
    });
    $("#quotationSearchReset").click(function(){
        $('input[name="from_date"]').val('');
        $('input[name="to_date"]').val('');
        $(".customerSelect").val('').trigger('change');
        $(".itemSelect").val('').trigger('change');
        $(".whsSelect").val('').trigger('change');        
        table.ajax.url(url).load();
    });

    $(".itemSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/products') }}",
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
                            text: item.productName,
                            id: item.productCode
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
                placeholder: "By searching name,item code",
                allowClear: false,
        });
   
   
        $(".branchSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/branches') }}",
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
                        text: item.BranchName,
                        id: item.BranchCode
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
            placeholder: "By searching branch name or code",
            allowClear: false,
    });

    $(".whsSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/whscode') }}",
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
                            text: item.whsName,
                            id: item.whsCode
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
                placeholder: "By searching name,warehouse",
                allowClear: false,
        });
   
   
        $(".branchSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/branches') }}",
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
                        text: item.BranchName,
                        id: item.BranchCode
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
            placeholder: "By searching branch name or code",
            allowClear: false,
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

    $(".partnerSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/userslist') }}",
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
                        text: item.name,
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
            placeholder: "By searching name,code",
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
                    $('.con-quote').html(data);
                },
            });
            $("#closemodal").modal("hide");
            $("#infomodal").modal("show");
            var url = "{{url('admin/custom_quotations')}}";
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
        var u = "{{url('admin/custom_quotations/confirm/')}}"+'/'+$("#approve-quot").val();
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
            var url = "{{url('admin/custom_quotations')}}";
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
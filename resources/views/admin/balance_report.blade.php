@extends('layouts.vertical', ["page_title"=> "Balance | Report"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Balance Report</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Balance Report</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">     

        <div class="col-12">
            <div class="card">
                <div class="card-body body-style salesMStyle balanceMreport tr-m table-spcl3 without-button marble-pagination balance-reportstyle">
                <div class="row mb-1 pb-2 dashed-borderStyle">
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
                    <form id="salesreturnregisterSearchForm" class="form" method="POST" action="">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">
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
                                    <!-- <div class="form-group row">
                                        <label for="status" class="col-sm-5 col-form-label">
                                        Status
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="rtn_status" id="rtn_status" class="form-control">
                                                <option value="All">All</option>
                                                <option value="Open">Open</option>
                                                
                                                <option value="Confirm">Confirmed</option>
                                            </select>              
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <label for="customer" class="col-sm-5 col-form-label">
                                        Customer
                                        </label>
                                        <div class="col-sm-7">
                                            <select required name="customer" class="customerSelect form-control select2">
                                            </select>               
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                            <label for="to_date" class="col-sm-5 col-form-label">
                                            Doc Number
                                            </label>
                                            <div class="col-sm-7">
                                                 <select name="invdoc_num" class="invdocSelect form-control select2">
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
                <table id="server-datatable"  class="table dt-responsive nowrap w-100 quotation-table" style="font-size:0.775rem !important;">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Invoice Number</th>
                            <th>Payment Date</th>
                            <th>Customer Name</th>
                            <!-- <th>Sales Employee</th> -->
                            <th>Total Amount</th>
                            <th>Sum Applied</th>
                            <th>Balance Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated dynamically -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th id="totalInvDocTotal"></th>
                            <th id="totalSumApplied"></th>
                            <th id="totalBalanceAmount"></th>
                            <th></th>
                        </tr>
                    </tfoot>
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
    var url = "{{url('admin/balancereport')}}";
var table = $('#server-datatable').DataTable({
    processing: true,
    serverSide: true,
    bFilter: false,
    bInfo: false,
    ajax: {
        url: url,
        data: function (d) {
            d.from_date = $('input[name="from_date"]').val();
            d.to_date = $('input[name="to_date"]').val();
            d.customer = $('select[name="customer"]').val();
            d.user = $('select[name="partner"]').val();
            d.invdoc_num = $('select[name="invdoc_num"]').val();

        }
    },
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' }, 
        { data: 'doc_num', name: 'doc_num' }, 
        { data: 'DocDate', name: 'DocDate' }, 
        { data: 'customer_name', name: 'customer_name' }, 
        // { data: 'partner_name', name: 'partner_name' }, 
        { data: 'InvDocTotal', name: 'InvDocTotal' }, 
        { data: 'SumApplied', name: 'SumApplied' }, 
        { data: 'balance', name: 'balance' }, 
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    dom: 'Blfrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    buttons: [
        {
            extend: 'csvHtml5',
            text: 'Export to CSV',
            className: 'btn btn-primary',
            exportOptions: { columns: ':not(:last-child)' }, // Exclude Action column
            footer: true
        },
        {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            className: 'btn btn-success',
            exportOptions: { columns: ':not(:last-child)' }, // Exclude Action column
            footer: true
        },
        {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            className: 'btn btn-danger',
            exportOptions: { columns: ':not(:last-child)' }, // Exclude Action column
            footer: true
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-info',
            exportOptions: { columns: ':not(:last-child)' }, // Exclude Action column
            footer: true
            
        }
    ],
    footerCallback: function (row, data, start, end, display) {
    var api = this.api();

    // Function to calculate column total
    // var columnTotal = function (index) {
    //     return api
    //         .column(index, { page: 'current' })
    //         .data()
    //         .reduce((a, b) => parseFloat(a) + parseFloat(b), 0)
    //         .toFixed(2);
    // }; 

    var totalInvDocTotal = api.column(4, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);
    var totalSumApplied = api.column(5, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);
    var totalBalanceAmount = api.column(6, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);

    // Calculate totals for numeric columns
    // var totalInvDocTotal = columnTotal(5);
    // var totalSumApplied = columnTotal(6);
    // var totalBalanceAmount = columnTotal(7);

    // Set calculated totals in footer
    $(api.column(0).footer()).html('');
    $(api.column(1).footer()).html('');
    $(api.column(2).footer()).html('');
    $(api.column(3).footer()).html('');
    // $(api.column(4).footer()).html('');
    $(api.column(4).footer()).html(totalInvDocTotal); // Total for InvDocTotal
    $(api.column(5).footer()).html(totalSumApplied); // Total for SumApplied
    $(api.column(6).footer()).html(totalBalanceAmount); // Total for Balance Amount
    $(api.column(7).footer()).html(''); // Empty column for Action
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
        $(".partnerSelect").val('').trigger('change');        
        $('select[name="rtn_status"]').val('All');
        $(".invdocSelect").val('').trigger('change');
        table.ajax.url(url).load();
    });

 
             $(".invdocSelect").select2({
            ajax: {
                        url: "{{ url('admin/ajax/invdocSelect') }}",
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
                                        results: $.map(data.data, function (item) {
                                            return {
                                                text: item.doc_num ,
                                                id: item.id, // Change `partner_code` to `id` if your database uses `id`
                                            };
                                        }),
                                        pagination: data.pagination
                                    };

                        },
                autoWidth: false,
                cache: true
            },
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Select Document No",
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
        url: "{{ url('admin/ajax/partners') }}",
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
                        id: item.partner_code
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

    });







  </script>
  <!-- Include the image-diff library -->
    <script src="{{ asset('assets/js/quagga.min.js') }}" defer></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>

    </script>
@endsection
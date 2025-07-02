@extends('layouts.vertical', ["page_title"=> "Balance | Report Details"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Balance Report Details</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Balance Report Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">     
        <div class="col-12">
            <div class="card">
                <div class="card-body body-style salesMStyle balanceDetailMstyle tr-m table-spcl3 without-button marble-pagination balance-reportStyle">
                <div class="row mb-1 pb-2 ">
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
                    
                </div>
                <table id="server-datatable"  class="table dt-responsive nowrap w-100 quotation-table" style="font-size:0.775rem !important;">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Invoice Number</th>
                            <th>Salesman</th>
                            <th>Payment Date</th>
                            <th>Total Amount</th>
                            <th>Pending</th>
                            <th>Sum Applied</th>
                            <th>Balance Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated dynamically -->
                    </tbody>
                    <tfoot>
                        <tr>
                        <th colspan="3" style="text-align:left"></th>
                            <th ></th>
                            <th></th>
                            <th></th>
                            <th ></th>
                            <th ></th>
                          
                        </tr>
                    </tfoot>
                   
                </table>
            <div class="col-sm-3 col-10 order-detail-back">
                    <button onclick="history.back()" class="btn btn-primary w-100">Back</button>
                    </div>

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
    var doc_num = window.location.pathname.split('/').pop();
    var url = "{{ url('admin/balance-report/view') }}/" + doc_num;

    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        bInfo: false,
        ajax: "{{ url('admin/balance-report/view') }}/" + doc_num,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Disable ordering
            { data: 'InvDocNum', name: 'InvDocNum' },
            { data: 'Salesman', name: 'Salesman' },
            { data: 'InvDocDate', name: 'InvDocDate' },
            { data: 'InvDocTotal', name: 'InvDocTotal' },
            { data: 'Pending', name: 'Pending' },
            { data: 'SumApplied', name: 'SumApplied' },
            { data: 'Balance', name: 'Balance' }
        ],
        dom: 'Blfrtip',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        buttons: [
            { extend: 'csvHtml5', text: 'Export to CSV', className: 'btn btn-primary',footer: true },
            { extend: 'excelHtml5', text: 'Export to Excel', className: 'btn btn-success',footer: true },
            { extend: 'pdfHtml5', text: 'Export to PDF', className: 'btn btn-danger',footer: true },
            { extend: 'print', text: 'Print', className: 'btn btn-info',footer: true }
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var totalInvDocTotal = api.column(4, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);

            var totalSumApplied = api.column(6, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);

            var totalBalanceAmount = api.column(7, { page: 'current' }).data()
                .reduce((a, b) => parseFloat(a) + parseFloat(b), 0).toFixed(2);

            var balance = totalInvDocTotal - totalSumApplied;

            // Apply values with proper alignment
            $(api.column(3).footer()).html(`Total :`);
            $(api.column(4).footer()).html(`<span class="text-right">${totalInvDocTotal}</span>`);
            $(api.column(6).footer()).html(`<span class="text-right">${totalSumApplied}</span>`);
            $(api.column(7).footer()).html(`Balance  : <span class="text-right">${balance}</span>`);
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
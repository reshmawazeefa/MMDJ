@extends('layouts.vertical', ["page_title"=> "Cashbook"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Cashbook</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Cashbook</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">     

        <div class="col-12">
            <div class="card">
                <div class="card-body body-style salesMStyle table-spcl2 without-button marble-pagination">
                <div class="row mb-4 pb-2 dashed-borderStyle">
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
                                </div>
                                <div class="col-lg-4">
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
                                        <label for="rtn_status" class="col-sm-5 col-form-label">
                                        Account
                                        </label>
                                        <div class="col-sm-7">
                                        <select id="account" name="account" class="accountlist form-control select2"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12 mt-1" style="text-align:end;">
                                        <input id="quotationSearchSubmit" class="btn btn-info" type="submit" value="Generate Report" />
                                        <input id="quotationSearchReset" class="btn btn-info" type="button" value="Reset" />
                                        </div>
                                    </div>
                                </div>







                                <!-- <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="from_date" class="form-label">From date</label>
                                        <input type="date" class="form-control" name="from_date">
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="to_date" class="form-label">To date</label>
                                        <input type="date" class="form-control" name="to_date">
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-3 col-sm-6">
                                    <div class="me-3">
                                        <label for="rtn_status" class="form-label">Account</label>
                                        <select id="account"  name="account" class="accountlist form-control select2 " >
                                    </select>
                                    </div>
                                </div> -->
                               
                                <!-- <div class="col-lg-2 col-sm-6">
                                    <div class="mt-3">
                                    <label for="customer" class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input id="quotationSearchSubmit" class="btn btn-info" type="submit" value="Generate Report" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6">
                                    <div class="mt-3">
                                    <label for="customer" class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input id="quotationSearchReset" class="btn btn-info" type="button" value="Reset" />
                                    </div>
                                </div> -->
                            </div>
                        </div><!-- end col-->
                    </form>
                </div>
                    <table id="server-datatable" class="table dt-responsive nowrap w-100 quotation-table" style="font-size:0.775rem !important;">
                        <style>
                            #server-datatable_wrapper{
                                margin-top: -3%
                            }
                        
                            .dataTables_length{
                                margin-top: 1.5%; margin-bottom: 1.5%;
                            }
                            .StyleS div{
                            z-index: 2;
                            margin-top: -10px;
                            margin-left: 194px;
                            position: absolute;
                        }
                        .StyleS{
                            position: sticky;
                            z-index: 2;
                            top: 16px;
                        }

                            @media screen and (max-width: 740px) {
                                #server-datatable_wrapper{
                                margin-top: 3%;
                            }
                            .StyleS {
                                text-align: center!important;
                            }
                            }
                            </style>
                        <div class="StyleS">
                            <div class="col-12">
                                <span class="me-3">Opening : <span id="opening_balance"></span></span>
                                <span>Closing : <span id="closing_balance"></span></span> 
                            </div>
                        </div>


                        <thead>

                            <tr>
                            <th>Sl No</th>
                                <th class="all">Doc Date</th>
                                <th class="all">Doc No</th>
                                <th>Inv No</th>
                                <th>Account</th>
                                <th>Debit</th>
                                <th>Credit</th>
                               
                            </tr>
                        </thead>


                        <tbody>
                        </tbody>
                        <tfoot>
                        <!-- <tr>
                            <th colspan="7" style="text-align: right;"></th>
                            <th style="text-align: left;"></th> 
                            <th style="text-align: left;"></th> 
                            <th style="text-align: left;"></th> 
                        </tr> -->
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
    $(".itemSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/allproducts') }}",
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


            $(".accountlist").select2({
                    ajax: {
                    url: "{{ url('admin/ajax/accountlist') }}",
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
                                    text: item.AcctName,
                                    id: item.AcctCode
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


    var url = "{{url('admin/cashbook')}}";
    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,bFilter: false, bInfo: false,
        
                ajax: {
                    url: url,
                    data: function (d) {
                        d.from_date = $('input[name="from_date"]').val(),
                        d.to_date = $('input[name="to_date"]').val(),
                        d.account = $('select[name="account"]').val()
                    },
                    dataSrc: function (json) {
                        console.log(json);
                        var total_debit = parseFloat(json.total_debit) || 0;
                        var total_credit = parseFloat(json.total_credit) || 0;
                        var opening_value = parseFloat(json.opening_value) || 0;

                        // Calculate balances
                        var closing_balance = opening_value + total_debit - total_credit;
                        var opening_balance = closing_balance + total_debit - total_credit;

                        // Update the UI with formatted values
                        $('#opening_balance').text(opening_balance.toFixed(2));
                        $('#closing_balance').text(closing_balance.toFixed(2));
                        return json.data; // Ensure only the data part is returned
                    },
                    initComplete: function (settings, json) {
                        console.log(json);
                        var total_debit = parseFloat(json.total_debit) || 0;
                        var total_credit = parseFloat(json.total_credit) || 0;
                        var opening_value = parseFloat(json.opening_value) || 0;

                        // Calculate balances
                        var closing_balance = opening_value + total_debit - total_credit;
                        var opening_balance = closing_balance + total_debit - total_credit;

                        // Update the UI with formatted values
                        $('#opening_balance').text(opening_balance.toFixed(2));
                        $('#closing_balance').text(closing_balance.toFixed(2));
                    }
                },
                            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Index 0
                { data: 'DocDate', name: 'DocDate' },           // Index 1
                { data: 'DocNum', name: 'DocNum' },         // Index 2
                { data: 'InvNo', name: 'InvNo' },       // Index 3
                { data: 'CashAcct', name: 'CashAcct' }, // Index 4
                { data: 'Debit', name: 'Debit' },   // Index 5
                { data: 'Credit', name: 'Credit' }           // Index 6
            ],
            dom: 'Blfrtip',
            lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export to CSV',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export to PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn btn-info'
                }
            ],
            // footerCallback: function (row, data, start, end, display) {
            //     var api = this.api();

            //     // Calculate sum of 'taxableamount' column (column 6)
            //     var totalTaxableAmount = api.column(7).data().reduce(function (a, b) {
            //         return parseFloat(a) + parseFloat(b);
            //     }, 0);

            //     // Calculate sum of 'tax_amount' column (column 7)
            //     var totalTaxAmount = api.column(8).data().reduce(function (a, b) {
            //         return parseFloat(a) + parseFloat(b);
            //     }, 0);

            //     // Calculate sum of 'total' column (column 8)
            //     var totalAmount = api.column(9).data().reduce(function (a, b) {
            //         return parseFloat(a) + parseFloat(b);
            //     }, 0);

            //     // Round the sums to 2 decimal places
            //     totalTaxableAmount = totalTaxableAmount.toFixed(2);
            //     totalTaxAmount = totalTaxAmount.toFixed(2);
            //     totalAmount = totalAmount.toFixed(2);

            //     // Display the sums in the footer
            //     $(api.column(7).footer()).html(totalTaxableAmount);
            //     $(api.column(8).footer()).html(totalTaxAmount);
            //     $(api.column(9).footer()).html(totalAmount);
            // }
    });
    $(document).on('click', '#quotationSearchSubmit', function(e) {
        e.preventDefault();         
        table.ajax.url(url).load();
    });
    $("#quotationSearchReset").click(function(){
        $('input[name="from_date"]').val('');
        $('input[name="to_date"]').val('');
        // $(".customerSelect").val('').trigger('change');
        // $(".branchSelect").val('').trigger('change');
        // $(".partnerSelect").val('').trigger('change');        
        $('select[name="account"]').trigger('change');  
        table.ajax.url(url).load();
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
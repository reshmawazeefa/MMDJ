@extends('layouts.vertical', ["page_title"=> "Stock In Create"])

@section('css')
<!-- third party css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" rel="stylesheet">
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->

<!-- icons -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
<!-- newly added -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" rel="stylesheet">

<!-- /newly added -->
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
                        <li class="breadcrumb-item">
                            <a href="{{url('admin/sales-invoice')}}">Stock In</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Stock In</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">@if(!empty($errors->all()))
            <p class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
            </p>
            @endif
            <div class="card">
                <form method="post" class="parsley-examples" action="{{url('admin/stockin/insert')}}">
                    {{csrf_field()}}
                    <div class="card-body body-style">
                        <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="form-group row">
                                                <label for="from_branch" class="col-sm-6 form-label">From Branch <span class="text-danger">*</span></label>
                                                <div class="col-sm-6"><select name="from_branch" id="from_branch" class="form-control" required>
                                                    <option value="">Select Branch</option>
                                                @foreach ($branch as $b)
                                                    <option value="{{ $b->BranchCode }}" data-address="{{ $b->Address }}" data-name="{{ $b->BranchName }}">{{ $b->BranchName }}</option>
                                                @endforeach
                                                </select>
                                                <input   type="hidden" class="form-control" name="from_branch_name" id="from_branch_name"  aria-describedby="basic-addon1"  readonly>

                                                <input   type="hidden" class="form-control" name="to_branch" id="to_branch"  aria-describedby="basic-addon1" value="{{session('branch_code')}}" readonly>
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                                <label for="to_branch_name" class="col-sm-6 form-label">To Branch</label>
                                                <div class="col-sm-6"><input   type="text" class="form-control" name="to_branch_name" id="to_branch_name"  aria-describedby="basic-addon1" value="{{session('branch_name')}}" readonly>
                                            </div>
                                    </div>
                                    
                                     
                                    <div class="form-group row">
                                                <label for="referral" class="col-sm-6 form-label">Address </label>
                                                <div class="col-sm-6"><textarea class="form-control" name="bill_to_address" id="bill_to_address" >{{session('branch_address')}}</textarea>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mt-1">
                                        <a class="btn btn-primary waves-effect waves-light mb-0 qutt-bttn" id="copy_from_qutn" name="copy_from_qutn">Copy from Draft Receipt</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group row">
                                                <label for="referral" class="col-sm-6 form-label">Barcode</label>
                                                <div class="col-sm-6"><input   type="text" class="form-control" name="scan_here" id="scan_here"  aria-describedby="basic-addon1">
                                                <span id="erbarcode" style="color: red;"> </span>
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                                <label for="referral" class="col-sm-6 form-label">Doc Number <span class="text-danger">*</span></label>
                                                <div class="col-sm-6"><div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1"><select name="doc_list" id="doc_list" class="doc_listSelect form-control select2">
                                                        <option value="WSJLB" selected>WSJLB</option>
                                                    </select></span>
                                                    <input required readonly type="text" class="form-control" name="docNumber" placeholder="Doc Number" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                                <label for="status" class="col-sm-6 form-label">Status</label>
                                                <div class="col-sm-6">
                                                <select name="status" class="statusSelect form-control select2">
                                                    <option value="Open">Open</option>
                                                    <option value="Closed">Closed</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row" id="open_quotation">
                                            <label for="referral" class="col-sm-6 form-label">Open Items</label>
                                            <div class="col-sm-6"><select  name="open_qutn" id="open_qutn" class="open_qutnSelect form-control select2" style="height: 54px;" multiple>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                        <div class="form-group row">
                                                <label for="posting_date" class="col-sm-6 form-label">Posting Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-6"><input required type="date" name="posting_date" id="posting_date" class="form-control flatpickr-input active" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <label for="date" class="col-sm-6 form-label">Delivery Date <span class="text-danger">*</span></label>
                                               <div class="col-sm-6"> <input required type="date" name="delivery_date" id="delivery_date"  class="form-control flatpickr-input active">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <label for="date" class="col-sm-6 form-label">Document Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-6"><input required type="date" name="DocuDate" id="DocuDate" class="form-control flatpickr-input active" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mt-1">
                                            <a class="btn btn-primary waves-effect waves-light mb-0 qutt-bttn" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#barcode_verifications" id="barcode_verification" name="barcode_verification">Barcode Verification</a>
                                            </div>

                                        </div>
                                       
                                </div>
                        </div>
                        <!-- <div class="col-lg-4 col-sm-6">
                            <a class="btn btn-primary waves-effect waves-light" id="copy_from_qutn" name="copy_from_qutn">Copy from Draft Receipt</a>
                        </div>

                        <div class="col-lg-4 col-sm-6" id="open_quotation">
                            <div class="me-3">
                                <label for="referral" class="form-label">Open Items</label>
                                <select  name="open_qutn" id="open_qutn" class="open_qutnSelect form-control select2" multiple>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                        
                            <a class="btn btn-primary waves-effect waves-light" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#barcode_verifications" id="barcode_verification" name="barcode_verification">Barcode Verification</a>

                        </div> -->
           
                <div class="col-12">                        
                        <input type="hidden" id="count" value="0">
                    <div class="new-table">
                        @for ($i = 0; $i < 1; $i++)
                            <div id="grid-container">
                                
                                    <div class="ech-tr" id="tr_{{$i}}">
                                        <!-- <div style="display:none">
                                            <span class="taxable_{{$i}}"></span>
                                            <span class="discwithouttax_{{$i}}"></span>
                                            <span class="tax_{{$i}}"></span>
                                            <span class="taxamount_{{$i}}"></span>
                                            <span class="netprice_{{$i}}"></span>
                                            <input type="hidden" name="LineTotal[]" class="linetotal_{{$i}}">
                                        </div> -->
                                        <div class="echtr-inn">
                                            <div class="row">
                                                <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                                    <div class="ech-td">
                                                        <span class="btn opentr-btn"></span>
                                                    </div>
                                                </div>
                                                <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                    <div class="ech-td">
                                                        <label class="td-label">Item(s) <span class="text-danger">*</span>
                                                        
                                                        </label>
                                                        <div class="td-value">
                                                        <select id="product_{{$i}}" onChange="load_warehouse({{$i}})" required  name="product[]" class="product_{{$i}} itemSelect form-control select2">
                                                </select><!--  -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                    <div class="ech-td">
                                                        <label class="td-label">Quantity <span class="text-danger">*</span></label>
                                                        <div class="td-value">
                                                        <input  type="number" id="quantity_{{$i}}" required class="quantity_{{$i}} form-control" onchange="price_calc({{$i}})" name="quantity[]" >
                                                    
                                                        </div>
                                                    </div>
                                                </div> 
                                                                            
                                                
                                                


                                                <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                    <div class="ech-td">
                                                        <label class="td-label">WHSE <span class="text-danger">*</span></label>
                                                        <div class="td-value">
                                                        <span style="display:none;" class="discount_{{$i}}"></span>
                                                        <span class="whscode_{{$i}}"></span>
                                                        <select class="form-control whscode-select" name="whscode[]" id="whscode_{{$i}}" required></select>
                                                        <input type="hidden" id="unitprice_{{$i}}"  class="unitprice unitprice_{{$i}} form-control" name="unitprice[]" readonly>
                                                        <input type="hidden" id="avqty_{{$i}}" class="avqty avqty_{{$i}} form-control" name="avqty[]" readonly="" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                        <div class="ech-td">
                                                            <label class="td-label">BarCode</label>
                                                            <div class="td-value">
                                                                <input type="text" id="barcode_{{$i}}"  class="barcode_{{$i}} form-control" name="barcode[]">
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div class="colbor col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="ech-td">
                                                            <label class="td-label">Serial No</label>
                                                            <div class="td-value">
                                                                <input type="text" id="serialno_{{$i}}"  class="serialno_{{$i}} form-control" name="serialno[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        </div>                        
                                        <div class="actn-td">
                                            <a href="javascript:void(0);" class="action-icon add-item"></a>
                                            <a href="javascript:void(0);" class="action-icon delete-item"></a>
                                        </div>
                                    </div>
                                <!-- Grid rows will be appended here -->
                            </div>
                        @endfor
                    <!-- <div id="grandTotalDisplay">Grand Total: 0.00</div> -->
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                         <div class="form-group row">
                                    <label for="referral" class="col-sm-6 form-label">Sales Employee <span class="text-danger">*</span></label>
                                    <div class="col-sm-6"><select required name="partner3" id="partner3" class="agentSelect form-control select2">
                                            </select>
                                </div>
                        </div>
                            
                        <div class="form-group row">
                                    <label for="referral" class="col-sm-6 form-label">Remarks</label>
                                    <div class="col-sm-6"><textarea placeholder="Remarks" id="remarks" type="text" name="remarks" class="form-control" ></textarea>
                                    
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                         <div class="form-group row">
                                    <label for="referral" class="col-sm-6 form-label">Total Quantity <span class="text-danger">*</span></label>
                                    <div class="col-sm-6"><input type="text" name="total_qty" id="total_qty" readonly class="form-control">
                                </div>
                        </div>
                            
                        <div class="form-group row">
                                    <label for="referral" class="col-sm-6 form-label">Total</label>
                                    <div class="col-sm-6"><input type="text" name="total_price" id="total_price" class="form-control" readonly>
                                    
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-1" style="margin-bottom: 3.5%;">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Save</button>
                    <!-- <button type="reset" class="btn btn-primary waves-effect waves-light" style="float: right;">Cancel</button> -->
                </div>
                    
                    <!-- <div class="col-lg-12">
                    <div class="row">
                   

                            <div class="col-lg-2 col-sm-3">
                                <div class="me-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-3">
                                <div class="me-3">
                                    <button type="reset" class="btn btn-primary waves-effect waves-light">Cancel</button>
                                </div>
                            </div>
                          
                           

                    </div>
                    </div> -->
                    </div>


                </form>
            
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
        <div class="modal fade" id="barcode_verifications" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                    <div class="modal-header pb-1">
                        <h5 class="modal-title" id="addPartModalLabel">Batch Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Modal content here -->
                        <form id="barcodeFormIds">
                            <div class="row">
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <div class="me-0">
                                <label  class="form-label">Scan Barcode <span class="text-danger">*</span></label>
                                <input  type="text" name="sbarcode" id="sbarcode" class="form-control flatpickr-input active" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <div class="me-0">
                                <label  class="form-label">Del Barcode <span class="text-danger">*</span></label>
                                <input  type="text" name="dbarcode" id="dbarcode" class="form-control flatpickr-input active" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <div class="me-0">
                                <label  class="form-label">Receipt No<span class="text-danger">*</span></label>
                                <input  type="text" name="rnumber" id="rnumber" class="form-control flatpickr-input active" >
                            </div>
                        </div>
                        </div>
                        <div class="new-table">
                            @for ($i = 0; $i < 1; $i++)
                                <div id="mgrid-container">
                                    
                            
                                @endfor
                            <!-- <div id="grandTotalDisplay">Grand Total: 0.00</div> -->
                    </div>
                    <div class="modal-footer pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button> <!-- Changed type to "submit" -->
                    </div>

                        </form>
                    </div>
                
                </div>
            </div>
        </div>
    @include('includes.modal_popups')
</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<!-- end demo js-->
<!-- demo app -->
<!-- end demo js-->
<script>
    $(document).ready(function() {
        var today = new Date();
        var formattedToday = today.toISOString().split('T')[0];
        
        // Set the date in the input field (YYYY-MM-DD format)
        $('#delivery_date').val(formattedToday);
        $('#DocuDate').val(formattedToday);
        $('#posting_date').val(formattedToday);
        $("#copy_from_qutn").css("display", "none");
        $("#barcode_verification").css("display", "none");
        $("#open_quotation").hide();
        $('#sepBilling').change(function(){
            if($('#sepBilling').is(':checked'))
            {
                $('select[name=prefixBilling').val($('select[name=prefix').val());
                $('input[name=addressIDBilling').val($('input[name=addressID').val());
                $('input[name=addressBilling').val($('input[name=address').val());
                $('input[name=address2Billing').val($('input[name=address2').val());
                $('input[name=placeBilling').val($('input[name=place').val());
                $('input[name=zip_codeBilling').val($('input[name=zip_code').val());
                $('select[name=stateBilling').val($('select[name=state').val());
                $('input[name=countryBilling').val($('input[name=country').val());
            }
            else{                
            }
        });
document.getElementById('from_branch').addEventListener('change', function() {
    // Get the selected option
    var selectedOption = this.options[this.selectedIndex];
    
    // Get the address from the selected option's data attribute
    // var address = selectedOption.getAttribute('data-address');
    var bname = selectedOption.getAttribute('data-name');
    
    // Set the address in the textarea
    // document.getElementById('bill_to_address').value = address || '';
    document.getElementById('from_branch_name').value = bname || '';
});


        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'partner'},
           success:function(data){
              $('#partner_code').val(data);
           }
        });
        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'customer'},
           success:function(data){
              $('#customer_code').val(data);
           }
        });

        load_product();

        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'stock-in'},
           success:function(data){
              $('input[name=docNumber]').val(data);
              $('input[name=rnumber]').val(data);
           }
        });

        // for payment term onchange function 
        $('#payment_term').change(function() {
        var paymentTerm = $(this).val();  // Get the selected payment term

        if (paymentTerm !== "cash") {
            var daysToAdd = parseInt(paymentTerm); // Convert payment term to an integer
            var currentDate = new Date(); // Get today's date

            // Add the selected number of days
            currentDate.setDate(currentDate.getDate() + daysToAdd);

            // Format the date to YYYY-MM-DD for the input field
            var formattedDate = currentDate.toISOString().split('T')[0]; 

            // Set the date in the input field (YYYY-MM-DD format)
            $('#delivery_date').val(formattedDate);
        } else {
            // For "Cash", set today's date in YYYY-MM-DD format
            var today = new Date();
            var formattedToday = today.toISOString().split('T')[0];
            
            // Set the date in the input field (YYYY-MM-DD format)
            $('#delivery_date').val(formattedToday);
        }
    });

    // Trigger the change event on page load to set the default value



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


        
        $(".customer_codeSelect").select2({
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
                            text: item.customer_code,
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
                placeholder: "By searching customer code",
                allowClear: false,
        });

        $(".agentSelect").select2({
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
                placeholder: "By searching name,phone",
                allowClear: false,
        });
    });
    
    $(document).on("click", ".add-item", function() {
    // Find the total number of existing rows
    var totalRows = $(".ech-tr").length; // Count the current rows
    var val = totalRows; // Set the new row's index to the total number of rows

    var html = '<div class="ech-tr" id="tr_'+val+'">'
                                +'<div style="display:none">'
                                +'<span class="taxable_'+val+'"></span><span class="discwithouttax_'+val+'"></span><span class="tax_'+val+'"></span>'
                                +'<span class="taxamount_'+val+'"></span><span class="netprice_'+val+'"></span>'
                                +'<input type="hidden" name="LineTotal[]" class="linetotal_'+val+'">'
                            +'</div>'
                            +'<div class="echtr-inn">'
                                +'<div class="row">'
                                    +'<div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">'
                                        +'<div class="ech-td">'
                                            +'<span class="btn opentr-btn"></span>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Item(s) <span class="text-danger">*</span></label>'
                                            +'<div class="td-value">'
                                            +'<select id="product_'+val+'" onChange="load_warehouse('+val+')" required  name="product[]" class="product_'+val+' itemSelect form-control select2"></select></div></div></div>'
                                     
                                    +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Quantity <span class="text-danger">*</span></label>'
                                            +'<div class="td-value"><input  type="number" id="quantity_'+val+'" required class="quantity_'+val+' form-control" onchange="price_calc('+val+')" name="quantity[]"></div></div></div>' 

                                         +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">WHSE <span class="text-danger">*</span></label>'
                                            +'<div class="td-value"><select id="whscode_'+val+'"  name="whscode[]" class="form-control whscode-select" required></select><input type="hidden" id="unitprice_'+val+'" class="unitprice unitprice_'+val+' form-control" name="unitprice[]" readonly=""></div></div></div>'

                                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                            +'<div class="ech-td">'
                                               +'<label class="td-label">Barcode</label>'
                                                +'<div class="td-value">'
                                                    +'<input type="text" id="barcode_${i}"  class="barcode_${i} form-control" name="barcode[]">'
                                                +'</div></div></div>'

                                            +'<div class="colbor col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">'
                                            +'<div class="ech-td">'
                                               +'<label class="td-label">Serial No</label>'
                                                +'<div class="td-value">'
                                                    +'<input type="text" id="serialno_${i}"  class="serialno_${i} form-control" name="serialno[]">'
                                                +'</div></div></div>'

                                    
                                    
                                        

                                    
                                            +'</div>'
                                            +'</div>'                
                                            +'<div class="actn-td">'
                                            +'<a href="javascript:void(0);" class="action-icon add-item"></a>'
                                            +'<a href="javascript:void(0);" class="action-icon delete-item"></a>'
                                            +'</div>'
                                            +'</div>';

    // Insert the new row after the clicked row
    $(this).closest(".ech-tr").after(html);

    // Initialize any additional functionality like product loading
    load_product();
});




    $(document).on("click", ".delete-item", function() {
    var $row = $(this).closest('.ech-tr');

    if ($('div .ech-tr').length == 1) {
        var val = parseInt($("#count").val()) + 1;
        $("#count").val(val);
        $(".add-item").click(); // Add new row when deleting the last one
    }

    $row.remove(); // Remove the row
    calculate_footer(); // Recalculate after removing a row
    });

    function load_product()
    {       
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
    }

    function load_warehouse(val) {
        console.log(val);
    var r = val; // Extract the row number (assuming format is like 'something_1')
    
    var product_id = '.product_' + r; // Generate the class for the product dropdown
    // console.log("Product ID class:", product_id);
    var unitprice_id = '#unitprice_' + r;
    var warehouse_id = '.whscode-select'; // The warehouse select element
    var productCode = $(product_id + ' option:selected').val(); // Get the selected product code
    if (!productCode) {
        console.error("No product code selected");
        return;
    }

    $.ajax({
            url: "{{ url('admin/ajax/product_stock') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                productCode: productCode,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data.price_list.price);
                if(data.price_list.price != '0')
                {
                    $(unitprice_id).val(data.price_list.price);

                }
                else
                {
                    $(unitprice_id).val(data.price_list.price);
                }
               
            }
        });

    // Initialize the select2 for the warehouse dropdown
    $(warehouse_id).select2({
        ajax: {
            url: "{{ url('admin/ajax/stock') }}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    q: params.term, // search term
                    productCode: productCode, // product term
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.current_page = params.current_page || 1;
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.warehouse.whsName,
                            id: item.whsCode
                        };
                    }),
                    pagination: data.pagination
                };
            },
            cache: true
        },
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: "By searching name, warehouse code",
        allowClear: false
    });

    // If quantity is not zero, reset it and recalculate the price
    var quantityField = $('#quantity_' + r);
    if (quantityField.val() != 0) {            
        quantityField.val(0); // Reset quantity to 0
        price_calc(r); // Recalculate price based on new values
    }
}


    function set_data(r)
    {
        var product_id = '#product_'+r;
        var warehouse_id = '.warehouse_'+r;
        var stock_det = '#stockdet_'+r;
        var uom_id = '.uom_'+r;
        var onhand_id = '.onhand_'+r;
        var Committed_id = '.Committed_'+r;
        var unitprice_id = '#unitprice_'+r;
        var tax_id = '.tax_'+r;
        var discount_id = '.discount_'+r;
        var netunitprice_id = '.netunitprice_'+r;
        var sqftprice_id = '.sqftprice_'+r;
        var productname_id = '#productname_'+r;
        var whsCode = "VNGW0002";
        var productCode = $(product_id+' option:selected').val();
        var price_list = $('#price_list option:selected').val();
        $.ajax({
            url: "{{ url('admin/ajax/product_stock') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                whsCode: whsCode,
                productCode: productCode,
                price_list: price_list,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.product.sqft_Conv == '0')
                {
                    var sqft_Conv = 1;
                }
                else
                {
                    var sqft_Conv = data.product.sqft_Conv;
                }
                /*if(sqft_Conv < 1)
                {
                    //1 = sqft_Conv * $x;
                    var no_tiles_for_sqft = 1/sqft_Conv;
                    var sqft_price = data.price_list.price*((100+parseFloat(data.product.taxRate))/100)*no_tiles_for_sqft;
                    console.log(sqft_price);
                }*/
                //else
                //{                    
                    var sqft_price = (data.price_list.price*((100+parseFloat(data.product.taxcode))/100)/sqft_Conv).toFixed(2);
                //}
                console.log(sqft_Conv);
                $(stock_det).val(JSON.stringify(data));
                $(onhand_id).html(data.itemwarehouse.OnHand);
                $(Committed_id).html(data.blockQty);
                $(uom_id).html(data.product.invUOM);
                $(unitprice_id).val(data.price_list.price);
                $(netunitprice_id).html(data.price_list.price);
                $(sqftprice_id).html(sqft_price);
                $(discount_id).html(0);
                $(tax_id).html(data.product.taxcode);
                $(productname_id).html(data.product.productName);
                //price_calc(r);
            }
        });
    }

    function price_calc(r) {
       
    
    var av_quantity_id = '.av_quantity_' + r;
    var quantity_id = '.quantity_' + r;
    var avqty = '.avqty_' + r;
    var unitprice_id = '.unitprice_' + r;
    var linetotal_id = '.linetotal_' + r;
    var discprice_id = '.discprice_' + r;

    var av_quantity = parseFloat($(av_quantity_id).val()) || 0;
    console.log("available quantity: " + av_quantity); // Check if this logs correctly

    var quantity = parseFloat($(quantity_id).val()) || 0;
    var avqty = parseFloat($(avqty).val()) || 0;
    var unitPrice = parseFloat($(unitprice_id).val()) || 0;

    var productName = $("#product_" + r + " option:selected").text();



    if (parseInt(quantity) > av_quantity) {
            alert("The entered quantity for " + productName + " exceeds the available quantity (" + av_quantity + ").");
            // Optionally, reset the quantity to the available quantity
            $("#quantity_" + r).val(av_quantity);
        }

    var line_total = quantity * unitPrice;

    // Update the line total in the current row
    $(linetotal_id).val(line_total.toFixed(2));
    $(discprice_id).val(unitPrice.toFixed(2));

    // Recalculate the grand total
    calculate_footer();
}


function hiddenprice_calc(r)
{
    var discprice_id = '.discprice_' + r;
    var doc_disc_id = '.doc_disc_' + r;
    var discount = '#discount';

    var disc_price = parseFloat($(discprice_id).val()) || 0;
    var discount_val = parseFloat($(discount).val()) || 0;
    console.log(discount_val);
    if(discount_val== 0)
    {
        var doc_disc = disc_price;
    }
    else
    {
        var doc_disc = disc_price - (disc_price * (discount_val/100));
    }
    $(doc_disc_id).val(doc_disc.toFixed(2));
    calculate_footer()

}




    function calculate_footer()
     {
            console.log("Calculating footer..."); // Debugging

            // Retrieve and parse the input values

           

            let discountPercentage = parseFloat($('#discount').val()) || 0;

            // Initialize total line discount and tax amount
            let totalLineDisc = 0;
            let total_price = 0;
            let total_tax_amount = 0;

            // Iterate through each row to calculate values
            $('.ech-tr').each(function(index) {
                var $row = $(this);

                var bgColor = $row.css('background-color');

                // Only include rows that do not have the 'removed' background color
                if (bgColor !== 'rgb(242, 222, 222)') {
                let $row = $(this);
                let quantity = parseFloat($row.find('[name="quantity[]"]').val()) || 0;
                let unitprice = parseFloat($row.find('[name="unitprice[]"]').val()) || 0;
                let disc_price = parseFloat($row.find('[name="discprice[]"]').val()) || 0;
                let taxcode = parseFloat($row.find('[name="taxcode[]"]').val()) || 0;

                let line_disc = parseFloat($row.find('[name="line_disc[]"]').val()) || 0;

                // Calculate discount based on discount percentage
                let doc_disc = discountPercentage === 0 ? disc_price : disc_price - (disc_price * (discountPercentage / 100));

                // Calculate row amount and line tax amount
                let row_amount_val = quantity * unitprice;
                let line_taxamount_val = row_amount_val * (taxcode / 100);
                let line_disc_val = quantity;// * disc_price;

                // Update calculated values in the row
                $row.find('[name="row_amount[]"]').val(row_amount_val.toFixed(2));
                $row.find('[name="doc_disc[]"]').val(doc_disc.toFixed(2));
                $row.find('[name="line_taxamount[]"]').val(line_taxamount_val.toFixed(2));
                // $row.find('[name="line_disc[]"]').val(line_disc_val.toFixed(2));

                // Accumulate totals
                totalLineDisc += line_disc_val;
                total_price += row_amount_val;
                total_tax_amount += line_taxamount_val;
                }
            });
    
            // $('#grandTotalDisplay').text(totalLineDisc.toFixed(2));
            $('#total_qty').val(totalLineDisc);
            $('#total_price').val(total_price.toFixed(2));
            $('#tax_amount').val(total_tax_amount.toFixed(2));

                 // Get Total Before Discount
            let totalBeforeDiscount = parseFloat($('#total_qty').val()) || 0;
            console.log(totalBeforeDiscount);
            // Get Discount Percentage

            // Calculate Discount Amount
            let discountAmount = (totalBeforeDiscount * discountPercentage / 100).toFixed(2);
            console.log("Discount Amount: " + discountAmount);

            // Set Discount Amount
            $('#discount_amount_value').val(discountAmount);

             // Get the Tax Amount
             let tax_amount = parseFloat($('#tax_amount').val()) || 0;
            console.log("Parsed tax amount:", tax_amount);

            // Get rounding amount
            let roundtext = parseFloat($('#roundtext').val()) || 0;

            // Calculate Grand Total
            let grand_total = (totalBeforeDiscount - discountAmount) + tax_amount + roundtext;
            console.log("Grand Total: " + grand_total);

            // Set Grand Total
            $('#grand_total').val(grand_total.toFixed(2));


    // Update total discount and tax
   
    }

 //calculate_footerdiscount by reshma

function calculate_footerdiscount(val=0)
{
    let totalBeforeDiscount = $('#total_qty').val();
    //let discount_amount = $('#discount_amount').val();
    if (totalBeforeDiscount) {
        totalBeforeDiscount = parseFloat(totalBeforeDiscount);
        let discount = (val * 100 / totalBeforeDiscount).toFixed(2);
        $('#discount').val(discount);

            let tax_amount = parseFloat($('#tax_amount').val()) || 0;
            console.log("Parsed tax amount:", tax_amount);

            // Get rounding amount
            let roundtext = parseFloat($('#roundtext').val()) || 0;
            let rawValue = $('#expense').val();
            let expense = parseFloat(rawValue.trim()) || 0; // Parse expense

            // Calculate Grand Total
            let grand_total = (totalBeforeDiscount - val) + expense + tax_amount + roundtext;
            console.log("Grand Total: " + grand_total);

            // Set Grand Total
            $('#grand_total').val(grand_total.toFixed(2));

    } else {
        console.log("Element not found or text is empty.");
    }
    
    // calculate_footer()
}


    $("#customer-form").submit(function(e){
        e.preventDefault();
        if($('input[name=phone').val() == $('input[name=alt_phone').val())
        {
            alert("Phone and Alt phone should not be same.");
            return false;
        }
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            url: url,
            type:'POST',
            data: form.serialize(),
            success: function(data) {
                $('.alert').html('');
                $(".alert").css('display','block');
                if($.isEmptyObject(data.error)){
                    $('.alert').html(data.success);
                    $('#customer-form').trigger("reset");
                    $.ajax({
                        type:'POST',
                        url:"{{ url('admin/code') }}",
                        data:{_token: "{{ csrf_token() }}",type:'customer'},
                        success:function(data){
                            $('#customer_code').val(data);
                        }
                    });
                    setTimeout(function() {$('#addCustModal').modal('hide');}, 2000);
                }else{
                    $('.alert').html(data.error);
                }
            }
        });
    
    });


    $(document).on("click",".opentr-btn",function(){

        if($(this).closest('.ech-tr').hasClass('open-tr'))
        {         
            $(this).closest('.ech-tr').removeClass('open-tr');
        }
        else{
            $(this).closest('.ech-tr').addClass('open-tr');
        }           
    });

//customer onchange function done by reshma

$('#from_branch').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue) {
        $.ajax({
            url: "{{ url('admin/stockin/ajax/stockout_details') }}",
            type: 'GET',
            data: { branch_code: selectedValue },
            success: function(response) {

                // Assuming the response contains the necessary properties
                if (response) {
                  
                    var stockout = response.stockout;
                    console.log("stockout : "+stockout);
                    if(stockout!="")
                    {
                        $("#copy_from_qutn").css("display", "block");
                        $("#open_quotation").css("display", "none");
                    }
                    else{
                        // $('#grid-container').empty();
                        // $('#total_qty').val("");
                        // $('#total_price').val("");
                        // $('#grid-container').html('No data received.!!');
                        $("#copy_from_qutn").css("display", "none");
                        $("#barcode_verification").css("display", "none");
                        $("#open_quotation").css("display", "none");
                    }

                } else {
                    
                    $('#result').html('Error: No data received.');
                   
                }
                
            },
            error: function() {
                console.log("AJAX request failed");
                $('#result').html('Error: Unable to fetch data.');
            }
        });
    } else {
        $('#result').html('Please select an option.');
    }
});

        // copy from quotation section
        $("#copy_from_qutn").click(function(e) {
            var selectedValue = $('#from_branch').val();

            
            e.preventDefault(); // Prevent default anchor behavior

            $.ajax({
                url: "{{ url('admin/stockin/ajax/branch_open_stock_details') }}",
                type: 'GET',
                data: { branch_code: selectedValue },
                dataType: "json", // Data type expected from server
                success: function(data) { // Change 'quotation' to 'data' here
                    console.log(data);
                    $('#open_quotation').show();
                    $('#open_qutn').attr('required', true);
                    // Clear previous options before appending new ones
                    $('#open_qutn').empty().append('<option disabled>Select Items</option>');

                    // Check if data is not empty
                    if (data.length > 0) {
                        $.each(data, function(index, stockout) {
                            $('#open_qutn').append(
                                $('<option></option>').val(stockout.id).text(stockout.doc_number)
                            );
                        });
                    } else {
                        $('#open_qutn').append('<option value="">No Stock Transfer data available</option>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors
                    console.log("Error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });


        $('#open_qutn').change(function() {
    var selectedValue = $(this).val(); // Get selected value
    if (selectedValue) {
        $.ajax({
            url: "{{ route('admin.ajax.stockin_details') }}", // Update with your endpoint
            type: 'GET',
            data: { stock_out: selectedValue },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    $('#grid-container').empty(); // Clear existing grid items
                    $('#mgrid-container').empty(); // Clear mgrid-container

                    // Step 1: Aggregate the quantities for duplicate product codes only for mgrid-container
                    var groupedItems = [];
                    response.data.forEach(item => {
                        var existingItem = groupedItems.find(groupedItem => groupedItem.productCode === item.productCode);
                        if (existingItem) {
                            existingItem.Qty += item.Qty;
                        } else {
                            groupedItems.push({ ...item });
                        }
                    });

                    // Step 2: Populate grid-container without aggregation
                    $.each(response.data, function(index, item) {
                            $("#remarks").val(item.remarks);
                            $('#partner3').empty();
                            $('#partner3').append(`<option value="${item.sales_emp_id}">${item.partner_name}</option>`);
                            $('#partner3').select2();

                        var i = index;
                        var rowSelector = '#tr_' + i; // Row ID based on index

                        var firstEmptyRow = $('.ech-tr').filter(function() {
                            return $(this).find('input[name="quantity[]"]').val() === '';
                        }).first();

                        $("#barcode_verification").css("display", "block");

                        if (firstEmptyRow.length > 0) {
                            firstEmptyRow.find('#quantity_' + i).val(item.Qty);
                            firstEmptyRow.find('#unitprice_' + i).val(item.UnitPrice);
                            var productSelect = firstEmptyRow.find('#product_' + i);
                            if (productSelect.length > 0) {
                                if (!productSelect.find(`option[value='${item.productCode}']`).length) {
                                    productSelect.append(new Option(item.productName, item.productCode));
                                }
                                productSelect.val(item.productCode);
                            } else {
                                console.error(`Product select box not found for row ${i}`);
                            }
                        } else {
                            var rowHtml = `
                                <div class="ech-tr" id="tr_${i}">
                                    <div class="echtr-inn">
                                        <div class="row">
                                            <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                                <div class="ech-td">
                                                    <span class="btn opentr-btn"></span>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Item(s) <span class="text-danger">*</span></label>
                                                    
                                                    <div class="td-value">
                                                        <input type="hidden" id="quotation_item_id_${i}" required class="quotation_item_id_${i} form-control" value="${item.itemid}" name="quotation_item_id[]">
                                                        <select id="product_${i}" required name="product[]" class="product_${i} itemSelect form-control select2" onChange="load_warehouse(${i})">
                                                            <option value="${item.productCode}">${item.productName}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">Quantity <span class="text-danger">*</span></label>
                                                    <div class="td-value">
                                                        <input type="hidden" id="av_quantity_${i}" required class="av_quantity_${i} form-control" value="${item.Qty}" name="av_quantity[]">
                                                        <input type="number" id="quantity_${i}" required class="quantity_${i} form-control" value="${item.Qty}" onchange="price_calc(${i})" name="quantity[]" >
                                                        <input type="hidden" id="unitprice_${i}" required class="unitprice_${i} form-control" value="${item.UnitPrice}" onkeyup="price_calc(${i})" name="unitprice[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">WHSE <span class="text-danger">*</span></label>
                                                    <div class="td-value">
                                                        <select class="form-control whscode-select" name="whscode[]" id="whscode_${i}" required>
                                                            <option value="${item.whsCode}">${item.whsName}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Barcode</label>
                                                    <div class="td-value">
                                                        <input type="text" id="barcode_${i}" class="barcode_${i} form-control" name="barcode[]" value="${item.barcode}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="ech-td">
                                                    <label class="td-label">Serial No</label>
                                                    <div class="td-value">
                                                        <input type="text" id="serialno_${i}" class="serialno_${i} form-control" name="serialno[]" value="${item.serialno}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#grid-container').append(rowHtml);
                        }
                    });

                    // Step 3: Populate mgrid-container with aggregated data only
                    $.each(groupedItems, function(index, item) {
                        console.log(item);
                        var i = index;
                        var existingMRow = $('#mgrid-container').find(`input[name="mproductcode[]"][value="${item.productCode}"]`).closest('.ech-tr');

                        if (existingMRow.length > 0) {
                            var existingQty = parseInt(existingMRow.find(`.mquantity_${i}`).val()) || 0;
                            var newQty = existingQty + item.Qty;
                            existingMRow.find(`.mquantity_${i}`).val(newQty);
                            existingMRow.find(`.mdquantity_${i}`).val(newQty);
                        } else {
                            var mrowHtml = `
                                <div class="ech-tr" id="tr_${i}">
                                    <div class="echtr-inn">
                                        <div class="row">
                                            <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                                ${i+1}
                                            </div>
                                            <div class="colbor col-xl-4 col-lg-5 col-md-5 col-sm-6 col-11">
                                                <div class="ech-td">
                                                    <label class="td-label">Item</label>
                                                    <div class="td-value">
                                                        <input type="hidden" id="quotation_item_id_${i}" class="quotation_item_id_${i} form-control" value="${item.itemid}" name="quotation_item_id[]">
                                                        <input type="text" id="mproduct_${i}" class="mproduct_${i} form-control" value="${item.productName}" data-value="${item.productCode}" name="mproduct[]" readonly>
                                                        <input type="hidden" id="mproductcode_${i}" class="mproductcode_${i} form-control" value="${item.productCode}" name="mproductcode[]">
                                                        <input type="hidden" id="mbarcode_${i}" class="mbarcode_${i} form-control" value="${item.barcode}" name="mbarcode[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">ReceiptQty</label>
                                                    <div class="td-value">
                                                        <input type="number" id="mquantity_${i}" class="mquantity_${i} form-control" value="${item.Qty}" name="mquantity[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">ScannedQty</label>
                                                    <div class="td-value">
                                                        <input type="number" id="msquantity_${i}" class="msquantity_${i} form-control" value="0" name="msquantity[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-5 col-7">
                                                <div class="ech-td">
                                                    <label class="td-label">DifferenceQty</label>
                                                    <div class="td-value">
                                                        <input type="number" id="mdquantity_${i}" class="mdquantity_${i} form-control" value="${item.Qty}" name="mdquantity[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#mgrid-container').append(mrowHtml);
                        }
                    });

                    // Step 4: Calculate the footer totals
                    calculate_footer(); // Update totals
                } else {
                    console.log("No items found in response.");
                    $('#grid-container').empty(); 
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", error);
            }
        });
    }
});


function updateLineTotal(row) {
    var qty = parseFloat(row.find('.qty-input').val()) || 0;
    var unitPrice = parseFloat(row.find('.unitprice-input').val()) || 0;
    var lineTotal = (qty * unitPrice).toFixed(2);

    // Update the line total
    row.find('.linetotal').text(lineTotal);
}

function calculateGrandTotal(val) {

    var total_price = 0;
var total_qty = 0;

$('#grid-container .ech-tr').each(function() {
    var $row = $(this);

    // Get the background color of the row
    var bgColor = $row.css('background-color');

    // Only include rows that do not have the 'removed' background color
    if (bgColor !== 'rgb(242, 222, 222)') { // 'rgb(242, 222, 222)' is the RGB equivalent of '#f2dede'
        // Use .val() if 'quantity' and 'unitprice' are input fields
        var quantity = parseFloat($row.find('[name="quantity[]"]').val()) || 0;
        var unitprice = parseFloat($row.find('[name="unitprice[]"]').val()) || 0;

        console.log("Quantity:", quantity);
        console.log("Unit Price:", unitprice);

        total_price += quantity * unitprice;
        total_qty += quantity;
    }
});

console.log("Total Price:", total_price);
$('#total_price').val(total_price.toFixed(2));
$('#total_qty').val(total_qty);

}


let inputTimeout;

$('#scan_here').on('keyup', function(e) {
    clearTimeout(inputTimeout); // Clear the timeout on each input event
  
    var $input = $(this); // Cache the jQuery object for the input element
    if (!$input.val().trim()) {
        // Clear the error message if the input is empty
        $("#erbarcode").html('');
        return; // Exit early to avoid unnecessary API calls
    }
    // Set a timeout to delay the API call until the user has finished typing
    inputTimeout = setTimeout(function() {
        var inputValue = $input.val(); // Get the input value inside the timeout function
        if (inputValue) {
            // Make the API call
            $.ajax({
                url: "{{ url('admin/stock-in/get_bproduct_details') }}",
                method: 'GET', // or 'POST', depending on your API
                data: { query: inputValue }, // Send the input value as data
                success: function(response) {
                   
                    if (response && response.length > 0) {
                        $("#erbarcode").html("");

                        // console.log(response);
                        $.each(response, function(index, item) {
                            console.log(item);
                            var exists = false;

                            // Check if the item is already in the grid
                            $('#productname_0').each(function() {
                                if ($(this).text() === item.productName) {
                                    exists = true; // Product already exists
                                }
                            });

                            if (!exists) {
                                var i = $('.ech-tr').length || 0;
                                // console.log("price : " + item.price);
                                document.getElementById("quantity_0").removeAttribute("readonly");
                                if (i === 1 && $('#productname_0').text() === "") {
                                    i++;
                                    // Populate the first row if the grid is empty
                                    $('#productname_0').text(item.productName);
                                    $('#product_0').html(`<option value="${item.productCode}">${item.productName}</option>`);
                                    $('#quotation_item_id_0').val(item.itemid);
                                    $('#quantity_0').val('');
                                    
                                    $('#unitprice_0').val(item.price);
                                    $('#barcode_0').val(item.barcode);
                                    $('#avqty_0').val(item.OnHand);
                                    $('#serialno_0').val(item.serial_no);
                                    $('#discprice_0').val('');
                                    $('#taxcode_0').val('12'); // Set default tax code or use item-specific tax code
                                    $('#whscode_0').html(`<option value="${item.whsCode}">${item.whsName}</option>`);
                                    $('#linetotal_0').val(item.LineTotal);
                                } else { 
                                    
                                    // Append new rows if the grid already has rows
                                    var rowHtml = `
                                    <div class="ech-tr" id="tr_${i}">
                                    <div class="echtr-inn">
                                        <div class="row">
                                            <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                                <div class="ech-td">
                                                    <span class="btn opentr-btn"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Item(s)</label>
                                                    
                                                    <div class="td-value">
                                                        <input type="hidden" id="quotation_item_id_${i}" required class="quotation_item_id_${i} form-control" value="${item.itemid}" name="quotation_item_id[]">
                                                        <select id="product_${i}" required name="product[]" class="product_${i} itemSelect form-control select2" onChange="load_warehouse(${i})">
                                                            <option value="${item.productCode}">${item.productName}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">Quantity</label>
                                                    <div class="td-value">
                                                        <input type="hidden" id="av_quantity_${i}" required class="av_quantity_${i} form-control" value="${item.Qty}" name="av_quantity[]">
                                                        <input  type="number" id="quantity_${i}" required class="quantity_${i} form-control" value="" onchange="price_calc(${i})" name="quantity[]">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                             <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">WHSE</label>
                                                <div class="td-value">
                                                    <select class="form-control whscode-select" name="whscode[]" id="whscode_${i}">
                                                        <option value="${item.whsCode}">${item.whsName}</option>
                                                    </select>
                                                    <input type="hidden" id="unitprice_${i}" class="unitprice unitprice_${i} form-control" name="unitprice[]" readonly="" value="${item.price}">
                                                     <input type="hidden" id="avqty_${i}" class="avqty avqty_${i} form-control" name="avqty[]" readonly="" value="${item.OnHand}">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Barcode</label>
                                                <div class="td-value">
                                                    <input type="text" id="barcode_${i}"  class="barcode_${i} form-control" name="barcode[]" value="${item.barcode}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="colbor col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Serial No</label>
                                                <div class="td-value">
                                                    <input type="text" id="serialno_${i}"  class="serialno_${i} form-control" name="serialno[]" value="${item.serial_no ? item.serial_no : ''}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                        </div>
                                    <div class="actn-td">
                                        <a href="javascript:void(0);" class="action-icon add-item"></a>
                                        <a href="javascript:void(0);" class="action-icon delete-item" value="${item.itemid}"></a>
                                    </div>
                                </div>`;
                                    $('#grid-container').append(rowHtml);

                                    // Reapply event bindings for new rows
                                    reapplyEventHandlers(i);
                                }

                                // Trigger footer calculation or any other post-processing function
                                calculate_footer();
                            } else {
                                console.log("Item already exists in the grid");
                            }
                        });

                        // Clear the input value after scanning
                        $('#scan_here').val('');
                        $("#erbarcode").html('');
                    } else {
                        $("#erbarcode").html("Invalid Barcode !!");
                        console.log("No items found in response.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    }, 300); // Adjust the timeout as necessary (300ms delay in this case)
});


function reapplyEventHandlers(i) {
    // Example: rebind events for dynamically added elements
    $(`#quantity_${i}`).on('keyup', function() {
        price_calc(i); // Rebind price calculation
    });

    $(`#discprice_${i}`).on('keyup', function() {
        hiddenprice_calc(i); // Rebind Discounted Price calculation
    });

    $(`#taxcode_${i}`).on('change', function() {
        calculate_footer(); // Recalculate footer on tax change
    });
}





$(document).on('click', '.remove-row', function(e) {
    e.preventDefault(); // Prevent the default action

    var itemValue = $(this).attr('value'); // Get the value from the clicked button
    var $row = $(this).closest('.ech-tr'); // Find the closest parent with the class 'ech-tr'
    var dataValue = this.getAttribute('data-value'); // Get data-value for further processing

    // Get all data for insertion (you can adjust based on your table structure)
    var rowData = {
        item: itemValue,
        rowData: [] // Collect all the row's data that you want to insert into the database
    };

    // Loop through the row's cells and get their values
    $row.find('td').each(function(index, cell) {
        rowData.rowData.push($(cell).text()); // Push the text of each cell into the rowData array
    });

    // AJAX call for closing the Stock In item and inserting data into the database
    $.ajax({
        url: "{{ url('admin/ajax/stockout_close_items') }}",
        type: 'POST',
        data: {  
            _token: "{{ csrf_token() }}",
            item: itemValue,
            rowData: rowData.rowData // Send the row data to the backend
        },
        dataType: "json", // Data type expected from server
        success: function(data) { 
            console.log("AJAX Success:", data);

            // Change the background color of the selected row
            $row.css('background-color', '#f2dede'); // Red color to indicate removal

            // Recalculate grand total if needed
            calculateGrandTotal(dataValue);

            // Remove the row after a delay
            setTimeout(function() {
                $row.remove(); // Remove the row from the DOM
            }, 500); // Delay for visual effect
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle any errors
            console.log("Error: " + textStatus + ' : ' + errorThrown);
        }
    });
});


    $('#rounding_check').change(function() {
            if ($(this).is(':checked')) {
                $('#roundtext').show();
                $('#roundtext').attr('required', 'required');
            } else {
                $('#roundtext').hide();
                $('#roundtext').removeAttr('required');
                // Get the value entered in the roundtext field, or 0 if empty
                let roundtext = parseFloat($('#roundtext').val()) || 0;

                // Get the current grand total, or 0 if it's not a number
                let grand_total = parseFloat($('#grand_total').val()) || 0;

                // Calculate the new total by subtracting the roundtext value from the grand total
                let total = grand_total - roundtext;

                // Ensure total is a valid number before calling toFixed
                if (!isNaN(total)) {
                    total = total.toFixed(2);
                } else {
                    total = '0.00'; // Fallback if something went wrong
                }

                // Update the grand total with the new total
                $('#grand_total').val(total);

                // Optionally, clear the roundtext value
                $('#roundtext').val('');
            }
});
let count = 0;
$('#sbarcode').on('keydown', function(e) {
    // Check if the Tab key (key code 9) is pressed
    if (e.keyCode === 9) {
        // Prevent default tab behavior
        e.preventDefault();

        var $input = $(this);

        // Perform barcode check logic
        checkBarcode($input);
    }
});

function checkBarcode($input) {
    var inputValue = $input.val().trim(); // Get the trimmed input value
    
    // Reset count each time the input changes
    count = 0;

    // Check if there is an input value
    if (inputValue) {
        $('#mgrid-container .ech-tr').each(function() {
            var $row = $(this);

            // Retrieve the barcode value from each row
            var productBarcode = $row.find('[name="mbarcode[]"]').val().trim();

            // Compare entered barcode with each product's barcode
            if (productBarcode === inputValue) {
                count++;
                
                // Set ScannedQty to 1 or increment if already set
                var scannedQty = parseFloat($row.find('[name="msquantity[]"]').val()) || 0;
                $row.find('[name="msquantity[]"]').val(scannedQty + 1);

                // Retrieve ReceiptQty and calculate DifferenceQty
                var receiptQty = parseFloat($row.find('[name="mquantity[]"]').val()) || 0;
                var differenceQty = receiptQty - (scannedQty + 1);

                // Set DifferenceQty for the matched row
                $row.find('[name="mdquantity[]"]').val(differenceQty);
            }
        });

        // Display the count or take any necessary action
        console.log("Count of matching barcodes:", count);
    }

    // Clear the sbarcode input field
    $input.val('');
}



let dcount = 0;
$('#dbarcode').on('keydown', function(e) {
    // Check if the Tab key (key code 9) is pressed
    if (e.keyCode === 9) {
        // Prevent default tab behavior
        e.preventDefault();

        var $input = $(this);

        // Perform barcode check logic
        checkdBarcode($input);
    }
});

function checkdBarcode($input) {
    var inputValue = $input.val().trim(); // Get the trimmed input value
    
    // Reset count each time the input changes
    dcount = 0;

    // Check if there is an input value
    if (inputValue) {
        $('#mgrid-container .ech-tr').each(function() {
            var $row = $(this);

            // Retrieve the barcode value from each row
            var productBarcode = $row.find('[name="mbarcode[]"]').val().trim();

            // Compare entered barcode with each product's barcode
            if (productBarcode === inputValue) {
                dcount--;
                
                // Set ScannedQty to 1 or increment if already set
                var scannedQty = parseFloat($row.find('[name="msquantity[]"]').val()) || 0;
                $row.find('[name="msquantity[]"]').val(scannedQty - 1);

                // Retrieve ReceiptQty and calculate DifferenceQty
                var receiptQty = parseFloat($row.find('[name="mquantity[]"]').val()) || 0;
                var differenceQty = receiptQty - (scannedQty - 1);

                // Set DifferenceQty for the matched row
                $row.find('[name="mdquantity[]"]').val(differenceQty);
            }
        });

        // Display the count or take any necessary action
        console.log("Count of matching barcodes:", count);
    }
    $input.val('');
}

// Form submission check for DifferenceQty > 0
$('#barcodeFormIds').on('submit', function(e) {
    let hasDifference = false;
    let differenceMsg = '';

    // Check each row for any DifferenceQty > 0
    $('#mgrid-container .ech-tr').each(function() {
        var $row = $(this);
        var differenceQty = parseFloat($row.find('[name="mdquantity[]"]').val()) || 0;

        if (differenceQty != 0) {
            var productName = $row.find('[name="mproduct[]"]').val();
            differenceMsg += `Product "${productName}" has a quantity difference of ${differenceQty}.\n`;
            hasDifference = true;
        }
    });

    // If there's any quantity difference, alert the message and prevent form submission
    if (hasDifference) {
        e.preventDefault();
        alert(differenceMsg);

    }

let formData = new FormData();

    // Append individual form field values
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('rnumber', $('#rnumber').val());

    // Append grid data fields
    $('#mgrid-container .ech-tr').each(function(index) {
        formData.append(`items[${index}][quotation_item_id]`, $(this).find('[name="quotation_item_id[]"]').val());
        formData.append(`items[${index}][mproduct]`, $(this).find('[name="mproduct[]"]').val());
        formData.append(`items[${index}][mproductcode]`, $(this).find('[name="mproductcode[]"]').val());
        formData.append(`items[${index}][mbarcode]`, $(this).find('[name="mbarcode[]"]').val());
        formData.append(`items[${index}][mquantity]`, $(this).find('[name="mquantity[]"]').val());
        formData.append(`items[${index}][msquantity]`, $(this).find('[name="msquantity[]"]').val());
        formData.append(`items[${index}][mdquantity]`, $(this).find('[name="mdquantity[]"]').val());
    });

    // Send AJAX request
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/stock-in/barcode_vefication_data') }}", // Your route URL
        data: formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        success: function(response) {
            alert("Data saved successfully!");
            $('#barcodeFormIds')[0].reset(); // Optional: reset form after submission
            $('#barcode_verifications').modal('hide');
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
        }
    });


});
</script>
@endsection
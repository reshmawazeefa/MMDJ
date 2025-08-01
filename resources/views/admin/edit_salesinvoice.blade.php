@extends('layouts.vertical', ["page_title"=> "Sales Invoice Create"])

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

@section('content')<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{url('admin/sales-order')}}">Sales Invoice</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Sales Invoice</h4>
                @if(!empty($errors->all()))
                    <p class="alert alert-danger error">
                    @foreach($errors->all() as $error)
                      🔸 {{$error}} 
                    @endforeach
                    </p>
                    @endif
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <!-- @if(!empty($errors->all()))
            <p class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
            </p>
            @endif -->
            
            <div class="card">
                    <form method="post" class="parsley-examples" action="{{url('admin/sales-invoice/'.$details->id.'/update')}}">
                        {{csrf_field()}}
                        <div class="card-body body-style">
                            <div class="row mb-3">


                                <!-- new start -->
                                <div class="col-lg-4">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-5 col-form-label">
                                        Customer <span class="text-danger">*</span>
                                        <!-- <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addCustModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a> -->
                                        </label>
                                        <div class="col-sm-7">
                                        <select required name="customer" id="customer" class=" form-control select2"><option value="{{$details->customer->customer_code}}">{{$details->customer->name}}</option>
                                        </select> 
                                        </div>
                                    </div>
                                    <div class="form-group row" style="display: none;">
                                        <label for="referral" class="col-sm-5 col-form-label">
                                        Ref/LPO No. 
                                        </label>
                                        <div class="col-sm-7">
                                        <input   type="text" class="form-control" name="refno" placeholder="Ref/LPO No." aria-describedby="basic-addon1" value="{{$details->ref_no}}">
                                        </div>
                                    </div> 
                                   
                                    <div class="form-group row">
                                        <label for="referral" class="col-sm-5 col-form-label">
                                        Address <span class="text-danger">*</span>
                                        </label>
                                

                                        <div class="col-sm-7">
                                                                    <textarea class="form-control" name="bill_to_address" id="bill_to_address" style="height: 52px !important;" readonly>{{$details->customer->addressIDBilling}}&#13;&#10;{{$details->customer->addressBilling}}&#13;&#10;{{$details->customer->zip_codeBilling}}</textarea>
                                                                    </div>
                                    </div>
                                    @php
                                        $docNum = $details->doc_num;
                                        $arr = explode('-',$docNum);
                                    @endphp


                                        <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-5 col-form-label">Doc Number <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                        <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
                                                <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
                                            </div>
                                    </div>
                                    </div>
                                </div>
                          
                                <div class="col-lg-4">
                                
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-5 col-form-label">DocDue Date <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                            <input required type="date" name="delivery_date" id="delivery_date"  class="form-control flatpickr-input active" value="{{$details->delivery_date}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="docdate" class="col-sm-5 col-form-label">Document Date <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                            <input required type="date" name="DocuDate" class="form-control flatpickr-input active" value="{{ \Carbon\Carbon::parse($details->doc_date)->format('Y-m-d') }}" >
                                            </div>
                                        </div>

                                        <div class="form-group row" style="display: none;">
                                            <label for="posting_date" class="col-sm-5 col-form-label">Payment Term <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                            <select  id="payment_term" name="payment_term" class="form-control select">
                                                <option value="cash" @if($details->payment_term == "cash") selected @endif >Cash</option>
                                                <option value="60" @if($details->payment_term == "60") selected @endif>Net-60 Days</option>
                                                <option value="90" @if($details->payment_term == "90") selected @endif>Net-90 Days</option>
                                                <option value="30" @if($details->payment_term == "30") selected @endif>Net-30 Days</option>
                                                <option value="120" @if($details->payment_term == "120") selected @endif>Net-120 Days</option>
                                            </select>
                                            </div>
                                        </div>


                                        <div class="form-group row" style="display: none;">
                                            <label for="posting_date" class="col-sm-5 col-form-label">TAX Reg No </label>
                                            <div class="col-sm-7">
                                            <input  type="text" name="tax_reg_no"  class="form-control" value="{{$details->tax_regno}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 mt-1">
                                            <a class="btn btn-primary waves-effect waves-light mb-0 qutt-bttn" id="copy_from_qutn" name="copy_from_qutn">Copy from Quotation</a>
                                            </div>
                                            <div class="col-sm-12" id="open_quotation">
                                            <select style="height: 54px;" name="open_qutn" id="open_qutn" class="open_qutnSelect form-control select2" multiple>
                                            </select>
                                            </div>
                                        </div>

                                </div>

                                <!-- new end -->
                            </div>

 <div class="col-lg-12">   
                            <input type="hidden" id="count" value="0">
                            <div class="new-table">
                                                
                                            @php
                                            $count = count($details->Item_details);
                                            @endphp
                                            @if(count($details->Item_details) > 0)
                                                @php $i = 0; @endphp
                                                @foreach ($details->Item_details as $val)
                                                <div id="grid-container">
                                                                        <input type="hidden" name="line_id[]" value="{{$val->id}}">
                                                                        <div class="ech-tr" id="tr_{{$i}}">
                                                
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
                                                                                                <option value="{{$val->products->productCode}}">{{$val->products->productName}}</option>
                                                                                            </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Unit <span class="text-danger">*</span></label>
                                                                                            <div class="td-value">
                                                                                            <span class="unit_{{$i}}"></span>
                                                                                            <select class="unit_{{$i}} form-control unit-select" name="unit[]" id="unit_{{$i}}" required>
                                                                                            <option value="{{$val->unit}}">{{$val->unit}}</option>

                                                                                            </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Quantity <span class="text-danger">*</span></label>
                                                                                            <div class="td-value">
                                                                                            <input min="0.1" type="number" step="any"   id="quantity_{{$i}}" required class="quantity_{{$i}} form-control" onChange="price_calc({{$i}})" name="quantity[]" value="{{$val->qty}}">

                                                                                            <input min="0.1" type="hidden" id="pquantity_{{$i}}" required class="pquantity_{{$i}} form-control" name="pquantity[]" value="{{$val->qty}}">
                                                                                        
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> 
                                                                                                                
                                                                                    
                                                                                    <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-8 col-12">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Unit Price <span class="text-danger">*</span></label>
                                                                                            <div class="td-value">
                                                                                            <!-- <span class="unitprice_{{$i}}"></span> -->
                                                                                            <input type="number"  step="0.01"  id="unitprice_{{$i}}" required class="unitprice_{{$i}} form-control" onChange="price_calc({{$i}})" name="unitprice[]" value="{{$val->unit_price}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">
                                                                                            <div class="ech-td">
                                                                                                <label class="td-label">Discounted Price <span class="text-danger">*</span></label>
                                                                                                <div class="td-value">
                                                                                                    <input type="number"  step="0.01"  id="discprice_{{$i}}" required class="discprice_{{$i}} form-control"  onChange="hiddenprice_calc({{$i}})" name="discprice[]" value="{{$val->disc_price}}">
                                                                                                </div>
                                                                                            
                                                                                            </div>
                                                                                        </div>
                                                                                        <input type="hidden" name="doc_disc[]" class="doc_disc_{{$i}}">
                                                                                        <input type="hidden" name="row_amount[]" class="row_amount_{{$i}}">
                                                                                        <input type="hidden" name="line_taxamount[]" class="line_taxamount_{{$i}}">
                                                                                        <input type="hidden" name="line_disc[]" class="line_disc_{{$i}}">
                                                
                                                                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Tax Code</label>
                                                                                            <div class="td-value">
                                                                                            <select class="form-control taxcode-select" name="taxcode[]" id="taxcode_{{$i}}" onchange="calculate_footer()">
                                                                                                <option value="0" @if($val->tax_code == "0") selected @endif>EXEMPT</option>
                                                                                                
                                                                                            </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10" style="display: none;">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">WHSE <span class="text-danger">*</span></label>
                                                                                            <div class="td-value">
                                                                                            <span style="display:none;" class="discount_{{$i}}"></span>
                                                                                            <span class="whscode_{{$i}}"></span>
                                                                                            <!-- <select class="form-control whscode-select" name="whscode[]" id="whscode" ><option value="{{$val->whs_code}}">{{$val->whs_code}}</option></select> -->

                                                                                            <input type="text"  id="whscode_{{$i}}" class="whscode whscode_{{$i}} form-control" name="whscode[]" readonly="" value="{{$val->whs_code}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-9 col-lg-3 col-md-12 col-sm-12 col-12">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Line Total</label>
                                                                                            <div class="td-value">
                                                                                            <!-- <span class="linetotal linetotal_{{$i}}"></span> -->
                                                                                            <input type="number"  step="0.01"  id="linetotal_{{$i}}"  class="linetotal linetotal_{{$i}} form-control" name="linetotal[]" value="{{$val->line_total}}" readonly>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10" style="display: none;">
                                                                                        <div class="ech-td">
                                                                                            <label class="td-label">Serial No</label>
                                                                                            <div class="td-value">
                                                                                            <span class="serialno_{{$i}}"></span>
                                                                                            <input type="text" id="serialno_{{$i}}"  class="serialno_{{$i}} form-control"  name="serialno[]" value="{{$val->serial_no}}">
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
                                                    @php $i++; @endphp
                                                @endforeach
                                            @endif

                            </div>
                        </div>
                        
                                <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label for="partner3" class="col-sm-5 col-form-label">Sales Employee </label>
                                                <div class="col-sm-7">
                                            
                                                <input type="text" id="partner3" name="partner3" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="remarks" class="col-sm-5 col-form-label">Remarks</label>
                                                <div class="col-sm-7">
                                                <textarea placeholder="Remarks" type="text" name="remarks" class="form-control">{{$details->remarks}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label for="total_bef_discount" class="col-sm-6 col-form-label">Total Before Discount</label>
                                                <div class="col-sm-6">
                                                <input type="number"  step="0.01"  name="total_bef_discount" class="form-control" id="total_bef_discount" readonly value="{{$details->total_bf_discount}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="discount" class="col-sm-6 col-form-label">Discount 
                                                <input type="number"  step="0.01"  name="discount" id="discount" style="width: 45%;margin-left: 3px;border: 1px solid #ced4da; border-radius: 3px;" placeholder="0.00" onChange="calculate_footer();" value="{{$details->discount_percent}}"> %
                                                </label>
                                                <div class="col-sm-6" id="discount_amount">
                                                <input type="number"  step="0.01"  name="discount_amount_value" id="discount_amount_value" class="form-control" onChange="calculate_footerdiscount(this.value);" value="{{$details->discount_amount}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="expense" class="col-sm-6 col-form-label">Extra Expense</label>
                                                <div class="col-sm-6" id="expenses">
                                                <input type="number"  step="0.01"  name="expense" onChange="calculate_footer();" id="expense" class="form-control" value="{{$details->total_exp}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label for="tax_amount" class="col-sm-6 col-form-label">Tax Amount</label>
                                                <div class="col-sm-6">
                                                <input type="number"  step="0.01"  name="tax_amount" id="tax_amount" class="form-control" readonly value="{{$details->tax_amount}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="rounding_check" class="col-sm-6 col-form-label">
                                                <input type="checkbox" id="rounding_check" name="option1" value="value1" style="margin-right:10px" @if($details->rounding != "") checked @endif> Rounding
                                                </label>
                                                <div class="col-sm-6" id="rounding">
                                                <input type="number"  step="0.01"  name="roundtext" onChange="calculate_footer();" id="roundtext" class="form-control" @if($details->rounding == "") style="background-color: #ebebeb;
                                                border: 1px solid #ebebeb; color:#000;"@endif @if($details->rounding != "") style="display: block;" @else style="display: none;" @endif value="{{$details->rounding}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="grand_total" class="col-sm-6 col-form-label">Total</label>
                                                <div class="col-sm-6">
                                                <input type="number"  step="0.01"  name="grand_total" id="grand_total" class="form-control" readonly value="{{$details->total}}">
                                                </div>
                                            </div>
                                        </div>                                         
                                </div>


                                <div class="col-12 edit-salesbtnstyle">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Update</button>
                                </div>
                            
                        </div>
    
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

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
        $("#copy_from_qutn").css("display", "none");
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
        $('select[name=vehicle_type]').change(function(){
            if(this.value == 'N/A')
            {
                $('input[name=km]').attr('required', false);
                $('label[for=distance] span[class=text-danger]').html('');
            }
            else{
                $('input[name=km]').attr('required', true);
                $('label[for=distance] span[class=text-danger]').html('*');
            }
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

        $(".engineerSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/partners/engineer') }}",
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

        $(".contractorSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/partners/contractor') }}",
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
//  +'<div style="display:none">'
//                                 +'<span class="taxable_'+val+'"></span><span class="discwithouttax_'+val+'"></span><span class="tax_'+val+'"></span>'
//                                 +'<span class="taxamount_'+val+'"></span><span class="netprice_'+val+'"></span>'
//                                 +'<input type="hidden" name="LineTotal[]" class="linetotal_'+val+'">'
//                             +'</div>'
    var html = '<div class="ech-tr" id="tr_'+val+'">'
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
                                            +'<div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Unit <span class="text-danger">*</span></label>'
                                            +'<div class="td-value">'
                                            +'<select id="unit_'+val+'" " required  name="unit[]" class="unit_'+val+' unit-select form-control select2"></select></div></div></div>'
                                     
                                    +'<div class="colbor col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Quantity <span class="text-danger">*</span></label>'
                                            +'<div class="td-value"><input min="0.1" type="number" step="any"  id="quantity_'+val+'" required class="quantity_'+val+' form-control" onChange="price_calc('+val+')" name="quantity[]"></div></div></div>' 
                                            +'<input min="0.1" type="hidden" id="pquantity_'+val+'" required class="pquantity_'+val+' form-control" name="pquantity[]" >'
                                    +'<div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-8 col-12">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Unit Price <span class="text-danger">*</span></label>'
                                            +'<div class="td-value"><input min="0.1" type="number"  step="0.01"  id="unitprice_'+val+'" required class="unitprice_'+val+' form-control" onChange="price_calc('+val+')" name="unitprice[]"></div></div></div>' 
                                            +'<div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">'
                                            +'<div class="ech-td">'
                                                +'<label class="td-label">Discounted Price <span class="text-danger">*</span></label>'
                                                +'<div class="td-value"><input type="number"  step="0.01"  id="discprice_'+val+'" required class="discprice_'+val+' form-control"  onChange="hiddenprice_calc('+val+')" name="discprice[]"></div></div></div>'
                                         +'<input type="hidden" name="doc_disc[]" class="doc_disc_'+val+'"><input type="hidden" name="row_amount[]" class="row_amount_'+val+'">'
                                        +'<input type="hidden" name="line_taxamount[]" class="line_taxamount_'+val+'"><input type="hidden" name="line_disc[]" class="line_disc_'+val+'">'
                                    
                                    +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">TaxCode</label>'
                                            +'<div class="td-value"><select class="form-control taxcode-select" id="taxcode_'+val+'" onchange="calculate_footer()" name="taxcode[]" ><option value="0">EXEMPT</option></select> </div></div></div>'
                                    
                                    +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12" style="display: none;">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">WHSE <span class="text-danger">*</span></label>'
                                            +'<div class="td-value"> <input type="text"  id="whscode_'+val+'" class="whscode whscode_'+val+' form-control" name="whscode[]" readonly="" > </div></div></div>'

                                    +'<div class="colbor col-xl-9 col-lg-3 col-md-12 col-sm-12 col-12">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Line Total</label>'
                                            +'<div class="td-value"><input type="number"  step="0.01"  id="linetotal_'+val+'"  class="linetotal linetotal_'+val+' form-control" name="linetotal[]" readonly></div></div></div>'
                                    +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12" style="display: none;">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Serial No</label>'
                                            +'<div class="td-value"><input min="0.1" type="text" id="serialno"  class="serialno_'+val+' form-control"  name="serialno[]"></div></div></div>'

                                    
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


    var r = val; // Extract the row number (assuming format is like 'something_1')
    
    var product_id = '.product_' + r; // Generate the class for the product dropdown
    console.log("Product ID class:", product_id);
    var avqty = '#av_quantity_' + r;
    var unitprice_id = '#unitprice_' + r;
    var unit = '#unit_' + r;


    var warehouse_id = '#whscode_' + r; // The warehouse select element
    var productCode = $(product_id + ' option:selected').val(); // Get the selected product code
    
    if (!productCode) {
        console.error("No product code selected");
        return;
    }



    // Initialize the select2 for the warehouse dropdown
    $.ajax({
    url: "{{ url('admin/product/product_details') }}",
    type: 'GET',
    data: {
        "_token": "{{ csrf_token() }}",
        productCode: productCode,
    },
    dataType: 'json',
    success: function(data) {
        console.log(data);
        
        // ✅ Set Available Quantity
        $('#av_quantity_' + r).val(data.OnHand);

        // ✅ Set Unit Price
        if (data.price_list && data.price_list.price != '0') {
            $('#unitprice_' + r).val(data.price_list.price);
        } else {
            $('#unitprice_' + r).val('');
        }

        if (data.stock && data.stock.whsCode != '') {
            $(warehouse_id).val(data.stock.whsCode);
        } else {
            $(warehouse_id).val('');
        }

        // ✅ Populate Unit Select Box
        var unitSelect = $(unit); // Ensure jQuery selector
        unitSelect.html('<option value="">Select Unit</option>'); // Clear previous options & add default

        if (data.price_list.unit) {
            unitSelect.append('<option value="' + data.price_list.unit + '" selected>' + data.price_list.unit + '</option>');
        }

        // ✅ If multiple units exist in an array (modify if needed)
        if (data.price_list.units && Array.isArray(data.price_list.units)) {
            data.price_list.units.forEach(function(unitValue) {
                unitSelect.append('<option value="' + unitValue + '">' + unitValue + '</option>');
            });
        }
    }
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

    function price_calc(r) 
    {
      
    var av_quantity_id = '.pquantity_' + r;
    var quantity_id = '.quantity_' + r;
    var unitprice_id = '.unitprice_' + r;
    var linetotal_id = '.linetotal_' + r;
    var discprice_id = '.discprice_' + r;

    var av_quantity = parseFloat($(av_quantity_id).val()) || 0;


    var quantity = parseFloat($(quantity_id).val()) || 0;
    var unitPrice = parseFloat($(unitprice_id).val()) || 0;

    var line_total = quantity * unitPrice;
//     if (av_quantity !== 0) {

//     if (av_quantity < parseInt(quantity)) {
//         alert("This much quantity is not available");
//         // return; // Use return to stop the function
//         // $(quantity_id).val(av_quantity);
//         $("#quantity_" + r).val(av_quantity);
//     }
// }

    // Update the line total in the current row
    $(linetotal_id).val(line_total.toFixed(2));
    $(discprice_id).val(unitPrice.toFixed(2));



    // Recalculate the grand total
    calculate_footer()
}

function hiddenprice_calc(r)
{
    var dis_linetotal_id = '.linetotal_' + r;
    var discprice_id = '.discprice_' + r;
    var doc_disc_id = '.doc_disc_' + r;
    var discount = '#discount';
    var quantity_id = '.quantity_' + r;


    var disc_price = parseFloat($(discprice_id).val()) || 0;
    var discount_val = parseFloat($(discount).val()) || 0;
    var quantity = parseFloat($(quantity_id).val()) || 0;

    var dis_linetotal = quantity * disc_price;

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
    $(dis_linetotal_id).val(dis_linetotal.toFixed(2));

    calculate_footer()

}




    function price_calc1(r)
    {
        var stock_det = '#stockdet_'+r;
        var discvalue_id = '#discvalue_'+r;
        var taxable_id = '.taxable_'+r;
        var discwithouttax_id = '.discwithouttax_'+r;
        var netunitprice_id = '.netunitprice_'+r;
        var unitprice_id = '.unitprice_'+r;
        var quantity_id = '#quantity_'+r;

        var taxamount_id = '.taxamount_'+r;
        var taxcode = '.taxcode_'+r;
        var linetotal_id = '.linetotal_'+r;
        var uom_id = '.uom_'+r;
        var netprice_id = '.netprice_'+r;
        var sqm_id = '.sqm_'+r;
        var sqft_id = '.sqft_'+r;
        var discount_id = '.discount_'+r;
        var discounttype_id = '#discounttype_'+r;
        var LineDiscPrice_id = '#LineDiscPrice_'+r;
        var stock_array = JSON.parse($(quantity_id).val());
        console.log(stock_array);
        var sqftprice_id = '.sqftprice_'+r;
        //console.log(stock_array);        
        var quantity = $(quantity_id).val();
        // var taxRate = parseFloat(stock_array.product.taxRate);     
        var unitprice = parseFloat(stock_array.price_list.price)*(100+taxcode)/100;
        unitprice = parseFloat(unitprice.toFixed(2));
        var uom = stock_array.product.invUOM;
        var sqmConvFac = parseFloat(stock_array.product.conv_Factor);
        if(sqmConvFac == 0)
            sqmConvFac = 1;
        var sqm = quantity * sqmConvFac;
        var sqftConvFac = parseFloat(stock_array.product.sqft_Conv);
        if(sqftConvFac == 0)
            sqftConvFac = 1;
        var sqft = quantity * sqftConvFac;
        var netprice =  unitprice * quantity;//parseFloat($(sqftprice_id).html()) * sqft;
        $(netprice_id).html(netprice.toFixed(2)); 
        $(netprice_id).html(netprice.toFixed(2)); 
        var disc = parseFloat($(discvalue_id).val());
        var discount = 0;  var unitdiscount = 0;
        var price_without_tax = parseFloat(stock_array.price_list.price) * quantity;
        var discou_without_tax = 0;
        if(disc)
        {
            if($(discounttype_id).val() == 'Percentage')
            {
                var unitdiscount = stock_array.price_list.price * disc/100 ;
                discount = unitdiscount * quantity * (100+taxcode)/100;
            }
            else
            { 
                discou_without_tax = (disc/((100+taxcode)/100)) * sqftConvFac * quantity;
                price_without_tax = price_without_tax - discou_without_tax;
                discount = discou_without_tax * (100+taxcode)/100;
            }
            discount = (discount/quantity).toFixed(2);
            discount = parseFloat(discount) * quantity;
            netprice = netprice - discount;
        }
        var sqftamtafterdisc = netprice/(sqftConvFac * quantity);
        var sqftamtafterdisc_id = '.sqftamtafterdisc_'+r;
        $(sqftamtafterdisc_id).html(sqftamtafterdisc.toFixed(4));
        var amtafterdisc = netprice/quantity; 
        var amtafterdisc_id = '.amtafterdisc_'+r;
        $(amtafterdisc_id).html(amtafterdisc.toFixed(2));
        netprice = parseFloat(amtafterdisc.toFixed(2)) * quantity;
        //$(netprice_id).html(price_without_tax.toFixed(2));
        $(taxable_id).html(price_without_tax.toFixed(2)); 
        $(LineDiscPrice_id).val(discount.toFixed(2));   
        $(discwithouttax_id).html(discou_without_tax.toFixed(2));     
        $(discount_id).html(discount.toFixed(2));
        var netunitprice = stock_array.price_list.price;//unitprice - unitdiscount;
        $(netunitprice_id).html(netunitprice.toFixed(2));
        $(unitprice_id).html(unitprice.toFixed(2));
        var taxamount = netprice * taxcode/100;
        $(taxamount_id).html(taxamount.toFixed(2));
        var linetotal = netprice;
        alert(linetotal_id);
        $(linetotal_id).val(linetotal.toFixed(2));
        $(uom_id).html(uom);

        $(sqm_id).html(sqm.toFixed(2));
        $(sqft_id).html(sqft.toFixed(2));
        
        calculate_footer();
    }

    function calculate_footer()
     {
            console.log("Calculating footer..."); // Debugging

            // Retrieve and parse the input values
            let rawValue = $('#expense').val();
            let expense = parseFloat(rawValue.trim()) || 0; // Parse expense

           

            let discountPercentage = parseFloat($('#discount').val()) || 0;

            // Initialize total line discount and tax amount
            let totalLineDisc = 0;
            let total_tax_amount = 0;

            // Iterate through each row to calculate values
            $('.ech-tr').each(function(index) {
                let $row = $(this);
                let quantity = parseFloat($row.find('[name="quantity[]"]').val()) || 0;
                let disc_price = parseFloat($row.find('[name="discprice[]"]').val()) || 0;
                let taxcode = parseFloat($row.find('[name="taxcode[]"]').val()) || 0;

                let line_disc = parseFloat($row.find('[name="line_disc[]"]').val()) || 0;

                // Calculate discount based on discount percentage
                let doc_disc = discountPercentage === 0 ? disc_price : disc_price - (disc_price * (discountPercentage / 100));

                // Calculate row amount and line tax amount
                let row_amount_val = quantity * doc_disc;
                let line_taxamount_val = row_amount_val * (taxcode / 100);
                let line_disc_val = quantity * disc_price;

                // Update calculated values in the row
                $row.find('[name="row_amount[]"]').val(row_amount_val.toFixed(2));
                $row.find('[name="doc_disc[]"]').val(doc_disc.toFixed(2));
                $row.find('[name="line_taxamount[]"]').val(line_taxamount_val.toFixed(2));
                $row.find('[name="line_disc[]"]').val(line_disc_val.toFixed(2));

                // Accumulate totals
                totalLineDisc += line_disc_val;
                total_tax_amount += line_taxamount_val;
            });
    
            // $('#grandTotalDisplay').text(totalLineDisc.toFixed(2));
            $('#total_bef_discount').val(totalLineDisc.toFixed(2));
            $('#tax_amount').val(total_tax_amount.toFixed(2));

                 // Get Total Before Discount
            let totalBeforeDiscount = parseFloat($('#total_bef_discount').val()) || 0;
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
            let grand_total = (totalBeforeDiscount - discountAmount) + expense + tax_amount + roundtext;
            console.log("Grand Total: " + grand_total);

            // Set Grand Total
            $('#grand_total').val(grand_total.toFixed(2));


    // Update total discount and tax
   
    }

 //calculate_footerdiscount by reshma

function calculate_footerdiscount(val=0)
{
    let totalBeforeDiscount = $('#total_bef_discount').val();
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

    function applydiscount(val=0)
    {
        var discount_amount = $('#total_amount').html() * val/100;
        //$('#discount_amount').html(discount_amount);
        var count = $('#count').val();
        var tax_amount = 0;
        for (let i = 0; i <= count; i++) 
        {
            var taxable_id = '.taxable_'+i;
            var netprice_id = '.netprice_'+i;
            var tax_id = '.tax_'+i;
            var taxable = 0; var netprice = 0;
            if($(taxable_id).html())
            {
                taxable = parseFloat($(taxable_id).html());
                netprice = taxable - taxable * val/100;
            }
            if($(tax_id).html())
            {
                var taxpercent = parseFloat($(tax_id).html());
                tax_amount = tax_amount + netprice * taxpercent/100;
            }
            $(netprice_id).html(netprice);
        }
        //$('#discount_amount').html(discount_amount.toFixed(2));
        $('#tax_amount').val(tax_amount.toFixed(2));
        var grand_total = $('#total_amount').html()-discount_amount+tax_amount;
        $('#grand_total').val(grand_total.toFixed(2));
        $('input[name=tax_amount]').val(tax_amount.toFixed(2));
        $('input[name=grand_total]').val(grand_total.toFixed(2));
    }



    

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

$('#customer').change(function() {
    console.log("Dropdown changed");
    var selectedValue = $(this).val();

    if (selectedValue) {
        $.ajax({
            url: "{{ url('admin/ajax/customer_details') }}",
            type: 'GET',
            data: { customer_code: selectedValue },
            success: function(response) {
                console.log("AJAX request successful");
                console.log(response);

                var bill_to = $('#bill_to');
                bill_to.empty(); // Clear existing options

                var ship_to = $('#ship_to');
                ship_to.empty(); // Clear existing options

                var place_of_sply = $('#place_of_sply');
                place_of_sply.empty();

                // Assuming the response contains the necessary properties
                if (response) {
                    var item = response.customer;
                    console.log(item);
                    if (item.phone && item.addressIDBilling && item.addressID && item.addressBilling && item.zip_codeBilling && item.address && item.zip_code) {
                        bill_to.append($('<option>', {
                            value: item.addressIDBilling,
                            text: item.addressIDBilling
                        }));
                        ship_to.append($('<option>', {
                            value: item.addressID,
                            text: item.addressID
                        }));

                        // Populate textarea with billing address
                        $('#bill_to_address').val(item.addressBilling + "\n" + item.zip_codeBilling);

                        // Update shipping address as text (assuming #ship_to_address is a div)
                        $('#ship_to_address').val(item.address + "\n" + item.zip_code);

                        place_of_sply.append($('<option>', {
                            value: item.state,
                            text: item.state
                        }));

                    } else {
                        console.log("Incomplete data for item:", item);
                        $('#result').html('Error: Data is incomplete.');
                    }
                    var quotations = response.quotations;
                    console.log(quotations);
                    if(quotations!="")
                    {
                        $("#copy_from_qutn").css("display", "block");
                    }
                    else{
                        $("#copy_from_qutn").css("display", "none");
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
    var selectedValue = $('#customer').val();

    if (selectedValue == null) {
        alert("Please select the customer");
        return; // Exit the function if no customer is selected
    }

    e.preventDefault(); // Prevent default anchor behavior

    $.ajax({
        url: "{{ url('admin/ajax/customer_open_quotations') }}",
        type: 'GET',
        data: { customer_code: selectedValue },
        dataType: "json", // Data type expected from server
        success: function(data) { // Change 'quotation' to 'data' here
            console.log(data);
            $('#open_quotation').show();
            $('#open_qutn').attr('required', true);
            // Clear previous options before appending new ones
            $('#open_qutn').empty().append('<option disabled>Select a Quotation</option>');

            // Check if data is not empty
            if (data.length > 0) {
                $.each(data, function(index, quotation) {
                    $('#open_qutn').append(
                        $('<option></option>').val(quotation.id).text(quotation.DocNo)
                    );
                });
            } else {
                $('#open_qutn').append('<option value="">No quotations available</option>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle any errors
            console.log("Error: " + textStatus + ' : ' + errorThrown);
        }
    });
});


$('#open_qutn').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue) {
        $.ajax({
            url: "{{ route('admin.ajax.quotation_details') }}", // Update with your endpoint
            type: 'GET',
            data: { quotation: selectedValue },
            success: function(response) {
                console.log("Data fetched: ", response); // Log the response to see the data
                if (response.data && response.data.length > 0) {
                    // Clear the grid container before appending new rows
                    $('#grid-container').empty();

                    // Loop through the response data and append rows to the grid
                    $.each(response.data, function(index, item) {
                        console.log(item);
                        var i = index;
                        var calc = (item.UnitPrice * (100 + item.TaxRate) / 100);
                        console.log("hi" + calc);
// <div style="display:none">
//                                     <span class="taxable_${i}">${item.taxable}</span>
//                                     <span class="discwithouttax_${i}">${item.discwithouttax}</span>
//                                     <span class="tax_${i}">${item.tax}</span>
//                                     <span class="taxamount_${i}">${item.taxamount}</span>
//                                     <span class="netprice_${i}">${item.netprice}</span>
//                                     <input type="hidden" name="LineTotal[]" class="linetotal_${i}" value="${item.LineTotal}">
//                                 </div>
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
                                                    <select id="product_${i}" required  name="product[]" class="product_${i} itemSelect form-control select2" onChange="load_warehouse(${i})">
                                                        <option value="${item.productCode}">${item.productName}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Unit <span class="text-danger">*</span></label>
                                                
                                                <div class="td-value">
                                                    <select id="unit_${i}" required  name="unit[]" class="unit_${i} unit-select form-control select2" >
                                                        <option value="${item.unit}">${item.unit}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Quantity <span class="text-danger">*</span></label>
                                                <div class="td-value">
                                                    <input min="0.1" type="number" step="any"  id="quantity_${i}" required class="quantity_${i} form-control" value="${item.Qty}" onChange="price_calc(${i})" name="quantity[]">

                                                    <input min="0.1" type="hidden" id="pquantity_${i}" required class="pquantity_${i} form-control" value="${item.Qty}" onChange="price_calc(${i})" name="pquantity[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-8 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Unit Price <span class="text-danger">*</span></label>
                                                <div class="td-value">
                                                    <input type="number"  step="0.01"  id="unitprice_${i}" required class="unitprice_${i} form-control" value="${item.UnitPrice}" onChange="price_calc(${i})" name="unitprice[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-4 col-md-4 col-sm-5 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Discounted Price <span class="text-danger">*</span></label>
                                                <div class="td-value">
                                                    <input type="number"  step="0.01"  id="discprice_${i}" required class="discprice_${i} form-control"  value="${item.UnitPrice}" onChange="hiddenprice_calc(${i})" name="discprice[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-7 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Tax Code</label>
                                                <div class="td-value">
                                                    <select class="form-control taxcode-select" name="taxcode[]" id="taxcode_${i}" onChange="calculate_footer()">
                                                        <option value="0">EXEMPT</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10" style="display: none;">
                                            <div class="ech-td">
                                                <label class="td-label">WHSE <span class="text-danger">*</span></label>
                                                <div class="td-value">
                                                    
                                                    <input type="text"  id="whscode_${i}" class="whscode whscode_${i} form-control" name="whscode[]" readonly="" value="${item.whsCode}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-9 col-lg-3 col-md-12 col-sm-12 col-12">
                                            <div class="ech-td">
                                                <label class="td-label">Line Total</label>
                                                <div class="td-value">
                                                    
                                                    <input type="number"  step="0.01"  id="linetotal_${i}" class="linetotal linetotal_${i} form-control" name="linetotal[]" readonly="" value="${item.LineTotal}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Serial No</label>
                                                <div class="td-value">
                                                    <input type="text" id="serialno_${i}"  class="serialno_${i} form-control" name="serialno[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="actn-td">
                                    <a href="javascript:void(0);" class="action-icon add-item"></a>
                                    <a href="javascript:void(0);" class="action-icon delete-item1 remove-row" value="${item.itemid}"></a>
                                </div>
                            </div>`;
                        
                        // Append the row to the grid container
                        $('#grid-container').append(rowHtml);
                        calculate_footer()
                    });
                } else {
                    console.log("No items found in response.");
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

function calculateGrandTotal() {
    var grandTotal = 0;

    $('#product-grid .grid-item').each(function() {
        var lineTotal = parseFloat($(this).find('.linetotal').text()) || 0;
        grandTotal += lineTotal;
    });

    $('#grand-total').text('Total: ' + grandTotal.toFixed(2));
}




$(document).on('click', '.remove-row', function(e) {
    e.preventDefault(); // Prevent the default action

    var itemValue = $(this).attr('value'); // Get the value from the clicked button
    var $row = $(this).closest('.ech-tr'); // Find the closest parent with the class 'ech-tr'

    // AJAX call for closing the sales order item
    $.ajax({
        url: "{{ url('admin/ajax/salesorder_close_items') }}",
        type: 'POST',
        data: {  
            _token: "{{ csrf_token() }}",
            item: itemValue 
        },
        dataType: "json", // Data type expected from server
        success: function(data) { 
            console.log("AJAX Success:", data);
            
            // Change the background color of the selected row
            $row.css('background-color', '#f2dede');

            // Recalculate grand total
            calculateGrandTotal();
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
                $('#roundtext').removeAttr('readonly');
                $('#roundtext').attr('required', 'required');
                $('#roundtext').css({  
                    'background-color': '#FFF', 
                    color:'#000',
                    'border': '1px solid #ced4da'    
                });

                let roundtext = parseFloat($('#roundtext').val()) || 0;

                // Get the current grand total, or 0 if it's not a number
                let grand_total = parseFloat($('#grand_total').val()) || 0;

                // Calculate the new total by subtracting the roundtext value from the grand total
                let total = grand_total + roundtext;

                // Ensure total is a valid number before calling toFixed
                if (!isNaN(total)) {
                    total = total.toFixed(2);
                } else {
                    total = '0.00'; // Fallback if something went wrong
                }

                // Update the grand total with the new total
                $('#grand_total').val(total);


            } else {
                // $('#roundtext').val('');
                $('#roundtext').removeAttr('required');
                $('#roundtext').attr('readonly','readonly');
                $('#roundtext').css({
                    'background-color': '#ebebeb', color:'#ebebeb',
                    'border': '1px solid #ebebeb'    
                });
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
                
            }
});




</script>
@endsection
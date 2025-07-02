@extends('layouts.vertical', ["page_title"=> "Quotation Create"])

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
                        <li class="breadcrumb-item"><a href="{{url('admin/quotations')}}">Quotations</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Quotation</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">@if(!empty($errors->all()))
            <p class="alert alert-danger newStyle">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
            </p>
            @endif
            <div class="card">
                <form method="post" id="myForm" class="parsley-examples" action="{{url('admin/quotation/insert')}}">
                    {{csrf_field()}}
                    <div class="card-body body-style">
                        <div class="row mb-3">

                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">
                                    Customer <span class="text-danger">*</span>
                                    <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addCustModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="customer" class="customerSelect form-control" >
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label ffor="referral" class="col-sm-5 col-form-label">
                                    Referral(Engineer)<a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addPartModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a>
                                    </label>
                                    <div class="col-sm-7">
                                    <select name="partner1" class="engineerSelect form-control select2" >
                                    </select >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label ffor="referral" class="col-sm-5 col-form-label">
                                    Referral(Contractor) <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="partner2" class="contractorSelect form-control select2" data-parsley-required="true"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label ffor="referral" class="col-sm-5 col-form-label">
                                    Referral(Sales Executive) <span class="text-danger">*</span></label>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="partner3" class="agentSelect form-control select2" data-parsley-required="true"></select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="date" class="col-sm-5 col-form-label"> Date <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <input required type="date" name="date" value="{{date('Y-m-d')}}" class="form-control flatpickr-input active" readonly="readonly">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="date" class="col-sm-5 col-form-label">Due Date <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <input required type="date" name="DueDate" class="form-control flatpickr-input active">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">Doc Number <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">{{date("Y")}}</span>
                                        <input required readonly type="text" class="form-control" name="docNumber" placeholder="Doc Number" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">Price List
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required id="price_list" name="priceList" class="form-control select">
                                        <option>Retail Price</option>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">Vehicle type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                        <select required name="vehicle_type" class="form-control select">
                                                <option value="">Select</option>
                                                <option>Light</option>
                                                <option>Heavy</option>
                                                <option>Any vehicle</option>
                                                <option>N/A</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="distance" class="col-sm-5 col-form-label">Distance(in km)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required type="number" name="km" steps="0.5" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>



                    <div class="col-12">
                        <input type="hidden" id="count" value="0">
                        <div class="new-table">
                        @for ($i = 0; $i < 1; $i++)
                        <div class="ech-tr" id="tr_{{$i}}">
                            <div style="display:none">
                                <span class="taxable_{{$i}}"></span>
                                <span class="discwithouttax_{{$i}}"></span>
                                <span class="tax_{{$i}}"></span>
                                <span class="taxamount_{{$i}}"></span>
                                <span class="netprice_{{$i}}"></span>
                                <input type="hidden" name="LineTotal[]" class="linetotal_{{$i}}">
                            </div>
                            <div class="echtr-inn">
                                <div class="row">
                                    <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                        <div class="ech-td">
                                            <span class="btn opentr-btn"></span>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                        <div class="ech-td">
                                            <label class="td-label">Item(s)
                                            <!--  -->
                                            </label>
                                            <div class="td-value">
                                            <select id="product_{{$i}}" required onChange="set_data({{$i}})" name="product[]" class="product_{{$i}} itemSelect form-control select2">
                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Quantity</label>
                                            <div class="td-value">
                                            <input min="1" type="number" id="quantity_{{$i}}" required class="quantity_{{$i}} form-control" onChange="price_calc({{$i}})" name="quantity[]">
                                        
                                            </div>
                                        </div>
                                    </div>                                
                                    
                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                                        <div class="ech-td"><label class="td-label">Disc Type</label>
                                            <div class="td-value">
                                            <select id="discounttype_{{$i}}" onChange="price_calc({{$i}})" name="discount_type[]" class="form-control">
                                                <option value="Amount">Amount</option>
                                                <option value="Percentage">Percentage</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Disc Value</label>
                                            <div class="td-value">
                                                <input type="number" id="discvalue_{{$i}}" step="0.0001" value="0" class="form-control" onChange="price_calc({{$i}})" name="disc_perct[]">
                                                <input type="hidden" id="LineDiscPrice_{{$i}}" name="LineDiscPrice[]" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Area</label>
                                            <div class="td-value">
                                            <input type="text" name="area[]" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">UOM</label>
                                            <div class="td-value">
                                            <span class="uom_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Blocked</label>
                                            <div class="td-value">
                                            <span class="Committed_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Unit Price</label>
                                            <div class="td-value">
                                            <span class="unitprice_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">On Hand</label>
                                            <div class="td-value">
                                            <input type="hidden" name="warehouse[]" value="VNGW0002">
                                            <input type="hidden" id="stockdet_{{$i}}" value=""><span class="onhand_{{$i}}"></span>
                                            <input type="hidden" id="onhand_stock_{{$i}}" name="onhand_stock[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">After Disc Price/Sqft</label>
                                            <div class="td-value">
                                            <span style="display:none;" class="discount_{{$i}}"></span>
                                            <span class="sqftamtafterdisc_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">After Disc Price/Piece</label>
                                            <div class="td-value">
                                            <span style="display:none;" class="netunitprice_{{$i}}"></span>
                                            <span class="amtafterdisc_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Sqft</label>
                                            <div class="td-value">
                                            <span class="sqft_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Sqm</label>
                                            <div class="td-value">
                                            <span class="sqm_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Price/Sqft</label>
                                            <div class="td-value">
                                            <span class="sqftprice_{{$i}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Line Total</label>
                                            <div class="td-value">
                                            <span class="linetotal_{{$i}}"></span>
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
                        @endfor
                        </div>
                    </div>

                    <div class="specarea">
                        <input value="0" type="hidden" name="discount_amount">
                        <input value="0" type="hidden" name="tax_amount">
                        <input value="0" type="hidden" name="grand_total">
                    </div>
                    

                    <div class="row">
    <div class="col-sm-4">
        <div class="form-group row">
            <label for="refferal" class="col-sm-5 col-form-label">Total Amount</label>
            <div class="col-sm-7" >
                <input type="text" class="form-control" id="total_amount" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="refferal" class="col-sm-5 col-form-label">Discount</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" id="discount_amount" readonly>
            </div>
        </div>
        <div class="form-group row">
        <label for="refferal" class="col-sm-5 col-form-label">Remarks</label>
            <div class="col-sm-7">
                <input placeholder="Remarks" type="text" name="remarks" class="form-control"> 
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label for="refferal" class="col-sm-6 col-form-label">Tax</label>
            <div class="col-sm-6">
                 <input type="text" class="form-control" id="tax_amount" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="refferal" class="col-sm-6 col-form-label">Freight charges</label>
            <div class="col-sm-6" id="freight">
            <input type="number" step="0.5" name="FreightCharge" onChange="calculate_footer();" id="freight_charge" class="form-control">         
            </div>
        </div>

        <div class="form-group row">
            <label for="refferal" class="col-sm-6 col-form-label">Loading charges</label>
            <div class="col-sm-6" id="loading">
            <input type="number" step="0.5" name="LoadingCharge" onChange="calculate_footer();" id="loading_charge" class="form-control">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group row">
            <label for="refferal" class="col-sm-6 col-form-label">Unloading charges</label>
            <div class="col-sm-6" id="unloading">
            <input type="number" step="0.5" name="UnloadingCharge" onChange="calculate_footer();" id="unloading_charge" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="reffer" class="col-sm-6 col-form-label">Grand Total</label>
            <div class="col-sm-6">
                 <input type="text" class="form-control" id="grand_total" readonly>
            </div>
        </div>
    </div>
                                                
</div>









                    <div class="col-sm-12">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="submit" id="submitBtn"  class="btn btn-primary waves-effect waves-light">Save</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<!-- end demo js-->
<!-- demo app -->
<!-- end demo js-->
<script>
    
$(document).ready(function () {
 
        $('#sepBilling').change(function(){
            if($('#sepBilling').is(':checked'))
            {
                $('select[name=prefixBilling').val($('select[name=prefix').val());
                $('input[name=addressIDBilling').val($('input[name=addressID').val());
                $('input[name=addressBilling').val($('input[name=address').val());
                $('input[name=address2Billing').val($('input[name=address2').val());
                $('input[name=placeBilling').val($('input[name=place').val());
                $('input[name=zip_codeBilling').val($('input[name=zip_code').val());
                $('input[name=stateBilling').val($('input[name=state').val());
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

        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'quotation'},
           success:function(data){
              $('input[name=docNumber]').val(data);
           }
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
    
    $(document ).on("click",".add-item",function()
    {
        var val = parseInt($("#count").val())+1;
        $("#count").val(val);
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
                                            +'<label class="td-label">Item(s)</label>'
                                            +'<div class="td-value">'
                                            +'<select id="product_'+val+'" required onChange="set_data('+val+')" name="product[]" class="product_'+val+' itemSelect form-control select2">'
                                    +'</select>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Quantity</label>'
                                            +'<div class="td-value">'
                                            +'<input min="1" type="number" id="quantity_'+val+'" required class="quantity_'+val+' form-control" onChange="price_calc('+val+')" name="quantity[]">'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">'
                                            +'<div class="ech-td"><label class="td-label">Disc Type</label>'
                                            +'<div class="td-value">'
                                            +'<select id="discounttype_'+val+'" onChange="price_calc('+val+')" name="discount_type[]" class="form-control">'
                                            +'<option value="Amount">Amount</option>'
                                            +'<option value="Percentage">Percentage</option>'
                                            +'</select>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Disc Value</label>'
                                            +'<div class="td-value">'
                                            +'<input type="number" id="discvalue_'+val+'" step="0.0001" value="0" class="form-control" onChange="price_calc('+val+')" name="disc_perct[]">'
                                            +'<input type="hidden" id="LineDiscPrice_'+val+'" name="LineDiscPrice[]" value="0">'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Area</label>'
                                            +'<div class="td-value">'
                                            +'<input type="text" name="area[]" class="form-control" value="">'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">UOM</label>'
                                            +'<div class="td-value">'
                                            +'<span class="uom_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Blocked</label>'
                                            +'<div class="td-value">'
                                            +'<span class="Committed_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Unit Price</label>'
                                            +'<div class="td-value">'
                                            +'<span class="unitprice_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">On Hand</label>'
                                            +'<div class="td-value">'
                                            +'<input type="hidden" name="warehouse[]" value="VNGW0002">'
                                            +'<input type="hidden" id="stockdet_'+val+'" value=""><span class="onhand_'+val+'"></span><input type="hidden" id="onhand_stock_'+val+'" name="onhand_stock[]" value="">'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">After Disc Price/Sqft</label>'
                                            +'<div class="td-value">'
                                            +'<span style="display:none;" class="discount_'+val+'"></span>'
                                            +'<span class="sqftamtafterdisc_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">After Disc Price/Piece</label>'
                                            +'<div class="td-value">'
                                            +'<span style="display:none;" class="netunitprice_'+val+'"></span>'
                                            +'<span class="amtafterdisc_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Sqft</label>'
                                            +'<div class="td-value">'
                                            +'<span class="sqft_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Sqm</label>'
                                            +'<div class="td-value">'
                                            +'<span class="sqm_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Price/Sqft</label>'
                                            +'<div class="td-value">'
                                            +'<span class="sqftprice_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                            +'<div class="ech-td">'
                                            +'<label class="td-label">Line Total</label>'
                                            +'<div class="td-value">'
                                            +'<span class="linetotal_'+val+'"></span>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'                
                                            +'<div class="actn-td">'
                                            +'<a href="javascript:void(0);" class="action-icon add-item"></a>'
                                            +'<a href="javascript:void(0);" class="action-icon delete-item"></a>'
                                            +'</div>'
                                            +'</div>';
        //$('.new-table .ech-tr:last').after(html);
        $(this).closest(".ech-tr").after(html);
        load_product();
    });

    /*$(document ).on("click",".add-item",function()
    {
        var val = parseInt($("#count").val())+1;
        $("#count").val(val);
        $("#tr_"+val).show();
    });*/

    $(document ).on("click",".delete-item",function() {
        if($('div .ech-tr').length == 1)
        {
            var val = parseInt($("#count").val())+1;
            $("#count").val(val);
            $(".add-item").click();
        }
        $(this).closest('.ech-tr').remove();
        calculate_footer();
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

    function load_warehouse(val)
    {
       var row = val.id;
       var result = row.split('_');
       var r = result[1];
       var product_id = '.product_'+r;
       var warehouse_id = '.warehouse_'+r;
       var productCode = $(product_id+' option:selected').val(); //alert(productCode);
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
                        productCode: productCode, // prod term
                        page: params.page || 1
                    };
                    },
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.warehouse.whsName,
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
                placeholder: "By searching name,warehouse code",
                allowClear: false,
        });

        if($('#quantity_'+r).val() != 0)
        {            
            $('#quantity_'+r).val(0);

            price_calc(r);
        }
    }

    function set_data(r)
    {
        var product_id = '#product_'+r;
        var warehouse_id = '.warehouse_'+r;
        var stock_det = '#stockdet_'+r;
        var uom_id = '.uom_'+r;
        var onhand_id = '.onhand_'+r;
        var onhand_stock = '#onhand_stock_'+r;
        var Committed_id = '.Committed_'+r;
        var unitprice_id = '.unitprice_'+r;
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
                    var sqft_price = (data.price_list.price*((100+parseFloat(data.product.taxRate))/100)/sqft_Conv).toFixed(2);
                //}
                console.log(data);
                $(stock_det).val(JSON.stringify(data));
                $(onhand_id).html(data.itemwarehouse.OnHand);
                $(onhand_stock).val(data.itemwarehouse.OnHand);
                $(Committed_id).html(data.blockQty);
                $(uom_id).html(data.product.invUOM);
                $(unitprice_id).html(data.price_list.price);
                $(netunitprice_id).html(data.price_list.price);
                $(sqftprice_id).html(sqft_price);
                $(discount_id).html(0);
                $(tax_id).html(data.product.taxRate);
                $(productname_id).html(data.product.productName);
                price_calc(r);
            }
        });
    }

    function price_calc(r)
    {
        var stock_det = '#stockdet_'+r;
        var discvalue_id = '#discvalue_'+r;
        var taxable_id = '.taxable_'+r;
        var discwithouttax_id = '.discwithouttax_'+r;
        var netunitprice_id = '.netunitprice_'+r;
        var unitprice_id = '.unitprice_'+r;
        var quantity_id = '#quantity_'+r;
        var onhand_stock = '#onhand_stock_'+r;
        var taxamount_id = '.taxamount_'+r;
        var linetotal_id = '.linetotal_'+r;
        var uom_id = '.uom_'+r;
        var netprice_id = '.netprice_'+r;
        var sqm_id = '.sqm_'+r;
        var sqft_id = '.sqft_'+r;
        var discount_id = '.discount_'+r;
        var discounttype_id = '#discounttype_'+r;
        var LineDiscPrice_id = '#LineDiscPrice_'+r;
        var stock_array = JSON.parse($(stock_det).val());
        var sqftprice_id = '.sqftprice_'+r;
        //console.log(stock_array);        
        var quantity = $(quantity_id).val();
        var stock = $(onhand_stock).val();
        var productName = $("#product_" + r + " option:selected").text();


        if (stock < parseInt(quantity)) {
                alert("The entered quantity for " + productName + " exceeds the available quantity (" + stock + ").");
                $("#quantity_" + r).val(stock); // Set quantity to the available stock
            } else {
                // Additional logic if necessary, e.g., update total or perform other checks
            }

        var taxRate = parseFloat(stock_array.product.taxRate);     
        var unitprice = parseFloat(stock_array.price_list.price)*(100+taxRate)/100;
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
        var disc = parseFloat($(discvalue_id).val());
        var discount = 0;  var unitdiscount = 0;
        var price_without_tax = parseFloat(stock_array.price_list.price) * quantity;
        var discou_without_tax = 0;
        if(disc)
        {
            if($(discounttype_id).val() == 'Percentage')
            {
                var unitdiscount = stock_array.price_list.price * disc/100 ;
                discount = unitdiscount * quantity * (100+taxRate)/100;
            }
            else
            { 
                discou_without_tax = (disc/((100+taxRate)/100)) * sqftConvFac * quantity;
                price_without_tax = price_without_tax - discou_without_tax;
                discount = discou_without_tax * (100+taxRate)/100;
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
        var taxamount = netprice * taxRate/100;
        $(taxamount_id).html(taxamount.toFixed(2));
        var linetotal = netprice;
        $(linetotal_id).html(linetotal.toFixed(2));
        $(linetotal_id).val(linetotal.toFixed(2));
        $(uom_id).html(uom);

        $(sqm_id).html(sqm.toFixed(2));
        $(sqft_id).html(sqft.toFixed(2));
        
        calculate_footer();
    }

    function calculate_footer()
    {
        var count = $('#count').val();
        let total = 0; let tot_qty = 0; let tot_sqm = 0; let tot_sqft = 0; let tot_disc = 0;let tax_amount = 0;
        let freight_charge = 0; let loading_charge = 0; let unloading_charge = 0;
        for(var i = 0; i <= count; i++)
        {
            /*var taxable_id = '.taxable_'+i;
            if($(taxable_id).html())
                total = total+parseFloat($(taxable_id).html());

            var discwithouttax_id = '.discwithouttax_'+i;
            if($(discwithouttax_id).html())
                total = total+parseFloat($(discwithouttax_id).html());*/

            var netprice_id = '.netprice_'+i;
            if($(netprice_id).html())
                total = total+parseFloat($(netprice_id).html());

            var quantity_id = '#quantity_'+i;
            if($(quantity_id).val())
                tot_qty = tot_qty + parseInt($(quantity_id).val());

            var sqm_id = '.sqm_'+i;
            if($(sqm_id).html())
                tot_sqm = tot_sqm + parseFloat($(sqm_id).html());

            var sqft_id = '.sqft_'+i;
            if($(sqft_id).html())
                tot_sqft = tot_sqft + parseFloat($(sqft_id).html()); 
            
            var discwithouttax_id = '.discwithouttax_'+i;
            /*if($(discwithouttax_id).html())
                tot_disc = tot_disc + parseFloat($(discwithouttax_id).html()); */
            var discount_id = '.discount_'+i;
            if($(discount_id).html())
                tot_disc = tot_disc + parseFloat($(discount_id).html());

            var taxable_id = '.taxable_'+i;
            var tax_id = '.tax_'+i;
            var taxable = 0; var netprice = 0;
            if($(taxable_id).html())
            {
                taxable = parseFloat($(taxable_id).html());
            }
            if($(tax_id).html())
            {
                var taxpercent = parseFloat($(tax_id).html());
                tax_amount = tax_amount + taxable * taxpercent/100;
            }

        }

        $('#tot_qty').val(tot_qty.toFixed(2));

        $('#tot_sqm').val(tot_sqm.toFixed(2));

        $('#tot_sqft').val(tot_sqft.toFixed(2));

        $('#total_amount').val(total.toFixed(2));

        $('#discount_amount').val(tot_disc.toFixed(2));

        $('input[name=discount_amount]').val(tot_disc.toFixed(2));

        $('#tax_amount').val(tax_amount.toFixed(2));

        if($('#freight_charge').val())
            freight_charge = parseFloat($('#freight_charge').val());

        if($('#loading_charge').val())
            loading_charge = parseFloat($('#loading_charge').val());

        if($('#unloading_charge').val())
            unloading_charge = parseFloat($('#unloading_charge').val());

        var grand_total = total-tot_disc+freight_charge+loading_charge+unloading_charge;
        $('#grand_total').val(grand_total.toFixed(0));
        $('input[name=tax_amount]').val(tax_amount.toFixed(2));
        $('input[name=grand_total]').val(grand_total.toFixed(2));

        //applydiscount(0);
    }

    function applydiscount(val=0)
    {
        var discount_amount = $('#total_amount').val() * val/100;
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
        var grand_total = $('#total_amount').val()-discount_amount+tax_amount;
        $('#grand_total').val(grand_total.toFixed(2));
        $('input[name=tax_amount]').val(tax_amount.toFixed(2));
        $('input[name=grand_total]').val(grand_total.toFixed(2));
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

    $("#partner-form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            url: url,
            type:'POST',
            data: form.serialize(),
            success: function(data) {
                $('.alert-part').html('');
                $(".alert-part").css('display','block');
                if($.isEmptyObject(data.error)){
                    $('.alert-part').html(data.success);
                    $('#partner-form').trigger("reset");
                    $.ajax({
                        type:'POST',
                        url:"{{ url('admin/code') }}",
                        data:{_token: "{{ csrf_token() }}",type:'partner'},
                        success:function(data){
                            $('#partner_code').val(data);
                        }
                    });
                    setTimeout(function() {$('#addPartModal').modal('hide');}, 2000);
                }else{
                    $('.alert-part').html(data.error);
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
</script>
@endsection
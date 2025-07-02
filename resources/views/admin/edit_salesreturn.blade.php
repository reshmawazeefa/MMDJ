@extends('layouts.vertical', ["page_title"=> "Sales Return Create"])

@section('css')
<!-- third party css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" rel="stylesheet">
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
                            <a href="{{url('admin/sales-order')}}">Sales Return</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Sales Return</h4>
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
                <form method="post" class="parsley-examples" action="{{url('admin/sales-return/'.$details->id.'/update')}}">
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="row">
                                    <!-- <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="customer" class="form-label">Customer code <span class="text-danger">*</span></label>
                                            <select required name="customer_code" class="customer_codeSelect form-control select2" id="customer_code">
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="customer" class="form-label">Customer <span class="text-danger">*</span></label>
                                            <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addCustModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a>
                                            <select required name="customer" id="customer" class="customerSelect form-control select2"><option value="{{$details->customer->customer_code}}">{{$details->customer->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Ref/LPO No.</label>
                                            
                                            <input required  type="text" class="form-control" name="refno" placeholder="Ref/LPO No." aria-describedby="basic-addon1" value="{{$details->ref_no}}">
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="referral" class="form-label">Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="bill_to_address" id="bill_to_address">{{$details->address_bill}}</textarea>
                                                <textarea class="form-control" name="ship_to_address" id="ship_to_address">{{$details->address_ship}}</textarea>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="referral" class="form-label">Place of Supply</label>
                                                
                                                <select id="place_of_sply" name="place_of_sply"  class="place_of_splySelect form-control select2" required>
                                                    <option value="{{$details->pl_supply}}">{{$details->pl_supply}}</option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="referral" class="form-label">Tax Type</label>
                                                <select name="tax_type" class="tax_typeSelect form-control select2" required>
                                                    <option value="b-b" @if($details->tax_type == "b-b") selected @endif>B-B</option>
                                                    <option value="b-c" @if($details->tax_type == "b-c") selected @endif>B-C</option>
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                        $docNum = $details->doc_num;
                                        $arr = explode('-',$docNum);
                                    @endphp

                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Doc Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
                                                <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                        
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="status" class="form-label">Status</label>
                                                
                                                <select name="status" class="statusSelect form-control select2">
                                                    <option value="Open" @if($details->status == "Open") selected @endif>Open</option>
                                                    <option value="Closed" @if($details->status == "Closed") selected @endif>Closed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="posting_date" class="form-label">Posting Date <span class="text-danger">*</span></label>
                                                <input required type="text" name="posting_date"  class="form-control flatpickr-input active" value="{{$details->posting_date}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="date" class="form-label">DocDue Date <span class="text-danger">*</span></label>
                                                <input required type="date" name="docdue_date" id="docdue_date"  class="form-control flatpickr-input active" value="{{$details->docdue_date}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="date" class="form-label">Document Date <span class="text-danger">*</span></label>
                                                <input required type="text" name="DocuDate" class="form-control flatpickr-input active" value="{{$details->doc_date}}" readonly>
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="referral" class="form-label">TAX Reg No <span class="text-danger">*</span></label>
                                                <input required type="text" name="tax_reg_no"  class="form-control" value="{{$details->tax_regno}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <a class="btn btn-primary waves-effect waves-light" id="copy_from_qutn" name="copy_from_qutn">Copy from Sales Invoice</a>
                                        </div>

                                        <div class="col-lg-4 col-sm-6" id="open_quotation">
                                            <div class="me-3">
                                                <label for="referral" class="form-label">Open Sales Invoice </label>
                                                <select  name="open_qutn" id="open_qutn" class="open_qutnSelect form-control select2" multiple>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4 col-sm-6">
                                            <div class="me-3">
                                                <label for="distance" class="form-label">Distance(in km) <span class="text-danger">*</span></label>
                                                <input required type="number" name="km" steps="0.5" class="form-control">
                                            </div>
                                        </div> -->
                                    </div>
                            </div>
                        <!-- <div class="col-lg-4">
                            <div class="text-lg-end">
                                <button type="button" class="btn btn-danger waves-effect waves-light mb-2 me-2"><i class="mdi mdi-basket me-1"></i> Add New Order</button>
                                <button type="button" class="btn btn-light waves-effect mb-2">Export</button>
                            </div>
                        </div>end col-->
                    </div>
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
                                                <label class="td-label">Item(s)
                                                
                                                </label>
                                                <div class="td-value">
                                                <select id="product_{{$i}}" onChange="load_warehouse({{$i}})" required  name="product[]" class="product_{{$i}} itemSelect form-control select2">
                                                    <option value="{{$val->products->productCode}}">{{$val->products->productName}}</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                            <div class="ech-td">
                                                <label class="td-label">Quantity</label>
                                                <div class="td-value">
                                                <input min="1" type="number" id="quantity_{{$i}}" required class="quantity_{{$i}} form-control" onkeyup="price_calc({{$i}})" name="quantity[]" value="{{$val->qty}}">
                                            
                                                </div>
                                            </div>
                                        </div> 
                                                                       
                                        
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Unit Price</label>
                                                <div class="td-value">
                                                <!-- <span class="unitprice_{{$i}}"></span> -->
                                                <input type="text" id="unitprice_{{$i}}" required class="unitprice_{{$i}} form-control" onkeyup="price_calc({{$i}})" name="unitprice[]" value="{{$val->unit_price}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Discount Price</label>
                                                    <div class="td-value">
                                                        <input type="text" id="discprice_{{$i}}" required class="discprice_{{$i}} form-control"  onkeyup="hiddenprice_calc({{$i}})" name="discprice[]" value="{{$val->disc_price}}">
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <input type="hidden" name="doc_disc[]" class="doc_disc_{{$i}}">
                                            <input type="hidden" name="row_amount[]" class="row_amount_{{$i}}">
                                            <input type="hidden" name="line_taxamount[]" class="line_taxamount_{{$i}}">
                                            <input type="hidden" name="line_disc[]" class="line_disc_{{$i}}">
    
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Tax Code</label>
                                                <div class="td-value">
                                                <select class="form-control taxcode-select" name="taxcode[]" id="taxcode_{{$i}}" onchange="calculate_footer()">
                                                    <option value="12" @if($val->tax_code == "12") selected @endif >CSGST@12</option>
                                                    <option value="18" @if($details->tax_code == "18") selected @endif>CSGST@18</option>
                                                    <option value="5" @if($details->tax_code == "5") selected @endif>CSGST@5</option>
                                                    <option value="1" @if($details->tax_code == "1") selected @endif>EXEMPT</option>
                                                    <option value="13" @if($details->tax_code == "13") selected @endif>CSGST@13</option>
                                                    <option value="19" @if($details->tax_code == "19") selected @endif >CSGST@19</option>
                                                    <option value="4" @if($details->tax_code == "4") selected @endif >IGST 4</option>
                                                    <option value="11" @if($details->tax_code == "11") selected @endif>IGST 11</option>
                                                    <option value="17" @if($details->tax_code == "17") selected @endif>IGST 17</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">WHSE</label>
                                                <div class="td-value">
                                                <span style="display:none;" class="discount_{{$i}}"></span>
                                                <span class="whscode_{{$i}}"></span>
                                                <select class="form-control whscode-select" name="whscode[]" id="whscode"><option value="{{$val->whs_code}}">{{$val->whs_code}}</option></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                            <div class="ech-td">
                                                <label class="td-label">Line Total</label>
                                                <div class="td-value">
                                                <!-- <span class="linetotal linetotal_{{$i}}"></span> -->
                                                <input type="text" id="linetotal_{{$i}}"  class="linetotal linetotal_{{$i}} form-control" name="linetotal[]" value="{{$val->line_total}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
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

                
                    <!-- <div id="grandTotalDisplay">Grand Total: 0.00</div> -->
                    </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="me-3">
                                    <label for="referral" class="form-label">Sales Employee <span class="text-danger">*</span></label>
                                    <select required name="partner3" class="agentSelect form-control select2"><option value="{{$details->referral3->partner_code}}">{{$details->referral3->name}}</option>
                                            </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-sm-6">
                                <div class="me-3">
                                    <label for="referral" class="form-label">Remarks</label>
                                    <textarea placeholder="Remarks" type="text" name="remarks" class="form-control">{{$details->remarks}}</textarea>
                                    
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="me-3">
                                    <label for="referral" class="form-label">Reason for Return <span class="text-danger">*</span></label>
                                    <select name="return_reason" id="return_reason" class="statusSelect form-control select2" required>
                                                    <option value="">Select</option>
                                                    <option value="Size Exchange" @if($details->return_reason == "Size Exchange") selected @endif>Size Exchange</option>
                                                    <option value="Colour Exchange"  @if($details->return_reason == "Colour Exchange") selected @endif>Colour Exchange</option>
                                                    <option value="Model Exchange" @if($details->return_reason == "Model Exchange") selected @endif>Model Exchange</option>
                                                    <option value="Gift Product Exchange" @if($details->return_reason == "Gift Product Exchange") selected @endif>Gift Product Exchange</option>
                                                    <option value="Product Damage" @if($details->return_reason == "Product Damage") selected @endif>Product Damage</option>
                                                </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="me-3">
                                    <label for="referral" class="form-label">Type of Damage <span class="text-danger">*</span></label>
                                    <select name="damage" id="damage" class="statusSelect form-control select2"> 
                                                    <option value="">Select</option>
                                                    <option value="Stitching Complaints" @if($details->damage_type == "Stitching Complaints") selected @endif>Stitching Complaints</option>
                                                    <option value="Pasting Complaints" @if($details->damage_type == "Pasting Complaints") selected @endif>Pasting Complaints</option>
                                                    <option value="Leather Complaints" @if($details->damage_type == "Leather Complaints") selected @endif>Leather Complaints</option>
                                                    <option value="Colour Fade" @if($details->damage_type == "Colour Fade") selected @endif>Colour Fade</option>
                                                    <option value="Sole Damage" @if($details->damage_type == "Sole Damage") selected @endif>Sole Damage</option>
                                                    <option value="Fitting Complaints" @if($details->damage_type == "Fitting Complaints") selected @endif>Fitting Complaints</option>
                                                    <option value="Logo Complaints" @if($details->damage_type == "Logo Complaints") selected @endif>Logo Complaints</option>
                                                    <option value="Nail Complaints" @if($details->damage_type == "Nail Complaints") selected @endif>Nail Complaints</option>
                                                    <option value="Insole Complaints"  @if($details->damage_type == "Insole Complaints") selected @endif>Insole Complaints</option>
                                                    <option value="Zip Complaints" @if($details->damage_type == "Zip Complaints") selected @endif>Zip Complaints</option>
                                                    <option value="Buckle Complaints" @if($details->damage_type == "Buckle Complaints") selected @endif>Buckle Complaints</option>
                                                    <option value="Leather Peel Off" @if($details->damage_type == "Leather Peel Off") selected @endif>Leather Peel Off</option>
                                                </select>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="specarea">

                        <ul>
                            <li><h6>Total Before Discount</h6></li>
                            <li> <input type="text" name="total_bef_discount" id="total_bef_discount" readonly value="{{$details->total_bf_discount}}"></li>
                        </ul>
                        <ul>
                            <li>
                                <h6>Discount 
                                    <input type="text" name="discount" id="discount" style="width: 45%;" placeholder="0.00" onkeyup="calculate_footer();" value="{{$details->discount_percent}}"> %
                                </h6>
                            </li>
                            <li>
                                <p id="discount_amount">
                                    <input type="text" name="discount_amount_value" id="discount_amount_value" class="form-control" onkeyup="calculate_footerdiscount(this.value);" value="{{$details->discount_amount}}">
                                </p>
                            </li>
                        </ul>
                        <ul>
                            <li><h6>Extra Expense</h6></li>
                            <li><p id="expenses"><input type="text" name="expense" onkeyup="calculate_footer();" id="expense" class="form-control" value="{{$details->total_exp}}"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Tax Amount</h6></li>
                            <li><p id="tax_amount_p"></p><input type="text" name="tax_amount" id="tax_amount" readonly value="{{$details->tax_amount}}"></li>
                        </ul>
                        
                        <ul>
                            <li><h6><input type="checkbox" id="rounding_check" name="option1" value="value1" style="width: 17%;" @if($details->rounding != "") checked @endif>Rounding</h6></li>
                            <li><p id="rounding"><input type="text" name="roundtext" onkeyup="calculate_footer();" id="roundtext" class="form-control"  @if($details->rounding != "") style="display: block;" @else style="display: none;" @endif value="{{$details->rounding}}"></p></li>
                        </ul>
                        
                        <ul>
                            <li><h6>Total</h6></li>
                            <li><p id="grand_total_p"></p><input type="text" name="grand_total" id="grand_total" readonly value="{{$details->total}}"></li>
                        </ul>
                    </div>
                    <div>&nbsp;</div>
                     
                    <div>&nbsp;</div>
                    <div class="col-sm-12">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
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
                                            +'<label class="td-label">Item(s)</label>'
                                            +'<div class="td-value">'
                                            +'<select id="product_'+val+'" onChange="load_warehouse('+val+')" required  name="product[]" class="product_'+val+' itemSelect form-control select2"></select></div></div></div>'
                                     
                                    +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Quantity</label>'
                                            +'<div class="td-value"><input min="1" type="number" id="quantity_'+val+'" required class="quantity_'+val+' form-control" onkeyup="price_calc('+val+')" name="quantity[]"></div></div></div>' 
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Unit Price</label>'
                                            +'<div class="td-value"><input min="1" type="text" id="unitprice" required class="unitprice_'+val+' form-control" onkeyup="price_calc('+val+')" name="unitprice[]"></div></div></div>' 
                                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                            +'<div class="ech-td">'
                                                +'<label class="td-label">Discount Price</label>'
                                                +'<div class="td-value"><input type="text" id="discprice_'+val+'" required class="discprice_'+val+' form-control"  onkeyup="hiddenprice_calc('+val+')" name="discprice[]"></div></div></div>'
                                         +'<input type="hidden" name="doc_disc[]" class="doc_disc_{{$i}}"><input type="hidden" name="row_amount[]" class="row_amount_{{$i}}">'
                                        +'<input type="hidden" name="line_taxamount[]" class="line_taxamount_{{$i}}"><input type="hidden" name="line_disc[]" class="line_disc_{{$i}}">'
                                    
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">TaxCode</label>'
                                            +'<div class="td-value"><select class="form-control taxcode-select" id="taxcode_'+val+'" onchange="calculate_footer()" name="taxcode[]" ><option value="12">CSGST@12</option><option value="18">CSGST@18</option><option value="5">CSGST@5</option><option value="1">EXEMPT</option><option value="13">CSGST@13</option><option value="19">CSGST@19</option><option value="4">IGST 4</option><option value="11">IGST 11</option><option value="17">IGST 17</option></select> </div></div></div>'
                                    
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">WHSE</label>'
                                            +'<div class="td-value"><select id="whscode_'+val+'"  name="whscode[]" class="form-control whscode-select"></select></div></div></div>'

                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Line Total</label>'
                                            +'<div class="td-value"><input type="text" id="linetotal_'+val+'"  class="linetotal linetotal_'+val+' form-control" name="linetotal[]" readonly></div></div></div>'
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Serial No</label>'
                                            +'<div class="td-value"><input min="1" type="text" id="serialno"  class="serialno_'+val+' form-control"  name="serialno[]"></div></div></div>'

                                    
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

    var warehouse_id = '.whscode-select'; // The warehouse select element
    var productCode = $(product_id + ' option:selected').val(); // Get the selected product code
    
    if (!productCode) {
        console.error("No product code selected");
        return;
    }

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
    var quantity_id = '.quantity_' + r;
    var unitprice_id = '.unitprice_' + r;
    var linetotal_id = '.linetotal_' + r;
    var discprice_id = '.discprice_' + r;


    var quantity = parseFloat($(quantity_id).val()) || 0;
    var unitPrice = parseFloat($(unitprice_id).val()) || 0;

    var line_total = quantity * unitPrice;

    // Update the line total in the current row
    $(linetotal_id).val(line_total.toFixed(2));
    $(discprice_id).val(unitPrice.toFixed(2));



    // Recalculate the grand total
    calculate_footer()
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

    // $("#partner-form").submit(function(e){
    //     e.preventDefault();
    //     var form = $(this);
    //     var url = form.attr('action');
    //     $.ajax({
    //         url: url,
    //         type:'POST',
    //         data: form.serialize(),
    //         success: function(data) {
    //             $('.alert-part').html('');
    //             $(".alert-part").css('display','block');
    //             if($.isEmptyObject(data.error)){
    //                 $('.alert-part').html(data.success);
    //                 $('#partner-form').trigger("reset");
    //                 $.ajax({
    //                     type:'POST',
    //                     url:"{{ url('admin/code') }}",
    //                     data:{_token: "{{ csrf_token() }}",type:'partner'},
    //                     success:function(data){
    //                         $('#partner_code').val(data);
    //                     }
    //                 });
    //                 setTimeout(function() {$('#addPartModal').modal('hide');}, 2000);
    //             }else{
    //                 $('.alert-part').html(data.error);
    //             }
    //         }
    //     });
    
    // });

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
            url: "{{ url('admin/salesreturn/ajax/customer_details') }}",
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
                    var salesinvoice = response.salesinvoice;
                    console.log(salesinvoice);
                    if(salesinvoice!="")
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
        url: "{{ url('admin/salesreturn/ajax/customer_open_invoice') }}",
        type: 'GET',
        data: { customer_code: selectedValue },
        dataType: "json", // Data type expected from server
        success: function(data) { // Change 'quotation' to 'data' here
            console.log(data);
            $('#open_quotation').show();
            $('#open_qutn').attr('required', true);
            // Clear previous options before appending new ones
            $('#open_qutn').empty().append('<option value="">Select a Invoice</option>');

            // Check if data is not empty
            if (data.length > 0) {
                $.each(data, function(index, invoices) {
                    $('#open_qutn').append(
                        $('<option></option>').val(invoices.id).text(invoices.doc_num)
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
            url: "{{ route('admin.ajax.invoice_details') }}", // Update with your endpoint
            type: 'GET',
            data: { invoice: selectedValue },
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
                                                <label class="td-label">Item(s)</label>
                                                
                                                <div class="td-value">
                                                    <select id="product_${i}" required  name="product[]" class="product_${i} itemSelect form-control select2" onChange="load_warehouse(${i})">
                                                        <option value="${item.productCode}">${item.productName}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                            <div class="ech-td">
                                                <label class="td-label">Quantity</label>
                                                <div class="td-value">
                                                    <input min="1" type="number" id="quantity_${i}" required class="quantity_${i} form-control" value="${item.Qty}" onkeyup="price_calc(${i})" name="quantity[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Unit Price</label>
                                                <div class="td-value">
                                                    <input type="text" id="unitprice_${i}" required class="unitprice_${i} form-control" value="${item.UnitPrice}" onkeyup="price_calc(${i})" name="unitprice[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Discount Price</label>
                                                <div class="td-value">
                                                    <input type="text" id="discprice_${i}" required class="discprice_${i} form-control"  value="${item.UnitPrice}"onkeyup="hiddenprice_calc(${i})" name="discprice[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                            <div class="ech-td">
                                                <label class="td-label">Tax Code</label>
                                                <div class="td-value">
                                                    <select class="form-control taxcode-select" name="taxcode[]" id="taxcode_${i}" onChange="calculate_footer()">
                                                        <option value="12">CSGST@12</option>
                                                        <option value="18">CSGST@18</option>
                                                        <option value="5">CSGST@5</option>
                                                        <option value="1">EXEMPT</option>
                                                        <option value="13">CSGST@13</option>
                                                        <option value="19">CSGST@19</option>
                                                        <option value="4">IGST 4</option>
                                                        <option value="11">IGST 11</option>
                                                        <option value="17">IGST 17</option>
                                                    </select>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                            <div class="ech-td">
                                                <label class="td-label">Line Total</label>
                                                <div class="td-value">
                                                    
                                                    <input type="text" id="linetotal_${i}" class="linetotal linetotal_${i} form-control" name="linetotal[]" readonly="" value="${item.LineTotal}">
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

    // AJAX call for closing the Sales Return item
    $.ajax({
        url: "{{ url('admin/ajax/salesinvoice_close_items') }}",
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
@extends('layouts.vertical', ["page_title"=> "Purchase Order Details"])
@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

<!-- third party css end -->
@endsection
@section('content')
@php 
    $total_discount = $doc_total = 0;
@endphp
<!-- Start Content-->
<div class="container-fluid hidden-tab">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$details->obj_type}}</a></li>
                        <li class="breadcrumb-item active">{{$details->obj_type}} Details</li>
                    </ol>
                </div>
                <h4 class="page-title">{{$details->obj_type}} Details</h4>
            </div>
        </div>
        <!-- <div class="col-lg-12">
            <div class="text-lg-end">
                <a href="{{url('/admin/pdf/'.$details->id)}}"class="btn btn-primary waves-effect waves-light">View as PDF</a>
                @if($details->status == 'Send for Approval')
                    <a href="{{url('/admin/quotations/'.$details->id.'/sendapproval')}}"class="btn btn-primary waves-effect waves-light">Send for Approval</a>
                
                @elseif($details->status == 'Open' && (Auth::user()->hasRole('Admin') || $details->manager1 == Auth::user()->id || $details->manager2 == Auth::user()->id))
                    <a href="{{url('/admin/quotations/approve/'.$details->id)}}"class="btn btn-primary waves-effect waves-light">Approve</a>
                
                @elseif($details->status == 'Approve' && (Auth::user()->hasRole('Admin') || $details->manager1 == Auth::user()->id || $details->manager2 == Auth::user()->id))
                    <a href="{{url('/admin/quotations/confirm/'.$details->id)}}"class="btn btn-primary waves-effect waves-light">Confirm</a>
                @endif
            </div>
        </div> -->
    </div>
    <!-- end page title -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success newStyle">
            {{ $message }}
        </div>
    @endif
    

    <div class="row">
        <div class="col-12">
            <!-- project card -->
            <div class="card ">
                <div class="card-body body-style2 purchaseOrder table-spcl4 purchaseorder-style">
                    <div class="row mb-0 pb-2 dashed-borderStyle">
                        <!-- <div class="col-lg-12">
                            <div class="text-lg-end">
                                <a href="{{url('/generate-pdf/'.$details->id)}}"><button type="button" class="btn btn-light waves-effect mb-2">Print</button></a>
                            </div>
                        </div> -->
                        <!-- New -->
                        <div class="col-lg-4">
                              @if($details->obj_type=='Purchase Order')
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-5 col-form-label">
                                Supplier
                                <label for="customer" class="form-label"></label>
                                </label>: {{$details->customer->name}}
                                <div class="col-sm-7">
                                <!-- <input type="text" value="{{$details->customer->name}}" class="form-control" readonly> -->
                                </div>
                            </div>
                            @else
                              <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-5 col-form-label">
                                Type
                                <label for="customer" class="form-label"></label>
                                </label>: {{$details->exp_type}}
                                <div class="col-sm-7">
                                </div>
                            </div>
                            @endif

                            <div class="form-group row" style="display: none;">
                                <label for="referral" class="col-sm-5 col-form-label">
                                Ref/LPO No.
                                </label>
                                <div class="col-sm-7">
                                <input readonly  type="text" class="form-control" name="refno" placeholder="Ref/LPO No." aria-describedby="basic-addon1" value="@if($details->ref_no) {{$details->ref_no}} @endif">
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <div class="col-sm-12">
                                Address <span class="text-danger">*</span>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <textarea class="form-control" rows="4" name="bill_to_address" id="bill_to_address">@if($details->address_bill) {{$details->address_bill}} @endif</textarea>                                 
                                    </div>
                                    <div class="col-sm-6">
                                    <textarea class="form-control" rows="4" name="ship_to_address" id="ship_to_address">@if($details->address_ship) {{$details->address_ship}} @endif</textarea>
                                    </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!--  -->

                        <div class="col-lg-4">

                            <div class="form-group row" style="display: none;">
                                <label for="referral" class="col-sm-5 col-form-label">
                                Place of Supply
                                </label>
                                <div class="col-sm-7">
                                <input readonly  type="text" class="form-control" name="place_of_sply" id="place_of_sply" aria-describedby="basic-addon1" value="@if($details->pl_supply) {{$details->pl_supply}} @endif" >
                                </div>
                            </div>
                            @if($details->obj_type=='Purchase Order')

                            @php
                            $docNum = $details->doc_num;
                            $arr = explode('-',$docNum);
                            @endphp
                            <div class="form-group row">
                                <label for="referral" class="col-sm-5 col-form-label">
                                Doc Number  <!--<span class="text-danger">*</span> -->
                                </label>: {{$arr[0]}}-{{$arr[1]}}
                                <!-- <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
                                    <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
                                </div>
                                </div> -->
                            </div>

                            @else
                            <div class="form-group row">
                                <label for="date" class="col-sm-5 col-form-label">
                                    Invoice Number <!--<span class="text-danger">*</span> -->
                                </label> : {{$details->invoice_no}}
                                <!-- <div class="col-sm-7">
                                <input required type="text" name="inv_no" id="inv_no" value="{{$details->invoice_no}}"  class="form-control flatpickr-input active">
                                </div> -->
                            </div>
                            @endif

                            <div class="form-group row" style="display: none;">
                                <label for="Status" class="col-sm-5 col-form-label">
                                Status
                                </label>
                                <div class="col-sm-7">
                                <input  readonly type="text" class="form-control" name="status" aria-describedby="basic-addon1" value="@if($details->status) {{$details->status}} @endif">
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="referral" class="col-sm-5 col-form-label">
                                Posting Date <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-7">
                                <input required type="text" name="posting_date"  class="form-control flatpickr-input active" value="@if($details->posting_date) {{$details->posting_date}} @endif" readonly>
                                </div>
                            </div>

                        </div>


                        <div class="col-lg-4">
                            @php
                            use Carbon\Carbon;
                                $dateDMY = $details->docdue_date ? Carbon::createFromFormat('Y-m-d', $details->docdue_date)->format('d-m-Y') : null;
                            @endphp
                            <div class="form-group row">
                                <label for="date" class="col-sm-5 col-form-label">
                                 Due Date <!--<span class="text-danger">*</span> -->
                                </label> : {{$dateDMY}}
                                <!-- <div class="col-sm-7">
                                <input required type="text" name="docdue_date" id="docdue_date"  class="form-control flatpickr-input active" value="{{$dateDMY}}" readonly>
                                </div> -->
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="date" class="col-sm-5 col-form-label">
                                Document Date <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-7">
                                <input required type="text" name="DocuDate" class="form-control flatpickr-input active" value="@if($details->doc_date) {{$details->doc_date}} @endif" readonly>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label for="refferal" class="col-sm-5 col-form-label">
                                TAX Reg No <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-7">
                                <input required type="text" name="tax_reg_no"  class="form-control" value="@if($details->tax_regno) {{$details->tax_regno}} @endif">
                                </div>
                            </div>


                        </div>
                    </div>
                                        
                        <!-- <div class="col-lg-12 pt-3" style="border-top:1px dashed #ebebeb;"> -->
                                            <!-- <table id="basic-datatable" class="table dt-responsive nowrap w-100" style="font-size:0.775rem !important" style="display: none;">
                                                <input type="hidden" id="count" value="0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Item(s)</th>
                                                            <th>Unit</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Discount Price</th>
                                                            <th>WHSE</th>
                                                            <th>Line Total</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body">
                                                    @if(count($details->Item_details) > 0)
                                                        @foreach ($details->Item_details as $val)
                                                            <tr id="tr_0">
                                                                <td>{{$val->products->productName??null}}</td>
                                                                <td>{{$val->unit}}</td>
                                                                <td>{{$val->qty}}</td>
                                                                <td>{{$val->unit_price}}</td>
                                                                <td>{{$val->disc_price}}</td>
                                                                <td>{{$val->products->stock->warehouse->whsName??null}}</td>
                                                                <td>{{$val->line_total}}</td>
                                                              
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                      
                                                    </tbody>
                                            </table> -->
                        <!-- </div> --> 
                         <div class="row pt-3 mb-2" >  
                            <div class="col-sm-4">
                                <div class="form-group row" style="display: none;">
                                    <label for="posting_date" class="col-sm-5 col-form-label">Sales Employee <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <input type="text" value="@if($details->user) {{$details->user->name}} @endif"  class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">Remarks</label> : {{$details->remarks}}
                                    <!-- <div class="col-sm-7">
                                    <textarea placeholder="Remarks"  id="remarks" type="text" name="remarks" class="form-control">{{$details->remarks}}</textarea>
                                    </div> -->
                                </div>

                            </div>
                            
                            <div class="col-sm-4" style="display: none;">
                                <div class="form-group row">
                                    <label for="reffer" class="col-sm-5 col-form-label">Total Before Discount</label>
                                    <div class="col-sm-7">
                                    <input type="text" value="@if($details->total_bf_discount) {{$details->total_bf_discount}} @endif" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="reffer" class="col-sm-5 col-form-label">Discount in %</label>
                                    <div class="col-sm-7">
                                    <input type="text" value="@if($details->discount_percent) {{$details->discount_percent}} @endif" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reffer" class="col-sm-5 col-form-label">Discount in Amount</label>
                                    <div class="col-sm-7">
                                    <input type="text" value="@if($details->discount_amount) {{$details->discount_amount}} @endif" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reffer" class="col-sm-5 col-form-label">Extra Expense</label>
                                    <div class="col-sm-7" id="expenses">
                                    <input type="text" value="@if($details->total_exp) {{$details->total_exp}} @endif" class="form-control" readonly>
                                    </div>
                                </div>

                                
                            </div>
                            

                            <div class="col-sm-4">
                                       
                               

                                <div class="form-group row" style="display: none;">
                                    <label for="reffer" class="col-sm-5 col-form-label">Tax Amount</label>
                                    <div class="col-sm-7">
                                    <input type="text" value="@if($details->tax_amount) {{$details->tax_amount}} @endif" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <label for="reffer" class="col-sm-5 col-form-label">
                                    <input type="checkbox" id="rounding_check" name="option1" value="value1" style="margin-right:10px" @if($details->rounding != "") checked @endif> Rounding
                                    </label>
                                    <div class="col-sm-7" id="rounding">
                                    <input type="number"  step="0.01"  name="roundtext" onChange="calculate_footer();" id="roundtext" class="form-control" @if($details->rounding == "") style="background-color: #ebebeb;
                                    border: 1px solid #ebebeb; color:#000;"@endif @if($details->rounding != "") style="display: block;" @else style="display: none;" @endif value="{{$details->rounding}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="reffer" class="col-sm-5 col-form-label">Total Amount</label> : @if($details->total) {{$details->total}} @endif
                                    <!-- <div class="col-sm-7">
                                    <input type="text" value="@if($details->total) {{$details->total}} @endif" class="form-control" readonly>
                                    </div> -->
                                </div>
                            </div> 
                            
                            <div class="col-sm-4">
                                        @if($details->obj_type=='Other Expense')
                                            <div class="form-group row">
                                                        <label for="referral" class="col-sm-5 col-form-label">Payment Type </label> : {{$details->payment_method}}
                                                        <!-- <div class="col-sm-7">
                                                            <select  id="ptype" name="ptype" class="form-control select ">
                                                            <option value="Cash" @if($details->payment_method=='Cash'){{'selected'}}@endif>Cash</option>
                                                            <option value="Card" @if($details->payment_method=='Card'){{'selected'}}@endif>Card</option>
                                                            <option value="Cheque" @if($details->payment_method=='Cheque'){{'selected'}}@endif>Cheque</option>
                                                            <option value="Bank Transfer" @if($details->payment_method=='Bank Transfer'){{'selected'}}@endif>Bank Transfer</option>
                                                            </select>
                                                        </div> -->
                                                </div>
                                        @endif
                            </div>
                            <!-- <div class="col-12 mt-1 mb-5" >
                                <button type="submit" class="btn btn-primary float-end"onclick="window.history.back();">BACK</button>
                            </div> -->
                            <div class="col-12 mt-1 mb-4" >
                            <button type="submit" class="btn btn-primary" style="float: right;" onclick="window.history.back();">BACK</button>
                            </div> 
                        </div>
                </div>
            </div> 
        </div>
                  
    </div>       
</div><!-- end container-->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/chart.js/chart.js.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/project-details.init.js')}}"></script>
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<!-- demo app -->
<script>
    $(document).ready(function(){
        var d = '<?php echo $total_discount;?>';
        var l = '<?php echo $doc_total;?>';
        $("#disc_id").html(d);
        $("#doc_id").html(l);
    });
</script>
@endsection
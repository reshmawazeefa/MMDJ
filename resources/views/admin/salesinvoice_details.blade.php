@extends('layouts.vertical', ["page_title"=> "Sales Invoice Details"])
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
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12 col-md-9 col-7">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/sales-invoice')}}">Sales Invoice</a></li>
                        <li class="breadcrumb-item active">Sales Invoice Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Sales Invoice Details</h4>
            </div>
        </div>
        <div class="col-lg-12 col-md-3 col-5 mb-2 pdf">
            <div class="text-lg-end float-end">
                <a href="{{url('/admin/invoicepdf/'.$details->id)}}" target="_blank" class="btn btn-primary waves-effect waves-light">View as PDF</a>
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
        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-list font-26 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($details->Item_details)}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Items</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-users font-26 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                            <div class="text-end">
                                <h3 class="text-dark mt-1" >{{$details->discount_percent}}</h3>
                                <p class="text-muted mb-1 text-truncate">Discount </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-clock font-26 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$details->tax_amount}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Tax</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-check-square font-26 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$details->total}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Amount </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <!-- project card -->
            <div class="card d-block">
            <div class="card-body body-style2 purchaseOrder table-spcl4 invoiceMstyle ">
                    <div class="row mb-0 pb-2 dashed-borderStyle">
                        <!-- <div class="col-lg-12">
                            <div class="text-lg-end">
                                <a href="{{url('/generate-pdf/'.$details->id)}}"><button type="button" class="btn btn-light waves-effect mb-2">Print</button></a>
                            </div>
                        </div> -->

<!-- newedit -->
<div class="col-lg-4">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label">
        Customer <span class="text-danger">*</span>
        <!-- <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addCustModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a> -->
        </label>
        <div class="col-sm-7">
        <input type="text" value="{{$details->customer->name}}" class="form-control" readonly>
        </div>
    </div>
    <div class="form-group row" style="display: none;">
        <label for="referral" class="col-sm-5 col-form-label">
        Ref/LPO No.
        </label>
        <div class="col-sm-7">
        <input readonly  type="text" class="form-control" name="refno" placeholder="Ref/LPO No." aria-describedby="basic-addon1" value="@if($details->ref_no) {{$details->ref_no}} @endif">
        </div>
    </div> 
    
    <div class="form-group row">
        <label for="referral" class="col-sm-12 col-form-label">
        Address <span class="text-danger">*</span>
        </label>
        <div class="col-sm-12">
        <div class="col-sm-12">
        <textarea class="form-control" name="bill_to_address" id="bill_to_address" readonly>{{$details->customer->addressIDBilling}}&#13;&#10;{{$details->customer->addressBilling}}&#13;&#10;{{$details->customer->zip_codeBilling}}</textarea>
        </div>
        </div>
    </div>
   


</div>

<div class="col-lg-4">
@php
            $docNum = $details->doc_num;
            $arr = explode('-',$docNum);
    @endphp
    <div class="form-group row">
        <label for="referral" class="col-sm-5 col-form-label">
        Doc Number <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <div class="input-group">
        <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
        <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
        </div>
        </div>
    </div> 
    <div class="form-group row" style="display: none;">
        <label for="Status" class="col-sm-5 col-form-label">
        Status <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <input  readonly type="text" class="form-control" name="status" aria-describedby="basic-addon1" value="@if($details->status) {{$details->status}} @endif">
        </div>
    </div>

    <!-- <div class="form-group row">
        <label for="posting_date" class="col-sm-5 col-form-label">
        Posting Date <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <input required type="text" name="posting_date"  class="form-control flatpickr-input active" value="@if($details->posting_date) {{$details->posting_date}} @endif" readonly>
        </div>
    </div> -->
    @php
        use Carbon\Carbon;
        
        $dateDMY = null; // Default value
        if (!empty($details->docdue_date)) {
            try {
                $dateDMY = Carbon::createFromFormat('Y-m-d', trim($details->docdue_date))->format('d-m-Y');
            } catch (\Exception $e) {
                // Log the error or handle it if necessary
                $dateDMY = null; // Keep it null if parsing fails
            }
        }
    @endphp
   

</div>

<div class="col-sm-4">
    <div class="form-group row">
        <label for="date" class="col-sm-5 col-form-label">
        DocDue Date <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <input required type="text" name="delivery_date" id="delivery_date"  class="form-control flatpickr-input active" value="{{$details->docdue_date}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="date" class="col-sm-5 col-form-label">
        Document Date <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <input required type="text" name="DocuDate" class="form-control flatpickr-input active" value="@if($details->doc_date) {{$details->doc_date}} @endif" readonly>
        </div>
    </div>

    <div class="form-group row" style="display: none;">
        <label for="refferal" class="col-sm-5 col-form-label">
        Payment Term <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <select required id="payment_term" name="payment_term" class="form-control select" disabled>
            <option value="cash" @if($details->payment_term == "cash") selected @endif>Cash</option>
            <option value="60" @if($details->payment_term == "60") selected @endif>Net-60 Days</option>
            <option value="90" @if($details->payment_term == "90") selected @endif>Net-90 Days</option>
            <option value="30" @if($details->payment_term == "30") selected @endif>Net-30 Days</option>
            <option value="120" @if($details->payment_term == "120") selected @endif>Net-120 Days</option>
        </select>
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

                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <input type="hidden" id="count" value="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item(s)</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount Price</th>
                                    <th>Tax Code</th>
                                    <th>WHSE</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody id="body">
                            @if(count($details->Item_details) > 0)
                                @foreach ($details->Item_details as $val)
                                    <tr id="tr_0">
                                        <td>{{$val->products->productName}}</td>
                                        <td>{{$val->unit}}</td>
                                        <td>{{$val->qty}}</td>
                                        <td>{{$val->unit_price}}</td>
                                        <td>{{$val->disc_price}}</td>
                                        <td>@if($val->tax_code == 0) {{'EXEMPT'}} @endif</td>
                                        <td>{{$val->products->stock->warehouse->whsName}}</td>
                                        <td>{{$val->line_total}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <!-- @php
                                $total_discount = round($total_discount,2);
                                $doc_total = round($doc_total,2)+$details->FreightCharge+$details->UnloadingCharge+$details->LoadingCharge;
                            @endphp -->
                            </tbody>
                        </table>

<div class="row pt-3 mb-2" >
        <div class="col-sm-4">
            <div class="form-group row">
                <label for="posting_date" class="col-sm-5 col-form-label">Sales Employee </label>
                <div class="col-sm-7">
                <input type="text" value="@if($details->user) {{$details->user->name}} @endif" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="referral" class="col-sm-5 col-form-label">Remarks</label>
                <div class="col-sm-7">
                <input type="text" value="{{$details->remarks}}" class="form-control" readonly>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Total Before Discount</label>
                <div class="col-sm-6">
                <input type="text" value="@if($details->total_bf_discount) {{$details->total_bf_discount}} @endif" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Discount in %</label>
                <div class="col-sm-6" id="discount_amount">
                <input type="text" name="discount_amount_value" id="discount_amount_value" class="form-control" onkeyup="calculate_footerdiscount(this.value);" value="@if($details->discount_percent) {{$details->discount_percent}} @endif" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Discount in Amount</label>
                <div class="col-sm-6" id="discount_amount">
                <input type="text" value="@if($details->discount_amount) {{$details->discount_amount}} @endif" class="form-control" readonly>
                </div>
            </div>

            
        </div>

        <div class="col-sm-4">
        <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Extra Expense</label>
                <div class="col-sm-6" id="expenses">
                <input type="text" value="@if($details->total_exp) {{$details->total_exp}} @endif" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Tax Amount</label>
                <div class="col-sm-6">
                <input type="text" value="@if($details->tax_amount) {{$details->tax_amount}} @endif" class="form-control" readonly>
                </div>
            </div>

           

            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Total Amount</label>
                <div class="col-sm-6">
                <input type="text" value="@if($details->total) {{$details->total}} @endif" class="form-control" readonly>
                </div>
            </div>
        </div> 
        <div class="col-12 mt-1 mb-4">
            <button type="submit" class="btn btn-primary" style="float: right;margin-bottom: 3%;"onclick="window.history.back();">BACK</button>
        </div>                                        
</div>



 
                                
         
                </div> <!-- end card-body-->

            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
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
@extends('layouts.vertical', ["page_title"=> "Purchase Return Details"])
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
        <div class="col-lg-12 col-md-9 col-7">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/purchase-return')}}">Purchase Return</a></li>
                        <li class="breadcrumb-item active">Purchase Return Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Purchase Return Details</h4>
            </div>
        </div>
        <div class="col-lg-12 col-md-3 col-5 mb-2 pdf">
            <div class="text-lg-end float-end">
                <a href="{{url('/admin/purchasereturnpdf/'.$details->id)}}"class="btn btn-primary waves-effect waves-light" target="_blank">View as PDF</a>
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
        <div class="col-xl-12 col-lg-12">
            <!-- project card -->
            <div class="card d-block">
            <div class="card-body body-style2 purchaseOrder table-spcl4">
                    <div class="row mb-0 pb-2 dashed-borderStyle">
<!--  -->
<div class="col-lg-4">
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-5 col-form-label">
        Supplier
        <label for="customer" class="form-label"></label>
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


<div class="col-lg-4">

    <div class="form-group row" style="display: none;">
        <label for="referral" class="col-sm-5 col-form-label">
        Place of Supply
        </label>
        <div class="col-sm-7">
        <input readonly  type="text" class="form-control" name="place_of_sply" id="place_of_sply" aria-describedby="basic-addon1" value="@if($details->pl_supply) {{$details->pl_supply}} @endif" >
        </div>
    </div>

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
        DocDue Date <span class="text-danger">*</span>
        </label>
        <div class="col-sm-7">
        <input required type="text" name="docdue_date" id="docdue_date"  class="form-control flatpickr-input active" value="{{$dateDMY}}" readonly>
        </div>
    </div>

    <div class="form-group row"  style="display: none;">
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

                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <input type="hidden" id="count" value="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Remarks</th>
                                    <!-- <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Discount Price</th>
                                    <th>Tax Code</th>
                                    <th>WHSE</th> -->
                                    <th>Amount</th>
                                    <!-- <th>Serial No</th> -->
                                </tr>
                            </thead>
                            <tbody id="body">
                            @if(count($details->Item_details) > 0)
                                @foreach ($details->Item_details as $val)
                                    <tr id="tr_0">
                                        <td>{{$val->remarks}}</td>
                                        <!-- <td>{{$val->qty}}</td>
                                        <td>{{$val->unit_price}}</td>
                                        <td>{{$val->disc_price}}</td>
                                        <td>{{$val->tax_code}}</td>
                                        <td>{{$val->whs_code}}</td> -->
                                        <td>{{$val->line_total}}</td>
                                        <!-- <td>{{$val->serial_no}}</td> -->
                                    </tr>
                                @endforeach
                            @endif
                            <!-- @php
                                $total_discount = round($total_discount,2);
                                $doc_total = round($doc_total,2)+$details->FreightCharge+$details->UnloadingCharge+$details->LoadingCharge;
                            @endphp -->
                            </tbody>
                    </table>

<div class="row pt-3 mb-2">
    <div class="col-sm-4">
        <div class="form-group row"  style="display: none;">
            <label for="posting_date" class="col-sm-5 col-form-label">Sales Employee <span class="text-danger">*</span></label>
            <div class="col-sm-7">
            <input type="text" value="@if($details->referral3) {{$details->referral3->name}} @endif" class="form-control" readonly>
            </div>
        </div>

        <div class="form-group row"  style="display: none;">
            <label for="referral" class="col-sm-5 col-form-label">Remarks</label>
            <div class="col-sm-7">
            <input type="text" value="{{$details->remarks}}" class="form-control" readonly>
            </div>
        </div>

    </div>


    <div class="col-sm-4">
        <div class="form-group row"  style="display: none;">
            <label for="reffer" class="col-sm-6 col-form-label">Total Before Discount</label>
            <div class="col-sm-6">
            <input type="text" value="@if($details->total_bf_discount) {{$details->total_bf_discount}} @endif" class="form-control" readonly>
            </div>
        </div>
        <div class="form-group row"  style="display: none;">
            <label for="reffer" class="col-sm-6 col-form-label">Discount in %</label>
            <div class="col-sm-6">
            <input type="text" value="@if($details->discount_percent) {{$details->discount_percent}} @endif" class="form-control" readonly>
            </div>
        </div>

        <div class="form-group row"  style="display: none;">
            <label for="reffer" class="col-sm-6 col-form-label">Discount in Amount</label>
            <div class="col-sm-6">
            <input type="text" value="@if($details->discount_amount) {{$details->discount_amount}} @endif" class="form-control" readonly>
            </div>
        </div>

        
    </div>

    <div class="col-sm-4">
    <div class="form-group row"  style="display: none;">
            <label for="reffer" class="col-sm-6 col-form-label">Extra Expense</label>
            <div class="col-sm-6" id="expenses">
            <input type="text" value="@if($details->total_exp) {{$details->total_exp}} @endif" class="form-control" readonly>
            </div>
        </div>

        <div class="form-group row"  style="display: none;">
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
    
<div class="col-12  mt-1 mb-4">
<button type="submit" class="btn btn-primary" style="float: right;" onclick="window.history.back();">BACK</button>
</div>
                                                
</div>




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
@extends('layouts.vertical', ["page_title"=> "Sales Return Details"])
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
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sales Return</a></li>
                        <li class="breadcrumb-item active">Sales Return Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Sales Return Details</h4>
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
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-list font-26 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($details->Item_details)}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Items</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-users font-26 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1" >{{$details->discount_percent}}</h3>
                                <p class="text-muted mb-1 text-truncate">Discount </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-clock font-26 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$details->tax_amount}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Tax</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-light">
                                <i class="fe-check-square font-26 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
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
        <div class="col-xl-12 col-lg-6">
            <!-- project card -->
            <div class="card d-block">
            <div class="card-body body-style2 purchaseOrder table-spcl4">
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
        </label>
        <div class="col-sm-7">
        <input type="text" value="{{$details->customer->name}}" class="form-control" readonly>
        </div>
    </div>
    <div class="form-group row">
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
        <div class="row">
        <div class="col-sm-6">
        <textarea class="form-control" name="bill_to_address" id="bill_to_address">@if($details->address_bill) {{$details->address_bill}} @endif</textarea>
        </div>
        <div class="col-sm-6">
        <textarea class="form-control" name="ship_to_address" id="ship_to_address">@if($details->address_ship) {{$details->address_ship}} @endif</textarea>
        </div>
        </div>
        </div>
    </div>
   


</div>

<div class="col-sm-4">
    <div class="form-group row">
        <label for="referral" class="col-sm-5 col-form-label">
        Place of Supply
        </label>
        <div class="col-sm-7">
        <input readonly  type="text" class="form-control" name="place_of_sply" id="place_of_sply" aria-describedby="basic-addon1" value="@if($details->pl_supply) {{$details->pl_supply}} @endif" >
        </div>
    </div> 
    <div class="form-group row">
        <label for="referral" class="col-sm-5 col-form-label">
        Tax Type
        </label>
        <div class="col-sm-7">
        <input readonly  type="text" class="form-control" name="tax_type" id="tax_type" aria-describedby="basic-addon1" value="@if($details->tax_type) {{$details->tax_type}} @endif" >
        </div>
    </div> 
    @php
        $docNum = $details->doc_num;
        $arr = explode('-',$docNum);
    @endphp
    <div class="form-group row">
        <label for="referral" class="col-sm-5 col-form-label">
        Doc Number
        </label>
        <div class="col-sm-7">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
            <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
        </div>
        </div>
    </div> 
    <div class="form-group row">
        <label for="Status" class="col-sm-5 col-form-label">
        Status
        </label>
        <div class="col-sm-7">
        <input  readonly type="text" class="form-control" name="status" aria-describedby="basic-addon1" value="@if($details->status) {{$details->status}} @endif">
        </div>
    </div> 
</div>


<div class="col-sm-4">
    <div class="form-group row">
        <label for="posting_date" class="col-sm-5 col-form-label">
        Posting Date
        </label>
        <div class="col-sm-7">
        <input required type="text" name="posting_date"  class="form-control flatpickr-input active" value="@if($details->posting_date) {{$details->posting_date}} @endif" readonly>
        </div>
    </div> 
    @php
    use Carbon\Carbon;
        $dateDMY = $details->docdue_date ? Carbon::createFromFormat('Y-m-d', $details->docdue_date)->format('d-m-Y') : null;
    @endphp
    <div class="form-group row">
        <label for="date" class="col-sm-5 col-form-label">
        DocDue Date
        </label>
        <div class="col-sm-7">
        <input required type="text" name="docdue_date" id="docdue_date"  class="form-control flatpickr-input active" value="{{$dateDMY}}" readonly>
        </div>
    </div> 
    <div class="form-group row">
        <label for="date" class="col-sm-5 col-form-label">
        Document Date
        </label>
        <div class="col-sm-7">
        <input required type="text" name="DocuDate" class="form-control flatpickr-input active" value="@if($details->doc_date) {{$details->doc_date}} @endif" readonly>
        </div>
    </div> 
    <div class="form-group row">
        <label for="refferal" class="col-sm-5 col-form-label">
        TAX Reg No
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
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Discount Price</th>
                                        <th>Tax Code</th>
                                        <th>WHSE</th>
                                        <th>Line Total</th>
                                        <th>Serial No</th>
                                    </tr>
                                </thead>
                            <tbody id="body">
                                @if(count($details->Item_details) > 0)
                                    @foreach ($details->Item_details as $val)
                                        <tr id="tr_0">
                                            <td>{{$val->products->productName}}</td>
                                            <td>{{$val->qty}}</td>
                                            <td>{{$val->unit_price}}</td>
                                            <td>{{$val->disc_price}}</td>
                                            <td>{{$val->tax_code}}</td>
                                            <td>{{$val->whs_code}}</td>
                                            <td>{{$val->line_total}}</td>
                                            <td>{{$val->serial_no}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            
                            </tbody>
                    </table>

<div class="row pt-3 mb-2">
        <div class="col-sm-4">
            <div class="form-group row">
                <label for="posting_date" class="col-sm-5 col-form-label">Sales Employee <span class="text-danger">*</span></label>
                <div class="col-sm-7">
                <input type="text" value="@if($details->referral3) {{$details->referral3->name}} @endif" class="form-control" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="referral" class="col-sm-5 col-form-label">Remarks</label>
                <div class="col-sm-7">
                <input type="text" value="{{$details->remarks}}" class="form-control"  readonly>
                </div>
            </div>
        </div>
        <div class="col-sm-4">


        <div class="form-group row">
                <label for="refferal" class="col-sm-6 col-form-label">Reason for Return</label>
                <div class="col-sm-6">
                <input type="text" value="{{$details->return_reason}}" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="refferal" class="col-sm-6 col-form-label">Type of Damage</label>
                <div class="col-sm-6">
                <input type="text" value="{{$details->damage_type}}" class="form-control" readonly>
                </div>
            </div>


            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Total Before Discount</label>
                <div class="col-sm-6">
                <input type="text" value="@if($details->total_bf_discount) {{$details->total_bf_discount}} @endif" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="reffer" class="col-sm-6 col-form-label">Discount in %</label>
                <div class="col-sm-6" id="discount_amount">
                <input type="text" value="@if($details->discount_percent) {{$details->discount_percent}} @endif" class="form-control" readonly>
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
<button type="submit" class="btn btn-primary" style="float: right;"onclick="window.history.back();">BACK</button>
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
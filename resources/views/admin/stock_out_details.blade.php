@extends('layouts.vertical', ["page_title"=> "Stock Out Details"])
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Stock Out</a></li>
                        <li class="breadcrumb-item active">Stock Out Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Stock Out Details</h4>
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
        <div class="col-md-7 col-xl-4">
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

        <div class="col-md-7 col-xl-4">
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
                                <h3 class="text-dark mt-1" >{{$details->total_qty}}</h3>
                                <p class="text-muted mb-1 text-truncate">Quantity </p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->


        <div class="col-md-7 col-xl-4">
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
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ number_format($details->total_price, 2) }}</span></h3>
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
                        <div class="col-lg-4">
                                <div class="form-group row">
                                                <label for="from_branch" class="col-sm-5 form-label">From Branch</label>
                                                <div class="col-sm-7"><input   type="text" class="form-control" name="from_branch" id="from_branch"  aria-describedby="basic-addon1" value="{{$details->from_branch_name}}" readonly>
                                               
                                            </div>
                                    
                                </div>
                                <div class="form-group row">
                                        
                                        <label for="from_branch" class="col-sm-5 form-label">To Branch</label>
                                        <div class="col-sm-7"><input   type="text" class="form-control" name="to_branch" id="to_branch"  aria-describedby="basic-addon1" value="{{$details->to_branch_name}}" readonly>
                                        </div>
                                </div>
                                    
                                <div class="form-group row">
                                                <label for="referral" class="col-sm-5 form-label">Address <span class="text-danger">*</span></label>
                                                <div class="col-sm-7"><textarea class="form-control" name="bill_to_address" id="bill_to_address" readonly>@if($details->address_billto) {{$details->address_billto}} @endif</textarea>
                                            </div>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                        @php
                                        $docNum = $details->doc_number;
                                        $arr = explode('-',$docNum);
                                    @endphp
                                    <div class="form-group row">
                                            <label for="referral" class="col-sm-5 form-label">Doc Number <span class="text-danger">*</span></label>
                                            <div class="col-sm-7"><div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">{{$arr[0]}}</span>
                                                <input required readonly type="text" class="form-control" name="docNumber" value="{{$arr[1]}}" placeholder="Doc Number" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                                <label for="status" class="col-sm-5 form-label">Status</label>
                                                <div class="col-sm-7">
                                                <input  readonly type="text" class="form-control" name="status" aria-describedby="basic-addon1" value="@if($details->status) {{$details->status}} @endif">
                                            </div>
                                    </div>
                                        @php
                                        use Carbon\Carbon;
                                         $pdateDMY = $details->posting_date ? Carbon::createFromFormat('Y-m-d', $details->posting_date)->format('d-m-Y') : null;
                                        @endphp
                                    <div class="form-group row">
                                                <label for="posting_date" class="col-sm-5 form-label">Posting Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-7"><input required type="text" name="posting_date"  class="form-control flatpickr-input active" value="{{$pdateDMY}}" readonly>
                                            </div>
                                    </div>
                        </div>
                        <div class="col-lg-4">
                                        @php
                                       
                                         $dateDMY = $details->delivery_date ? Carbon::createFromFormat('Y-m-d', $details->delivery_date)->format('d-m-Y') : null;
                                        @endphp
                                        <div class="form-group row">
                                                <label for="date" class="col-sm-5 form-label">Delivery Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-7"><input required type="text" name="delivery_date" id="delivery_date"  class="form-control flatpickr-input active" value="{{$dateDMY}}" readonly>
                                            </div>
                                        </div>
                                        @php
                                       
                                         $docdateDMY = $details->doc_date ? Carbon::createFromFormat('Y-m-d', $details->doc_date)->format('d-m-Y') : null;
                                        @endphp
                                        <div class="form-group row">
                                                <label for="date" class="col-sm-5 form-label">Document Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-7"><input required type="text" name="DocuDate" class="form-control flatpickr-input active" value="{{$docdateDMY}}" readonly>
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
                                        <!-- <th>Unit Price</th> -->
                                        <th>WHSE</th>
                                        <!-- <th>Line Total</th> -->
                                        <th>Serial No</th>
                                    </tr>
                                </thead>
                            <tbody id="body">
                                @if(count($details->Item_details) > 0)
                                    @foreach ($details->Item_details as $val)
                                        <tr id="tr_0">
                                            <td>{{$val->products->productName}}</td>
                                            <td>{{$val->qty}}</td>
                                            <!-- <td>{{$val->unit_price}}</td> -->
                                            <td>{{$val->products->stock->warehouse->whsName}}</td>
                                            <!-- <td>{{$val->line_total}}</td> -->
                                            <td>{{$val->serial_no}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            
                            </tbody>
                    </table>

                    <div class="row pt-3 mb-2">
                        <div class="col-sm-4 ">
                                <div class="form-group row">
                                        <label for="referral" class="col-sm-5 form-label">Sales Employee</label>
                                         <div class="col-sm-7"><input type="text" value="@if($details->referral3) {{$details->referral3->name}} @endif" class="form-control" readonly>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                        <label for="referral" class="col-sm-5 form-label">Remarks</label>
                                        <div class="col-sm-7"><input type="text" value="{{$details->remarks}}" class="form-control" readonly>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                                <div class="form-group row">
                                        <label for="total_qty" class="col-sm-5 form-label">Total Quantity</label>
                                        <div class="col-sm-7"><input type="text" value="@if($details->total_qty) {{$details->total_qty}} @endif" class="form-control" readonly>
                                        </select>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                        <label for="total_price" class="col-sm-5 form-label">Total Amount</label>
                                        <div class="col-sm-7"><input type="text" value="@if($details->total_price) {{$details->total_price}} @endif" class="form-control" readonly>
                                        </select>
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
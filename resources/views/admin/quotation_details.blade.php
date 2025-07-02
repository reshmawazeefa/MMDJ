@extends('layouts.vertical', ["page_title"=> "Quotation Details"])
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quotations</a></li>
                        <li class="breadcrumb-item active">Quotation Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Quotation Details</h4>
            </div>
        </div>
        <div class="col-lg-12 pt-2 pb-2">
            <div class="text-lg-end">
                <a href="{{url('/admin/pdf/'.$details->id)}}" class="btn btn-primary waves-effect waves-light" >View as PDF</a>
                @if($details->status == 'Send for Approval')
                    <a href="{{url('/admin/quotations/'.$details->id.'/sendapproval')}}"class="btn btn-primary waves-effect waves-light">Send for Approval</a>
                
                @elseif($details->status == 'Open' && (Auth::user()->hasRole('Admin') || $details->manager1 == Auth::user()->id || $details->manager2 == Auth::user()->id))
                    <a href="{{url('/admin/quotations/approve/'.$details->id)}}"class="btn btn-primary waves-effect waves-light">Approve</a>
                
                @elseif($details->status == 'Approve' && (Auth::user()->hasRole('Admin') || $details->manager1 == Auth::user()->id || $details->manager2 == Auth::user()->id))
                    <a href="{{url('/admin/quotations/confirm/'.$details->id)}}"class="btn btn-primary waves-effect waves-light">Confirm</a>
                @endif
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
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($details->items)}}</span></h3>
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
                                <h3 class="text-dark mt-1" id="disc_id"><span data-plugin="counterup">{{$details->DiscAmount}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Discount</p>
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
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$details->TaxAmount}}</span></h3>
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
                                <h3 id="doc_id" class="text-dark mt-1"><span data-plugin="counterup">{{$details->DocTotal}}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Amount</p>
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
            <div class="card-body body-style4 productMStyle table-spcl2 without-button">
                    <div class="row mb-3">
                        <!-- <div class="col-lg-12">
                            <div class="text-lg-end">
                                <a href="{{url('/generate-pdf/'.$details->id)}}"><button type="button" class="btn btn-light waves-effect mb-2">Print</button></a>
                            </div>
                        </div> -->
                    <div class="col-lg-4">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-5 col-form-label">
                            Customer</label>
                            <div class="col-sm-7">
                            <input type="text" value="{{$details->customer->name}}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="referral" class="col-sm-5 col-form-label">
                            Referral(Engineer)
                            </label>
                            <div class="col-sm-7">
                            <input type="text" value="@if($details->referral1) {{$details->referral1->name}} @endif" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="referral" class="col-sm-5 col-form-label">
                        Referral(Contractor)
                            </label>
                            <div class="col-sm-7">
                            <input type="text" value="@if($details->referral2) {{$details->referral2->name}} @endif" class="form-control" readonly>
                            </div>  
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-5 col-form-label">
                            Date</label>
                            <div class="col-sm-7">
                            <input type="date" name="date" value="{{$details->DocDate}}" class="form-control" readonly="readonly">
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-4">
                        

                        <div class="form-group row">
                            <label for="date" class="col-sm-5 col-form-label">
                            Due Date
                            </label>
                            <div class="col-sm-7">
                            <input type="date" name="date" value="{{$details->DueDate}}" class="form-control" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="referral" class="col-sm-5 col-form-label">
                            Doc Number
                            </label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                <input type="text" value="{{$details->DocNo}}" class="form-control" readonly>
                                </div>
                            </div>  
                        </div>

                        <div class="form-group row">
                            <label for="refferal" class="col-sm-5 col-form-label">
                            Price List</label>
                            <div class="col-sm-7">
                            <input type="text" value="{{$details->PriceList}}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="refferal" class="col-sm-5 col-form-label">
                            Vehicle type
                            </label>
                            <div class="col-sm-7">
                            <input type="text" value="{{$details->VehType}}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        

                        

                        <div class="form-group row">
                            <label for="referral" class="col-sm-5 col-form-label">
                            Distance(in km)
                            </label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                <input type="text" value="{{$details->Distance}}" class="form-control" readonly>
                                </div>
                            </div>  
                        </div>

                        <div class="form-group row">
                            <label for="referral" class="col-sm-5 col-form-label">
                            Status
                            </label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                <input type="text" value="{{$details->status}} @if($details->cancelReason)(Reason : {{$details->cancelReason}}) @endif" class="form-control" readonly>
                                </div>
                            </div>  
                        </div>

                        <div class="form-group row">
                            <label for="referral" class="col-sm-5 col-form-label">
                            Remarks
                            </label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                <input type="text" value="{{$details->Remarks}}" class="form-control" readonly>
                                </div>
                            </div>  
                        </div>




                    </div>



                    </div>

                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <input type="hidden" id="count" value="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Line No</th>
                                    <th>Item(s)</th>
                                    <th>Quantity</th>
                                    <th>Sqmt</th>
                                    <th>Sqft</th>
                                    <th>Area</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>Tax Rate</th>
                                    <th>Tax</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody id="body">
                                @if(count($details->items) > 0)
                                    @foreach ($details->items as $val)
                                    @php 
                                        $discount = $val->LineDiscPrice * (100+$val->TaxRate)/100; 
                                        $total_discount = $total_discount + $discount;

                                        $line_total = round($val->LineTotal * (100+$val->TaxRate)/100,2);
                                        $doc_total = $doc_total + $line_total;
                                    @endphp
                                    <tr id="tr_0">
                                        <td>{{$val->LineNo}}</td>
                                        <td>{{$val->products->productName}}</td>
                                        <td>{{$val->Qty}}</td>
                                        <td>{{$val->SqmtQty}}</td>
                                        <td>{{$val->SqftQty}}</td>
                                        <td>{{$val->area}}</td>
                                        <td>{{round($val->UnitPrice * (100+$val->TaxRate)/100,2)}}</td>
                                        <td>{{round($discount,2)}}</td>
                                        <td>{{$val->TaxRate}}</td>
                                        <td>{{$val->TaxAmount}}</td>
                                        <td>{{$line_total}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @php
                                $total_discount = round($total_discount,2);
                                $doc_total = round($doc_total,2)+$details->FreightCharge+$details->UnloadingCharge+$details->LoadingCharge;
                            @endphp
                            </tbody>
                        </table>
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
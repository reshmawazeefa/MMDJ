@extends('layouts.vertical', ["page_title"=> "Day End Closing Details"])
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Day End Closing</a></li>
                        <li class="breadcrumb-item active">Day End Closing Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Day End Closing Details</h4>
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
        <div class="col-xl-12 col-lg-6">
            <!-- project card -->
            <div class="card d-block">
                <div class="card-body body-style">
                    <div class="row mb-2">
                        <div class="container">
                            <div class="row mb-3 m-style">
                                    <div class="col-sm-12 mt-2 mb-3 pb-3 borderStyleclosing">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Branch
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="text" id="cash_sum"  class=" form-control"  name="cash_sum" value="{{session('branch_name')}}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Opening Balance
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="text" id="opening_balance"  class=" form-control"  name="opening_balance" value="{{$details->OpeningBalance ?? 0}}" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Counter Balance
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="text" id="counter_balance"  class=" form-control"  name="counter_balance" value="{{$details->CounterBalance ?? 0}}" readonly>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="col-sm-12 mb-3 pb-3 borderStyleclosing">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Closing Date
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input type="text" id="closing_date" class="form-control" name="closing_date" value="{{$details->DocDate}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Cash Total
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="cash_total"  class=" form-control"  name="cash_total" readonly value="{{ $details->CashTotal ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Petty Cash
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="petty_cash"  class=" form-control" name="petty_cash" readonly value="{{ $details->PettyCash ?? 0 }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Card Total
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="card_total"  class=" form-control"  name="card_total" readonly value="{{$details->CardTotal ?? 0}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Cheque Total
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="cheque_total"  class=" form-control"  name="cheque_total" readonly value="{{$details->ChequeTotal ?? 0}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Bank Transfer
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="bank_transfer"  class=" form-control"  name="bank_transfer" readonly value="{{$details->TotalBankTransfer ?? 0}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-2">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Total Payment
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="total_payment"  class=" form-control"  name="cheque_branch" readonly value="{{ $details->PaymentTotal ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Total Sales
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="total_sales"  class=" form-control"  name="total_sales" value="{{$details->TotalSales ?? 0}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Total Returns
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="total_returns"  class=" form-control"  name="total_returns" value="{{$details->TotalSalesReturns ?? 0}}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Net Sales 
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="net_sales"  class=" form-control"  name="net_sales" value="{{$details->NetSales ?? 0}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Net Cash
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="net_cash"  class=" form-control"  name="net_cash" value="{{$details->NetCash ?? 0 }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="referral" class="col-sm-5 col-form-label">
                                                    Transfer To Safe  
                                                    </label>
                                                    <div class="col-sm-7">
                                                    <input  type="number" id="transfer_to_safe"  class=" form-control"  name="transfer_to_safe" value="{{$details->TransferToSafe ?? 0 }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                            </div> 
                        </div>
                    </div>

                        <div class="row">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="button" class="btn btn-primary" onclick="window.history.back();">BACK</button>
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
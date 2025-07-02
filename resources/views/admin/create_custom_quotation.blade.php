@extends('layouts.vertical', ["page_title"=> "Quotation Create"])

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
            <p class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
            </p>
            @endif
            <div class="card">
                <form method="post" class="parsley-examples" action="{{url('admin/custom_quotation/insert')}}">
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="customer" class="form-label">Customer <span class="text-danger">*</span></label>
                                            <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addCustModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a>
                                            <select required name="customer" class="customerSelect form-control select2">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Referral(Engineer)</label>
                                            <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#addPartModal"><i class="mdi mdi-plus-circle me-1"></i>Add</a>
                                            <select name="partner1" class="engineerSelect form-control select2">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Referral(Contractor)</label>
                                            <select required name="partner2" class="contractorSelect form-control select2">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Referral(Sales Executive) <span class="text-danger">*</span></label>
                                            <select required name="partner3" class="agentSelect form-control select2">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                            <input required type="date" name="date" value="{{date('Y-m-d')}}" class="form-control flatpickr-input active" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                            <input required type="date" name="DueDate" class="form-control flatpickr-input active">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Doc Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1">{{date("Y")}}</span>
                                                <input required readonly type="text" class="form-control" name="docNumber" placeholder="Doc Number" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Price List <span class="text-danger">*</span></label>
                                            <select required id="price_list" name="priceList" class="form-control select">
                                                <option>Retail Price</option>
                                                <!--<option>Distributor Price</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="referral" class="form-label">Vehicle type <span class="text-danger">*</span></label>
                                            <select required name="vehicle_type" class="form-control select">
                                                <option value="">Select</option>
                                                <option>Light</option>
                                                <option>Heavy</option>
                                                <option>Any vehicle</option>
                                                <option>N/A</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="me-3">
                                            <label for="distance" class="form-label">Distance(in km) <span class="text-danger">*</span></label>
                                            <input required type="number" name="km" steps="0.5" class="form-control">
                                        </div>
                                    </div>
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
                        @for ($i = 0; $i < 1; $i++)
                        <div class="ech-tr" id="tr_{{$i}}">
                            <div style="display:none">
                                <span class="taxable_{{$i}}"></span>
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
                                            <label class="td-label">Item Type
                                            
                                            </label>
                                            <div class="td-value">
                                            <select id="product_{{$i}}" required onChange="set_data({{$i}})" name="product[]" class="product_{{$i}} form-control">
                                                <option value="">Select</option>
                                                <option value="NS10117">MARBLE SLAB</option>
                                                <option value="NS10118">GRANITE SLAB</option>
                                                <option value="OT90126">STEEL STAND</option>
                                                <option value="NS10009">COMPOSITE QUARTZ BIANCO CLASSIC - KALINGA</option>
                                                <option value="NS10010">COMPOSITE QUARTZ BIANCO NEVE</option>
                                                <option value="NS10015">COMPOSITE QUARTZ FONDENTE BROWN</option>
                                                <option value="NS10017">COMPOSITE  QUARTZ GRIGIO DIAMANTE - KALINGA</option>
                                                <option value="NS10018">COMPOSITE QUARTZ GRIGIO LONDRA - KALINGA</option>
                                                <option value="NS10021">COMPOSITE QUARTZ MARRONE DIAMANTE - KALINGA</option>
                                                <option value="NS10024">COMPOSITE QUARTZ NERO DIAMANTE - KALINGA</option>
                                                <option value="NS10004">COMPOSITE QUARTS BIANCO DIAMANTE - KALINGA</option>
                                                <option value="NS10023">COMPOSITE QUARTZ NERO CLASSIC</option>
                                                <option value="NS10030">COMPOSTE QUARTS SANDY DIAMANTE - KALINGA</option>
                                                <option value="NS10016">COMPOSITE QUARTZ GIALLO DIAMANTE - KALINGA</option>
                                                <option value="NS10011">COMPOSITE QUARTZ BLUE DIAMANTE-KALINGA</option>
                                                <option value="NS10000">ANTICO BROWN (KALINGA</option>) TERRAZZO</option>
                                                <option value="NS10001">ARTIFICAL MARBLE SLABS MARCELLO-18 MM KALINGA</option>
                                                <option value="NS10002">ARTIFICAL MARBLE SLABS TIBERIO -15 MM</option>
                                                <option value="NS10003">COMPOSITE QUAETZ ROSSO DIAMANTE - KALINGA</option>
                                                <option value="NS10005">COMPOSITE QUARTS - CEMENT QUARTZ</option>
                                                <option value="NS10006">COMPOSITE QUARTS CLASSIC BEIGE</option>
                                                <option value="NS10007">COMPOSITE QUARTS VETRO BIANCO - KALINGA</option>
                                                <option value="NS10008">COMPOSITE QUARTZ BEIGE DIAMANTE</option>
                                                <option value="NS10012">COMPOSITE QUARTZ CONCRETE 15 MM</option>
                                                <option value="NS10013">COMPOSITE QUARTZ CONCRETE 20MM</option>
                                                <option value="NS10014">COMPOSITE QUARTZ CREMA SCURO - KALINGA</option>
                                                <option value="NS10019">COMPOSITE QUARTZ JERUSALAM GRAY DIAMANTE</option>
                                                <option value="NS10020">COMPOSITE QUARTZ JERUSALEM DIAMANTE</option>
                                                <option value="NS10022">COMPOSITE QUARTZ MOCCA DIAMANTE  - KALINGA</option>
                                                <option value="NS10025">COMPOSITE QUARTZ - NISLEY 15MM</option>
                                                <option value="NS10026">COMPOSITE QUARTZ - NISLEY 20MM</option>
                                                <option value="NS10027">COMPOSITE QUARTZ PAQS  CREMA VERONA</option>
                                                <option value="NS10028">COMPOSIT QUARTS CREMA VERONA 20MM</option>
                                                <option value="NS10029">COMPOSIT QUARTZ CHOCOLATE BROWN</option>
                                                <option value="NS10151">ARTIFICIAL QUARTZ SLABS USH 20 MM (KALINGA)</option>
                                                <option value="NS10031">CRISTALISED GLASS PANEL</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Item name</label>
                                            <div class="td-value">
                                            <input required type="text" name="name[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Price(per Sqft)</label>
                                            <div class="td-value">
                                                <input step="0.01" type="number" id="sqftprice_{{$i}}" required class ="form-control sqftprice_{{$i}}" onkeyup="price_calc({{$i}})" name="sqftprice[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                                        <div class="ech-td">
                                            <label class="td-label">Sqft</label>
                                            <div class="td-value">
                                                <input min="0.01" type="number" step="0.01" id="sqft_{{$i}}" required class="sqft_{{$i}} form-control" onkeyup="price_calc({{$i}})" name="sqft[]"> 
                                                <input type="hidden" id="stockdet_{{$i}}" value="">                                   
                                            </div>
                                        </div>
                                    </div>                                
                                    
                                    <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
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
                                                <input type="number" id="discvalue_{{$i}}" step="0.0001" value="0" class="form-control" onkeyup="price_calc({{$i}})" name="disc_perct[]">
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
                                            <label class="td-label">After Disc Price/Sqft</label>
                                            <div class="td-value">
                                            <span style="display:none;" class="discount_{{$i}}"></span>
                                            <span class="sqftamtafterdisc_{{$i}}"></span>
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

                    <div class="specarea">
                        <input value="0" type="hidden" name="discount_amount">
                        <input value="0" type="hidden" name="tax_amount">
                        <input value="0" type="hidden" name="grand_total">
                        <!--<ul>
                            <li><h6>Total Quantity</h6></li>
                            <li><p id="tot_qty"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Total sqm</h6></li>
                            <li><p id="tot_sqm"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Total sqft</h6></li>
                            <li><p id="tot_sqft"></p></li>
                        </ul>-->
                        <ul>
                            <li><h6>Total Amount</h6></li>
                            <li><p id="total_amount"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Discount </h6></li>
                            <li><p id="discount_amount"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Tax</h6></li>
                            <li><p id="tax_amount"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Freight charges</h6></li>
                            <li><p id="freight"><input type="number" step="0.5" name="FreightCharge" onkeyup="calculate_footer();" id="freight_charge" class="form-control"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Loading charges</h6></li>
                            <li><p id="loading"><input type="number" step="0.5" name="LoadingCharge" onkeyup="calculate_footer();" id="loading_charge" class="form-control"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Unloading charges</h6></li>
                            <li><p id="unloading"><input type="number" step="0.5" name="UnloadingCharge" onkeyup="calculate_footer();" id="unloading_charge" class="form-control"></p></li>
                        </ul>
                        <ul>
                            <li><h6>Grand Total</h6></li>
                            <li><p id="grand_total"></p></li>
                        </ul>
                    </div>
                    <div>&nbsp;</div>
                    <input placeholder="Remarks" type="text" name="remarks" class="form-control"> 
                    <div>&nbsp;</div>
                    <div class="col-sm-12">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
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
<!-- end demo js-->
<!-- demo app -->
<!-- end demo js-->
@include('includes.scripts')
@endsection
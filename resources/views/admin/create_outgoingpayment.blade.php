@extends('layouts.vertical', ["page_title"=> "Outgoing Payment Create"])

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
<style>
    .m-style h5{
    font-weight: 700;
    font-family: 'Nunito', sans-serif;
    text-transform: uppercase;
    color: #00295f;
    }
    .card-body .tab a{
background: #FFFFF;
padding: 1% 2%;
border-radius: 5px;
color: #000;
font-size:13px;
}
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}
.tab a {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

.tab a:hover {
  background-color: #ddd;
}

.tab a.active {
  background-color: #ccc;
}

h4{
    font-family: "Nunito", sans-serif;
}
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.topright {
  float: right;
  cursor: pointer;
  font-size: 28px;
}

.topright:hover {color: red;}
table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            /* border-bottom: 4px solid #007bff; 
            background-color: #f4f4f4; */
        }
        .checkbox-cell {
            width: 5%;
        }

#invoiceTableBody td{
    text-align: left;
}
.new .form-control:disabled {
    background-color: #eeeeee!important;
    opacity: 1;
    color: #979494;
    font-size:13px;
}
</style>
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
                            <a href="{{url('admin/outgoing-payment-create')}}">Outgoing Payment</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Outgoing Payment</h4>
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
            <div class="card incomingPayment purchaseOrder table-spcl4">
                <form id="outgoing-payment-submit" method="post" class="parsley-examples" action="{{url('admin/outgoing-payment/insert')}}">
                    {{csrf_field()}}
                    <div class="card-body body-style">
                        <div class="row mb-3">

                            <div class="col-lg-4 ">
                                <div class="form-group row bp_name" id="for_supplier">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">
                                    BP Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="customer" id="customer" class="customerSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row bp_name" id="for_customer">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">
                                    BP Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="cust" id="cust" class="cusSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row ref_no" style="display: none;">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Ref/LPO No. <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input   type="text" class="form-control" name="refno" placeholder="Ref/LPO No." aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row baddress" style="display: none;">
                                    <div class="col-sm-5">
                                    Address <span class="text-danger">*</span>
                                    </div>
                                    <div class="col-sm-7">
                                    <textarea class="form-control" name="bill_to_address" id="bill_to_address" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Doc Number <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><select name="doc_list" id="doc_list" class="doc_listSelect form-control select2">
                                    <option value="TRKFHL" selected>TRKFHL</option>
                                    </select></span>
                                    <input required disabled type="text" class="form-control" name="docNumber" placeholder="Doc Number" aria-describedby="basic-addon1">
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                    <label for="date" class="col-sm-5 col-form-label">
                                    Delivery Date<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required type="date" name="delivery_date" id="delivery_date"  class="form-control flatpickr-input active">
                                    
                                    </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                    <label for="Status" class="col-sm-5 col-form-label">
                                    Status
                                    </label>
                                    <div class="col-sm-7">
                                    <select name="status" class="statusSelect form-control select2" disabled>
                                        <option value="Open">Open</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Posting Date <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input  type="date" name="posting_date" id="posting_date"  class="form-control flatpickr-input active" value="<?php echo date('d-m-Y');?>">
                                    
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4">



                                <div class="form-group row">
                                    <label for="date" class="col-sm-5 col-form-label">
                                    Document Date <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required type="date" name="DocuDate" id="DocuDate" class="form-control flatpickr-input active" value="<?php echo date('d-m-Y');?>" >
                                    
                                    </div>
                                </div>

                                <div class="form-group row" style="display: none;">
                                    <label for="refferal" class="col-sm-5 col-form-label">
                                    Account Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select  id="account_type" name="account_type" class="form-control select">
                                    <option value="supplier" selected>Supplier</option>
                                    <option value="customer">Customer</option>
                                    <option value="account">Account</option>
                                    <option value="advance">Advance</option>
                                    </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                   <div class="col-sm-12">
                        <div class="tab p-2">
                        <a class="tablinks"  onclick="openCity(event, 'Paris')" class="ms-5" id="defaultOpen">Inv Details</a>
                        <a class="tablinks" onclick="openCity(event, 'London')"  style="display:none;">Payment Details</a>
                        </div>
                        <div id="Paris" class="tabcontent">
                        <input type="hidden" id="count" value="0">
            


                        
                        <div class="new-table mt-2">    
                        @for ($i = 0; $i < 1; $i++)
                         <div id="grid-container">
                            
                                <div class="ech-tr outgoing" id="tr_{{$i}}">
                    
                                    <div class="echtr-inn">
                                        <div class="row">
                                            <div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">
                                                <div class="ech-td">
                                                    <span class="btn opentr-btn"></span>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Account
                                                    <span id="accountlist_{{$i}}" class="product-name"></span>
                                                    </label>
                                                    <div class="td-value">
                                                    <select id="accountlist_{{$i}}"    name="accountlist[]" class="accountlist_{{$i}} accountlist accountlist_val form-control select2" data-row="{{$i}}">
                                                       
                                            </select>
                                             <input type="hidden" id="accountname_{{$i}}" name="accountname[]" class="accountname_{{$i}} form-control">
                                            <!--  -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">Account Code</label>
                                                    <div class="td-value">
                                                    <input  type="number"  step="0.01"  id="acc_code_{{$i}}"  class="acc_code_{{$i}} form-control" name="acc_code[]">
                                                
                                                    </div>
                                                </div>
                                            </div> 
                                                                        
                                            
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                <div class="ech-td">
                                                    <label class="td-label">Description</label>
                                                    <div class="td-value">
                                                    <!-- <span class="unitprice_{{$i}}"></span> -->
                                                    <input type="text" id="desc_{{$i}}"  class="desc_{{$i}} form-control"  name="desc[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">
                                                    <div class="ech-td">
                                                        <label class="td-label">Sum Applied</label>
                                                        <div class="td-value">
                                                            <input type="number"  step="0.01"  id="sum_applied_{{$i}}"  class="sum_applied_{{$i}} sum_applied form-control"  onChange="calculateTotal();" name="sum_applied[]" >
                                                        </div>
                                                    
                                                    </div>
                                            </div>
                                            
                                            <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                                                <div class="ech-td">
                                                    <label class="td-label">Cost Centre1</label>
                                                    <div class="td-value">
                                                    <!-- <span class="linetotal linetotal_{{$i}}"></span> -->
                                                    <input type="text" id="cost_centre1_{{$i}}"  class=" cost_centre1_{{$i}} form-control" name="cost_centre1[]" >
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
                    @endfor
            </div>


            <table id="invtable" style="border: 1px solid #ddd;padding: 8px;text-align: left; 
            margin-top:-22px;" >
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Inv No</th>
                                    <th>Doc Date</th>
                                    <th>Doc Total</th>
                                    <th>Sum Applied</th>
                                    <!-- <th>Cost Centre 1</th> -->
                                </tr>
                            </thead>
                            <tbody id="invoiceTableBody">
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" ></td>
                                    <td><span id="invno"></span></td>
                                    <td><span id="doc_date"></span></td>
                                    <td><span id="doc_total"></span></td>
                                    <td><input type="number"  step="0.01"  class="form-control" name="sum_appied" id="sum_appied"></td>
                                    
                                </tr>
                         </tbody>
              </table>


                                  
 </div>

<div id="London" class="tabcontent">
<!-- New mrudul -->

     <div class="container">
        <div class="row mb-3 m-style new">
            <div class="col-lg-3 col-sm-6">
                    <h5>Cash</h5>
                    <div class="">
                    <label for="referral" class="form-label">Cash Account </label>
                    <select  id="cash_acc" name="cash_acc" class="form-control select accountlist_payment">
                    <!-- <option value="Terminal Cash Account">Terminal Cash Account</option>
                    <option value="Water & Food Expenses">Water & Food Expenses </option>
                    <option value="Vehicle Fuel">Vehicle Fuel</option>
                    <option value="Stationary & Office Expense">Stationary & Office Expense</option>
                    <option value="Cash Remittance to Control Account">Cash Remittance to Control Account</option>
                    <option value="KNET">KNET</option>
                    <option value="TAP Link">TAP Link</option> -->
                    </select>
                    </div>

                    <div class="mt-2 mb-3">
                    <label for="referral" class="form-label">Cash Sum </label>
                    <input  type="number"  step="0.01"  id="cash_sum"  class=" form-control"  name="cash_sum">
                    </div>

                    

                    
            </div>

            <div class="col-lg-3 col-sm-6">
                <h5>Cheque</h5>
                <div class="">
                <label for="referral" class="form-label">Cheque Account </label>
                <!-- <input  type="number"  step="0.01"  id="cheque_amount"  class=" form-control"  name="cheque_amount"> -->
                <select  id="cheque_acc" name="cheque_acc" class="form-control select accountlist" disabled>
                </select>
                </div>

                <div class="mt-2">
                <label for="referral" class="form-label">Cheque Sum </label>
                <input  type="number"  step="0.01"  id="cheque_sum"  class=" form-control"  name="cheque_sum" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Cheque No. </label>
                <input  type="number"  step="0.01"  id="cheque_no"  class=" form-control" name="cheque_no" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Cheque Date </label>
                <input  type="date" id="cheque_date"  class=" form-control"  name="cheque_date" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Cheque Bank </label>
                <input  type="number"  step="0.01"  id="cheque_bank"  class=" form-control"  name="cheque_bank" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Cheque Branch </label>
                <input  type="number"  step="0.01"  id="cheque_branch"  class=" form-control"  name="cheque_branch" disabled>
                </div>

            </div>

            <div class="col-lg-3 col-sm-6">
                <h5>Card</h5>
                <div class="">
                <label for="referral" class="form-label">Card Account </label>
                <!-- <input  type="number"  step="0.01"  id="card_acc" required class=" form-control"  name="card_acc"> -->
                <select  id="card_acc" name="card_acc" class="form-control select accountlist" disabled>
                </select>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Card Sum </label>
                <input  type="number"  step="0.01"  id="card_sum"  class=" form-control"  name="card_sum" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Card Type </label>
                <select class="form-control select" name="card_type" id="card_type" disabled>
                <option value="master">Master</option>
                <option value="visa">Visa</option>
                </select>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Card No </label>
                <input  type="number"  step="0.01"  id="card_no"  class=" form-control"  name="card_no" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Card Valid </label>
                <input  type="number"  step="0.01"  id="card_valid"  class=" form-control"  name="card_valid" disabled>
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">VoucherNo </label>
                <input  type="number"  step="0.01"  id="voucher_no"  class=" form-control"  name="voucher_no" disabled>
                </div>


            </div>

            <div class="col-lg-3 col-sm-6">
                <h5>Bank Transfer</h5>
                <div class="">
                <label for="referral" class="form-label">Transfer Account </label>
                <!-- <input  type="number"  step="0.01"  id="bank_tranfer" required class=" form-control"  name="bank_tranfer"> -->
                <select  id="bankt_acc" name="bankt_acc" class="form-control select accountlist" >
                </select>

                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Transfer Sum </label>
                <input  type="number"  step="0.01"  id="transfer_sum"  class=" form-control"  name="transfer_sum" >
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Transfer Date </label>
                <input  type="date" id="transfer_date"  class=" form-control"  name="transfer_date" >
                </div>
                <div class="mt-2">
                <label for="referral" class="form-label">Transfer Ref. </label>
                <input  type="text" id="transfer_ref"  class=" form-control"  name="transfer_ref" >
                </div>

            </div>

           


        </div>
    </div>

</div>

</div> 



<!-- New mrudul End-->

<div class="row mt-3">
    <div class="col-sm-5">
        <div class="form-group row">
            <label for="posting_date" class="col-sm-5 col-form-label">Sales Employee <span class="text-danger">*</span></label>
            <div class="col-sm-7">
            <!-- <select required name="partner3" class="agentSelect form-control select2">
            </select> -->
            <input type="text" id="partner3" name="partner3" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="referral" class="col-sm-5 col-form-label">Remarks</label>
            <div class="col-sm-7">
            <textarea placeholder="Remarks" type="text" name="remarks" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-4">
    <div class="form-group row">
                            <label for="referral" class="col-sm-6 col-form-label">Payment Type </label>
                            <div class="col-sm-6">
                                <select  id="cash_acc" name="cash_acc" class="form-control select ">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>
                    </div>

            <div class="mt-2" style="display: none;">
                <label for="referral" class="form-label">Total Payment</label>
                <input  type="text" id="totalpayment"  class=" form-control"  name="totalpayment" readonly>
            </div>
    <div class="form-group row">
            <label for="reffer" class="col-sm-6 col-form-label">Total</label>
            <div class="col-sm-6">
            <input type="text" name="doctotal"  id="doctotal" class="form-control" disabled>
            </div>
        </div>
    </div>
</div>
        
<div class="col-12 create-incomebtn">
<button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Save</button>
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
document.getElementById('account_type').addEventListener('change', function () 
{
        const selectedType = this.value;
        const invTable = document.getElementById('invtable');
        const acc = document.getElementById('grid-container');
        // alert(selectedType);
        if (selectedType === 'account') {
            invTable.style.display = 'none'; // Hide the table
            $(".bp_name").hide();
            $("#for_customer").hide();
            $(".ref_no").hide();
            $("#bill_to_address").val("");
            $("#add_label").html("Pay To");
            acc.style.display = 'block'; // Hide the table
        }
        else if (selectedType === 'advance') {
            invTable.style.display = 'none';
            acc.style.display = 'none';
            $(".bp_name").show();
            $("#for_customer").hide();
            $(".ref_no").show();
            $(".baddress").show();
            $("#add_label").html("Address");
        }
        else if (selectedType === 'supplier') {
            invTable.style.display = 'table'; // Show the table
            acc.style.display = 'none';
            $(".bp_name").show();
            $("#for_customer").hide();
            $(".ref_no").show();
            $(".baddress").show();
            $("#bill_to_address").val("");
            $("#add_label").html("Address");

        }
        else {
            // alert("hi");
            invTable.style.display = 'table'; // Show the table
            acc.style.display = 'none';
            $(".bp_name").hide();
            $("#for_customer").show();
            $(".ref_no").show();
            $(".baddress").show();
            $("#bill_to_address").val("");
            $("#add_label").html("Address");

        }
});
$(document).on('change', '.accountlist', function() {
    // Get the selected value (account ID or code) from the dropdown
    let selectedValue = $(this).val();

    // Get the row index from the data-row attribute
    let rowIndex = $(this).data('row');

    // AJAX call to fetch the account code based on the selected account
    $.ajax({
        url: 'outgoing-payment/get_account_code', // Laravel route to fetch account code
        type: 'GET',
        data: { account_id: selectedValue },
        success: function(response) {
            
            if (response.status === 'success') {
                console.log(response);
                // Populate the Account Code field in the same row
                $('#acc_code_' + rowIndex).val(response.account_code);
                $('#accountname_' + rowIndex).val(response.account_name);
            } else {
                alert('Failed to fetch account code.');
            }
        },
        error: function() {
            alert('An error occurred while fetching the account code.');
        }
    });
});





function calculateTotalPayment() 
{
        // Get the values of all the input fields
        const chequeSum = parseFloat(document.getElementById('cheque_sum').value) || 0;
        const cardSum = parseFloat(document.getElementById('card_sum').value) || 0;
        const transferSum = parseFloat(document.getElementById('transfer_sum').value) || 0;
        const cashSum = parseFloat(document.getElementById('cash_sum').value) || 0;

        // Calculate the total
        const totalPayment = chequeSum + cardSum + transferSum + cashSum;

        // Update the total payment input field
        document.getElementById('totalpayment').value = totalPayment.toFixed(2); // Ensure 2 decimal places
}

    // Attach event listeners to all input fields to trigger the calculation on input
    document.getElementById('cheque_sum').addEventListener('input', calculateTotalPayment);
    document.getElementById('card_sum').addEventListener('input', calculateTotalPayment);
    document.getElementById('transfer_sum').addEventListener('input', calculateTotalPayment);
    document.getElementById('cash_sum').addEventListener('input', calculateTotalPayment);



    const acc = document.getElementById('grid-container');
    acc.style.display = 'none';
    // Initially check the value and hide/show the table accordingly
    // document.getElementById('account_type').dispatchEvent(new Event('change'));
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "grid";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
    $(document).ready(function() {

        document.getElementById("for_customer").style.display = "none";
        $('#coupon_no').on('blur', function() {
            let couponCode = $(this).val();
            if (couponCode) {
                validateCodeforcoupon(couponCode, 'coupon', '#c_amount');
            }
        });

    // Handle voucher code validation
    $('#voucher_no').on('blur', function() {
        let voucherCode = $(this).val();
        if (voucherCode) {
            validateCode(voucherCode, 'voucher', '#v_amount');
        }
    });

    // AJAX function to validate codes
    function validateCodeforcoupon(code, type, amountField) {
        $.ajax({
            url: '{{ route("validate_coupon.code") }}',
            method: 'POST',
            data: {
                code: code,
                type: type,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $(amountField).val(response.amount);
                calculateTotalPayment();
                // Set the amount in the corresponding field
                // alert(`${type.charAt(0).toUpperCase() + type.slice(1)} code is valid.`);
            },
            error: function(xhr) {
                $(amountField).val(''); // Clear the amount field on error
                $('#coupon_no').val(''); // Clear the amount field on error
                $('#coupon_no').focus(); // Clear the amount field on error
                alert(xhr.responseJSON.message);
            }
        });
    }

    function validateCode(code, type, amountField) {
        $.ajax({
            url: '{{ route("validate_voucher.code") }}',
            method: 'POST',
            data: {
                code: code,
                type: type,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $(amountField).val(response.amount); // Set the amount in the corresponding field
                calculateTotalPayment();
                // alert(`${type.charAt(0).toUpperCase() + type.slice(1)} code is valid.`);
            },
            error: function(xhr) {
                $(amountField).val(''); // Clear the amount field on error
                $('#voucher_no').val(''); // Clear the amount field on error
                $('#voucher_no').focus(); // Clear the amount field on error
                alert(xhr.responseJSON.message);
            }
        });
    }


        var today = new Date();
        var formattedToday = today.toISOString().split('T')[0];
        
        // Set the date in the input field (YYYY-MM-DD format)
        $('#discount').val('0.00');
        $('#delivery_date').val(formattedToday);
        $('#DocuDate').val(formattedToday);
        $('#posting_date').val(formattedToday);
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
        // $('select[name=vehicle_type]').change(function(){
        //     if(this.value == 'N/A')
        //     {
        //         $('input[name=km]').attr('required', false);
        //         $('label[for=distance] span[class=text-danger]').html('');
        //     }
        //     else{
        //         $('input[name=km]').attr('required', true);
        //         $('label[for=distance] span[class=text-danger]').html('*');
        //     }
        // });

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
           data:{_token: "{{ csrf_token() }}",type:'outgoingpayment'},
           success:function(data){
              $('input[name=docNumber]').val(data);
           }
        });

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
            url: "{{ url('admin/ajax/outgoing-customers') }}",
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




        $(".cusSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/outgoing-cus') }}",
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
    var totalRows = $(".outgoing").length; // Count the current rows
    var val = totalRows; // Set the new row's index to the total number of rows

    var html = '<div class="ech-tr outgoing" id="tr_'+val+'">'
                             +'<div class="echtr-inn">'
                                +'<div class="row">'
                                    +'<div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">'
                                        +'<div class="ech-td">'
                                            +'<span class="btn opentr-btn"></span>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Account</label>'
                                            +'<div class="td-value">'
                                            +'<select id="accountlist_'+val+'" onChange="load_warehouse('+val+')" data-row="'+val+'"   name="accountlist[]" class="accountlist_'+val+' accountlist  accountlist_val form-control select2"></select><input type="hidden" id="accountname_'+val+'" name="accountname[]" class="accountname_'+val+' form-control"></div></div></div>'
                                     
                                    +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Account Code</label>'
                                            +'<div class="td-value"><input  type="number"  step="0.01"  id="acc_code_'+val+'"  class="acc_code_'+val+' form-control"  name="acc_code[]"></div></div></div>' 
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Description</label>'
                                            +'<div class="td-value"><input type="text" id="desc_'+val+'"  class="desc_'+val+' form-control"  name="desc[]"></div></div></div>' 
                                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                            +'<div class="ech-td">'
                                                +'<label class="td-label">Sum Applied</label>'
                                                +'<div class="td-value"><input type="number"  step="0.01"  id="sum_applied_'+val+'"  class="sum_applied_'+val+' form-control sum_applied"  onChange="calculateTotal();" name="sum_applied[]" ></div></div></div>'
                                   

                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Cost Centre1</label>'
                                            +'<div class="td-value"><input type="text" id="cost_centre1_'+val+'"  class="cost_centre1 cost_centre1_'+val+' form-control" name="cost_centre1[]" ></div></div></div>'
                                  

                                    
                                            +'</div>'
                                            +'</div>'                
                                            +'<div class="actn-td">'
                                            +'<a href="javascript:void(0);" class="action-icon add-item"></a>'
                                            +'<a href="javascript:void(0);" class="action-icon delete-item"></a>'
                                            +'</div>'
                                            +'</div>';

    // Insert the new row after the clicked row
    $(this).closest(".outgoing").after(html);

    // Initialize any additional functionality like product loading
    load_product();
});




    $(document).on("click", ".delete-item", function() {
    var $row = $(this).closest('.outgoing');

    if ($('div .outgoing').length == 1) {
        var val = parseInt($("#count").val()) + 1;
        $("#count").val(val);
        $(".add-item").click(); // Add new row when deleting the last one
    }

    $row.remove(); // Remove the row
    calculateTotal(); // Recalculate after removing a row
    });

    function load_product()
    {       
        $(".accountlist").select2({
            ajax: {
            url: "{{ url('admin/ajax/accountlist') }}",
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
                            text: item.AcctName,
                            id: item.AcctCode
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

        $(".accountlist_payment").select2({
            ajax: {
            url: "{{ url('admin/ajax/accountlist_payment') }}",
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
                            text: item.AcctName,
                            id: item.AcctCode
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
    var avqty = '#av_quantity_' + r;
    var unitprice_id = '#unitprice_' + r;

    var warehouse_id = '.whscode-select'; // The warehouse select element
    var productCode = $(product_id + ' option:selected').val(); // Get the selected product code
    
    if (!productCode) {
        console.error("No product code selected");
        return;
    }

    $.ajax({
            url: "{{ url('admin/stockout/branch_product_stock') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                productCode: productCode,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $(avqty).val(data.OnHand);
                if(data.price_list.price != '0')
                {
                    $(unitprice_id).val(data.price_list.price);

                }
                else
                {
                    $(unitprice_id).val(data.price_list.price);
                }
               
            }
        });

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
    
    var av_quantity_id = '.av_quantity_' + r;
    var quantity_id = '.quantity_' + r;
    var unitprice_id = '.unitprice_' + r;
    var linetotal_id = '.linetotal_' + r;
    var discprice_id = '.discprice_' + r;

    var av_quantity = parseFloat($(av_quantity_id).val()) || 0;
    console.log("available quantity: " + av_quantity); // Check if this logs correctly

    var quantity = parseFloat($(quantity_id).val()) || 0;
    var unitPrice = parseFloat($(unitprice_id).val()) || 0;
    var productName = $("#product_" + r + " option:selected").text();

    if (av_quantity !== 0) {

        if (av_quantity < parseInt(quantity)) {
            alert("The entered quantity for " + productName + " exceeds the available quantity (" + av_quantity + ").");
            // Optionally, reset the quantity to the available quantity
            $("#quantity_" + r).val(av_quantity);

            // return; // Use return to stop the function
        }
    }

    var line_total = quantity * unitPrice;

    // Update the line total in the current row
    $(linetotal_id).val(line_total.toFixed(2));
    $(discprice_id).val(unitPrice.toFixed(2));

    // Recalculate the grand total
    calculate_footer();
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

    $("#outgoing-payment-submit").submit(function(e){
    e.preventDefault(); // Prevent the default form submission
    var form = $(this);
    var url = form.attr('action');
    var account_type = $('#account_type').val();
    var customer = $('#customer').val();
    if(customer == null)
    {
        alert('Please select the customer');
        return false
    }
    if(account_type!='account')
    {
    if ($('.row-checkbox:checked').length === 0) {
            alert('Please check at least one checkbox.');
            $('.row-checkbox').first().focus(); // Attempt to set focus (for accessibility)
            $('.row-checkbox').css('outline', '2px solid red'); // Highlight the checkboxes visually
            event.preventDefault(); // Prevent form submission
            return false
        }

        $('.row-checkbox').on('change', function () {
            $('.row-checkbox').css('outline', 'none');
        });

    }
    else
    {
        let isValid = true;

        $('.accountlist_val').each(function () {
            if (!$(this).val()) {
                $(this).attr('required', true); // Use .attr() to set the required attribute
                isValid = false; // Mark form as invalid
                $(this).focus(); // Focus on the first invalid select
                return false; // Break out of the loop
            }
        });

        $('.sum_applied').each(function () {
            if (!$(this).val()) {
                $(this).attr('required', true); // Add required attribute
                isValid = false; // Mark form as invalid
                $(this).focus(); // Focus on the first invalid field
                return false; // Exit the loop
            }
        });

        if (!isValid) {
            alert('Please fill out all required fields.');
            event.preventDefault(); // Prevent form submission
            return false;
        }
    }
        
        var doctotal = $('#doctotal').val();
        var totalpayment = $('#totalpayment').val();

        if(doctotal > 0)
        {
            if(totalpayment != doctotal)
            {
                alert('Fill the payment details section correctly / Total payment amount is incorrect. Please check!!');
                event.preventDefault();
                return false;
                $('#cash_sum').focus();
            }

        }

    // Create a temporary form data object to store only the rows with valid background color
    var filteredData = new FormData();

    // Iterate through each row with class '.ech-tr'


    //const filteredData = new FormData();

    // Retrieve CSRF token from the input field
    const csrfToken = $('input[name="_token"]').val();

// Collect all form values first (even from unchecked rows)
// Collect data from the checked rows only
form.find('input, select, textarea').each(function () {
    const $row = $(this).closest('tr');
    const $checkbox = $row.find('.row-checkbox');

    // Only append values from rows that have the checkbox checked
    if ($checkbox.is(':checked')) {
        filteredData.append($(this).attr('name'), $(this).val());
    }
});

// Collect all other form data (excluding rows with unchecked checkboxes)
form.find('input, select, textarea').not('.row-checkbox').each(function () {
    const $row = $(this).closest('tr');
    const $checkbox = $row.find('.row-checkbox');

    // Skip unchecked rows and only append data from unchecked rows
    if (!$checkbox.is(':checked')) {
        filteredData.append($(this).attr('name'), $(this).val());
    }
});

// Append CSRF token to FormData
filteredData.append('_token', csrfToken);

// Send the data using AJAX
$.ajax({
    url: url,
    type: 'POST',
    data: filteredData,
    processData: false,
    contentType: false,
    success: function (data) {
        if (data.success) {
            sessionStorage.setItem('successMessage', data.message);
            // window.location.href = 'outgoing-payment/' + data.outgoingpayment_id;
            window.location.href = 'outgoing-payment';
        }
    },
    error: function (xhr, status, error) {
        console.error('Error:', error);
    }
});


});


    $(document).on("click",".opentr-btn",function(){

        if($(this).closest('.outgoing').hasClass('open-tr'))
        {         
            $(this).closest('.outgoing').removeClass('open-tr');
        }
        else{
            $(this).closest('.outgoing').addClass('open-tr');
        }           
    });

//customer onchange function done by reshma

$('#customer').change(function() {
    console.log("Dropdown changed");
    var selectedValue = $(this).val();
    $("#totalpayment").val("");
    $("#doctotal").val("");
    if (selectedValue) {
        $.ajax({
            url: "{{ url('admin/outgoing/ajax/customer_details') }}",
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
                        bill_to.append($('<option>', {
                            value: item.addressIDBilling,
                            text: item.addressIDBilling
                        }));
                        ship_to.append($('<option>', {
                            value: item.addressID,
                            text: item.addressID
                        }));

                        // Populate textarea with billing address
                        $('#bill_to_address').val(item.addressBilling + "\n" + item.zip_codeBilling);

                        // Update shipping address as text (assuming #ship_to_address is a div)
                        $('#ship_to_address').val(item.address + "\n" + item.zip_code);
                        $('#loyalty_point').val(item.loyalty_point);
                        calculateTotalPayment();
                        $('#loyalty_point').attr('max', item.loyalty_point);

                        place_of_sply.append($('<option>', {
                            value: item.state,
                            text: item.state
                        }));

                    } else {
                        console.log("Incomplete data for item:", item);
                        $('#result').html('Error: Data is incomplete.');
                    }
                    var purchaseinvoices = response.purchaseinvoice;
                    // console.log(purchaseinvoices);
                    if (purchaseinvoices.length > 0) {
                        let tableRows = "";
                        let i=-1;
                        purchaseinvoices.forEach((invoice) => {
                            i=i+1;
                            var sum_appliedamount = (invoice.total - invoice.applied_amount).toFixed(2);
                            tableRows += `
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox" name="rows[${i}][checked]" value="1" data-total="${sum_appliedamount}">
                                    </td>
                                    <td>
                                       ${invoice.doc_num}
                                        <input type="hidden" name="rows[${i}][doc_num]" value="${invoice.doc_num}">
                                    </td>
                                    <td>
                                        ${invoice.doc_date}
                                        <input type="hidden" name="rows[${i}][doc_date]" value="${invoice.doc_date}">
                                    </td>
                                    <td>
                                        ${invoice.total}
                                        <input type="hidden" name="rows[${i}][total]" id="doc_total_${i}" value="${invoice.total}">
                                    </td>
                                    <td>
                                        <input type="number"  step="0.01"  name="rows[${i}][sum_applied]" value="${sum_appliedamount}" class="form-control sum_applied">
                                        <input type="hidden"  step="0.01"  name="rows[${i}][org_sum_applied]" value="${sum_appliedamount}" class="form-control org_sum_applied">
                                    </td>
                                   
                                </tr>
                            `;
                        });

                        // Append the rows to your table body
                        $("#invoiceTableBody").html(tableRows);
                    } else {
                        console.error("No data available in purchaseinvoices array.");
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

$(document).on('input', '.sum_applied', function () {
    let $input = $(this);
    
    // Find the index from the input name like rows[2][sum_applied]
    let inputName = $input.attr('name');
    let indexMatch = inputName.match(/rows\[(\d+)\]\[sum_applied\]/);

    if (indexMatch) {
        let index = indexMatch[1];

        // Find the matching hidden input using the same index
        let originalSelector = `input[name="rows[${index}][org_sum_applied]"]`;
        let originalVal = parseFloat($(originalSelector).val()) || 0;
        let currentVal = parseFloat($input.val()) || 0;

        if (currentVal > originalVal) {
            alert('Sum Applied cannot be greater than Entered Sum Applied!');
            $input.val(originalVal.toFixed(2)); // Reset to original value
        }
    }
});

$('#cust').change(function() {
    console.log("Dropdown changed");
    var selectedValue = $(this).val();
    $("#totalpayment").val("");
    $("#doctotal").val("");
    if (selectedValue) {
        $.ajax({
            url: "{{ url('admin/outgoing/ajax/cust_details') }}",
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
                        bill_to.append($('<option>', {
                            value: item.addressIDBilling,
                            text: item.addressIDBilling
                        }));
                        ship_to.append($('<option>', {
                            value: item.addressID,
                            text: item.addressID
                        }));

                        // Populate textarea with billing address
                        $('#bill_to_address').val(item.addressBilling + "\n" + item.zip_codeBilling);

                        // Update shipping address as text (assuming #ship_to_address is a div)
                        $('#ship_to_address').val(item.address + "\n" + item.zip_code);
                        $('#loyalty_point').val(item.loyalty_point);
                        calculateTotalPayment();
                        $('#loyalty_point').attr('max', item.loyalty_point);

                        place_of_sply.append($('<option>', {
                            value: item.state,
                            text: item.state
                        }));

                    } else {
                        console.log("Incomplete data for item:", item);
                        $('#result').html('Error: Data is incomplete.');
                    }
                    var purchaseinvoices = response.purchaseinvoice;
                    // console.log(purchaseinvoices);
                    if (purchaseinvoices.length > 0) {
                        let tableRows = "";
                        let i=-1;
                        purchaseinvoices.forEach((invoice) => {
                            i=i+1;
                            var sum_appliedamount = (invoice.total - invoice.applied_amount).toFixed(2);
                            tableRows += `
                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox" name="rows[${i}][checked]" value="1" data-total="${sum_appliedamount}">
                                    </td>
                                    <td>
                                       ${invoice.doc_num}
                                        <input type="hidden" name="rows[${i}][doc_num]" value="${invoice.doc_num}">
                                    </td>
                                    <td>
                                        ${invoice.doc_date}
                                        <input type="hidden" name="rows[${i}][doc_date]" value="${invoice.doc_date}">
                                    </td>
                                    <td>
                                        ${invoice.total}
                                        <input type="hidden" name="rows[${i}][total]" id="doc_total_${i}" value="${invoice.total}">
                                    </td>
                                    <td>
                                        <input type="number"  step="0.01"  name="rows[${i}][sum_applied]" value="${sum_appliedamount}">
                                    </td>
                                    <td>
                                        <input type="text" name="rows[${i}][cost_centre]">
                                    </td>
                                </tr>
                            `;
                        });

                        // Append the rows to your table body
                        $("#invoiceTableBody").html(tableRows);
                    } else {
                        console.error("No data available in purchaseinvoices array.");
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

function calculateCheckedTotal() {
    let totalSumApplied = 0;

    $('.row-checkbox:checked').each(function () {
        const parentRow = $(this).closest('tr');

        const sumAppliedValue = parseFloat(
            parentRow.find('input[name$="[sum_applied]"]').val()
        ) || 0;

        totalSumApplied += sumAppliedValue;
    });

    $("#doctotal").val(totalSumApplied.toFixed(2));
    $("#cash_sum").val(totalSumApplied.toFixed(2));
    $("#totalpayment").val(totalSumApplied.toFixed(2));
}


$(document).on("change", ".row-checkbox", function () {
    calculateCheckedTotal();
    
});

$(document).on('change', '#selectAll', function () {
    const isChecked = $(this).is(':checked');
    $('.row-checkbox').prop('checked', isChecked);
    calculateCheckedTotal(); // Recalculate after select all
});


    function calculateTotal() {
    let total = 0;

    // Loop through each sum_applied field and add their values
    $('input[name="sum_applied[]"]').each(function () {
        let value = parseFloat($(this).val()) || 0; // Default to 0 if empty or invalid
        total += value;
    });

    // alert(value);

    // Set the total in the doctotal field
    $('#doctotal').val(total.toFixed(2)); // Display total with 2 decimal places
    $('#cash_sum').val(total.toFixed(2)); // Display total with 2 decimal places
    $('#totalpayment').val(total.toFixed(2)); // Display total with 2 decimal places

    // document.getElementById('doctotal').value = total.toFixed(2);
}
function calculateTotalApplied() {
    let total = 0;

    // Iterate over all rows and add the value of checked rows
    document.querySelectorAll('input[name^="rows"][name$="[sum_applied]"]').forEach(input => {
        const row = input.closest('tr'); // Get the closest row of the input
        const checkbox = row.querySelector('input[type="checkbox"]'); // Find the checkbox in the same row

        if (checkbox && checkbox.checked) { // Check if the checkbox is checked
            const value = parseFloat(input.value) || 0; // Parse value as float, default to 0 if invalid
            total += value;
        }
    });

    // Update the total textbox
    document.getElementById('doctotal').value = total.toFixed(2);
    document.getElementById('totalpayment').value = total.toFixed(2);
}

// Event listener for dynamically added "sum_applied" inputs and checkboxes
document.addEventListener('input', (event) => {
    if (
        event.target.matches('input[name^="rows"][name$="[sum_applied]"]') || 
        event.target.matches('input[type="checkbox"]')
    ) {
        calculateTotalApplied();
    }
});

// Initial calculation in case of pre-filled values
document.addEventListener('DOMContentLoaded', calculateTotalApplied);

        // copy from quotation section
        $("#copy_from_qutn").click(function(e) {
            var selectedValue = $('#customer').val();

            if (selectedValue == null) {
                alert("Please select the customer");
                return; // Exit the function if no customer is selected
            }

            e.preventDefault(); // Prevent default anchor behavior

            $.ajax({
                url: "{{ url('admin/ajax/customer_open_quotations') }}",
                type: 'GET',
                data: { customer_code: selectedValue },
                dataType: "json", // Data type expected from server
                success: function(data) { // Change 'quotation' to 'data' here
                    console.log(data);
                    $('#open_quotation').show();
                    $('#open_qutn').attr('required', true);
                    // Clear previous options before appending new ones
                    $('#open_qutn').empty().append('<option value="">Select a Quotation</option>');

                    // Check if data is not empty
                    if (data.length > 0) {
                        $.each(data, function(index, quotation) {
                            $('#open_qutn').append(
                                $('<option></option>').val(quotation.id).text(quotation.DocNo)
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




function updateLineTotal(row) {
    var qty = parseFloat(row.find('.qty-input').val()) || 0;
    var unitPrice = parseFloat(row.find('.unitprice-input').val()) || 0;
    var lineTotal = (qty * unitPrice).toFixed(2);

    // Update the line total
    row.find('.linetotal').text(lineTotal);
}








</script>
@endsection
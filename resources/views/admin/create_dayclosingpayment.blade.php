@extends('layouts.vertical', ["page_title"=> "Day End Closing Create"])

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
font-size:16px;
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
            border-bottom: 4px solid #007bff; 
            background-color: #f4f4f4;
        }
        .checkbox-cell {
            width: 5%;
        }

#invoiceTableBody td{
    text-align: left;
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
                            <a href="{{url('admin/dayend-closing-create')}}">Day End Closing</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Day End Closing</h4>
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
                <form id="dayend-closing-submit" method="post" class="parsley-examples" action="{{url('admin/dayend-closing/insert')}}">
                    {{csrf_field()}}
                    <div class="container body-style">
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
                                            <input  type="text" id="opening_balance"  class=" form-control"  name="opening_balance" value="{{$opening_blnc->OpeningBalance}}" readonly >
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Counter Balance
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="counter_balance"  class=" form-control"  name="counter_balance" required>
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
                                            <input type="date" id="closing_date" class="form-control" name="closing_date" value="{{ now()->format('Y-m-d') }}">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Cash Total
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="cash_total"  class=" form-control"  name="cash_total" readonly value="{{ $totalcash->total_cash ?? 0 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Petty Cash
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="petty_cash"  class=" form-control" name="petty_cash" readonly value="{{ $pettycash->total_cash ?? 0 }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Card Total
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="card_total"  class=" form-control"  name="card_total" readonly value="{{$totalSums->total_card ?? 0}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Cheque Total
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="cheque_total"  class=" form-control"  name="cheque_total" readonly value="{{$totalSums->total_cheque ?? 0}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Bank Transfer
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="bank_transfer"  class=" form-control"  name="bank_transfer" readonly value="{{$totalSums->total_transfer ?? 0}}">
                                            </div>
                                        </div>
                                        <?php
                                            $totalpayment= $totalSums->total_transfer ?? 0 + $totalSums->total_cheque ?? 0 + $totalSums->total_card ?? 0 + $totalcash->total_cash ?? 0 + $pettycash->total_cash ?? 0;
                                        ?>
                                        <div class="form-group row mt-2" id="for_supplier">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Total Payment
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="total_payment"  class=" form-control"  name="total_payment" readonly value="{{ $totalpayment }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3 pb-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Total Sales
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="text" id="total_sales"  class=" form-control"  name="total_sales" value="{{$total_sale->totalsale ?? 0}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Total Returns
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="total_returns"  class=" form-control"  name="total_returns" value="{{$total_sales_return->totalsalereturn ?? 0}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Net Sales 
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="text" id="net_sales"  class=" form-control"  name="net_sales" value="{{$total_sale->totalsale ?? 0 - $total_sales_return->totalsalereturn ?? 0 }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Net Cash
                                            </label>
                                            <div class="col-sm-7">
                                            <input  type="number" id="net_cash"  class=" form-control"  name="net_cash" value="{{$totalcash->total_cash ?? 0 - $totalpayment }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $totalpayment= $totalSums->total_transfer ?? 0 + $totalSums->total_cheque ?? 0 + $totalSums->total_card ?? 0 + $totalcash->total_cash ?? 0 + $pettycash->total_cash ?? 0;
                                    ?>
                                    <div class="col-lg-4" id="for_supplier">
                                        <div class="form-group row">
                                            <label for="referral" class="col-sm-5 col-form-label">
                                            Transfer To Safe   <span class="text-danger">*</span>
                                            </label> 
                                            <div class="col-sm-7">
                                            <input  type="number" id="transfer_to_safe"  class=" form-control"  name="transfer_to_safe" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-12 mt-1" style="margin-bottom: 3.5%;">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div> 
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

$(document).on('change', '.accountlist', function() {
    // Get the selected value (account ID or code) from the dropdown
    let selectedValue = $(this).val();

    // Get the row index from the data-row attribute
    let rowIndex = $(this).data('row');

    // AJAX call to fetch the account code based on the selected account
    $.ajax({
        url: 'dayend-closing/get_account_code', // Laravel route to fetch account code
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



// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
    $(document).ready(function() {
        let selectedDate = $('#closing_date').val(); // Get the pre-selected date on page load

        if (selectedDate) {
            fetchData(selectedDate); // Call the function to fetch and populate data
        }

        function fetchData(selectedDate) {
            $.ajax({
                url: "{{ url('admin/dayend-closing-create') }}",
                method: 'get',
                data: { date: selectedDate },
                beforeSend: function () {
                    $('#result').html('Loading...');
                },
                success: function (response) {
                   // console.log(response);
                    // Update fields with the data
                    $('#cash_total').val(response.total_cash);
                    $('#petty_cash').val(response.petty_cash);
                    $('#card_total').val(response.total_card);
                    $('#cheque_total').val(response.total_cheque);
                    $('#bank_transfer').val(response.total_transfer);
                    $('#total_sales').val(response.total_sales);
                    $('#total_returns').val(response.total_sales_return);
                    $('#opening_balance').val(response.opening_balance);
                    $('#total_payment').val(parseFloat(response.total_payment).toFixed(2));
                    $('#net_sales').val(parseFloat(response.net_sales).toFixed(2));
                    $('#net_cash').val(parseFloat(response.net_cash).toFixed(2));
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    $('#result').html('<p>An error occurred. Please try again.</p>');
                }
            });
        }

        $('#closing_date').on('change', function () {
            let selectedDate = $(this).val();

            if (selectedDate) {
                fetchData(selectedDate); // Call the same function
            }
        });

        
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
           data:{_token: "{{ csrf_token() }}",type:'incomingpayment'},
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



    });
    
    $(document).on("click", ".add-item", function() {
    // Find the total number of existing rows
    var totalRows = $(".ech-tr").length; // Count the current rows
    var val = totalRows; // Set the new row's index to the total number of rows

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
                                            +'<label class="td-label">Account</label>'
                                            +'<div class="td-value">'
                                            +'<select id="accountlist_'+val+'" onChange="load_warehouse('+val+')" data-row="'+val+'"   name="accountlist[]" class="accountlist_'+val+' accountlist  form-control select2"></select><input type="hidden" id="accountname_'+val+'" name="accountname[]" class="accountname_'+val+' form-control"></div></div></div>'
                                     
                                    +'<div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Account Code</label>'
                                            +'<div class="td-value"><input  type="text" id="acc_code_'+val+'"  class="acc_code_'+val+' form-control"  name="acc_code[]"></div></div></div>' 
                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Description</label>'
                                            +'<div class="td-value"><input type="text" id="desc_'+val+'"  class="desc_'+val+' form-control"  name="desc[]"></div></div></div>' 
                                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                                            +'<div class="ech-td">'
                                                +'<label class="td-label">Sum Applied</label>'
                                                +'<div class="td-value"><input type="text" id="sum_applied_'+val+'"  class="sum_applied_'+val+' form-control"  onkeyup="calculateTotal();" name="sum_applied[]"></div></div></div>'
                                   

                                    +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                                        +'<div class="ech-td">'
                                            +'<label class="td-label">Cost Centre1</label>'
                                            +'<div class="td-value"><input type="text" id="cost_centre_'+val+'"  class="cost_centre cost_centre_'+val+' form-control" name="cost_centre[]" ></div></div></div>'
                                  

                                    
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
                var $row = $(this);

                // Get the background color of the row
                var bgColor = $row.css('background-color');

                // Only include rows that do not have the 'removed' background color
                if (bgColor !== 'rgb(242, 222, 222)') 
                {
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
                }
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

    $("#dayend-closing-submit").submit(function(e){
    e.preventDefault(); // Prevent the default form submission
    var form = $(this);
    var url = form.attr('action');

    // Create a temporary form data object to store only the rows with valid background color
    var filteredData = new FormData();

    // Iterate through each row with class '.ech-tr'
    $('.ech-tr').each(function() {
        var bgColor = $(this).css('background-color');
        
        // If the background color is not 'rgb(242, 222, 222)', include this row's data
        if (bgColor !== 'rgb(242, 222, 222)') {
            // Add each input within this row to the filtered data
            $(this).find('input, select, textarea').each(function() {
                filteredData.append($(this).attr('name'), $(this).val());
            });
        }
    });

    // Also, append any other necessary form fields (outside the rows if needed)
    form.find('input, select, textarea').not('.ech-tr input, .ech-tr select, .ech-tr textarea').each(function() {
        filteredData.append($(this).attr('name'), $(this).val());
    });

    // Send the filtered data using AJAX
    $.ajax({
        url: url,
        type: 'POST',
        data: filteredData,
        processData: false, // Important: Don't process the data into a query string
        contentType: false, // Important: Let jQuery set the content type
        success: function(data) {
            // Handle success (redirect, display a message, etc.)
            // console.log('Success:', data);
            if (data.success) {
                sessionStorage.setItem('successMessage', data.message);
                // window.location.href = 'dayend-closing/' + data.dayclosing;
                window.location.href = 'dayend-closing';
            }
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log('Error:', error);
        }
    });
});


    $(document).on("click",".opentr-btn",function(){

        if($(this).closest('.ech-tr').hasClass('open-tr'))
        {         
            $(this).closest('.ech-tr').removeClass('open-tr');
        }
        else{
            $(this).closest('.ech-tr').addClass('open-tr');
        }           
    });





</script>
@endsection
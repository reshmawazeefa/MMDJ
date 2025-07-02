@extends('layouts.vertical', ["page_title"=> "Customer | Edit"])

@section('content')
@php
    $name = explode('. ',$customer->addressID);
    if(count($name) > 1)
    {
        $prefix = $name[0].".";
        $addressID = $name[1];
    }
    else
    {
        $prefix = null;
        $addressID = $customer->addressID;
    }

    $nameBilling = explode('. ',$customer->addressIDBilling);
    if(count($nameBilling) > 1)
    {
        $prefixBilling = $nameBilling[0].".";
        $addressIDBilling = $nameBilling[1];
    }
    else
    {
        $prefixBilling = null;
        $addressIDBilling = $customer->addressIDBilling;
    }
@endphp
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/customers')}}">Customers </a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Customer Details </h4>
                @if(!empty($errors->all()))
                    <p class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      🔸 {{$error}} 
                    @endforeach
                    </p>
                    @endif
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
               
                    <!-- <h4 class="header-title">Customer  Form</h4> -->
                    
                    <form id="form" role="form" class="parsley-examples" method="post" action="{{url('admin/customers/'.$customer->id)}}">
                        {{csrf_field()}}
                        {{ method_field('PATCH') }}
                        <div class="card-body body-style">
                        <div class="row mb-3">
                            <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                            <div class="form-group row">
                            <div class="col-6">
                                <label for="webSite" class="col-form-label"><b>{{old('name') ? old('name'):$customer->name }}</b></label>
                            </div>
                        </div>
                                <div class="form-group row mt-2 pt-2" style="border-top: 1px dashed #ebebeb;">
                                    <label for="inputEmail3" class="col-6 col-form-label">Name : </label> {{old('name') ? old('name'):$customer->name }}
                                    <div class="col-7" style="display: none;">
                                        <input type="text" name="name" value="{{old('name') ? old('name'):$customer->name }}" required class="form-control" placeholder="Name" id="name" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hori-pass1" class="col-6 col-form-label">Customer  Code :</label> {{old('customer_code') ? old('customer_code'):$customer->customer_code }}
                                    <div class="col-7" style="display: none;">
                                        <input type="text" readonly name="customer_code" value="{{old('customer_code') ? old('customer_code'):$customer->customer_code }}" placeholder="Customer Code" required class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <label for="type" class="col-6 col-form-label">Type </label>
                                    <div class="col-7" style="display: none;">
                                        <select class="form-control" name="type" id="type" required>
                                            <option value="C" @if($customer->type == 'C') selected @endif>Customer</option>
                                            <option value="S" @if($customer->type == 'S') selected @endif>Supplier</option>
                                            
                                        </select>
                                    </div>
                                </div> 


                                <div class="form-group row">
                                    <label for="hori-pass2" class="col-6 col-form-label">Contact Number : </label>{{old('phone') ? old('phone'):$customer->phone }}
                                    <div class="col-7" style="display: none;">
                                        <input type="number" name="phone" min="10" value="{{old('phone') ? old('phone'):$customer->phone }}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="hori-pass2" class="col-6 col-form-label">Email :</label> {{old('email') ? old('email'):$customer->email}}
                                    <div class="col-7" style="display: none;">
                                        <input type="email" name="email" value="{{old('email') ? old('email'):$customer->email}}" placeholder="Email" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hori-pass2" class="col-6 col-form-label">Whatsapp Phone : </label>{{$customer->country_code ? '+'.$customer->country_code : ''}}  {{old('alt_phone')? old('alt_phone'):$customer->alt_phone}}
                                    <div class="col-7" style="display: none;">
                                        <input type="number" name="alt_phone" min="10" value="{{old('alt_phone')? old('alt_phone'):$customer->alt_phone}}" required placeholder="Whatsapp Contact Number" class="form-control" id="hori-pass2" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="webSite" class="col-6 col-form-label">Description :</label> {{old('description') ? old('description'):$customer->description }}
                                    <div class="col-7" style="display: none;">
                                        <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description') ? old('description'):$customer->description }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hori-pass2" class="col-6 col-form-label">GSTIN / VAT :</label> {{old('gstin') ? old('gstin'):$customer->gstin}}
                                    <div class="col-7" style="display: none;">
                                        <input type="text" name="gstin" value="{{old('gstin') ? old('gstin'):$customer->gstin}}" placeholder="GSTIN / VAT" class="form-control" id="hori-pass2" />
                                    </div>
                                </div>
                            </div>
                            
                        <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="webSite" class="col-form-label">↓ Billing Address ↓</label>
                            </div>
                        </div>
                        
                        <div class="form-group row mt-2 pt-2" style="border-top: 1px dashed #ebebeb;">
                            <label for="webSite" class="col-6 col-form-label">Address ID : </label> {{$prefixBilling}}
                            <div class="col-3" style="display: none;">
                                <select class="form-control" name="prefixBilling">
                                    <option @if($prefixBilling == 'Mr.') selected @endif>Mr.</option>
                                    <option @if($prefixBilling == 'Ms.') selected @endif>Ms.</option>
                                    <option @if($prefixBilling == 'Dr.') selected @endif>Dr.</option>
                                    <option @if($prefixBilling == 'Adv.') selected @endif>Adv.</option>
                                    <option @if($prefixBilling == 'M/S.') selected @endif>M/S.</option>
                                </select>
                            </div>
                            {{old('addressIDBilling')? old('addressIDBilling'):$addressIDBilling}}
                            <div class="col-4" style="display: none;">
                                <input type="text" required class="form-control" placeholder="Address ID" name="addressIDBilling" value="{{old('addressIDBilling')? old('addressIDBilling'):$addressIDBilling}}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Address 1 :</label> {{old('addressBilling')? old('addressBilling'):$customer->addressBilling}}
                            <div class="col-7" style="display: none;">
                                <input type="text" required class="form-control" placeholder="Address 1" name="addressBilling" value="{{old('addressBilling')? old('addressBilling'):$customer->addressBilling}}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Address 2 :</label> {{old('address2Billing')? old('address2Billing'):$customer->address2Billing}}
                            <div class="col-7" style="display: none;">
                                <input type="text" required class="form-control" placeholder="Address 2" name="address2Billing" value="{{old('address2Billing')? old('address2Billing'):$customer->address2Billing}}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">City : </label>{{old('placeBilling') ? old('placeBilling'):$customer->placeBilling}}
                            <div class="col-7" style="display: none;">
                            <input type="text" name="placeBilling" value="{{old('placeBilling') ? old('placeBilling'):$customer->placeBilling}}" placeholder="City" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Post code : </label>{{old('zip_codeBilling') ? old('zip_codeBilling'):$customer->zip_codeBilling}}
                            <div class="col-7" style="display: none;">
                            <input type="text" required name="zip_codeBilling" value="{{old('zip_codeBilling') ? old('zip_codeBilling'):$customer->zip_codeBilling}}" placeholder="Post code" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">State :</label>{{$customer->stateBilling}}
                            <div class="col-7" style="display: none;">
                            <!-- <input type="text" name="stateBilling" value="{{old('stateBilling') ? old('stateBilling'):$customer->stateBilling}}" placeholder="StateBilling" class="form-control" /> -->
                            <select id="stateBilling" name="stateBilling" class="form-control select2" required>
                                <option value="">Select a Region</option>
                                <option value="england" {{ (old('stateBilling') ? old('stateBilling') : $customer->stateBilling) == 'england' ? 'selected' : '' }}>England</option>
                                <option value="scotland" {{ (old('stateBilling') ? old('stateBilling') : $customer->stateBilling) == 'scotland' ? 'selected' : '' }}>Scotland</option>
                                <option value="wales" {{ (old('stateBilling') ? old('stateBilling') : $customer->stateBilling) == 'wales' ? 'selected' : '' }}>Wales</option>
                                <option value="northern_ireland" {{ (old('stateBilling') ? old('stateBilling') : $customer->stateBilling) == 'northern_ireland' ? 'selected' : '' }}>Northern Ireland</option>
                            </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Country : </label>{{old('countryBilling') ? old('countryBilling'):$customer->countryBilling}}
                            <div class="col-7" style="display: none;">
                            <input type="text" value="United Kingdom" name="countryBilling" value="{{old('countryBilling') ? old('countryBilling'):$customer->countryBilling}}" placeholder="Country" class="form-control" readonly />
                            </div>
                        </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="webSite" class="col-form-label">↓ Shipping Address ↓</label>
                            </div>
                        </div>
                        <div class="form-group row mt-2 pt-2" style="border-top: 1px dashed #ebebeb;">
                            <div class="col-7" style="display: none;"><input type="checkbox" name="sepBilling" id="sepBilling" @if($customer->same_checking=='on') {{'checked'}} @endif>
                                <label for="webSite" class="col-form-label"> Same as Billing Address</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Address ID :</label>{{$prefix}}
                            <div class="col-3" style="display: none;">
                            <select class="form-control" name="prefix" >
                            <option value="Mr." {{ $prefix == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                            <option value="Ms." {{ $prefix == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                            <option value="Dr." {{ $prefix == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                            <option value="Adv." {{ $prefix == 'Adv.' ? 'selected' : '' }}>Adv.</option>
                            <option value="M/S." {{ $prefix == 'M/S.' ? 'selected' : '' }}>M/S.</option>
                        </select>

                            </div>{{old('addressID')? old('addressID'):$addressID}}
                            <div class="col-4" style="display: none;">
                                <input type="text" required class="form-control" name="addressID" placeholder="Address ID" value="{{old('addressID')? old('addressID'):$addressID}}" {{ $customer->same_checking == 'on' ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Address 1 : </label>{{old('address')? old('address'):$customer->address}}
                            <div class="col-7" style="display: none;">
                                <input type="text" required class="form-control" placeholder="Address 1" name="address" value="{{old('address')? old('address'):$customer->address}}" {{ $customer->same_checking == 'on' ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Address 2 :</label>{{old('address2')? old('address2'):$customer->address2}}
                            <div class="col-7" style="display: none;">
                                <input type="text" required class="form-control" name="address2" placeholder="Address 2" value="{{old('address2')? old('address2'):$customer->address2}}" {{ $customer->same_checking == 'on' ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">City :</label>{{old('place') ? old('place'):$customer->place}}
                            <div class="col-7" style="display: none;">
                            <input type="text" name="place" value="{{old('place') ? old('place'):$customer->place}}" required placeholder="City" class="form-control" {{ $customer->same_checking == 'on' ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Post code :</label>{{old('zip_code') ? old('zip_code'):$customer->zip_code}}
                            <div class="col-7" style="display: none;">
                            <input type="text" required name="zip_code" value="{{old('zip_code') ? old('zip_code'):$customer->zip_code}}" placeholder="Post code" class="form-control" {{ $customer->same_checking == 'on' ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">State :</label>{{ $customer->state }}
                            <div class="col-7" style="display: none;">
                            <!-- <input type="text" name="state" value="{{old('state') ? old('state'):$customer->state}}" required placeholder="State" class="form-control" /> -->

                           <select id="state" name="state" class="state form-control select2" required >
                                <option value="">Select a Region</option>
                                <option value="england" {{ (old('state') ? old('state') : $customer->state) == 'england' ? 'selected' : '' }}>England</option>
                                <option value="scotland" {{ (old('state') ? old('state') : $customer->state) == 'scotland' ? 'selected' : '' }}>Scotland</option>
                                <option value="wales" {{ (old('state') ? old('state') : $customer->state) == 'wales' ? 'selected' : '' }}>Wales</option>
                                <option value="northern_ireland" {{ (old('state') ? old('state') : $customer->state) == 'northern_ireland' ? 'selected' : '' }}>Northern Ireland</option>
                            </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="webSite" class="col-6 col-form-label">Country :</label>{{old('country') ? old('country'):$customer->country}}
                            <div class="col-7" style="display: none;">
                            <input type="text" value="United Kingdom" name="country" value="{{old('country') ? old('country'):$customer->country}}" required placeholder="Country" class="form-control" readonly/>
                            </div>
                        </div>

                        </div>
                             <div class="form-group row mt-2 newbutton">
                                <div class="d-flex justify-content-end gap-1 mb-3">
                                    <!-- <button id="myform" type="submit" class="btn btn-primary waves-effect waves-light">Update</button> -->
                                    <a href="{{url('admin/customers')}}"><button type="button" class="btn btn-secondary waves-effect">Back</button></a>
                                </div>
                            </div>
                    
                        </div>
                        </div>
                        
                        
                       

                        <!-- <div class="col-12 mt-1" style="margin-bottom: 3.5%;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Save</button>
                        </div> -->
                    </form>
                
            </div> <!-- end card -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<!-- end demo js-->
<script>
    $(document).ready(function() {
        $('#sepBilling').on('change', function() {
        if ($(this).is(':checked')) {
            syncBillingToShipping();
            enableReadonly(true);
        } else {
            clearShippingFields();
            enableReadonly(false);
        }
    });

    // On any change in billing fields, update the shipping fields if checkbox is checked
    $('select[name=prefixBilling], input[name=addressIDBilling], input[name=addressBilling], input[name=address2Billing], input[name=placeBilling], input[name=zip_codeBilling], select[name=stateBilling], input[name=countryBilling]').on('input change', function() {
        if ($('#sepBilling').is(':checked')) {
            syncBillingToShipping();
        }
    });

    // Function to sync billing to shipping
    // Function to sync billing to shipping
// Function to sync billing to shipping
function syncBillingToShipping() {
    var prefixVal = $('select[name=prefixBilling]').find('option:selected').val();
    var stateVal = $('select[name=stateBilling]').find('option:selected').val();

    $('select[name=prefix]').val(prefixVal).addClass('readonly').trigger('change');
    $('input[name=addressID]').val($('input[name=addressIDBilling]').val()).prop('readonly', true);
    $('input[name=address]').val($('input[name=addressBilling]').val()).prop('readonly', true);
    $('input[name=address2]').val($('input[name=address2Billing]').val()).prop('readonly', true);
    $('input[name=place]').val($('input[name=placeBilling]').val()).prop('readonly', true);
    $('input[name=zip_code]').val($('input[name=zip_codeBilling]').val()).prop('readonly', true);
    $('select[name=state]').val(stateVal).addClass('readonly').trigger('change');
    $('input[name=country]').val($('input[name=countryBilling]').val()).prop('readonly', true);
}


    // Function to clear shipping fields
    function clearShippingFields() {
        $('select[name=prefix]').removeClass('readonly');
        $('input[name=addressID]').val('').prop('readonly', false);
        $('input[name=address]').val('').prop('readonly', false);
        $('input[name=address2]').val('').prop('readonly', false);
        $('input[name=place]').val('').prop('readonly', false);
        $('input[name=zip_code]').val('').prop('readonly', false);
        $('select[name=state]').removeClass('readonly').val('');
        //$('input[name=country]').val('').prop('readonly', false);
    }

    // Function to toggle readonly state
    function enableReadonly(enable) {
        //$('select[name=prefix]').prop('disabled', enable);
        // $('select[name=state]').prop('disabled', enable);
        $('input[name=addressID]').prop('readonly', enable);
        $('input[name=address]').prop('readonly', enable);
        $('input[name=address2]').prop('readonly', enable);
        $('input[name=place]').prop('readonly', enable);
        $('input[name=zip_code]').prop('readonly', enable);
        //$('input[name=country]').prop('readonly', enable);
    }


        $("#myform").click(function(e) {
        //prevent Default functionality
            e.preventDefault();

            let namePattern = /^[A-Za-z\s]+$/;
            let name = document.getElementById("name").value;


            if (!namePattern.test(name)) {
                alert("Only alphabets and spaces allowed.");
                $("#name").focus();
                $("#name").val("");
                 return false; // Set focus back to input
            }

            $('#form').submit();
        });
    });
</script>
@endsection
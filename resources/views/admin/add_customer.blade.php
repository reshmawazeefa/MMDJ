@extends('layouts.vertical', ["page_title"=> "Customer | Add"])
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />


@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/customers')}}">Customer | Supplier </a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Customer | Supplier </h4>
                @if(!empty($errors->all()))
                <p class="alert alert-danger error">
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
                   

                    <form id="form" role="form" class="parsley-examples" method="post" action="{{url('admin/customers')}}">
                        {{csrf_field()}}
                        <div class="card-body body-style">
                        <div class="row mb-3">

                        <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-4 col-form-label">Name<span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" name="name" value="{{old('name')}}" required class="form-control" placeholder="Name" id="name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hori-pass1" class="col-4 col-form-label">Customer | Supplier  Code<span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" readonly name="customer_code" id="customer_code" value="{{old('customer_code')}}" placeholder="{{old('customer_code')}}" required class="form-control" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-4 col-form-label">Type <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="C">Customer</option>
                                        <option value="S">Supplier</option>
                                        
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="hori-pass2" class="col-4 col-form-label">Contact Number <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="tel" pattern="\d{10,14}" name="phone" min="10" value="{{old('phone')}}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hori-pass2" class="col-4 col-form-label">Email </label>
                                <div class="col-7">
                                    <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="whatsapp-number" class="col-4 col-form-label">WhatsApp Phone <span class="text-danger">*</span></label>
                                <div class="col-3">
                                    <input type="tel" name="country_code" pattern="\d{1,4}" value="{{ old('country_code') }}" required placeholder="44" class="form-control" id="country-code" title="Country Code" />
                                </div>
                                <div class="col-4">
                                    <input type="tel" name="alt_phone" pattern="\d{10,14}" value="{{ old('alt_phone') }}" required placeholder="WhatsApp Number" class="form-control" id="whatsapp-number" />
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Description</label>
                            <div class="col-7">
                                <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description')}}</textarea>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">GSTIN / VAT</label>
                            <div class="col-7">
                                <input type="text" name="gstin" value="{{old('gstin')}}" placeholder="GSTIN / VAT" class="form-control" id="hori-pass2" />
                            </div>
                            </div>
                        </div>

                        
                        <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="webSite" class="col-form-label">↓ Billing Address ↓</label>
                                </div>
                            </div>
                            <div class="form-group row mt-2 pt-2" style="border-top: 1px dashed #ebebeb;">
                                <label for="webSite" class="col-4 col-form-label">Address ID 
                                    <!-- <span class="text-danger">*</span> -->
                                </label>
                                <div class="col-3">
                                    <select class="form-control" name="prefixBilling" >
                                    <option value="">Select</option>
                                    <option value="Mr." {{ old('prefixBilling') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                    <option value="Ms." {{ old('prefixBilling') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                    <option value="Dr." {{ old('prefixBilling') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                    <option value="Adv." {{ old('prefixBilling') == 'Adv.' ? 'selected' : '' }}>Adv.</option>
                                    <option value="M/S." {{ old('prefixBilling') == 'M/S.' ? 'selected' : '' }}>M/S.</option>
                                </select>

                                </div>
                                <div class="col-4">
                                    <input type="text" placeholder="Address ID" required class="form-control" name="addressIDBilling" value="{{old('addressIDBilling')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Address 1 <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" placeholder="Address 1" required class="form-control" name="addressBilling" value="{{old('addressBilling')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Address 2 <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" placeholder="Address 2" required class="form-control" name="address2Billing" value="{{old('address2Billing')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">City <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" name="placeBilling" value="{{old('placeBilling')}}" required placeholder="City" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Post code <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" required name="zip_codeBilling" value="{{old('zip_codeBilling')}}" placeholder="Post code" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">State <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <!-- <input type="text" value="Kerala" name="stateBilling" value="{{old('stateBilling')}}" required placeholder="State" class="form-control" /> -->
                                <select id="stateBilling" name="stateBilling" class="stateBilling form-control select2" required>
                                    <option value="">Select a Region</option>
                                    <option value="england" {{ old('stateBilling') == 'england' ? 'selected' : '' }}>England</option>
                                    <option value="scotland" {{ old('stateBilling') == 'scotland' ? 'selected' : '' }}>Scotland</option>
                                    <option value="wales" {{ old('stateBilling') == 'wales' ? 'selected' : '' }}>Wales</option>
                                    <option value="northern_ireland" {{ old('stateBilling') == 'northern_ireland' ? 'selected' : '' }}>Northern Ireland</option>
                                </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Country <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" value="United Kingdom" name="countryBilling" value="{{old('countryBilling')}}" required placeholder="Country" class="form-control" readonly/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-lg-6 col-sm-6 md-pt">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="webSite" class=" col-form-label">↓ Shipping Address ↓</label>
                                </div>
                            </div>
                            <div class="form-group row mt-2 pt-2" style="border-top: 1px dashed #ebebeb;">
                                <div class="col-md-12  mb-2">
                                <input type="checkbox" name="sepBilling" id="sepBilling" {{ old('sepBilling') ? 'checked' : '' }}>

                                    <label for="webSite" class="col-form-label"> Same as Billing Address</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Address ID <!-- <span class="text-danger">*</span>--></label> 
                                <div class="col-3">
                                <select class="form-control" name="prefix" >
                                    <option value="">Select</option>
                                    <option value="Mr." {{ old('prefix') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                    <option value="Ms." {{ old('prefix') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                    <option value="Dr." {{ old('prefix') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                    <option value="Adv." {{ old('prefix') == 'Adv.' ? 'selected' : '' }}>Adv.</option>
                                    <option value="M/S." {{ old('prefix') == 'M/S.' ? 'selected' : '' }}>M/S.</option>
                                </select>

                                </div>
                                <div class="col-4">
                                    <input type="text" placeholder="Address ID" required class="form-control" name="addressID" value="{{old('addressID')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Address 1 <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" placeholder="Address 1" required class="form-control" name="address" value="{{old('address')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Address 2 <span class="text-danger">*</span></label>
                                <div class="col-7">
                                    <input type="text" placeholder="Address 2" required class="form-control" name="address2" value="{{old('address2')}}" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">City <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" name="place" value="{{old('place')}}" placeholder="City" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Post code <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" required name="zip_code" value="{{old('zip_code')}}" placeholder="Post code" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">State <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <!-- <input type="text" value="Kerala" name="state" value="{{old('state')}}" placeholder="State" class="form-control" /> -->
                                <select id="state" name="state" class="state form-control select2" required>
                                    <option value="">Select a Region</option>
                                    <option value="england" {{ old('state') == 'england' ? 'selected' : '' }}>England</option>
                                    <option value="scotland" {{ old('state') == 'scotland' ? 'selected' : '' }}>Scotland</option>
                                    <option value="wales" {{ old('state') == 'wales' ? 'selected' : '' }}>Wales</option>
                                    <option value="northern_ireland" {{ old('state') == 'northern_ireland' ? 'selected' : '' }}>Northern Ireland</option>
                                </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="webSite" class="col-4 col-form-label">Country <span class="text-danger">*</span></label>
                                <div class="col-7">
                                <input type="text" value="United Kingdom" name="country" value="{{old('country')}}" placeholder="Country" class="form-control" readonly />
                                </div>
                            </div>

                        </div>
                        <div class="form-group row mt-2 newbutton">
                            <div class="d-flex justify-content-end gap-1 mb-3">
                               
                                <button id="myform" type="submit" class="btn btn-primary waves-effect waves-light h-view">Save</button>
                                <button id="" type="reset" class="btn btn-primary waves-effect waves-light h-view">Clear</button>
                                <button type="button" class="btn btn-secondary cancelbtn h-view" onclick="window.history.back();" >Cancel</button>
                                
                            </div>
                        </div>
                    </form>
                </div>
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


        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'customer'},
           success:function(data){
              $('#customer_code').val(data);
           }
        });
        $('#form').on('reset', function() {
            let preservedValue = $('#customer_code').val(); // Store value before reset

            setTimeout(() => {
                $('#customer_code').val(preservedValue); // Restore after reset
            }, 10);
        });

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


        // $("#myform").click(function(e) {
        // //prevent Default functionality
        //     e.preventDefault();
        //     let namePattern = /^[A-Za-z\s]+$/;
        //     let name = document.getElementById("name").value;


        //     if (!namePattern.test(name)) {
        //         alert("Only alphabets and spaces allowed.");
        //         $("#name").focus();
        //         $("#name").val("");
        //          return false; // Set focus back to input
        //     }

        //     $('#form').submit();
        // });
    });
</script>
@endsection
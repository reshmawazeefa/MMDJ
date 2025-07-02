<style>
.text-left-style{
    text-align: left;
}
.popup .page-title{
    font-size:18px!important;
    padding-bottom: 3%;
}
</style>
<!-- modal --><!-- modal -->
<div id="addCustModal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body-approve p-3">
                    <div class="text-center">
                        <div class="page-title-box popup">
                            <h4 class="page-title">Create Customer </h4>
                        </div>
                        <form id="customer-form" role="form" class="parsley-examples" method="post" action="{{url('admin/customers')}}">
                        {{csrf_field()}}
                        <div class="row mb-2">
                            <label for="inputEmail3" class="col-3 col-form-label text-left-style">Name<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" name="name" value="{{old('name')}}" required class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass1" class="col-3 col-form-label text-left-style">Customer  Code<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" readonly name="customer_code" id="customer_code" value="{{old('customer_code')}}" placeholder="Customer Code" required class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="type" class="col-3 col-form-label text-left-style">Type <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <select class="form-control" name="type" id="type" required>
                                    <option value="C">Customer</option>
                                    <option value="S">Supplier</option>
                                    
                                </select>
                            </div>
                        </div> 
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="number" name="phone" min="10" value="{{old('phone')}}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Email</label>
                            <div class="col-9">
                                <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Alt Phone<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="number" name="alt_phone" min="10" value="{{old('alt_phone')}}" placeholder="Alternate Contact Number" class="form-control" id="hori-pass2" required/>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Description</label>
                            <div class="col-9">
                                <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">GSTIN </label>
                            <div class="col-9">
                                <input type="text" name="gstin" value="{{old('gstin')}}" placeholder="GSTIN" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="row mb-2"><label for="webSite" class="col-12 col-form-label text-left-style">&#8595; Shipping Address &#8595;</label></div>
                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address ID <span class="text-danger">*</span></label>
                            <div class="col-3">
                                <select class="form-control" name="prefix">
                                    <option>Mr.</option>
                                    <option>Ms.</option>
                                    <option>Dr.</option>
                                    <option>Adv.</option>
                                    <option>M/S.</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" placeholder="Address ID" required class="form-control" name="addressID" value="{{old('addressID')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address 1 <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" placeholder="Address 1" required class="form-control" name="address" value="{{old('address')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address 2 <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" placeholder="Address 2" required class="form-control" name="address2" value="{{old('address2')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">City <span class="text-danger">*</span></label>
                            <div class="col-9">
                            <input type="text" name="place" value="{{old('place')}}" placeholder="City" class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Zip code <span class="text-danger">*</span></label>
                            <div class="col-9">
                            <input type="text" required name="zip_code" value="{{old('zip_code')}}" placeholder="Zip code" class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">State <span class="text-danger">*</span></label>
                            <div class="col-9">
                            <!-- <input type="text" value="Kerala" name="state" value="{{old('state')}}" placeholder="State" class="form-control" /> -->
                            <select id="state" name="state"  class="state form-control select2" required>
                                                <option value="">Select a State</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Sikkim">Sikkim</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Tripura">Tripura</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="Uttarakhand">Uttarakhand</option>
                                                <option value="West Bengal">West Bengal</option>
                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh">Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                <option value="Lakshadweep">Lakshadweep</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Puducherry">Puducherry</option>
                                                <option value="Ladakh">Ladakh</option>
                                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option value="Kuwait">Kuwait</option>
                                            </select>
                            
                        </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Country <span class="text-danger">*</span></label>
                            <div class="col-9">
                            <input type="text" value="India" name="country" value="{{old('country')}}" placeholder="Country" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-left-style">
                                <label for="webSite" class="col-form-label">↓ Billing Address ↓</label>
                            </div>
                            <div class="col-6  text-left-style"><input type="checkbox" name="sepBilling" id="sepBilling">
                                <label for="webSite" class="col-form-label"> Same as Shipping Address</label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address ID <span class="text-danger">*</span></label>
                            <div class="col-3">
                                <select class="form-control" name="prefixBilling">
                                    <option>Mr.</option>
                                    <option>Ms.</option>
                                    <option>Dr.</option>
                                    <option>Adv.</option>
                                    <option>M/S.</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" placeholder="Address ID" required class="form-control" name="addressIDBilling" value="{{old('addressIDBilling')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address 1 <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" placeholder="Address 1" required class="form-control" name="addressBilling" value="{{old('addressBilling')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address 2 <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" placeholder="Address 1" required class="form-control" name="address2Billing" value="{{old('address2Billing')}}" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">City</label>
                            <div class="col-9">
                            <input type="text" name="placeBilling" value="{{old('placeBilling')}}" placeholder="City" class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Zip code <span class="text-danger">*</span></label>
                            <div class="col-9">
                            <input type="text" required name="zip_codeBilling" value="{{old('zip_codeBilling')}}" placeholder="Zip code" class="form-control" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">State</label>
                            <div class="col-9">
                            <!-- <input type="text" value="Kerala" name="stateBilling" value="{{old('stateBilling')}}" placeholder="State" class="form-control" /> -->
                            <select id="stateBilling" name="stateBilling"  class="state form-control select2" required>
                                                <option value="">Select a State</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Sikkim">Sikkim</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Tripura">Tripura</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="Uttarakhand">Uttarakhand</option>
                                                <option value="West Bengal">West Bengal</option>
                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh">Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                <option value="Lakshadweep">Lakshadweep</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Puducherry">Puducherry</option>
                                                <option value="Ladakh">Ladakh</option>
                                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option value="Kuwait">Kuwait</option>
                                            </select>
                            
                        
                        
                        </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Country</label>
                            <div class="col-9">
                            <input type="text" value="India" name="countryBilling" value="{{old('countryBilling')}}" placeholder="Country" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 offset-4" style="float:right;">
                                <button id="customer-submit" type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                <button type="button" id="confirm-cancel" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        <div class="page-title-box">
                            <p style="display:none" class="alert alert-danger">
                            </p>
                        </div>
                    </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- modal -->

    <!-- modal --><!-- modal -->
    <div id="addPartModal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body-approve p-3">
                    <div class="text-center">
                        <div class="page-title-box popup">
                            <h4 class="page-title">Create Partner</h4>
                        </div>
                        <form id="partner-form" role="form" class="parsley-examples" method="post" action="{{url('admin/partners')}}">
                        {{csrf_field()}}
                        <div class="row mb-2">
                            <label for="inputEmail3" class="col-3 col-form-label text-left-style">Name<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" name="name" value="{{old('name')}}" required class="form-control" placeholder="Name" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass1" class="col-3 col-form-label text-left-style">Partner Code<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" name="partner_code" id="partner_code" value="{{old('partner_code')}}" placeholder="Partner Code" required class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="number" min="10" name="phone" value="{{old('phone')}}" required placeholder="Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Email</label>
                            <div class="col-9">
                                <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Partner Type <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <select name="partner_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Contractor">Contractor</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Sales Executive">Sales Executive</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Designation</label>
                            <div class="col-9">
                                <input type="text" name="designation" value="{{old('designation')}}" placeholder="Designation" class="form-control" id="hori-pass2" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="hori-pass2" class="col-3 col-form-label text-left-style">Alt Contact Number</label>
                            <div class="col-9">
                                <input type="text" name="alt_phone" value="{{old('alt_phone')}}" placeholder="Alt Contact Number" class="form-control" id="hori-pass2" />
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Address</label>
                            <div class="col-9">
                                <textarea class="form-control" name="address" rows="5" spellcheck="false">{{old('address')}}</textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="webSite" class="col-3 col-form-label text-left-style">Description</label>
                            <div class="col-9">
                                <textarea class="form-control" name="description" rows="5" spellcheck="false">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 offset-4" style="float: right;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                        <div class="page-title-box">
                            <p style="display:none" class="alert-part alert-danger">
                            </p>
                        </div>
                    </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- modal -->




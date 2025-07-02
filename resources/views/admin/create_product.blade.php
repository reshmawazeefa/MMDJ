@extends('layouts.vertical', ["page_title"=> "Product Add"])

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
                            <a href="{{url('admin/products')}}">Product</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Product</h4>
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
        <div class="col-12">
            <!-- @if(!empty($errors->all()))
            <p class="alert alert-danger newStyle">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
            </p>
            @endif -->
            <div class="card">
                <form id="products-submit" method="post" class="parsley-examples" action="{{url('admin/products/insert')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="card-body body-style">
                        <div class="row mb-3">
                        <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">
                                    Product Code <span class="text-danger">*</span>                                    
                                    </label>
                                    <div class="col-sm-7">
                                    <input type="text" class="form-control" name="procode" id="procode" placeholder="Product Code" aria-describedby="basic-addon1" value="{{$prcode}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Product Name. <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="proname" id="proname" placeholder="Product Name." aria-describedby="basic-addon1" value="{{old('proname')}}">
                                    </div>
                                </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="form-group row">
                                <label for="referral" class="col-sm-5 col-form-label">
                                    Image <!-- <span class="text-danger">*</span> -->
                                </label>
                                <div class="col-sm-7">
                                    <input type="file" name="image" id="photo" class="form-control">
                                    <div id="image-preview" style="padding:2% 0%;">
                                        <img width="30%" id="imgPreview" src="">
                                    </div>
                                    <!-- Warning Text -->
                                    <small class="text-muted" id="image-warning">Allowed file types: jpeg, png, jpg, gif. Max size: 2MB.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Unit <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="unit" id="unit" class="form-control">
                                        <option value="" disabled>Select Unit</option>
                                        <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                                        <option value="Packet" {{ old('unit') == 'Packet' ? 'selected' : '' }}>Packet</option>
                                        <option value="Bunch" {{ old('unit') == 'Bunch' ? 'selected' : '' }}>Bunch</option>
                                        <option value="Pieces" {{ old('unit') == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                        <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="Bag" {{ old('unit') == 'Bag' ? 'selected' : '' }}>Bag</option>
                                        <option value="Litre" {{ old('unit') == 'Liter' ? 'selected' : '' }}>Litre</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Narration <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="box_qty" id="box_qty" placeholder="Quantity" aria-describedby="basic-addon1" value="{{old('box_qty')}}">
                                    </div>
                                </div>
                                
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Price <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="number" class="form-control" name="price" id="price" placeholder="Price" aria-describedby="basic-addon1" step="0.01"  value="{{old('price')}}">
                                    </div>
                                </div> 
                        </div>
                       <div class="col-lg-4">

                             <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Purchase Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="warehouse" id="warehouse" class="form-control">
                                        <!-- <option value="" disabled>Select Unit</option> -->
                                         @foreach($data as $val)
                                        <option value="{{$val->whsCode}}" {{ old('warehouse') == $val->whsCode ? 'selected' : '' }}>{{$val->whsName}}</option>
                                        @endforeach
                                        <!-- <option value="Local Market">Local Market</option> -->
                                    </select>
                                    </div>
                                </div>
                                <!--  <div class="form-group row">
                                    <label for="activeToggle" class="col-sm-5 col-form-label">
                                         Active? 
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="checkbox" id="activeToggle" name="activeToggle" data-toggle="toggle" data-on="Active" data-off="Inactive" 
                                            data-onstyle="success" data-offstyle="danger" {{ old('activeToggle') ? 'checked' : '' }}>
                                    </div>
                                </div>-->
                        </div> 
                        <div class="col-lg-4">
                                
                                <div class="button-height">
                                <div class="text-right"> 
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button> 
                                <button type="reset" class="btn btn-primary waves-effect waves-light" style="margin-left: 10px;">Clear</button>
                                <button type="button" class="btn btn-secondary cancelbtn" onclick="window.history.back();">Cancel</button>
                                   
                                   
                                </div>

                                </div>
                        </div>
                        




                            <div class="col-lg-4">
                                

                              

                                <!-- <div class="form-group row">
                                <label for="referral" class="col-sm-5 col-form-label">
                                Barcode
                                    </label>
                                    <div class="col-sm-7">
                                    <input  type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                               

                                <!-- <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    InvUOM
                                    </label>
                                    <div class="col-sm-7">
                                    <input   type="text" class="form-control" name="invuom" id="invuom" placeholder="InvUOM" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                                <!-- <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    SaleUOM
                                    </label>
                                    <div class="col-sm-7">
                                    <input   type="text" class="form-control" name="saleuom" id="saleuom" placeholder="SaleUOM" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                                <!-- <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    HSN Code
                                    </label>
                                    <div class="col-sm-7">
                                    <input   type="text" class="form-control" name="hsn_code" id="hsn_code" placeholder="HSN Code" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                                <!-- <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Tax Rate <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="number" class="form-control" name="tax_rate" id="tax_rate" placeholder="Tax Rate" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                                
                               

                               

                                

                                

                            </div>


                        <!-- <div class="col-lg-4">

                                

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    WareHouse  <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="whscode" id="whscode" class="whscode-select form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    On Hand <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="on_hand" id="on_hand" placeholder="On Hand" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Block Quantity <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="block_qty" id="block_qty" placeholder="Block Quantity" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="customer" class="col-sm-5 col-form-label">
                                    Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="category" id="category" class="categorySelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="from_date" class="col-sm-5 col-form-label">
                                    Subcategory <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="subcategory" id="subcategory" class="subCategorySelect form-control select2">
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="to_date" class="col-sm-5 col-form-label">
                                    Type <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="type" id="type" class="typeSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="customer" class="col-sm-5 col-form-label">
                                    Brand <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="brand" id="brand" class="brandSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="size" class="col-sm-5 col-form-label">
                                    Size <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="size" id="size" class="sizeSelect form-control select2">
                                    </select>
                                    </div>
                                </div> 

                                

                               
                        </div>-->


                        <!-- <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="color" class="col-sm-5 col-form-label">
                                    Color <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="color" id="color" class="colorSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="finish" class="col-sm-5 col-form-label">
                                    Finish <span class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                    <select required name="finish" id="finish" class="finishSelect form-control select2">
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Thickness <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="thickness" id="thickness" placeholder="Thickness" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Conv Factor <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="number" class="form-control" name="conv_factor" id=" conv_factor" placeholder="Conv Factor" aria-describedby="basic-addon1">
                                    </div>
                                </div> -->

                               

                                <!-- <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Sqft Conv <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="number" class="form-control" name="sqft_conv" id="sqft_conv"  placeholder="Sqft Conv" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Weight <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="number" class="form-control" name="weight" id="weight"  placeholder="Weight" aria-describedby="basic-addon1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="date" class="col-sm-5 col-form-label">
                                    Updated Date <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required type="date" name="updated_date" id="updated_date"  class="form-control flatpickr-input active">
                                    </div>
                                </div> 

                                
                        </div>-->
                        </div>


                        <!-- <div class="col-12 mt-1" style="margin-bottom: 3.5%;">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();" style="float: right; margin-left:10px;">Back</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Save</button>
                        </div> -->
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
    $(document).ready(function() {
        
        const photoInp = $("#photo");
        photoInp.change(function (e) {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $(".categorySelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/categories') }}",
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
                                text: item.categoryName,
                                id: item.categoryCode
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
                    placeholder: "Category",
                    allowClear: false,
            });
            $(".subCategorySelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/subcategories') }}",
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
                                text: item.subCateg,
                                id: item.subCateg
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
                    placeholder: "Subcategory",
                    allowClear: false,
            });
            $(".typeSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/types') }}",
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
                                text: item.type,
                                id: item.type
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
                    placeholder: "Type",
                    allowClear: false,
            });
            $(".brandSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/brands') }}",
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
                                text: item.brand,
                                id: item.brand
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
                    placeholder: "Brand",
                    allowClear: false,
            });
            $(".sizeSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/sizes') }}",
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
                                text: item.size,
                                id: item.size
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
                    placeholder: "Size",
                    allowClear: false,
            });
            $(".colorSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/colors') }}",
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
                                text: item.color,
                                id: item.color
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
                    placeholder: "Color",
                    allowClear: false,
            });
            $(".finishSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/finish') }}",
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
                                text: item.finish,
                                id: item.finish
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
                    placeholder: "Finish",
                    allowClear: false,
            });

            $(".whscode-select").select2({
            ajax: {
                url: "{{ url('admin/ajax/whscode') }}",
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
                processResults: function (data, params) {
                    params.current_page = params.current_page || 1;
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.whsName,
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
        var today = new Date();
        var formattedToday = today.toISOString().split('T')[0];
      

        
    });
    
 

//     $("#products-submit").submit(function(e){

//             e.preventDefault(); // Prevent the default form submission
//             var form = $(this);
//             var url = form.attr('action');

//             // Create a temporary form data object to store only the rows with valid background color
//             var formData = new FormData(this);

//             // Add CSRF token manually if not already included
//             formData.append('_token', "{{ csrf_token() }}");

//             $.ajax({
//             url: url,
//             type: 'POST',
//             data: formData,
//             processData: false, // Don't convert to a query string
//             contentType: false, // Let jQuery set content type
//             success: function (data) {
//             console.log("data.success");
//             console.log(data.success);
//                 if (data.success) {
//                     sessionStorage.setItem('successMessage', data.message);
//                     window.location.href = 'products';
//                 }
//             },
//             error: function (xhr) {
//                 console.log('Error:', xhr.responseText);
//             }
//         });
// });


</script>
@endsection
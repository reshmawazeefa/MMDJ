@extends('layouts.vertical', ["page_title"=> "Product Edit"])

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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Product</h4>
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
                <form id="products-submit" method="post" class="parsley-examples" action="{{url('admin/products/'.$details->id.'/update')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="card-body body-style">
                        <div class="row mb-3">
                       
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 col-form-label">
                                    Product Code <span class="text-danger">*</span>                                    
                                    </label>
                                    <div class="col-sm-7">
                                    <input type="text" class="form-control" name="procode" id="procode" placeholder="Product Code" aria-describedby="basic-addon1" value="{{$details->productCode}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Product Name. <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <input required  type="text" class="form-control" name="proname" id="proname" placeholder="Product Name." aria-describedby="basic-addon1" value="{{$details->productName}}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                <label for="referral" class="col-sm-5 col-form-label">
                                 Image <!--<span class="text-danger">*</span> -->
                                    </label>
                                    <div class="col-sm-7">
                                    <!-- <input   type="file" class="form-control" name="image" id="image" placeholder="Image" aria-describedby="basic-addon1"> -->
                                    <input type="file" name="image"  id="photo" >
                                    </div>
                                    <div id="image-preview">
                                        <img width="100" id="imgPreview" src="{{asset('').'/assets/images/products/'.$details->image}}">
                                    </div>
                                    <!-- Warning Text -->
                                    <small class="text-muted" id="image-warning">Allowed file types: jpeg, png, jpg, gif. Max size: 2MB.</small>
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Unit <span class="text-danger">*</span> 
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="unit" id="unit" class="form-control" style="width: 100%;">
                                        <option value="" disabled {{ !isset($details->price->unit) ? 'selected' : '' }}>Select Unit</option>
                                        <option value="Box" {{ (isset($details->price->unit) && $details->price->unit == 'Box') ? 'selected' : '' }}>Box</option>
                                        <option value="Packet" {{ (isset($details->price->unit) && $details->price->unit == 'Packet') ? 'selected' : '' }}>Packet</option>
                                        <option value="Bunch" {{ (isset($details->price->unit) && $details->price->unit == 'Bunch') ? 'selected' : '' }}>Bunch</option>
                                        <option value="Pieces" {{ (isset($details->price->unit) && $details->price->unit == 'Pieces') ? 'selected' : '' }}>Pieces</option>
                                        <option value="Kg" {{ (isset($details->price->unit) && $details->price->unit == 'Kg') ? 'selected' : '' }}>Kg</option>
                                        <option value="Bag" {{ (isset($details->price->unit) && $details->price->unit == 'Bag') ? 'selected' : '' }}>Bag</option>
                                        <option value="Litre" {{ (isset($details->price->unit) && $details->price->unit == 'Litre') ? 'selected' : '' }}>Litre</option>
                                    </select>

                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <label for="referral" class="col-sm-5 col-form-label">
                                        Narration <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                        <input required  type="text" class="form-control" name="box_qty" id="box_qty" placeholder="Quantity" aria-describedby="basic-addon1" value="{{$details->boxQty}}">
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-4">
                                    <div class="form-group row">
                                        <label for="referral" class="col-sm-5 col-form-label">
                                        Price <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-7">
                                        <input required  type="number" class="form-control" name="price" id="price" placeholder="Price" aria-describedby="basic-addon1" step="0.01" value="{{$details->price->price}}">
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-4">
                                    <div class="form-group row" style="display: none; ">
                                        <label for="activeToggle" class="col-sm-5 col-form-label">
                                            Active?  <!--<span class="text-danger">*</span> -->
                                        </label>
                                        <div class="col-sm-7">
                                        <input type="checkbox" id="activeToggle" name="activeToggle" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" {{ isset($details->is_active) && $details->is_active == 'Y' ? 'checked' : '' }}>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="referral" class="col-sm-5 col-form-label">
                                    Purchased Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-7">
                                    <select required name="warehouse" id="warehouse" class="form-control">
                                        <!-- <option value="" disabled>Select Unit</option> -->
                                        @foreach($data as $val)
                                        <option value="{{$val->whsCode}}" {{ isset($details->stock->whsCode) && $details->stock->whsCode == $val->whsCode ? 'selected' : '' }}>{{$val->whsName}}</option>
                                        @endforeach
                                        <!-- <option value="Local Market">Local Market</option> -->
                                    </select>
                                    </div>
                                </div>

                               

                            </div>
                            <div class="col-lg-4">
                                
                                <div class="edit-product-btn">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();" style="float: right;margin-left:10px;">Back</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Update</button>
                                </div>
                        </div>

                           

                            <!-- <div class="col-lg-4">

                            <div  style="margin-bottom: 3.5%;">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();" style="float: right;margin-left:10px;">Back</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Update</button>
                        </div>
                                   
                            </div> -->
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
    
 


</script>
@endsection
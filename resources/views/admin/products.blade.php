@extends('layouts.vertical', ["page_title"=> "Products | List"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

<style>
        /* In order to place the tracking correctly */
        canvas.drawing, canvas.drawingBuffer {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
<!-- third party css end -->
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">Table</li>
                    </ol>
                </div>
                <h4 class="page-title">Products</h4>
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

        <div class="col-12">
            <div class="card">
                <div class="card-body body-style productMStyle table-m">
                <div class="row pb-3" style="border-bottom:1px dashed #ededed;">
                    @can('manage-user')
                        
                    @endcan
                    <form id="productSearchForm" class="form" method="POST" action="">
                        @csrf
                        <div class="col-lg-12">
                            <div class="row">

    <div class="col-lg-4">
        <div class="form-group row">
            <label for="customer" class="col-sm-5 col-form-label">
            Product</label>
            <div class="col-sm-7">
            <select name="product" class="productSelect form-control select2">
            </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="to_date" class="col-sm-5 col-form-label">
            Purchased Type
            </label>
            <div class="col-sm-7">
                <select required name="whscode" class="whsSelect form-control select2">
                </select>
            </div>
        </div>

       
    </div>

    <div class="col-lg-4">
                <div class="form-group row">
                    <label for="from_date" class="col-sm-5 col-form-label">
                    Unit</label>
                    <div class="col-sm-7">
                    <select  name="unit" id="unit" class="form-control">
                        <option value="" >Select Unit</option>
                        <option value="Box">Box</option>
                        <option value="Pieces">Pieces</option>
                        <option value="Kg">Kg</option>
                        <option value="Bag">Bag</option>
                        <option value="Litre">Litre</option>
                    </select>
                    </div>
                </div>

        <div class="form-group row mb-3">
            <label for="customer" class="col-sm-5 col-form-label">
            </label>
            <div class="col-sm-7">
            <input id="productSearchSubmit" class="btn btn-info btn-info2 me-md-0" type="submit" value="Search" />
            <input id="productSearchReset" class="btn btn-info btn-info2" type="button" value="Reset" />
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-3">
        <div class="form-group row">
            <label for="size" class="col-sm-5 col-form-label">
            Size</label>
            <div class="col-sm-7">
            <select name="size" class="sizeSelect form-control select2">
            </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="color" class="col-sm-5 col-form-label">
            Color</label>
            <div class="col-sm-7">
            <select name="color" class="colorSelect form-control select2">
            </select>
            </div>
        </div>
    </div> -->

    <div class="col-lg-4">

        <div class="form-group row">
           
            <div class="col-sm-5">
            <!-- <div class="d-grid gap-1 d-md-flex justify-content-md-end">
            <input id="productSearchSubmit" style="padding: 0.45rem 0.56rem;" class="btn btn-info me-md-0" type="submit" value="Search" />
            <input id="productSearchReset" style="padding: 0.45rem 0.56rem;" class="btn btn-info" type="button" value="Reset" />
            </div> -->
            </div>
            <div class="col-sm-7">
            <div style="padding-bottom: 28px;">
            <!-- <a href="{{url('cron/product')}}" class="btn btn-primary">Sync Product Master</a>&nbsp;
            <a href="{{url('cron/prodStock')}}" class="btn btn-info">Sync Product Stock</a>&nbsp;&nbsp;
            <a href="{{url('cron/prodPrice')}}" class="btn btn-danger close-icon">Sync Product Price</a> -->
            <a href="{{url('admin/pcreate')}}" class="btn btn-primary w-100">Add Product </a>
        </div>
            </div>
        </div>
       
    </div>


 </div>
                        
</div><!-- end col-->
                    </form>
                </div>

                    <table id="server-datatable" class="table dt-responsive nowrap w-100 ">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Purchased Type</th>

                                <!--<th>subCategory</th>
                                <th>taxRate</th>
                                <th>type</th>
                                <th>brand</th>
                                <th>size</th>
                                <th>invUOM</th>
                                <th>Sale UOM</th>
                                <th>color</th>
                                <th>finish</th>
                                <th>conv_Factor</th>
                                <th>boxQty</th>-->
                                <!-- <th>Image</th> -->
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

</div> <!-- container -->

@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<!-- end demo js-->

   
<script type="text/javascript">
  $(document).ready(function() {
    var url = "{{url('admin/products')}}";
    var table = $('#server-datatable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: url,
            data: function (d) {
                d.product = $('select[name="product"]').val(),
                d.unit = $('select[name="unit"]').val(),
                d.whscode = $('select[name="whscode"]').val()
                // d.type = $('select[name="type"]').val(),
                // d.brand = $('select[name="brand"]').val(),
                // d.size = $('select[name="size"]').val(),
                // d.color = $('select[name="color"]').val(),
                // d.finish = $('select[name="finish"]').val()
            }
        },
        columns: [
            {data: 'productCode', name: 'productCode'},
            {data: 'productName', name: 'productName'},
            { data: 'whsName', name: 'whsName' },
            // {data: 'categoryCode', name: 'categoryCode'},
            /*{data: 'category.categoryName', name: 'category.categoryName'},
            {data: 'subCateg', name: 'subCateg'},
            {data: 'taxRate', name: 'taxRate'},
            {data: 'type', name: 'type'},
            {data: 'brand', name: 'brand'},
            {data: 'size', name: 'size'},
            {data: 'invUOM', name: 'invUOM'},
            {data: 'saleUOM', name: 'saleUOM'},
            {data: 'color', name: 'color'},
            {data: 'finish', name: 'finish'},
            {data: 'conv_Factor', name: 'conv_Factor'},
            {data: 'boxQty', name: 'boxQty'},*/
            // {data: 'image', name: 'image'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    $(document).on("click", ".checkActive", function() {

    if (confirm('Are you sure you want to update the status of this Product?')) {
        var button = $(this);
        var u = "{{ url('admin/products/status') }}";
        var id = button.data("id");
        var status = button.hasClass("btn-success") ? 'N' : 'Y';

        $.ajax({
            url: u,
            type: "POST",
            dataType: "JSON",
            data: { 
                _token: button.data("token"), 
                is_active: status, 
                id: id 
            },
            success: function(data) {
                if (data.success) {
                    // Toggle button text and class based on the new status
                    if (data.is_active == 'Y') {
                        button.text("Active").removeClass("btn-danger").addClass("btn-success");
                    } else {
                        button.text("Deactive").removeClass("btn-success").addClass("btn-danger");
                    }
                    $('.con-quote').html(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function() {
                alert("Error while updating status");
            }
        });
    }
    });

            $(".productSelect").select2({
                ajax: {
                url: "{{ url('admin/ajax/products') }}",
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
                                text: item.productName,
                                id: item.productCode
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
                    placeholder: "Product",
                    allowClear: false,
            });

            $(".whsSelect").select2({
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
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.whsName,
                            id: item.whsCode
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
                placeholder: "Purchased Type",
                allowClear: false,
        });
   
   
        $(".branchSelect").select2({
        ajax: {
        url: "{{ url('admin/ajax/branches') }}",
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
                        text: item.BranchName,
                        id: item.BranchCode
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
            placeholder: "By searching branch name or code",
            allowClear: false,
    });

        


    $(document).on('click', '#productSearchSubmit', function(e) {
        e.preventDefault(); 
        
        table.ajax.url(url).load();
    });
    $("#productSearchReset").click(function(){
    // Reset Select2 dropdowns correctly
    $(".productSelect").val(null).trigger('change');
    $("#unit").val('').trigger('change');
    $(".whsSelect").val('').trigger('change');        

    // Reload DataTable
    table.ajax.url(url).load();

    // Reset other form elements if needed
    $("#productSearchForm")[0].reset();
});

});
  </script>
  <!-- Include the image-diff library -->
    <script src="{{ asset('assets/js/quagga.min.js') }}" defer></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script>        
        var _scannerIsRunning = false;

        function startScanner() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                    constraints: {
                        width: 480,
                        height: 320,
                        facingMode: "environment"
                    },
                },
                decoder: {
                    readers: [
                        "code_128_reader",
                        "ean_reader",
                        "ean_8_reader",
                        "code_39_reader",
                        "code_39_vin_reader",
                        "codabar_reader",
                        "upc_reader",
                        "upc_e_reader",
                        "i2of5_reader"
                    ],
                    debug: {
                        showCanvas: true,
                        showPatches: true,
                        showFoundPatches: true,
                        showSkeleton: true,
                        showLabels: true,
                        showPatchLabels: true,
                        showRemainingPatchLabels: true,
                        boxFromPatches: {
                            showTransformed: true,
                            showTransformedBox: true,
                            showBB: true
                        }
                    }
                },

            }, function (err) {
                if (err) {
                    console.log(err);
                    return
                }

                console.log("Initialization finished. Ready to start");
                Quagga.start();

                // Set flag to is running
                _scannerIsRunning = true;
            });

            Quagga.onProcessed(function (result) {
                var drawingCtx = Quagga.canvas.ctx.overlay,
                drawingCanvas = Quagga.canvas.dom.overlay;

                if (result) {
                    if (result.boxes) {
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                        result.boxes.filter(function (box) {
                            return box !== result.box;
                        }).forEach(function (box) {
                            Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                        });
                    }

                    if (result.box) {
                        Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
                    }

                    if (result.codeResult && result.codeResult.code) {
                        Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
                    }
                }
            });


            Quagga.onDetected(function (result) {
                console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
                window.location.replace("http://127.0.0.1:8000/admin/products/14276880");
            });
        }


       
        $(document).on('click', '.deleteProducts', function() {
    let productId = $(this).data('id');
    let token = $(this).data('token'); // Fetch CSRF token from data attribute
    var url = "{{ url('admin/products/close/') }}" + '/' + productId;

    if (confirm("Are you sure you want to delete this product?")) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: token,
                _method: 'DELETE' // Important for Laravel delete method
            },
            success: function(response) {
                alert("Product deleted successfully!");
                $('#server-datatable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert("Error deleting product! Check console.");
                console.log(xhr.responseText);
            }
        });
    }
});



    </script>
@endsection
@extends('layouts.vertical', ["page_title"=> "Products | List"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
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

    <div class="row">     

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12">
                    <form id="productSearchForm" class="form" method="POST" action="">
                        @csrf
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="category" class="categorySelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="subcategory" class="subCategorySelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="type" class="typeSelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="brand" class="brandSelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="size" class="sizeSelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="color" class="colorSelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <select name="finish" class="finishSelect form-control select2">
                            </select>
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <input id="productSearchSubmit" class="btn btn-info" type="submit" value="Search" />
                        </div>
                        <div class="col-sm-1.5" style="float: left;">&nbsp;&nbsp;</div>
                        <div class="col-sm-1.5" style="float: left;">
                            <input id="productSearchReset" class="btn btn-info" type="button" value="Reset" />
                        </div>
                    </form>
                    </div><!-- end col-->
                    <div class="col-sm-12">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <!-- Div to show the scanner -->
                            <div id="scanner-container"></div>
                            <input class="btn btn-primary waves-effect waves-light" type="button" id="btn" value="Start the scanner" /> 
                        </div>
                    </div>
                </div>
                    <table id="server-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Category</th>
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
                                <th>Image</th>
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
                d.category = $('select[name="category"]').val(),
                d.subcategory = $('select[name="subcategory"]').val(),
                d.type = $('select[name="type"]').val(),
                d.brand = $('select[name="brand"]').val(),
                d.size = $('select[name="size"]').val(),
                d.color = $('select[name="color"]').val(),
                d.finish = $('select[name="finish"]').val()
            }
        },
        columns: [
            {data: 'productCode', name: 'productCode'},
            {data: 'productName', name: 'productName'},
            {data: 'category.categoryName', name: 'category.categoryName'},
            /* {data: 'subCateg', name: 'subCateg'},
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
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $(document).on('click', '#productSearchSubmit', function(e) {
        e.preventDefault(); 
        
        table.ajax.url(url).load();
    });
    $("#productSearchReset").click(function(){
        
        $(".categorySelect").select2('val', 'All');
        $(".subCategorySelect").select2('val', 'All');
        $(".typeSelect").select2('val', 'All');
        $(".brandSelect").select2('val', 'All');
        $(".sizeSelect").select2('val', 'All');
        $(".colorSelect").select2('val', 'All');
        $(".finishSelect").select2('val', 'All');
        table.ajax.url(url).load();
        //$("#productSearchForm").trigger("reset");
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


        // Start/stop scanner
        document.getElementById("btn").addEventListener("click", function () {
            if (_scannerIsRunning) {
                Quagga.stop();
            } else {
                startScanner();
            }
        }, false);
        
        $(document).ready(function() {
            
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
        });
        //$("#orderSerachForm").ajaxForm({url: "http://127.0.0.1:8000/admin/products", type: 'post'});

        
        /*$("#orderSerachForm").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                alert(here); // show response from the php script.
                }
            });

        });*/

    </script>
@endsection
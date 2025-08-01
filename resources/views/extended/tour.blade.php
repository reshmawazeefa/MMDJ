@extends('layouts.vertical', ["page_title"=> "Tour | Hopscotch"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/hopscotch/hopscotch.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extended UI</a></li>
                        <li class="breadcrumb-item active">Tour</li>
                    </ol>
                </div>
                <h4 class="page-title" id="page-title-tour">Tour</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="77" style="padding-bottom: 5%;" id="logo-tour">
                    </div>

                    <h1 id="display-title-tour">This is a Heading 1</h1>
                    <p class="text-muted">Suspendisse vel quam malesuada, aliquet sem sit
                        amet, fringilla elit. Morbi
                        tempor tincidunt tempor. Etiam id turpis viverra, vulputate sapien
                        nec,
                        varius sem. Curabitur ullamcorper fringilla eleifend. In ut eros
                        hendrerit
                        est consequat posuere et at velit.</p>

                    <div class="clearfix"></div>

                    <h2>This is a Heading 2</h2>
                    <p class="text-muted">In nec rhoncus eros. Vestibulum eu mattis nisl.
                        Quisque viverra viverra magna
                        nec pulvinar. Maecenas pellentesque porta augue, consectetur
                        facilisis diam
                        porttitor sed. Suspendisse tempor est sodales augue rutrum
                        tincidunt.
                        Quisque a malesuada purus.</p>

                    <div class="clearfix"></div>

                    <h3>This is a Heading 3</h3>
                    <p class="text-muted">Vestibulum auctor tincidunt semper. Phasellus ut
                        vulputate lacus. Suspendisse
                        ultricies mi eros, sit amet tempor nulla varius sed. Proin nisl
                        nisi,
                        feugiat quis bibendum vitae, dapibus in tellus.</p>

                    <div class="clearfix"></div>

                    <h4>This is a Heading 4</h4>
                    <p class="text-muted">Nulla et mattis nunc. Curabitur scelerisque
                        commodo condimentum. Mauris
                        blandit, velit a consectetur egestas, diam arcu fermentum justo,
                        eget
                        ultrices arcu eros vel erat.</p>

                    <div class="clearfix"></div>

                    <h5>This is a Heading 5</h5>
                    <p class="text-muted">Quisque nec turpis at urna dictum luctus.
                        Suspendisse convallis dignissim
                        eros at volutpat. In egestas mattis dui. Aliquam mattis dictum
                        aliquet.
                        Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.
                        Vivamus
                        pretium nec odio cursus elementum. Suspendisse molestie ullamcorper
                        ornare.</p>

                    <div class="clearfix"></div>

                    <h6>This is a Heading 6</h6>
                    <p class="text-muted">Donec ultricies, lacus id tempor condimentum, orci
                        leo faucibus sem, a
                        molestie libero lectus ac justo. ultricies mi eros, sit amet tempor
                        nulla
                        varius sed. Proin nisl nisi, feugiat quis bibendum vitae, dapibus in
                        tellus.</p>


                    <div class="text-center pt-4">
                        <a href="javascript: void(0);" class="btn btn-danger" id="thankyou-tour">Thank you !</a>
                    </div>
                </div>
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/hopscotch/hopscotch.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/tour.init.js')}}"></script>
<!-- end demo js-->
@endsection
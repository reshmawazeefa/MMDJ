@extends('layouts.vertical', ["page_title"=> "User | Edit"])
@section('css')
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet" type="text/css" />

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
                        <li class="breadcrumb-item"><a href="{{url('admin/users')}}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit User</h4>
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
                
                    <!-- <h4 class="header-title">User Form</h4> -->
                    
                    <form role="form" class="parsley-examples" method="post" action="{{url('admin/users/'.$user->id)}}">
                    <div class="card-body body-style">
                        {{csrf_field()}}
                        {{ method_field('PATCH') }}
                        <div class="row mb-2">

                        <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-4 col-form-label">Name<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" name="name" value="{{old('name') ? old('name'):$user->name }}" required class="form-control" placeholder="Name" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="email" name="email" value="{{old('email') ? old('email'):$user->email}}" required placeholder="Email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Is Admin?</label>
                            <div class="col-7">
                                <input type="checkbox" name="roles" value="Admin" @if($userRole == 'Admin') checked @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Contact Number</label>
                            <div class="col-7">
                            <input type="number" name="phone" value="{{old('phone') ? old('phone'):$user->phone}}" required placeholder="phone" class="form-control"  />
                            </div>
                        </div>

                        
                        <!-- <div class="form-group row approver" @if($userRole == 'Admin') style="display:none;" @endif>
                            <label for="hori-pass2" class="col-4 col-form-label">Approver 1</label>
                            <div class="col-7">
                                <select name="approver1" class="userSelect form-control select2">
                                    @if($user->approver_1)<option value="{{$user->approver_1->id}}">{{$user->approver_1->name}}</option>@endif
                                </select>
                            </div>
                        </div> -->

                        </div>

                        <div class="col-lg-6">  
                            
                        <div class="form-group row">
                            <label for="webSite" class="col-4 col-form-label">Password</label>
                            <!-- <div class="col-7 input-group">
                                <input type="password" name="password" id="password" class="form-control" readonly value="{{ $decryptedPassword }}" />
                                <span class="input-group-text toggle-password" data-target="#password" style="cursor: pointer;">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </span>
                            </div> -->

                            <div class=" col-7 password-wrapper">
                                <input type="password" id="passwordInput" name="passwordInput" readonly placeholder="Enter password"  value="{{ $decryptedPassword }}">
                                <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-11 d-flex justify-content-end mt-2 gap-1">
                                <button type="submit" class="btn btn-primary waves-effect waves-light h-view">Update</button>
                               
                                <button type="button" class="btn btn-secondary cancelbtn  ms-2 h-view" onclick="window.history.back();">Back</button>
                            </div>
                        </div>




                        <!-- <div class="form-group row approver" @if($userRole == 'Admin') style="display:none;" @endif>
                            <label for="hori-pass2" class="col-4 col-form-label">Approver 2</label>
                            <div class="col-7">
                                <select name="approver2" class="userSelect form-control select2">
                                @if($user->approver_2)<option value="{{$user->approver_2->id}}">{{$user->approver_2->name}}</option>@endif
                                </select>
                            </div>
                        </div> -->
                        

                       

                        <div class="form-group row mt-2" style="display: none;">
                            <label for="webSite" class="col-4 col-form-label">Confirm Password</label>
                            <div class="col-7 input-group">
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" readonly value="{{ $decryptedPassword }}" />
                                <span class="input-group-text toggle-password" data-target="#confirmPassword" style="cursor: pointer;">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Include Font Awesome for the eye icon -->
                    


  <script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('passwordInput');

    toggle.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  <style>
    .toggle-password{
        position: absolute!important;
        right: 24px!important;
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] {
      width: 100%;
      font-size: 13px !important;
    height: calc(1em + 0.8rem + .05px);
    padding: 0rem 0.3rem !important;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }
  </style>






                        <!--  -->
                        </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="{{asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<!-- end demo js-->
<script>
$(".userSelect").select2({
    ajax: {
    url: "{{ url('admin/ajax/users') }}",
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
                    text: item.name+'('+item.email+')',
                    id: item.id
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
        placeholder: "By searching name,email",
        allowClear: false,
});
$('input[name="roles"]').change(function(){
    if ($(this).is(':checked')) {
        $('.approver').hide();
    }
    else{
        $('.approver').show();
    }
});

// document.querySelectorAll('.toggle-password').forEach(item => {
//     item.addEventListener('click', function () {
//         const target = document.querySelector(this.getAttribute('data-target'));
//         const icon = this.querySelector('i');

//         // Toggle the password visibility
//         if (target.type === 'password') {
//             target.type = 'text';
//             icon.classList.remove('fa-eye-slash');
//             icon.classList.add('fa-eye');
//         } else {
//             target.type = 'password';
//             icon.classList.remove('fa-eye');
//             icon.classList.add('fa-eye-slash');
//         }
//     });
// });


</script>
@endsection
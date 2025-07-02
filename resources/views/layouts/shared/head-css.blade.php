@yield('css')

<!-- icons -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">

<!-- icons -->
<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />


@if(isset($mode) && $mode == 'rtl')

<!-- App css -->
@if(isset($demo) && $demo == 'creative')
<link href="{{asset('assets/css/config/creative/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/creative/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/creative/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/creative/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'modern')
<link href="{{asset('assets/css/config/modern/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/modern/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/modern/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/modern/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'material')
<link href="{{asset('assets/css/config/material/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/material/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/material/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/material/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'purple')
<link href="{{asset('assets/css/config/purple/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/purple/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/purple/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/purple/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'saas')
<link href="{{asset('assets/css/config/saas/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/saas/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/saas/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/saas/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
<link href="{{asset('assets/css/config/default/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/default/app-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/default/bootstrap-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/default/app-dark-rtl.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@endif
@endif
@endif
@endif
@endif

@else
<!-- App css -->
@if(isset($demo) && $demo == 'creative')
<link href="{{asset('assets/css/config/creative/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/creative/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/creative/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/creative/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'modern')
<link href="{{asset('assets/css/config/modern/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/modern/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/modern/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/modern/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'material')
<link href="{{asset('assets/css/config/material/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/material/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/material/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/material/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'purple')
<link href="{{asset('assets/css/config/purple/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/purple/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/purple/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/purple/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
@if(isset($demo) && $demo == 'saas')
<link href="{{asset('assets/css/config/saas/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/saas/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/saas/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/saas/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@else
<link href="{{asset('assets/css/config/default/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{asset('assets/css/config/default/app.min.css')}} " rel="stylesheet" type="text/css" id="app-default-stylesheet" />
<link href="{{asset('assets/css/config/default/bootstrap-dark.min.css')}} " rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
<link href="{{asset('assets/css/config/default/app-dark.min.css')}} " rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />
@endif
@endif
@endif
@endif
@endif
@endif
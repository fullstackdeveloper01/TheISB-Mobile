<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/extra/colors.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/extra/extra.css') }}">
@stack('styles_libs')
<link rel="stylesheet" href="{{ asset('assets/css/user/application.css') }}">
@stack('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extra/custom.css') }}">
<style type="text/css">
   .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      display: none;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: 0.4s;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: 0.4s;
      transition: 0.4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #4ac721;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #4ac721;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
</style>

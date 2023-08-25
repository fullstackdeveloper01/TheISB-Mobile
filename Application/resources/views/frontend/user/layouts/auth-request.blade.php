<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('frontend.user.includes.head')
    @include('frontend.user.includes.styles')
</head>

<body>
    <div class="vr__page @yield('bg')">
        <div class="vr__form__aria">
            @yield('content')
        </div>
    </div>
    @include('frontend.configurations.config')
    @include('frontend.configurations.widgets')
    @include('frontend.user.includes.scripts')
    {!! google_captcha() !!}
    @include('frontend.user.includes.toastr')
</body>

</html>

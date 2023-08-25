@extends('frontend.user.layouts.dash')
@section('title', lang('Dashboard', 'user'))
@section('search', true)
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-lg-3">
            <div class="vr__counter__box bg-success h-100">
                <div class="bx mb-3">
                    <h3 class="vr__counter__box__title">{{ lang('Available', 'user') }}</h3>
                    <p class="vr__counter__box__number">
                        0
                    </p>
                    <span class="vr__counter__box__icon pb-2 pe-3">
                        <i class="fas fa-database"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="vr__counter__box bg-danger h-100">
                <div class="bx mb-3">
                    <h3 class="vr__counter__box__title">{{ lang('Booked', 'user') }}</h3>
                    <p class="vr__counter__box__number">
                        0
                    </p>
                    <span class="vr__counter__box__icon pb-2 pe-3">
                        <i class="fas fa-book"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="vr__counter__box bg-warning h-100">
                <div class="bx mb-3">
                    <h3 class="vr__counter__box__title">{{ lang('Incoming-today', 'user') }}</h3>
                    <p class="vr__counter__box__number">
                        0
                    </p>
                    <span class="vr__counter__box__icon pb-2 pe-3">
                        <i class="fas fa-credit-card"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="vr__counter__box bg-secondary h-100">
                <div class="bx mb-2">
                    <h3 class="vr__counter__box__title">{{ lang('Leaving-today', 'user') }}</h3>
                    <p class="vr__counter__box__number">0</p>
                    <span class="vr__counter__box__icon pb-2 pe-3">
                        <i class="fas fa-paper-plane"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    {{--
    <h5 class="fs-5 mb-4">{{ lang('Your transfers', 'user') }}</h5>
    @include('frontend.user.includes.transfers')
    --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <h5 class="fs-5 mb-4">{{ lang('Incoming-today', 'user') }}</h5>
            @include('frontend.user.includes.empty')
        </div>
        <div class="col-lg-4">
            <h5 class="fs-5 mb-4">{{ lang('Latest Booked', 'user') }}</h5>
            @include('frontend.user.includes.empty')
        </div>
        <div class="col-lg-4">
            <h5 class="fs-5 mb-4">{{ lang('Queue of the boats', 'user') }}</h5>
            @include('frontend.user.includes.empty')
        </div>
    </div>
    @if(!empty($user->address->address_1))
        <div class="row g-3 mb-4">
            <div class="col-lg-12">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="1250" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q={{ @$user->address->latitude }},%20{{ @$user->address->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://embedgooglemap.net/124/">Framesport</a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:1250px;}</style><a href="https://www.embedgooglemap.net"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1250px;}</style></div></div>
            </div>
        </div>
    @endif
@endsection

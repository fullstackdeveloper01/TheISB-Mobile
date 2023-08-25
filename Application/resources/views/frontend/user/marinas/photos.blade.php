@extends('frontend.user.layouts.dash')
@section('title', lang('Photos', 'user'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-3">
                @include('frontend.user.marinas.sidebar')
            </div>
            <div class="col-xl-9">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <div class="row">
                                <div class="col-lg-2">
                                    <a href="{{ route('user.marinasProfile') }}" class="btn btn-default btn-sm">Marina Details</a>
                                </div>
                                {{--<div class="col-lg-2">
                                    <a href="{{ route('user.marinasBerthSpaces') }}" class="btn btn-default btn-sm">Berth Spaces</a>
                                </div>--}}
                                <div class="col-lg-2">
                                    <a href="{{ route('user.marinasAmenities') }}" class="btn btn-default btn-sm">Amenities</a>
                                </div>
                                <div class="col-lg-2">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm">Slider</a>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-auto" style="float: right;">
                                        <a href="{{ route('user.marinasPhotosAdd')}}" class="btn btn-secondary me-2"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="vr__settings__box__body">
                            @include('frontend.user.marinas.tab.photos')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

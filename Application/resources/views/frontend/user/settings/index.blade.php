@extends('frontend.user.layouts.dash')
@section('title', lang('Settings', 'user'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-3">
                @include('frontend.user.includes.list')
            </div>
            <div class="col-xl-9">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ lang('Account details', 'user') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.settings.details.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">{{ lang('Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="{{ lang('Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    {{--<div class="col">
                                        <label class="form-label">{{ lang('Last Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="lastname" name="lastname" class="form-control"
                                            placeholder="{{ lang('Last Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->lastname }}" required>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ lang('Email address', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="{{ lang('Email address', 'forms') }}" value="{{ $user->email }}" readonly required>
                                    </div>
                                    <div class="col-lg-6" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Username', 'forms') }} : </label>
                                            <input class="form-control" placeholder="{{ lang('Username', 'forms') }}"
                                                value="{{ $user->username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Phone Number', 'forms') }} : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ lang('Phone Number', 'forms') }}"
                                                    value="{{ $user->mobile }}" readonly>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#mobileModal"
                                                    type="button">{{ lang('Change', 'user') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ lang('Address line 1', 'forms') }} : <span class="red">*</span></label>
                                    <input type="text" name="address_1" value="{{ @$user->address->address_1 }}" id="full_address" class="form-control" required onFocus="geolocate()">
                                    <input type="hidden" id="latitude" name="latitude" value="{{ @$user->address->latitude }}" >
                                    <input type="hidden" id="longitude" name="longitude" value="{{ @$user->address->longitude }}" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ lang('Address line 2', 'forms') }} :</label>
                                    <input type="text" name="address_2" class="form-control"
                                        placeholder="{{ lang('Apartment, suite, etc. (optional)', 'forms') }}"
                                        value="{{ @$user->address->address_2 }}">
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Country', 'forms') }} : <span class="red">*</span></label>
                                            <select name="country" class="form-select" required>
                                                @foreach (countries() as $country)
                                                    @if($country->id == 110)
                                                        <option value="{{ $country->id }}"
                                                            @if ($country->name == @$user->address->country) selected @endif>
                                                            {{ $country->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('City') }} :<span class="red">*</span></label>
                                            <select name="city_id" class="form-select select2" required>
                                                <option value=""></option>
                                                @foreach ($cityList as $city)
                                                    <option value="{{ $city->id }}" {{ ($user->city_id == $city->id)?"selected":"" }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('State', 'forms') }} : <span
                                                    class="red">*</span></label>
                                            <input type="text" name="state" class="form-control"
                                                value="{{ @$user->address->state }}">
                                        </div>
                                    </div>--}}
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Postal code', 'forms') }} : <span
                                                    class="red">*</span></label>
                                            <input type="text" name="zip" class="form-control"
                                                value="{{ @$user->address->zip }}" required>
                                        </div>
                                    </div>
                                </div>                                
                                <button class="btn btn-secondary"><i class="far fa-save"></i>
                                    {{ lang('Save Changes', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mobileModal" tabindex="-1" aria-labelledby="mobileModalLabel"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('user.settings.details.mobile.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ lang('Phone Number', 'forms') }} : <span
                                    class="red">*</span></label>
                            <div class="form-number">
                                <select id="mobile_code" name="mobile_code" class="form-select flex-shrink-0 w-auto">
                                    @foreach (countries() as $country)
                                        @if($country->id == 110)
                                            <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                                value="{{ $country->id }}" @if ($country->name == @$user->address->country) selected @endif>
                                                {{ $country->code }}
                                                ({{ $country->phone }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <input id="mobile" type="tel" name="mobile" class="form-control"
                                    placeholder="{{ lang('Phone Number', 'forms') }}" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit"
                                class="btn btn-secondary w-100 me-2">{{ lang('Save', 'user') }}</button>
                            <button type="button" class="btn btn-primary w-100 ms-2"
                                data-bs-dismiss="modal">{{ lang('Close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

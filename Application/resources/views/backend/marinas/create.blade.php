@extends('backend.layouts.form')
@section('title', 'Add new marina')
@section('container', 'container-max-lg')
@section('back', route('admin.marinas.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.marinas.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="avatar text-center py-4" style="display: none;">
                    <img id="filePreview" src="{{ asset('images/avatars/default.png') }}" class="rounded-circle mb-3"
                        width="120px" height="120px">
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary d-flex m-auto">{{ __('Choose Image') }}</button>
                    <input id="selectedFileInput" type="file" name="avatar" accept="image/png, image/jpg, image/jpeg"
                        hidden>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Marina Name') }} :<span
                                    class="red">*</span></label>
                            <input type="firstname" name="firstname" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6" style="display:none;">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Marina Lastname') }} :<span
                                    class="red">*</span></label>
                            <input type="lastname" name="lastname" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('E-mail Address') }} :<span
                                    class="red">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                {{--<div class="mb-3">
                    <label class="form-label">{{ __('Username') }} :<span class="red">*</span></label>
                    <input type="username" name="username" class="form-control" required>
                </div>--}}
                <div class="mb-3" style="display:none;">
                    <label class="form-label">{{ __('Country') }} :<span class="red">*</span></label>
                    <select name="country" class="form-select" required>
                        <option value="" selected disabled>{{ __('Choose') }}</option>
                        @foreach (countries() as $country)
                            @if($country->id == 110)
                                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Phone number') }} :<span class="red">*</span></label>
                            <div class="form-number d-flex">
                                <select name="mobile_code" class="form-select flex-shrink-0 w-auto" required>
                                    @foreach (countries() as $country)
                                        @if($country->id == 110)
                                            <option value="{{ $country->id }}">{{ $country->code }} ({{ $country->phone }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="tel" name="mobile" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('City') }} :<span class="red">*</span></label>
                            <select name="city_id" class="form-select select2" required>
                                <option value=""></option>
                                @foreach ($cityList as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }} :<span class="red">*</span></label>
                    <input type="text" name="password" class="form-control" value="{{ $password }}" required>
                </div>
            </form>
        </div>
    </div>
@endsection

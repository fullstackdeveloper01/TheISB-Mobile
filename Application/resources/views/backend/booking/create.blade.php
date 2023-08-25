@extends('backend.layouts.form')
@section('title', 'Add new service')
@section('container', 'container-max-lg')
@section('back', route('admin.services.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Image') }} :<span class="red">*</span></label>
                            <input type="file" name="service_icon" accept="image/png, image/jpg, image/jpeg" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Service') }} :<span class="red">*</span></label>
                            <input type="text" name="service_name" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Select Marina') }} :<span class="red">*</span></label>
                            <select name="marina_id" id="marina_id" class="form-control select2" required>
                                <option value="">Select Marina</option>
                                @if($marinaList)
                                    @foreach($marinaList as $marina)
                                        <option value="{{ $marina->id }}">{{ $marina->firstname.' '.$marina->lastname }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Category') }} :<span class="red">*</span></label>
                            <select name="category_id" id="category_id" class="form-control select2" required>
                                <option value="">Select category</option>
                                @if($categoryList)
                                    @foreach($categoryList as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Sub Category') }} :<span class="red">*</span></label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control select2" required>
                                <option value="">Select sub category</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Distance from Port') }} :<span class="red">*</span></label>
                            <input type="text" name="distance" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Contact Number') }} :<span class="red">*</span></label>
                            <input type="number" name="contact_number" maxlength="12" class="form-control number" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Location') }} :<span class="red">*</span></label>
                            <input type="text" name="address" id="full_address" class="form-control" required onFocus="geolocate()">
                            <input type="hidden" id="latitude" name="latitude" value="">
                            <input type="hidden" id="longitude" name="longitude" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Short Description') }} :<span class="red">*</span><small>(UP TO 200 characters)</small></label>
                            <textarea class="form-control" name="heading" maxlength="200" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Full Description') }} :<span class="red">*</span> <small>(UP TO 500 characters)</small></label>
                            <textarea class="form-control" name="description" rows="5" maxlength="500" required></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

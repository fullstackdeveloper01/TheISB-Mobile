@extends('backend.layouts.form')
@section('title', $service->name)
@section('back', route('admin.services.index'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Banned') }}" @if ($service->status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Image') }}</label><br>
                                    <input type="file" name="service_icon" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <img src="{{ asset($service->service_icon) }}" height="100px" alt="Service" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Service') }} :<span class="red">*</span></label>
                                    <input type="text" name="service_name" value="{{ $service->service_name }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Select Marinas') }} :<span class="red">*</span></label>
                                    <select name="marina_id[]" id="marina_id" class="form-control select2" multiple required>
                                        <option value="">Select Marina</option>
                                        @if($marinaList)
                                            @foreach($marinaList as $marina)
                                                @if(in_array($marina->id, $selectedMarina))
                                                    <option value="{{ $marina->id }}" selected>{{ $marina->firstname }}</option>
                                                @else
                                                    <option value="{{ $marina->id }}">{{ $marina->firstname }}</option>
                                                @endif
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
                                                <option value="{{ $cat->id }}" {{ ($cat->id == $service->category_id )?'selected':'' }}>{{ $cat->name }}</option>
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
                                        @if($subCategoryList)
                                            @foreach($subCategoryList as $cat)
                                                @if($service->category_id == $cat->parent_id)
                                                    <option value="{{ $cat->id }}" {{ ($cat->id == $service->sub_category_id )?'selected':'' }}>{{ $cat->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Distance from Port') }} :<span class="red">*</span></label>
                                    <input type="text" name="distance" value="{{ $service->distance }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Contact Number') }} :<span class="red">*</span></label>
                                    <input type="number" name="contact_number" maxlength="12" value="{{ $service->contact_number }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Location') }} :<span class="red">*</span></label>
                                    <input type="text" name="address" id="full_address" class="form-control" value="{{ $service->address }}" required onFocus="geolocate()">
                                    <input type="hidden" id="latitude" name="latitude" value="{{ $service->latitude }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ $service->longitude }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Short Description') }} :<span class="red">*</span></label>
                                    <textarea class="form-control" name="heading" maxlength="200" rows="3" required>{{ $service->heading }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Full Description') }} :<span class="red">*</span></label>
                                    <textarea class="form-control" name="description" rows="5" maxlength="500" required>{{ $service->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

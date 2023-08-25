@extends('backend.layouts.form')
@section('title', $slider->title)
@section('back', route('admin.sliders.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sliders.update', $slider->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <div class="row md-3">
                            <div class="col-lg-6 md-3">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                                    <input type="text" name="title" id="create_slug" class="form-control"
                                        value="{{ $slider->title }}" required />
                                </div>
                            </div>
                            <div class="col-lg-4 md-3">
                                <label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
                                <select class="form-control select2" name="redirection" required="">
                                    <option value=""></option>
                                    <option value="leave" {{ ($slider->redirection == "leave")?"selected":"" }}>Leave</option>
                                    <option value="noticeboard" {{ ($slider->redirection == "noticeboard")?"selected":"" }}>Noticeboard</option>
                                    <option value="bus_route" {{ ($slider->redirection == "bus_route")?"selected":"" }}>Bus Routes</option>
                                    <option value="school_rule" {{ ($slider->redirection == "school_rule")?"selected":"" }}>School Rule</option>
                                    <option value="query" {{ ($slider->redirection == "query")?"selected":"" }}>Query</option>
                                </select>
                            </div>
                        </div>
                        <div class="row md-3">
                            <div class="col-lg-6 md-3">
                                <label class="form-label">Icon : <span class="red">*</span> <small class="text-muted">Allowed (PNG, JPG, JPEG)</small></label>
                                <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            </div>
                            <div class="col-lg-4 md-3">
                                <img src="{{ asset($slider->image) }}" class="img-responsive" height="100px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

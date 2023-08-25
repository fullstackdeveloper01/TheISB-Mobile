@extends('backend.layouts.form')
@section('title', __('Create Slider'))
@section('back', route('admin.sliders.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2 mb-3">
                    <div class="card-body">
						<div class="row md-3">
							<div class="col-lg-6 md-3">
								<label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
								<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus />
							</div>
							<div class="col-lg-4 md-3">
								<label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
								<select class="form-control select2" name="redirection" required="">
									<option value=""></option>
									<option value="leave">Leave</option>
									<option value="noticeboard">Noticeboard</option>
									<option value="bus_route">Bus Routes</option>
									<option value="school_rule">School Rule</option>
									<option value="query">Query</option>
								</select>
							</div>
						</div>
						<div class="row md-3">
							<div class="col-lg-6 md-3">
								<label class="form-label">Icon : <span class="red">*</span> <small class="text-muted">Allowed (PNG, JPG, JPEG)</small></label>
                                <input type="file" name="image" required class="form-control" accept="image/png, image/jpg, image/jpeg">
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            //let GET_SLUG_URL = "{{ route('articles.slug') }}";
        </script>
    @endpush
@endsection

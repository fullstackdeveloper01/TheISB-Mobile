@extends('backend.layouts.form')
@section('title', __('Create Highlighter'))
@section('back', route('admin.highlighters.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.highlighters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus />
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ __('Description') }} : <span class="red">*</span></label>
                            <textarea name="content" id="content" rows="10" class="form-control" required>{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                            <div class="file-preview-box mb-3 d-none">
                                <img id="filePreview" src="#" class="rounded-3 w-100" height="160px">
                            </div>
                            <button id="selectFileBtn" type="button"
                                class="btn btn-secondary mb-2">{{ __('Choose Image') }}</button>
                            <input id="selectedFileInput" type="file" name="image"
                                accept="image/png, image/jpg, image/jpeg" hidden required>
                            <small class="text-muted d-block">{{ __('Allowed (PNG, JPG, JPEG)') }}</small>
                            <small class="text-muted d-block">{{ __('Image will be resized into (1280x720)') }}</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ __('Short description') }} : <span class="red">*</span></label>
                            <textarea name="short_description" rows="6" class="form-control" maxlength="200" placeholder="{{ __('50 to 200 character at most') }}" required>{{ old('short_description') }}</textarea>
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

@extends('backend.layouts.form')
@section('title', __('Create Gallery'))
@section('back', route('admin.galleries.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.galleries.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card p-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required
                            autofocus />
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="form-label">{{ __('Type') }} : <span class="red">*</span></label>
                        <select name="item_type" class="form-select" required onchange="setGalletType(this.value)">
                            <option value="1">Photos</option>
                            <option value="2">Videos</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="slideshow-upload mt-3"> 
                    <div class="gallerytype_" id="gallerytype_1">
                        <label class="form-label">Upload Photos : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                        <input type="file" name="item_photos[]" multiple class="form-control" accept="image/png, image/jpg, image/jpeg" autofocus>
                    </div>
                    <div class="gallerytype_" id="gallerytype_2" style="display: none;">
                        <label class="form-label">Upload Video URL : <span class="red">*</span></label>
                        <input type="url" name="item_videos" id="item_videos" class="form-control {{ $errors->has('item_videos') ? ' is-invalid' : '' }}" autofocus>
                    </div>
                </div>
                <!-- <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                    <div class="file-preview-box mb-3 d-none">
                        <img id="filePreview" src="#" class="rounded-3" height="100" width="100">
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2">{{ __('Choose File') }}</button>
                    <input id="selectedFileInput" type="file" name="image" accept="video/MP4, video/MP4" hidden required>
                    <small class="text-muted d-block">{{ __('Allowed (PNG, JPG, JPEG)') }}</small>
                    <small class="text-muted d-block">{{ __('Allowed (MP4, WEBM)') }}</small>
                </div> -->
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            //let GET_SLUG_URL = "{{ route('articles.slug') }}";
            
            function setGalletType(gtype){
                $('.gallerytype_').css('display', 'none');
                if(gtype){
                    $('#gallerytype_'+gtype).css('display', 'block');
                }
            }
        </script>
    @endpush
@endsection

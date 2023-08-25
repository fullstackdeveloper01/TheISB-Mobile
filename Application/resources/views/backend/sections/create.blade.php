@extends('backend.layouts.form')
@section('section', __('Sections'))
@section('title', __('Create new section'))
@section('container', 'container-max-lg')
@section('back', route('admin.sections.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">  
                    <div class="col-md-10 mb-3">
                        <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">{{ __('Title Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="title_color" id="title_color" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">    
                    <div class="col-lg-4">
                        <label class="form-label">{{ __('BG Type') }} : <span class="red">*</span></label>
                        <select class="form-control select2" name="bg_type" required onchange="setGalletType(this.value)">
                            <option value="0">Color</option>
                            <option value="1">Image</option>
                        </select>
                    </div>
                    <div class="col-lg-4 bgtype" id="bgtype_0" style="display: block;">
                        <label class="form-label">{{ __('Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="bg_color" id="bg_color" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4 bgtype" id="bgtype_1" style="display: none;">
                        <label class="form-label">{{ __('Image') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                        <input type="file" name="image" id="bg_image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ __('Section Type') }} : <span class="red">*</span></label>
                        <select class="form-control select2" name="section_type" required>
                            <option value=""></option>
                            <option value="0">Slider</option>
                            <option value="1">Video</option>
                            <option value="2">Other</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";
            $(function() {
                $('.vironeer-color-picker').colorpicker();
            });

            function setGalletType(gtype){
                $('.bgtype').css('display', 'none');
                if(gtype){
                    $('#bgtype_'+gtype).css('display', 'block');
                }
            }
        </script>
    @endpush
@endsection

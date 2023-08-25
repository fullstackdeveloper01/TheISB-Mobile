@extends('backend.layouts.form')
@section('title', __('PopUp Notice'))
@section('container', 'container-max-lg')
@section('content')
<form id="vironeer-submited-form" action="{{ route('admin.additional.notice.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
       <div class="card-body my-2">
          <div class="row">
              <div class="col-lg-2">
                <div class="mb-3">
                    <label class="form-label">{{ __('Status') }} :</label>
                    <input type="checkbox" name="popup_notice_status" data-toggle="toggle" @if($popupNotice->status) checked @endif>
                </div>
              </div>
          </div>
          <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                <div class="file-preview-box mb-3">
                    <img id="filePreview" src="{{ asset($popupNotice->image) }}" class="rounded-3" height="100"
                        width="100">
                </div>
                <button id="selectFileBtn" type="button"
                    class="btn btn-secondary mb-2">{{ __('Choose Image') }}</button>
                <input id="selectedFileInput" type="file" name="image" accept="image/png, image/jpg, image/jpeg"
                    hidden>
                <small class="text-muted d-block">{{ __('Allowed (PNG, JPG, JPEG)') }}</small>
                <small class="text-muted d-block">{{ __('Image will be resized into (1021x1600)') }}</small>
            </div>
          {{--<div class="mb-0">
             <label class="form-label">{{ __('PopUp description') }} :</label>
             <textarea name="popup_notice_description" id="content-small" rows="10" class="form-control"></textarea>
          </div>--}}
       </div>
    </div>
</form>
@endsection
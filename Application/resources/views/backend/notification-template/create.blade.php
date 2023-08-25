@extends('backend.layouts.form')
@section('title', 'Add Notification Template')
@section('back', route('admin.notificationTemplate.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.notificationTemplate.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Message') }} :<span class="red">*</span></label>
                            <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

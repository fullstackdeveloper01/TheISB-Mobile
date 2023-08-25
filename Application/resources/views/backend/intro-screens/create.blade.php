@extends('backend.layouts.form')
@section('title', 'Add new intro screens')
@section('container', 'container-max-lg')
@section('back', route('admin.introScreens.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.introScreens.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Image') }} :<span class="red">*</span></label>
                            <input type="file" name="screen" accept="image/png, image/jpg, image/jpeg" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                            <input type="text" name="title" class="form-control" maxlength="150" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

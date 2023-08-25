@extends('backend.layouts.form')
@section('title', 'Edit advertisement')
@section('back', route('admin.advertisement.index'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.advertisement.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Banned') }}" @if ($advertisement->status) checked @endif>
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
                                    <input type="file" name="image" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <img src="{{ asset($advertisement->image) }}" height="100px" alt="Advertisement" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                                    <input type="text" name="title" value="{{ $advertisement->title }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('backend.layouts.form')
@section('back', route('admin.settings.index'))
@section('title', 'Splash Screen')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.splashScreen.update', $splashScreen->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Inactive') }}" @if ($splashScreen->status) checked @endif>
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
                                    <img src="{{ asset($splashScreen->image) }}" height="100px" alt="splashScreen" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

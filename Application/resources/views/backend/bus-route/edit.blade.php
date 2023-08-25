@extends('backend.layouts.form')
@section('back', route('admin.settings.index'))
@section('title', 'Bus Route')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.busRoute.update', $busRoute->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Inactive') }}" @if ($busRoute->status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('File') }}</label><br>
                                    <input type="file" name="image" accept="application/pdf, application/PDF">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <a href="{{ asset($busRoute->image) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

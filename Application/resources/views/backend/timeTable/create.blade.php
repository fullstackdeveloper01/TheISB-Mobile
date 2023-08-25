@extends('backend.layouts.form')
@section('title', 'Add new amenity')
@section('container', 'container-max-lg')
@section('back', route('admin.amenities.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.amenities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Icon') }} :<span class="red">*</span></label>
                            <input type="file" name="icon" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Amenity') }} :<span
                                    class="red">*</span></label>
                            <input type="text" name="amenity" class="form-control" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

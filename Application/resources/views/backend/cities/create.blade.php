@extends('backend.layouts.form')
@section('title', 'Add new city')
@section('container', 'container-max-lg')
@section('back', route('admin.cities.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.cities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }} :<span
                                    class="red">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

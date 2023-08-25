@extends('backend.layouts.form')
@section('title', __('Create Redirection'))
@section('back', route('admin.redirection.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.redirection.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card p-2">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required autofocus />
                </div>
            </div>
        </div>
    </form>
@endsection

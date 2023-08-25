@extends('backend.layouts.form')
@section('title', $redirection->title)
@section('back', route('admin.redirection.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.redirection.update', $redirection->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
		<div class="row mb-3">
			<div class="col-lg-4 my-1">
				<label class="form-label">{{ __('Account status') }} : </label>
				<input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" @if ($redirection->status) checked @endif>
			</div>
		</div>
        <div class="card p-2">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ $redirection->title }}" required autofocus />
                </div>
            </div>
        </div>
    </form>
@endsection

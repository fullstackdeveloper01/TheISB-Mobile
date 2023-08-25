@extends('backend.layouts.form')
@section('title', $complaintType->title)
@section('back', route('admin.complaintType.index'))
@section('content')
	<form id="vironeer-submited-form" action="{{ route('admin.complaintType.update', $complaintType->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
            	<div class="row mb-3">
            		<div class="col-lg-6">            			
	                    <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
	                    <input type="text" name="title" class="form-control" value="{{ $complaintType->title }}" required>	
            		</div>
            	</div>
            </div>
        </div>
    </form>
@endsection

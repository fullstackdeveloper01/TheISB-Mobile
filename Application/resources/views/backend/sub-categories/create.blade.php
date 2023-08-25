@extends('backend.layouts.form')
@section('title', 'Add new sub-category')
@section('container', 'container-max-lg')
@section('back', route('admin.subCategories.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.subCategories.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Category') }} :<span class="red">*</span></label>
                            <select name="parent_id" class="form-control select2" required>
                                <option value="">Select category </option>
                                @if($categoryList)
                                    @foreach($categoryList as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
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

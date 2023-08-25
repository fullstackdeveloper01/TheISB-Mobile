@extends('backend.layouts.form')
@section('title', $category->name)
@section('back', route('admin.subCategories.index'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.subCategories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Banned') }}" @if ($category->status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Category') }} :<span class="red">*</span></label>
                                    <select name="parent_id" class="form-control select2" required>
                                        <option value="">Select category </option>
                                        @if($categoryList)
                                            @foreach($categoryList as $cat)
                                                <option value="{{ $cat->id }}" {{ ($category->parent_id == $cat->id)?'selected':'' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Name') }} :<span
                                            class="red">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $category->name }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

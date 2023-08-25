@extends('frontend.user.layouts.dash')
@section('title', 'Add new Operator')
@section('back', route('user.operators'))
@section('content')
    <div class="vr__settings__v2">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ lang('Account details', 'user') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.operator.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ lang('First Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="firstname" class="form-control" placeholder="{{ lang('First Name', 'forms') }}" maxlength="50" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ lang('Last Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="lastname" class="form-control" placeholder="{{ lang('Last Name', 'forms') }}" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ lang('Email address', 'forms') }} : <span class="red">*</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="{{ lang('Email address', 'forms') }}" required maxlength="80">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Phone Number', 'forms') }} : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="mobile" maxlength="12" placeholder="{{ lang('Phone Number', 'forms') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-secondary"><i class="far fa-save"></i>
                                    {{ lang('Save', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

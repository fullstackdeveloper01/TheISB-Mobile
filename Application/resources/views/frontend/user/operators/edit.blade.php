@extends('frontend.user.layouts.dash')
@section('title', lang('Edit Operator', 'user'))
@section('back', route('user.operators'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ lang('Account details', 'user') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.operator.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ lang('First Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="firstname" value="{{ @$user->firstname }}" class="form-control" placeholder="{{ lang('First Name', 'forms') }}" maxlength="50" required>
                                        <input type="hidden" name="id" value="{{ @$user->id }}" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ lang('Last Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="lastname" value="{{ @$user->lastname }}" class="form-control" placeholder="{{ lang('Last Name', 'forms') }}" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ lang('Phone Number', 'forms') }} : </label>
                                            <div class="input-group">
                                                <input type="text" value="{{ @$user->mobile }}" class="form-control" name="mobile" maxlength="12" placeholder="{{ lang('Phone Number', 'forms') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ lang('Status', 'forms') }} : <span class="red">*</span></label>
                                        <select class="form-control" name="status" id="status">
                                            <option value=""></option>
                                            <option value="1" {{ ($user->status == 1)?"selected":""}}>Active</option>
                                            <option value="0" {{ ($user->status == 0)?"selected":""}}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-secondary"><i class="far fa-save"></i>
                                    {{ lang('Update', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

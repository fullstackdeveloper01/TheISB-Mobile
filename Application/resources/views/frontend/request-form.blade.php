@extends('frontend.user.layouts.auth-request-bg')
@section('title', lang('Request Form', 'user'))
@section('content')
    <div class="vr__sign__form vr__register">
        <div class="vr__sign__header text-white">
            <p class="h3 mb-1">{{ lang('Ready to get on board?', 'user') }}</p>
            <p class="h3 mb-1">{{ lang('Take your marina to the next level', 'user') }}</p>
            <p class="mb-0">{{ lang('Fill this form to request for marina account.', 'user') }}</p>
        </div>
        <div class="sign-body">
            <form action="{{ url('requestForm') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input id="firstname" type="firstname" name="firstname" class="form-control" placeholder="{{ lang('Marina Name', 'forms') }}" maxlength="50" value="{{ old('firstname') }}" required>
                    <label>{{ lang('Marina Name', 'forms') }}</label>
                </div>
                {{--<div class="form-floating mb-3">
                    <input id="username" type="username" name="username" class="form-control"
                        placeholder="{{ lang('Username', 'forms') }}" minlength="6" maxlength="50"
                        value="{{ old('username') }}" required>
                    <label>{{ lang('Username', 'forms') }}</label>
                </div>--}}
                <div class="form-floating mb-3">
                    <select id="country" name="country" class="form-select" required>
                        @foreach (countries() as $country)
                            @if($country->id == 110)
                                <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                    value="{{ $country->id }}" @if ($country->id == old('country')) selected @endif>
                                    {{ $country->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <label>{{ lang('Country', 'forms') }}</label>
                </div>
                <div class="form-number mb-3">
                    <select id="mobile_code" name="mobile_code" class="form-select flex-shrink-0 w-auto">
                        @foreach (countries() as $country)
                            @if($country->id == 110)
                                <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                    value="{{ $country->id }}" @if ($country->id == old('mobile_code')) selected @endif>
                                    {{ $country->code }}
                                    ({{ $country->phone }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <div class="form-floating w-100">
                        <input id="mobile" type="tel" name="mobile" class="form-control"
                            placeholder="{{ lang('Phone Number', 'forms') }}" value="{{ old('mobile') }}" required>
                        <label>{{ lang('Phone Number', 'forms') }}</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input id="email" type="email" name="email" class="form-control"
                        placeholder="{{ lang('Email address', 'forms') }}" value="{{ old('email') }}" required>
                    <label>{{ lang('Email address', 'forms') }}</label>
                </div>
                {{--<div class="form-floating mb-3">
                    <input id="password" type="password" name="password" class="form-control"
                        placeholder="{{ lang('Password', 'forms') }}" minlength="8" required>
                    <label>{{ lang('Password', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                        placeholder="{{ lang('Confirm password', 'forms') }}" minlength="8" required>
                    <label>{{ lang('Confirm password', 'forms') }}</label>
                </div>--}}
                @if ($settings['terms_of_service_link'])
                    <div class="form-check mb-3">
                        <input id="terms" name="terms" class="form-check-input" type="checkbox"
                            @if (old('terms')) checked @endif required>
                        <label class="form-check-label">
                            {{ lang('I agree to the', 'user') }} <a href="{{ $settings['terms_of_service_link'] }}"
                                class="vr__link__color">{{ lang('terms of service', 'user') }}</a>
                        </label>
                    </div>
                @endif
                {!! display_captcha() !!}
                <div class="d-flex">
                    <button class="btn btn-secondary btn-lg w-100">{{ lang('Submit', 'user') }}</button>
                </div>
                {!! facebook_login() !!}
            </form>
        </div>
    </div>
@endsection

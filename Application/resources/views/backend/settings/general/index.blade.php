@extends('backend.layouts.form')
@section('title', __('Account'))
@section('section', __('Settings'))
@section('back', route('admin.settings.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.general.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf        
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Project Overview') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="app_heading_2" class="form-control" readonly value="{{ $appVersion['0']['heading'] }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version_2" class="form-control" value="{{ $appVersion['0']['app_version'] }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="app_heading_3" class="form-control" readonly value="{{ $appVersion['1']['heading'] }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version_3" class="form-control" value="{{ $appVersion['1']['app_version'] }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="app_heading_4" class="form-control" readonly value="{{ $appVersion['2']['heading'] }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version_4" class="form-control" value="{{ $appVersion['2']['app_version'] }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="app_heading_5" class="form-control" readonly value="{{ $appVersion['3']['heading'] }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version_5" class="form-control" value="{{ $appVersion['3']['app_version'] }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="app_heading_6" class="form-control" readonly value="{{ $appVersion['4']['heading'] }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version_6" class="form-control" value="{{ $appVersion['4']['app_version'] }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" style="display:none;">
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Name') }} : <span class="red">*</span></label>
                        <input type="text" name="website_name" class="form-control"
                            value="{{ $settings['website_name'] }}" required>
                    </div>
					<div class="col-lg-6">
                        <label class="form-label">{{ __('App Version ') }}</label>
                        <input type="text" name="app_version" class="form-control">
                    </div>
					<div class="col-lg-12">
                        <label class="form-label">{{ __('App Description') }}</label>
						<textarea name="website_url" class="form-control"></textarea>
                    </div>
				<div style="display:none;">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Site URL') }} : <span class="red">*</span></label>
                        <input type="text" name="website_url" class="form-control" value="{{ $settings['website_url'] }}"
                            required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Contact email') }} : </label>
                        <input type="email" name="contact_email" class="form-control"
                            value="{{ $settings['contact_email'] }}" placeholder="Enter contact email">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Terms of service') }} : <small
                                class="text-muted">({{ __('Used on registration & cookies') }})</small></label>
                        <input type="text" name="terms_of_service_link" class="form-control"
                            value="{{ $settings['terms_of_service_link'] }}" placeholder="Enter link">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Date format') }} : <span class="red">*</span></label>
                        <select name="date_format" class="form-select">
                            @foreach (dateFormatsArray() as $formatKey => $formatValue)
                                <option value="{{ $formatKey }}" @if ($formatKey == $settings['date_format']) selected @endif>
                                    {{ \Carbon\Carbon::now()->format($formatValue) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Website Currency') }} : <span class="red">*</span></label>
                        <select name="website_currency" class="form-select">
                            @foreach (currencies() as $currencyKey => $currencyValue)
                                <option value="{{ $currencyKey }}"
                                    {{ $currencyKey == $settings['website_currency'] ? 'selected' : '' }}>
                                    {{ $currencyValue['name'] }}
                                    ({{ $currencyValue['symbol'] . ' ' . $currencyValue['code'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Timezone') }} : <span class="red">*</span></label>
                        <select name="timezone" class="form-select">
                            @foreach (timezonesArray() as $timezoneKey => $timezoneValue)
                                <option value="{{ $timezoneKey }}" @if ($timezoneKey == $settings['timezone']) selected @endif>
                                    {{ $timezoneValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('Expired subscriptions data delete after') }} : <span
                                class="red">*</span></label>
                        <select name="expired_subscriptions_data_delete" class="form-select">
                            @foreach (timesArr() as $timeKey => $timeValue)
                                <option value="{{ $timeKey }}"
                                    {{ $timeKey == $settings['expired_subscriptions_data_delete'] ? 'selected' : '' }}>
                                    {{ $timeValue }}</option>
                            @endforeach
                        </select>
                    </div>
				</div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Main Section') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ __('App Heading') }} : <span class="red">*</span></label>
                        <input type="text" name="main_section_heading" class="form-control" value="{{ $mainSection->heading }}" required>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">{{ __('App Icon') }}</label>
                        <input type="file" name="main_section_icon">
                    </div>
                    <div class="col-lg-1">
                        <img class="img-responsive" width="75" src="{{ asset($mainSection->icon) }}">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">{{ __('Line Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="main_section_line_color" class="form-control" value="{{ $mainSection->line_color }}" required>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-3">
                        <label class="form-label">{{ __('Main Screen Background') }}</label>
                        <select name="main_section_file_type" class="form-select" required onchange="setFileType(this.value)">
                            <option value="color" {{ ($mainSection->file_type == "color")?"selected":"" }}>Color</option>
                            <option value="bg" {{ ($mainSection->file_type == "bg")?"selected":"" }}>Image</option>
                        </select>
                    </div>
                    <div class="col-lg-3 filetype_" id="filetype_bg" style="display: {{ ($mainSection->file_type == 'bg')?'block':'none'}};">
                        <label class="form-label">{{ __('Background Image') }} : <span class="red">*</span></label>
                        <input type="file" name="main_section_image">                        
                    </div>
                    <div class="col-lg-3 filetype_" id="filetype_color" style="display: {{ ($mainSection->file_type == 'bg')?'none':'block'}};">
                        <label class="form-label">{{ __('Background Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="main_section_file_value" class="form-control" value="{{ $mainSection->file_value }}">
                        </div>
                    </div>
                    <div class="col-lg-3 filetype_">
                        @if(is_file($mainSection->file_value))
                            <img class="img-responsive" src="{{ asset($mainSection->file_value) }}">
                        @endif                     
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Colors Palette') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-12 col-xl-3">
                        <label class="form-label">{{ __('Primary color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="website_primary_color" class="form-control"
                                value="{{ $settings['website_primary_color'] }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-3">
                        <label class="form-label">{{ __('Text Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="website_secondary_color" class="form-control"
                                value="{{ $settings['website_secondary_color'] }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-3">
                        <label class="form-label">{{ __('Accent Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="website_file_icon_dark_color" class="form-control"
                                value="{{ $settings['website_file_icon_dark_color'] }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-3">
                        <label class="form-label">{{ __('Accent Text Color') }} : <span
                                class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="website_file_icon_medium_color" class="form-control"
                                value="{{ $settings['website_file_icon_medium_color'] }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-4" style="display:none;">
                        <label class="form-label">{{ __('File icon light color') }} : <span
                                class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="website_file_icon_light_color" class="form-control"
                                value="{{ $settings['website_file_icon_light_color'] }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" style="display:none;">
            <div class="card-header">
                {{ __('Actions') }}
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Email Verification') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_email_verify_status" data-toggle="toggle"
                            @if ($settings['website_email_verify_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Website Registration') }} : <span
                                class="red">*</span></label>
                        <input type="checkbox" name="website_registration_status" data-toggle="toggle"
                            @if ($settings['website_registration_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Force SSL') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_force_ssl_status" data-toggle="toggle"
                            @if ($settings['website_force_ssl_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('GDPR Cookie') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_cookie" data-toggle="toggle"
                            @if ($settings['website_cookie']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Website blog') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_blog_status" data-toggle="toggle"
                            @if ($settings['website_blog_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Website support tickets') }} : <span
                                class="red">*</span></label>
                        <input type="checkbox" name="website_tickets_status" data-toggle="toggle"
                            @if ($settings['website_tickets_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Website FAQ') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_faq_status" data-toggle="toggle"
                            @if ($settings['website_faq_status']) checked @endif>
                    </div>
                    <div class="col-lg-3 col-xl-3">
                        <label class="form-label">{{ __('Contact Form') }} : <span class="red">*</span></label>
                        <input type="checkbox" name="website_contact_form_status" data-toggle="toggle"
                            @if ($settings['website_contact_form_status']) checked @endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Logo & App Icon') }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="my-3">
                            <div class="vironeer-image-preview bg-light">
                                <img id="vironeer-preview-img-1" src="{{ asset($settings['website_dark_logo']) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="vironeer-image-targeted-input-1" type="file" name="website_dark_logo"
                                accept=".jpg, .jpeg, .png, .svg" class="form-control" hidden>
                            <button data-id="1" type="button"
                                class="vironeer-select-image-button btn btn-secondary btn-lg w-100 mb-2">{{ __('Choose Dark Logo') }}</button>
                            <small class="text-muted">{{ __('Supported (PNG, JPG, JPEG, SVG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-3">
                            <div class="vironeer-image-preview bg-dark">
                                <img id="vironeer-preview-img-2" src="{{ asset($settings['website_light_logo']) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="vironeer-image-targeted-input-2" type="file" name="website_light_logo"
                                accept=".jpg, .jpeg, .png, .svg" class="form-control" hidden>
                            <button data-id="2" type="button"
                                class="vironeer-select-image-button btn btn-secondary btn-lg w-100 mb-2">{{ __('Choose Light Logo') }}</button>
                            <small class="text-muted">{{ __('Supported (PNG, JPG, JPEG, SVG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="my-3">
                            <div class="vironeer-image-preview bg-light">
                                <img id="vironeer-preview-img-3" src="{{ asset($settings['website_favicon']) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="vironeer-image-targeted-input-3" type="file" name="website_favicon"
                                accept=".jpg, .jpeg, .png, .ico" class="form-control" hidden>
                            <button data-id="3" type="button"
                                class="vironeer-select-image-button btn btn-secondary btn-lg w-100 mb-2">{{ __('Choose Favicon') }}</button>
                            <small class="text-muted">{{ __('Supported (PNG, JPG, JPEG, ICO)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3" style="display:none;">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('Social Image') }} <small class="text-muted">{{ __('(og:image)') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="vironeer-image-preview-box bg-light">
                                <img id="vironeer-preview-img-4" src="{{ asset($settings['website_social_image']) }}"
                                    width="100%" height="315px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="vironeer-image-targeted-input-4" type="file" name="website_social_image"
                                accept="image/jpg, image/jpeg" class="form-control" hidden>
                            <button data-id="4" type="button"
                                class="vironeer-select-image-button btn btn-secondary btn-lg w-100 mb-2">{{ __('Choose Social Image') }}</button>
                            <small class="text-muted">
                                {{ __('Supported (JPEG, JPG) Size') }} <strong>600x315px.</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('Home page counters') }}
                    </div>
                    <div class="statistics-box card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label class="form-label">{{ __('Counter status') }} : <span
                                        class="red">*</span></label>
                                <input type="checkbox" name="counter_status" data-toggle="toggle"
                                    @if ($settings['counter_status']) checked @endif>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ __('Active Users') }} : </label>
                                <input type="number" name="active_users_counter" class="form-control"
                                    value="{{ $settings['active_users_counter'] }}" placeholder="0">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ __('Transferred files') }} : </label>
                                <input type="number" name="transferred_files_counter" class="form-control"
                                    value="{{ $settings['transferred_files_counter'] }}" placeholder="0">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ __('Daily visitors') }} : </label>
                                <input type="number" name="daily_visitors_couner" class="form-control"
                                    value="{{ $settings['daily_visitors_couner'] }}" placeholder="0">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ __('All-Time Downloads') }} : </label>
                                <input type="number" name="all_time_downloads_couner" class="form-control"
                                    value="{{ $settings['all_time_downloads_couner'] }}" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";
            $(function() {
                $('.vironeer-color-picker').colorpicker();
            });

            function setFileType(ftype){
                $('.filetype_').css('display', 'none');
                $('#filetype_'+ftype).css('display', 'block');
            }
        </script>
    @endpush
@endsection

@extends('backend.layouts.application')
@section('title', __('Dashboard'))
{{--
@section('access', 'Quick Access')
--}}
@section('content')
    @if (!$settings['mail_status'])
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ __('SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.') }}
            <a href="{{ route('admin.settings.smtp.index') }}">{{ __('Take Action') }}</a>
        </div>
    @endif
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-8 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Students') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalStudents }}</p>
                <small>{{ __('Included inactive students') }}</small>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-9 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Active App User') }}</h3>
                <p class="vironeer-counter-box-number">{{ '0' }}</p>
                <!--<small>{{ __('Included inactive marinas') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-11 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total App Installed') }}</h3>
                <p class="vironeer-counter-box-number">{{ '0' }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-7 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Inactive App User') }}</h3>
                <p class="vironeer-counter-box-number">{{ '0' }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="card vhp-460">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Recent User Login ( IOS )') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li>
                                    <a class="dropdown-item" href="javascript::void()">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @include('backend.includes.emptysmall')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="card vhp-460">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Recent User Login Android') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li>
                                    <a class="dropdown-item" href="javascript::void()">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @include('backend.includes.emptysmall')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="card vhp-460">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Most Viewed Images') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="javascript:void(0)">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
							@include('backend.includes.emptysmall')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="card vhp-460">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Most Viewed Videos') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="javascript:void(0)">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
							@include('backend.includes.emptysmall')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/admin/js/charts.js') }}"></script>
    @endpush
    @push('top_scripts')
        <script type="text/javascript">
            "use strict";
            const WEBSITE_CURRENCY = "{{ currencySymbol() }}";
        </script>
    @endpush
@endsection

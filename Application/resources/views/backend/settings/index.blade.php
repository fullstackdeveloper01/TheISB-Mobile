@extends('backend.layouts.grid')
@section('title', __('Settings'))
@section('container', 'container-max-xl')
@section('content')
    <div class="row g-3 g-xl-3">
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.general') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Account') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __("Manage your website's account settings") }}</p>
                </a>
            </div>
        </div>
        {{--<div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.storage.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-database"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Storage') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Manage and set your website storage') }}</p>
                </a>
            </div>
        </div>--}}
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.busRoute.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Bus Route') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Edit and update bus route information') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('pages.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Pages') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Create and update your website pages') }}</p>
                </a>
            </div>
        </div>
        {{--<div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.marinas.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Marinas') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Add and update your website marinas') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.extensions.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Extensions') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Enable or disable your website extensions') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('languages.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-globe-asia"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Languages') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Add and update your website languages') }}</p>
                </a>
            </div>
        </div>--}}
        {{--<div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.mailtemplates.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-paint-roller"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Mail Templates') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Manage your website mail templates') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('seo.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('SEO Configurations') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Create and manage your seo configurations') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.gateways.index') }}">
                    <div class="text-muted mb-3">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Payment gateways') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Manage your website payment gateways') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.taxes.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-percent"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Taxes') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Manage your website taxes for every country') }}
                    </p>
                </a>
            </div>
        </div>--}}
        {{--<div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.categories.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-th-list"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Category') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Categories master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.subCategories.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-th"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Sub Category') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Sub categories master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.cities.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-map-marker"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Cities') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Capital master') }}
                    </p>
                </a>
            </div>
        </div>--}}
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.redirection.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Redirection') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Redirection') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.splashScreen.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-mobile"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Splash Screen') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Splash Screen master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.introScreens.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Intro Screen') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Intro Screen master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.academicTimeTable.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-file"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Class Time Table') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Class time table master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.academicContent.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Class Academic Content') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Class academic content master') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.homework.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Homework') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Class homework master') }}
                    </p>
                </a>
            </div>
        </div>
    </div>
@endsection

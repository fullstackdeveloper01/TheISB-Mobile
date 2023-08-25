@extends('backend.layouts.application')
@section('title', __('Students List'))
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="vironeer-counter-box bg-success">
                <h3 class="vironeer-counter-box-title">{{ __('Active Students') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalActiveStudent }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="vironeer-counter-box bg-danger">
                <h3 class="vironeer-counter-box-title">{{ __('Inactive Students') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalInactiveStudent }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-ban"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="card">
        {{--<div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="input-group vironeer-custom-input-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search on users...') }}"
                        value="{{ request()->input('search') ?? '' }}" required>
                    <button class="btn btn-secondary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{ __('Filter') }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="{{ request()->url() . '?filter=active' }}">{{ __('Active') }}</a></li>
                        <li><a class="dropdown-item"
                                href="{{ request()->url() . '?filter=banned' }}">{{ __('Banned') }}</a></li>
                    </ul>
                </div>
            </form>
        </div>--}}
        <div>
            @if(count($studentList) > 0)
                <div class="table-responsive">
                    <table id="datatable" class="table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-10x">{{ __('Student Name') }}</th>
                                <th class="tb-w-10x">{{ __('Father Name') }}</th>
                                <th class="tb-w-8x">{{ __('Mobile Number') }}</th>
                                <th class="tb-w-5x">{{ __('Campus') }}</th>
                                <th class="tb-w-3x">{{ __('Shift') }}</th>
                                <th class="tb-w-3x">{{ __('Class') }}</th>
                                <th class="tb-w-3x">{{ __('Section') }}</th>
                                <th class="tb-w-3x">{{ __('Status') }}</th>
                                <th class="tb-w-10x">{{ __('Admission Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentList as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->firstname.' '.$user->middlename.' '.$user->lastname }}</td>
                                    <td>{{ $user->Father_Name }}</td>
                                    <td>{{ $user->Father_Mobile }}</td>
                                    <td>{{ $user->Campus }}</td>
                                    <td>{{ @$user->Shift }}</td>
                                    <td>{{ $user->Class }}</td>
                                    <td>
                                        @if(@$user->payment_status == 1)
                                            {{ __('A1') }}
                                        @elseif(@$user->payment_status == 2)
                                            {{ __('A2') }} 
                                        @elseif(@$user->payment_status == 3)
                                            {{ __('A3') }} 
                                        @elseif(@$user->payment_status == 4)
                                            {{ __('A4') }}
                                        @elseif(@$user->payment_status == 5)
                                            {{ __('A5') }}
                                        @elseif(@$user->payment_status == 6)
                                            {{ __('A6') }}
                                        @else
                                            {{ __('NA') }}
                                        @endif
                                    </td>
                                    <td>{!! userStatus($user->active) !!}</td>
                                    <td>{{ $user->Date_of_Admission }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @include('backend.includes.empty')
            @endif
        </div>
    </div>
@endsection

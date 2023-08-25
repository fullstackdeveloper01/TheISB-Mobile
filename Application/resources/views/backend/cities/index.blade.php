@extends('backend.layouts.grid')
@section('title', __('Cities'))
@section('back', route('admin.settings.index'))
@section('link', route('admin.cities.create'))
@section('content')
    <div class="custom-card card">
        {{--<div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="input-group vironeer-custom-input-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search on cities...') }}"
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
            @if ($cities->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-20x">{{ __('Name') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Status') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Created date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $key => $city)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.cities.edit', $city->id) }}">
                                            {{ $city->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">{!! userStatus($city->status) !!}</td>
                                    <td class="text-center">{{ vDate($city->created_at) }}</td>
                                    <td>
                                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="vironeer-able-to-delete dropdown-item text-danger text-center">
                                                <i class="far fa-trash-alt me-2"></i>{{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
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
    @if (!request()->input('search') && !request()->input('filter'))
        {{ $cities->links() }}
    @endif
@endsection

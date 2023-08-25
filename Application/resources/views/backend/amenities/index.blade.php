@extends('backend.layouts.grid')
@section('title', __('Amenities'))
@section('back', route('admin.settings.index'))
@section('link', route('admin.amenities.create'))
@section('content')
    <div class="custom-card card">
        {{--<div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="input-group vironeer-custom-input-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search on amenity...') }}"
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
                                href="{{ request()->url() . '?filter=banned' }}">{{ __('Inactive') }}</a></li>
                    </ul>
                </div>
            </form>
        </div>--}}
        <div>
            @if ($amenityList->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-20x">{{ __('Icon') }}</th>
                                <th class="tb-w-20x">{{ __('Amenity') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Status') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Created date') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($amenityList as $key => $amenity)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ asset($amenity->icon) }}" width="50" alt="{{ $amenity->icon }}"></td>
                                    <td>
                                        <a href="{{ route('admin.amenities.edit', $amenity->id) }}">
                                            {{ $amenity->amenity }}
                                        </a>
                                    </td>
                                    <td class="text-center">{!! userStatus($amenity->status) !!}</td>
                                    <td class="text-center">{{ vDate($amenity->created_at) }}</td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-2">
                                                <a href="{{ route('admin.amenities.edit', $amenity->id) }}">
                                                    <i class="far fa-edit me-2 text-info"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-2">   
                                                <form action="{{ route('admin.amenities.destroy', $amenity->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="vironeer-able-to-delete dropdown-item text-danger text-center">
                                                        <i class="far fa-trash-alt me-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
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
        {{ $amenityList->links() }}
    @endif
@endsection

@extends('backend.layouts.grid')
@section('title', __('Advertisement'))
@section('link', route('admin.advertisement.create'))
@section('content')
    <div class="custom-card card">
        {{--<div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="input-group vironeer-custom-input-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search on advertisement...') }}"
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
            @if ($advertisements->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#ID</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advertisements as $key => $advertisement)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.advertisement.edit', $advertisement->id) }}">
                                                <img src="{{ asset($advertisement->image) }}" alt="Advertisement" />
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.advertisement.edit', $advertisement->id) }}">
                                            {{ $advertisement->title }}
                                        </a>
                                    </td>
                                    <td class="text-center">{!! userStatus($advertisement->status) !!}</td>
                                    <td class="text-end">
                                        <div class="row">
                                            <div class="col-lg-5">                                                
                                                <a href="{{ route('admin.advertisement.edit', $advertisement->id) }}" class="text-center">
                                                    <i class="far fa-edit text-info"></i>
                                                </a>
                                            </div>   
                                            <div class="col-lg-5">                                                
                                                <form action="{{ route('admin.advertisement.destroy', $advertisement->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                            class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
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
        {{ $advertisements->links() }}
    @endif
@endsection

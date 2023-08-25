@extends('backend.layouts.grid')
@section('title',  __('Redirections'))
@section('link', route('admin.redirection.create'))
@section('back', route('admin.sections.index'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th class="tb-w-9x">{{ __('Title') }}</th>
                    <th class="tb-w-2x text-center">{{ __('Status') }}</th>
					<th class="tb-w-2x text-center">{{ __('Created date') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($redirections as $key => $redirection)
                    <tr class="item">
                        <td>{{ $key+1 }}</td>
                        <td><a class="text-reset" href="{{ route('admin.redirection.edit', $redirection->id) }}">{{ $redirection->title }}</a></td>
                        <td class="text-center">{!! userStatus($redirection->status) !!}</td>
						<td class="text-center">{{ vDate($redirection->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.redirection.edit', $redirection->id) }}">
                                            <i class="fa fa-edit me-2"></i>{{ __('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.redirection.destroy', $redirection->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="vironeer-able-to-delete dropdown-item text-danger">
                                                <i class="far fa-trash-alt me-2"></i>{{ __('Delete') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

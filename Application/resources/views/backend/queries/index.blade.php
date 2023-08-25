@extends('backend.layouts.grid')
@section('title', __('Queries'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th class="tb-w-7x">{{ __('Student Name') }}</th>
                    <th class="tb-w-7x">{{ __('Class') }}</th>
                    <th class="tb-w-7x">{{ __('Phone Number') }}</th>
                    <th class="tb-w-5x">{{ __('Query for') }}</th>
                    <th class="tb-w-30x">{{ __('Your Query') }}</th>
                    <th class="tb-w-7x">{{ __('Request Date') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($queries as $query)
                    <tr class="item">
                        <td>{{ $no++ }}</td>
                        <td>{{ $query->full_name }}</a></td>
                        <td>{{ $query->class }}</a></td>
                        <td>{{ $query->phone_number }}</a></td>
                        <td>{{ $query->query_for }}</a></td>
                        <td>{{ $query->your_query }}</a></td>
                        <td>{{ vDate($query->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
								{{--<li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.queries.edit', $query->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>--}}
                                    <li>
                                        <form action="{{ route('admin.queries.destroy', $query->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                    class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
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

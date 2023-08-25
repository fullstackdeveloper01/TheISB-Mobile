@extends('backend.layouts.grid')
@section('title', __('Notification Template'))
@section('link', route('admin.notificationTemplate.create'))
@section('content')
    <div class="custom-card card">
        <div>
            @if ($notificationList->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-10x">{{ __('Title') }}</th>
                                <th class="tb-w-30x">{{ __('Message') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificationList as $key => $notification)
                                <tr>
                                    <td data-short="{{ strtotime($notification->created_at) }}">{{ $key+1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.notificationTemplate.edit', $notification->id) }}">
                                            {{ $notification->title }}
                                        </a>
                                    </td>
									<td>
                                        {{ $notification->message }}
                                    </td>
                                    <td class="text-center">{!! userStatus($notification->status) !!}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.notificationTemplate.edit', $notification->id) }}">
                                                        <i class="fa fa-edit me-2"></i>{{ __('Edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.notificationTemplate.destroy', $notification->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <input type="hidden" value="{{$notification->id}}" name="assignment_id" >
                                                        <button class="vironeer-able-to-delete dropdown-item text-danger">
                                                            <i class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
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
            @else
                @include('backend.includes.empty')
            @endif
        </div>
    </div>
@endsection

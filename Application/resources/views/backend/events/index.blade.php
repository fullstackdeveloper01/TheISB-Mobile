@extends('backend.layouts.grid')
@section('title', __('Events'))
@section('link', route('admin.events.create'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th class="tb-w-7x">{{ __('Campus') }}</th>
                    <th class="tb-w-7x">{{ __('Shift') }}</th>
                    <th class="tb-w-7x">{{ __('Class') }}</th>
                    <th class="tb-w-7x">{{ __('Section') }}</th>
                    <th class="tb-w-7x">{{ __('Student') }}</th>
                    <th class="tb-w-4x">{{ __('Event Type') }}</th>
                    <th class="tb-w-15x">{{ __('Title') }}</th>
                    <th class="tb-w-20x">{{ __('Short Description') }}</th>
                    <th>{{ __('Event Date') }}</th>
                    <!-- <th>{{ __('Created date') }}</th> -->
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr class="item">
                        <td>{{ $event->id }}</td>
                        <td><img src="{{ asset($event->image) }}" width="50" alt="{{ $event->image }}"></td>
                        <td>{{ $event->campus }}</td>
                        <td>{{ $event->shift }}</td>
                        <td>{{ ($event->class_id == 0)?"All":shortertext($event->class_id, 70) }}</td>
                        <td>
                            @if($event->section == 0)
                                {{ 'All' }}
                            @else
                                {{ studentSection($event->section) }}
                            @endif
                        </td>
                        <td>{{ studentName($event->student_id) }}</td>
                        <td>{{ ($event->event_date < date('Y-m-d'))?"Activities":"Upcoming" }}</td>
                        <td>
							<a class="text-reset" href="{{ route('admin.events.edit', $event->id) }}">{{ shortertext($event->title, 30) }}</a>
						</td>
                        <td>{{ shortertext($event->short_description, 70) }}</td>
                        <td>{{ date('d M, Y', strtotime($event->event_date)) }}</td>
                        <!-- <td>{{ vDate($event->created_at) }}</td> -->
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.events.edit', $event->id) }}">
										<i class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                            @csrf @method('DELETE')
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
@endsection

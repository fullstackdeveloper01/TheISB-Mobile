@extends('backend.layouts.grid')
@section('title',  __('Announcements'))
@section('link', route('admin.announcements.create'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th class="tb-w-7x">{{ __('Campus') }}</th>
                    <th class="tb-w-7x">{{ __('Shift') }}</th>
                    <th class="tb-w-7x">{{ __('Class') }}</th>
                    <th class="tb-w-7x">{{ __('Section') }}</th>
                    <th class="tb-w-7x">{{ __('Student') }}</th>
                    <th class="tb-w-3x">{{ __('Title') }}</th>
                    <th class="tb-w-20x">{{ __('Description') }}</th>
					<th class="tb-w-7x">{{ __('Created date') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr class="item">
                        <td data-sort="{{ strtotime($announcement->created_at) }}">{{ $announcement->id }}</td>
                        <td>{{ $announcement->campus }}</td>
                        <td>{{ $announcement->shift }}</td>
                        <td>{{ $announcement->class_id }}</td>
                        <td>
                            @if($announcement->section == 0)
                                {{ 'All' }}
                            @else
                                {{ studentSection($announcement->section) }}
                            @endif                         
                        </td>
                        <td>{{ ($announcement->student_id == 0)?"All":$announcement->student_id }}</td>
                        <td><a class="text-reset" href="{{ route('admin.announcements.edit', $announcement->id) }}">{{ shortertext($announcement->title, 40) }}</a></td>
						<td>{!! shortertext($announcement->content, 50) !!}</td>
                        <td>{{ vDate($announcement->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.announcements.edit', $announcement->id) }}">
                                            <i class="fa fa-edit me-2"></i>{{ __('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider"/>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST">
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

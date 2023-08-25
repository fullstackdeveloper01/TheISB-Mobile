@extends('backend.layouts.grid')
@section('title', __('Notice Board'))
@section('link', route('admin.noticeBoard.create'))
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
                    <th class="tb-w-20x">{{ __('Title') }}</th>
                    <th>{{ __('Content') }}</th>
                    <th class="tb-w-5x">{{ __('Notice Date') }}</th>
                    <th class="tb-w-5x">{{ __('Created Date') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noticeBoardList as $key => $noticeBoard)
                    <tr class="item">
                        <td>{{ $noticeBoard->id }}</td>
                        <td>{{ str_replace(',',', ',$noticeBoard->campus) }}</td>
                        <td>{{ $noticeBoard->shift }}</td>
                        <td>{{ shortertext($noticeBoard->class_id, 50) }}</td>
                        <td>
                            @if($noticeBoard->section == 0)
                                {{ 'All' }}
                            @else
                                {{ studentSection($noticeBoard->section) }}
                            @endif
                        </td>
                        <td>{{ ($noticeBoard->student_id == 0)?"All":$noticeBoard->student_id }}</td>
                        <td>
							<a class="text-reset" href="{{ route('admin.noticeBoard.edit', $noticeBoard->id) }}">{{ shortertext($noticeBoard->title, 30) }}</a>
						</td>
						@if($noticeBoard->notice_type == 1)
							<td><img src="{{ asset($noticeBoard->image) }}" width="100" height="80" alt="{{ $noticeBoard->image }}"></td>
                        @elseif($noticeBoard->notice_type == 2)
                            <td>                                
                                <a href="{{ asset($noticeBoard->image) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a>
                            </td>
						@else
							<td>{!! shortertext($noticeBoard->content, 70) !!}</td>
						@endif
                        <td>{{ date('d M, Y', strtotime($noticeBoard->notice_date)) }}</td>
                        <td>{{ vDate($noticeBoard->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.noticeBoard.edit', $noticeBoard->id) }}">
										<i class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.noticeBoard.destroy', $noticeBoard->id) }}" method="POST">
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

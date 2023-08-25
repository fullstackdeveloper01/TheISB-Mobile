@extends('backend.layouts.grid')
@section('title', __('Popup Notice'))
@section('link', route('admin.popup-notice.create'))
@section('content')	
    <div class="card">
		@if(count($noticeList) > 0)
			<table id="datatable" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-7x">{{ __('Campus') }}</th>
						<th class="tb-w-7x">{{ __('Shift') }}</th>
						<th class="tb-w-7x">{{ __('Class') }}</th>
						<th class="tb-w-7x">{{ __('Section') }}</th>
						<th class="tb-w-7x">{{ __('Student') }}</th>
						<th class="tb-w-7x">{{ __('Notice') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($noticeList as $notice)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td>{{ $count }}</td>
							<td>{{ $notice->campus }}</td>
							<td>{{ $notice->shift }}</td>
							<td>{{ ($notice->class_id == 0)?"All":$notice->class_id }}</td>
							<td>
								@if($notice->section == 0)
									{{ "All" }}
								@elseif($notice->section == 1)
									{{ "A1" }}
								@elseif($notice->section == 2)
									{{ "A2" }}
								@elseif($notice->section == 3)
									{{ "A3" }}
								@elseif($notice->section == 4)
									{{ "A4" }}
								@elseif($notice->section == 5)
									{{ "A5" }}
								@elseif($notice->section == 6)
									{{ "A6" }}
								@endif
							</td>
							<td>{{ ($notice->student_id == 0)?"All":$notice->student_id }}</td>
							<td><img src="{{ asset($notice->image) }}" width="50" alt="{{ $notice->image }}"></td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<a class="dropdown-item" href="{{ route('admin.popup-notice.edit', $notice->id) }}">
												<i class="fa fa-edit me-2"></i>{{ __('Edit') }}
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.popup-notice.destroy', $notice->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$notice->id}}" name="notice_id" >
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
		@else
			@include('backend.includes.empty')
		@endif
    </div>
@endsection

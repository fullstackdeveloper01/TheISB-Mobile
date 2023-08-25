@extends('backend.layouts.grid')
@section('title', __('Push Notification'))
@section('link', route('admin.pushNotification.create'))
@section('content')	
    <div class="card">
		@if(count($notificationList) > 0)
			<table id="datatable" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-7x">{{ __('Campus') }}</th>
						<th class="tb-w-7x">{{ __('Shift') }}</th>
						<th class="tb-w-7x">{{ __('Class') }}</th>
						<th class="tb-w-7x">{{ __('Section') }}</th>
						<th class="tb-w-7x">{{ __('Student') }}</th>
						<th class="tb-w-7x">{{ __('Title') }}</th>
						<th class="tb-w-7x">{{ __('Image') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($notificationList as $notification)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td data-sort="{{ strtotime($notification->created_at) }}">{{ $count }}</td>
							<td>{{ $notification->campus }}</td>
							<td>{{ $notification->shift }}</td>
							<td>{{ $notification->class_id }}</td>
							<td>
								@if($notification->section == 0)
	                                {{ 'All' }}
	                            @else
	                            	{{ studentSection($notification->section) }}
	                            @endif
							</td>
							<td>{{ ($notification->student_id == 0)?"All":$notification->student_id }}</td>
							<td>{{ $notification->title }}</td>
							@if(!empty($notification->image))
								<td>
									<img src="{{ asset($notification->image) }}" width="60px" height="70px">
								</td>
							@else
								<td><img width="60px" height="70px"></td>
							@endif
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<a class="dropdown-item" href="{{ route('admin.pushNotification.edit', $notification->id) }}">
												<i class="fa fa-eye me-2"></i>{{ __('View') }}
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.pushNotification.destroy', $notification->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$notification->id}}" name="assignment_id" >
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

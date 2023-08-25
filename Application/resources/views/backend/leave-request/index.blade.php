@extends('backend.layouts.form')
@section('title', __('Leave Request'))
@section('content')
	@if(count($leaveRequestList) > 0)
        <div class="card">
			<table id="datatable" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-7x">{{ __('Student Name') }}</th>
						<th class="tb-w-7x">{{ __('Father Name') }}</th>
						<th class="tb-w-7x">{{ __('Class') }}</th>
						<th class="tb-w-7x">{{ __('Start Date') }}</th>
						<th class="tb-w-7x">{{ __('End Date') }}</th>
						<th class="tb-w-7x">{{ __('Reason For Leave') }}</th>
						<th class="tb-w-7x">{{ __('Application') }}</th>
						<th class="tb-w-7x">{{ __('Status') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($leaveRequestList as $key => $leaveReques)
						@php
							$count++;
							$fileExt = array('png', 'jpg', 'jpeg');
						@endphp
						<tr class="item">
							<td>{{ $key+1 }}</td>
							<td>{{ $leaveReques->student_name }}</td>
							<td>{{ $leaveReques->father_name }}</td>
							<td>{{ $leaveReques->class_id }}</td>
							<td>{{ $leaveReques->start_date }}</td>
							<td>{{ $leaveReques->end_date }}</td>
							<td>{{ $leaveReques->reason_for_leave }}</td>
							@if($leaveReques->extension == 'pdf')
								<td><a href="{{ asset($leaveReques->application) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a></td>
							@elseif(in_array($leaveReques->extension, $fileExt))
								<td><img src="{{ asset($leaveReques->application) }}" width="100" alt=""></td>
							@else
								<td>{{ $leaveReques->application }}</td>
							@endif
							<td>  
                                <input data-id="{{$leaveReques->id}}" data-table="leave_requests" class="toggle-class change-status" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Approved" data-off="Pending" {{ $leaveReques->status ? 'checked' : '' }}>
                        	</td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<form action="{{ route('admin.leaveReques.destroy', $leaveReques->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$leaveReques->id}}" name="leaveReques_id" >
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
	@else
		@include('backend.includes.empty')
	@endif
@endsection

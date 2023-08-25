@extends('backend.layouts.grid')
@section('title', __('Class Homework'))
@section('link', route('admin.homework.create'))
@section('content')	
	@if(count($assignmentList) > 0)
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
						<th class="tb-w-7x">{{ __('Title') }}</th>
						<th class="tb-w-7x">{{ __('Assignment') }}</th>
						<th class="tb-w-7x">{{ __('Created Date') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($assignmentList as $assignment)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td data-sort="{{ strtotime($assignment->created_at) }}">{{ $count }}</td>
							<td>{{ $assignment->campus }}</td>
							<td>{{ $assignment->shift }}</td>
							<td>{{ $assignment->class_id }}</td>
							<td>
								@if($assignment->section == 0)
	                                {{ 'All' }}
	                            @else
	                            	{{ studentSection($assignment->section) }}
	                            @endif
							</td>
							<td>{{ ($assignment->student_id == 0)?"All":$assignment->student_id }}</td>
							<td>{{ $assignment->title }}</td>
							@if($assignment->homework_type == 'file')
								<td>
									<a href="{{ asset($assignment->assignment) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a>
								</td>
							@elseif($assignment->homework_type == 'image')
								<td><img src="{{ asset($assignment->assignment) }}" width="100px"></td>
							@else
								<td>{!!shortertext($assignment->assignment, 70)!!}</td>
							@endif
							<td>{{ vDate($assignment->created_at) }}</td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<a class="dropdown-item"
												href="{{ route('admin.homework.edit', $assignment->id) }}"><i
													class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.homework.destroy', $assignment->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$assignment->id}}" name="assignment_id" >
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
	@else
		@include('backend.includes.empty')
	@endif
@endsection

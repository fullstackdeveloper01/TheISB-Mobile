@extends('backend.layouts.grid')
@section('title', __('Academic Time Table'))
@section('link', route('admin.academicTimeTable.create'))
@section('content')	
	@if(count($syllabusList) > 0)
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
						<th class="tb-w-7x">{{ __('Time Table') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($syllabusList as $syllabus)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td>{{ $count }}</td>
							<td>{{ $syllabus->campus }}</td>
							<td>{{ $syllabus->shift }}</td>
							@if($syllabus->class_name == 0)
                                <td>{{ 'All' }}</td>
                            @else
                            	<td>{{ shortertext($syllabus->class_name, 50) }}</td>
                            @endif
							<td>
								@if($syllabus->section == 0)
	                                {{ 'All' }}
	                            @else
	                            	{{ studentSection($syllabus->section) }}
	                            @endif
							</td>
							<td>{{ ($syllabus->student_id == 0)?"All":$syllabus->student_id }}</td>
							<td><a href="{{ asset($syllabus->syllabus) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a></td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<a class="dropdown-item" href="{{ route('admin.academicTimeTable.edit', $syllabus->id) }}">
												<i class="fa fa-edit me-2"></i>{{ __('Edit') }}
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.academicTimeTable.destroy', $syllabus->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$syllabus->id}}" name="syllabus_id" >
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

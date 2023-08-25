@extends('backend.layouts.form')
@section('title', __('Class Academic Content'))
@section('content')
	<form id="vironeer-submited-form" action="{{ route('admin.academicContentSave') }}" method="POST"
        enctype="multipart/form-data">
		<input type="hidden" name="type" value="2">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
            	<div class="row mb-3">
            		<div class="col-lg-4">            			
	                    <label class="form-label">{{ __('Class') }} :<span class="red">*</span></label>
	                    <select name="class_name" class="form-select select2" required>
	                        <option>Please select</option>                        
							<option value="Playgroup">Playgroup</option>
							<option value="Nursery">Nursery</option>
							<option value="LKG">LKG</option>
							<option value="UKG">UKG</option>
							<option value="Class I">Class I</option>
							<option value="Class II">Class II</option>
							<option value="Class III">Class III</option>
							<option value="Class IV">Class IV</option>
							<option value="Class V">Class V</option>
							<option value="Class VI">Class VI</option>
							<option value="Class VII">Class VII</option>
							<option value="Class VIII">Class VIII</option>
							<option value="Class IX">Class IX</option>
							<option value="Class X">Class X</option>
							<option value="Class XI">Class XI</option>
							<option value="Class XII">Class XII</option>
	                    </select>
            		</div>
            		<div class="col-lg-4">    
            			<label class="form-label">{{ __('Academic Year') }} :<span class="red">*</span></label>
	                    <select name="academic_year" class="form-select select2" required>
	                        <option></option>                        
							<option value="2023-24">2023-24</option>
							<option value="2024-25">2024-25</option>
							<option value="2025-26">2025-26</option>
							<option value="2026-27">2026-27</option>
							<option value="2027-28">2027-28</option>
							<option value="2028-29">2028-29</option>
	                    </select>        			
            		</div>
            		<div class="col-lg-4">      
            			<label class="form-label">Upload Files : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PDF)') }}</small></label>
                        <input type="file" name="image" multiple class="form-control" accept="application/pdf, application/PDF" required>		
            		</div>
            	</div>
            </div>
        </div>
    </form>
	@if(count($syllabusList) > 0)
        <div class="card">
			<table id="datatable" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-7x">{{ __('Class') }}</th>
						<th class="tb-w-7x">{{ __('Academic Year') }}</th>
						<th class="tb-w-7x">{{ __('Syllabus') }}</th>
						<th class="tb-w-7x">{{ __('Created Date') }}</th>
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
							<td>{{ $syllabus->class_name }}</td>
							<td>{{ $syllabus->academic_year }}</td>
							<td><a href="{{ asset($syllabus->syllabus) }}" target="_blank"><i class="fa fa-file-pdf fa-2x text-danger"></i></a></td>
							<td>{{ vDate($syllabus->created_at) }}</td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
									{{--<li>
											<a class="dropdown-item"
												href="{{ route('admin.syllabus.edit', $syllabus->id) }}"><i
													class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>--}}
										<li>
											<form action="{{ route('admin.academicTimeTable.destroy', $syllabus->id) }}" method="POST">
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
	@else
		@include('backend.includes.empty')
	@endif
@endsection

@extends('backend.layouts.form')
@section('title', __('Complaint-Type'))
@section('content')
	<form id="vironeer-submited-form" action="{{ route('admin.complaintType.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
            	<div class="row mb-3">
            		<div class="col-lg-6">            			
	                    <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
	                    <input type="text" name="title" class="form-control" required>	
            		</div>
            		<div class="col-lg-4">            			
	                    <label class="form-label">{{ __('Complaint Type For') }} :<span class="red">*</span></label>
	                    <select class="form-control select2" name="type" required>
			                <option value=""></option>
			                <option value="Transport">Transport</option>
			                <option value="Academic">Academic</option>
			            </select>
            		</div>
            	</div>
            </div>
        </div>
    </form>
	@if(count($complaintTypeList) > 0)
        <div class="card">
			<table id="datatable" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-7x">{{ __('Title') }}</th>
						<th class="tb-w-7x">{{ __('Complaint Type') }}</th>
						<th class="tb-w-7x">{{ __('Created Date') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($complaintTypeList as $key => $complaintType)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td>{{ $key+1 }}</td>
							<td>{{ $complaintType->title }}</td>
							<td>{{ $complaintType->type }}</td>
							<td>{{ vDate($complaintType->created_at) }}</td>
							<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
										<li>
											<a class="dropdown-item" href="{{ route('admin.complaintType.edit', $complaintType->id) }}">
												<i class="fa fa-edit me-2"></i>{{ __('Edit') }}
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.complaintType.destroy', $complaintType->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$complaintType->id}}" name="complaintType_id" >
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

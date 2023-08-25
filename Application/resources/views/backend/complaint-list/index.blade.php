@extends('backend.layouts.grid')
@section('title', $complaintType.__(' complaint Queries'))
@section('content')
	<div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-8 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Resolved') }}</h3>
                <p class="vironeer-counter-box-number">{{ @$totalResolved }}</p>
                <!-- <small>{{ __('Included inactive students') }}</small> -->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-9 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total In-Process') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalOnProcessing }}</p>
                <!--<small>{{ __('Included inactive marinas') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-11 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Pending') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalPending }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-7 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Rejected') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalRejected }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
    </div>
	@if(count($complaintList) > 0)
	    <div class="row mb-3">
	        <div class="col-lg-5">                      
	            <label for="campus" class="form-label">{{ __('Start Date') }}</label>
	            <input type="date" class="form-control" id="start_date">
	        </div>
	        <div class="col-lg-5">                      
	            <label for="shift" class="form-label">{{ __('End Date') }}</label>
	            <input type="date" class="form-control" id="end_date">
	        </div> 
	        <div class="col-lg-2"><br>
	            <button type="button" class="btn btn-primary" id="search_button">Search</button>
	        </div> 
	    </div> 
        <div class="card">
        	<div class="table-responsive w-100">
				<table id="data-table-large-2" class="table w-100 table table-striped display">
	            	<thead>
						<tr>
							<th class="tb-w-2x">{{ __('#') }}</th>
							<th class="tb-w-2x">{{ __('Student Name') }}</th>
							<th class="tb-w-2x">{{ __('Father Name') }}</th>
							<th class="tb-w-2x">{{ __('Mother Name') }}</th>
							<th class="tb-w-2x">{{ __('Class') }}</th>
							<th class="tb-w-2x">{{ __('Shift') }}</th>
							<th class="tb-w-2x">{{ __('Mobile') }}</th>
							<th class="tb-w-10x">{{ __('Complaint') }}</th>
							<th class="tb-w-10x">{{ __('Admin Comment') }}</th>
							<th class="tb-w-10x">{{ __('Created Date Time') }}</th>
							<th class="tb-w-2x">{{ __('Status') }}</th>
						</tr>
					</thead>
					<tbody>
						 
					</tbody>
	                <tfoot>
	                    <tr>
							<th class="tb-w-2x">{{ __('#') }}</th>
							<th class="tb-w-2x">{{ __('Student Name') }}</th>
							<th class="tb-w-2x">{{ __('Father Name') }}</th>
							<th class="tb-w-2x">{{ __('Mother Name') }}</th>
							<th class="tb-w-2x">{{ __('Class') }}</th>
							<th class="tb-w-2x">{{ __('Shift') }}</th>
							<th class="tb-w-2x">{{ __('Mobile') }}</th>
							<th class="tb-w-10x">{{ __('Complaint') }}</th>
							<th class="tb-w-10x">{{ __('Admin Comment') }}</th>
							<th class="tb-w-10x">{{ __('Created Date Time') }}</th>
							<th class="tb-w-2x">{{ __('Status') }}</th>
						</tr>
	                </tfoot> 
				</table>
			</div>
        </div>
	@else
		@include('backend.includes.empty')
	@endif
	<div class="modal fade" id="adminCommentModal" tabindex="-1" aria-labelledby="mobileModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-top">
	        <div class="modal-content">
	            <form action="javascript:void(0)" method="POST" id="admin-comment-form">
	                <div class="modal-body">
	                    <div class="row form-group">
	                        <div class="col-md-12">
	                            <h5 class="form-label">{{ lang('Admin Comment', 'user') }}</h5>   
	                        </div><hr>
	                    </div>
	                    <div class="row form-group mb-3">
	                        <div class="col-md-12 mb-3">
	                            <label>Status<span class="text-danger">*</span></label>
	                            <select id="comment_status" name="comment_status" class="form-select form-control" onchange="setInProcessStatus(this.value)">
	                                <option value="">Select option</option>
	                                <option value="0">Pending</option>
	                                <option value="1">In-Process</option>
	                                <option value="2">Resolved</option>
	                                <option value="3">Rejected</option>
	                            </select>
	                            <span class="error_comment_status text-danger"></span>
	                        </div>
	                        <div class="col-md-12 mb-3" id="admin-comment">
	                            <label>Comment</label>
	                            <input type="hidden" name="complaint_id" id="complaint_id">
	                            <textarea class="form-control" name="admin_comment" maxlength="200" id="admin_comment" rows="3"></textarea>
	                        </div>
	                        <hr>
	                        <div class="col-md-12 mb-3">                            
	                            <div class="d-flex justify-content-between">
	                                <button type="button" class="btn btn-primary w-100 me-2 admin-comment" onclick="adminCommentSubmit()">{{ lang('Save', 'user') }}</button>
	                                <button type="button" class="btn btn-secondary w-100 ms-2" id="close_comment_modal" data-bs-dismiss="modal">{{ lang('Close') }}</button>
	                            </div>
	                        </div>                        
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
@endsection

@push('scripts')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">  
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function () {
    var oTable = $('#data-table-large-2').DataTable({
        dom: "Bfrtip",
        processing: true,
        serverSide: false,  
        pageLength: 20,
        // paging: false,
        // ordering: false,
        // searching: false,
        // info: false,
        ajax: {
            url: "{{ route('admin.complaintsQueryAjax') }}",
            type: "POST",
            dataType: 'json',
            data: function(data1){
                var start_date = jQuery('#start_date').val();
                var end_date = jQuery('#end_date').val();

                // Append to data
                data1.type = '{{ $complaintType }}'; 
                data1.start_date = start_date; 
                data1.end_date = end_date;
            } 
        },   
        buttons: ["excel", "print"],
        order: [[0, 'desc']]
    });
    $("#reset").click(function () {
        oTable.ajax.reload();
    });
    jQuery(document).on('click', '#search_button', function(e){ 
        oTable.ajax.reload();
        oTable.draw();
        e.preventDefault();
    }); 
 
});
</script>
@endpush 
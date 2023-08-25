@extends('backend.layouts.grid')
@section('title', __('Student Report')) 
@section('content')	
     
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-6">                      
                        <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                        <select name="campus" id="campus" class="form-select select2" required>
                            <option></option>             
                            <option selected value="0">All</option>   
                            <option value="Elite Campus">Elite Campus</option>   
                            <option value="Premium Campus">Premium Campus</option>   
                            <option value="World School">World School</option>   
                        </select>
                    </div>
                    <div class="col-lg-6">                      
                        <label for="shift" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                        <select name="shift" id="shift" class="form-select select2" required>
                            <option></option>        
                            <option selected value="0">All</option>      
                            <option value="Morning">Morning</option>   
                            <option value="Afternoon">Afternoon</option>  

                        </select>
                    </div> 
                </div> 
                <div class="row mb-3">
                    <div class="col-lg-6">                      
                        <label class="form-label">{{ __('Class') }} :<span class="red">*</span></label>
                        <select name="class_id" id="class_id" class="form-select select2" required>
                            <option></option>        
                            <option selected value="0">All</option>                        
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
                    <div class="col-lg-6">                      
                        <label for="section" class="form-label">{{ __('Section') }} :<span class="red">*</span></label>
                        <select name="section" id="section" class="form-select select2" required>
                            <option></option>        
                            <option selected value="0">All</option> 
                            <option value="1">A1</option>  
                            <option value="2">A2</option>  
                            <option value="3">A3</option> 
                            <option value="4">A4</option> 
                            <option value="5">A5</option> 
                            <option value="6">A6</option> 
                        </select>
                    </div> 
                    
                </div> 
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-primary " id="search_button">Search Students</button>
                    </div>
                </div>
            </div> 

		<!-- 	<table id="usersReport" class="table w-100 table table-striped display">
				<thead>
					<tr>
                        <th class="tb-w-3x">S.No.</th>
                        <th class="tb-w-10x">{{ __('Student Name') }}</th>
                        <th class="tb-w-10x">{{ __('Father Name') }}</th>
                        <th class="tb-w-8x">{{ __('Mobile Number') }}</th>
                        <th class="tb-w-5x">{{ __('Campus') }}</th>
                        <th class="tb-w-3x">{{ __('Shift') }}</th>
                        <th class="tb-w-3x">{{ __('Class') }}</th>
                        <th class="tb-w-3x">{{ __('Section') }}</th>
                        <th class="tb-w-3x">{{ __('Status') }}</th>
                        <th class="tb-w-10x">{{ __('Admission Date') }}</th>
					</tr>
				</thead>
				<tbody>
					 
				</tbody>
                <tfoot>
                    <tr>
                        <th class="tb-w-3x">S.No.</th>
                        <th class="tb-w-10x">{{ __('Student Name') }}</th>
                        <th class="tb-w-10x">{{ __('Father Name') }}</th>
                        <th class="tb-w-8x">{{ __('Mobile Number') }}</th>
                        <th class="tb-w-5x">{{ __('Campus') }}</th>
                        <th class="tb-w-3x">{{ __('Shift') }}</th>
                        <th class="tb-w-3x">{{ __('Class') }}</th>
                        <th class="tb-w-3x">{{ __('Section') }}</th>
                        <th class="tb-w-3x">{{ __('Status') }}</th>
                        <th class="tb-w-10x">{{ __('Admission Date') }}</th>
					</tr>
                    
                </tfoot>
			</table> -->
            <table id="data-table-large-2" class="table w-100 table table-striped display">
            <thead>
					<tr>
                        <th class="tb-w-3x">S.No.</th>
                        <th class="tb-w-10x">{{ __('Student Name') }}</th>
                        <th class="tb-w-10x">{{ __('Father Name') }}</th>
                        <th class="tb-w-8x">{{ __('Mobile Number') }}</th>
                        <th class="tb-w-5x">{{ __('Campus') }}</th>
                        <th class="tb-w-3x">{{ __('Shift') }}</th>
                        <th class="tb-w-3x">{{ __('Class') }}</th>
                        <th class="tb-w-3x">{{ __('Section') }}</th>
                        <th class="tb-w-3x">{{ __('Status') }}</th>
                        <th class="tb-w-10x">{{ __('Admission Date') }}</th>
					</tr>
				</thead>
				<tbody>
					 
				</tbody>
                <tfoot>
                    <tr>
                        <th class="tb-w-3x">S.No.</th>
                        <th class="tb-w-10x">{{ __('Student Name') }}</th>
                        <th class="tb-w-10x">{{ __('Father Name') }}</th>
                        <th class="tb-w-8x">{{ __('Mobile Number') }}</th>
                        <th class="tb-w-5x">{{ __('Campus') }}</th>
                        <th class="tb-w-3x">{{ __('Shift') }}</th>
                        <th class="tb-w-3x">{{ __('Class') }}</th>
                        <th class="tb-w-3x">{{ __('Section') }}</th>
                        <th class="tb-w-3x">{{ __('Status') }}</th>
                        <th class="tb-w-10x">{{ __('Admission Date') }}</th>
					</tr>
                    
                </tfoot> 
</table>
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
        pageLength: 100,
        // paging: false,
        // ordering: false,
        // searching: false,
        // info: false,
        ajax: {
            url: "{{ route('admin.studentReportAjax') }}",
            type: "POST",
            dataType: 'json',
            data: function(data1){
                var campus = jQuery('#campus').val();
                var shift = jQuery('#shift').val();
                var class_id = jQuery('#class_id').val();
                var section = jQuery('#section').val();

                // Append to data
                data1.campus = campus; 
                data1.shift = shift; 
                data1.class_id = class_id; 
                data1.section = section; 
            } 
        },   
        buttons: ["excel", "print"],
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
<script>
   /*  jQuery(document).ready(function() {
        jQuery("#usersReport").DataTable({
            dom: "Bfrtip",
            buttons: ["excel", "print"],
            pageLength: 100
        });
    });  */
 
</script>

@endpush 

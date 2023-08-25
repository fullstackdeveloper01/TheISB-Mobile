@extends('backend.layouts.grid-calendar')
@section('title', __('Calendar'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="custom-card card">
        <div id='calendar'></div>
    </div> 
    <div class="modal fade" id="timeTableModal" tabindex="-1" aria-labelledby="timeTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeTableModalLabel">Add Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row mb-3">
                            <div class="col-lg-6">                      
                                <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                                <select name="campus" id="campus" class="form-select select2" required>
                                    <option value=""></option>       
                                    <option value="All" selected>All</option>       
                                    <option value="Elite Campus">Elite Campus</option>   
                                    <option value="Premium Campus">Premium Campus</option>   
                                    <option value="World School">World School</option>   
                                </select>
                            </div>
                            <div class="col-lg-6">                      
                                <label for="shift" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                                <select name="shift" id="shift" class="form-select select2" required>
                                    <option value=""></option>       
                                    <option value="All" selected>All</option>    
                                    <option value="Morning">Morning</option>   
                                    <option value="Afternoon">Afternoon</option>  
                                </select>
                            </div> 
                            
                        </div> 
                        <div class="row mb-3">
                            <div class="col-lg-6">  
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Class') }} : <span class="red">*</span></label>
                                    <select name="student_class" id="student_class" class="form-control select2">
                                        <option value=""></option>
                                        <option selected value="0">All</option>
                                        @if($class_list)
                                            @foreach($class_list as $res)
                                                <option value="{{ $res }}">{{ $res }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>                                
                            </div>                            
                            <div class="col-lg-6">                      
                                <label for="section" class="form-label">{{ __('Section') }} :<span class="red">*</span></label>
                                <select name="section" id="section" class="form-select select2" required>
                                    <option value=""></option>        
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">{{ __('Students') }} :<span class="red">*</span></label>
                                <select name="student_id[]" id="student_id" class="form-select select2" multiple>
                                    <option>Please select here</option>  
                                    <option value="all">All</option>  
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Date') }} : <span class="red">*</span></label>
                                <p class="selected_date"></p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" maxlength="150" required>
                                <input type="hidden" name="start" id="start" class="form-control" required>
                                <input type="hidden" name="end" id="end" class="form-control" required>
                                <input type="hidden" name="allDay" id="allDay" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="form-label">{{ __('Description') }} : <span class="red">(Optional)</span></label>
                            <textarea name="description" id="description" class="form-control" rows="3" maxlength="150"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="saveTimeTableData()">{{ __('Submit') }}</button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" class="btn-close">Close</button>
                </div>
            </div>
        </div>
    </div>                     
@endsection


@push('scripts')

<script>
     $(document).ready(function () {
        //console.log('checkaaaaaa aa')
         getUsersAjax();
         
        });
    jQuery(document).on('change', '#student_class', function(){
        getUsersAjax();
    });

    jQuery(document).on('change', '#campus', function(){ 
        getUsersAjax();
    });

    jQuery(document).on('change', '#shift', function(){ 
        getUsersAjax();
    });

    jQuery(document).on('change', '#section', function(){ 
        getUsersAjax();
    });

    function getUsersAjax() {
        console.log('check')
        var campus = jQuery('#campus').val();
        var shift = jQuery('#shift').val();
        var class_id = jQuery('#student_class').val();
        var section = jQuery('#section').val();

        if (typeof campus === 'undefined' || campus === '' || campus === null){
            return false;
        }else if (typeof shift === 'undefined' || shift === '' || shift === null){
            return false;
        }else if (typeof class_id === 'undefined' || class_id === '' || class_id === null){
            return false;
        }

        if(section == 0)
        {
            section = '';
        }

        var form_data = {
            "cumpus" : campus,
            "shift" : shift,
            "class_id" : class_id,
            "section" : section,
        }

        $('#student_id').html('');
        $('#student_id').append($("<option></option>")
                                        .attr("value", 'all')
                                        .text('All'));

        $.ajax({
            type: 'post',
            url: "{{route('admin.assignments.userlist')}}",
            data: form_data,  
            dataType: 'json',
            success: (data) => {
                console.log(data)
                if(data.status == 1)
                {
                    $.each(data.studentList, function(key, value) {  
                        console.log(key, value);
                        var name = value.firstname + ' '+ value.lastname;
                        $('#student_id')
                            .append($("<option></option>")
                                        .attr("value", value.userid)
                                        .text(name)); 
                    });
                }else{

                }
            }
        });
    }
</script>

@endpush 

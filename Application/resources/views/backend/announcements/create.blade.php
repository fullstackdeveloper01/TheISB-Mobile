@extends('backend.layouts.form')
@section('title', __('Create Announcement'))
@section('back', route('admin.announcements.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-2">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-4">                      
                        <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                        <select name="campus[]" id="campus" class="form-select select2" required multiple>
                            <option value=""></option>            
                            <option value="Elite Campus">Elite Campus</option>   
                            <option value="Premium Campus">Premium Campus</option>   
                            <option value="World School">World School</option>   
                        </select>
                    </div>
                    <div class="col-lg-4">                      
                        <label for="shift[]" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                        <select name="shift[]" id="shift" class="form-select select2" required multiple>
                            <option value=""></option>       
                            <option value="Morning">Morning</option>   
                            <option value="Afternoon">Afternoon</option>
                        </select>
                    </div>
                    <div class="col-lg-4">                      
                        <label class="form-label">{{ __('Class') }} :<span class="red">*</span></label>
                        <select name="class_id[]" id="class_id" class="form-select select2" required multiple>
                            <option value=""></option>                        
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
                </div> 
                <div class="row mb-3">
                    <div class="col-lg-4">                      
                        <label for="section" class="form-label">{{ __('Section') }} :<span class="red">*</span></label>
                        <select name="section[]" id="section" class="form-select select2" required multiple>
                            <option value=""></option>
                            <option selected value="all">All</option> 
                            <option value="1">A1</option>  
                            <option value="2">A2</option>  
                            <option value="3">A3</option> 
                            <option value="4">A4</option> 
                            <option value="5">A5</option> 
                            <option value="6">A6</option> 
                        </select>
                    </div>
                    <div class="col-lg-4">                      
                        <label for="student_id" class="form-label">{{ __('Students') }} :<span class="red">*</span></label>
                        <select name="student_id[]" id="student_id" class="form-select select2" multiple>
                            <option>Please select here</option>  
                            <option value="all">All</option>  
                        </select>
                    </div>
                    <div class="col-lg-4">    
                        <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                        <input type="text" name="title" class="form-control" maxlength="100" required value="{{ old('title') }}" required autofocus />
                    </div>                            
                </div>
                <div class="row mb-3"> 
                    <div class="col-lg-12 mb-0">
                        <label class="form-label">{{ __('Description') }} :
                            <small class="text-muted">({{ __('Max 255 characters, spaces allowed') }})</small><span class="red">*</span></label>
                        <textarea name="content" id="content" rows="4" class="form-control" maxlength="255" required>{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        jQuery(document).on('change', '#class_id', function(){
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
            var campus = jQuery('#campus').val();
            var shift = jQuery('#shift').val();
            var class_id = jQuery('#class_id').val();
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
                url: "{{route('admin.assignments.allStudentList')}}",
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
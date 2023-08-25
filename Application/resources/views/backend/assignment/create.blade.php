@extends('backend.layouts.form')
@section('title', 'Add new homework')
@section('back', route('admin.homework.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.homework.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
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
                                    <option value="all">All</option>  
                                </select>
                            </div>
                            <div class="col-lg-4">    
                                <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                                <input type="text" name="title" class="form-control" maxlength="50" required>
                            </div> 
                           
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-2">                      
                                <label for="homework_type" class="form-label">{{ __('Homework Type') }} :<span class="red">*</span></label>
                                <select name="homework_type" id="homework_type" class="form-select select2" required >
                                    <option value="content">Content</option>   
                                    <option selected value="file">PDF File</option>  
                                    <option value="image">Image</option>  
                                </select>
                            </div>
                            <div class="col-lg-10 box-content" style="display:none;" id="type_content">      
                                <label class="form-label">Content: <span class="red">*</span></label>
                                 <textarea id="content" name="content"></textarea>
                            </div>
                            <div class="col-lg-4 box-file" style="display:block;" id="type_file">   
                                <label class="form-label">Upload Assignment : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PDF)') }}</small></label>
                                <input type="file" name="assignment" class="form-control" accept="application/pdf, application/PDF">
                            </div>
                            <div class="col-lg-4 box-image" style="display:none;" id="type_image">   
                                <label class="form-label">Upload Assignment : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (png,jpg,jpeg)') }}</small></label>
                                <input type="file" name="image" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')

<script>
    jQuery(document).on('change', '#homework_type', function(){
        var val = jQuery(this).val();
        if(val == 'file')
        {
            jQuery('.box-file').show();
            jQuery('.box-image').hide();
            jQuery('.box-content').hide();
        }
        else if (val == 'image')
        {
            jQuery('.box-image').show();
            jQuery('.box-file').hide();
            jQuery('.box-content').hide();
        }
        else{
            jQuery('.box-content').show();
            jQuery('.box-file').hide();
            jQuery('.box-image').hide();
        } 
    });
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

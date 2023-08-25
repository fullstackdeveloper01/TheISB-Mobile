@extends('backend.layouts.form')
@section('title', 'Edit homework')
@section('back', route('admin.homework.index'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.homework.update', $homework->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Inactive') }}" @if ($homework->status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">                      
                                <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                                <select name="campus[]" id="campus" class="form-select select2" required multiple>
                                    <option value="Elite Campus" {{ (in_array('Elite Campus', $campus_arr))?"selected":"" }}>Elite Campus</option>   
                                    <option value="Premium Campus" {{ (in_array('Premium Campus', $campus_arr))?"selected":"" }}>Premium Campus</option>   
                                    <option value="World School" {{ (in_array('World School', $campus_arr))?"selected":"" }}>World School</option>   
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label for="shift" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                                <select name="shift[]" id="shift" class="form-select select2" required multiple>
                                    <option value="Morning" {{ (in_array('Morning', $shift_arr))?"selected":"" }}>Morning</option>   
                                    <option value="Afternoon" {{ (in_array('Afternoon', $shift_arr))?"selected":"" }}>Afternoon</option>  
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label class="form-label">{{ __('Class') }} :<span class="red">*</span></label>
                                <select name="class_id[]" id="class_id" class="form-select select2" required multiple>
                                    <option></option>                         
                                    <option value="Playgroup" {{ (in_array('Playgroup', $class_arr))?"selected":"" }}>Playgroup</option>
                                    <option value="Nursery" {{ (in_array('Nursery', $class_arr))?"selected":"" }}>Nursery</option>
                                    <option value="LKG" {{ (in_array('LKG', $class_arr))?"selected":"" }}>LKG</option>
                                    <option value="UKG" {{ (in_array('UKG', $class_arr))?"selected":"" }}>UKG</option>
                                    <option value="Class I" {{ (in_array('Class I', $class_arr))?"selected":"" }}>Class I</option>
                                    <option value="Class II" {{ (in_array('Class II', $class_arr))?"selected":"" }}>Class II</option>
                                    <option value="Class III" {{ (in_array('Class III', $class_arr))?"selected":"" }}>Class III</option>
                                    <option value="Class IV" {{ (in_array('Class IV', $class_arr))?"selected":"" }}>Class IV</option>
                                    <option value="Class V" {{ (in_array('Class V', $class_arr))?"selected":"" }}>Class V</option>
                                    <option value="Class VI" {{ (in_array('Class VI', $class_arr))?"selected":"" }}>Class VI</option>
                                    <option value="Class VII" {{ (in_array('Class VII', $class_arr))?"selected":"" }}>Class VII</option>
                                    <option value="Class VIII" {{ (in_array('Class VIII', $class_arr))?"selected":"" }}>Class VIII</option>
                                    <option value="Class IX" {{ (in_array('Class IX', $class_arr))?"selected":"" }}>Class IX</option>
                                    <option value="Class X" {{ (in_array('Class X', $class_arr))?"selected":"" }}>Class X</option>
                                    <option value="Class XI" {{ (in_array('Class XI', $class_arr))?"selected":"" }}>Class XI</option>
                                    <option value="Class XII" {{ (in_array('Class XII', $class_arr))?"selected":"" }}>Class XII</option>
                                </select>
                            </div> 
                            
                        </div> 
                        <div class="row mb-3">
                            <div class="col-lg-4">                      
                                <label for="section" class="form-label">{{ __('Section') }} :<span class="red">*</span></label>
                                <select name="section[]" id="section" class="form-select select2" required multiple>
                                    <option value=""></option>
                                    <option value="0" {{ (in_array('0', $section_arr))?"selected":"" }}>All</option> 
                                    <option value="1" {{ (in_array('1', $section_arr))?"selected":"" }}>A1</option>  
                                    <option value="2" {{ (in_array('2', $section_arr))?"selected":"" }}>A2</option>  
                                    <option value="3" {{ (in_array('3', $section_arr))?"selected":"" }}>A3</option> 
                                    <option value="4" {{ (in_array('4', $section_arr))?"selected":"" }}>A4</option> 
                                    <option value="5" {{ (in_array('5', $section_arr))?"selected":"" }}>A5</option> 
                                    <option value="6" {{ (in_array('6', $section_arr))?"selected":"" }}>A6</option> 
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label for="student_id" class="form-label">{{ __('Students') }} :<span class="red">*</span></label>
                                <select name="student_id[]" id="student_id" class="form-select select2" multiple>
                                      
                                    <!-- <option value="all" @if($homework->student_id =='0') selected @endif >All</option>  -->
                                     
                                </select>
                            </div>
                            <div class="col-lg-4">    
                                <label class="form-label">{{ __('Title') }} :<span class="red">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ $homework->title }}" maxlength="50" required>
                            </div> 
                           
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-2">                      
                                <label for="homework_type" class="form-label">{{ __('Homework Type') }} :<span class="red">*</span></label>
                                <select name="homework_type" id="homework_type" class="form-select select2" required >
                                    <option @if($homework->homework_type == 'content') selected @endif value="content">Content</option>   
                                    <option @if($homework->homework_type == 'file') selected @endif value="file">PDF File</option>  
                                    <option @if($homework->homework_type == 'image') selected @endif value="image">Image</option>  
                                </select>
                            </div>
                            <div class="col-lg-10 box-content" style="display: @if($homework->homework_type =='content') block @else none @endif ;">      
                                <label class="form-label">Content: <span class="red">*</span></label>
                                 <textarea id="content" name="content">
                                 @if($homework->homework_type == 'content')  {{ $homework->assignment }}  @endif  </textarea>
                            </div>
                            <div class="col-lg-4 box-file" style="display:@if($homework->homework_type =='file') block @else none @endif;">      
                                <label class="form-label">Upload Assignment : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PDF)') }}</small></label>
                                <input type="file" name="assignment" class="form-control" accept="application/pdf, application/PDF">
                            </div>
                            @if($homework->homework_type == 'file')
                                <div class="col-lg-4 box-file" style="display:@if($homework->homework_type == 'file') block @else none @endif;"> 
                                    <div class="mb-3">
                                        <a href="{{ asset($homework->assignment)}}" target="_blank" >
                                            <i class="fa fa-file-pdf fa-2x text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-4 box-file" style="display:@if($homework->homework_type =='image') block @else none @endif;">      
                                <label class="form-label">Upload Assignment : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (png,jpg,jpeg)') }}</small></label>
                                <input type="file" name="image" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg">
                            </div>
                            @if($homework->homework_type == 'image')
                                <div class="col-lg-4 box-file" style="display:@if($homework->homework_type == 'image') block @else none @endif;"> 
                                    <div class="mb-3">
                                        <img src="{{ asset($homework->assignment)}}" width="100%">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
@endsection

@push('scripts')
 
    @php
        $explodeArr = [];
        if($homework->student_id != 0){
            $explodeArr = explode(',', $homework->student_id);
    }
    @endphp 
<script>
    var student_id = '{{ $homework->student_id }}'; 

    jQuery(document).ready(function(){
        getUsersAjax(1);
    });
    jQuery(document).on('change', '#homework_type', function(){
        var val = jQuery(this).val();
        if(val == 'file')
        {
            jQuery('.box-file').show();
            jQuery('.box-content').hide();
        }else{
            jQuery('.box-content').show();
            jQuery('.box-file').hide();
        } 
    });
    jQuery(document).on('change', '#campus', function(){

        getUsersAjax();
    });

    jQuery(document).on('change', '#class_id', function(){ 
        getUsersAjax();
    });

    jQuery(document).on('change', '#shift', function(){ 
        getUsersAjax();
    });

    jQuery(document).on('change', '#section', function(){ 
        getUsersAjax();
    });

    function getUsersAjax(is_first=0) {
        

        var studentArr = student_id.split(',');
        console.log(studentArr); 

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

        if(student_id == 0)
        {
            $('#student_id').append($("<option></option>")
                                        .attr("value", 'all')
                                        .attr("selected", '')
                                        .text('All'));
        }else{
            $('#student_id').append($("<option></option>")
                                        .attr("value", 'all')
                                        .text('All'));
        }

        

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

                        if(student_id != 0 && is_first == 1)
                        {
                            if(studentArr.includes(value.userid) == true)
                            {
                                $('#student_id')
                                .append($("<option></option>")
                                            .attr("value", value.userid)
                                            .attr("selected", '')
                                            .text(name)); 
                            }else{
                                $('#student_id')
                                    .append($("<option></option>")
                                                .attr("value", value.userid)
                                                .text(name));
                            } 
                        }else{
                            $('#student_id')
                                .append($("<option></option>")
                                            .attr("value", value.userid)
                                            .text(name));
                        }
                    });
                }else{

                }
            }
        });
    }
</script>

@endpush 
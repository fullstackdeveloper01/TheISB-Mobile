@extends('backend.layouts.form')
@section('title', __('Edit Event'))
@section('back', route('admin.events.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.events.update', $event->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card custom-card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 my-1">
                        <label class="form-label">{{ __('Status') }} : </label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                            data-off="{{ __('Inactive') }}" @if ($event->status) checked @endif>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                    <div class="row mb-3">
                            <div class="col-lg-4">                      
                                <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                                <select name="campus[]" id="campus" class="form-select select2" required multiple>
                                    <option></option>
                                    <option value="Elite Campus" {{ (in_array('Elite Campus', $campus_arr))?"selected":"" }}>Elite Campus</option>
                                    <option value="Premium Campus" {{ (in_array('Premium Campus', $campus_arr))?"selected":"" }}>Premium Campus</option>   
                                    <option value="World School" {{ (in_array('World School', $campus_arr))?"selected":"" }}>World School</option>
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label for="shift" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                                <select name="shift[]" id="shift" class="form-select select2" required multiple>
                                    <option></option>
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
                            <div class="col-lg-8">                      
                                <label for="student_id" class="form-label">{{ __('Students') }} :<span class="red">*</span></label>
                                <select name="student_id[]" id="student_id" class="form-select select2" multiple>
                                      
                                    <!-- <option value="all" @if($event->student_id =='0') selected @endif >All</option>  -->
                                     
                                </select>
                            </div> 
                           
                        </div>
                         <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                                    <input type="text" name="title" id="create_slug" class="form-control"
                                        value="{{ $event->title }}" required />
                                </div>
                            </div>
                            <div class="col-lg-3" style="display: none; ">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Type') }} : <span class="red">*</span></label>
                                    <select name="event_type" class="form-select" required onchange="getEventType(this.value)">
                                        <!-- <option value="1" {{ ($event->event_type == "1") ?"selected":"" }}>Latest</option> -->
                                        <option value="2" {{ ($event->event_type == "2") ?"selected":"" }}>Upcoming</option>
                                    </select>
                                </div>                                
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ __('Description') }} : <span class="red">*</span></label>
                            <textarea name="content" id="content" rows="10" class="form-control" required>{{ $event->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        <div class="row event_date">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">{{ __('Event Date') }} : <span class="red">*</span></label>
                                <input type="date" name="event_date" id="event_date" class="form-control" required value="{{ $event->event_date }}">
                            </div>
                        </div>
                        <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ asset($event->image) }}" class="rounded-3 w-100"
                                    height="160px">
                            </div>
                            <button id="selectFileBtn" type="button"
                                class="btn btn-secondary mb-2">{{ __('Choose Image') }}</button>
                            <input id="selectedFileInput" type="file" name="image"
                                accept="image/png, image/jpg, image/jpeg" hidden>
                            <small class="text-muted d-block">{{ __('Allowed (PNG, JPG, JPEG)') }}</small>
                            <small class="text-muted d-block">{{ __('Image will be resized into (1280x720)') }}</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ __('Short description') }} : <span class="red">*</span></label>
                            <textarea name="short_description" rows="6" class="form-control" placeholder="{{ __('50 to 200 character at most') }}" maxlength="200" required>{{ $event->short_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            //let GET_SLUG_URL = "{{ route('articles.slug') }}";

            function getEventType(event){
                if(event == '2'){
                    $('#event_date').attr('required','required');
                    $('.event_date').css('display', 'block');
                }else{
                    $('#event_date').removeAttr('required','required');
                    $('.event_date').css('display', 'none');
                }
            }
        </script>
    @endpush
@endsection



@push('scripts')
 
    @php
        $explodeArr = [];
        if($event->student_id != 0){
            $explodeArr = explode(',', $event->student_id);
    }
    @endphp 
<script>
    var student_id = '{{ $event->student_id }}'; 

    jQuery(document).ready(function(){
        getUsersAjax(1);
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

        $('#student_id').html('');

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
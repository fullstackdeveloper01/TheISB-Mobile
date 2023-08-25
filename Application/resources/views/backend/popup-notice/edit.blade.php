@extends('backend.layouts.form')
@section('title', 'Edit Notice')
@section('back', route('admin.popup-notice.index'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="vironeer-submited-form" action="{{ route('admin.popup-notice.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 my-1">
                                <label class="form-label">{{ __('Status') }} : </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                                    data-off="{{ __('Inactive') }}" @if ($notice->status) checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">                      
                                <label for="campus" class="form-label">{{ __('Campus') }} :<span class="red">*</span></label>
                                <input type="hidden" name="syllabus_id" value="{{ $notice->id }}">
                                <select name="campus" id="campus" class="form-select select2" required>
                                    <option value=""></option>
                                    <option value="All" @if($notice->campus =='All') selected @endif >All</option>   
                                    <option value="Elite Campus" @if($notice->campus =='Elite Campus') selected @endif >Elite Campus</option>   
                                    <option value="Premium Campus" @if($notice->campus =='Premium Campus') selected @endif >Premium Campus</option>
									<option value="World School" @if($notice->campus =='World School') selected @endif >World School</option>   
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label for="shift" class="form-label">{{ __('Shift') }} :<span class="red">*</span></label>
                                <select name="shift" id="shift" class="form-select select2" required>
                                    <option value=""></option> 
                                    <option value="All" @if($notice->shift =='All') selected @endif >Both</option>   
                                    <option value="Morning" @if($notice->shift =='Morning') selected @endif >Morning</option>   
                                    <option value="Afternoon" @if($notice->shift =='Afternoon') selected @endif >Afternoon</option>
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label class="form-label">{{ __('Class') }} :<span class="red">*</span></label>
                                <select name="class_id" id="class_id" class="form-select select2" required>
                                    <option value=""></option>                                     
                                    <option value="0" @if($notice->class_id =='0') selected @endif>All</option>
                                    <option value="Playgroup" @if($notice->class_id =='Playgroup') selected @endif>Playgroup</option>
                                    <option value="Nursery" @if($notice->class_id =='Nursery') selected @endif>Nursery</option>
                                    <option value="LKG" @if($notice->class_id =='LKG') selected @endif>LKG</option>
                                    <option value="UKG" @if($notice->class_id =='UKG') selected @endif>UKG</option>
                                    <option value="Class I" @if($notice->class_id =='Class I') selected @endif>Class I</option>
                                    <option value="Class II" @if($notice->class_id =='Class II') selected @endif>Class II</option>
                                    <option value="Class III" @if($notice->class_id =='Class III') selected @endif>Class III</option>
                                    <option value="Class IV" @if($notice->class_id =='Class IV') selected @endif>Class IV</option>
                                    <option value="Class V" @if($notice->class_id =='Class V') selected @endif>Class V</option>
                                    <option value="Class VI" @if($notice->class_id =='Class VI') selected @endif>Class VI</option>
                                    <option value="Class VII" @if($notice->class_id =='Class VII') selected @endif>Class VII</option>
                                    <option value="Class VIII" @if($notice->class_id =='Class VIII') selected @endif>Class VIII</option>
                                    <option value="Class IX" @if($notice->class_id =='Class IX') selected @endif>Class IX</option>
                                    <option value="Class X" @if($notice->class_id =='Class X') selected @endif>Class X</option>
                                    <option value="Class XI" @if($notice->class_id =='Class XI') selected @endif>Class XI</option>
                                    <option value="Class XII" @if($notice->class_id =='Class XII') selected @endif>Class XII</option>
                                </select>
                            </div>                             
                        </div> 
                        <div class="row mb-3">
                            <div class="col-lg-4">                      
                                <label for="section" class="form-label">{{ __('Section') }} :<span class="red">*</span></label>
                                <select name="section" id="section" class="form-select select2" required>
                                    <option value=""></option>
                                    <option value="0" @if($notice->section =='0') selected @endif>All</option> 
                                    <option value="1" @if($notice->section =='1') selected @endif>A1</option>  
                                    <option value="2" @if($notice->section =='2') selected @endif>A2</option>  
                                    <option value="3" @if($notice->section =='3') selected @endif>A3</option> 
                                    <option value="4" @if($notice->section =='4') selected @endif>A4</option> 
                                    <option value="5" @if($notice->section =='5') selected @endif>A5</option> 
                                    <option value="6" @if($notice->section =='6') selected @endif>A6</option> 
                                </select>
                            </div>
                            <div class="col-lg-4">                      
                                <label for="student_id" class="form-label">{{ __('Students') }} :<span class="red">*</span></label>
                                <select name="student_id[]" id="student_id" class="form-select select2" multiple>
                                    <option value=""></option>
                                    <!-- <option value="all" @if($notice->student_id =='0') selected @endif >All</option> -->
                                </select>
                            </div>
                            <div class="col-lg-3">    
                                <label class="form-label">Choose Image : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                                <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                            <div class="col-lg-1">    
                                <img id="filePreview" src="{{ asset($notice->image) }}" width="85px">
                            </div>                           
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
        if($notice->student_id != 0){
            $explodeArr = explode(',', $notice->student_id);
    }
    @endphp 
<script>
    var student_id = '{{ $notice->student_id }}'; 

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
        //console.log(studentArr); 
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
            $('#student_id').append($("<option value=''></option>")
                                        .attr("value", 'all')
                                        .attr("selected", '')
                                        .text('All'));
        }else{
            $('#student_id').append($("<option value=''></option>")
                                        .attr("value", 'all')
                                        .text('All'));
        }
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

                        if(student_id != 0 && is_first == 1)
                        {
                            if(studentArr.includes(value.userid) == true)
                            {
                                $('#student_id')
                                .append($("<option value=''></option>")
                                            .attr("value", value.userid)
                                            .attr("selected", '')
                                            .text(name)); 
                            }else{
                                $('#student_id')
                                    .append($("<option value=''></option>")
                                                .attr("value", value.userid)
                                                .text(name));
                            } 
                        }else{
                            $('#student_id')
                                .append($("<option value=''></option>")
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
@extends('backend.layouts.form')
@section('title', __('Sections') . ' | ' . $section->title)
@section('container', 'container-max-lg')
@section('back', route('admin.sections.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3" style="display: {{ ($section->id == 1)?'none':'block' }};">
                    <div class="col-lg-4 my-1">
                        <label class="form-label">{{ __('Account status') }} : </label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-on="{{ __('Active') }}"
                            data-off="{{ __('Inactive') }}" @if ($section->status) checked @endif>
                    </div>
                </div>
                <div class="row mb-3">  
                    <div class="col-md-10 mb-3">
                        <label class="form-label">{{ __('Title') }} : <span class="red">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $section->title }}" required>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">{{ __('Title Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="title_color" id="title_color" class="form-control" value="{{ $section->title_color }}">
                        </div>
                    </div>
                </div>                
                @if($section->id == 3 || $section->id == 7 || $section->id == 9)
                <div class="row mb-3">  
                    <div class="col-md-10 mb-3">
                        <label class="form-label">{{ __('Sub Title') }} : <span class="red">*</span></label>
                        <input type="text" name="sub_title" class="form-control" value="{{ $section->sub_title }}">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label">{{ __('Sub Title Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="sub_title_color" id="sub_title_color" class="form-control" value="{{ $section->sub_title_color }}">
                        </div>
                    </div>
                </div>
                @endif
                <div class="row mb-3">    
                    <div class="col-lg-4">
                        <label class="form-label">{{ __('BG Type') }} : <span class="red">*</span></label>
                        <select class="form-control select2" name="bg_type" required onchange="setGalletType(this.value)">
                            <option value="0" {{ ($section->bg_type =="0")?"selected":"" }}>Color</option>
                            <option value="1" {{ ($section->bg_type =="1")?"selected":"" }}>Image</option>
                        </select>
                    </div>
                    <div class="col-lg-4 bgtype" id="bgtype_0" style="display: {{ ($section->bg_type == 0)?'block':'none' }};">
                        <label class="form-label">{{ __('Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="bg_color" id="bg_color" class="form-control" value="{{ $section->bg_value }}">
                        </div>
                    </div>
                    <div class="col-lg-4 bgtype" id="bgtype_1" style="display: {{ ($section->bg_type == 1)?'block':'none' }};">
                        <label class="form-label">{{ __('Image') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                        <input type="file" name="image" id="bg_image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 bgtype" style="display: {{ ($section->bg_type == 1)?'block':'none' }};">
                        <div class="file-preview-box mb-3">
                            <img id="filePreview" src="{{ asset($section->bg_value) }}" class="rounded-3 w-100" height="160px">
                        </div>
                    </div>
                </div>
                @if($section->id == 5)
                <div class="row mb-3"> 
                    <div class="col-lg-4">
                        <label class="form-label">{{ __('Button Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="btn_color" id="btn_color" class="form-control" value="{{ $section->btn_color }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ __('Button Text Color') }} : <span class="red">*</span></label>
                        <div class="vironeer-color-picker input-group">
                            <span class="input-group-text colorpicker-input-addon">
                                <i></i>
                            </span>
                            <input type="text" name="btn_text_color" id="btn_text_color" class="form-control" value="{{ $section->btn_text_color }}">
                        </div>
                    </div>
                </div>
                @endif
                @if($section->id == 2)
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label class="form-label">{{ __('Line Color') }} : <span class="red">*</span></label>
                            <div class="vironeer-color-picker input-group">
                                <span class="input-group-text colorpicker-input-addon">
                                    <i></i>
                                </span>
                                <input type="text" name="line_color" id="line_color" class="form-control" value="{{ $section->line_color }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">{{ __('App Icon') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                            <input type="file" name="app_icon" id="app_icon" class="form-control" accept="image/png, image/jpg, image/jpeg">
                        </div>
                        <div class="col-lg-4">
                            <div class="file-preview-box mb-3">
                                <img class="img-responsive" width="75" src="{{ asset($section->app_icon) }}">
                            </div>
                        </div>
                    </div>
                @endif
                @if($section->id == 4)
                <hr>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <h5>
                            {{ __('Box') }}
                        </h5>
                    </div>
                    <div class="col-md-2">
                        <span style="cursor: pointer;" onClick="addMoreOther()"><i class="fa fa-plus fa-2x text-info"></i></span>
                    </div>
                </div>
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        @if($sectionOther)
                            @for($aid = 0; $aid < count($sectionOther); $aid++)
                                <div id="rid_{{ $aid }}">                       
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Text') }} : <span class="red">*</span></label>
                                            <input type="text" name="other_title_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->title }}" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">{{ __('Text Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_title_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->title_color }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-1"><br>
                                            <a href="javascript:void(0)" onClick="removeSection({{ $aid }}, {{ @$sectionOther[$aid]->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                        </div>   
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
                                            <select class="form-control select2" name="other_redirection_[{{ $sectionOther[$aid]->id }}]" onChange="getRedirectionType({{$sectionOther[$aid]->id}},'', this.value)" required>
                                                <option value=""></option>
                                                @if($redirectionList)
                                                    @foreach($redirectionList as $rrr)
                                                        <option value="{{ $rrr->id }}" {{ (@$sectionOther[$aid]->redirection == $rrr->id)?"selected":"" }}>{{ $rrr->title }}</option>
                                                    @endforeach
                                                @endif
                                                <!-- <option value="leave" {{ (@$sectionOther[$aid]->redirection =="leave")?"selected":"" }}>Leave</option>
                                                <option value="noticeboard" {{ (@$sectionOther[$aid]->redirection =="noticeboard")?"selected":"" }}>Noticeboard</option>
                                                <option value="bus_route" {{ (@$sectionOther[$aid]->redirection =="bus_route")?"selected":"" }}>Bus Routes</option>
                                                <option value="school_rule" {{ (@$sectionOther[$aid]->redirection =="school_rule")?"selected":"" }}>School Rule</option>
                                                <option value="query" {{ (@$sectionOther[$aid]->redirection =="query")?"selected":"" }}>Query</option> -->
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Icon') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                                            <input type="file" name="other_icon_{{ $sectionOther[$aid]->id }}" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="file-preview-box mb-3">
                                                <img class="img-responsive" width="75" src="{{ asset(@$sectionOther[$aid]->icon) }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="e{{ $sectionOther[$aid]->id }}" style="display: {{ (@$sectionOther[$aid]->redirection == 14)?'block':'none' }}">
                                        <div class="col-lg-12">
                                            <label class="form-label">{{ __('Redirection URL') }}</label>
                                            <input type="text" name="other_redirection_url[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->redirection_url }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-3">
                                            <label class="form-label">{{ __('Box Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_box_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->box_color }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                        <div class="more-section"></div>
                    </div>
                </div>
                @endif
                @if($section->id == 6)
                <hr>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <h5>
                            {{ __('Menu') }}
                        </h5>
                    </div>
                    <div class="col-md-2">
                        <span style="cursor: pointer;" onClick="addMoreOtherMenu()"><i class="fa fa-plus fa-2x text-info"></i></span>
                    </div>
                </div>
                <div class="card p-2 mb-3">
                    <div class="card-body">
                        @if($sectionOther)
                            @for($aid = 0; $aid < count($sectionOther); $aid++)
                                <div id="rid_{{ $aid }}">                       
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Text') }} : <span class="red">*</span></label>
                                            <input type="text" name="other_title_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->title }}" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">{{ __('Text Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_title_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->title_color }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-1"><br>
                                            <a href="javascript:void(0)" onClick="removeSection({{ $aid }}, {{ @$sectionOther[$aid]->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                        </div>  
                                    </div>
                                    <div class="row mb-3"> 
                                        <div class="col-md-8">
                                            <label class="form-label">{{ __('Sub Text') }} : <span class="red">*</span></label>
                                            <input type="text" name="other_sub_title_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->sub_title }}" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label">{{ __('Sub Text Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_sub_title_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->sub_title_color }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
                                            <select class="form-control select2" name="other_redirection_[{{ $sectionOther[$aid]->id }}]" onChange="getRedirectionType({{$sectionOther[$aid]->id}},'', this.value)" required>
                                                <option value=""></option>
                                                @if($redirectionList)
                                                    @foreach($redirectionList as $rrr)
                                                        <option value="{{ $rrr->id }}" {{ (@$sectionOther[$aid]->redirection == $rrr->id)?"selected":"" }}>{{ $rrr->title }}</option>
                                                    @endforeach
                                                @endif
                                                <!-- <option value="leave" {{ (@$sectionOther[$aid]->redirection =="leave")?"selected":"" }}>Leave</option>
                                                <option value="noticeboard" {{ (@$sectionOther[$aid]->redirection =="noticeboard")?"selected":"" }}>Noticeboard</option>
                                                <option value="bus_route" {{ (@$sectionOther[$aid]->redirection =="bus_route")?"selected":"" }}>Bus Routes</option>
                                                <option value="school_rule" {{ (@$sectionOther[$aid]->redirection =="school_rule")?"selected":"" }}>School Rule</option>
                                                <option value="query" {{ (@$sectionOther[$aid]->redirection =="query")?"selected":"" }}>Query</option> -->
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Icon') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                                            <input type="file" name="other_icon_{{ $sectionOther[$aid]->id }}" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="file-preview-box mb-3">
                                                <img class="img-responsive" width="75" src="{{ asset(@$sectionOther[$aid]->icon) }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3" id="e{{ $sectionOther[$aid]->id }}" style="display: {{ (@$sectionOther[$aid]->redirection == 14)?'block':'none' }}">
                                        <div class="col-lg-12">
                                            <label class="form-label">{{ __('Redirection URL') }}</label>
                                            <input type="text" name="other_redirection_url[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->redirection_url }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Icon Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_icon_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->icon_color }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">{{ __('Button Color') }} : <span class="red">*</span></label>
                                            <div class="vironeer-color-picker input-group">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                                <input type="text" name="other_btn_color_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->btn_color }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                        <div class="more-section"></div>
                    </div>
                </div>
                @endif
                @if($section->id > 10)
                    <hr>
                    @if($section->section_type == 0)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <h5>
                                    {{ __('Slider') }}
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <span style="cursor: pointer;" onClick="addMoreSlider()"><i class="fa fa-plus fa-2x text-info"></i></span>
                            </div>
                        </div>
                        <div class="card p-2 mb-3">
                            <div class="card-body">
                                @if($sectionOther)
                                    @for($aid = 0; $aid < count($sectionOther); $aid++)
                                        <div id="rid_{{ $aid }}">
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">{{ __('Image') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                                                    <input type="file" name="other_icon_{{ $sectionOther[$aid]->id }}" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="file-preview-box mb-3">
                                                        <img class="img-responsive" width="75" src="{{ asset(@$sectionOther[$aid]->icon) }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
                                                    <select class="form-control select2" name="other_redirection_[{{ $sectionOther[$aid]->id }}]" onChange="getRedirectionType('e',{{ $sectionOther[$aid]->id }}, this.value)" required>
                                                        <option value=""></option>
                                                        @if($redirectionList)
                                                            @foreach($redirectionList as $rrr)
                                                                <option value="{{ $rrr->id }}" {{ (@$sectionOther[$aid]->redirection == $rrr->id)?"selected":"" }}>{{ $rrr->title }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-lg-1"><br>
                                                    <a href="javascript:void(0)" onClick="removeSection({{ $aid }}, {{ @$sectionOther[$aid]->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                </div>
                                            </div>
                                            <div class="row mb-3" id="e{{ $sectionOther[$aid]->id }}" style="display: {{ (@$sectionOther[$aid]->redirection == 14)?'block':'none' }}">
                                                <div class="col-lg-12">
                                                    <label class="form-label">{{ __('Redirection URL') }}</label>
                                                    <input type="text" name="other_redirection_url_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->redirection_url }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                                <div class="more-section"></div>
                            </div>
                        </div>
                    @else
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <h5>
                                    {{ __('Video') }}
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <span style="cursor: pointer;" onClick="addMoreVideo()"><i class="fa fa-plus fa-2x text-info"></i></span>
                            </div>
                        </div>
                        <div class="card p-2 mb-3">
                            <div class="card-body">
                                @if($sectionOther)
                                    @for($aid = 0; $aid < count($sectionOther); $aid++)
                                        <div id="rid_{{ $aid }}">
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">{{ __('Thumbnail') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>
                                                    <input type="file" name="other_icon_{{ $sectionOther[$aid]->id }}" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="file-preview-box mb-3">
                                                        <img class="img-responsive" width="75" src="{{ asset(@$sectionOther[$aid]->icon) }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4" style="display: none;">
                                                    <label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>
                                                    <select class="form-control select2" name="other_redirection_[{{ $sectionOther[$aid]->id }}]" required>
                                                        <option value="14">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-1"><br>
                                                    <a href="javascript:void(0)" onClick="removeSection({{ $aid }}, {{ @$sectionOther[$aid]->id }})"><i class="fa fa-times fa-2x text-danger"></i></a>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label class="form-label">{{ __('URL') }}</label>
                                                    <input type="text" name="other_redirection_url_[{{ $sectionOther[$aid]->id }}]" class="form-control" value="{{ @$sectionOther[$aid]->redirection_url }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                                <div class="more-section"></div>
                            </div>
                        </div>
                    @endif
                @endif
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";
            $(function() {
                $('.vironeer-color-picker').colorpicker();
            });

            function setGalletType(gtype){
                $('.bgtype').css('display', 'none');
                if(gtype){
                    $('#bgtype_'+gtype).css('display', 'block');
                }
            }

            var counter = '{{ count($sectionOther) }}';
            function addMoreOther(){
                counter++;
                var html = '';
                html += '<div id="rid_'+counter+'">';
                html += '<div class="row mb-3">';
                html += '<div class="col-md-8">';
                html += '<label class="form-label">{{ __('Text') }} : <span class="red">*</span></label>';
                html += '<input type="text" name="other_title[]" class="form-control" required>';
                html += '</div>';
                html += '<div class="col-lg-3">';
                html += '<label class="form-label">{{ __('Text Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group"><span class="input-group-text colorpicker-input-addon"><i></i></span>';
                html += '<input type="text" name="other_title_color[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-lg-1"><br><a href="javascript:void(0)" onClick="removeSection('+counter+', 0)"><i class="fa fa-times fa-2x text-danger"></i></a></div>';
                html += '</div>';
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>';
                html += '<select class="form-control select2" name="other_redirection[]" required>';
                html += '<option value=""></option>';
                html += '<option value="leave">Leave</option>';
                html += '<option value="noticeboard">Noticeboard</option>';
                html += '<option value="bus_route">Bus Routes</option>';
                html += '<option value="school_rule">School Rule</option>';
                html += '<option value="query">Query</option>';
                html += '</select>';
                html += '</div>';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Icon') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>';
                html += '<input type="file" name="other_icon[]" class="form-control" accept="image/png, image/jpg, image/jpeg">';
                html += '</div>';
                html += '</div>';
                html += '<div class="row mb-3">';
                 html += '<div class="col-lg-3">';
                html += '<label class="form-label">{{ __('Box Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group"><span class="input-group-text colorpicker-input-addon"><i></i></span>';
                html += '<input type="text" name="other_box_color[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                $('.more-section').append(html);
                $('.vironeer-color-picker').colorpicker();
            }

            function addMoreOtherMenu(){
                counter++;
                var html = '';
                html += '<div id="rid_'+counter+'">';
                html += '<div class="row mb-3">';
                html += '<div class="col-md-8">';
                html += '<label class="form-label">{{ __('Text') }} : <span class="red">*</span></label>';
                html += '<input type="text" name="other_title[]" class="form-control" required>';
                html += '</div>';
                html += '<div class="col-lg-3">';
                html += '<label class="form-label">{{ __('Text Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group"><span class="input-group-text colorpicker-input-addon"><i></i></span>';
                html += '<input type="text" name="other_title_color[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-lg-1"><br><a href="javascript:void(0)" onClick="removeSection('+counter+', 0)"><i class="fa fa-times fa-2x text-danger"></i></a></div>';
                html += '</div>';
                html += '<div class="row mb-3">';
                html += '<div class="col-md-8">';
                html += '<label class="form-label">{{ __('Sub Text') }} : <span class="red">*</span></label>';
                html += '<input type="text" name="other_sub_title[]" class="form-control" required>';
                html += '</div>';
                html += '<div class="col-lg-3">';
                html += '<label class="form-label">{{ __('Sub Text Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group"><span class="input-group-text colorpicker-input-addon"><i></i></span>';
                html += '<input type="text" name="other_sub_title_color[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '</div>'; 
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>';
                html += '<select class="form-control select2 other_redirection_slider" name="other_redirection[]" onChange="getRedirectionType(9,'+counter+', this.value)" required>';
                html += '<option value=""></option>';
                @if($redirectionList)
                    @foreach($redirectionList as $rr)
                        html += '<option value="{{ $rr->id }}">{{ $rr->title }}</option>';
                    @endforeach
                @endif 
                html += '</select>';
                html += '</div>';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Icon') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>';
                html += '<input type="file" name="other_icon[]" class="form-control" accept="image/png, image/jpg, image/jpeg">';
                html += '</div>';
                html += '</div>';
                html += '<div class="row mb-3" id="e9'+counter+'" style="display: none;">';
                html += '<div class="col-lg-12">';
                html += '<label class="form-label">{{ __('Redirection URL') }}</label>';
                html += '<input type="text" name="other_redirection_url_new[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Icon Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group"><span class="input-group-text colorpicker-input-addon"><i></i></span><input type="text" name="other_icon_color[]" class="form-control"></div>';
                html += '</div>';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Button Color') }} : <span class="red">*</span></label>';
                html += '<div class="vironeer-color-picker input-group">';
                html += '<span class="input-group-text colorpicker-input-addon"><i></i></span>';
                html += '<input type="text" name="other_btn_color[]" class="form-control">';
                html += '</div>';
                html += '</div>';                
                html += '</div>';
                $('.more-section').append(html);
                $('.vironeer-color-picker').colorpicker();
                $(".other_redirection_slider").select2();
            }

            function addMoreSlider(){
                counter++;
                var html = '';
                html += '<div id="rid_'+counter+'">';   
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Image') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>';
                html += '<input type="file" name="other_icon[]" class="form-control" accept="image/png, image/jpg, image/jpeg">';
                html += '</div>';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>';
                html += '<select class="form-control select2 other_redirection_slider" name="other_redirection[]" onChange="getRedirectionType(1,'+counter+', this.value)" required>';
                html += '<option value=""></option>';
                @if($redirectionList)
                    @foreach($redirectionList as $rr)
                        html += '<option value="{{ $rr->id }}">{{ $rr->title }}</option>';
                    @endforeach
                @endif
                html += '</select>';
                html += '</div>';                
                html += '<div class="col-lg-1"><br><a href="javascript:void(0)" onClick="removeSection('+counter+', 0)"><i class="fa fa-times fa-2x text-danger"></i></a></div>';
                html += '</div>';
                html += '<div class="row mb-3" id="n1'+counter+'" style="display: none;">';
                html += '<div class="col-lg-12">';
                html += '<label class="form-label">{{ __('Redirection URL') }}</label>';
                html += '<input type="text" name="other_redirection_url[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                $('.more-section').append(html);
                $('.vironeer-color-picker').colorpicker();
                $(".other_redirection_slider").select2();
            }

            function getRedirectionType(type_, ids, val){
                if(type_ == 1){
                    var ids_ = 'n'+type_+''+ids;
                }
                else{                    
                    var ids_ = 'e'+type_+''+ids;
                }
                if(val == 14){
                    $('#'+ids_).css('display', 'block');
                }
                else{
                    $('#'+ids_).css('display', 'none');
                }
            }

            function addMoreVideo(){
                counter++;
                var html = '';
                html += '<div id="rid_'+counter+'">';   
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-4">';
                html += '<label class="form-label">{{ __('Thumbnail') }} : <span class="red">*</span> <small class="text-muted">{{ __('Allowed (PNG, JPG, JPEG)') }}</small></label>';
                html += '<input type="file" name="other_icon[]" class="form-control" accept="image/png, image/jpg, image/jpeg">';
                html += '</div>';
                html += '<div class="col-lg-4" style="display: none;">';
                html += '<label class="form-label">{{ __('Redirection') }} : <span class="red">*</span></label>';
                html += '<select class="form-control select2 other_redirection_slider" name="other_redirection[]">';
                html += '<option value="14">Other</option>';
                html += '</select>';
                html += '</div>';                
                html += '<div class="col-lg-1"><br><a href="javascript:void(0)" onClick="removeSection('+counter+', 0)"><i class="fa fa-times fa-2x text-danger"></i></a></div>';
                html += '</div>';
                html += '<div class="row mb-3">';
                html += '<div class="col-lg-12">';
                html += '<label class="form-label">{{ __('Redirection URL') }}</label>';
                html += '<input type="text" name="other_redirection_url[]" class="form-control">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                $('.more-section').append(html);
                $('.vironeer-color-picker').colorpicker();
            }
        </script>
    @endpush
@endsection

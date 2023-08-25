<form id="deatilsForm" action="{{ route('user.marinasProfileUpdate') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="row">
        <div class="col-lg-6">
            <h5>Basic form</h5>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }} :<span class="red">*</span></label>
                        <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control" required>
                    </div>
                </div>                
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Country') }} :<span class="red">*</span></label>
                        <select name="country" class="form-select" required>
                            <option value=""></option>
                            @foreach (countries() as $country)
                                @if($country->id == 110)
                                    <option value="{{ $country->id }}" selected>
                                        {{ $country->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">{{ __('City') }} :<span class="red">*</span></label>
                        <select name="city_id" class="form-select select2" required>
                            <option value=""></option>
                            @foreach ($cityList as $city)
                                <option value="{{ $city->id }}" {{ ($user->city_id == $city->id)?"selected":"" }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                
                <div class="col-lg-6 mb-3">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Postcode') }} :<span class="red">*</span></label>
                        <input type="text" name="zip" class="form-control" value="{{ @$user->address->zip }}" required>
                    </div>
                </div>            
                <div class="col-lg-6 mb-3">
                    <label class="form-label">{{ __('Book Show') }} :<span class="red">*</span></label><br>
                    <label class="switch">
                        @if(@$marinaDetail->book_show_status == 1)
                            <input type="checkbox" checked name="book_show_status">
                            <span class="slider"></span>
                        @else
                            <input type="checkbox" name="book_show_status">
                            <span class="slider"></span>
                        @endif
                    </label>
                </div>
            </div>                            
        </div>
        <div class="col-lg-6">
            <h5>Featured Amenities</h5>
            <div class="table-responsive">
                <table class="vironeer-normal-table table w-100">
                    <thead>
                        <tr>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($amenities)
                            @foreach($amenities as $key => $res)
                                <tr>
                                    <td><img src="{{ asset($res->icon) }}" width="50" alt="{{ $res->icon }}"></td>
                                    <td>{{ $res->amenity }}</td>
                                    <td class="text-center">
                                        <label class="switch">
                                            @if(in_array($res->id, $featuredAmenity))
                                                <input type="checkbox" checked onchange="featuredAmenitiesStatus(this, {{ $res->id }})">
                                                <span class="slider"></span>
                                            @else
                                                <input type="checkbox" onchange="featuredAmenitiesStatus(this, {{ $res->id }})">
                                                <span class="slider"></span>
                                            @endif
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>                      
        </div>        
    </div>    
    <div class="row">
        <div class="col-lg-12 dash__forms mb-3">
            <label class="form-label">{{ __('Description') }} :<span class="red">*</span></label>
            <textarea name="description" rows="3" class="form-control" required>{{ @$marinaDetail->description }}</textarea>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">{{ __('Number of Berth') }} :<span class="red">*</span></label>
                <input type="number" name="number_of_berth" maxlength="3" class="form-control" value="{{ @$marinaDetail->number_of_berth }}" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">{{ __('Type of Berth') }} :<span class="red">*</span></label>
                <input type="text" name="type_of_berth" class="form-control" value="{{ @$marinaDetail->type_of_berth }}" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">{{ __('Max Draft') }} :<span class="red">*</span></label>
                <input type="number" name="max_draft" maxlength="3" class="form-control" value="{{ @$marinaDetail->max_draft }}" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">{{ __('Max Length') }} :<span class="red">*</span></label>
                <input type="number" name="max_length" maxlength="3" class="form-control" value="{{ @$marinaDetail->max_length }}" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-3 dash__forms">
            <label class="form-label">{{ __('Cancellation Policy') }} :<span class="red">*</span></label>
            <textarea name="cancellation_policy" rows="3" class="form-control" required>{{ @$marinaDetail->cancellation_policy }}</textarea>
        </div>
        <div class="col-lg-12 mb-3 dash__forms">
            <label class="form-label">{{ __('Getting to Marina') }} :<span class="red">*</span></label>
            <textarea name="getting_to_marina" rows="3" class="form-control" required>{{ @$marinaDetail->getting_to_marina }}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">{{ __('Address') }} :<span class="red">*</span></label>
                <input type="text" name="address_1" value="{{ @$user->address->address_1 }}" id="full_address" class="form-control" required onFocus="geolocate()">
                <input type="hidden" id="latitude" name="latitude" value="{{ @$user->address->latitude }}" >
                <input type="hidden" id="longitude" name="longitude" value="{{ @$user->address->longitude }}" >
            </div>
        </div>
    </div>
    @if(!empty($user->address->address_1))
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="mb-3">
                    <h5 class="panel-heading">Map Details (Marina Center Spot)</h5>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="886" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q={{ @$user->address->latitude }},%20{{ @$user->address->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://embedgooglemap.net/124/">Framesport</a><br><style>.mapouter{position:relative;text-align:right;height:300px;width:886px;}</style><a href="https://www.embedgooglemap.net"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:886px;}</style></div></div>
            </div>
        </div> 
    @endif
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-secondary">
                <i class="far fa-save"></i>
                {{ lang('Save', 'user') }}
            </button>
        </div>
    </div>
</form>
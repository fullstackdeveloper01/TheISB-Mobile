<div class="row">
    <div class="col-lg-6">
        <h3>Basic form</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }} :<span class="red">*</span></label>
                    <input type="text" name="firstname" value="{{ $user->firstname.' '.$user->lastname }}" class="form-control" disabled required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('Description') }} :<span class="red">*</span></label>
                    <textarea name="description" class="form-control" disabled required></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('City') }} :<span class="red">*</span></label>
                    <select name="city_id" class="form-select select2" disabled required>
                        <option value=""></option>
                        @foreach ($cityList as $city)
                            <option value="{{ $city->id }}" {{ ($user->city_id == $city->id)?"selected":"" }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Country') }} :<span class="red">*</span></label>
                    <input type="text" name="country" class="form-control" disabled value="Italy" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Address') }} :<span class="red">*</span></label>
                    <input type="text" name="address_1" class="form-control" disabled required value="{{ @$user->address_1 }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Postcode') }} :<span class="red">*</span></label>
                    <input type="text" name="country" class="form-control" disabled required>
                </div>
            </div>
        </div>                            
    </div>
    <div class="col-lg-6">
        <h3>Contact Person Information</h3>
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">{{ __('Contact Image') }}</label>
                    @if("images/avatars/default.png" == $user->avatar)
                        <img src="{{ asset('images/avatars/default.png') }}" class="rounded-circle border" width="100px" height="100px">
                    @else
                        <img src="{{ asset($user->avatar) }}" class="border" width="100px" height="100px">
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }} :<span class="red">*</span></label>
                            <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control" disabled required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Surname') }} :<span class="red">*</span></label>
                            <input type="text" name="surname" value="{{ $user->lastname }}" class="form-control" disabled required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }} :<span class="red">*</span></label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" disabled required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('Website') }} :<span class="red">*</span></label>
                    <input type="url" name="website" class="form-control" disabled required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('Phone Number') }} :<span class="red">*</span></label>
                    <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control" disabled required>
                </div>
            </div>
        </div>                            
    </div>
</div>
<div class="card custom-card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <h4 class="panel-heading">Map Details (Marina Center Spot)</h4>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="886" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=42.001977,%2015.001103&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://embedgooglemap.net/124/">birds of prey 123movies</a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:886px;}</style><a href="https://www.embedgooglemap.net"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:886px;}</style></div></div>
            </div>
        </div>  
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <h4 class="panel-heading">Extra Details</h4>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <label class="form-label">{{ __('Cancellation Description') }}</label>
            <textarea class="form-control" disabled></textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">{{ __('Check-in Description') }}</label>
            <textarea class="form-control" disabled></textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">{{ __('Check-out Description') }}</label>
            <textarea class="form-control" disabled></textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">{{ __('Berth Capacity') }}</label>
            <input type="number" name="phone_number" class="form-control" disabled required>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">{{ __('Max Boat Length') }}</label>
            <input type="text" name="phone_number" class="form-control" disabled required>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <label class="form-label">{{ __('VHF Channels') }}</label>
            <textarea class="form-control" disabled></textarea>
        </div>
    </div>  
</div>  
@extends('backend.layouts.grid')
@section('title', __('Booking Details ID #35415'))
{{-- @section('link', route('admin.services.create')) --}}
@section('back', route('admin.bookings.index'))
@section('content')
	<div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-8 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Booked Date Time') }}</h3>
                <p class="vironeer-counter-box-number"></p>
                <small>{{ '21 Feb, 2023 11:30' }}</small>
                <span class="vironeer-counter-box-icon">
                    
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-9 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Approved Date Time') }}</h3>
                <p class="vironeer-counter-box-number"></p>
                <small>{{ '21 Feb, 2023 12:30' }}</small>
                <span class="vironeer-counter-box-icon">
                    
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-10 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Arrival Date Time') }}</h3>
                <p class="vironeer-counter-box-number"></p>
                <small>{{ '21 Feb, 2023 11:30' }}</small>
                <span class="vironeer-counter-box-icon">
                    
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-11 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Departure Date time') }}</h3>
                <p class="vironeer-counter-box-number"></p>
                <small>{{ '23 Feb, 2023 05:00' }}</small>
                <span class="vironeer-counter-box-icon">
                    
                </span>
            </div>
        </div>
    </div>
    <div class="card custom-card">
        <div class="card-body">
            <div class="row">
			    <div class="col-lg-6">
			        <h3>User Information</h3>
			        <div class="row">
			            <div class="col-lg-12">
			                <div class="mb-3">
			                    <label class="form-label">Name :<span class="red">*</span></label>
			                    <input type="text" name="firstname" value="Marina di S. Pietro" class="form-control" disabled="" required="">
			                </div>
			            </div>
			            <div class="col-lg-12">
			                <div class="mb-3">
			                    <label class="form-label">Email :<span class="red">*</span></label>
			                    <input type="email" name="email" value="philip@mailinator.com" class="form-control" disabled="" required="">
			                </div>
			            </div>
			            
			            <div class="col-lg-6">
			                <div class="mb-3">
			                    <label class="form-label">Phone number :<span class="red">*</span></label>
			                    <input type="text" name="address_1" class="form-control" disabled="" required="" value="+938639699928">
			                </div>
			            </div>
			            <div class="col-lg-6">
			                <div class="mb-3">
			                    <label class="form-label">City :<span class="red">*</span></label>
			                    <input type="text" name="country" class="form-control" disabled="" required="" value="Termoli">
			                </div>
			            </div>
			        </div>                            
			    </div>
			    <div class="col-lg-6">
			        <h3>Marina Information</h3>
			        <div class="row">
			            <div class="col-lg-4">
			                <div class="mb-3">
			                    <label class="form-label">Contact Image :<span class="red">*</span></label>
			                    <img src="https://framesport.manageprojects.in/images/avatars/default.png" class="rounded-circle border" width="100px" height="100px">
			                </div>
			            </div>
			            <div class="col-lg-8">
			                <div class="row">
			                    <div class="col-lg-12">
			                        <div class="mb-3">
			                            <label class="form-label">Name :<span class="red">*</span></label>
			                            <input type="text" name="firstname" value="Marina di" class="form-control" disabled="" required="">
			                        </div>
			                    </div>
			                    <div class="col-lg-12">
			                        <div class="mb-3">
			                            <label class="form-label">Surname :<span class="red">*</span></label>
			                            <input type="text" name="surname" value="S. Pietro" class="form-control" disabled="" required="">
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-lg-12">
			                <div class="mb-3">
			                    <label class="form-label">Email :<span class="red">*</span></label>
			                    <input type="email" name="email" value="spietro@mailinator.com" class="form-control" disabled="" required="">
			                </div>
			            </div>
			            <div class="col-lg-12">
			                <div class="mb-3">
			                    <label class="form-label">Phone Number :<span class="red">*</span></label>
			                    <input type="text" name="mobile" value="+938639699928" class="form-control" disabled="" required="">
			                </div>
			            </div>
			        </div>                            
			    </div>
			</div><hr>        
            <div class="row">
			    <div class="col-lg-12">
			        <h3>Boat Details</h3>
			        <div class="row">
			            <div class="col-lg-3">
			                <div class="mb-3">
			                    <img src="https://images.unsplash.com/photo-1563030249-d73af8d6c8db?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1176&q=80" width="100px" height="100px">
			                </div>
			            </div>
	                    <div class="col-lg-3">
	                        <div class="mb-3">
	                            <label class="form-label">Boat Name</label>
	                            <input type="text" name="surname" value="Termoli 56" class="form-control" disabled="">
	                        </div>
	                    </div>
			        </div>
			        <div class="row">
	                    <div class="col-lg-3">
	                        <div class="mb-3">
	                            <label class="form-label">Boat Type :<span class="red">*</span></label>
	                            <input type="text" name="surname" class="form-control" disabled="" value="Motor boat">
	                        </div>
	                    </div>
	                    <div class="col-lg-3">
	                        <div class="mb-3">
	                            <label class="form-label">Length :<span class="red">*</span></label>
	                            <input type="text" name="surname" class="form-control" disabled="" value="10.00m">
	                        </div>
	                    </div>
	                    <div class="col-lg-3">
	                        <div class="mb-3">
	                            <label class="form-label">Width :<span class="red">*</span></label>
	                            <input type="text" name="surname" class="form-control" disabled="" value="4.00m">
	                        </div>
	                    </div>
	                    <div class="col-lg-3">
	                        <div class="mb-3">
	                            <label class="form-label">Draught :<span class="red">*</span></label>
	                            <input type="text" name="surname" class="form-control" disabled="" value="3.00m">
	                        </div>
	                    </div>
			        </div>                          
			    </div>
			</div>                
        </div>
    </div>
@endsection

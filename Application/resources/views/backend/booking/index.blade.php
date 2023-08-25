@extends('backend.layouts.grid')
@section('title', __('Booking'))
{{-- @section('link', route('admin.services.create')) --}}
@section('content')
	<div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-8 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Booking') }}</h3>
                <p class="vironeer-counter-box-number">{{ '03' }}</p>
				<small>{{ __('Date Time') }}</small>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-book"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-9 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Pending Booking') }}</h3>
                <p class="vironeer-counter-box-number">{{ '0' }}</p>
				<small>{{ __('Date Time') }}</small>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-th-list"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-10 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Approved Bookings') }}</h3>
                <p class="vironeer-counter-box-number">{{ '0' }}</p>
                <small>{{ __('Date Time') }}</small>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-th"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="custom-card card">        
		<div class="table-responsive">
			<table class="vironeer-normal-table table w-100">
				<thead>
					<tr>
						<th class="tb-w-3x">#ID</th>
						<th>{{ __('User Details') }}</th>
						<th>{{ __('Marina Details') }}</th>
						<th>{{ __('Arrival Date Time') }}</th>
						<th>{{ __('Departure Date Time') }}</th>
						<th class="tb-w-3x text-center">{{ __('Status') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<a href="{{ route('admin.bookings.show', 1) }}" class="text-center">#35415</a>
						</td>
						<td>
							<div class="vironeer-user-box">
								<a href="javascript::void()">
									<span class="profileImage">PS</span>
								</a>
								<div>
									<a class="text-reset" href="javascript::void()">Philip Srant</a>
									<p class="text-muted mb-0">philip@mailinator.com</p>
								</div>
							</div>
						</td>
						<td>
							<div class="vironeer-user-box">
								<a href="javascript::void()">
									<span class="profileImage">MP</span>
								</a>
								<div>
									<a class="text-reset" href="javascript::void()">Marina di S. Pietro</a>
									<p class="text-muted mb-0">spietro@mailinator.com</p>
								</div>
							</div>
						</td>
						<td>21 Feb, 2023 11:30</td>
						<td>23 Feb, 2023 05:00</td>
						<td class="text-center">{!! userStatus(1) !!}</td>
					</tr>
					<tr>
						<td>
							<a href="{{ route('admin.bookings.show', 1) }}" class="text-center">#21458</a>
						</td>
						<td>
							<div class="vironeer-user-box">
								<a href="javascript::void()">
									<span class="profileImage">JG</span>
								</a>
								<div>
									<a class="text-reset" href="javascript::void()">Jackson Garner</a>
									<p class="text-muted mb-0">jackson@mailinator.com</p>
								</div>
							</div>
						</td>
						<td>
							<div class="vironeer-user-box">
								<a href="javascript::void()">
									<span class="profileImage">PC</span>
								</a>
								<div>
									<a class="text-reset" href="javascript::void()">Porto turistico Santa Cristina</a>
									<p class="text-muted mb-0">porto@mailinator.com</p>
								</div>
							</div>
						</td>
						<td>19 Feb, 2023 10:45</td>
						<td>22 Feb, 2023 04:22</td>
						<td class="text-center">{!! userStatus(1) !!}</td>						
					</tr>
				</tbody>
			</table>
		</div>
    </div>
    {{--
    @if (!request()->input('search') && !request()->input('filter'))
        {{ $bookingList->links() }}
    @endif
    --}}
@endsection

@extends('frontend.user.layouts.dash')
@section('title', lang('Log details', 'user'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-3">
                @include('frontend.user.marinas.sidebar')
            </div>
            <div class="col-xl-9">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <div class="row">
                                <div class="col-xl-12">
									<div class="table-responsive">
										<table class="vironeer-normal-table table w-100">
											<thead>
												<tr>
													<th class="tb-w-3x">#ID</th>
													<th>{{ __('IP Address') }}</th>
													<th>{{ __('Location') }}</th>
													<th>{{ __('Timezone') }}</th>
													<th>{{ __('Latitude') }}</th>
													<th>{{ __('Longitude') }}</th>
													<th>{{ __('Browser') }}</th>
													<th>{{ __('OS') }}</th>
												</tr>
											</thead>
											<tbody>
												@if($logs)
													@foreach($logs as $key => $log)
														<tr>
															<td>{{ $key+1 }}</td>
															<td>{{ $log->ip }}</td>
															<td>{{ $log->location }}</td>
															<td>{{ $log->timezone }}</td>
															<td>{{ $log->latitude }}</td>
															<td>{{ $log->longitude }}</td>
															<td>{{ $log->browser }}</td>
															<td>{{ $log->os }}</td>
														</tr>
													@endforeach
												@endif
											</tbody>
										</table>
									</div>
									{{ $logs->links() }}
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

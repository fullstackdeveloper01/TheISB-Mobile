@extends('backend.layouts.grid')
@section('title', __('Marinas Request List'))
@section('content')
    <div class="card custom-card">
        <table class="vironeer-normal-table table w-100" id="datatable">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th class="tb-w-7x">{{ __('Marina Name') }}</th>
                    <th class="tb-w-5x">{{ __('Email') }}</th>
                    <th class="tb-w-5x">{{ __('Phone Number') }}</th>
                    <th class="tb-w-5x">{{ __('Request Date') }}</th>
                    <th class="tb-w-5x">{{ __('Status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestList as $key => $requests)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><i class="fas fa-ship"></i> {{ $requests->firstname }}</td>
                        <td>{{ $requests->email }}</td>
                        <td>{{ $requests->mobile }}</td>
                        <td>{{ vDate($requests->created_at) }}</td>
                        <td>
                            @if($requests->request_status == 2)
                                <a href="javascript:void(0)" class="text-center">
                                    <span class="badge bg-success">{{ __('Approved') }}</span>
                                </a>
                            @elseif($requests->request_status == 3)
                                <a href="javascript:void(0)">
                                    <span class="badge bg-danger" class="text-center">{{ __('Rejected') }}</span>
                                </a>
                            @else
                                <div id="marinasn{{ $requests->id }}">                                    
                                    <a href="javascript:void(0)">
                                        <span class="badge bg-primary text-center" onClick="marinaApproved({{ $requests->id }}, 2)">{{ __('Approve') }}</span>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <span class="badge bg-warning text-center" onClick="marinaApproved({{ $requests->id }}, 3)">{{ __('Reject') }}</span>
                                    </a>
                                </div>
                                <div class="marinasn{{ $requests->id }}"></div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
    {{ $requestList->links() }}
@endsection
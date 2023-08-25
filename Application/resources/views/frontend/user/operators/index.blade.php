@extends('frontend.user.layouts.dash')
@section('title', lang('Operators', 'user'))
@section('link', route('user.operator.create'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        @if ($operatersList->count() > 0)
                        <div class="transactions-table">
                            <div class="vr__table">
                                <table>
                                    <thead>
                                        <th>{{ lang('#ID') }}</th>
                                        <th class="text-center">{{ lang('Name', 'user') }}</th>
                                        <th class="text-center">{{ lang('Email', 'user') }}</th>
                                        <th class="text-center">{{ lang('Mobile', 'user') }}</th>
                                        <th class="text-center">{{ lang('Created Date', 'user') }}</th>
                                        <th class="text-center">{{ lang('Status', 'user') }}</th>
                                        <th class="text-center">{{ lang('Action', 'user') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($operatersList as $key => $operater)
                                            <tr>
                                                <td>#{{ $key+1 }} </td>
                                                <td>
                                                    {{ $operater->firstname.' '.$operater->lastname }}
                                                </td>
                                                <td>
                                                    {{ $operater->email }}
                                                </td>
                                                <td>
                                                    {{ $operater->mobile }}
                                                </td>
                                                <td class="text-center">{{ vDate($operater->created_at) }}</td>
                                                <td class="text-center">
                                                    @if ($operater->status == 1)
                                                        <span class="badge bg-success">{{ lang('Active', 'user') }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ lang('Deactive', 'user') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.operator.edit', $operater->id)}}" class="btn btn-blue btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $operatersList->links() }}
                        </div>
                    @else
                        @include('frontend.user.includes.empty-full')
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

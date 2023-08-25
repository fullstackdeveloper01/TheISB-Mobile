@extends('backend.layouts.form')
@section('title', __('Sections'))
@section('container', 'container-max-lg')
@section('link', route('admin.sections.create'))
@if ($sectionList->count() == 0)
    @section('btn_action', 'disabled')
@endif
{{--@section('language', true)--}}
@section('content')
    @if ($sectionList->count() > 0)
        <form id="vironeer-submited-form" action="{{ route('admin.sections.sort') }}" method="POST">
            @csrf
            <input name="ids" id="ids" value="{{ $idsArray }}" hidden>
        </form>
        <div class="card mb-3">
            <ul class="vironeer-sort-menu custom-list-group list-group list-group-flush">
                @foreach ($sectionList as $section)
                    <li data-id="{{ $section->id }}" class="list-group-item d-flex justify-content-between align-items-center preset{{ $section->id }}-bg">
                        <h5 class="m-0">
                            <span class="vironeer-navigation-handle me-2 text-muted"><i class="fas fa-arrows-alt"></i></span>
                            <span class="text-secondary">{{ $section->title }}</span>
                        </h5>
                        <div class="buttons">
                            @if($section->status ==1)
                                <i class="fa fa-circle text-success"></i>
                            @else
                                <i class="fa fa-circle text-danger"></i>
                            @endif
                            <a class="btn btn-sm me-2" href="{{ route('admin.sections.edit', $section->id) }}">
								<i class="fa fa-edit text-muted"></i>
							</a>
							{{--<form class="d-inline" action="{{ route('admin.sections.destroy', $section->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="vironeer-able-to-delete btn btn-danger btn-sm"><i
                                        class="far fa-trash-alt"></i></button>
                            </form>--}}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @include('backend.includes.empty')
            </div>
        </div>
    @endif
    @if ($sectionList->count() > 0)
        @push('styles_libs')
            <link href="{{ asset('assets/vendor/libs/jquery/jquery-ui.min.css') }}" />
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('assets/vendor/libs/jquery/jquery-ui.min.js') }}"></script>
        @endpush
    @endif
@endsection

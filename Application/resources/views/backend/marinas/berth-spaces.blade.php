@extends('backend.layouts.form')
@section('title', $marina->firstname . ' ' . $marina->lastname . ' | Details')
@section('back', route('admin.marinas.index'))
@section('content')
    <div class="row">
        <div class="col-lg-3">
           @include('backend.marinas.sidebar')
        </div>
        <div class="col-lg-9">
            @include('backend.marinas.profile-sidebar') 
            <div class="row">
                <div class="col-lg-6">
                    <h3>Berth Spaces</h3>
                </div>
            </div>           
            <div class="card custom-card">
                <div class="card-body">
                    @include('backend.marinas.tab.berth-spaces')                    
                </div>
            </div>
        </div>
    </div>
@endsection

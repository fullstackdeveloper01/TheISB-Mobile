@extends('backend.layouts.grid')
@section('title', __('Galleries'))
@section('link', route('admin.galleries.create'))
@section('content')
	<div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-6" onclick="showGallery('photos')" style="cursor: pointer;">
            <div class="vironeer-counter-box bg-success">
                <h3 class="vironeer-counter-box-title">{{ __('Photos') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalPhotos }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-file-image"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-6" onclick="showGallery('videos')" style="cursor: pointer;">
            <div class="vironeer-counter-box bg-danger">
                <h3 class="vironeer-counter-box-title">{{ __('Videos') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalVideos }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-film"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="gallerytype_" id="gallerytype_photos"> 
        @if(count($galleryPhotos) > 0)
            <div class="card">
                <table id="datatable" class="table w-100">
                    <thead>
                        <tr>
                            <th class="tb-w-2x">{{ __('#') }}</th>
                            <th class="tb-w-7x">{{ __('Title') }}</th>
                            <th class="tb-w-7x">{{ __('Photo') }}</th>
                            <!-- <th class="tb-w-7x">{{ __('Featured') }}</th> -->
                            <!-- <th class="tb-w-7x">{{ __('Created Date') }}</th> -->
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($galleryPhotos as $gallery)
                            <tr class="item">
                                <td>{{ $gallery->id }}</td>
                                <td>{{ $gallery->title }}</td>
                                <td>
                                    <div class="row mb-4">
                                        @if($galleries)
                                            @foreach($galleries as $rrr)
                                                @if($gallery->id == $rrr->gallery_id)
                                                    <div class="col-lg-2">
                                                        <img src="{{ asset($rrr->item_value) }}" class="rounded" width="60" height="60"><br>
                                                        <input type="radio" name="featured_status" {{ ($rrr->featured_status == 1)?"checked":"" }} onclick="return confirmationFeatured('{{ $rrr->id }}')" >
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <!-- <td>{{ vDate($gallery->created_at) }}</td> -->
                                <td>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                            aria-expanded="true">
                                            <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
        								    <!-- <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.galleries.edit', $gallery->id) }}"><i
                                                        class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li> -->
                                            <li>
                                                <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                            class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="custom-card card">
                @include('backend.includes.empty')
            </div>
        @endif
    </div>
    <div class="gallerytype_" id="gallerytype_videos" style="display: none;"> 
        @if(count($videoGalleries) > 0)
            <div class="card">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="tb-w-2x">{{ __('#') }}</th>
                            <th class="tb-w-7x">{{ __('Title') }}</th>
                            <th class="tb-w-7x">{{ __('Video') }}</th>
                            <th class="tb-w-7x">{{ __('Created Date') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $snn = 1; @endphp
                        @foreach ($videoGalleries as $gallery)
                            <tr class="item">
                                <td>{{ $gallery->id }}</td>
                                <td>{{ $gallery->gallery->title }}</td>
                                <td>
                                    <iframe width="220" height="115" src="https://www.youtube.com/embed/{{ $gallery->item_value }}"></iframe>
                                    {{--<video width="100" height="100" controls>
                                        <source src="https://youtu.be/{{ $gallery->item_value }}">
                                    </video>--}}
                                </td>
                                <td>{{ vDate($gallery->created_at) }}</td>
                                <td>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                            aria-expanded="true">
                                            <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                            <!-- <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.galleries.edit', $gallery->id) }}"><i
                                                        class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li> -->
                                            <li>
                                                <form action="{{ route('admin.galleries.destroy', $gallery->gallery_id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                            class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="custom-card card">
                @include('backend.includes.empty')
            </div>
        @endif
    </div>
    @push('top_scripts')
        <script>
            "use strict";                
            function showGallery(gtype){
                $('.gallerytype_').css('display', 'none');
                if(gtype){
                    $('#gallerytype_'+gtype).css('display', 'block');
                }
            }            
        </script>
    @endpush
@endsection

@extends('frontend.user.layouts.dash')
@section('title', lang('Edit Berth-Space', 'user'))
@section('back', route('user.berthSpace'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row g-3">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ lang('Berth-Space', 'user') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.berthSpace.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ lang('Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="{{ lang('Name', 'forms') }}" maxlength="50" value="{{ $berth_data->name }}" required>
                                        <input type="hidden" name="id" class="form-control" value="{{ $berth_data->id }}" required>
                                        <input type="hidden" name="coordinates" class="form-control" id="coordinates" value="{{ $berth_data->coordinates }}">
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="form-group col-md-12">
                                        <small class="help-block with-errors text-danger"></small>
                                        <div id="berthMap" class="width: 100%;" style="height: 450px;"></div>
                                        <script>
                                            let lat = 42.00228;
                                            let lng = 15.00124;
                                            // enable map with draw controls and draw mode
                                            let map = L.map('berthMap').setView([lat, lng], 18);
                                            // add the OpenStreetMap tiles
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                attribution: '',
                                                maxZoom: 18,
                                                minZoom: 16,
                                            }).addTo(map);

                                            // Stop the drag and zoom handlers.
                                            map.dragging.disable();
                                            map.touchZoom.disable();
                                            map.doubleClickZoom.disable();
                                            map.scrollWheelZoom.disable();
                                            map.boxZoom.disable();
                                            map.keyboard.disable();
                                            $(".leaflet-control-zoom").css("visibility", "hidden");

                                            map.pm.addControls({
                                                position: 'topleft',
                                                drawRectangle: true,
                                                dragMode: true,
                                                removalMode: true,
                                                rotateMode: true,
                                                editMode: true,
                                                // all other controls are disabled
                                                cutPolygon: false,
                                                drawCircle: false,
                                                drawMarker: false,
                                                drawCircleMarker: false,
                                                drawPolygon: false,
                                                drawPolyline: false,
                                                drawLine: false,
                                                drawCut: false,
                                                drawText: false,
                                            });

                                            function updateCoordinates(e) {
                                                let layer = e.layer;
                                                let latLngs = layer.getLatLngs();
                                                let angle = layer.pm._angle || 0;
                                                let coordinates = {
                                                    coordinates: latLngs,
                                                    angle: angle
                                                };
                                                $('#coordinates').val(JSON.stringify(coordinates));
                                            }

                                            map.on('pm:drawstart', function (e) {
                                                // remove all layers
                                                map.eachLayer(function (layer) {
                                                    if (layer instanceof L.Polygon) {
                                                        map.removeLayer(layer);
                                                    }
                                                });
                                            });

                                            map.on('pm:create', (e) => {

                                                updateCoordinates(e);
                                                const layer = e.layer;
                                                layer.on('pm:edit', (e) => {
                                                    updateCoordinates(e);
                                                });
                                            });

                                            map.on('pm:remove', () => {
                                                $('#coordinates').val('');
                                            });
                                            let colors = [
                                                {status: 'Available', color: '#27ec27'},
                                                {status: 'Reserved', color: '#1a81e7'},
                                                {status: 'Occupied', color: '#c71515'},
                                                {status: 'Default', color: '#2f2d2d'},
                                            ];
                                            // If the user has already defined a berth, we draw it on the map
                                            @if($berth_data->coordinates)
                                                let coordinates = JSON.parse('{!! $berth_data->coordinates !!}');
                                                let latLngs = coordinates.coordinates;
                                                let angle = coordinates.angle;
                                                let status = '{!! $berth_data->status !!}';
                                                // check if the status matches any of the statuses in the colors
                                                let color = colors.find(c => c.status === status);
                                                if (color) {
                                                    color = color.color;
                                                } else {
                                                    color = colors.find(c => c.status === 'Default').color;
                                                }
                                                L.polygon(latLngs, {color: color}).addTo(map);
                                            @endif

                                        </script>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Length', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="length" value="{{ $berth_data->length }}" class="form-control" placeholder="{{ lang('Length', 'forms') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Width', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="width" value="{{ $berth_data->width }}" class="form-control" placeholder="{{ lang('Width', 'forms') }}" required>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Depth', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="depth" value="{{ $berth_data->depth }}" class="form-control" placeholder="{{ lang('Depth', 'forms') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Rotation', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="rotation" value="{{ $berth_data->rotation }}" class="form-control" placeholder="{{ lang('Rotation', 'forms') }}" required>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <!-- A dropdown map type selection, GMap or OpenStreetMap-->
                                    <div class="col-md-6" style="display: none;">
                                        <label class="form-label">{{ lang('Map Type', 'forms') }} : <span class="red">*</span></label>
                                        <select class="form-control" name="map_type" id="map_type">
                                            <option value="GMap" {{ ($berth_data->map_type == "GMap")?"selected":"" }}>GMap</option>
                                            <option value="OpenStreetMap" {{ ($berth_data->map_type == "OpenStreetMap")?"selected":"" }}>OpenStreetMap</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ lang('Status', 'forms') }} : <span class="red">*</span></label>
                                        <select class="form-control" name="status" id="status">
                                            <option value=""></option>
                                            <option value="Available" {{ ($berth_data->status == "Available")?"selected":"" }}>Available</option>
                                            <option value="Unavailable" {{ ($berth_data->status == "Unavailable")?"selected":"" }}>Unavailable</option>
                                            <option value="Reserved" {{ ($berth_data->status == "Reserved")?"selected":"" }}>Reserved</option>
                                            <option value="Occupied" {{ ($berth_data->status == "Occupied")?"selected":"" }}>Occupied</option>
                                            <option value="Under Maintenance" {{ ($berth_data->status == "Under Maintenance")?"selected":"" }}>Under Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="form-group col-md-12">
                                        <label class="form-label">{{ lang('Additional Params', 'forms') }} : <span class="red">*</span></label>
                                        <div id="berth_data" class="row">
                                            <div class="col-md-12 mb-2">
                                                <div class="row">
                                                    @if($berth_data->additional_params)
                                                        @foreach(json_decode($berth_data->additional_params) as $key => $value)
                                                            <div class="col-md-12 mb-2">
                                                                <div class="input-group">
                                                                    <input type="text" name="additional_params_names[]"
                                                                           class="form-control"
                                                                           placeholder="{{__('Key')}}" value="{{$key}}">
                                                                    <select name="additional_params_values[]" class="form-control">
                                                                        <option value="1" @if($value == 1) selected @endif>{{__('True')}}</option>
                                                                        <option value="0" @if($value == 0) selected @endif>{{__('False')}}</option>
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-danger" type="button"
                                                                                onclick="removeBerthData(this)"><i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button id="addParam" type="button" class="btn btn-primary add-berth-data"><i
                                                class="fa fa-plus"></i></button>
                                        <script>
                                            // Add a new key value pair input
                                            $('#addParam').click(function () {
                                                let berth_data = $('#berth_data');
                                                let index = berth_data.children().length;
                                                let input = '<div class="col-md-12 mb-2"><div class="input-group"><input type="text" name="additional_params_names[]" class="form-control" placeholder="{{__('Key')}}"><input type="text" name="additional_params_values[]" class="form-control" placeholder="{{__('Value')}}"><div class="input-group-append"><button class="btn btn-danger" type="button" onclick="removeBerthData(this)"><i class="fas fa-trash"></i></button></div></div></div>';
                                                berth_data.append(input);
                                            });

                                            // Remove a key value pair input
                                            function removeBerthData(element) {
                                                $(element).parent().parent().parent().remove();
                                            }
                                        </script>
                                    </div>
                                </div><hr>
                                <button class="btn btn-secondary" type="submit"><i class="far fa-save"></i>
                                    {{ lang('Update', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.user.layouts.dash')
@section('title', 'Add New Berth-Space')
@section('back', route('user.berthSpace'))
@section('content')
    <div class="vr__settings__v2">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        <div class="vr__settings__box__header border-bottom">
                            <h5 class="mb-0">{{ lang('Berth-Space', 'user') }}</h5>
                        </div>
                        <div class="vr__settings__box__body">
                            <form id="deatilsForm" action="{{ route('user.berthSpace.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ lang('Name', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="{{ lang('Name', 'forms') }}" maxlength="50" required>
                                        <input type="hidden" name="coordinates" class="form-control" id="coordinates">
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
                                                draggable: false,
                                                scaleControl: false,
                                                scrollwheel: false,
                                                navigationControl: false,
                                                streetViewControl: false,
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

                                            // If the user has already defined a berth, we draw it on the map
                                            @if($berth_data->coordinates)
                                            let coordinates = JSON.parse('{!! $berth_data->coordinates !!}');
                                            let latLngs = coordinates.coordinates;
                                            let angle = coordinates.angle;
                                            L.polygon(latLngs).addTo(map);
                                            @endif

                                        </script>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Length', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="length" class="form-control" placeholder="{{ lang('Length', 'forms') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Width', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="width" class="form-control" placeholder="{{ lang('Width', 'forms') }}" required>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Depth', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="depth" class="form-control" placeholder="{{ lang('Depth', 'forms') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ lang('Rotation', 'forms') }} : <span class="red">*</span></label>
                                        <input type="text" name="rotation" class="form-control" placeholder="{{ lang('Rotation', 'forms') }}" required>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <!-- A dropdown map type selection, GMap or OpenStreetMap-->
                                    <div class="col-md-6" style="display: none;">
                                        <label class="form-label">{{ lang('Map Type', 'forms') }} : <span class="red">*</span></label>
                                        {{ Form::select('map_type', ['GMap' => 'GMap', 'OpenStreetMap' => 'OpenStreetMap'], null, ['class'=>"form-control"]) }}
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ lang('Status', 'forms') }} : <span class="red">*</span></label>
                                        {{ Form::select('status', ['Available' => 'Available', 'Unavailable' => 'Unavailable', 'Reserved' => 'Reserved', 'Occupied' => 'Occupied', 'Under Maintenance' => 'Under Maintenance'], null, ['class'=>"form-control"]) }}
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="form-group col-md-12">
                                        <label class="form-label">{{ lang('Additional Params', 'forms') }} : <span class="red">*</span></label>
                                        <div id="berth_data" class="row form-group">
                                            <div class="col-md-12 mb-2">
                                                <div class="input-group">
                                                    <input type="text" name="additional_params_names[]" class="form-control"
                                                           placeholder="{{__('Key')}}" value="">
                                                    <select name="additional_params_values[]" class="form-control">
                                                        <option value="1" selected>{{__('True')}}</option>
                                                        <option value="0">{{__('False')}}</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-danger" type="button"
                                                                onclick="removeBerthData(this)"><i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
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
                                <button class="btn btn-secondary"><i class="far fa-save"></i>
                                    {{ lang('Save', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

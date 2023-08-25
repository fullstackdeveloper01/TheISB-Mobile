@extends('frontend.user.layouts.dash')
@section('title', lang('Berth-Space', 'user'))
@section('link', route('user.berthSpace.create'))
@section('content')
    <div class="vr__settings__v2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="my-3">
                            <div class="w-100" style="height: 550px;" id="berthMap"></div>
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

                                // Now we allow the user to draw a rectangle on map to define the berth
                                let drawnItems = new L.FeatureGroup();
                                map.addLayer(drawnItems);

                                // we draw existing berths on map make them clickable, when clicked we take the user to edit page
                                @if($berths)
                                let berths = @json($berths);
                                let coordinates;
                                let colors = [
                                    {status: 'Available', color: '#27ec27'},
                                    {status: 'Reserved', color: '#1a81e7'},
                                    {status: 'Occupied', color: '#c71515'},
                                    {status: 'Default', color: '#2f2d2d'},
                                ];
                                berths.forEach(berth => {
                                    if (berth.coordinates) {
                                        coordinates = JSON.parse(berth.coordinates);
                                        coordinates = coordinates.coordinates;
                                        let status = berth.status;
                                        // check if the status matches any of the statuses in the colors
                                        let color = colors.find(c => c.status === status);
                                        if (color) {
                                            color = color.color;
                                        } else {
                                            color = colors.find(c => c.status === 'Default').color;
                                        }
                                        let polygon = L.polygon(coordinates, {color: color}).addTo(map);
                                        polygon.bindPopup(`<p>Name: <a href="/user/berthSpace/edit/${berth.id}">${berth.name}</a><br><b>Status: ${berth.status}</b></p>`);
                                    }
                                });
                                @endif

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-xl-12">
                <div class="vr__card">
                    <div class="vr__settings__box">
                        @if ($berths->count() > 0)
                        <div class="transactions-table">
                            <div class="vr__table">
                                <table>
                                    <thead>
                                        <th>{{ lang('#No') }}</th>
                                        <th class="text-center">{{ lang('Name', 'user') }}</th>
                                        <th class="text-center">{{ lang('Length', 'user') }}</th>
                                        <th class="text-center">{{ lang('Width', 'user') }}</th>
                                        <th class="text-center">{{ lang('Depth', 'user') }}</th>
                                        <th class="text-center">{{ lang('Rotation', 'user') }}</th>
                                        <!-- <th class="text-center">{{ lang('Map Type', 'user') }}</th> -->
                                        <th class="text-center">{{ lang('Created Date', 'user') }}</th>
                                        <th class="text-center">{{ lang('Status', 'user') }}</th>
                                        <th class="text-center">{{ lang('Action', 'user') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($berths as $key => $berth)
                                            <tr>
                                                <td>#{{ $key+1 }} </td>
                                                <td>
                                                    {{ $berth->name }}
                                                </td>
                                                <td>
                                                    {{ $berth->length }}
                                                </td>
                                                <td>
                                                    {{ $berth->width }}
                                                </td>
                                                <td>
                                                    {{ $berth->depth }}
                                                </td>
                                                <td>
                                                    {{ $berth->rotation }}
                                                </td>
                                                <!-- <td>
                                                    {{ $berth->map_type }}
                                                </td> -->
                                                <td class="text-center">{{ vDate($berth->created_at) }}</td>
                                                <td class="text-center">
                                                    {{ $berth->status }}
                                                    {{--@if ($berth->status == "Available")
                                                        <span class="badge bg-success">{{ lang('Available', 'user') }}</span>
                                                    @elseif ($berth->status == "Unavailable")
                                                        <span class="badge bg-blue">{{ lang('Unavailable', 'user') }}</span>
                                                    @elseif ($berth->status == "Reserved")
                                                        <span class="badge bg-blue">{{ lang('Reserved', 'user') }}</span>
                                                    @elseif ($berth->status == "Under Maintenance")
                                                        <span class="badge bg-blue">{{ lang('Under Maintenance', 'user') }}</span>
                                                    @elseif ($berth->status == "Under Maintenance")
                                                        <span class="badge bg-blue">{{ lang('Under Maintenance', 'user') }}</span>
                                                    @elseif ($berth->status == "Under Maintenance")
                                                        <span class="badge bg-blue">{{ lang('Under Maintenance', 'user') }}</span>
                                                    @endif--}}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.berthSpace.edit', $berth->id)}}" class="btn btn-blue btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('user.berthSpace.delete', $berth->id)}}" onclick="return confirm('Are you sure you would like to remove this?');" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

<div class="table-responsive">
    <table class="vironeer-normal-table table w-100">
        <thead>
            <tr>
                <th class="tb-w-3x">#ID</th>
                <th>{{ __('Icon') }}</th>
                <th>{{ __('Name') }}</th>
                <th class="text-center">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($amenities)
                @foreach($amenities as $key => $res)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><img src="{{ asset($res->icon) }}" width="50" alt="{{ $res->icon }}"></td>
                        <td>{{ $res->amenity }}</td>
                        <td class="text-center">
                            <label class="switch">
                                @if(in_array($res->id, $selectedAmenity))
                                    <input type="checkbox" checked onchange="amenitiesStatus(this, {{ $res->id }})">
                                    <span class="slider"></span>
                                @else
                                    <input type="checkbox" onchange="amenitiesStatus(this, {{ $res->id }})">
                                    <span class="slider"></span>
                                @endif
                            </label>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
{{ $amenities->links() }}
<div class="card custom-card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2">
                <a href="{{ route('admin.marinas.marinaProfile', $marina->id) }}" class="btn btn-{{ ($active_tab == 'details' )?'primary':'default' }} btn-sm">Marina Details</a>
            </div>
            {{--<div class="col-lg-2">
                <a href="{{ route('admin.marinas.berthSpaces', $marina->id) }}"class="btn btn-{{ ($active_tab == 'berth-spaces' )?'primary':'default' }} btn-sm">Berth Spaces</a>
            </div>--}}
            <div class="col-lg-2">
                <a href="{{ route('admin.marinas.amenities', $marina->id) }}"class="btn btn-{{ ($active_tab == 'amenities' )?'primary':'default' }} btn-sm">Amenities</a>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('admin.marinas.marinaPhotos', $marina->id) }}"class="btn btn-{{ ($active_tab == 'photos' )?'primary':'default' }} btn-sm">Slider</a>
            </div>
        </div>
    </div>
</div>
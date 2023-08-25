<div class="custom-card card mb-3">
    <div class="card-body text-center">
        <form id="changeUserAvatarForm" action="#" method="POST" enctype="multipart/form-data">
            <div class="avatar mb-3">
                @if("images/avatars/default.png" == $marina->avatar)
                    <div class="profileImage-large" id="filePreview">
                        <span>{{ substr($marina->firstname, 0, 1); }}{{substr($marina->lastname, 0, 1);}} </span>
                    </div>
                @else
                    <img id="filePreview" src="{{ asset($marina->avatar) }}" class="rounded-circle border" width="150"
                        height="150">
                @endif
                <input id="selectedFileInput" data-id="{{ $marina->id }}" class="vironeer-marina-avatar" type="file"
                    name="avatar" accept="image/png, image/jpg, image/jpeg" hidden>
                <span class="image-error-icon error-icon d-none"><i class="far fa-times-circle"></i></span>
            </div>
        </form>
        <div class="buttons">
            <button id="selectFileBtn" type="button" class="btn btn-secondary me-2"><i
                    class="fas fa-sync-alt me-2"></i>{{ __('Change') }}</button>
            <form class="d-inline" action="{{ route('admin.marinas.deleteAvatar', $marina->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="vironeer-able-to-delete btn btn-danger"><i
                        class="fas fa-times me-2"></i>{{ __('Remove') }}</button>
            </form>
        </div>
    </div>
    <ul class="custom-list-group list-group list-group-flush border-top">
        <li class="list-group-item d-flex justify-content-between"><span>{{ __('Email ') }} :</span>
            <strong>{{ $marina->email }}</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between"><span>{{ __('Joined at') }} :</span>
            <strong>{{ vDate($marina->created_at) }}</strong>
        </li>
    </ul>
</div>
<div class="custom-card card mb-3">
    <div class="custom-list-group list-group list-group-flush">
        <a href="{{ route('admin.marinas.edit', $marina->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->routeIs('admin.marinas.edit')) active @endif">
            <span>{{ __('Details') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.marinas.marinaProfile', $marina->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->routeIs('admin.marinas.marinaProfile') || request()->routeIs('admin.marinas.berthSpaces') || request()->routeIs('admin.marinas.amenities') || request()->routeIs('admin.marinas.marinaPhotos')) active @endif">
            <span>{{ __('Marina Profile') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.marinas.bookings', $marina->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->routeIs('admin.marinas.bookings')) active @endif">
            <span>{{ __('Bookings') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
        <a href="{{ route('admin.marinas.logs', $marina->id) }}"
            class="list-group-item list-group-item-action d-flex justify-content-between @if (request()->routeIs('admin.marinas.logs')) active @endif">
            <span>{{ __('Login logs') }}</span>
            <span><i class="fas fa-angle-right"></i></span>
        </a>
    </div>
</div>

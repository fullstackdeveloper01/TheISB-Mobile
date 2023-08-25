<div class="vr__card">
    <div class="vr__settings__side">
        <div class="vr__settings__user">
            <div class="vr__settings__user__img mb-3">
                <img id="avatar_preview" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" />
                @if (request()->routeIs('user.settings'))
                    <div class="vr__settings__user__img__change">
                        <input id="change_avatar" type="file" name="avatar" form="deatilsForm"
                            accept="image/jpg, image/jpeg, image/png" hidden />
                        <label for="change_avatar">
                            <i class="fa fa-camera"></i>
                        </label>
                    </div>
                @endif
            </div>
            <div class="vr__settings__user__title">
                <p class="mb-0 h5">{{ userAuthInfo()->name }}</p>
            </div>
        </div>
        <div class="vr__settings__links">
            <a href="{{ route('user.marinasProfile') }}" class="vr__settings__link @if (request()->routeIs('user.marinasProfile') || request()->routeIs('user.marinasBerthSpaces') || request()->routeIs('user.marinasAmenities') || request()->routeIs('user.marinasPhotos')) active @endif">
                <i class="fa fa-edit"></i> {{ lang('Marina Profile', 'user') }}
            </a>
            <a href="{{ route('user.loginLogs') }}" class="vr__settings__link @if (request()->routeIs('user.loginLogs')) active @endif">
                <i class="fas fa-sync-alt"></i> {{ lang('Login Logs', 'user') }}
            </a>
        </div>
    </div>
</div>

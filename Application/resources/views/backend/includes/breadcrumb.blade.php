@if (request()->routeIs('admin.sections.index'))
    <div class="row md-3">
        <div class="col-lg-3">        
            <p class="h3 mb-0 capitalize">@yield('title')</p>
            <nav class="mt-2" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sa-simple mb-0">
                    <?php $segments = ''; ?>
                    @foreach (request()->segments() as $segment)
                        <?php $segments .= '/' . $segment; ?>
                        <li class="breadcrumb-item  @if(request()->segment(count(request()->segments())) == $segment) active @endif">
                            @if(request()->segment(count(request()->segments())) != $segment)
                            <a href="{{ url($segments) }}">{{ $segment }}</a>
                        @else
                            {{ $segment }}
                    @endif
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="col-lg-4">        
            <label>Select App Screen</label>
            <select class="form-control select2">
                <option value=""></option>
                <option value="0">Home Page</option>
                <option value="1">Splash Screen</option>
                <option value="2">Contact Us</option>
                <option value="3">Gallery</option>
            </select>
        </div>
    </div>
@else
    <p class="h3 mb-0 capitalize">@yield('title')</p>
    <nav class="mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-sa-simple mb-0">
            <?php $segments = ''; ?>
            @foreach (request()->segments() as $segment)
                <?php $segments .= '/' . $segment; ?>
                <li class="breadcrumb-item  @if(request()->segment(count(request()->segments())) == $segment) active @endif">
                    @if(request()->segment(count(request()->segments())) != $segment)
                    <a href="{{ url($segments) }}">{{ $segment }}</a>
                @else
                    {{ $segment }}
            @endif
            </li>
            @endforeach
        </ol>
    </nav>
@endif

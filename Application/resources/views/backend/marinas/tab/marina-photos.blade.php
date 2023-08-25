@if(count($photosList) > 0)
    <div class="table-responsive">
        <table class="vironeer-normal-table table w-100">
            <thead>
                <tr>
                    <th class="tb-w-3x">No</th>
                    <th>{{ __('Image') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($photosList as $key => $photo)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td class="thumb-lg m-r col-md-9"> 
                            <img class="img-responsive" width="100px" src="{{ asset($photo->image) }}">
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.marinas.marinasPhotosRemove', $photo->id) }}" onclick="return confirm('Are you sure?')" >
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $photosList->links() }}
@else
@include('frontend.user.includes.empty-full')
@endif

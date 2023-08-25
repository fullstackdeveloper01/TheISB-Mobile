@extends('backend.layouts.grid')
@section('title', __('Knowledge Bases'))
@section('link', route('admin.knowledgeBase.create'))
@section('content')
    <div class="card">
        <table id="datatable" class="table w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">{{ __('#') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th class="tb-w-20x">{{ __('Title') }}</th>
                    <th class="tb-w-20x">{{ __('Short Description') }}</th>
                    <th class="tb-w-7x">{{ __('Created date') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($knowledgeBaseList as $knowledgeBase)
                    <tr class="item">
                        <td>{{ $knowledgeBase->id }}</td>
                        <td><img src="{{ asset($knowledgeBase->image) }}" width="50" alt="{{ $knowledgeBase->image }}"></td>
                        <td>
							<a class="text-reset" href="{{ route('admin.knowledgeBase.edit', $knowledgeBase->id) }}">{{ shortertext($knowledgeBase->title, 30) }}</a>
						</td>
                        <td>{{ shortertext($knowledgeBase->short_description, 70) }}</td>
                        <td>{{ vDate($knowledgeBase->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.knowledgeBase.edit', $knowledgeBase->id) }}">
										<i class="fa fa-edit me-2"></i>{{ __('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.knowledgeBase.destroy', $knowledgeBase->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="vironeer-able-to-delete dropdown-item text-danger">
											<i class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
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
@endsection

<form id="deatilsForm" action="{{ route('user.photosAdd') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="row">
        <div class="col-lg-6">
            <h3>Add Photo</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Photo') }} :<span class="red">*</span></label>
                        <input type="file" name="image" required>
                    </div>
                </div>
            </div>                            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-secondary">
                <i class="far fa-save"></i>
                {{ lang('Save', 'user') }}
            </button>
        </div>
    </div>
</form>
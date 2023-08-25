<script type="text/javascript">
    "use strict";
    const BASE_URL = "{{ url('/admin') }}";
    const PRIMARY_COLOR = "{{ $settings['website_primary_color'] }}";
    const SECONDARY_COLOR = "{{ $settings['website_secondary_color'] }}";
</script>  
<script>
    function confirmationFeatured(mid){
        Swal.fire({

            title: 'Are you sure?',

            text: "Do you really want do this action?",

            icon: 'question',

            showCancelButton: true,

            allowOutsideClick: false,

            confirmButtonColor: PRIMARY_COLOR,

            confirmButtonText: 'Yes',

        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({

                    type: 'GET',

                    url: BASE_URL + '/setFeaturedImage',

                    data: {

                        id: mid,

                    },
                    success: function(resp) {
                        
                    }
                });
            }
        });        
    }

    function removeSection(rid, oid){
        if(oid == 0){
            $('#rid_'+rid).remove();
        }
        else{
            Swal.fire({

                title: 'Are you sure?',

                text: "Do you really want do this action?",

                icon: 'question',

                showCancelButton: true,

                allowOutsideClick: false,

                confirmButtonColor: PRIMARY_COLOR,

                confirmButtonText: 'Yes',

            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({

                        type: 'GET',

                        url: BASE_URL + '/deleteOtherSection',

                        data: {

                            id: oid,

                        },
                        success: function(resp) {
                            $('#rid_'+rid).remove();
                        }
                    });
                }
            });
        }
    }    
</script>
@stack('top_scripts')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('assets/vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert/sweetalert2.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('assets/vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatable/datatables.jq.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/vendor/admin/js/application.js') }}"></script>
@toastr_render
<script>
    /**** Status manage ****/
    $(function(){
        $('.change-status').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0; 
            var id = $(this).data('id'); 
            var table = $(this).data('table'); 
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/changeStatus',
                data: {'status': status, 'id': id, 'table': table},
                success:function (data) {
                            if(data.status == true) {
                                toastr.success(data.message);
                                toastr.options.timeOut = 10000;
                            }
                            else if(data.status==false){
                                toastr.error(data.error);
                            }
                        }, 
            });
        })
    });

    /*****************************************************************
     * @Function: Get Admin Comment
     * ***************************************************************/
    function getAdminComment(cid) {
        $('#complaint_id').val(cid);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = {
            cid: cid
        };
        var ajaxurl = "{{ route('admin.getAdminComment') }}";
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                if(data.status == true){
                    $('#admin_comment').text(data.result);
                    $('#comment_status').val(data.comment_status);
                }
                else{
                    $('#admin_comment').text('');
                }
            },
            error: function (data) {
                
            }
        });
    }

    /******************************************************
     * @Function: Set In Process Status
     * ****************************************************/
    function setInProcessStatus(complaint_status) {
        if(complaint_status == 1){
            $('#admin_comment').text('Matter is taken up and will get back to you soon.');
        }
        else{
            $('#admin_comment').text('');
        }
    }

    /******************************************************
     * @Function: Admin comment submit
     * ****************************************************/
    function adminCommentSubmit() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.admin-comment').prop('disabled', true);
        var complaint_id           = $('#complaint_id').val();
        var admin_comment          = $('#admin_comment').val();
        var comment_status         = $('#comment_status :selected').val();
        if(comment_status == ''){
            $('.error_comment_status').text('Status field is required');
            return false;
        }else{
            $('.error_comment_status').text('');                
        }
        var formData = {
            complaint_id: complaint_id,
            comment_status: comment_status,
            admin_comment: admin_comment,
        };
        var ajaxurl = "{{ route('admin.adminCommentSubmit') }}";
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                if(data.status == true){
                    $('#admin_comment'+complaint_id).text(admin_comment);
                    if(data.commentstatus == 0){
                        $('#complaint-status'+complaint_id).text('Pending');
                    }
                    else if(data.commentstatus == 1){
                        $('#complaint-status'+complaint_id).text('In-Process');
                    }
                    else if(data.commentstatus == 2){
                        $('#complaint-status'+complaint_id).text('Resolved');
                    }
                    else if(data.commentstatus == 3){
                        $('#complaint-status'+complaint_id).text('Rejected');
                    }
                    else{
                        $('#complaint-status'+complaint_id).text('Pending');
                    }
                    $("#admin-comment-form")[0].reset()
                    $('#close_comment_modal').click();
                    toastr.success(data.result, '', []);
                    $('.admin-comment').prop('disabled', false);
                }
                else{
                    toastr.warning(data.result, '', []);
                    $('.admin-comment').prop('disabled', false);
                }
            },
            error: function (data) {
                
            }
        });
    }
</script>
@stack('scripts')

jQuery(document).ready(function($){
    var custom_uploader;
    $('#upload_image_button').click(function(e) {
        e.preventDefault();

        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
            $('#image').attr('src', attachment.url);
            $('#preview_image').show();
        });

        custom_uploader.open();
    });

    $('#remove_image_button').on('click', function(e) {
        e.preventDefault();
        $('#upload_image').val('');
        $('#image').attr('src', '');
        $('#preview_image').hide();
    });


    $('.edit_record_bcl').on('click',function(){
        var id_bcl = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: data_bcl_builder.ajaxurl,
            data: {
                action: 'edit_record_bcl',
                id: id_bcl,
            },
            success: function(response) {
                if (response.success) {
                    $('#modal_edit_record_bcl .modal-content').html(response.data);
                    $('#modal_edit_record_bcl').modal('show');
                }
            }
        });

    });


});
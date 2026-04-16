$(document).ready(function() {
    $('#select-authors').select2({
        placeholder: 'Busca y selecciona autores...',
        allowClear: true,
        width: '100%'
    });

    $('#select-categories').select2({
        placeholder: 'Busca y selecciona categorías...',
        allowClear: true,
        width: '100%'
    });

    // Preview de portada
    $('#cover_url_edit').on('change', function() {
        var url = $(this).val();
        if (url) {
            $('#preview_img_edit').attr('src', url);
            $('#cover_preview_edit').show();
        } else {
            $('#cover_preview_edit').hide();
        }
    });
});

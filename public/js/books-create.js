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

    // Búsqueda por ISBN en Open Library
    $('#btn_search_isbn').on('click', function() {
        const isbn = $('#isbn_search').val().trim();
        const btn = $(this);

        if (!isbn) {
            showToast('Por favor, ingresa un ISBN', 'warning');
            return;
        }

        btn.prop('disabled', true).text('Buscando...');

        $.ajax({
            url: window.searchIsbnUrl,
            data: { isbn: isbn },
            success: function(data) {
                showToast('¡Datos del libro cargados con éxito!', 'success');

                $('input[name="title"]').val(data.title);
                $('input[name="isbn"]').val(isbn);
                $('textarea[name="description"]').val(data.description);
                $('#published_at').val(data.published_at);
                $('#cover_url').val(data.cover_url);

                if (data.cover_url) {
                    $('#preview_img').attr('src', data.cover_url);
                    $('#cover_preview').show();
                }

                // Recargar opciones y seleccionar autores
                if (data.author_ids && data.author_ids.length > 0) {
                    $.get(window.createBookUrl, function(html) {
                        var newOptions = $(html).find('#select-authors option');
                        $('#select-authors').empty().append(newOptions);
                        $('#select-authors').val(data.author_ids).trigger('change');
                    });
                }

                // Recargar opciones y seleccionar categorías
                if (data.category_ids && data.category_ids.length > 0) {
                    $.get(window.createBookUrl, function(html) {
                        var newOptions = $(html).find('#select-categories option');
                        $('#select-categories').empty().append(newOptions);
                        $('#select-categories').val(data.category_ids).trigger('change');
                    });
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON ? xhr.responseJSON.error : 'Error al buscar el libro';
                showToast(msg, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).text('Cargar Datos');
            }
        });
    });

    // Preview de portada
    $('#cover_url').on('change', function() {
        var url = $(this).val();
        if (url) {
            $('#preview_img').attr('src', url);
            $('#cover_preview').show();
        } else {
            $('#cover_preview').hide();
        }
    });
});

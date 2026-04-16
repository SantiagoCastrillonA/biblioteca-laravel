$(document).ready(function() {
    $('#authorsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']]
    });

    initDeleteForms('¿Estás seguro de que deseas eliminar este autor?');
});

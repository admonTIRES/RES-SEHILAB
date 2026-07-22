
//=================================================
// LOAD PAGINA

var opcion = 0
var ruta_storage_guardar = '/reportes';

//=================================================
// TABLA MEL DRAFT
//=================================================

var reporteregistro_id = 0; 
var areas_poe = 1;

$(document).ready(function () {
	
	
	setTimeout(function () {
		tabla_matrizreco(proyecto.id, reporteregistro_id, areas_poe);
	}, 100);
});

var datatable_reporte_melreco = null;



function tabla_matrizreco(proyecto_id,reporteregistro_id,areas_poe)
{
    try {

        var ruta =
            '/matrizrecomendaciones/' +
            proyecto_id +
            '/' +
            reporteregistro_id +
            '/' +
            areas_poe;

        if (
            $.fn.DataTable.isDataTable(
                '#tabla_matrizreco'
            )
        ) {
            $('#tabla_matrizreco')
                .DataTable()
                .clear()
                .destroy();
        }

        datatable_reporte_melreco =
            $('#tabla_matrizreco').DataTable({

                ajax: {
                    url: ruta,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',

                    dataSrc: function (json) {

                        if (
                            !json ||
                            json.success === false ||
                            !Array.isArray(json.data)
                        ) {
                            console.warn(
                                'No se recibieron datos válidos:',
                                json
                            );

                            return [];
                        }

                        return json.data;
                    },

                    error: function (
                        xhr,
                        error,
                        thrown
                    ) {
                        console.error(
                            'Error al cargar DataTable:',
                            error,
                            thrown,
                            xhr.responseText
                        );
                    }
                },

                columns: [
                    {
                        data: 'numero_registro',
                        defaultContent: '-',
                        orderable: false
                    },
                    {
                        data: 'DEPARTAMENTO_MEL',
                        defaultContent: '-',
                        orderable: false
                    },
                    {
                        data: 'reportearea_instalacion',
                        defaultContent: '-',
                        orderable: false
                    },
                    {
                        data: 'reportearea_nombre',
                        defaultContent: '',
                        orderable: false
                    },
                    {
                        data: 'nombre_agente',
                        defaultContent: '',
                        orderable: false
                    },
                    {
                        data: 'recomendaciones',
                        defaultContent: '',
                        orderable: false,
                        searchable: false
                    }
                ],

                /*
                 * Solamente se agrupan:
                 *
                 * 1 = Departamento
                 * 2 = Instalación
                 *
                 * Las áreas y agentes ya aparecen una sola vez.
                 */
                rowsGroup: [1, 2],

                ordering: false,
                processing: true,
                searching: true,
                paging: true,

                pageLength: 30,

                lengthMenu: [
                    [30, 50, 100, -1],
                    [30, 50, 100, 'Todos']
                ],

                language: {
                    lengthMenu:
                        'Mostrar _MENU_ Registros',

                    zeroRecords:
                        'No se encontraron registros',

                    info:
                        'Página _PAGE_ de _PAGES_ ' +
                        '(Total _TOTAL_ registros)',

                    infoEmpty:
                        'No se encontraron registros',

                    infoFiltered:
                        '(Filtrado de _MAX_ registros)',

                    emptyTable:
                        'No hay datos disponibles en la tabla',

                    loadingRecords:
                        'Cargando datos...',

                    processing:
                        'Procesando ' +
                        "<i class='fa fa-spin " +
                        "fa-spinner fa-3x'></i>",

                    search: 'Buscar',

                    paginate: {
                        first: 'Primera',
                        last: 'Última',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                },

                createdRow: function (row, data) {

                    $(row)
                        .addClass('fila-matrizreco')
                        .attr(
                            'data-numero-registro',
                            data.numero_registro
                        )
                        .attr(
                            'data-area-id',
                            data.area_id || 0
                        )
                        .attr(
                            'data-agente-id',
                            data.agente_id || 0
                        );
                },

                drawCallback: function () {

                    $('[data-toggle="tooltip"]')
                        .tooltip();
                }
            });

    } catch (error) {

        console.error(
            'Excepción en tabla_matrizreco:',
            error
        );
    }
}



$('#btn_guardar_recomendaciones').on(
    'click',
    async function (e) {

        e.preventDefault();

        const proyecto_id = proyecto.id;

        const token =
            $('meta[name="csrf-token"]')
                .attr('content');

      
        const agentesGuardar = {};

        if (
            !$.fn.DataTable.isDataTable(
                '#tabla_matrizreco'
            )
        ) {
            await Swal.fire({
                title: 'Advertencia',
                text: 'La tabla de recomendaciones no está disponible.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });

            return;
        }

        const tabla =
            $('#tabla_matrizreco').DataTable();

        
        tabla.rows().every(function () {

            const row = this.data();
            const nodo = this.node();

            if (
                !row ||
                !row.agente_id ||
                parseInt(row.agente_id) === 0
            ) {
                return;
            }

            const agente_id = row.agente_id;
            const recomendaciones = [];

         
            $(nodo)
                .find('.recomendacion_checkbox')
                .each(function () {

                    recomendaciones.push({
                        id: $(this).data('id'),

                        seleccionado:
                            $(this).is(':checked')
                    });
                });

            agentesGuardar[agente_id] = {
                agente_id: agente_id,
                recomendaciones: recomendaciones
            };
        });

        const dataGuardar =
            Object.keys(agentesGuardar)
                .map(function (agente_id) {

                    return agentesGuardar[agente_id];
                });

        if (dataGuardar.length === 0) {

            await Swal.fire({
                title: 'Advertencia',
                text: 'No hay recomendaciones para guardar.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });

            return;
        }

        const confirmacion = await Swal.fire({
            title:
                '¿Desea guardar las recomendaciones?',

            text:
                'Se almacenarán las selecciones generales de cada agente.',

            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        });

        if (!confirmacion.isConfirmed) {
            return;
        }

        try {

            const res = await $.ajax({
                url:
                    '/guardarMatrizRecomendaciones',

                type:
                    'POST',
                data: JSON.stringify({
                    proyecto_id:
                        proyecto_id,

                    reporteregistro_id:
                        reporteregistro_id || 0,

                    data:
                        dataGuardar
                }),

                contentType:
                    'application/json; charset=utf-8',

                dataType:
                    'json',

                headers: {
                    'X-CSRF-TOKEN': token
                },

                beforeSend: function () {

                    $('#btn_guardar_recomendaciones')
                        .prop('disabled', true)
                        .html(
                            '<i class="fa fa-spinner ' +
                            'fa-spin"></i> Guardando...'
                        );
                }
            });

            if (res.success) {

                await Swal.fire({
                    title: 'Éxito',

                    text:
                        res.mensaje ||
                        'Recomendaciones guardadas correctamente.',

                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });

                tabla.ajax.reload(
                    null,
                    false
                );

            } else {

                await Swal.fire({
                    title: 'Error',

                    text:
                        res.mensaje ||
                        'Ocurrió un problema al guardar las recomendaciones.',

                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }

        } catch (err) {

            console.error(err);

            let mensaje =
                'Error de conexión al guardar las recomendaciones.';

            if (
                err.responseJSON &&
                err.responseJSON.mensaje
            ) {
                mensaje =
                    err.responseJSON.mensaje;
            }

            await Swal.fire({
                title: 'Error',
                text: mensaje,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });

        } finally {

            $('#btn_guardar_recomendaciones')
                .prop('disabled', false)
                .html(
                    'Guardar <i class="fa fa-save"></i>'
                );
        }
    }
);





$(document).on('click','#btnexportarmelrecomendaciones',
    function (e) {

        e.preventDefault();

        const boton =
            $('#btnexportarmelrecomendaciones');

        $.ajax({
            url:
                '/verificarmatrizrecomendaciones/' +
                proyecto.id,

            method: 'GET',

            success: function (respuesta) {

                if (!respuesta.success) {

                    Swal.fire({
                        title: 'Atención',
                        text:
                            respuesta.message ||
                            'No se puede verificar la matriz.',
                        icon: 'warning'
                    });

                    return;
                }

                Swal.fire({
                    title:
                        '¿Desea generar la Matriz de Recomendaciones?',

                    text:
                        'Se exportará el archivo Excel con los datos actuales.',

                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, descargar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true

                }).then(function (result) {

                    if (!result.isConfirmed) {
                        return;
                    }

                    boton.prop('disabled', true);

                    Swal.fire({
                        title: 'Generando reporte...',

                        text:
                            'Espere un momento mientras se prepara el documento.',

                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,

                        didOpen: function () {
                            Swal.showLoading();
                        }
                    });

                    const ruta =
                        '/exportarMatrizRecomendaciones/' +
                        proyecto.id +
                        '/' +
                        reporteregistro_id;

                    $.ajax({
                        url: ruta,
                        method: 'GET',

                        xhrFields: {
                            responseType: 'blob'
                        },

                        success: function (
                            archivo,
                            status,
                            xhr
                        ) {

                            const contentType =
                                xhr.getResponseHeader(
                                    'Content-Type'
                                ) || '';

                            if (
                                contentType.indexOf(
                                    'application/json'
                                ) !== -1
                            ) {

                                const reader =
                                    new FileReader();

                                reader.onload =
                                    function () {

                                        try {

                                            const response =
                                                JSON.parse(
                                                    reader.result
                                                );

                                            Swal.fire({
                                                title: 'Atención',

                                                text:
                                                    response.message ||
                                                    'No se puede generar el reporte.',

                                                icon: 'warning'
                                            });

                                        } catch (error) {

                                            Swal.fire({
                                                title: 'Error',

                                                text:
                                                    'La respuesta del servidor no es válida.',

                                                icon: 'error'
                                            });
                                        }
                                    };

                                reader.readAsText(
                                    archivo
                                );

                                return;
                            }

                            const disposition =
                                xhr.getResponseHeader(
                                    'Content-Disposition'
                                );

                            let nombreArchivo = '';

                            if (disposition) {

                                let coincidencia =
                                    /filename\*=UTF-8''([^;]+)/i
                                        .exec(disposition);

                                if (
                                    coincidencia &&
                                    coincidencia[1]
                                ) {

                                    nombreArchivo =
                                        decodeURIComponent(
                                            coincidencia[1]
                                        );

                                } else {

                                    coincidencia =
                                        /filename="?([^";]+)"?/i
                                            .exec(disposition);

                                    if (
                                        coincidencia &&
                                        coincidencia[1]
                                    ) {
                                        nombreArchivo =
                                            coincidencia[1];
                                    }
                                }
                            }

                            nombreArchivo =
                                nombreArchivo
                                    .replace(/['"]/g, '')
                                    .trim();

                            if (!nombreArchivo) {

                                Swal.fire({
                                    title: 'Error',

                                    text:
                                        'El servidor no proporcionó el nombre del archivo.',

                                    icon: 'error'
                                });

                                return;
                            }

                            const urlDescarga =
                                window.URL
                                    .createObjectURL(
                                        archivo
                                    );

                            const enlace =
                                document.createElement(
                                    'a'
                                );

                            enlace.href =
                                urlDescarga;

                            enlace.download =
                                nombreArchivo;

                            document.body
                                .appendChild(enlace);

                            enlace.click();
                            enlace.remove();

                            window.URL
                                .revokeObjectURL(
                                    urlDescarga
                                );

                            Swal.fire({
                                title: 'Éxito',

                                text:
                                    'El archivo se descargó correctamente.',

                                icon: 'success',
                                confirmButtonText: 'Cerrar'
                            });
                        },

                        error: function (xhr) {

                            if (
                                xhr.response instanceof Blob
                            ) {

                                const reader =
                                    new FileReader();

                                reader.onload =
                                    function () {

                                        let mensaje =
                                            'No se pudo generar el reporte.';

                                        try {

                                            const response =
                                                JSON.parse(
                                                    reader.result
                                                );

                                            mensaje =
                                                response.message ||
                                                mensaje;

                                        } catch (error) {
                                        }

                                        Swal.fire({
                                            title: 'Error',
                                            text: mensaje,
                                            icon: 'error'
                                        });
                                    };

                                reader.readAsText(
                                    xhr.response
                                );

                            } else {

                                Swal.fire({
                                    title: 'Error',

                                    text:
                                        'No se pudo generar el reporte.',

                                    icon: 'error'
                                });
                            }
                        },

                        complete: function () {

                            boton.prop(
                                'disabled',
                                false
                            );
                        }
                    });
                });
            },

            error: function (xhr) {

                console.error(
                    xhr.responseText
                );

                Swal.fire({
                    title: 'Error',

                    text:
                        'No se pudo verificar la matriz.',

                    icon: 'error'
                });
            }
        });
    }
);

 //VARIABLES GLOBALES
var tabla_recsensorial = null;
var tabla_recsensorialareas = null;
var tabla_recsensorialcategorias = null;
var tabla_control_cambios = null;
var select_areacategorias_opciones = "";
var rutaMapa = '';
var optionSelectAreas = '';
var categoriasEvaluadas = '';
var areacategorias_total = 0;
var recsensorial_perfil = 0;
var recsensorial = 0;
var normativa_id = 0;
var tabla = null;
var HIGIENE = 1;

var Tablarecocategoriasergo = null;
var Tablarecoareasergo = null;
var Tablafichasevaluacionfre = null;
var tabla_reporte_categoria = null;
var tabla_reporte_area = null;
var tabla_reporte_revisiones  = null 
var datatableTablaActividadesFre = null;
var datatableTablaImcFre = null;
var tabla_reporte_trabajadores_ergo = null;

var instalacionreco = '';

var TablangulosFre = null;


ID_CATEGORIA_ERGO = 0;
ID_AREA_ERGO = 0;
ID_FICHAS_TECNICAS = 0;

ID_EVALUACION_FRE = 0;

ID_ANGULOS_FRE = 0;

var fichas_id = null; 

var fre_id = null; 


//--------------------------------------------------CARGA PRINCIPAL---------------------------------------------------------//
$(document).ready(function () {
	// mostrar tabla
	tabla_reconocimientosensorial();

	// desactivar menu agentes
	$("#tab_menu2").css('display', 'none');
	$("#tab_menu3").css('display', 'none');
	$("#tab_menu4").css('display', 'none');

	
	$('#inputfotomapa').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});


		$('#inputfotoplano').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
		});
	
	
		$('#inputfotoinstalacion').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
		});
	

	
	
	// Inicializar tooltip
	$('[data-toggle="tooltip"]').tooltip();
});


$(document).ready(function () {
	let timeout;

	$('#proyecto_folio').on('change', function (e) {
		clearTimeout(timeout);

		timeout = setTimeout(() => {
			obtenerEstructuraProyectos($(this).val(), 1);
		}, 1500); // Esperamos 1.5 segundos para ejecutar la funcion
	});
});

//-------------------------------------------------TABS---------------------------------------------------------------------//
$('.link_menuprincipal').click(function () {
	switch (this.id) {
		case "tab_menu1":
			// Menu
			$("#tab_menu2").css('display', 'none');
			$("#tab_menu3").css('display', 'none');

			// Contenido
			$("#tab_1").css('display', 'block');
			$("#tab_2").css('display', 'none');
			$("#tab_3").css('display', 'none');

		break;
		case "tab_menu2":
			$("#tab_2").css('display', 'block');
			$("#tab_1").css('display', 'none');
			$("#tab_3").css('display', 'none');

			$("#steps_menu_tab1").click();
			break;
		

    case "tab_menu3":
            
              
            const introduccion = document.querySelector('#INFORME_INTRODUCCION');

            if (introduccion) {
                $('#INFORME_INTRODUCCION').summernote('code', introduccion.defaultValue);
            } 

            const reconocimiento = document.querySelector('#INFORME_RECONOCIMIENTO');

            if (reconocimiento) {
                $('#INFORME_RECONOCIMIENTO').summernote('code', reconocimiento.defaultValue);
            } 
            
            const textareasInformeFre = [
            '#RUTA_IMAGEN_PORTADA',
            '#RUTA_IMAGEN_UBICACION',
            '#INFORME_INTRODUCCION',
            '#INFORME_OBJETIVOGENERALES',
            '#INFORME_OBJETIVOSESPECIFICOS',
            '#INFORME_RECONOCIMIENTO',
            '#INFORME_ANALISISRECONOCIMIENTO',
            '#INFORME_UBICACIONINSTALACION',
            '#INFORME_PROCESOINSTALACION',
            '#INFORME_ACTIVIDADPRINCIPAL',
            '#INFORME_ANTROPOMETRICAS',
            '#OBSERVACIONES_ESQUELETICAS1',
            '#OBSERVACIONES_ESQUELETICAS2',
            '#OBSERVACIONES_ESQUELETICAS3',
            '#OBSERVACIONES_ESQUELETICAS4',
            '#OBSERVACIONES_ESQUELETICAS5',
            '#OBSERVACIONES_ESQUELETICAS6',
            '#INFORME_CONCLUSION'
        ];

        textareasInformeFre.forEach(function(selector) {
            const textarea = document.querySelector(selector);

            if (textarea) {
                textarea.value = textarea.defaultValue;
            }
        });

    
            $('#SELECT_CONCLUSION').val('').trigger('change');
            

			$("#tab_3").css('display', 'block');
			$("#tab_1").css('display', 'none');
			$("#tab_2").css('display', 'none');

			$("#steps_menu_tab1").click();


           
            
         
            var funcionesCargaFreErgo = [
                cargarDatosInformesFreErgo,
                cargarDatosGeneralesInformeFre,
                cargarDefinicionesFreErgo,
                cargarDatosGeneralesInformeReco,
                cargarMapaPeligros,
                mostrartablaactividadesfre,
                tablaReporteTrabajadoresErgo,
                mostrartablaimcfre,
                cargarMetodosFre,
                cargarGraficaPregunta1,
                cargarGraficaPregunta2,
                cargarGraficaPregunta3,
                cargarGraficaPregunta4,
                cargarGraficaPregunta5,
                cargarGraficaPregunta6,
                cargarRecomendacionesInformeFreErgo,
                tablaVersionesRecoErgo,
                validarEdicionRecoErgo,
                cargarDatosPlantilla

            ];

            $.each(funcionesCargaFreErgo, function (indice, funcion) {

                setTimeout(function () {

                    try {
                        funcion();
                    } catch (error) {
                        console.error(
                            'Error al ejecutar la función ' + funcion.name,
                            error
                        );
                    }

                }, indice * 400);

            });


			$('#INFORME_RESPONSABLE1DOCUMENTO').dropify({
							messages: {
								'default': 'Arrastre la imagen aquí o haga click',
								'replace': 'Arrastre la imagen o haga clic para reemplazar',
								'remove': 'Quitar',
								'error': 'Ooops, ha ocurrido un error.'
							},
							error: {
								'fileSize': 'Demasiado grande ({{ value }} max).',
								'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
								'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
								'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
								'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
								'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
							}
			});


            $('#INFORME_RESPONSABLE1DOCUMENTO').val('');
	        $('#INFORME_RESPONSABLE1DOCUMENTO').dropify().data('dropify').resetPreview();
            $('#INFORME_RESPONSABLE1DOCUMENTO').dropify().data('dropify').clearElement();


		$('#INFORME_RESPONSABLE2DOCUMENTO').dropify({
						messages: {
							'default': 'Arrastre la imagen aquí o haga click',
							'replace': 'Arrastre la imagen o haga clic para reemplazar',
							'remove': 'Quitar',
							'error': 'Ooops, ha ocurrido un error.'
						},
						error: {
							'fileSize': 'Demasiado grande ({{ value }} max).',
							'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
							'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
							'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
							'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
							'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
						}
					});



            $('#INFORME_RESPONSABLE2DOCUMENTO').val('');
	        $('#INFORME_RESPONSABLE2DOCUMENTO').dropify().data('dropify').resetPreview();
            $('#INFORME_RESPONSABLE2DOCUMENTO').dropify().data('dropify').clearElement();

			

			break;
		
		default:
			break;
	}
});

$('.multisteps-form__progress-btn').click(function () {
	switch (this.id) {
		case "steps_menu_tab4":
			recsensorial = $("#recsensorial_id").val(); 
            mostrarTablafichasevaluacionfre();
            break;
        case "steps_menu_tab5":
            recsensorial = $("#recsensorial_id").val(); 
            cargarGraficaPregunta1();
            cargarGraficaPregunta2();
            cargarGraficaPregunta3();
            cargarGraficaPregunta4();
            cargarGraficaPregunta5();
            cargarGraficaPregunta6();
		break;
		default:
		break;
	}
});



function cargarDatosPlantilla()
{
    $.ajax({
        url: 'obtenerDatosPlantilla',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: recsensorial
        },
        success: function(resp) {

            if (!resp.success) {
                return;
            }

            // INTROODUCCION
            let contenido = $('#INFORME_INTRODUCCION').summernote('code');

            if (contenido) {

                $.each(resp.data, function(marcador, valor) {
                    contenido = contenido.split(marcador).join(valor || '');
                });

                $('#INFORME_INTRODUCCION').summernote('code', contenido);
            }


            // RECONOCIMIENTO
             let reco = $('#INFORME_RECONOCIMIENTO').summernote('code');

            if (reco) {

                $.each(resp.data, function(marcador, valor) {
                    reco = reco.split(marcador).join(valor || '');
                });

                $('#INFORME_RECONOCIMIENTO').summernote('code', reco);
            }

        

            // PROCESO
            let proceso = $('#INFORME_PROCESOINSTALACION').val();

            if (proceso) {

                $.each(resp.data, function(marcador, valor) {
                    proceso = proceso.split(marcador).join(valor || '');
                });

                $('#INFORME_PROCESOINSTALACION').val(proceso);
            }

            // ACTIVIDAD PRINCIPAL
            let actividad = $('#INFORME_ACTIVIDADPRINCIPAL').val();

            if (actividad) {

                $.each(resp.data, function(marcador, valor) {
                    actividad = actividad.split(marcador).join(valor || '');
                });

                $('#INFORME_ACTIVIDADPRINCIPAL').val(actividad);
            }

        },
        error: function(xhr) {
            console.error('ERROR AL CARGAR PLANTILLA:', xhr.responseText);
        }
    });
}


//-----------------------------------------------------INPUT-----------------------------------------------------------------//
$('input[name="informe_del_cliente"]').change(function () {

	var valor = $(this).val();

	if (valor === '1') {

		cliente_lista(lista_clientes, $('#cliente_id').val())

	} else if (valor === '0') {
		///Limpiamos la informacion del cliente
		$("#empresa").val('');
		$("#rfc").val('');
		$("#representantelegal").val('');

	}
});

//-----------------------------------------------------BOTONES---------------------------------------------------------------//
$("#boton_nuevo_reconocimiento").click(function () {


	$('#inputfotomapa').attr('required', false);

	$('#titleOrganizacionLabel').fadeIn();

	$("#estructura-container").css('display', 'none');

	// mostrar TAB principal
	$("#tab_menu2").css('display', 'block');
	$("#tab_menu3").css('display', 'none');
	$("#tab_menu4").css('display', 'none');
	$("#tab_menu5").css('display', 'none');
	$("#tab_menu6").css('display', 'none');


	// ocultar secciones
	$("#steps_menu_tab2").css('display', 'none');
	$("#steps_menu_tab3").css('display', 'none');
	$("#steps_menu_tab4").css('display', 'none');
	$("#steps_menu_tab5").css('display', 'none');

	// LIMPIAR TITULO DEL RECONOCIMIENTO
	$(".div_reconocimiento_folios").html('FOLIO');
	$(".div_reconocimiento_alcance").html('Reconocimiento');
	$(".div_reconocimiento_instalacion").html('INSTALACIÓN');

	// Borrar border warning
	$('#divListaAgentes').removeClass('checkbox_warning');


    // Resetear campo FOTO INSTALACION
    

    // inicializar campo FOTO mapa ubicacion
	$('#inputfotomapa').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});

	$('#inputfotomapa').val('');
	$('#inputfotomapa').dropify().data('dropify').resetPreview();
	$('#inputfotomapa').dropify().data('dropify').clearElement();


	// inicializar campo FOTO plano instalacion
	$('#inputfotoplano').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});


	
	$('#inputfotoplano').val('');
	$('#inputfotoplano').dropify().data('dropify').resetPreview();
	$('#inputfotoplano').dropify().data('dropify').clearElement();



	// inicializar campo FOTO plano instalacion
	$('#inputfotoinstalacion').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});

	$('#inputfotoinstalacion').val('');
	$('#inputfotoinstalacion').dropify().data('dropify').resetPreview();
	$('#inputfotoinstalacion').dropify().data('dropify').clearElement();



	// inicializar campo FOTO mapa ubicacion
	$('#TECNICO_DOC_IMG').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});

	// inicializar campo FOTO plano instalacion
	$('#CONTRATO_DOC_IMG').dropify({
		messages: {
			'default': 'Arrastre la imagen aquí o haga click',
			'replace': 'Arrastre la imagen o haga clic para reemplazar',
			'remove': 'Quitar',
			'error': 'Ooops, ha ocurrido un error.'
		},
		error: {
			'fileSize': 'Demasiado grande ({{ value }} max).',
			'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
			'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
			'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
			'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
			'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
		}
	});


	$("#boton_descargarfotoinstalacion").css('display', 'none');

	// BOton evidencia fotografica quimicos
	$("#boton_nueva_fotoevidenciaquimicos").attr('disabled', false);

	// Desactivar boton descargas FOTO
	$("#boton_descargarmapaubicacion").css('display', 'none');
	$("#boton_descargarplanoinstalacion").css('display', 'none');
	$("#boton_descargarmapaderiesgo").css('display', 'none');

	// Visor quimico PDF
	$('#visor_pdfquimicos').attr('src', '/assets/images/nada.jpg');
	$("#visor_pdfquimicos").css('display', 'none');
	$("#visor_pdfquimicos_icono").css('display', 'block');

	// Borrar formulario
	$('#form_recsensorial').each(function () {
		this.reset();
	});

	// Campos Hidden
	$("#recsensorial_id").val(0);

	// Desbloquear campos alcances
	$("#recsensorial_alcancefisico").attr('disabled', false);
	$("#recsensorial_alcancequimico").attr('disabled', false);

	//Campos exclusivos para Pemex
	$('#catregion_id').attr('disabled', false);
	$('#catsubdireccion_id').attr('disabled', false);
	$('#catgerencia_id').attr('disabled', false);
	$('#catactivo_id').attr('disabled', false);

 
    $('#boton_nueva_categoria').prop('disabled', false);
    $('#boton_guardar_categoria').prop('disabled', false);
    $('#boton_nueva_area').prop('disabled', false);
    $('#boton_guardar_area').prop('disabled', false);

	//Ocultamos la seccion de validar quimicos ya que esa parte se rellena una vez esta finalizado el reconocimiento
	$('#finalizarQuimico').fadeOut(0)


	//Seteamos y ocultamos los valores de clientes y contratos obtenidos por el cliente
	$('#cliente_id').val('')
	$('#contrato_id').val('')
	$('#requiere_contrato').val('')
	$('#descripcion_contrato').val('')
	$('#descripcion_cliente').val('')
	$('#infoCliente').empty().css('border-style', 'none')


	$("#BOTON_TRAERHI").css('display', 'none');

    
	// seleccionar TAB	
	$("#steps_menu_tab1").click();
	$("#tab_menu2").click();

	//Cragamos la lista de los folios de los proyectos
	cargarFoliosProyecto(0);

});

$("#boton_descargarmapaubicacion").click(function () {
	window.open('/mostrarmapaubicacionergo/1/' + recsensorial);
});

$("#boton_descargarplanoinstalacion").click(function () {
	window.open('/mostraplanoergo/1/' + recsensorial);
});

$("#boton_descargarfotoinstalacion").click(function () {
	window.open('/mostrafotoinstalacionergo/1/' + recsensorial);
});


$("#boton_descargarmapaderiesgo").click(function () {
	window.open('/mostrarmapariesgoergo/1/' + recsensorial);
});




$("#boton_guardar_recsensorial").click(function () {

    $('#recsensorial_ordenservicio').attr('required', false);
    $('#inputfotomapa').prop('required', false);

    if ($('#proyecto_folio').val() != "") {

        var valida = this.form.checkValidity();

        if (valida) {

            Swal.fire({
                title: "¡Confirme que desea guardar!",
                text: "Reconocimiento sensorial",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }).then((result) => {

                if (result.isConfirmed) {

                    var formData = new FormData($('#form_recsensorial')[0]);
                    formData.append('opcion', 1);
                    formData.append('higiene', HIGIENE);

                    $.ajax({
                        url: '/reconocimientoergo',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,

                        beforeSend: function () {
                            $('#boton_guardar_recsensorial').html('Guardando <i class="fa fa-spin fa-spinner"></i>');
                        },

                        success: function (dato) {

                            $("#recsensorial_id").val(dato.recsensorial.id);
                            recsensorial = dato.recsensorial.id;

                            menu_parametros_ocultar();
                            activa_stepforms();
                            tabla_reconocimientosensorial();

                            Swal.fire({
                                icon: "success",
                                title: "¡El reconocimiento fue guardado exitosamente!",
                                text: dato.msj,
                                timer: 2500,
                                showConfirmButton: false
                            });

                            $('#boton_guardar_recsensorial').html('Guardar <i class="fa fa-save"></i>');
                        },

                        error: function (xhr) {

                            console.log(xhr.responseText);

                            $('#boton_guardar_recsensorial').html('Guardar <i class="fa fa-save"></i>');

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Error en la petición"
                            });
                        }
                    });

                } else {

                    Swal.fire({
                        icon: "error",
                        title: "Cancelado",
                        text: "Acción cancelada",
                        timer: 1000,
                        showConfirmButton: false
                    });

                }

            });

            return false;

        }

    } else {

        $('html, body').animate({
            scrollTop: $("#primeraParte").offset().top
        }, 1000);

        Swal.fire({
            icon: "warning",
            title: "Falta seleccionar un FOLIO de proyecto",
            text: "Es necesario seleccionar este reconocimiento con un FOLIO de proyecto para poder continuar!",
            timer: 2000,
            showConfirmButton: false
        });

        return false;
    }
});

//-------------------------------------------------------TABLAS---------------------------------------------------------------//
$('#tabla_reconocimiento_sensorial tbody').on('click', 'td.mostrar', function () {
	var tr = $(this).closest('tr');
	var row = tabla_recsensorial.row(tr);
	$('#form_responsables').each(function () {
		this.reset();
	});

	$('#inputfotomapa').attr('required', false);
	$('#infoCliente').empty().css('border-style', 'none');


	if (row.data().proyecto_folio == null) {

		$(".organizacional").css('display', 'block');
		$("#estructura-container").css('display', 'none');


	} else {
		$(".organizacional").css('display', 'none');

		$("#estructura-container").css('display', 'flex');

	}
	$("#steps_menu_tab2").css('display', 'block');
	$("#steps_menu_tab3").css('display', 'block');
	$("#steps_menu_tab4").css('display', 'block');
	$("#steps_menu_tab5").css('display', 'block');

	// Menu principal
	$("#tab_menu2").css('display', 'block');
	$("#tab_menu3").css('display', 'block');
	$("#tab_menu4").css('display', 'none');
	$("#tab_menu5").css('display', 'none');

	// Borrar formulario
	$('#form_recsensorial').each(function () {
		this.reset();
	});

	// Campos hidden
	recsensorial = row.data().id;
	$("#recsensorial_id").val(row.data().id);



	instalacionreco = row.data().instalacion;

	//Obtemos la estructura del proyecto
	obtenerEstructuraProyectos(row.data().proyecto_folio, 0);

	//Obtenemos la lista de los folios de proyectos y los asignamos
	cargarFoliosProyecto(row.data().proyecto_folio);



	var cliente = row.data().descripcion_cliente == null ? "Sin asignar cliente" : row.data().descripcion_cliente;
	var contrato = row.data().descripcion_contrato == null ? "Sin asignar contrato" : row.data().descripcion_contrato;


	// $('#infoCliente').html(`<h2 class="mt-2" style="font-weight:bold"><i class="fa fa-id-badge"></i> Cliente</h2>
	// 						<h4>${cliente}</h4>
	// 						<h2 class="mt-4" style="font-weight:bold"> <i class="fa fa-file-text"></i> Formalización del servicio</h2>
	// 						<h4 class="mb-2">${contrato}</h4>`).css('border-style','dotted')

	$("#empresa").val(row.data().empresa);
	$("#codigopostal").val(row.data().codigopostal);
	$("#rfc").val(row.data().rfc);
	$("#ordenservicio").val(row.data().ordenservicio);
	$("#representantelegal").val(row.data().representantelegal);
	$("#representanteseguridad").val(row.data().representanteseguridad);
	$("#direccion").val(row.data().direccion);
	$("#instalacion").val(row.data().instalacion);
	$("#coordenadas").val(row.data().coordenadas);
	$("#fechainicio").val(row.data().fechainicio);
	$("#fechafin").val(row.data().fechafin);
	$("#actividadprincipal").val(row.data().actividadprincipal);
	$("#descripcionproceso").val(row.data().descripcionproceso);
	$("#observaciones").val(row.data().observaciones);

	$("#ordentrabajo_id").val(row.data().ordentrabajo_id);
	$("#proyecto_folio").val(row.data().proyecto_folio);


	//Mostramos si la informacion del contrato es la que se le da al reconocimiento
	if (row.data().informe_del_cliente == 1) {
		$('#informe_del_cliente_si').prop('checked', true);
	} else {
		$('#informe_del_cliente_no').prop('checked', true);

	}



		///////////////// OBTENER FOTO UBICACION /////////////////
		if (row.data().fotoubicacion) {
			var archivo = row.data().fotoubicacion;
			var extension = archivo.substring(archivo.lastIndexOf("."));
			var imagenUrl = '/mostrarmapaubicacionergo/0/' + row.data().id + extension;

			rutaMapa = imagenUrl

			// INPUT FOTO UBICACION
			if ($('#inputfotomapa').data('dropify')) {
				$('#inputfotomapa').dropify().data('dropify').destroy();
				// $('.dropify-wrapper').css('height', 400);
				$('#inputfotomapa').dropify().data('dropify').settings.defaultFile = imagenUrl;
				$('#inputfotomapa').dropify().data('dropify').init();
			}
			else {
				// $('#inputfotomapa').attr('data-height', 400);
				$('#inputfotomapa').attr('data-default-file', imagenUrl);
				$('#inputfotomapa').dropify({
					messages: {
						'default': 'Arrastre la imagen aquí o haga click',
						'replace': 'Arrastre la imagen o haga clic para reemplazar',
						'remove': 'Quitar',
						'error': 'Ooops, ha ocurrido un error.'
					},
					error: {
						'fileSize': 'Demasiado grande ({{ value }} max).',
						'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
						'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
						'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
						'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
						'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
					}
				});
			}

			// No requerir campo FOTO
			$('#inputfotomapa').attr('required', false);

			// Activar boton descarga
			$("#boton_descargarmapaubicacion").css('display', 'block');
		}
		else {
			$("#boton_descargarmapaubicacion").css('display', 'none');
	}
	


	///////////// OBTENER PLANO INSTALACION /////////////
	
		if (row.data().fotoplano) {
			var archivo = row.data().fotoplano;
			var extension = archivo.substring(archivo.lastIndexOf("."));
			var imagenUrl = '/mostraplanoergo/0/' + row.data().id + extension;

			rutaMapa = imagenUrl

			// INPUT FOTO UBICACION
			if ($('#inputfotoplano').data('dropify')) {
				$('#inputfotoplano').dropify().data('dropify').destroy();
				// $('.dropify-wrapper').css('height', 400);
				$('#inputfotoplano').dropify().data('dropify').settings.defaultFile = imagenUrl;
				$('#inputfotoplano').dropify().data('dropify').init();
			}
			else {
				// $('#inputfotomapa').attr('data-height', 400);
				$('#inputfotoplano').attr('data-default-file', imagenUrl);
				$('#inputfotoplano').dropify({
					messages: {
						'default': 'Arrastre la imagen aquí o haga click',
						'replace': 'Arrastre la imagen o haga clic para reemplazar',
						'remove': 'Quitar',
						'error': 'Ooops, ha ocurrido un error.'
					},
					error: {
						'fileSize': 'Demasiado grande ({{ value }} max).',
						'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
						'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
						'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
						'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
						'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
					}
				});
			}

			// No requerir campo FOTO
			$('#inputfotoplano').attr('required', false);

			// Activar boton descarga
			$("#boton_descargarplanoinstalacion").css('display', 'block');
		}
		else {
			$("#boton_descargarplanoinstalacion").css('display', 'none');
	}


	//////////// OBTENER FOTO INSTALACION ////////////
	
		if (row.data().fotoinstalacion) {
			var archivo = row.data().fotoinstalacion;
			var extension = archivo.substring(archivo.lastIndexOf("."));
			var imagenUrl = '/mostrafotoinstalacionergo/0/' + row.data().id + extension;

			rutaMapa = imagenUrl

			// INPUT FOTO UBICACION
			if ($('#inputfotoinstalacion').data('dropify')) {
				$('#inputfotoinstalacion').dropify().data('dropify').destroy();
				// $('.dropify-wrapper').css('height', 400);
				$('#inputfotoinstalacion').dropify().data('dropify').settings.defaultFile = imagenUrl;
				$('#inputfotoinstalacion').dropify().data('dropify').init();
			}
			else {
				// $('#inputfotomapa').attr('data-height', 400);
				$('#inputfotoinstalacion').attr('data-default-file', imagenUrl);
				$('#inputfotoinstalacion').dropify({
					messages: {
						'default': 'Arrastre la imagen aquí o haga click',
						'replace': 'Arrastre la imagen o haga clic para reemplazar',
						'remove': 'Quitar',
						'error': 'Ooops, ha ocurrido un error.'
					},
					error: {
						'fileSize': 'Demasiado grande ({{ value }} max).',
						'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
						'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
						'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
						'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
						'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
					}
				});
			}

			// No requerir campo FOTO
			$('#inputfotoinstalacion').attr('required', false);

			// Activar boton descarga
			$("#boton_descargarfotoinstalacion").css('display', 'block');
		}
		else {
			$("#boton_descargarfotoinstalacion").css('display', 'none');
	}



	// Perfil
	recsensorial_perfil = parseInt(row.data().perfil);
	//responsables
	$("#NOMBRE_TECNICO").val(row.data().NOMBRE_TECNICO);
	$("#NOMBRE_CONTRATO").val(row.data().NOMBRE_CONTRATO);
	$("#CARGO_TECNICO").val(row.data().CARGO_TECNICO);
	$("#CARGO_CONTRATO").val(row.data().CARGO_CONTRATO);
	
	if (row.data().TECNICO_DOC){
		var archivo = row.data().TECNICO_DOC;
		var extension = archivo.substring(archivo.lastIndexOf("."));
		var imagenUrl = '/mostrartecnicodoc/0/' + row.data().id + extension;
		
		rutaMapa = imagenUrl

		// INPUT FOTO TECNICO DOC
		if ($('#TECNICO_DOC_IMG').data('dropify'))
		{
			$('#TECNICO_DOC_IMG').dropify().data('dropify').destroy();
			// $('.dropify-wrapper').css('height', 400);
			$('#TECNICO_DOC_IMG').dropify().data('dropify').settings.defaultFile = imagenUrl;
			$('#TECNICO_DOC_IMG').dropify().data('dropify').init();
		}
		else
		{
			// $('#inputfotomapa').attr('data-height', 400);
			$('#TECNICO_DOC_IMG').attr('data-default-file', imagenUrl);
			$('#TECNICO_DOC_IMG').dropify({
				messages: {
					'default': 'Arrastre la imagen aquí o haga click',
					'replace': 'Arrastre la imagen o haga clic para reemplazar',
					'remove':  'Quitar',
					'error':   'Ooops, ha ocurrido un error.'
				},
				error: {
					'fileSize': 'Demasiado grande ({{ value }} max).',
					'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
					'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
					'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
					'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
					'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
				}
			});
		}

		// No requerir campo FOTO
		$('#TECNICO_DOC_IMG').attr('required', false);

		// Activar boton descarga
		$("#boton_descargarTECNICO_DOC").css('display', 'block');
	}
	else
	{
		$("#boton_descargarTECNICO_DOC").css('display', 'none');
	}

	// OBTENER FOTO PLANO
	if (row.data().CONTRATO_DOC) {
		var archivo = row.data().CONTRATO_DOC;
		var extension = archivo.substring(archivo.lastIndexOf("."));
		var imagenUrl = '/mostrarcontratodoc/0/' + row.data().id + extension;

		rutaMapa = imagenUrl


		// INPUT FOTO PLANO
		if ($('#CONTRATO_DOC_IMG').data('dropify')) {
			$('#CONTRATO_DOC_IMG').dropify().data('dropify').destroy();
			// $('.dropify-wrapper').css('height', 400);
			$('#CONTRATO_DOC_IMG').dropify().data('dropify').settings.defaultFile = imagenUrl;
			$('#CONTRATO_DOC_IMG').dropify().data('dropify').init();
		}
		else {
			// $('#inputfotoplano').attr('data-height', 400);
			$('#CONTRATO_DOC_IMG').attr('data-default-file', imagenUrl);
			$('#CONTRATO_DOC_IMG').dropify({
				messages: {
					'default': 'Arrastre la imagen aquí o haga click',
					'replace': 'Arrastre la imagen o haga clic para reemplazar',
					'remove': 'Quitar',
					'error': 'Ooops, ha ocurrido un error.'
				},
				error: {
					'fileSize': 'Demasiado grande ({{ value }} max).',
					'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
					'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
					'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
					'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
					'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
				}
			});
		}

		// No requerir campo FOTO
		$('#CONTRATO_DOC_IMG').attr('required', false);

		// Activar boton descarga
		$("#boton_descargarCONTRATO_DOC").css('display', 'block');
	}
	else {
		$("#boton_descargarCONTRATO_DOC").css('display', 'none');
	}


	// Colocar nombre del reconocimieto
	$(".div_reconocimiento_instalacion").html(row.data().instalacion);

	// seleccionar TAB
	$("#steps_menu_tab1").click();
	$("#tab_menu2").click();
});



//-----------------------------------------------------FUNCIONES------------------------------------------------------------//

function activa_stepforms() {
	$("#steps_menu_tab2").css('display', 'block');
	$("#steps_menu_tab3").css('display', 'block');
	$("#steps_menu_tab4").css('display', 'block');
	$("#steps_menu_tab5").css('display', 'block');
}

function desactiva_stepforms() {
	$("#steps_menu_tab2").css('display', 'none');
	$("#steps_menu_tab3").css('display', 'none');
	$("#steps_menu_tab4").css('display', 'none');
	$("#steps_menu_tab5").css('display', 'none');

}

function menu_parametros_ocultar() {
	//Ocultar Menu agentes, Modulo evaluacion de Fisicos completo
	$('.link_menuparametro').each(function () {
		$("#" + this.id).removeClass('active');
		$("#" + this.id).css('display', 'none');
	});

	//Ocultar las opciones select, Modulo evaluacion de Puntos de muestreos por el CLIENTE
	$('.selectagente').each(function () {
		$("#" + this.id).css('display', 'none');
	});
}

function tabla_reconocimientosensorial() {
	try {
		var ruta = "/tablareconocimientoergo";

		if (tabla_recsensorial != null) {
			// Destruir la tabla existente antes de crear una nueva
			tabla_recsensorial.destroy();

		}

		tabla_recsensorial = $('#tabla_reconocimiento_sensorial').DataTable({
			"ajax": {
				"url": ruta,
				"type": "get",
				"cache": false,
				"error": function (xhr, error, code) {
					console.log('error en tabla_recsensorial');
				},
				"data": {}
			},
			"columns": [
				{
					"data": "numero_registro",
					"defaultContent": "-"
				},
				{
					"data": "rfc",
					"defaultContent": "-"
				},
				{
					"data": "codigopostal",
					"defaultContent": "-"
				},
				{
					"data": "proyecto_folio",
					"defaultContent": "--"
				},
				{
					"data": "instalacion"
				},
				{
					"className": 'mostrar',
					"orderable": false,
					"data": 'boton_mostrar',
					"defaultContent": '-'
				}
			],
			"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
			"order": [[0, "DESC"]],
			"ordering": true,
			"processing": true,
			"responsive": true,
			"language": {
				"lengthMenu": "Mostrar _MENU_ Registros",
				"zeroRecords": "No se encontraron registros",
				"info": "Página _PAGE_ de _PAGES_ (Total _MAX_ registros)",
				"infoEmpty": "No se encontraron registros",
				"infoFiltered": "(Filtrado de _MAX_ registros)",
				"emptyTable": "No hay datos disponibles en la tabla",
				"loadingRecords": "Cargando datos....",
				"processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
				"search": "Buscar",
				"paginate": {
					"first": "Primera",
					"last": "Última",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});

		tabla_recsensorial.on('draw', function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
	} catch (exception) {
		console.error("Error en tabla_reconocimientosensorial:", exception);
	}
}

function cargarFoliosProyecto(proyecto_folio) {

	$('#proyecto_folio').html('');

	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/folioproyectoergp/" + proyecto_folio,
		data: {},
		cache: false,
		success: function (dato) {
			$('#proyecto_folio').html(dato.opciones);

		}, beforeSend: function () {

			$('#proyecto_folio').html('<option value="" selected> Consultando folios de proyectos... </option>');

		},
		error: function (dato) {
			// alert('Error: '+dato.msj);
			return false;
		}
	});//Fin ajax
}

function obtenerEstructuraProyectos(FOLIO, NUEVO) {

	$('#titleOrganizacionLabel').fadeOut();

	$.ajax({
		url: '/estructuraproyectosergo/' + FOLIO,
		method: 'GET',
		beforeSend: function () {
			$('#estructura-container').empty();
		},
		success: function (response) {

			//MOSTRAMOS LA ESTRUCTURA ORGANIZACIONAL DEL PROYECTO 
			if (response.data && response.data.length > 0) {
				var container = $('#estructura-container');

				$('#estructura-container').css({ 'background': '#e8e8e8', 'padding': '10px', 'border-style': 'dotted', 'border-color': '#000', 'border-width': '1px', 'border-radius': '15px', 'display': 'flex' });

				container.append(
					'<div class="col-12 text-center">' +
					'<h3 class="mb-2" style="font-weight: bold">Estructura organizacional</h3>' +
					'</div>'
				);

				var niveles = [1, 2, 3, 4, 5];
				niveles.forEach(function (nivel) {
					var data = response.data.filter(item => item.NIVEL == nivel);
					if (data.length > 0) {
						data.forEach(function (item) {
							container.append(
								'<div class="col-6"><label style="color: black;">Nivel ' + nivel + (nivel === 1 ? ' (Considerado como el más alto)' : '') + '</label></div>' +
								'<div class="col-6"><label style="color: black;">Clasificación</label></div>' +
								'<div class="col-6"><label>' + item.NOMBRE_ETIQUETA + '</label></div>' +
								'<div class="col-6"><label>' + item.NOMBRE_OPCIONES + '</label></div>'
							);
						});
					}
				});
			} else {
				$('#estructura-container').append('<p>No se encontraron datos.</p>');
			}

			
			if(response.HIGIENE[0].HI_RECONOCIMIENTO===1){
				HIGIENE = 1;
				$('#boton_nueva_categoria').prop('disabled', true);
				$('#boton_nueva_area').prop('disabled', true);
	            $("#BOTON_TRAERHI").css('display', 'block');

                
			}else{
                HIGIENE = 0;
                $('#boton_nueva_categoria').prop('disabled', false);
				$('#boton_guardar_categoria').prop('disabled', false);
				$('#boton_nueva_area').prop('disabled', false);
                $('#boton_guardar_area').prop('disabled', false);
	            $("#BOTON_TRAERHI").css('display', 'none');
                
			}

			//MOSTRAMOS LOS DATOS DEL PROYECTO SOLO SI ES NUEVO SI YA ESTA CARGADO MOSTRAMOS LOS DATOS GUARDADOS EN LA BASE DE DATOS
			$('#higiene').val(HIGIENE)

			if (NUEVO == 1) {

				

				$('#empresa').val(response.info[0].RAZON_SOCIAL)
				$('#rfc').val(response.info[0].RFC)
				$('#representanteseguridad').val(response.info[0].REPRESENTANTE)
				$('#direccion').val(response.info[0].DIRRECCION)
				$('#instalacion').val(response.info[0].INSTALACION)

				// Input ocultos
				var contrato = response.info[0].CONTRATO_ID == 0 ? "" : response.info[0].CONTRATO_ID
				var requiereContrato = response.info[0].CONTRATO_ID == 0 ? 0 : 1

				$('#cliente_id').val(response.info[0].CLIENTE_ID)
				$('#contrato_id').val(contrato)
				$('#requiere_contrato').val(requiereContrato)
				$('#descripcion_contrato').val(response.info[0].NOMBRE_CONTRATO)
				$('#descripcion_cliente').val(response.info[0].RAZON_SOCIAL)



				//INFORMACION CONSULTADA DE RECSENSORIAL


			
				
				$('#ordenservicio').val(response.info[0].ORDENSERVICIO)
				$('#representantelegal').val(response.info[0].REPRESENTANTE_LEGAL)
				$('#codigopostal').val(response.info[0].CODIGOPOSTAL)
				$('#coordenadas').val(response.info[0].COORDENADAS)
				$('#actividadprincipal').val(response.info[0].ACTIVIDADPRINCIPAL)
				$('#descripcionproceso').val(response.info[0].DESCRIPCIONPROCESO)
				$('#observaciones').val(response.info[0].OBSERVACION)
				$('#fechainicio').val(response.info[0].FECHAINICIO)
				$('#fechafin').val(response.info[0].FECHAFIN)




				$('#infoCliente').html(`<h2 class="mt-2" style="font-weight:bold"><i class="fa fa-id-badge"></i> Cliente</h2>
										<h4>${response.info[0].RAZON_SOCIAL}</h4>
										<h2 class="mt-4" style="font-weight:bold"> <i class="fa fa-file-text"></i> ${response.info[0].TIPO_SERVICIO}</h2>
										<h4 class="mb-2">${response.info[0].NOMBRE_CONTRATO}</h4>`).css('border-style', 'dotted')

				
			
                
                
                if (response.info[0].FOTOUBICACION != null) {

                    var archivo = response.info[0].FOTOUBICACION;
                    var extension = archivo.substring(archivo.lastIndexOf("."));
                    var imagenUrl = '/mostrarmapa/0/' + response.info[0].ID + extension;

                    rutaMapa = imagenUrl;

                    // GUARDAMOS DATOS
                    $("#hidden_fotomapa").val(response.info[0].ID);
                    $("#hidden_fotomapa_extension").val(extension);
                    $("#hidden_fotomapa_ruta").val(response.info[0].FOTOUBICACION);

                    // INPUT FOTO UBICACION
                    if ($('#inputfotomapa').data('dropify')) {

                        $('#inputfotomapa').dropify().data('dropify').destroy();

                        $('#inputfotomapa').dropify({
                            defaultFile: imagenUrl,
                            messages: {
                                'default': 'Arrastre la imagen aquí o haga click',
                                'replace': 'Arrastre la imagen o haga clic para reemplazar',
                                'remove': 'Quitar',
                                'error': 'Ooops, ha ocurrido un error.'
                            },
                            error: {
                                'fileSize': 'Demasiado grande ({{ value }} max).',
                                'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                                'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                                'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                                'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                                'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                            }
                        });

                    } else {

                        $('#inputfotomapa').attr('data-default-file', imagenUrl);

                        $('#inputfotomapa').dropify({
                            messages: {
                                'default': 'Arrastre la imagen aquí o haga click',
                                'replace': 'Arrastre la imagen o haga clic para reemplazar',
                                'remove': 'Quitar',
                                'error': 'Ooops, ha ocurrido un error.'
                            },
                            error: {
                                'fileSize': 'Demasiado grande ({{ value }} max).',
                                'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                                'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                                'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                                'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                                'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                            }
                        });
                    }

                    $('#inputfotomapa').attr('required', false);

                    $("#boton_descargarmapaubicacion").css('display', 'block');

                } else {

                    $("#boton_descargarmapaubicacion").css('display', 'none');
                }



                // FOTO PLANO

				if (response.info[0].FOTOPLANO != null) {

                    var archivo = response.info[0].FOTOPLANO;
                    var extension = archivo.substring(archivo.lastIndexOf("."));
                    var imagenUrl = '/mostrarplano/0/' + response.info[0].ID + extension;

                    rutaMapa = imagenUrl;

                    $("#hidden_fotoplano").val(response.info[0].ID);
                    $("#hidden_fotoplano_extension").val(extension);

                    // NUEVO
                    $("#hidden_fotoplano_ruta").val(response.info[0].FOTOPLANO);

                    // INPUT FOTO PLANO
                    if ($('#inputfotoplano').data('dropify')) {

                        $('#inputfotoplano').dropify().data('dropify').destroy();

                        $('#inputfotoplano').dropify().data('dropify').settings.defaultFile = imagenUrl;

                        $('#inputfotoplano').dropify().data('dropify').init();

                    }
                    else {

                        $('#inputfotoplano').attr('data-default-file', imagenUrl);

                        $('#inputfotoplano').dropify({
                            messages: {
                                'default': 'Arrastre la imagen aquí o haga click',
                                'replace': 'Arrastre la imagen o haga clic para reemplazar',
                                'remove': 'Quitar',
                                'error': 'Ooops, ha ocurrido un error.'
                            },
                            error: {
                                'fileSize': 'Demasiado grande ({{ value }} max).',
                                'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                                'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                                'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                                'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                                'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                            }
                        });
                    }

                    $('#inputfotoplano').attr('required', false);

                    $("#boton_descargarplanoinstalacion").css('display', 'block');

                }
                else {

                    $("#boton_descargarplanoinstalacion").css('display', 'none');
                }
                                
				


// FOTO INSTALACION

				if (response.info[0].FOTOINSTALACION) {

                        var archivo = response.info[0].FOTOINSTALACION;
                        var extension = archivo.substring(archivo.lastIndexOf("."));
                        var imagenUrl = '/mostrarfotoinstalacion/0/' + response.info[0].ID + extension;

                        $("#hidden_fotoinstalacion").val(response.info[0].ID);
                        $("#hidden_fotoinstalacion_extension").val(extension);

                        // NUEVO
                        $("#hidden_fotoinstalacion_ruta").val(response.info[0].FOTOINSTALACION);

                        // INPUT FOTO INSTALACION
                        if ($('#inputfotoinstalacion').data('dropify')) {

                            $('#inputfotoinstalacion').dropify().data('dropify').destroy();

                            $('#inputfotoinstalacion').dropify().data('dropify').settings.defaultFile = imagenUrl;

                            $('#inputfotoinstalacion').dropify().data('dropify').init();

                        }
                        else {

                            $('#inputfotoinstalacion').attr('data-default-file', imagenUrl);

                            $('#inputfotoinstalacion').dropify({
                                messages: {
                                    'default': 'Arrastre la imagen aquí o haga click',
                                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                                    'remove': 'Quitar',
                                    'error': 'Ooops, ha ocurrido un error.'
                                },
                                error: {
                                    'fileSize': 'Demasiado grande ({{ value }} max).',
                                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                                    'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                                }
                            });
                        }

                        $('#inputfotoinstalacion').attr('required', false);

                        $("#boton_descargarfotoinstalacion").css('display', 'block');

                    }
                    else {

                        $('#inputfotoinstalacion').val('');

                        $('#inputfotoinstalacion').dropify().data('dropify').resetPreview();

                        $('#inputfotoinstalacion').dropify().data('dropify').clearElement();

                        $('#inputfotoinstalacion').attr('required', false);

                        $("#boton_descargarfotoinstalacion").css('display', 'none');
				    }
				


				swal({
					title: "Información del proyecto consultada y asignada correctamente",
					text: "Al momento de seleccionar un FOLIO se consulta la información cargada en proyecto y se asigna a reconocimiento",
					type: "success",
					buttons: { visible: true },
					showConfirmButton: true,
					showCancelButton: false,

				});
			} else {

				$('#infoCliente').html(`<h2 class="mt-2" style="font-weight:bold"><i class="fa fa-id-badge"></i> Cliente</h2>
									<h4>${response.info[0].RAZON_SOCIAL}</h4>
									<h2 class="mt-4" style="font-weight:bold"> <i class="fa fa-file-text"></i> ${response.info[0].TIPO_SERVICIO}</h2>
									<h4 class="mb-2">${response.info[0].NOMBRE_CONTRATO}</h4>`).css('border-style', 'dotted')

			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error('Error al consultar los datos:', textStatus, errorThrown);
			$('#estructura-container').append('<p>Error al consultar los datos.</p>');
		}
	});
}


////// FICHAS TECNICAS

$("#boton_nueva_ficha").click(function (e) {
    e.preventDefault();

    ID_FICHAS_TECNICAS = 0;

    $('#form_fichas')[0].reset();

    cargarCategoriasSelect();

    $('[id^="ficha_"]').empty();

    $("#contenedorActividades").empty(); 
    $('#contenido2, #contenido3, #contenido4, #contenido5, #contenido6, #contenido7').hide();

   $('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION')
    .attr('style', 'display:block !important;');

    $("#modal_fichas").modal("show");

	$('#modal_fichas .modal-title').html('Nueva ficha');
	
    $('#JSON_ACTIVIDADES').val('')


    
    var selectTurno = $('#TURNO_EMPLEADO_FICHA').selectize({
        placeholder: 'Seleccione una o varias opciones',
        allowEmptyOption: true,
        closeAfterSelect: false,
    })[0].selectize;
    
    selectAreasFichas.clear();
    selectTurno.clear();
    
    
    $.ajax({
        url: 'obtenerPEFichas',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            reco_id: recsensorial
        },
        success: function (resp) {
            $('#PE_EVALUADAS').val(resp.pe);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });



});

$('#modal_fichas').on('hidden.bs.modal', function (e) {

     ID_FICHAS_TECNICAS = 0;

    $('#form_fichas')[0].reset();

    $('[id^="ficha_"]').empty();

    $("#contenedorActividades").empty(); 
    $('#contenido2, #contenido3, #contenido4, #contenido5, #contenido6, #contenido7').hide();

   $('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION')
    .attr('style', 'display:block !important;');

    $('#JSON_ACTIVIDADES').val('')

	selectAreasFichas.clear();

})

let selectAreasFichas;

$(document).ready(function () {

    selectAreasFichas = $('#CAT_AREAS_FICHA').selectize({
        placeholder: 'Seleccione una o varias opciones',
        maxItems: null,
    })[0].selectize;

});

function calcularEdad(fechaNacimiento) {
    if (!fechaNacimiento) return '';

    const partes = fechaNacimiento.split('-'); 

    if (partes.length !== 3) return '';

    const nacimiento = new Date(partes[0], partes[1] - 1, partes[2]);
    const hoy = new Date();

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mesDiferencia = hoy.getMonth() - nacimiento.getMonth();

    if (mesDiferencia < 0 || (mesDiferencia === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad >= 0 ? edad : '';
}

$('#FECHA_NACIMIENTO').on('change blur', function () {
    const fecha = $(this).val();
    const edad = calcularEdad(fecha);

    $('#EDAD_EMPLEADO_FICHA').val(edad);
});

function cargarCategoriasSelect(callback = null) {

    let reco_id = $("#recsensorial_id").val(); 

    $.ajax({
        url: '/getCategoriasErgo',
        type: 'GET',
        data: { reco_id: reco_id },
        success: function (response) {

            let select = $('#CATEGORIA_ID_FICHA');
            select.empty();

            select.append('<option value="">Selecciona un tipo de valor</option>');

            response.data.forEach(function (item) {

                let areas = JSON.stringify(item.CATEGORIA_AREAS_ID || []);

                select.append(`
                    <option 
                        value="${item.ID_CATEGORIA_ERGO}"
                        data-departamento="${item.CAT_DEPARTAMENTO}"
                        data-areas='${areas}'
                    >
                        ${item.NOMBRE_CATEGORIA_ERGO}
                    </option>
                `);
            });
            if (callback) callback();
        }
    });
}

$(document).on('change', '#CATEGORIA_ID_FICHA', function () {

    let selected = $(this).find(':selected');

    let departamento = selected.data('departamento');
    let areas = selected.data('areas');

    if (departamento) {
        $('#CAT_DEPARTAMENTO_FICHA').val(departamento).trigger('change');
    } else {
        $('#CAT_DEPARTAMENTO_FICHA').val('');
    }

    if (typeof areas === "string") {
        try { areas = JSON.parse(areas); } 
        catch (e) { areas = []; }
    }

    if (!Array.isArray(areas)) {
        areas = [];
    }

    cargarAreasFicha(areas);
});

function cargarAreasFicha(valoresSeleccionados = []) {

    let reco_id = $("#recsensorial_id").val(); 

    selectAreasFichas.clearOptions();
    selectAreasFichas.clear();

    $.ajax({
        url: '/obtenerareasergo',
        type: 'GET',
        data: { reco_id: reco_id },
        success: function (response) {

            response.data.forEach(function (item) {
                selectAreasFichas.addOption({
                    value: item.ID_AREA_ERGO,
                    text: item.NOMBRE_AREA_ERGO
                });
            });

            selectAreasFichas.setValue(valoresSeleccionados);

            selectAreasFichas.refreshOptions(false);
        },
        error: function () {
            console.log('Error cargando áreas');
        }
    });
}


/// ACTIVIDADES  - TAREAS 

function agregarActividad() {

    let contenedor = document.getElementById("contenedorActividades");
    let total = contenedor.querySelectorAll('.actividad-item').length + 1;

    let html = `
    <div class="actividad-item" id="actividad_${total}">
        <div class="actividad-card">

            <div class="d-flex justify-content-between mb-2">
                <strong>Actividad ${total}</strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)"> <i class="fa fa-trash"></i></button>
            </div>

            <div class="actividad-row">

                <div class="actividad-left">
                    <label class="d-block">Nombre de la actividad
                        <textarea class="form-control actividad-nombre mt-1" rows="3" placeholder="Nombre de la actividad"></textarea>
                    </label>
                </div>

                <div class="actividad-right">
                    <button type="button" class="btn btn-agregar-tarea" onclick="agregarTarea(${total})"> + Agregar tarea</button>

                    <div id="tareas_${total}"></div>
                </div>

            </div>
        </div>
    </div>
    `;

    contenedor.insertAdjacentHTML('beforeend', html);

    reindexarActividades();
}

function eliminarActividad(btn) {

    btn.closest('.actividad-item').remove();

    reindexarActividades();
}

function reindexarActividades() {

    let actividades = document.querySelectorAll(
        '#contenedorActividades .actividad-item'
    );

    actividades.forEach((el, index) => {

        let num = index + 1;

        el.id = `actividad_${num}`;

        el.querySelector('strong').innerText = `Actividad ${num}`;

        let textarea = el.querySelector('.actividad-nombre');
        textarea.name = `actividades[${num}][nombre]`;

        let btnTarea = el.querySelector('.btn-agregar-tarea');
        btnTarea.setAttribute('onclick', `agregarTarea(${num})`);

        let tareasDiv = el.querySelector('[id^="tareas_"]');
        tareasDiv.id = `tareas_${num}`;

        reindexarTareasActividad(tareasDiv, num);
    });
}

function agregarTarea(idActividad) {

    let contenedor = document.getElementById(`tareas_${idActividad}`);
    let total = contenedor.querySelectorAll('.tarea-item').length + 1;

    let html = `
    <div class="tarea-item">

        <div class="d-flex justify-content-between mb-2">
            <small>Tarea ${total}</small>

            <button type="button"  class="btn btn-danger btn-sm" onclick="eliminarTarea(this)"> <i class="fa fa-trash"></i></button>
        </div>

        <div class="form-group mb-2">
            <label class="d-block">Nombre de la tarea
                <textarea class="form-control mt-1 tarea-nombre" rows="3" ></textarea>
            </label>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group mb-2">
                    <label class="d-block">Frecuencia
                        <input type="text" class="form-control mt-1 tarea-frecuencia">
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group mb-2">
                    <label class="d-block">
                        No de veces
                        <input type="text" class="form-control mt-1 tarea-numero-veces" >
                    </label>
                </div>
            </div>

        </div>

        <div class="form-group mb-2">
            <label class="d-block"> Duración (tiempo en Min)
                <input type="text"
                    class="form-control mt-1 tarea-duracion" >
            </label>
        </div>
    </div>
    `;

    contenedor.insertAdjacentHTML('beforeend', html);

    reindexarTareasActividad(contenedor, idActividad);
}

function eliminarTarea(btn) {

    let tareaItem = btn.closest('.tarea-item');
    let contenedor = tareaItem.parentElement;

    tareaItem.remove();

    let idActividad = contenedor.id.split('_')[1];

    reindexarTareasActividad(contenedor, idActividad);
}

function reindexarTareasActividad(contenedor, idActividad) {

    let tareas = contenedor.querySelectorAll('.tarea-item');

    tareas.forEach((el, index) => {

        let num = index + 1;

        let titulo = el.querySelector('small');

        if (titulo) {
            titulo.innerText = `Tarea ${num}`;
        }

        el.querySelector('.tarea-nombre').name =
            `actividades[${idActividad}][tareas][${num}][nombre]`;

        el.querySelector('.tarea-frecuencia').name =
            `actividades[${idActividad}][tareas][${num}][frecuencia]`;

        el.querySelector('.tarea-numero-veces').name =
            `actividades[${idActividad}][tareas][${num}][numero_veces]`;

        el.querySelector('.tarea-duracion').name =
            `actividades[${idActividad}][tareas][${num}][duracion]`;
    });
}

/// FIN TAREA 


function toggleSeccion(id) {

    let cont = $('#' + id);

    cont.slideToggle();

    if (cont.is(':visible')) {

        if (id === "contenido2") {
            $('#ficha_1_1, #ficha_1_3').empty();
            fichas["1.1"].render();
            fichas["1.3"].render();
        }

        if (id === "contenido3") {
            $('#ficha_1_2').empty();
            fichas["1.2"].render();
        }

        if (id === "contenido4") {
            $('#ficha_2_1, #ficha_2_2').empty();
            fichas["2.1"].render();
            fichas["2.2"].render();
        }

        if (id === "contenido5") {
            $('#ficha_3_1').empty();
            fichas["3.1"].render();
        }

        if (id === "contenido6") {
            $('#ficha_4_1').empty();
            fichas["4.1"].render();
        }

        if (id === "contenido7") {
            $('#ficha_4_2').empty();
            fichas["4.2"].render();
        }
    }
}

const fichas = {

"1.1": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde">
<b>FICHA 1.1.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por LEVANTAMIENTO DE CARGAS.</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr>
<td width="40"  class="texto-pregunta">a.</td>
<td class="texto-pregunta">¿Todas las cargas levantadas pesan 10 kg o menos?</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a" id="a_no" value="NO" required>
<label class="form-check-label" for="a_no">NO</label>
</div>
</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a" id="a_si" value="SI" required>
<label class="form-check-label" for="a_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">b.</td>
<td class="texto-pregunta">
¿El peso máximo de la carga está entre 3 kg y 5 kg y la frecuencia de levantamientos no excede de 5 levantamientos/minuto?<br><br>
O bien,<br><br>
¿El peso máximo de la carga es de más de 5 kg e inferior a los 10 kg y la frecuencia no excede de 1 levantamiento/minuto?
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b" id="b_no" value="NO" required>
<label class="form-check-label" for="b_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b" id="b_si" value="SI" required>
<label class="form-check-label" for="b_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">c.</td>
<td class="texto-pregunta">¿El desplazamiento vertical se realiza entre la cadera y los hombros?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c" id="c_no" value="NO" required>
<label class="form-check-label" for="c_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c" id="c_si" value="SI" required>
<label class="form-check-label" for="c_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">d.</td>
<td class="texto-pregunta">¿El tronco está erguido, sin flexión ni rotación?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="d" id="d_no" value="NO" required>
<label class="form-check-label" for="d_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="d" id="d_si" value="SI" required>
<label class="form-check-label" for="d_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">e.</td>
<td class="texto-pregunta">¿La carga se mantiene muy cerca del cuerpo (no más de 10 cm de la parte frontal del torso)?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="e" id="e_no" value="NO" required>
<label class="form-check-label" for="e_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="e" id="e_si" value="SI" required>
<label class="form-check-label" for="e_si">SI</label>
</div>
</td>
</tr>

</table>

<div class="p-3">
Si a todas las preguntas ha contestado “SI” entonces la tarea tiene un riesgo aceptable y está en la Zona Verde.
Si alguna de las respuestas es “NO”, compruebe si se trata de una tarea con un nivel de riesgo inaceptable según la ficha 1.4.
</div>

</div>
</div>
`;

        $('#ficha_1_1').html(html);
        
$('input[name="a"], input[name="b"], input[name="c"], input[name="d"], input[name="e"]')
.change(evaluarFicha_1_1);

}

    },
    
    "1.2": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde">
<b>FICHA 1.2.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por TRANSPORTE DE CARGAS.</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr>
<td width="40" class="texto-pregunta">a.</td>
<td class="texto-pregunta">
Si se requiere que una carga sea transportada manualmente a una distancia inferior o igual a 10 m, responda:<br><br>

¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 10.000 kg en 8 horas?<br>
Y<br>
¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 1.500 kg en 1 hora?<br>
Y<br>
¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 30 kg en 1 minuto?
</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a2" id="a2_no" value="NO" required>
<label class="form-check-label" for="a2_no">NO</label>
</div>
</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a2" id="a2_si" value="SI" required>
<label class="form-check-label" for="a2_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">b.</td>
<td class="texto-pregunta">
Si se requiere que una carga sea transportada manualmente a una distancia superior a 10 m, responda:<br><br>

¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 6.000 kg en 8 horas?<br>
Y<br>
¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 750 kg en 1 hora?<br>
Y<br>
¿La masa acumulada transportada manualmente (peso total de todas las cargas) es menor de 15 kg en 1 minuto?
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b2" id="b2_no" value="NO" required>
<label class="form-check-label" for="b2_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b2" id="b2_si" value="SI" required>
<label class="form-check-label" for="b2_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">c.</td>
<td class="texto-pregunta">¿El transporte de la carga se realiza sin posturas forzadas?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c2" id="c2_no" value="NO" required>
<label class="form-check-label" for="c2_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c2" id="c2_si" value="SI" required>
<label class="form-check-label" for="c2_si">SI</label>
</div>
</td>
</tr>

</table>

<div class="p-3">
Si a las preguntas “a” o “b”, y a la pregunta “c” ha contestado “SI” entonces la tarea tiene un riesgo aceptable y está en la Zona Verde.
<br><br>
Si alguna de las respuestas es “NO”, compruebe si se trata de una tarea con un nivel de riesgo inaceptable según la ficha 1.5.
</div>

</div>
</div>
`;

            $('#ficha_1_2').html(html);
            
            $('input[name="a2"], input[name="b2"], input[name="c2"]')
                
.change(evaluarFicha_1_2);
}

    },
    
"1.3": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-azul text-center">
<b>FICHA 1.3.- Aspectos adicionales a considerar</b><br>
A cada una de las preguntas de cada apartado marque una "X" en la columna SI o NO
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Condiciones ambientales de trabajo para el levantamiento o transporte manual</b></td>
<td width="80"><b></b></td>
<td width="80"><b></b></td>
</tr>

${fila13("f1","¿Hay presencia de baja o altas temperaturas?")}
${fila13("f2","¿Hay presencia de suelo resbaladizo, desigual o inestable?")}
${fila13("f3","¿Está restringida la libre circulación en el puesto de trabajo?")}

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Características de los objetos levantados o transportados</b></td>
<td><b></b></td>
<td><b></b></td>
</tr>

${fila13("f4","¿El tamaño del objeto obstaculiza la visibilidad y el movimiento?")}
${fila13("f5","¿El centro de gravedad de la carga es inestable? P.ej. líquidos o cosas que se mueven dentro del objeto.")}
${fila13("f6","¿La forma de la carga y su configuración presenta bordes afilados, superficies sobresalientes o protuberancias?")}
${fila13("f7","¿El contacto con la superficie es frío?")}
${fila13("f8","¿El contacto con la superficie es caliente?")}
${fila13("f9","¿La tarea de levantamiento o transporte manual de cargas se realiza por más de 8 horas al día?")}

</table>

<div id="resultadoFicha13" class="p-3"></div>

</div>
</div>
`;

            $('#ficha_1_3').html(html);


$('input[name^="f"]').change(evaluarFicha_1_3);

},

    },


    "1.4": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-rojo text-center">
<b>FICHA 1.4. Evaluación Rápida para identificar la presencia de condiciones inaceptables (Zona roja) por LEVANTAMIENTO DE CARGAS</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

${fila14("r1","a.","¿La distancia vertical es superior a 175 cm o está por debajo del nivel del suelo?")}
${fila14("r2","b.","¿El desplazamiento vertical es superior a 175 cm?")}
${fila14("r3","c.","¿La distancia horizontal es superior a 63 cm fuera del alcance máximo (brazo completamente estirado hacia delante)?")}
${fila14("r4","d.","¿El ángulo de asimetría es superior a 135°?")}
${fila14("r5","e.","¿Se realizan más de 15 levantamientos/min en duración corta? (La tarea  de manipulación manual no dura más de 60 min consecutivos y viene seguida de tareas ligeras para la espalda de duración miníma de 60 min)")}
${fila14("r6","f.","¿Se realizan más de 12 levantamientos/min en duración media? (La tarea de manipulación manual no dura más de 120 min consecutivos  y viene seguida de tareas ligeras para la espalda de duración miníma de 30 min )")}
${fila14("r7","g.","¿Se realizan más de 8 levantamientos/min en duración larga? (La tarea de manipulación manual que no es de duración corta ni media )")}
${fila14("r8","h.","¿La tarea se puede realizar por mujeres (entre 18 y 45 años) y la carga pesa más de 20 kg?")}
${fila14("r9","i.","¿La tarea se puede realizar por mujeres (menores de 18 y mayores de 45 años) y  la carga pesa más de 15 kg?")}
${fila14("r10","j.","¿La tarea  la realizan únicamente hombres (entre 18 y 45 años) y la carga pesa más de 25 kg?")}
${fila14("r11","k.","¿La tarea la realizan únicamente hombre (menores de 18 y mayores de 45 años) y la carga pesa más de 20 kg?")}

</table>

<div id="resultadoFicha14" class="p-3"></div>

</div>
</div>
`;

            $('#ficha_1_4').html(html);

$('input[name^="r"]').change(evaluarFicha_1_4);

}

    },

    "1.5": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-rojo text-center">
<b>FICHA 1.5. Evaluación Rápida para identificar la presencia de condiciones inaceptables (Zona roja) por TRANSPORTE DE CARGAS</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

${fila15("t1","a.","¿Se manipula una masa acumulada (peso total de todas las cargas) de más de 10.000 kg en 8 horas, en una distancia menor a 20 metros?")}

${fila15("t2","b.","¿Se manipula una masa acumulada (peso total de todas las cargas) de más de 6.000 kg en 8 horas, en una distancia igual o superior a 20 metros?")}

</table>

<div id="resultadoFicha15" class="p-3"></div>

</div>
</div>
`;

            $('#ficha_1_5').html(html);

$('input[name^="t"]').change(evaluarFicha_1_5);

}

    },
    
  
    "2.1": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde">
<b>FICHA 2.1.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por EMPUJE Y TRACCIÓN DE CARGAS.</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr>
<td width="40" class="texto-pregunta">a.</td>
<td class="texto-pregunta">
¿La fuerza requerida en el empuje o tracción es inferior a “Moderada” (en la Escala de Borg menor a 3)?<br>
<br>O<br><br>
¿La fuerza requerida en el empuje o tracción no supera los 30 N en fuerza continua (sostenida) y no supera los 100 N en los picos de fuerza?<br>
<br>O<br><br>
¿La fuerza requerida en el empuje o tracción no supera los 50 N cuando la frecuencia es menor 1 acción cada 5 minutos en una distancia de recorrido inferior a 50 m?
</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a21" id="a21_no" value="NO" required>
<label class="form-check-label" for="a21_no">NO</label>
</div>
</td>

<td width="100">
<div class="form-check">
<input class="form-check-input" type="radio" name="a21" id="a21_si" value="SI" required>
<label class="form-check-label" for="a21_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">b.</td>
<td class="texto-pregunta">¿La fuerza de empuje o tracción se aplica a una altura de agarre entre la cadera y la mitad del pecho?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b21" id="b21_no" value="NO" required>
<label class="form-check-label" for="b21_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="b21" id="b21_si" value="SI" required>
<label class="form-check-label" for="b21_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">c.</td>
<td class="texto-pregunta">¿La acción de empuje o tracción se realiza con el tronco erguido (sin torsión ni flexión)?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c21" id="c21_no" value="NO" required>
<label class="form-check-label" for="c21_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="c21" id="c21_si" value="SI" required>
<label class="form-check-label" for="c21_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">d.</td>
<td class="texto-pregunta">¿La tarea de empuje o tracción se realiza durante menos de 8 horas al día?</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="d21" id="d21_no" value="NO" required>
<label class="form-check-label" for="d21_no">NO</label>
</div>
</td>

<td>
<div class="form-check">
<input class="form-check-input" type="radio" name="d21" id="d21_si" value="SI" required>
<label class="form-check-label" for="d21_si">SI</label>
</div>
</td>
</tr>

</table>

<div class="p-3">
Si a todas las preguntas ha contestado “SI” entonces la tarea tiene un riesgo aceptable y está en la Zona Verde.
Si alguna de las respuestas es “NO”, compruebe si se trata de una tarea con un nivel de riesgo inaceptable según la ficha 2.3.
</div>

</div>
</div>
`;

$('#ficha_2_1').html(html);

$('input[name="a21"], input[name="b21"], input[name="c21"], input[name="d21"]')
.change(evaluarFicha_2_1);

}

    },
    
"2.2": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-azul text-center">
<b>FICHA 2.2.- Aspectos adicionales a considerar</b><br>
A cada una de las preguntas de cada apartado marque una "X" en la columna SI o NO
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Condiciones ambientales de trabajo</b></td>
<td width="80"></td>
<td width="80"></td>
</tr>

${fila22("f22_1","¿Las superficies de los suelos son resbaladizas, inestables, irregulares, con pendientes, o presentan fisuras, grietas o están rotas?")}
${fila22("f22_2","¿Hay restricciones o limitaciones para desplazarse?")}
${fila22("f22_3","¿Hay rampas o cuestas con mucha pendiente?")}
${fila22("f22_4","¿La temperatura ambiental no es adecuada (por frío o calor)?")}
${fila22("f22_5","¿Los espacios son confinados, insuficientes para girar, puertas estrechas, etc.?")}

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Características de los objetos a empujar / tirar</b></td>
<td></td>
<td></td>
</tr>

${fila22("f22_6","¿El objeto limita la visibilidad del trabajador u obstaculiza el movimiento?")}
${fila22("f22_7","¿El objeto carece de asas?")}
${fila22("f22_8","¿El objeto es inestable?")}
${fila22("f22_9","¿El objeto tiene características peligrosas, superficies afiladas, elementos sobresalientes, etc., que puedan dañar al trabajador?")}
${fila22("f22_10","¿Las ruedas están desgastadas, rotas o sin mantenimiento?")}
${fila22("f22_11","¿Las ruedas son inadecuadas para las condiciones de trabajo?")}

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Características de la tarea</b></td>
<td></td>
<td></td>
</tr>

${fila22("f22_12","¿La tarea de empuje o tracción se realiza por más de 8 horas al día?")}
${fila22("f22_13","¿Se deben hacer movimientos acelerados para iniciar, frenar o mover la carga?")}
${fila22("f22_14","¿La tarea requiere el uso de las manos por detrás del cuerpo para transportar la carga?")}

</table>

<div id="resultadoFicha22" class="p-3"></div>

</div>
</div>
`;

$('#ficha_2_2').html(html);

$('input[name^="f22_"]').change(evaluarFicha_2_2);

}

    },

    "2.3": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-rojo text-center">
<b>FICHA 2.3. Evaluación Rápida para identificar la presencia de condiciones inaceptables (Zona roja) por EMPUJE Y TRACCIÓN DE CARGAS</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

${fila23("r23_1","a.","¿La fuerza requerida en el empuje o tracción es “Muy intensa” o superior (Escala de Borg mayor o igual a 8)? <br>  O <br>  ¿la fuerza requerida  en el empuje  o tracción para iniciar el movimiento es 360 N o más para hombres, o de 240 N más para mujeres? <br> O  <br> ¿la fuerza requerida para  el empuje o tracción para mantener el movimiento es de 250 N o más para hombres o de 150 N o más mujeres?")}

${fila23("r23_2","b.","¿La fuerza de empuje o tracción se aplica a una altura de agarre superior a 150 cm o menor a 60 cm?")}

${fila23("r23_3","c.","¿La acción de empuje o tracción se realiza con el tronco flexionado o en torsión?")}

${fila23("r23_4","d.","¿Se realiza la tarea de empuje o tracción durante más de 8 horas al día?")}

</table>

<div id="resultadoFicha23" class="p-3"></div>

</div>
</div>
`;

$('#ficha_2_3').html(html);

$('input[name^="r23_"]').change(evaluarFicha_2_3);

}

    },
    

    "3.1": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde text-center">
<b>FICHA 3.1.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por MOVIMIENTOS REPETITIVOS DE LA EXTREMIDAD SUPERIOR.</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr>
<td width="40" class="texto-pregunta">a.</td>
<td class="texto-pregunta">
¿Las extremidades superiores están inactivas por más del 50% del tiempo total del trabajo repetitivo (se considera como tiempo de inactividad de la extremidad superior cuando el trabajador camina con las manos vacías, o lee, o hace control visual, o espera que la máquina concluya el trabajo, etc.)?
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m1" id="m1_no" value="NO" required>
<label class="form-check-label" for="m1_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m1" id="m1_si" value="SI" required>
<label class="form-check-label" for="m1_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">b.</td>
<td class="texto-pregunta">¿Ninguno de los brazos trabaja con el codo casi a la altura del hombro por más del 10% del tiempo de trabajo repetitivo?</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m2" id="m2_no" value="NO" required>
<label class="form-check-label" for="m2_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m2" id="m2_si" value="SI" required>
<label class="form-check-label" for="m2_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">c.</td>
<td class="texto-pregunta">
¿La fuerza necesaria para realizar el trabajo es menor a moderada (es ligera)?<br><br>
O bien,<br><br>
¿Si la fuerza es moderada, no supera el 25% del tiempo de trabajo repetitivo?
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m3" id="m3_no" value="NO" required>
<label class="form-check-label" for="m3_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m3" id="m3_si" value="SI" required>
<label class="form-check-label" for="m3_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">d.</td>
<td class="texto-pregunta">¿Están ausentes los picos de fuerza (más que Moderada en la Escala Borg)?</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m4" id="m4_no" value="NO" required>
<label class="form-check-label" for="m4_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m4" id="m4_si" value="SI" required>
<label class="form-check-label" for="m4_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">e.</td>
<td class="texto-pregunta">¿Hay pausas de duración al menos 8 min cada 2 horas?</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m5" id="m5_no" value="NO" required>
<label class="form-check-label" for="m5_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m5" id="m5_si" value="SI" required>
<label class="form-check-label" for="m5_si">SI</label>
</div>
</td>
</tr>

<tr>
<td class="texto-pregunta">f.</td>
<td class="texto-pregunta">¿La (s) tarea (s) de trabajo repetitivo se realiza durante menos de 8 horas al día?</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m6" id="m6_no" value="NO" required>
<label class="form-check-label" for="m6_no">NO</label>
</div>
</td>

<td class="text-center">
<div class="form-check">
<input class="form-check-input" type="radio" name="m6" id="m6_si" value="SI" required>
<label class="form-check-label" for="m6_si">SI</label>
</div>
</td>
</tr>

</table>

<div class="p-3">
Si a todas las preguntas ha contestado “SI” entonces la tarea tiene un riesgo aceptable y está en la Zona Verde.
Si alguna de las respuestas es “NO”, compruebe si se trata de una tarea con un nivel de riesgo inaceptable según la ficha 3.2.
</div>

</div>
</div>
`;

$('#ficha_3_1').html(html);

$('input[name="m1"], input[name="m2"], input[name="m3"], input[name="m4"], input[name="m5"], input[name="m6"]')
.change(evaluarFicha_3_1);

}

},

    "3.2": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-rojo text-center">
<b>FICHA 3.2. Evaluación Rápida para identificar la presencia de condiciones inaceptables (Zona roja) por MOVIMIENTOS REPETITIVOS DE LA EXTREMIDAD SUPERIOR</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

${fila32("r32_1","a.","¿Las acciones técnicas de una extremidad son tan rápidas que no es posible contarlas?")}

${fila32("r32_2","b.","¿Un brazo o ambos trabajan con el codo casi a la altura del hombro por la mitad o más del tiempo de trabajo repetitivo?")}

${fila32("r32_3","c.","¿Se realizan picos de fuerza (Fuerza intensa o más en la de escala Borg) durante el 5% o más del tiempo de trabajo repetitivo?")}

${fila32("r32_4","d.","¿Se requiere el agarre de objetos con los dedos (agarre de precisión) durante más del 80% del tiempo de trabajo repetitivo ?")}

${fila32("r32_5","e.","En turnos de 6 horas o más, ¿sólo tiene una pausa o ninguna?")}

${fila32("r32_6","f.","¿El tiempo de trabajo repetitivo es superior a 8 horas en el turno?")}

</table>

<div id="resultadoFicha32" class="p-3"></div>

</div>
</div>
`;

$('#ficha_3_2').html(html);

$('input[name^="r32_"]').change(evaluarFicha_3_2);

}

    },
    
    "4.1": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde text-center">
<b>FICHA 4.1.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por POSTURAS ESTÁTICAS FORZADAS</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Cabeza y tronco</b></td>
<td width="80"></td>
<td width="80"></td>
</tr>

${fila41("p1","a.","¿El tronco está erguido, o si está flexionado o en extensión el ángulo no supera los 20°?")}
${fila41("p2","b.","¿El cuello está recto, o si está flexionado o en extensión el ángulo no supera los 25°?")}
${fila41("p3","c.","¿La cabeza está recta, o si está inclinada lateralmente el ángulo no supera los 25°?")}

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Extremidad Superior</b></td>
<td></td>
<td></td>
</tr>

${fila41("p4","d.","¿El brazo está sin apoyo y la flexión no supera el ángulo de 20°?")}
${fila41("p5","e.","¿El brazo está con apoyo y la flexión no supera el ángulo de 60°?")}
${fila41("p6","f.","¿El codo realiza flexo-extensiones o prono-supinacinaciones no extremas (pequeñas)?")}
${fila41("p7","g.","¿La muñeca está en posición neutra o no realiza desviaciones extremas (flexión,extensión,desviación radial o ulnar)?")}

<tr class="bg-light text-center">
<td colspan="2" class="texto-pregunta"><b>Extremidad Inferior</b></td>
<td></td>
<td></td>
</tr>

${fila41("p8","h.","¿Las flexiones extremas de rodilla están ausentes?")}
${fila41("p9","i.","¿Las dorsiflexiones y flexiones plantares de tobillo extremas están ausentes?")}
${fila41("p10","j.","¿Las posturas de rodillas y cuclillas están ausentes?")}
${fila41("p11","k.","Si la postura es sentado, ¿el ángulo de rodilla está entre 90° y 135°?")}

</table>

<div id="resultadoFicha41" class="p-3"></div>

</div>
</div>
`;

$('#ficha_4_1').html(html);

$('input[name^="p"]').change(evaluarFicha_4_1);

}

    },
    "4.2": {

render: function () {

let html = `
<div class="card mt-3">

<div class="card-header header-verde text-center">
<b>FICHA 4.2.- Evaluación Rápida para Identificar la presencia de condiciones aceptables (Zona verde) por POSTURAS DINÁMICAS FORZADAS</b>
<br>
NOTA: Señale con una "X", cuando la condición verificada está presente (columna "SI") y cuando no está presente (columna "NO")
</div>

<div class="card-body p-0">

<table class="table table-bordered mb-0">

${fila42("d1","a.","¿El tronco está erguido, o realiza flexiones o extensiones sin superar el ángulo de 20°?")}
${fila42("d2","b.","¿El tronco está erguido, o realiza inclinaciones laterales o torsión sin superar el ángulo de 10°?")}
${fila42("d3","c.","¿La cabeza está recta, o realiza inclinaciones laterales sin superar el ángulo de 10°?")}
${fila42("d4","d.","¿La cabeza está recta, o realiza torsión del cuello sin superar el ángulo de 45°?")}
${fila42("d5","e.","¿El cuello está recto o realiza flexiones entre 0° y 40°?")}
${fila42("d6","f.","¿Los brazos están neutros, o realizan flexión o abducción sin superar el ángulo de 20°?")}

</table>

<div id="resultadoFicha42" class="p-3"></div>

</div>
</div>
`;

$('#ficha_4_2').html(html);

$('input[name^="d"]').change(evaluarFicha_4_2);

}

},

};

///////  EVALUACION FICHAS 
function evaluarFicha_1_1() {

	let a = $('input[name="a"]:checked').val();
	let b = $('input[name="b"]:checked').val();
	let c = $('input[name="c"]:checked').val();
	let d = $('input[name="d"]:checked').val();
	let e = $('input[name="e"]:checked').val();

	if (!a || !b || !c || !d || !e) return;

	let ok = (a==="SI" && b==="SI" && c==="SI" && d==="SI" && e==="SI");

	if (!ok) {
		$('#ficha_1_4').html("");
		fichas["1.4"].render();  
	} else {
		$('#ficha_1_4').html("");
	}

}

function evaluarFicha_1_2() {

    let a = $('input[name="a2"]:checked').val();
    let b = $('input[name="b2"]:checked').val();
    let c = $('input[name="c2"]:checked').val();

    if (!a || !b || !c) return;

    let ok = (a === "SI" && b === "SI" && c === "SI");

    if (!ok) {
        $('#ficha_1_5').html("");
        fichas["1.5"].render();
    } else {
        $('#ficha_1_5').html("");
    }

}

function evaluarFicha_1_3() {

	let respuestas = [];

	for (let i = 1; i <= 9; i++) {
		let val = $(`input[name="f${i}"]:checked`).val();
		if (!val) return;
		respuestas.push(val);
	}

	let todasNO = respuestas.every(r => r === "NO");

	if (todasNO) {
		$('#resultadoFicha13').html(`
			<div class="alert alert-success">
			Si a todas las preguntas ha contestado “NO”, no hay presencia de factores adicionales al riesgo.
			</div>
		`);
	} else {
		$('#resultadoFicha13').html(`
			<div class="alert alert-warning">
			Si una o más respuestas son “SI”, los factores de riesgo adicionales deben ser considerados.
			</div>
		`);
	}

}

function evaluarFicha_1_4() {

	let respuestas = [];

	for (let i = 1; i <= 11; i++) {
		let val = $(`input[name="r${i}"]:checked`).val();
		if (!val) return;
		respuestas.push(val);
	}

	let algunaSI = respuestas.some(r => r === "SI");
	let todasNO = respuestas.every(r => r === "NO");

	if (algunaSI) {

		$('#resultadoFicha14').html(`
			<div class="alert alert-danger">
			Si alguna de las respuestas es “SI”, la tarea probablemente está en la <b>Zona Roja</b> y tiene un nivel de riesgo inaceptable.<br>
			Se recomienda realizar la evaluación específica del riesgo.
			</div>
		`);

	} else if (todasNO) {

		$('#resultadoFicha14').html(`
			<div class="alert alert-info">
			Si todas las respuestas son “NO”, no es posible discriminar el nivel de riesgo de forma rápida y se requiere evaluación específica.
			</div>
		`);

	}

}

function evaluarFicha_1_5() {

	let a = $('input[name="t1"]:checked').val();
	let b = $('input[name="t2"]:checked').val();

	if (!a || !b) return;

	let algunaSI = (a === "SI" || b === "SI");
	let todasNO = (a === "NO" && b === "NO");

	if (algunaSI) {

		$('#resultadoFicha15').html(`
			<div class="alert alert-danger">
			Si alguna de las respuestas es “SI”, la tarea probablemente está en la <b>Zona Roja</b> y tiene un nivel de riesgo inaceptable.<br>
			Se recomienda realizar la evaluación específica del riesgo de la tarea por manipulación manual de cargas para definir la intervención.
			</div>
		`);

	} else if (todasNO) {

		$('#resultadoFicha15').html(`
			<div class="alert alert-info">
			Si todas las respuestas son “NO”, no es posible discriminar el nivel de riesgo de forma rápida y por tanto, es necesario realizar la evaluación específica.
			</div>
		`);

	}

}

function evaluarFicha_2_1() {

	let a = $('input[name="a21"]:checked').val();
	let b = $('input[name="b21"]:checked').val();
	let c = $('input[name="c21"]:checked').val();
	let d = $('input[name="d21"]:checked').val();

	if (!a || !b || !c || !d) return;

	let ok = (a==="SI" && b==="SI" && c==="SI" && d==="SI");

	if (!ok) {
		$('#ficha_2_3').html(""); 
		fichas["2.3"].render();  
	} else {
		$('#ficha_2_3').html(""); 
	}

}

function evaluarFicha_2_2() {

	let total = $('input[name^="f22_"]:checked').length;

	if (total < 14) return;

	let haySI = false;

	$('input[name^="f22_"]:checked').each(function () {
		if ($(this).val() === "SI") {
			haySI = true;
		}
	});

	if (haySI) {
		$('#resultadoFicha22').html(`
			<div class="alert alert-warning">
			Si una o más respuestas son <b>“SI”</b>, los riesgos específicos adicionales deben ser cuidadosamente considerados para garantizar la ausencia del riesgo.
			</div>
		`);
	} else {
		$('#resultadoFicha22').html(`
			<div class="alert alert-success">
			Si a todas las preguntas ha contestado <b>“NO”</b>, no hay presencia de factores adicionales al riesgo por empuje y tracción.
			</div>
		`);
	}

}

function evaluarFicha_2_3() {

	let total = $('input[name^="r23_"]:checked').length;

	if (total < 4) return;

	let haySI = false;

	$('input[name^="r23_"]:checked').each(function () {
		if ($(this).val() === "SI") {
			haySI = true;
		}
	});

	if (haySI) {
		$('#resultadoFicha23').html(`
			<div class="alert alert-danger">
			Si alguna de las respuestas es <b>“SI”</b>, la tarea probablemente está en la <b>Zona Roja</b> y tiene un nivel de riesgo inaceptable. Se recomienda realizar la evaluación específica del riesgo.
			</div>
		`);
	} else {
		$('#resultadoFicha23').html(`
			<div class="alert alert-secondary">
			Si todas las respuestas son <b>“NO”</b>, no es posible discriminar el nivel de riesgo de forma rápida y es necesario realizar la evaluación específica.
			</div>
		`);
	}

}

function evaluarFicha_3_1() {

	let m1 = $('input[name="m1"]:checked').val();
	let m2 = $('input[name="m2"]:checked').val();
	let m3 = $('input[name="m3"]:checked').val();
	let m4 = $('input[name="m4"]:checked').val();
	let m5 = $('input[name="m5"]:checked').val();
	let m6 = $('input[name="m6"]:checked').val();

	if (!m1 || !m2 || !m3 || !m4 || !m5 || !m6) return;

	let ok = (
		m1 === "SI" &&
		m2 === "SI" &&
		m3 === "SI" &&
		m4 === "SI" &&
		m5 === "SI" &&
		m6 === "SI"
	);

	if (!ok) {
		$('#ficha_3_2').html("");
		fichas["3.2"].render();
	} else {
		$('#ficha_3_2').html("");
	}

}

function evaluarFicha_3_2() {

	let total = $('input[name^="r32_"]:checked').length;

	if (total < 6) return;

	let haySI = false;

	$('input[name^="r32_"]:checked').each(function () {
		if ($(this).val() === "SI") {
			haySI = true;
		}
	});

	if (haySI) {
		$('#resultadoFicha32').html(`
			<div class="alert alert-danger">
			Si alguna de las respuestas es <b>“SI”</b>, la tarea probablemente está en la <b>Zona Roja</b> y tiene un nivel de riesgo inaceptable.
			</div>
		`);
	} else {
		$('#resultadoFicha32').html(`
			<div class="alert alert-warning">
			Si todas las respuestas son <b>“NO”</b>, no es posible discriminar el riesgo rápidamente y se requiere evaluación específica.
			</div>
		`);
	}

}

function evaluarFicha_4_1() {

	let total = $('input[name^="p"]:checked').length;

	if (total < 11) return;

	let todasSI = true;

	$('input[name^="p"]:checked').each(function () {
		if ($(this).val() !== "SI") {
			todasSI = false;
		}
	});

	if (todasSI) {
		$('#resultadoFicha41').html(`
			<div class="alert alert-success">
			Si a todas las preguntas ha contestado <b>“SI”</b>, la tarea tiene un riesgo aceptable y está en la <b>Zona Verde</b>.
			</div>
		`);
	} else {
		$('#resultadoFicha41').html(`
			<div class="alert alert-warning">
			Si una o más respuestas son <b>“NO”</b>, se recomienda realizar la evaluación específica del riesgo por postura estática.
			</div>
		`);
	}

}

function evaluarFicha_4_2() {

	let total = $('input[name^="d"]:checked').length;

	if (total < 6) return;

	let todasSI = true;

	$('input[name^="d"]:checked').each(function () {
		if ($(this).val() !== "SI") {
			todasSI = false;
		}
	});

	if (todasSI) {
		$('#resultadoFicha42').html(`
			<div class="alert alert-success">
			Si a todas las preguntas ha contestado <b>“SI”</b>, la tarea tiene un riesgo aceptable y está en la <b>Zona Verde</b>.
			</div>
		`);
	} else {
		$('#resultadoFicha42').html(`
			<div class="alert alert-warning">
			Si una o más respuestas son <b>“NO”</b>, se recomienda realizar la evaluación específica del riesgo por postura dinámica.
			</div>
		`);
	}

}

///// FILAS ///// 
function fila13(name, texto) {
    return `
    <tr>
        <td colspan="2" class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila14(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta" >${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila15(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta">${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila22(name, texto) {
    return `
    <tr>
        <td colspan="2" class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila23(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta">${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila32(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta">${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila41(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta">${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

function fila42(name, letra, texto) {
    return `
    <tr>
        <td width="40" class="texto-pregunta">${letra}</td>
        <td class="texto-pregunta">${texto}</td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_no" value="NO" required>
                <label class="form-check-label" for="${name}_no">NO</label>
            </div>
        </td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="${name}" id="${name}_si" value="SI" required>
                <label class="form-check-label" for="${name}_si">SI</label>
            </div>
        </td>
    </tr>
    `;
}

$(document).ready(function(){

    $('[name="P1_CARGA_MAYOR_3KG"]').on('change', function(){

        let p1 = $(this).val();

        if (p1 === "SI") {

            $('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION').attr('style', 'display:block !important;');


        } else if (p1 === "NO") {

            $('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION').attr('style', 'display:none !important;');

            $('[name="P2_FRECUENCIA_CARGA"]').val("NO");
			$('[name="P3_MANIPULACION_CARGA"]').val("NO");
			
		} else {
			
  			$('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION').attr('style', 'display:block !important;');
 			$('[name="P2_FRECUENCIA_CARGA"]').val("");
			$('[name="P3_MANIPULACION_CARGA"]').val("");
		}

    });

});

function generarJSONActividades() {

    let data = [];

    $('#contenedorActividades .actividad-item').each(function () {

        let actividad = {
            nombre: $(this).find('.actividad-nombre').val(),
            tareas: []
        };

        $(this).find('.tarea-item').each(function () {

            actividad.tareas.push({
                nombre: $(this).find('.tarea-nombre').val(),
                frecuencia: $(this).find('.tarea-frecuencia').val(),
                numero_veces: $(this).find('.tarea-numero-veces').val(),
                duracion: $(this).find('.tarea-duracion').val()
            });

        });

        data.push(actividad);
    });

    return JSON.stringify(data);
}

function generarJSONFichas() {

    let resultado = [];

    $('[id^="ficha_"]').each(function () {

        let id = $(this).attr('id'); 
        let ficha = id.replace('ficha_', '').replace('_', '.'); 

        let preguntas = [];

        $(this).find('tr').each(function () {

            let texto = $(this).find('.texto-pregunta').text().trim();
            let radio = $(this).find('input[type="radio"]:checked');

            if (radio.length > 0) {

                preguntas.push({
                    name: radio.attr('name'),
                    texto: texto,
                    respuesta: radio.val()
                });
            }

        });

        if (preguntas.length > 0) {

            resultado.push({
                ficha: ficha,
                preguntas: preguntas,
                resultado: calcularResultadoFicha(ficha, preguntas)
            });
        }

    });

    return JSON.stringify(resultado);
}

function calcularResultadoFicha(ficha, preguntas) {

    let respuestas = preguntas.map(p => p.respuesta);

    if (respuestas.includes("NO")) return "ROJO";

    return "VERDE";
}

function mostrarTablafichasevaluacionfre() {
	try {
		var ruta = "/Tablafichasevaluacionfre";

		if (Tablafichasevaluacionfre != null) {
			Tablafichasevaluacionfre.destroy();
		}

		Tablafichasevaluacionfre = $('#Tablafichasevaluacionfre').DataTable({
			"ajax": {
				"url": ruta,
				"type": "get",
				"cache": false,
				"data": {
					ergoid: recsensorial 
				},
				"error": function (xhr, error, code) {
					console.log('error en Tablafichasevaluacionfre');
				}
			},
			"columns": [
				{
					data: null,
					render: function (data, type, row, meta) {
						return meta.row + 1;
					}
                },
                {
					"data": "PE_EVALUADAS",
					"defaultContent": "-"
                },
                 {
                    "data": "NOMBRE_AREA",
                    "defaultContent": "-"
                },
				{
					"data": "NOMBRE_CATEGORIA",
					"defaultContent": "-"
				},
				{
					"data": "NOMBRE_EMPLEADO_FICHA",
					"defaultContent": "-"
				},
				{
					"data": "NO_EMPLEADO_FICHA",
					"defaultContent": "-"
				},
				{ 
					data: 'BTN_EDITAR',
					orderable: false,
					searchable: false
                },
               
                { 
					data: 'BTN_FICHA',
					orderable: false,
					searchable: false
                },
                 { 
					data: 'ESTATUS_FRE',
					orderable: false,
					searchable: false
				},
			],
			"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
			"order": [[0, "ASC"]],
			"ordering": false,
			"processing": true,
			"responsive": true,
			"language": {
				"lengthMenu": "Mostrar _MENU_ Registros",
				"zeroRecords": "No se encontraron registros",
				"info": "Página _PAGE_ de _PAGES_ (Total _MAX_ registros)",
				"infoEmpty": "No se encontraron registros",
				"infoFiltered": "(Filtrado de _MAX_ registros)",
				"emptyTable": "No hay datos disponibles en la tabla",
				"loadingRecords": "Cargando datos....",
				"processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
				"search": "Buscar",
				"paginate": {
					"first": "Primera",
					"last": "Última",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});

		Tablafichasevaluacionfre.on('draw', function () {
			$('[data-toggle="tooltip"]').tooltip();
		});

	} catch (exception) {
		console.error("Error en Tablafichasevaluacionfre:", exception);
	}
}

function pintarActividades(json) {

    let contenedor = $('#contenedorActividades');
    contenedor.empty();

    if (!json) return;

    let data;

    if (typeof json === "string") {
        try {
            data = JSON.parse(json);
        } catch (e) {
            data = [];
        }
    } else {
        data = json;
    }

    if (!Array.isArray(data)) return;

    data.forEach((actividad, index) => {

        let num = index + 1;

        let htmlActividad = `
        <div class="actividad-item" id="actividad_${num}">

            <div class="actividad-card">

                <div class="d-flex justify-content-between mb-2">
                    <strong>Actividad ${num}</strong>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>

                <div class="actividad-row">
                    <div class="actividad-left">
                        <label class="d-block"> Nombre de la actividad
                            <textarea class="form-control actividad-nombre mt-1" rows="3">${actividad.nombre || ''}</textarea>
                        </label>
                    </div>
                    <div class="actividad-right">
                        <button type="button" class="btn btn-agregar-tarea" onclick="agregarTarea(${num})"> + Agregar tarea</button>
                        <div id="tareas_${num}"></div>
                    </div>
                </div>

            </div>
        </div>
        `;

        contenedor.append(htmlActividad);

        if (Array.isArray(actividad.tareas)) {

            actividad.tareas.forEach((tarea, i) => {

                let numT = i + 1;

                let htmlTarea = `
                <div class="tarea-item">

                    <div class="d-flex justify-content-between">
                        <small>Tarea ${numT}</small>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTarea(this)"><i class="fa fa-trash"></i></button>
                    </div>

                    <div class="form-group mb-2">
                        <label class="d-block">Nombre de la tarea
                            <textarea class="form-control mt-1 tarea-nombre" rows="3">${tarea.nombre || ''}</textarea>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label class="d-block">Frecuencia
                                    <input type="text" class="form-control mt-1 tarea-frecuencia"value="${tarea.frecuencia || ''}">
                                </label>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label class="d-block">No de veces
                                    <input type="text" class="form-control mt-1 tarea-numero-veces" value="${tarea.numero_veces ?? ''}">
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mb-2">
                        <label class="d-block">
                            Duración (tiempo en Min)
                            <input type="text" class="form-control mt-1 tarea-duracion" value="${tarea.duracion || ''}">
                        </label>
                    </div>
                </div>
                `;

                $(`#tareas_${num}`).append(htmlTarea);

            });

        }

    });
}

$('#Tablafichasevaluacionfre tbody').on('click', 'td>button.editar', function () {

    var tr = $(this).closest('tr');
    var row = Tablafichasevaluacionfre.row(tr);

    let data = row.data();

    ID_FICHAS_TECNICAS = data.ID_FICHAS_TECNICAS;

    editarDatoTabla(data, 'form_fichas', 'modal_fichas',1);

    $('#modal_fichas .modal-title').html(data.NOMBRE_EMPLEADO_FICHA);

    let areasGuardadas = data.CAT_AREAS_FICHA;

    if (typeof areasGuardadas === "string") {
        try { areasGuardadas = JSON.parse(areasGuardadas); } 
        catch (e) { areasGuardadas = []; }
    }

    if (!Array.isArray(areasGuardadas)) {
        areasGuardadas = [];
    }


    if (!$('#TURNO_EMPLEADO_FICHA')[0].selectize) {
        $('#TURNO_EMPLEADO_FICHA').selectize({
            placeholder: 'Seleccione una o varias opciones',
            maxItems: null
        });
    }

    let selTurno = $('#TURNO_EMPLEADO_FICHA')[0].selectize;
    selTurno.clear();

    let valoresTurno = row.data().TURNO_EMPLEADO_FICHA;

    if (typeof valoresTurno === "string") {
        try { valoresTurno = JSON.parse(valoresTurno); } catch (e) { valoresTurno = []; }
    }

    if (Array.isArray(valoresTurno)) {
        selTurno.setValue(valoresTurno);
    }


    cargarCategoriasSelect(function () {

        $('#CATEGORIA_ID_FICHA')
            .val(data.CATEGORIA_ID_FICHA)
            .trigger('change');

        setTimeout(() => {
            cargarAreasFicha(areasGuardadas);
        }, 300);

    });

    $("#contenedorActividades").empty(); 
	pintarActividades(data.JSON_ACTIVIDADES);

	setTimeout(() => {

		limpiarTodasLasFichas();

	
		if (data.P1_CARGA_MAYOR_3KG !== "SI") {
			$('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION')
				.attr('style', 'display:none !important;');
		} else {
			$('#TEXTO_MANIPULACION, #LEVANTAMIENTO_CARGA, #TRANSPORTE_CARGAS, #EMPUJE_TRACCION')
				.attr('style', 'display:block !important;');
		}

		fichas["1.1"].render();
		fichas["1.3"].render();
		fichas["1.2"].render();
		fichas["2.1"].render();
		fichas["2.2"].render();
		fichas["3.1"].render();
		fichas["4.1"].render();
		fichas["4.2"].render();

		pintarFichasBase(data.JSON_FICHAS);

		activarLogicaFichas();

		setTimeout(() => {

		pintarFichasDependientes(data.JSON_FICHAS);

		abrirSeccionesSegunJSON(data.JSON_FICHAS);

		}, 200);

	}, 300);



     if (
        row.data().PE_EVALUADAS === null ||
        row.data().PE_EVALUADAS === '' ||
        typeof row.data().PE_EVALUADAS === 'undefined'
    ) {

        $.ajax({
            url: 'obtenerPEFichas',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                reco_id: recsensorial
            },
            success: function (resp) {
                $('#PE_EVALUADAS').val(resp.pe);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });

    }



});

function limpiarTodasLasFichas() {

    $('[id^="ficha_"]').each(function () {
        $(this).html('');
    });

    $('[id^="resultadoFicha"]').html('');
}

function abrirSeccionesSegunJSON(json) {

    let data = typeof json === "string" ? JSON.parse(json) : json;

    let abrir2 = false;
    let abrir3 = false;
    let abrir4 = false;
    let abrir5 = false;
    let abrir6 = false;
    let abrir7 = false;

    data.forEach(f => {

        let ficha = f.ficha;

        if (["1.1","1.3","1.4"].includes(ficha)) abrir2 = true;

        if (["1.2","1.5"].includes(ficha)) abrir3 = true;

        if (ficha.startsWith("2.")) abrir4 = true;

        if (ficha.startsWith("3.")) abrir5 = true;

        if (ficha === "4.1") abrir6 = true;

        if (ficha === "4.2") abrir7 = true;

    });

    if (abrir2) $('#contenido2').show();
    if (abrir3) $('#contenido3').show();
    if (abrir4) $('#contenido4').show();
    if (abrir5) $('#contenido5').show();
    if (abrir6) $('#contenido6').show();
    if (abrir7) $('#contenido7').show();
}

function pintarFichasBase(json) {

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(f => {

        if (["1.1","1.2","2.1","3.1","4.1"].includes(f.ficha)) {

            f.preguntas.forEach(p => {
                $(`input[name="${p.name}"][value="${p.respuesta}"]`).prop('checked', true);
            });

        }

    });
}

function pintarFichasDependientes(json) {

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(f => {

        if (!["1.1","1.2","2.1","3.1","4.1"].includes(f.ficha)) {

            f.preguntas.forEach(p => {
                $(`input[name="${p.name}"][value="${p.respuesta}"]`).prop('checked', true);
            });

        }

    });
}

function activarLogicaFichas() {

    evaluarFicha_1_1();
    evaluarFicha_1_2();
    evaluarFicha_1_3();
    evaluarFicha_1_4();
    evaluarFicha_1_5();

    evaluarFicha_2_1();
    evaluarFicha_2_2();
    evaluarFicha_2_3();

    evaluarFicha_3_1();
    evaluarFicha_3_2();

    evaluarFicha_4_1();
    evaluarFicha_4_2();
}



///////////// EVALUACION FRE   /////////////



let selectAreasFRE;

$(document).ready(function () {

    selectAreasFRE = $('#CAT_AREAS_FRE').selectize({
        placeholder: 'Seleccione una o varias opciones',
        maxItems: null,
    })[0].selectize;

});


$('#Tablafichasevaluacionfre tbody').on('click', 'td>button.iniciarfre', function() {
    var tr = $(this).closest('tr');
    var row = Tablafichasevaluacionfre.row(tr);

    $('#form_evalfre').each(function(){
        this.reset();
    });

    $("#ID_FICHAS_TECNICAS").val(row.data().ID_FICHAS_TECNICAS);
   


    
    $("#tab1_fre_info").click();

    

	let areasGuardadas = row.data().CAT_AREAS_FICHA;

    if (typeof areasGuardadas === "string") {
        try {
            areasGuardadas = JSON.parse(areasGuardadas);
        } catch (e) {
            areasGuardadas = [];
        }
    }

    if (!Array.isArray(areasGuardadas)) {
        areasGuardadas = [];
    }

    cargarCategoriasSelectFRE(function () {

        $('#CATEGORIA_ID_FRE')
            .val(row.data().CATEGORIA_ID_FICHA)
            .trigger('change');

        setTimeout(() => {

            cargarAreasFRE(areasGuardadas);

        }, 300);

    });
    

	fichas_id = row.data().ID_FICHAS_TECNICAS;
    $('#INSTALACION_FRE').val(instalacionreco);


	

	$.ajax({

		url: '/obtenerEvaluacionFre',
		type: 'POST',
		data: {
		FICHA_ID: fichas_id,
		_token: $('meta[name="csrf-token"]').attr('content')

	},

	success: function (fre) {


			if (fre && fre.ID_EVALUACION_FRE) {

				cargarEvaluacionFre(fre);

			} else {

				cargarDatosFicha(row.data());

			}

		}
	});
	
    $("#tab1_fre_info").off("click").on("click", function (e) {
        e.preventDefault();

        $("#tab1_fre_info").addClass("active");
        $("#tab2_imagenes_angulos").removeClass("active");

        $("#tab1_fre").show().addClass("active");
        $("#tab2_angulos").hide().removeClass("active");
    });

    $("#tab2_imagenes_angulos").off("click").on("click", function (e) {
        e.preventDefault();

        $("#tab2_imagenes_angulos").addClass("active");
        $("#tab1_fre_info").removeClass("active");

        $("#tab2_angulos").show().addClass("active");
        $("#tab1_fre").hide().removeClass("active");

        tabla_angulos_fre();
    });
    
    $('#modal_evalfre').modal({backdrop:false});
});


function cargarCategoriasSelectFRE(callback = null) {

    let reco_id = $("#recsensorial_id").val(); 

    $.ajax({
        url: '/getCategoriasErgo',
        type: 'GET',
        data: { reco_id: reco_id },
        success: function (response) {

            let select = $('#CATEGORIA_ID_FRE');
            select.empty();

            select.append('<option value="">Selecciona un tipo de valor</option>');

            response.data.forEach(function (item) {

                let areas = JSON.stringify(item.CATEGORIA_AREAS_ID || []);

                select.append(`
                    <option 
                        value="${item.ID_CATEGORIA_ERGO}"
                        data-departamento="${item.CAT_DEPARTAMENTO}"
                        data-areas='${areas}'
                    >
                        ${item.NOMBRE_CATEGORIA_ERGO}
                    </option>
                `);
            });
            if (callback) callback();
        }
    });
}

$(document).on('change', '#CATEGORIA_ID_FRE', function () {

    let selected = $(this).find(':selected');

    let departamento = selected.data('departamento');
    let areas = selected.data('areas');

    if (departamento) {
        $('#CAT_DEPARTAMENTO_FRE').val(departamento).trigger('change');
    } else {
        $('#CAT_DEPARTAMENTO_FRE').val('');
    }

    if (typeof areas === "string") {
        try { areas = JSON.parse(areas); } 
        catch (e) { areas = []; }
    }

    if (!Array.isArray(areas)) {
        areas = [];
    }

    cargarAreasFRE(areas);
});

function cargarAreasFRE(valoresSeleccionados = []) {

    let reco_id = $("#recsensorial_id").val();

    selectAreasFRE.clearOptions();
    selectAreasFRE.clear();

    $.ajax({
        url: '/obtenerareasergo',
        type: 'GET',
        data: { reco_id: reco_id },
        success: function (response) {

            response.data.forEach(function (item) {

                selectAreasFRE.addOption({
                    value: item.ID_AREA_ERGO,
                    text: item.NOMBRE_AREA_ERGO
                });

            });

            selectAreasFRE.setValue(valoresSeleccionados);

            selectAreasFRE.refreshOptions(false);

        },
        error: function () {
            console.log('Error cargando áreas');
        }
    });

}

$('input[name="EVALUACION_TRABAJADOR"]').change(function () {

	var valor = $(this).val();

	if (valor === '1') {


	} else if (valor === '0') {

		$("#NOMBRE_EMPLEADO_FRE").val('');
		$("#NO_EMPLEADO_FRE").val('');
		$("#SEXO_EMPLEADO_FRE").val('');
		$("#EDAD_EMPLEADO_FRE").val('');
		$("#PESO_FRE").val('');
		$("#TALLA_FRE").val('');
		$("#TIEMPO_EMPRESA_FRE").val('');
		$("#ANTIGUEDAD_CATEOGORIA_FRE").val('');


	}
});
//// TAREAS FRE

function agregarActividadFRE() {

    let contenedor = document.getElementById("contenedorActividadesfre");
    let total = contenedor.querySelectorAll('.actividad-item').length + 1;

    let html = `
    <div class="actividad-item" id="actividad_${total}">
        <div class="actividad-card">
            <div class="d-flex justify-content-between mb-2">
                <strong>Actividad ${total}</strong>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)"> <i class="fa fa-trash"></i></button>
            </div>
            <div class="actividad-row">
                <div class="actividad-left">
                    <label class="d-block">Nombre de la actividad
                        <textarea class="form-control actividad-nombre mt-1" rows="3" ></textarea>
                    </label>
                </div>
                <div class="actividad-right">
                    <button type="button" class="btn btn-agregar-tarea" onclick="agregarTarea(${total})"> + Agregar tarea</button>
                    <div id="tareas_${total}"></div>
                </div>
            </div>
        </div>
    </div>
    `;

    contenedor.insertAdjacentHTML('beforeend', html);
}

function eliminarActividadfre(btn) {

    btn.closest('.actividad-item').remove();

    reindexarActividadesfre();
}

function reindexarActividadesfre() {

    let actividades = document.querySelectorAll('#contenedorActividadesfre .actividad-item');

    actividades.forEach((el, index) => {

        let num = index + 1;

        el.id = `actividad_${num}`;

        el.querySelector('strong').innerText = `Actividad ${num}`;

        let input = el.querySelector('.actividad-left textarea');
        input.name = `actividades[${num}][nombre]`;

        let btnTarea = el.querySelector('.btn-agregar-tarea');
        btnTarea.setAttribute('onclick', `agregarTarea(${num})`);


        let tareasDiv = el.querySelector('[id^="tareas_"]');
        tareasDiv.id = `tareas_${num}`;


        reindexarTareasActividadfre(tareasDiv, num);
    });
}

function agregarTareafre(idActividad) {

    let contenedor = document.getElementById(`tareas_${idActividad}`);
    let total = contenedor.querySelectorAll('.tarea-item').length + 1;

    let html = `
    <div class="tarea-item">
        <div class="d-flex justify-content-between">
            <small>Tarea ${total}</small>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTarea(this)"><i class="fa fa-trash"></i></button>
        </div>

        <div class="form-group mb-2">
            <label class="d-block">Nombre de la tarea
                <textarea class="form-control mt-1 tarea-nombre" rows="3" ></textarea>
            </label>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group mb-2">
                    <label class="d-block"> Frecuencia
                        <input type="text" class="form-control mt-1 tarea-frecuencia">
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group mb-2">
                    <label class="d-block"> No de veces
                        <input type="text" class="form-control mt-1 tarea-numero-veces">
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group mb-2">
            <label class="d-block">
                Duración (tiempo en Min)
                <input type="text" class="form-control mt-1 tarea-duracion" >
            </label>
        </div>
    </div>
    `;

    contenedor.insertAdjacentHTML('beforeend', html);
}

function eliminarTareafre(btn) {

    let tareaItem = btn.closest('.tarea-item');
    let contenedor = tareaItem.parentElement;

    tareaItem.remove();

    let idActividad = contenedor.id.split('_')[1];

    reindexarTareasActividadfre(contenedor, idActividad);
}

function reindexarTareasActividadfre(contenedor, idActividad) {

    let tareas = contenedor.querySelectorAll('.tarea-item');

    tareas.forEach((el, index) => {

        let num = index + 1;


        let titulo = el.querySelector('small');
        if (titulo) titulo.innerText = `Tarea ${num}`;

        let inputs = el.querySelectorAll('textarea, input');

        inputs[0].name = `actividades[${idActividad}][tareas][${num}][nombre]`;
        inputs[1].name = `actividades[${idActividad}][tareas][${num}][frecuencia]`;
        inputs[2].name = `actividades[${idActividad}][tareas][${num}][numero_veces]`;
        inputs[3].name = `actividades[${idActividad}][tareas][${num}][duracion]`;
    });
}

function pintarActividadesfre(json, idHidden = 'JSON_ACTIVIDADES') {

    $('#' + idHidden).val(typeof json === 'string' ? json : JSON.stringify(json));

    let contenedor = $('#contenedorActividadesfre');
    contenedor.empty();

    if (!json) return;

    let data;

    if (typeof json === "string") {
        try {
            data = JSON.parse(json);
        } catch (e) {
            data = [];
        }
    } else {
        data = json;
    }

    if (!Array.isArray(data)) return;

    data.forEach((actividad, index) => {

        let num = index + 1;

        let htmlActividad = `
        <div class="actividad-item" id="actividad_${num}">

            <div class="actividad-card">

                <div class="d-flex justify-content-between mb-2">
                    <strong>Actividad ${num}</strong>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarActividad(this)"> <i class="fa fa-trash"></i></button>
                </div>
                <div class="actividad-row">
                    <div class="actividad-left">
                        <label class="d-block"> Nombre de la actividad
                            <textarea class="form-control actividad-nombre mt-1" rows="3" >${actividad.nombre || ''}</textarea>
                        </label>
                    </div>
                    <div class="actividad-right">
                        <button type="button" class="btn btn-agregar-tarea" onclick="agregarTarea(${num})"> + Agregar tarea</button>
                        <div id="tareas_${num}"></div>
                    </div>
                </div>
            </div>
        </div>
        `;

        contenedor.append(htmlActividad);

        if (Array.isArray(actividad.tareas)) {

            actividad.tareas.forEach((tarea, i) => {

                let numT = i + 1;

                let htmlTarea = `
                <div class="tarea-item">

                    <div class="d-flex justify-content-between">
                        <small>Tarea ${numT}</small>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarTarea(this)"><i class="fa fa-trash"></i></button>
                    </div>

                    <div class="form-group mb-2">
                        <label class="d-block"> Nombre de la tarea
                            <textarea class="form-control mt-1 tarea-nombre" rows="3" >${tarea.nombre || ''}</textarea>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label class="d-block"> Frecuencia
                                    <input type="text" class="form-control mt-1 tarea-frecuencia" value="${tarea.frecuencia || ''}">
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-2">
                                <label class="d-block">No de veces
                                    <input type="text" class="form-control mt-1 tarea-numero-veces"  placeholder="No de veces" value="${tarea.numero_veces ?? ''}">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="d-block"> Duración (tiempo en Min)
                            <input type="text" class="form-control mt-1 tarea-duracion"  value="${tarea.duracion || ''}">
                        </label>
                    </div>

                </div>
                `;

                $(`#tareas_${num}`).append(htmlTarea);

            });

        }

    });
}

/// FIN TAREAS

function cargarDatosFicha(data) {

    $("#contenedorActividadesfre").empty();

    pintarActividadesfre(data.JSON_ACTIVIDADES, 'JSON_ACTIVIDADES_FRE');

    $("#NOMBRE_EMPLEADO_FRE").val(data.NOMBRE_EMPLEADO_FICHA);
    $("#NO_EMPLEADO_FRE").val(data.NO_EMPLEADO_FICHA);
    $("#SEXO_EMPLEADO_FRE").val(data.SEXO_EMPLEADO_FICHA);
    $("#EDAD_EMPLEADO_FRE").val(data.EDAD_EMPLEADO_FICHA);
    $("#PESO_FRE").val(data.PESO_FICHA);
    $("#TALLA_FRE").val(data.TALLA_FICHA);
    $("#REGIMEN_CONTRACTUAL_FRE").val(data.REGIMEN_CONTRACTUAL_FICHA);
    $("#JORNADA_EMPLEADO_FRE").val(data.JORNADA_EMPLEADO_FICHA);
    $("#TIEMPO_EMPRESA_FRE").val(data.TIEMPO_EMPRESA_FICHA);
    $("#ANTIGUEDAD_CATEOGORIA_FRE").val(data.ANTIGUEDAD_CATEOGORIA_FICHA);



}

function cargarEvaluacionFre(data) {

    ID_EVALUACION_FRE = data.ID_EVALUACION_FRE;


    fre_id = data.ID_EVALUACION_FRE;

	$("#ID_EVALUACION_FRE").val(data.ID_EVALUACION_FRE);

    $("#FECHA_EVALUACION_FRE").val(data.FECHA_EVALUACION_FRE);
    $("#CAT_DEPARTAMENTO_FRE").val(data.CAT_DEPARTAMENTO_FRE);
    $("#EVALUACION_TRABAJADOR").val(data.EVALUACION_TRABAJADOR);

    $("#NOMBRE_EMPLEADO_FRE").val(data.NOMBRE_EMPLEADO_FRE);
    $("#NO_EMPLEADO_FRE").val(data.NO_EMPLEADO_FRE);
    $("#ULTIMO_GRADO_FRE").val(data.ULTIMO_GRADO_FRE);
    $("#INDIQUE_UBICACION_FRE").val(data.INDIQUE_UBICACION_FRE);

    $("#SEXO_EMPLEADO_FRE").val(data.SEXO_EMPLEADO_FRE);
    $("#EDAD_EMPLEADO_FRE").val(data.EDAD_EMPLEADO_FRE);

    $("#REGIMEN_CONTRACTUAL_FRE").val(data.REGIMEN_CONTRACTUAL_FRE);
    $("#JORNADA_EMPLEADO_FRE").val(data.JORNADA_EMPLEADO_FRE);
    $("#TIEMPO_EMPRESA_FRE").val(data.TIEMPO_EMPRESA_FRE);
    $("#ANTIGUEDAD_CATEOGORIA_FRE").val(data.ANTIGUEDAD_CATEOGORIA_FRE);

    $("#PAUSAS_DESCANSO").val(data.PAUSAS_DESCANSO);

    $("#PESO_FRE").val(data.PESO_FRE);
    $("#TALLA_FRE").val(data.TALLA_FRE);

    $("#ENFERMEDAD_MUSCULOESQUELETICA").val(data.ENFERMEDAD_MUSCULOESQUELETICA).trigger('change');
    $("#ENFERMEDAD_MUSCULOESQUELETICA_CUAL").val(data.ENFERMEDAD_MUSCULOESQUELETICA_CUAL);
    $("#ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO").val(data.ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO);
    $("#INCAPACITADO_DOLOR_MUSCULO").val(data.INCAPACITADO_DOLOR_MUSCULO);

    $("#FUENTE_ILUMINACION").val(data.FUENTE_ILUMINACION);
    $("#INTENSIDAD_ILUMINACION").val(data.INTENSIDAD_ILUMINACION);
    $("#OBSERVACION_ILUMINACION").val(data.OBSERVACION_ILUMINACION);

    $("#PERCEPCION_TERMICA").val(data.PERCEPCION_TERMICA).trigger('change');
    $("#INTENSIDAD_TERMICA").val(data.INTENSIDAD_TERMICA);
    $("#CUAL_PERCEPCION").val(data.CUAL_PERCEPCION);
    $("#OBSERVACIONES_TERMICAS").val(data.OBSERVACIONES_TERMICAS);

    $("#INTENSIDAD_RUIDO").val(data.INTENSIDAD_RUIDO);
    $("#CONTINUIDAD_RUIDO").val(data.CONTINUIDAD_RUIDO);
    $("#OBSERVACIONES_RUIDO").val(data.OBSERVACIONES_RUIDO);

    $("#INTENSIDAD_VIBRACION").val(data.INTENSIDAD_VIBRACION);
    $("#SEGMENTO_VIBRACION").val(data.SEGMENTO_VIBRACION);
    $("#OBSERVACIONES_VIBRACION").val(data.OBSERVACIONES_VIBRACION);

    $("#contenedorActividadesfre").empty();
	pintarActividadesfre(data.JSON_ACTIVIDADES_FRE, 'JSON_ACTIVIDADES_FRE');

    $("#SUFRIDO_LESION_ACCIDENTE").val(data.SUFRIDO_LESION_ACCIDENTE).trigger('change');
    $("#CUANDO_LESION_ACCIDENTE").val(data.CUANDO_LESION_ACCIDENTE);
    $("#CUAL_LESION_ACCIDENTE").val(data.CUAL_LESION_ACCIDENTE);

    $('input[name="CUELLO"][value="' + data.CUELLO + '"]').prop('checked', true).trigger('change');
    $('input[name="HOMBRO"][value="' + data.HOMBRO + '"]').prop('checked', true).trigger('change');
    $("#HOMBRO_IZQ").prop("checked", data.HOMBRO_IZQ == 1);
    $("#HOMBRO_DER").prop("checked", data.HOMBRO_DER == 1);

    $('input[name="CODO"][value="' + data.CODO + '"]').prop('checked', true).trigger('change');
    $("#CODO_IZQ").prop("checked", data.CODO_IZQ == 1);
    $("#CODO_DER").prop("checked", data.CODO_DER == 1);

    $('input[name="MUNECA"][value="' + data.MUNECA + '"]').prop('checked', true).trigger('change');
    $("#MUNECA_IZQ").prop("checked", data.MUNECA_IZQ == 1);
    $("#MUNECA_DER").prop("checked", data.MUNECA_DER == 1);

    $('input[name="ESPALDA_ALTA"][value="' + data.ESPALDA_ALTA + '"]').prop('checked', true);
    $('input[name="ESPALDA_BAJA"][value="' + data.ESPALDA_BAJA + '"]').prop('checked', true);
    $('input[name="CADERAS_PIERNAS"][value="' + data.CADERAS_PIERNAS + '"]').prop('checked', true);
    $('input[name="RODILLAS"][value="' + data.RODILLAS + '"]').prop('checked', true);
    $('input[name="TOBILLOS_PIES"][value="' + data.TOBILLOS_PIES + '"]').prop('checked', true);

    $('input[name="CUELLO_12_MESES"][value="' + data.CUELLO_12_MESES + '"]').prop('checked', true);
    $('input[name="CUELLO_7_DIAS"][value="' + data.CUELLO_7_DIAS + '"]').prop('checked', true);

    $('input[name="HOMBRO_12_MESES"][value="' + data.HOMBRO_12_MESES + '"]').prop('checked', true);
    $('input[name="HOMBRO_7_DIAS"][value="' + data.HOMBRO_7_DIAS + '"]').prop('checked', true);

    $('input[name="CODO_12_MESES"][value="' + data.CODO_12_MESES + '"]').prop('checked', true);
    $('input[name="CODO_7_DIAS"][value="' + data.CODO_7_DIAS + '"]').prop('checked', true);

    $('input[name="MUNECA_12_MESES"][value="' + data.MUNECA_12_MESES + '"]').prop('checked', true);
    $('input[name="MUNECA_7_DIAS"][value="' + data.MUNECA_7_DIAS + '"]').prop('checked', true);

    $('input[name="ESPALDA_ALTA_12_MESES"][value="' + data.ESPALDA_ALTA_12_MESES + '"]').prop('checked', true);
    $('input[name="ESPALDA_ALTA_7_DIAS"][value="' + data.ESPALDA_ALTA_7_DIAS + '"]').prop('checked', true);

    $('input[name="ESPALDA_BAJA_12_MESES"][value="' + data.ESPALDA_BAJA_12_MESES + '"]').prop('checked', true);
    $('input[name="ESPALDA_BAJA_7_DIAS"][value="' + data.ESPALDA_BAJA_7_DIAS + '"]').prop('checked', true);

    $('input[name="CADERAS_PIERNAS_12_MESES"][value="' + data.CADERAS_PIERNAS_12_MESES + '"]').prop('checked', true);
    $('input[name="CADERAS_PIERNAS_7_DIAS"][value="' + data.CADERAS_PIERNAS_7_DIAS + '"]').prop('checked', true);

    $('input[name="RODILLAS_12_MESES"][value="' + data.RODILLAS_12_MESES + '"]').prop('checked', true);
    $('input[name="RODILLAS_7_DIAS"][value="' + data.RODILLAS_7_DIAS + '"]').prop('checked', true);

    $('input[name="TOBILLOS_PIES_12_MESES"][value="' + data.TOBILLOS_PIES_12_MESES + '"]').prop('checked', true);
    $('input[name="TOBILLOS_PIES_7_DIAS"][value="' + data.TOBILLOS_PIES_7_DIAS + '"]').prop('checked', true);

    $('input[name="COLUMNA_LUMBAR_P1"][value="' + data.COLUMNA_LUMBAR_P1 + '"]').prop('checked', true).trigger('change');
    $('input[name="COLUMNA_LUMBAR_P2"][value="' + data.COLUMNA_LUMBAR_P2 + '"]').prop('checked', true);
    $('input[name="COLUMNA_LUMBAR_P3"][value="' + data.COLUMNA_LUMBAR_P3 + '"]').prop('checked', true);
    $('input[name="COLUMNA_LUMBAR_P4"][value="' + data.COLUMNA_LUMBAR_P4 + '"]').prop('checked', true).trigger('change');

    $('input[name="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL"][value="' + data.COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL + '"]').prop('checked', true);
    $('input[name="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO"][value="' + data.COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO + '"]').prop('checked', true);

    $('input[name="COLUMNA_LUMBAR_P6"][value="' + data.COLUMNA_LUMBAR_P6 + '"]').prop('checked', true);
    $('input[name="COLUMNA_LUMBAR_P7"][value="' + data.COLUMNA_LUMBAR_P7 + '"]').prop('checked', true);
	$('input[name="COLUMNA_LUMBAR_P8"][value="' + data.COLUMNA_LUMBAR_P8 + '"]').prop('checked', true);
	
    $('input[name="CUELLO_P1"][value="' + data.CUELLO_P1 + '"]').prop('checked', true).trigger('change');
    $('input[name="CUELLO_P2"][value="' + data.CUELLO_P2 + '"]').prop('checked', true);
    $('input[name="CUELLO_P3"][value="' + data.CUELLO_P3 + '"]').prop('checked', true);
    $('input[name="CUELLO_P4"][value="' + data.CUELLO_P4 + '"]').prop('checked', true).trigger('change');
    $('input[name="CUELLO_P5_ACTIVIDAD_LABORAL"][value="' + data.CUELLO_P5_ACTIVIDAD_LABORAL + '"]').prop('checked', true);
    $('input[name="CUELLO_P5_ACTIVIDAD_OCIO"][value="' + data.CUELLO_P5_ACTIVIDAD_OCIO + '"]').prop('checked', true);
    $('input[name="CUELLO_P6"][value="' + data.CUELLO_P6 + '"]').prop('checked', true);
    $('input[name="CUELLO_P7"][value="' + data.CUELLO_P7 + '"]').prop('checked', true);
    $('input[name="CUELLO_P8"][value="' + data.CUELLO_P8 + '"]').prop('checked', true);

    $('input[name="HOMBRO_P1"][value="' + data.HOMBRO_P1 + '"]').prop('checked', true).trigger('change');
    $('input[name="HOMBRO_P2"][value="' + data.HOMBRO_P2 + '"]').prop('checked', true);
    $('input[name="HOMBRO_P3"][value="' + data.HOMBRO_P3 + '"]').prop('checked', true);
    $('input[name="HOMBRO_P4"][value="' + data.HOMBRO_P4 + '"]').prop('checked', true).trigger('change');
    $('input[name="HOMBRO_P5_ACTIVIDAD_LABORAL"][value="' + data.HOMBRO_P5_ACTIVIDAD_LABORAL + '"]').prop('checked', true);
    $('input[name="HOMBRO_P5_ACTIVIDAD_OCIO"][value="' + data.HOMBRO_P5_ACTIVIDAD_OCIO + '"]').prop('checked', true);
    $('input[name="HOMBRO_P6"][value="' + data.HOMBRO_P6 + '"]').prop('checked', true);
    $('input[name="HOMBRO_P7"][value="' + data.HOMBRO_P7 + '"]').prop('checked', true);
    $('input[name="HOMBRO_P8"][value="' + data.HOMBRO_P8 + '"]').prop('checked', true);

    $("#REQUIERE_FUERZA_MANUAL").val(data.REQUIERE_FUERZA_MANUAL).trigger('change');
    $("#APLICA_LEY_SILLA").val(data.APLICA_LEY_SILLA).trigger('change');

    $("#APLICA_METODOS_ERGONOMICOS").val(data.APLICA_METODOS_ERGONOMICOS).trigger('change');


    $("#FUERZA_MANO_DERECHA").val(data.FUERZA_MANO_DERECHA);
    $("#FUERZA_MANO_IZQUIERDA").val(data.FUERZA_MANO_IZQUIERDA);
    $("#TIPO_DOMINANCIA").val(data.TIPO_DOMINANCIA);

    $("#REALIZA_TAREAS_PIE").val(data.REALIZA_TAREAS_PIE);
    $("#BIPEDESTACION_ESTATICA").val(data.BIPEDESTACION_ESTATICA);
    $("#BIPEDESTACION_DINAMICA").val(data.BIPEDESTACION_DINAMICA);
    $("#OBSERVACIONES_GENERALES").val(data.OBSERVACIONES_GENERALES);


    if (data.JSON_EQUIPOS_TRABAJO) {
        pintarEquiposTrabajo(data.JSON_EQUIPOS_TRABAJO);
    }

    if (data.JSON_FUENTES_TERMICAS) {
        pintarFuentesTermicas(data.JSON_FUENTES_TERMICAS);
    }

    if (data.JSON_FUENTES_RUIDO) {
        pintarFuentesRuido(data.JSON_FUENTES_RUIDO);
    }

    if (data.JSON_FUENTES_VIBRACION) {
        pintarFuentesVibracion(data.JSON_FUENTES_VIBRACION);
    }

    if (data.JSON_EPP) {
        pintarEPP(data.JSON_EPP);
    }

    $("#OBSERVACIONES_CUESTIONARIO").val(data.OBSERVACIONES_CUESTIONARIO);
    $("#RECOMENDACIONES_EPP").val(data.RECOMENDACIONES_EPP);
    $("#OBSERVACIONES_FUERZAMANUAL").val(data.OBSERVACIONES_FUERZAMANUAL);
    $("#INTERPRETACION_ESCALA_BORG").val(data.INTERPRETACION_ESCALA_BORG);

    
    $("#ESCALA_BORG").val(data.ESCALA_BORG).trigger('change');

	$('#ENFERMEDAD_MUSCULOESQUELETICA').trigger('change');
	$('#PERCEPCION_TERMICA').trigger('change');
	$('input[name="HOMBRO"]:checked').trigger('change');
	$('input[name="CODO"]:checked').trigger('change');
	$('input[name="MUNECA"]:checked').trigger('change');
	$('input[name="COLUMNA_LUMBAR_P1"]:checked').trigger('change');
	$('input[name="COLUMNA_LUMBAR_P4"]:checked').trigger('change');
	$('input[name="CUELLO_P1"]:checked').trigger('change');
	$('input[name="CUELLO_P4"]:checked').trigger('change');
	$('input[name="HOMBRO_P1"]:checked').trigger('change');
	$('input[name="HOMBRO_P4"]:checked').trigger('change');
	$('#SUFRIDO_LESION_ACCIDENTE').trigger('change');
    $('#REQUIERE_FUERZA_MANUAL').trigger('change');
    $('#APLICA_LEY_SILLA').trigger('change');
    $('#APLICA_METODOS_ERGONOMICOS').trigger('change');
    

    
    



   let metodoGuardadas = data.CAT_METODOS_FRE;

    if (typeof metodoGuardadas === "string") {
        try {
            metodoGuardadas = JSON.parse(metodoGuardadas);
        } catch (e) {
            metodoGuardadas = [];
        }
    }

    if (!Array.isArray(metodoGuardadas)) {
        metodoGuardadas = [];
    }

    if (selectMetodosFRE) {
        selectMetodosFRE.setValue(metodoGuardadas);
    }


    /// OWAS

    $("#OWAS_ESPALDA").val(data.OWAS_ESPALDA);
    $("#OWAS_BRAZOS").val(data.OWAS_BRAZOS);
    $("#OWAS_PIERNAS").val(data.OWAS_PIERNAS);
    $("#OWAS_CARGA").val(data.OWAS_CARGA);

    $("#ANALISIS_METODO_OWAS").val(data.ANALISIS_METODO_OWAS);

    setTimeout(function () {

        document.getElementById('OWAS_ESPALDA').dispatchEvent(
            new Event('change', { bubbles: true })
        );

    }, 100);


    /// ROSA 
  
    $("#ROSA_ALTURA_ASIENTO").val(data.ROSA_ALTURA_ASIENTO);
    $("#ROSA_PROFUNDIDAD_ASIENTO").val(data.ROSA_PROFUNDIDAD_ASIENTO);
    $("#ROSA_REPOSABRAZOS").val(data.ROSA_REPOSABRAZOS);
    $("#ROSA_RESPALDO").val(data.ROSA_RESPALDO);
    $("#ROSA_TIEMPO_A").val(data.ROSA_TIEMPO_A);
    $("#ROSA_TELEFONO").val(data.ROSA_TELEFONO);
    $("#ROSA_TIEMPO_B1").val(data.ROSA_TIEMPO_B1);
    $("#ROSA_PANTALLA").val(data.ROSA_PANTALLA);
    $("#ROSA_TIEMPO_B2").val(data.ROSA_TIEMPO_B2);
    $("#ROSA_RATON").val(data.ROSA_RATON);
    $("#ROSA_TIEMPO_C1").val(data.ROSA_TIEMPO_C1);
    $("#ROSA_TECLADO").val(data.ROSA_TECLADO);
    $("#ROSA_TIEMPO_C2").val(data.ROSA_TIEMPO_C2);
    $("#ANALISIS_METODO_ROSA").val(data.ANALISIS_METODO_ROSA);


    let datosROSA = data.ROSA_DATOS_JSON;

    if (typeof datosROSA === "string" && datosROSA !== "") {
        try {
            datosROSA = JSON.parse(datosROSA);
        } catch (e) {
            console.error("Error al recuperar ROSA_DATOS_JSON:", e);
            datosROSA = null;
        }
    }

    if (datosROSA && Array.isArray(datosROSA.extras))
    {

        $("#contenedorMetodoROSA .rosa-extra").prop("checked", false);

        datosROSA.extras.forEach(extra => {

            $("#contenedorMetodoROSA .rosa-extra").each(function () {

                const coincideApartado = this.dataset.apartado === String(extra.apartado);
                const coincideValor = Number(this.value) === Number(extra.valor);
                if (coincideApartado && coincideValor) {
                    $(this).prop("checked", true);
                }

            });

        });

    }

    setTimeout(function () {

        const contenedorROSA = document.getElementById("contenedorMetodoROSA");

        if (!contenedorROSA) {
            return;
        }

        contenedorROSA.querySelectorAll(".rosa-campo, .rosa-extra, .rosa-tiempo").forEach(function (elemento) {
            elemento.dispatchEvent(
                new Event("change", {
                    bubbles: true
                })
            );

        });

    }, 150);

    
    /// RULA

    $("#RULA_BRAZO").val(data.RULA_BRAZO);
    $("#RULA_ANTEBRAZO").val(data.RULA_ANTEBRAZO);
    $("#RULA_MUNECA").val(data.RULA_MUNECA);
    $("#RULA_GIRO_MUNECA").val(data.RULA_GIRO_MUNECA);
    $("#RULA_CUELLO").val(data.RULA_CUELLO);
    $("#RULA_TRONCO").val(data.RULA_TRONCO);
    $("#RULA_PIERNAS").val(data.RULA_PIERNAS);
    $("#RULA_BRAZO_ABDUCIDO").val(data.RULA_BRAZO_ABDUCIDO);
    $("#RULA_HOMBRO_ELEVADO").val(data.RULA_HOMBRO_ELEVADO);
    $("#RULA_BRAZO_APOYADO").val(data.RULA_BRAZO_APOYADO);
    $("#RULA_ANTEBRAZO_PROYECCION").val(data.RULA_ANTEBRAZO_PROYECCION);
    $("#RULA_ANTEBRAZO_CRUZA").val(data.RULA_ANTEBRAZO_CRUZA);
    $("#RULA_MUNECA_DESVIACION").val(data.RULA_MUNECA_DESVIACION);
    $("#RULA_CUELLO_ROTADO").val(data.RULA_CUELLO_ROTADO);
    $("#RULA_CUELLO_LATERAL").val(data.RULA_CUELLO_LATERAL);
    $("#RULA_TRONCO_TORSION").val(data.RULA_TRONCO_TORSION);
    $("#RULA_TRONCO_LATERAL").val(data.RULA_TRONCO_LATERAL);
    $("#RULA_ACTIVIDAD").val(data.RULA_ACTIVIDAD);
    $("#RULA_CARGA").val(data.RULA_CARGA);
    $("#ANALISIS_METODO_RULA").val(data.ANALISIS_METODO_RULA);


   setTimeout(function () {
        document.getElementById('RULA_BRAZO').dispatchEvent(
            new Event('change', { bubbles: true })
        );
    }, 100);


    /// REBA

    $("#REBA_TRONCO").val(data.REBA_TRONCO);
    $("#REBA_TRONCO_MOD").val(data.REBA_TRONCO_MOD);
    $("#REBA_CUELLO").val(data.REBA_CUELLO);
    $("#REBA_CUELLO_MOD").val(data.REBA_CUELLO_MOD);
    $("#REBA_PIERNAS").val(data.REBA_PIERNAS);
    $("#REBA_RODILLAS").val(data.REBA_RODILLAS);
    $("#REBA_BRAZO").val(data.REBA_BRAZO);
    $("#REBA_BRAZO_MOD").val(data.REBA_BRAZO_MOD);
    $("#REBA_ANTEBRAZO").val(data.REBA_ANTEBRAZO);
    $("#REBA_MUNECA").val(data.REBA_MUNECA);
    $("#REBA_MUNECA_MOD").val(data.REBA_MUNECA_MOD);
    $("#REBA_CARGA").val(data.REBA_CARGA);
    $("#REBA_FUERZA_BRUSCA").val(data.REBA_FUERZA_BRUSCA);
    $("#REBA_AGARRE").val(data.REBA_AGARRE);
    $("#REBA_ACTIVIDAD_MUSCULAR").val(data.REBA_ACTIVIDAD_MUSCULAR);
    $("#ANALISIS_METODO_REBA").val(data.ANALISIS_METODO_REBA);


    setTimeout(function () {

        const contenedorREBA = document.getElementById("contenedorMetodoREBA");

        if (!contenedorREBA) {
            return;
        }

        contenedorREBA.querySelectorAll("select").forEach(function (elemento) {

            elemento.dispatchEvent(
                new Event("change", {
                    bubbles: true
                })
            );

        });

    }, 150);


    /// MAC


    $("#MAC_TAREAS_EQUIPO").val(data.MAC_TAREAS_EQUIPO);
    $("#MAC_LEVANTAMIENTO_INDIVIDUAL").val(data.MAC_LEVANTAMIENTO_INDIVIDUAL);
    $("#MAC_TRANSPORTE_CARGA").val(data.MAC_TRANSPORTE_CARGA);

    // MAC TAREAS EN EQUIPO

    $("#MAC_EQ_A").val(data.MAC_EQ_A);
    $("#MAC_EQ_PESO_CARGA").val(data.MAC_EQ_PESO_CARGA);
    $("#MAC_EQ_NUM_PERSONAS").val(data.MAC_EQ_NUM_PERSONAS);
    $("#MAC_EQ_B").val(data.MAC_EQ_B);
    $("#MAC_EQ_C").val(data.MAC_EQ_C);
    $("#MAC_EQ_D").val(data.MAC_EQ_D);
    $("#MAC_EQ_E").val(data.MAC_EQ_E);
    $("#MAC_EQ_F").val(data.MAC_EQ_F);
    $("#MAC_EQ_G").val(data.MAC_EQ_G);
    $("#MAC_EQ_H").val(data.MAC_EQ_H);
    $("#MAC_EQ_I").val(data.MAC_EQ_I);
    $("#MAC_EQ_J").val(data.MAC_EQ_J);
    $("#MAC_EQ_K").val(data.MAC_EQ_K);

    $("#MAC_EQ_CONTROL_A").val(data.MAC_EQ_CONTROL_A);
    $("#MAC_EQ_CONTROL_B").val(data.MAC_EQ_CONTROL_B);
    $("#MAC_EQ_CONTROL_C").val(data.MAC_EQ_CONTROL_C);
    $("#MAC_EQ_CONTROL_D").val(data.MAC_EQ_CONTROL_D);
    $("#MAC_EQ_CONTROL_E").val(data.MAC_EQ_CONTROL_E);
    $("#MAC_EQ_CONTROL_F").val(data.MAC_EQ_CONTROL_F);
    $("#MAC_EQ_CONTROL_G").val(data.MAC_EQ_CONTROL_G);
    $("#MAC_EQ_CONTROL_H").val(data.MAC_EQ_CONTROL_H);
    $("#MAC_EQ_CONTROL_I").val(data.MAC_EQ_CONTROL_I);
    $("#MAC_EQ_CONTROL_J").val(data.MAC_EQ_CONTROL_J);
    $("#MAC_EQ_CONTROL_K").val(data.MAC_EQ_CONTROL_K);

    $("#MAC_EQ_ANALISIS_RESULTADOS").val(data.MAC_EQ_ANALISIS_RESULTADOS);
    $("#MAC_EQ_TOTAL").text(data.MAC_EQ_TOTAL);
    $("#MAC_EQ_RESULTADO").text(data.MAC_EQ_RESULTADO);

    // MAC LEVANTAMIENTO INDIVIDUAL

    $("#MAC_IND_PESO_CARGA").val(data.MAC_IND_PESO_CARGA);
    $("#MAC_IND_NUM_OBJETOS").val(data.MAC_IND_NUM_OBJETOS);
    $("#MAC_IND_NUM_PERSONAS").val(data.MAC_IND_NUM_PERSONAS);
    $("#MAC_IND_HORAS").val(data.MAC_IND_HORAS);
    $("#MAC_IND_FRECUENCIA").val(data.MAC_IND_FRECUENCIA);

    $("#MAC_IND_A").val(data.MAC_IND_A);
    $("#MAC_IND_B").val(data.MAC_IND_B);
    $("#MAC_IND_C").val(data.MAC_IND_C);
    $("#MAC_IND_D").val(data.MAC_IND_D);
    $("#MAC_IND_E").val(data.MAC_IND_E);
    $("#MAC_IND_F").val(data.MAC_IND_F);
    $("#MAC_IND_G").val(data.MAC_IND_G);
    $("#MAC_IND_H").val(data.MAC_IND_H);

    $("#MAC_IND_CONTROL_A").val(data.MAC_IND_CONTROL_A);
    $("#MAC_IND_CONTROL_B").val(data.MAC_IND_CONTROL_B);
    $("#MAC_IND_CONTROL_C").val(data.MAC_IND_CONTROL_C);
    $("#MAC_IND_CONTROL_D").val(data.MAC_IND_CONTROL_D);
    $("#MAC_IND_CONTROL_E").val(data.MAC_IND_CONTROL_E);
    $("#MAC_IND_CONTROL_F").val(data.MAC_IND_CONTROL_F);
    $("#MAC_IND_CONTROL_G").val(data.MAC_IND_CONTROL_G);
    $("#MAC_IND_CONTROL_H").val(data.MAC_IND_CONTROL_H);

    $("#MAC_IND_ANALISIS_RESULTADOS").val(data.MAC_IND_ANALISIS_RESULTADOS);
    $("#MAC_IND_TOTAL").text(data.MAC_IND_TOTAL);
    $("#MAC_IND_RESULTADO").text(data.MAC_IND_RESULTADO);

    // MAC TRANSPORTE DE CARGA

    $("#MAC_TRANS_PESO_CARGA").val(data.MAC_TRANS_PESO_CARGA);
    $("#MAC_TRANS_NUM_OBJETOS").val(data.MAC_TRANS_NUM_OBJETOS);
    $("#MAC_TRANS_NUM_PERSONAS").val(data.MAC_TRANS_NUM_PERSONAS);
    $("#MAC_TRANS_HORAS").val(data.MAC_TRANS_HORAS);
    $("#MAC_TRANS_FRECUENCIA").val(data.MAC_TRANS_FRECUENCIA);

    $("#MAC_TRANS_A").val(data.MAC_TRANS_A);
    $("#MAC_TRANS_B").val(data.MAC_TRANS_B);
    $("#MAC_TRANS_C").val(data.MAC_TRANS_C);
    $("#MAC_TRANS_D").val(data.MAC_TRANS_D);
    $("#MAC_TRANS_E").val(data.MAC_TRANS_E);
    $("#MAC_TRANS_F").val(data.MAC_TRANS_F);
    $("#MAC_TRANS_G").val(data.MAC_TRANS_G);
    $("#MAC_TRANS_H").val(data.MAC_TRANS_H);
    $("#MAC_TRANS_I").val(data.MAC_TRANS_I);

    $("#MAC_TRANS_CONTROL_A").val(data.MAC_TRANS_CONTROL_A);
    $("#MAC_TRANS_CONTROL_B").val(data.MAC_TRANS_CONTROL_B);
    $("#MAC_TRANS_CONTROL_C").val(data.MAC_TRANS_CONTROL_C);
    $("#MAC_TRANS_CONTROL_D").val(data.MAC_TRANS_CONTROL_D);
    $("#MAC_TRANS_CONTROL_E").val(data.MAC_TRANS_CONTROL_E);
    $("#MAC_TRANS_CONTROL_F").val(data.MAC_TRANS_CONTROL_F);
    $("#MAC_TRANS_CONTROL_G").val(data.MAC_TRANS_CONTROL_G);
    $("#MAC_TRANS_CONTROL_H").val(data.MAC_TRANS_CONTROL_H);
    $("#MAC_TRANS_CONTROL_I").val(data.MAC_TRANS_CONTROL_I);

    $("#MAC_TRANS_ANALISIS_RESULTADOS").val(data.MAC_TRANS_ANALISIS_RESULTADOS);
    $("#MAC_TRANS_TOTAL").text(data.MAC_TRANS_TOTAL);
    $("#MAC_TRANS_RESULTADO").text(data.MAC_TRANS_RESULTADO);

    setTimeout(function () {

        const contenedorMAC = document.getElementById("contenedorMetodoMAC");

        if (!contenedorMAC) {
            return;
        }

        contenedorMAC.querySelectorAll("select").forEach(function (elemento) {

            elemento.dispatchEvent(
                new Event("change", {
                    bubbles: true
                })
            );

        });

    }, 150);
        

    // RAPP CON RUEDAS

    $("#RAPP_CON_RUEDAS").val(data.RAPP_CON_RUEDAS).trigger("change");
    $("#RAPP_SIN_RUEDAS").val(data.RAPP_SIN_RUEDAS).trigger("change");



    $("#RAPP_RUEDAS_A1_PEQUENO").val(data.RAPP_RUEDAS_A1_PEQUENO);
    $("#RAPP_RUEDAS_A1_MEDIANO").val(data.RAPP_RUEDAS_A1_MEDIANO);
    $("#RAPP_RUEDAS_A1_GRANDE").val(data.RAPP_RUEDAS_A1_GRANDE);

    $("#RAPP_RUEDAS_A2_POSTURA").val(data.RAPP_RUEDAS_A2_POSTURA);
    $("#RAPP_RUEDAS_A3_AGARRE").val(data.RAPP_RUEDAS_A3_AGARRE);
    $("#RAPP_RUEDAS_A4_SISTEMA_TRABAJO").val(data.RAPP_RUEDAS_A4_SISTEMA_TRABAJO);
    $("#RAPP_RUEDAS_A5_DISTANCIA").val(data.RAPP_RUEDAS_A5_DISTANCIA);
    $("#RAPP_RUEDAS_A6_CONDICIONES_EQUIPO").val(data.RAPP_RUEDAS_A6_CONDICIONES_EQUIPO);
    $("#RAPP_RUEDAS_A7_SUPERFICIE_PISO").val(data.RAPP_RUEDAS_A7_SUPERFICIE_PISO);
    $("#RAPP_RUEDAS_A8_OBSTACULOS").val(data.RAPP_RUEDAS_A8_OBSTACULOS);
    $("#RAPP_RUEDAS_A9_OTROS_FACTORES").val(data.RAPP_RUEDAS_A9_OTROS_FACTORES);

    $("#RAPP_RUEDAS_ANALISIS_RESULTADOS").val(data.RAPP_RUEDAS_ANALISIS_RESULTADOS);

    $("#RAPP_RUEDAS_TOTAL_PEQUENO").text(data.RAPP_RUEDAS_TOTAL_PEQUENO);
    $("#RAPP_RUEDAS_TOTAL_MEDIANO").text(data.RAPP_RUEDAS_TOTAL_MEDIANO);
    $("#RAPP_RUEDAS_TOTAL_GRANDE").text(data.RAPP_RUEDAS_TOTAL_GRANDE);

    $("#RAPP_RUEDAS_NIVEL_PEQUENO").text(data.RAPP_RUEDAS_NIVEL_PEQUENO);
    $("#RAPP_RUEDAS_NIVEL_MEDIANO").text(data.RAPP_RUEDAS_NIVEL_MEDIANO);
    $("#RAPP_RUEDAS_NIVEL_GRANDE").text(data.RAPP_RUEDAS_NIVEL_GRANDE);

    $("#RAPP_RUEDAS_RESULTADO_GENERAL").text(data.RAPP_RUEDAS_RESULTADO_GENERAL);


    // RAPP SIN RUEDAS

    $("#RAPP_SIN_RUEDAS_B1_RODADO").val(data.RAPP_SIN_RUEDAS_B1_RODADO);
    $("#RAPP_SIN_RUEDAS_B1_PIVOTEO").val(data.RAPP_SIN_RUEDAS_B1_PIVOTEO);
    $("#RAPP_SIN_RUEDAS_B1_ARRASTRAR").val(data.RAPP_SIN_RUEDAS_B1_ARRASTRAR);

    $("#RAPP_SIN_RUEDAS_B2_POSTURA").val(data.RAPP_SIN_RUEDAS_B2_POSTURA);
    $("#RAPP_SIN_RUEDAS_B3_AGARRE").val(data.RAPP_SIN_RUEDAS_B3_AGARRE);
    $("#RAPP_SIN_RUEDAS_B4_SISTEMA_TRABAJO").val(data.RAPP_SIN_RUEDAS_B4_SISTEMA_TRABAJO);
    $("#RAPP_SIN_RUEDAS_B5_DISTANCIA").val(data.RAPP_SIN_RUEDAS_B5_DISTANCIA);
    $("#RAPP_SIN_RUEDAS_B6_SUPERFICIE_PISO").val(data.RAPP_SIN_RUEDAS_B6_SUPERFICIE_PISO);
    $("#RAPP_SIN_RUEDAS_B7_OBSTACULOS").val(data.RAPP_SIN_RUEDAS_B7_OBSTACULOS);
    $("#RAPP_SIN_RUEDAS_B8_OTROS_FACTORES").val(data.RAPP_SIN_RUEDAS_B8_OTROS_FACTORES);

    $("#RAPP_SIN_RUEDAS_ANALISIS_RESULTADOS").val(data.RAPP_SIN_RUEDAS_ANALISIS_RESULTADOS);

    $("#RAPP_SIN_RUEDAS_TOTAL_RODADO").text(data.RAPP_SIN_RUEDAS_TOTAL_RODADO);
    $("#RAPP_SIN_RUEDAS_TOTAL_PIVOTEO").text(data.RAPP_SIN_RUEDAS_TOTAL_PIVOTEO);
    $("#RAPP_SIN_RUEDAS_TOTAL_ARRASTRAR").text(data.RAPP_SIN_RUEDAS_TOTAL_ARRASTRAR);

    $("#RAPP_SIN_RUEDAS_NIVEL_RODADO").text(data.RAPP_SIN_RUEDAS_NIVEL_RODADO);
    $("#RAPP_SIN_RUEDAS_NIVEL_PIVOTEO").text(data.RAPP_SIN_RUEDAS_NIVEL_PIVOTEO);
    $("#RAPP_SIN_RUEDAS_NIVEL_ARRASTRAR").text(data.RAPP_SIN_RUEDAS_NIVEL_ARRASTRAR);

    $("#RAPP_SIN_RUEDAS_RESULTADO_GENERAL").text(data.RAPP_SIN_RUEDAS_RESULTADO_GENERAL);


    setTimeout(function () {

        const contenedorRAPP = document.getElementById("contenedorMetodoRAPP");

        if (!contenedorRAPP) {
            return;
        }

        contenedorRAPP.querySelectorAll("select").forEach(function (elemento) {

            elemento.dispatchEvent(
                new Event("change", {
                    bubbles: true
                })
            );

        });

    }, 150);
    

    
}

function pintarEquiposTrabajo(json) {

    $('#tablaEquiposTrabajo tbody').empty();

    if (!json) return;

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(function (item) {

        let fila = `
            <tr>

                <td>
                    <select class="form-control" name="tipo_equipo[]">
                        <option value="">Seleccione</option>
                        <option value="M" ${item.tipo == 'M' ? 'selected' : ''}>M (Máquinas)</option>
                        <option value="H" ${item.tipo == 'H' ? 'selected' : ''}>H (Herramientas)</option>
                        <option value="U" ${item.tipo == 'U' ? 'selected' : ''}>P (Periféricos)</option>
                        <option value="OTROS" ${item.tipo == 'OTROS' ? 'selected' : ''}>Accesorios u otros</option>
                    </select>
                </td>

                <td>
                    <textarea class="form-control" name="nombre_equipo[]" rows="2">${item.nombre ?? ''}</textarea>
                </td>

                <td>
                    <textarea class="form-control" name="caracteristicas_equipo[]" rows="2">${item.caracteristicas ?? ''}</textarea>
                </td>

                <td>
                    <textarea class="form-control" name="peso_equipo[]" rows="2">${item.peso ?? ''}</textarea>
                </td>

                <td>
                    <textarea class="form-control" name="metodo_equipo[]" rows="2">${item.metodo ?? ''}</textarea>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm eliminarFilaEquipo">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;

        $('#tablaEquiposTrabajo tbody').append(fila);

    });

}

function pintarFuentesTermicas(json) {

    $('#tablaFuentesTermicas tbody').empty();

    if (!json) return;

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(function (item) {

        let fila = `
            <tr>

                <td>
                    <textarea class="form-control"
                              name="fuentes_termicas[]"
                              rows="2">${item.fuente ?? ''}</textarea>
                </td>

                <td class="text-center">
                    <button type="button"
                            class="btn btn-danger eliminarFuenteTermica">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;

        $('#tablaFuentesTermicas tbody').append(fila);

    });

}

function pintarFuentesRuido(json) {

    $('#tablaFuentesRuido tbody').empty();

    if (!json) return;

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(function (item) {

        let fila = `
            <tr>

                <td>
                    <textarea class="form-control"
                              name="fuentes_ruido[]"
                              rows="2">${item.fuente ?? ''}</textarea>
                </td>

                <td class="text-center">
                    <button type="button"
                            class="btn btn-danger eliminarFuenteRuido">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;

        $('#tablaFuentesRuido tbody').append(fila);

    });

}

function pintarFuentesVibracion(json) {

    $('#tablaFuentesVibracion tbody').empty();

    if (!json) return;

    let data = typeof json === "string" ? JSON.parse(json) : json;

    data.forEach(function (item) {

        let fila = `
            <tr>

                <td>
                    <textarea class="form-control"
                              name="fuentes_vibracion[]"
                              rows="2">${item.fuente ?? ''}</textarea>
                </td>

                <td class="text-center">
                    <button type="button"
                            class="btn btn-danger eliminarFuenteVibracion">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;

        $('#tablaFuentesVibracion tbody').append(fila);

    });

}

function pintarEPP(jsonEPP) {

    $('#tablaEPP tbody').empty();

    if (!jsonEPP)
        return;

    let datos = typeof jsonEPP === 'string'
        ? JSON.parse(jsonEPP)
        : jsonEPP;

    datos.forEach(function (item, index) {

        $('#agregarEPP').trigger('click');

        let fila = $('#tablaEPP tbody tr').eq(index);

        fila.find('.region_anatomica_epp')
            .val(item.region)
            .trigger('change');

        setTimeout(function () {

            fila.find('.clave_epp')
                .val(item.clave)
                .trigger('change');

        }, 100);

    });

}

$('#modal_evalfre').on('hidden.bs.modal', function (e) {

	ID_EVALUACION_FRE = 0;

    $('#form_evalfre')[0].reset();

	$("#contenedorActividadesfre").empty(); 


    $('#ID_EVALUACION_FRE').val('')
    $('#JSON_EQUIPOS_TRABAJO').val('')
    $('#JSON_FUENTES_TERMICAS').val('')
    $('#JSON_FUENTES_RUIDO').val('')
    $('#JSON_FUENTES_VIBRACION').val('')
    $('#JSON_EPP').val('')
	$('#datosLesion').hide();
	$('#datosEnfermedadMusculo').hide();
	$('#datosFuerzaManual').hide();
    $('#ESCALA_BORG').css({ 'background-color': '', 'color': '' });
	$('#datosLeySilla').hide();
    $('#TEXTO_NO_APLICALEY').hide();
    $('#metodosergonomicos').hide();
    $('#TEXTO_NO_METODO').hide();

    
	$('#tablaEquiposTrabajo tbody').empty();
	$('#tablaFuentesTermicas tbody').empty();
	$('#tablaFuentesRuido tbody').empty();
    $('#tablaFuentesVibracion tbody').empty();
    $('#tablaEPP tbody').empty();

	$('#CONDICION_TERMINCA_CUAL').hide();

    fichas_id = 0; 

	$('#HOMBRO_IZQ, #HOMBRO_DER').prop('checked', false).prop('disabled', true);
	$('#CODO_IZQ, #CODO_DER').prop('checked', false).prop('disabled', true);
	$('#MUNECA_IZQ, #MUNECA_DER').prop('checked', false).prop('disabled', true);


	$('.bloque-lumbar-p2,.bloque-lumbar-p3,.bloque-lumbar-p4,.bloque-lumbar-p5,.bloque-lumbar-p6,.bloque-lumbar-p7,.bloque-lumbar-p8').find('input').prop('disabled', false);
	$('.bloque-cuello-p2,.bloque-cuello-p3,.bloque-cuello-p4,.bloque-cuello-p5,.bloque-cuello-p6,.bloque-cuello-p7,.bloque-cuello-p8').find('input').prop('disabled', false);
	$('.bloque-hombro-p2,.bloque-hombro-p3,.bloque-hombro-p4,.bloque-hombro-p5,.bloque-hombro-p6,.bloque-hombro-p7,.bloque-hombro-p8').find('input').prop('disabled', false);

	$('#HOMBRO_IZQ,#HOMBRO_DER').prop('disabled', false);
	$('#CODO_IZQ,#CODO_DER').prop('disabled', false);
	$('#MUNECA_IZQ,#MUNECA_DER').prop('disabled', false);
	
    
    selectAreasFRE.clear();
    selectMetodosFRE.clear();


    $('#contenedorMetodoOWAS').hide();
    $('#contenedorMetodoROSA').hide();
    $('#contenedorMetodoRULA').hide();
    $('#contenedorMetodoREBA').hide();


    $('#contenedorMetodoMAC').hide();
    $('#fichaMACTareasEquipo').hide();
    $('#fichaMACLevantamiento').hide();
    $('#fichaMACTransporte').hide();

    $('#contenedorMetodoRAPP').hide();

    $('#fichaRAPPConRuedas').hide();
    $('#fichaRAPPSinRuedas').hide();


    //  OWAS
    $('#OWAS_COD_ESPALDA, #OWAS_COD_BRAZOS, #OWAS_COD_PIERNAS, #OWAS_COD_CARGA').text('—');
    $('#OWAS_CODIGO_COMPLETO').val('');
    $('#OWAS_CARD_RESULTADO').hide();
    $('#OWAS_RESULTADO_CATEGORIA').text('').attr('class', 'badge ml-2');
    $('#OWAS_TABLA_RESULTADOS tbody tr').removeClass('owas-fila-seleccionada');

    //  ROSA
    $('#contenedorMetodoROSA .rosa-celda-seleccionada').removeClass('rosa-celda-seleccionada');
    $('#contenedorMetodoROSA .rosa-seleccionada').removeClass('rosa-seleccionada');
    $('#ROSA_PUNTUACION_FINAL').text('Pendiente');
    $('#ROSA_RIESGO_FINAL').text('Completa todos los campos de las secciones A, B y C para obtener la puntuación final.');

    //  RULA
    $('#contenedorMetodoRULA .rula-celda-seleccionada, #contenedorMetodoRULA .rula-fila-seleccionada, #contenedorMetodoRULA .rula-adicional-activo')
        .removeClass('rula-celda-seleccionada rula-fila-seleccionada rula-adicional-activo');

    $('#RULA_PUNTUACION_A, #RULA_PUNTUACION_B, #RULA_PUNTUACION').text('—');
    $('#RULA_RESUMEN_FINAL').text('Puntuación final: — | Nivel de actuación: —');

    //  REBA
    $('#contenedorMetodoREBA .reba-celda-seleccionada').removeClass('reba-celda-seleccionada');

    $('#REBA_RESULTADO_A, #REBA_RESULTADO_B, #REBA_RESULTADO_C, #REBA_RESULTADO_A_FINAL, #REBA_RESULTADO_B_FINAL, #REBA_PUNTUACION_FINAL').text('—');

    $('#REBA_RESUMEN_FINAL').text('Completa las posiciones corporales para obtener el resultado.');

    $('#REBA_TABLA_NIVEL tbody tr').css({
        'outline': 'none',
        'font-weight': 'normal'
    });
        
    $('#ROSA_DATOS_JSON').val('')
    $('#RULA_DATOS_JSON').val('')




    // MAC
    $('#fichaMACTareasEquipo .mac-eq-seleccionado').removeClass('mac-eq-seleccionado');

    $('#fichaMACTareasEquipo [id^="MAC_EQ_RIESGO_"]').removeClass('mac-eq-seleccionado');

    $('#fichaMACTareasEquipo #tablaResumenMACEq .mac-eq-color')
        .removeClass('mac-eq-color-verde mac-eq-color-naranja mac-eq-color-rojo mac-eq-color-morado')
        .text('')
        .css('background-color', '');

    $('#fichaMACTareasEquipo #tablaResumenMACEq .mac-eq-valor').text('-');

    $('#MAC_EQ_TOTAL').text('');

    $('#MAC_EQ_RESULTADO').text('').css({
        'background-color': '',
        'color': '',
        'border-color': ''
    });


    $('#fichaMACLevantamiento .mac-ind-seleccionado').removeClass('mac-ind-seleccionado');

    $('#fichaMACLevantamiento [id^="MAC_IND_RIESGO_"]').removeClass('mac-ind-seleccionado');

    $('#fichaMACLevantamiento #tablaResumenMACIndividual .mac-ind-color')
        .removeClass('mac-ind-color-verde mac-ind-color-naranja mac-ind-color-rojo mac-ind-color-morado')
        .text('')
        .css('background-color', '');

    $('#fichaMACLevantamiento #tablaResumenMACIndividual .mac-ind-valor').text('-');

    $('#MAC_IND_TOTAL').text('');

    $('#MAC_IND_RESULTADO').text('').css({
        'background-color': '',
        'color': '',
        'border-color': ''
    });

    $('#fichaMACTransporte .mac-trans-seleccionado').removeClass('mac-trans-seleccionado');

    $('#fichaMACTransporte [id^="MAC_TRANS_RIESGO_"]').removeClass('mac-trans-seleccionado');

    $('#fichaMACTransporte #tablaResumenMACTransporte .mac-trans-color')
        .removeClass('mac-trans-color-verde mac-trans-color-naranja mac-trans-color-rojo mac-trans-color-morado')
        .text('')
        .css('background-color', '');

    $('#fichaMACTransporte #tablaResumenMACTransporte .mac-trans-valor').text('-');

    $('#MAC_TRANS_TOTAL').text('');

    $('#MAC_TRANS_RESULTADO').text('').css({
        'background-color': '',
        'color': '',
        'border-color': ''
    });


    // RAPP

    $('#fichaRAPPConRuedas .rapp-seleccionado').removeClass('rapp-seleccionado');

    $('#fichaRAPPConRuedas [id^="RAPP_RUEDAS_RIESGO_"]').removeClass('rapp-seleccionado');

    $('#fichaRAPPConRuedas td, #fichaRAPPConRuedas th').css({
        'outline': 'none',
        'border': '',
        'box-shadow': ''
    });

    $('#fichaRAPPConRuedas [id^="RAPP_RUEDAS_TABLA_"]').each(function () {
        $(this).text('').css({
            'background-color': '',
            'color': '',
            'font-weight': ''
        });
    });

    $('#RAPP_RUEDAS_TOTAL_PEQUENO, #RAPP_RUEDAS_TOTAL_MEDIANO, #RAPP_RUEDAS_TOTAL_GRANDE').text('');

    $('#RAPP_RUEDAS_NIVEL_PEQUENO, #RAPP_RUEDAS_NIVEL_MEDIANO, #RAPP_RUEDAS_NIVEL_GRANDE').text('').css({
        'background-color': '',
        'color': '',
        'font-weight': ''
    });

    $('#RAPP_RUEDAS_RESULTADO_GENERAL').text('').css({
        'background-color': '',
        'color': '',
        'border-color': ''
    });



    $('#fichaRAPPSinRuedas .rapp-seleccionado').removeClass('rapp-seleccionado');

    $('#fichaRAPPSinRuedas [id^="RAPP_SIN_RUEDAS_RIESGO_"]').removeClass('rapp-seleccionado');

    $('#fichaRAPPSinRuedas td, #fichaRAPPSinRuedas th').css({
        'outline': 'none',
        'border': '',
        'box-shadow': ''
    });

    $('#fichaRAPPSinRuedas [id^="RAPP_SIN_RUEDAS_TABLA_"]').each(function () {
        $(this).text('').css({
            'background-color': '',
            'color': '',
            'font-weight': ''
        });
    });

    $('#RAPP_SIN_RUEDAS_TOTAL_RODADO, #RAPP_SIN_RUEDAS_TOTAL_PIVOTEO, #RAPP_SIN_RUEDAS_TOTAL_ARRASTRAR').text('');

    $('#RAPP_SIN_RUEDAS_NIVEL_RODADO, #RAPP_SIN_RUEDAS_NIVEL_PIVOTEO, #RAPP_SIN_RUEDAS_NIVEL_ARRASTRAR').text('').css({
        'background-color': '',
        'color': '',
        'font-weight': ''
    });

    $('#RAPP_SIN_RUEDAS_RESULTADO_GENERAL').text('').css({
        'background-color': '',
        'color': '',
        'border-color': ''
    });


    // ==================== SELECTORES PRINCIPALES MAC Y RAPP ====================

    $('#MAC_TAREAS_EQUIPO, #MAC_LEVANTAMIENTO_INDIVIDUAL, #MAC_TRANSPORTE_CARGA').val('');
    $('#RAPP_CON_RUEDAS, #RAPP_SIN_RUEDAS').val('');
        



})



$(document).on('change', '#ENFERMEDAD_MUSCULOESQUELETICA', function () {

    if ($(this).val() === 'SI') {
        $('#datosEnfermedadMusculo').show();
    } else {
        $('#datosEnfermedadMusculo').hide();

        $('#ENFERMEDAD_MUSCULOESQUELETICA_CUAL').val('');
        $('#ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO').val('');
    }

});

$(document).on('change', '#REQUIERE_FUERZA_MANUAL', function () {

    if ($(this).val() == 1) {
        $('#datosFuerzaManual').show();
    } else {
        $('#datosFuerzaManual').hide();
    }

});

$(document).on('change', '#APLICA_LEY_SILLA', function () {

    if ($(this).val() == 1) {

    $('#datosLeySilla').show();
    $('#TEXTO_NO_APLICALEY').hide();

    } else if ($(this).val() == 2) {

        $('#TEXTO_NO_APLICALEY').show();
        $('#datosLeySilla').hide();

        $('#REALIZA_TAREAS_PIE').val('');
        $('#BIPEDESTACION_ESTATICA').val('');
        $('#BIPEDESTACION_DINAMICA').val('');
        $('#OBSERVACIONES_GENERALES').val('');

    } else {

        $('#datosLeySilla').hide();
        $('#TEXTO_NO_APLICALEY').hide();

    }

});


$(document).on('change', '#APLICA_METODOS_ERGONOMICOS', function () {

    if ($(this).val() == 1) {

    $('#metodosergonomicos').show();
    $('#TEXTO_NO_METODO').hide();

    } else if ($(this).val() == 2) {

        $('#TEXTO_NO_METODO').show();
        $('#metodosergonomicos').hide();

    } else {

        $('#metodosergonomicos').hide();
        $('#TEXTO_NO_METODO').hide();

    }

});



$('#ESCALA_BORG').on('change', function () {
    const opcion = this.options[this.selectedIndex];
    const color = opcion.dataset.color;

    if (!this.value) {
        $(this).css({
            'background-color': '',
            'color': ''
        });
        return;
    }

    $(this).css({
        'background-color': color,
        'color': (this.value >= 8 || this.value <= 2) ? '#fff' : '#222'
    });
});


$(document).on('change', '#SUFRIDO_LESION_ACCIDENTE', function () {

    if ($(this).val() === 'SI') {
        $('#datosLesion').show();
    } else {
        $('#datosLesion').hide();

        $('#CUANDO_LESION_ACCIDENTE').val('');
        $('#CUAL_LESION_ACCIDENTE').val('');
    }

});


//// GUARDAR NUEVO DINAMICO 
$(document).on('click', '#agregarFilaEquipo', function () {

    let fila = `
        <tr>
            <td>
                <select class="form-control" name="tipo_equipo[]">
                    <option value="">Seleccione</option>
                    <option value="M">M (Máquinas)</option>
                    <option value="H">H (Herramientas)</option>
                    <option value="U">P (Periféricos)</option>
                    <option value="OTROS">Accesorios u otros</option>
                </select>
            </td>

            <td>
                <textarea
                    class="form-control"
                    name="nombre_equipo[]"
                    rows="2"></textarea>
            </td>

            <td>
                <textarea
                    class="form-control"
                    name="caracteristicas_equipo[]"
                    rows="2"></textarea>
            </td>

            <td>
                <textarea
                    class="form-control"
                    name="peso_equipo[]"
                    rows="2"></textarea>
            </td>

            <td>
                <textarea
                    class="form-control"
                    name="metodo_equipo[]"
                    rows="2"></textarea>
            </td>

            <td class="text-center">
                <button
                    type="button"
                    class="btn btn-danger btn-sm eliminarFilaEquipo">
                    <i class="fa fa-trash"></i>
                    
                </button>
            </td>
        </tr>
    `;

    $('#tablaEquiposTrabajo tbody').append(fila);

});

$(document).on('click', '.eliminarFilaEquipo', function () {
    $(this).closest('tr').remove();
});


let recognition = null;
let textareaActivo = null;
let botonActivo = null;
let grabando = false;

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    recognition = new SpeechRecognition();

    recognition.lang = 'es-MX';
    recognition.continuous = true;
    recognition.interimResults = false;

    recognition.onresult = function (event) {

        let texto = '';

        for (let i = event.resultIndex; i < event.results.length; i++) {

            if (event.results[i].isFinal) {
                texto += event.results[i][0].transcript + ' ';
            }

        }

        if (textareaActivo) {

            let actual = $(textareaActivo).val();

            $(textareaActivo).val(
                actual + (actual ? ' ' : '') + texto
            );

        }
    };

    recognition.onend = function () {

        if (grabando) {
            recognition.start();
        }

    };
}

$(document).on('click', '.btnMicrofono', function () {

    if (!recognition) {
        alert('El navegador no soporta reconocimiento de voz');
        return;
    }

    if (grabando) {

        grabando = false;
        recognition.stop();

        $('.btnMicrofono')
            .removeClass('btn-danger')
            .addClass('btn-primary')
            .html('<i class="fa fa-microphone"></i>');

        return;
    }

    textareaActivo = '#' + $(this).data('target');
    botonActivo = $(this);

    grabando = true;

    $('.btnMicrofono')
        .removeClass('btn-danger')
        .addClass('btn-primary')
        .html('<i class="fa fa-microphone"></i>');

    botonActivo
        .removeClass('btn-primary')
        .addClass('btn-danger')
        .html('⏹');

    recognition.start();
});

//// GUARDAR NUEVO DINAMICO 

$(document).on('click', '#agregarFuenteTermica', function () {

    let fila = `
        <tr>
            <td>
                <textarea class="form-control"
                          name="fuentes_termicas[]"
                          rows="2"></textarea>
            </td>

            <td class="text-center">
                <button type="button"
                        class="btn btn-danger eliminarFuenteTermica">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

    $('#tablaFuentesTermicas tbody').append(fila);

});

$(document).on('click', '.eliminarFuenteTermica', function () {
    $(this).closest('tr').remove();
});

//// GUARDAR NUEVO DINAMICO 

$(document).on('click', '#agregarFuenteRuido', function () {

    let fila = `
        <tr>
            <td>
                <textarea class="form-control"
                          name="fuentes_ruido[]"
                          rows="2"></textarea>
            </td>

            <td class="text-center">
                <button type="button"
                        class="btn btn-danger eliminarFuenteRuido">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

    $('#tablaFuentesRuido tbody').append(fila);

});

$(document).on('click', '.eliminarFuenteRuido', function () {
    $(this).closest('tr').remove();
});

//// GUARDAR NUEVO DINAMICO 

$(document).on('click', '#agregarFuenteVibracion', function () {

    let fila = `
        <tr>
            <td>
                <textarea class="form-control"
                          name="fuentes_vibracion[]"
                          rows="2"></textarea>
            </td>

            <td class="text-center">
                <button type="button"
                        class="btn btn-danger eliminarFuenteVibracion">
                   <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

    $('#tablaFuentesVibracion tbody').append(fila);

});

$(document).on('click', '.eliminarFuenteVibracion', function () {
    $(this).closest('tr').remove();
});

$('#PERCEPCION_TERMICA').on('change', function () {

	if ($(this).val() == '3') {
		$('#CONDICION_TERMINCA_CUAL').show();
	} else {
		$('#CONDICION_TERMINCA_CUAL').hide();
		$('#CUAL_PERCEPCION').val(''); 
	}

});

$('input[name="HOMBRO"]').change(function () {

    if ($('#HOMBRO_NO').is(':checked')) {

        $('#HOMBRO_IZQ').prop('checked', false);
        $('#HOMBRO_DER').prop('checked', false);

        $('#HOMBRO_IZQ').prop('disabled', true);
        $('#HOMBRO_DER').prop('disabled', true);

    }

    if ($('#HOMBRO_SI').is(':checked')) {

        $('#HOMBRO_IZQ').prop('disabled', false);
        $('#HOMBRO_DER').prop('disabled', false);

    }

});

$('input[name="CODO"]').change(function () {

    if ($('#CODO_NO').is(':checked')) {

        $('#CODO_IZQ').prop('checked', false);
        $('#CODO_DER').prop('checked', false);

        $('#CODO_IZQ').prop('disabled', true);
        $('#CODO_DER').prop('disabled', true);

    }

    if ($('#CODO_SI').is(':checked')) {

        $('#CODO_IZQ').prop('disabled', false);
        $('#CODO_DER').prop('disabled', false);

    }

});


$('input[name="MUNECA"]').change(function () {

    if ($('#MUNECA_NO').is(':checked')) {

        $('#MUNECA_IZQ').prop('checked', false);
        $('#MUNECA_DER').prop('checked', false);

        $('#MUNECA_IZQ').prop('disabled', true);
        $('#MUNECA_DER').prop('disabled', true);

    }

    if ($('#MUNECA_SI').is(':checked')) {

        $('#MUNECA_IZQ').prop('disabled', false);
        $('#MUNECA_DER').prop('disabled', false);

    }

});

function habilitarBloque(selector, habilitar) {

    $(selector)
        .find('input')
        .prop('disabled', !habilitar);

    if (!habilitar) {

        $(selector)
            .find('input')
            .prop('checked', false);

    }

}

// PREGUNTA 1
$('input[name="COLUMNA_LUMBAR_P1"]').change(function () {

    if ($('#COLUMNA_LUMBAR_P1_NO').is(':checked')) {

        habilitarBloque('.bloque-lumbar-p2', false);
        habilitarBloque('.bloque-lumbar-p3', false);
        habilitarBloque('.bloque-lumbar-p4', false);
        habilitarBloque('.bloque-lumbar-p5', false);
        habilitarBloque('.bloque-lumbar-p6', false);
        habilitarBloque('.bloque-lumbar-p7', false);
        habilitarBloque('.bloque-lumbar-p8', false);

    } else {

        habilitarBloque('.bloque-lumbar-p2', true);
        habilitarBloque('.bloque-lumbar-p3', true);
        habilitarBloque('.bloque-lumbar-p4', true);
        habilitarBloque('.bloque-lumbar-p5', true);
        habilitarBloque('.bloque-lumbar-p6', true);
        habilitarBloque('.bloque-lumbar-p7', true);
        habilitarBloque('.bloque-lumbar-p8', true);

    }

});

// PREGUNTA 4
$('input[name="COLUMNA_LUMBAR_P4"]').change(function () {

    if ($('#COLUMNA_LUMBAR_P4_0_DIAS').is(':checked')) {

        habilitarBloque('.bloque-lumbar-p5', false);
        habilitarBloque('.bloque-lumbar-p6', false);
        habilitarBloque('.bloque-lumbar-p7', false);
        habilitarBloque('.bloque-lumbar-p8', false);

    } else {

        habilitarBloque('.bloque-lumbar-p5', true);
        habilitarBloque('.bloque-lumbar-p6', true);
        habilitarBloque('.bloque-lumbar-p7', true);
        habilitarBloque('.bloque-lumbar-p8', true);

    }

});


function habilitarBloqueCuello(selector, habilitar) {

    $(selector)
        .find('input')
        .prop('disabled', !habilitar);

    if (!habilitar) {

        $(selector)
            .find('input')
            .prop('checked', false);

    }

}

//-------------------------------------
// PREGUNTA 1
//-------------------------------------
$('input[name="CUELLO_P1"]').change(function () {

    if ($('#CUELLO_P1_NO').is(':checked')) {

        habilitarBloqueCuello('.bloque-cuello-p2', false);
        habilitarBloqueCuello('.bloque-cuello-p3', false);
        habilitarBloqueCuello('.bloque-cuello-p4', false);
        habilitarBloqueCuello('.bloque-cuello-p5', false);
        habilitarBloqueCuello('.bloque-cuello-p6', false);
        habilitarBloqueCuello('.bloque-cuello-p7', false);
        habilitarBloqueCuello('.bloque-cuello-p8', false);

    } else {

        habilitarBloqueCuello('.bloque-cuello-p2', true);
        habilitarBloqueCuello('.bloque-cuello-p3', true);
        habilitarBloqueCuello('.bloque-cuello-p4', true);
        habilitarBloqueCuello('.bloque-cuello-p5', true);
        habilitarBloqueCuello('.bloque-cuello-p6', true);
        habilitarBloqueCuello('.bloque-cuello-p7', true);
        habilitarBloqueCuello('.bloque-cuello-p8', true);

    }

});


//-------------------------------------
// PREGUNTA 4
//-------------------------------------
$('input[name="CUELLO_P4"]').change(function () {

    if ($('#CUELLO_P4_0_DIAS').is(':checked')) {

        habilitarBloqueCuello('.bloque-cuello-p5', false);
        habilitarBloqueCuello('.bloque-cuello-p6', false);
        habilitarBloqueCuello('.bloque-cuello-p7', false);
        habilitarBloqueCuello('.bloque-cuello-p8', false);

    } else {

        habilitarBloqueCuello('.bloque-cuello-p5', true);
        habilitarBloqueCuello('.bloque-cuello-p6', true);
        habilitarBloqueCuello('.bloque-cuello-p7', true);
        habilitarBloqueCuello('.bloque-cuello-p8', true);

    }

});

function habilitarBloqueHombro(selector, habilitar) {

    $(selector)
        .find('input')
        .prop('disabled', !habilitar);

    if (!habilitar) {

        $(selector)
            .find('input')
            .prop('checked', false);

    }

}

//--------------------------------------------------
// PREGUNTA 1
//--------------------------------------------------
$('input[name="HOMBRO_P1"]').change(function () {

    if ($('#HOMBRO_P1_NO').is(':checked')) {

        habilitarBloqueHombro('.bloque-hombro-p2', false);
        habilitarBloqueHombro('.bloque-hombro-p3', false);
        habilitarBloqueHombro('.bloque-hombro-p4', false);
        habilitarBloqueHombro('.bloque-hombro-p5', false);
        habilitarBloqueHombro('.bloque-hombro-p6', false);
        habilitarBloqueHombro('.bloque-hombro-p7', false);
        habilitarBloqueHombro('.bloque-hombro-p8', false);

    } else {

        habilitarBloqueHombro('.bloque-hombro-p2', true);
        habilitarBloqueHombro('.bloque-hombro-p3', true);
        habilitarBloqueHombro('.bloque-hombro-p4', true);
        habilitarBloqueHombro('.bloque-hombro-p5', true);
        habilitarBloqueHombro('.bloque-hombro-p6', true);
        habilitarBloqueHombro('.bloque-hombro-p7', true);
        habilitarBloqueHombro('.bloque-hombro-p8', true);

    }

});

//--------------------------------------------------
// PREGUNTA 4
//--------------------------------------------------
$('input[name="HOMBRO_P4"]').change(function () {

    if ($('#HOMBRO_P4_0_DIAS').is(':checked')) {

        habilitarBloqueHombro('.bloque-hombro-p5', false);
        habilitarBloqueHombro('.bloque-hombro-p6', false);
        habilitarBloqueHombro('.bloque-hombro-p7', false);
        habilitarBloqueHombro('.bloque-hombro-p8', false);

    } else {

        habilitarBloqueHombro('.bloque-hombro-p5', true);
        habilitarBloqueHombro('.bloque-hombro-p6', true);
        habilitarBloqueHombro('.bloque-hombro-p7', true);
        habilitarBloqueHombro('.bloque-hombro-p8', true);

    }

});


function opcionesRegionAnatomica() {

    let html = '<option value="">Seleccione una opción</option>';

    window.catRegionAnatomica.forEach(function (item) {
        html += `
            <option value="${item.ID_REGION_ANATOMICA}">
                ${item.NOMBRE_REGION}
            </option>
        `;
    });

    return html;
}

function opcionesClaveEPP() {

    let html = '<option value="">Seleccione una opción</option>';

    window.catClaveEPP.forEach(function (item) {
        html += `
            <option
                value="${item.ID_CLAVE_EPP}"
                data-region="${item.REGION_ANATOMICA_ID}"
                data-tipo="${item.TIPO_RIESGO}">
                ${item.CLAVE}) ${item.EPP}
            </option>
        `;

    });

    return html;
}

$(document).on('click', '#agregarEPP', function () {

  
    let fila = `
        <tr>
            <td>
                <select class="form-control region_anatomica_epp">
                    ${opcionesRegionAnatomica()}
                </select>
            </td>
            <td>
                <select class="form-control clave_epp">
                    ${opcionesClaveEPP()}
                </select>
            </td>
            <td>
                <textarea class="form-control tipo_riesgo_epp" rows="2" readonly></textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger eliminarFilaEPP"> <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        `;
    $('#tablaEPP tbody').append(fila);

});

$(document).on('click', '.eliminarFilaEPP', function () {
    $(this).closest('tr').remove();

});

$(document).on('change', '.region_anatomica_epp', function () {

    let fila = $(this).closest('tr');
    let regionSeleccionada = $(this).val();
    let selectClave = fila.find('.clave_epp');
    let textareaTipo = fila.find('.tipo_riesgo_epp');
    textareaTipo.val('');

    if (!selectClave.data('loaded')) {
        selectClave.data('loaded', true);
        selectClave.data('originalOptions', selectClave.html());

    }

    let todasLasOpciones = $('<div>').html(selectClave.data('originalOptions'));

    let opciones = todasLasOpciones.find('option');

    selectClave.html('<option value="">Seleccione una opción</option>');

    opciones.each(function () {

        let region = $(this).data('region');

        if (!regionSeleccionada)
            return;

        if (String(region) === String(regionSeleccionada)) {

            selectClave.append($(this).clone());

        }

    });

});

$(document).on('change', '.clave_epp', function () {

    let fila = $(this).closest('tr');

    let tipo = $(this).find(':selected').data('tipo');

    fila.find('.tipo_riesgo_epp').val(tipo ? tipo : '');

});

function generarJSONEPP() {

    let datos = [];

    $('#tablaEPP tbody tr').each(function () {

        let region = $(this).find('.region_anatomica_epp').val();

        let clave = $(this).find('.clave_epp').val();

        let tipo = $(this).find('.tipo_riesgo_epp').val();

        if (region != "" || clave != "") {

            datos.push({

                region: region,
                clave: clave,
                tipo: tipo

            });

        }

    });

    return JSON.stringify(datos);

}

function generarJSONActividadesfre() {

    let data = [];

    $('#contenedorActividadesfre .actividad-item').each(function () {

        let actividad = {
            nombre: $(this).find('.actividad-nombre').val(),
            tareas: []
        };

        $(this).find('.tarea-item').each(function () {

            actividad.tareas.push({
                nombre: $(this).find('.tarea-nombre').val(),
                frecuencia: $(this).find('.tarea-frecuencia').val(),
                numero_veces: $(this).find('.tarea-numero-veces').val(),
                duracion: $(this).find('.tarea-duracion').val()
            });

        });

        data.push(actividad);
    });

    return JSON.stringify(data);
}

function generarJSONEquiposTrabajo() {

    let equipos = [];
    $('#tablaEquiposTrabajo tbody tr').each(function () {
        equipos.push({
            tipo: $(this).find('select[name="tipo_equipo[]"]').val(),
            nombre: $(this).find('textarea[name="nombre_equipo[]"]').val(),
            caracteristicas: $(this).find('textarea[name="caracteristicas_equipo[]"]').val(),
            peso: $(this).find('textarea[name="peso_equipo[]"]').val(),
            metodo: $(this).find('textarea[name="metodo_equipo[]"]').val()
        });
    });
    return JSON.stringify(equipos);
}

function generarJSONFuentesTermicas() {
    let datos = [];
    $('#tablaFuentesTermicas tbody tr').each(function () {
        datos.push({fuente: $(this).find('textarea[name="fuentes_termicas[]"]').val()});
    });
    return JSON.stringify(datos);
}

function generarJSONFuentesRuido() {
    let datos = [];
    $('#tablaFuentesRuido tbody tr').each(function () {
        datos.push({ fuente: $(this).find('textarea[name="fuentes_ruido[]"]').val()});
    });
    return JSON.stringify(datos);
}

function generarJSONFuentesVibracion() {

    let datos = [];

    $('#tablaFuentesVibracion tbody tr').each(function () {
        datos.push({fuente: $(this).find('textarea[name="fuentes_vibracion[]"]').val()});
    });
    return JSON.stringify(datos);
}

$("#boton_guardar_fre").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#form_evalfre'))

    if (formularioValido) {


		let json = generarJSONActividadesfre();
		let jsonEquipos = generarJSONEquiposTrabajo();
		let jsonTermicas = generarJSONFuentesTermicas();
		let jsonRuido = generarJSONFuentesRuido();
		let jsonVibracion = generarJSONFuentesVibracion();
        let jsonEPP = generarJSONEPP();

		if (!$('#JSON_ACTIVIDADES_FRE').length) {
			$('#form_evalfre').append('<input type="hidden" name="JSON_ACTIVIDADES_FRE" id="JSON_ACTIVIDADES_FRE">');
		}

		if (!$('#JSON_EQUIPOS_TRABAJO').length)
    	$('#form_evalfre').append('<input type="hidden" id="JSON_EQUIPOS_TRABAJO" name="JSON_EQUIPOS_TRABAJO">');

		if (!$('#JSON_FUENTES_TERMICAS').length)
		$('#form_evalfre').append('<input type="hidden" id="JSON_FUENTES_TERMICAS" name="JSON_FUENTES_TERMICAS">');

		if (!$('#JSON_FUENTES_RUIDO').length)
    	$('#form_evalfre').append('<input type="hidden" id="JSON_FUENTES_RUIDO" name="JSON_FUENTES_RUIDO">');

		if (!$('#JSON_FUENTES_VIBRACION').length)
        $('#form_evalfre').append('<input type="hidden" id="JSON_FUENTES_VIBRACION" name="JSON_FUENTES_VIBRACION">');
        

        if (!$('#JSON_EPP').length) {
        $('#form_evalfre').append('<input type="hidden" name="JSON_EPP" id="JSON_EPP">');
        }
		
		$('#JSON_ACTIVIDADES_FRE').val(json);
        $('#JSON_EQUIPOS_TRABAJO').val(jsonEquipos);
        
		$('#JSON_FUENTES_TERMICAS').val(jsonTermicas);
		$('#JSON_FUENTES_RUIDO').val(jsonRuido);
        $('#JSON_FUENTES_VIBRACION').val(jsonVibracion);
        
        $('#JSON_EPP').val(jsonEPP);
        

        let datosROSA = {
            extras: []
        };

        $('#contenedorMetodoROSA .rosa-extra:checked').each(function () {

            datosROSA.extras.push({
                apartado: $(this).data('apartado'),
                valor: parseInt($(this).val(), 10),
                texto: $(this).data('texto')
            });

        });

        $('#ROSA_DATOS_JSON').val(JSON.stringify(datosROSA));



        let datosRULA = {
    extras: []
};

$('#contenedorMetodoRULA .rula-extra:checked').each(function () {

    datosRULA.extras.push({
        apartado: $(this).data('apartado'),
        valor: parseInt($(this).val(), 10),
        texto: $(this).data('texto')
    });

});

        $('#RULA_DATOS_JSON').val(JSON.stringify(datosRULA));
        

    if (ID_EVALUACION_FRE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_fre')
            await ajaxAwaitFormData({ api: 1,FICHA_ID: fichas_id, ID_EVALUACION_FRE: ID_EVALUACION_FRE, RECO_ID: recsensorial, }, 'evaluacionfre', 'form_evalfre', 'boton_guardar_fre', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_EVALUACION_FRE = data.fre.ID_EVALUACION_FRE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modal_evalfre').modal('hide')
                    document.getElementById('form_evalfre').reset();
                    Tablafichasevaluacionfre.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_fre')
            await ajaxAwaitFormData({ api: 1, FICHA_ID: fichas_id, ID_EVALUACION_FRE: ID_EVALUACION_FRE, RECO_ID: recsensorial,}, 'evaluacionfre', 'form_evalfre', 'boton_guardar_fre', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_EVALUACION_FRE = data.fre.ID_EVALUACION_FRE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modal_evalfre').modal('hide')
                    document.getElementById('form_evalfre').reset();
                    Tablafichasevaluacionfre.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

////// GRAFICAS 1

function cargarGraficaPregunta1()
{

    $.ajax({

        url: '/cargarGraficaPregunta1',
        type: 'POST',
        dataType: 'json',
        data:{
            recsensorial: recsensorial,
            _token: $('meta[name="csrf-token"]').attr('content')

        },
        beforeSend:function(){
            $("#tablaPregunta1").html("");

        },

        success:function(response){
            if(response.code==200)
            {
                llenarMapaPregunta1(response.porcentajes);
                llenarTablaPregunta1(response.tabla);
            }

        },

        error:function(xhr){
            console.log(xhr.responseText);
        }

    });

}

function llenarMapaPregunta1(datos)
{
    colocarPorcentaje("#CUELLOP1",datos.CUELLO);
    colocarPorcentaje("#HOMBREOP1",datos.HOMBRO);
    colocarPorcentaje("#CODOP1",datos.CODO);
    colocarPorcentaje("#MANOP1",datos.MUNECA);
    colocarPorcentaje("#DORSALP1",datos.ESPALDA_ALTA);
    colocarPorcentaje("#LUMBARP1",datos.ESPALDA_BAJA);
    colocarPorcentaje("#CADERAP1",datos.CADERAS_PIERNAS);
    colocarPorcentaje("#RODILLAP1",datos.RODILLAS);
    colocarPorcentaje("#TOBILLOP1",datos.TOBILLOS_PIES);
}

function colocarPorcentaje(id, valor)
{
    $(id).text(valor + "%");

    if (valor == 0)
    {
        $(id).css({
            "background": "#FFFFFF",
            "color": "black"
        });
    }
    else if (valor >= 1 && valor < 50)
    {
        $(id).css({
            "background": "#A4D65E",
            "color": "black"
        });
    }
    else
    {
        $(id).css({
            "background": "#FF585D",
            "color": "white"
        });
    }
}

function llenarTablaPregunta1(datos)
{

    let html = "";

    html += `
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    let grupos = {};
    $.each(datos, function(i, row){
        if(!grupos[row.AREA]){
            grupos[row.AREA] = [];
        }
        grupos[row.AREA].push(row);
    });

    $.each(grupos, function(area, filas){
        $.each(filas, function(index, row){
            html += "<tr>";
            if(index == 0){
                html += `
                    <td rowspan="${filas.length}" class="align-middle font-weight-bold">
                        ${area}
                    </td>
                `;
            }
            html += `
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            `;
            html += "</tr>";
        });
    });
    html += `
            </tbody>
        </table>
    `;
    $("#tablaPregunta1").html(html);
}

////// GRAFICAS 2

function cargarGraficaPregunta2()
{

    $.ajax({
        url: '/cargarGraficaPregunta2',
        type: 'POST',
        dataType: 'json',
        data:{
            recsensorial: recsensorial,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend:function(){
            $("#tablaPregunta2").html("");
        },
        success:function(response){
            if(response.code==200)
            {
                llenarMapaPregunta2(response.porcentajes);
                llenarTablaPregunta2(response.tabla);
            }
        },
        error:function(xhr){
            console.log(xhr.responseText);
        }

    });

}

function llenarMapaPregunta2(datos)
{

    colocarPorcentajePregunta2("#CUELLOP2",datos.CUELLO_12_MESES);
    colocarPorcentajePregunta2("#HOMBREOP2",datos.HOMBRO_12_MESES);
    colocarPorcentajePregunta2("#CODOP2",datos.CODO_12_MESES);
    colocarPorcentajePregunta2("#MANOP2",datos.MUNECA_12_MESES);
    colocarPorcentajePregunta2("#DORSALP2",datos.ESPALDA_ALTA_12_MESES);
    colocarPorcentajePregunta2("#LUMBARP2",datos.ESPALDA_BAJA_12_MESES);
    colocarPorcentajePregunta2("#CADERAP2",datos.CADERAS_PIERNAS_12_MESES);
    colocarPorcentajePregunta2("#RODILLAP2",datos.RODILLAS_12_MESES);
    colocarPorcentajePregunta2("#TOBILLOP2",datos.TOBILLOS_PIES_12_MESES);

}

function colocarPorcentajePregunta2(id,valor)
{

    $(id).text(valor + "%");

    if (valor == 0)
    {
        $(id).css({
            "background": "#FFFFFF",
            "color": "black"
        });
    }
    else if (valor >= 1 && valor < 50)
    {
        $(id).css({
            "background": "#A4D65E",
            "color": "black"
        });
    }
    else
    {
        $(id).css({
            "background": "#FF585D",
            "color": "white"
        });
    }

}

function llenarTablaPregunta2(datos)
{

    let html = "";

    html += `
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    let grupos = {};
    $.each(datos, function(i, row){

        if(!grupos[row.AREA]){
            grupos[row.AREA] = [];
        }
        grupos[row.AREA].push(row);
    });

    $.each(grupos, function(area, filas){
        $.each(filas, function(index, row){
            html += "<tr>";
            if(index == 0){
                html += `<td rowspan="${filas.length}" class="align-middle font-weight-bold">${area}</td>`;
            }
            html += `
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            `;
            html += "</tr>";
        });
    });
    html += `
            </tbody>
        </table>
    `;
    $("#tablaPregunta2").html(html);

}

////// GRAFICAS 3

function cargarGraficaPregunta3()
{
    $.ajax({

        url: '/cargarGraficaPregunta3',
        type: 'POST',
        dataType: 'json',
        data:{
            recsensorial: recsensorial,
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend:function(){
            $("#tablaPregunta3").html("");
        },

        success:function(response){

            if(response.code==200)
            {
                llenarMapaPregunta3(response.porcentajes);
                llenarTablaPregunta3(response.tabla);
            }
        },
        error:function(xhr){
            console.log(xhr.responseText);
        }
    });
}

function llenarMapaPregunta3(datos)
{

    colocarPorcentajePregunta3("#CUELLOP3",datos.CUELLO_7_DIAS);
    colocarPorcentajePregunta3("#HOMBREOP3",datos.HOMBRO_7_DIAS);
    colocarPorcentajePregunta3("#CODOP3",datos.CODO_7_DIAS);
    colocarPorcentajePregunta3("#MANOP3",datos.MUNECA_7_DIAS);
    colocarPorcentajePregunta3("#DORSALP3",datos.ESPALDA_ALTA_7_DIAS);
    colocarPorcentajePregunta3("#LUMBARP3",datos.ESPALDA_BAJA_7_DIAS);
    colocarPorcentajePregunta3("#CADERAP3",datos.CADERAS_PIERNAS_7_DIAS);
    colocarPorcentajePregunta3("#RODILLAP3",datos.RODILLAS_7_DIAS);
    colocarPorcentajePregunta3("#TOBILLOP3",datos.TOBILLOS_PIES_7_DIAS);

}

function colocarPorcentajePregunta3(id,valor)
{
     $(id).text(valor + "%");

    if (valor == 0)
    {
        $(id).css({
            "background": "#FFFFFF",
            "color": "black"
        });
    }
    else if (valor >= 1 && valor < 50)
    {
        $(id).css({
            "background": "#A4D65E",
            "color": "black"
        });
    }
    else
    {
        $(id).css({
            "background": "#FF585D",
            "color": "white"
        });
    }

}

function llenarTablaPregunta3(datos)
{
    let html = "";

    html += `
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    let grupos = {};

    $.each(datos, function(i, row){

        if(!grupos[row.AREA]){
            grupos[row.AREA] = [];
        }

        grupos[row.AREA].push(row);

    });

    $.each(grupos, function(area, filas){
        $.each(filas, function(index, row){
            html += "<tr>";
            if(index == 0){
                html += `<td rowspan="${filas.length}" class="align-middle font-weight-bold">${area}</td>`;
            }
            html += `
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            `;
            html += "</tr>";
        });
    });

    html += `
            </tbody>
        </table>
    `;

    $("#tablaPregunta3").html(html);
}


////// GRAFICAS 4

function cargarGraficaPregunta4()
{
    $.ajax({

        url: '/cargarGraficaPregunta4',
        type: 'POST',
        dataType: 'json',
        data:{
            recsensorial: recsensorial,
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend:function(){

            $("#tablaPregunta4").html("");

        },

        success:function(response){

            if(response.code==200)
            {
                llenarMapaPregunta4(response.porcentaje);
                llenarTablaPregunta4(response.tabla);
            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

        }

    });
}

function llenarMapaPregunta4(valor)
{
    colocarPorcentajePregunta4("#LUMBARP4", valor);
}

function colocarPorcentajePregunta4(id, valor)
{

    $(id).text(valor + "%");

    if (valor == 0)
    {
        $(id).css({
            "background": "#FFFFFF",
            "color": "black"
        });
    }
    else if (valor >= 1 && valor < 50)
    {
        $(id).css({
            "background": "#A4D65E",
            "color": "black"
        });
    }
    else
    {
        $(id).css({
            "background": "#FF585D",
            "color": "white"
        });
    }

}

function llenarTablaPregunta4(datos)
{

    let html="";

    html+=`
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    $.each(datos,function(i,row){

        html+=`
            <tr>
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            </tr>
        `;

    });

    html+=`
            </tbody>
        </table>
    `;

    $("#tablaPregunta4").html(html);

}

////// GRAFICAS 5

function cargarGraficaPregunta5()
{
    $.ajax({

        url:'/cargarGraficaPregunta5',
        type:'POST',
        dataType:'json',
        data:{
            recsensorial:recsensorial,
            _token:$('meta[name="csrf-token"]').attr('content')
        },

        beforeSend:function(){

            $("#tablaPregunta5").html("");

        },

        success:function(response){

            if(response.code==200)
            {
                llenarMapaPregunta5(response.porcentaje);
                llenarTablaPregunta5(response.tabla);
            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

        }

    });
}

function llenarMapaPregunta5(valor)
{
    colocarPorcentajePregunta5("#CUELLOP5",valor);
}

function colocarPorcentajePregunta5(id,valor)
{

    $(id).text(valor+"%");

    if(valor==0)
    {
        $(id).css({

            "background":"#FFFFFF",
            "color":"black"

        });
    }
    else if(valor>=1 && valor<50)
    {
        $(id).css({

            "background":"#A4D65E",
            "color":"black"

        });
    }
    else
    {
        $(id).css({

            "background":"#FF585D",
            "color":"white"

        });
    }

}

function llenarTablaPregunta5(datos)
{

    let html="";

    html+=`
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    $.each(datos,function(i,row){

        html+=`
            <tr>
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            </tr>
        `;

    });

    html+=`
            </tbody>
        </table>
    `;

    $("#tablaPregunta5").html(html);

}

////// GRAFICAS 6

function cargarGraficaPregunta6()
{
    $.ajax({

        url:'/cargarGraficaPregunta6',
        type:'POST',
        dataType:'json',
        data:{
            recsensorial:recsensorial,
            _token:$('meta[name="csrf-token"]').attr('content')
        },

        beforeSend:function(){

            $("#tablaPregunta6").html("");

        },

        success:function(response){

            if(response.code==200)
            {
                llenarMapaPregunta6(response.porcentaje);
                llenarTablaPregunta6(response.tabla);
            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

        }

    });
}

function llenarMapaPregunta6(valor)
{
    colocarPorcentajePregunta6("#HOMBROP6",valor);
}

function colocarPorcentajePregunta6(id,valor)
{

    $(id).text(valor+"%");

    if(valor==0)
    {
        $(id).css({

            "background":"#FFFFFF",
            "color":"black"

        });
    }
    else if(valor>=1 && valor<50)
    {
        $(id).css({

            "background":"#A4D65E",
            "color":"black"

        });
    }
    else
    {
        $(id).css({

            "background":"#FF585D",
            "color":"white"

        });
    }

}

function llenarTablaPregunta6(datos)
{

    let html="";

    html+=`
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
    `;

    $.each(datos,function(i,row){

        html+=`
            <tr>
                <td>${row.CATEGORIA}</td>
                <td>${row.PORCENTAJE}%</td>
            </tr>
        `;

    });

    html+=`
            </tbody>
        </table>
    `;

    $("#tablaPregunta6").html(html);

}


/////  TOMAR CAPTURA


function descargarCard(idCard,nombre)
{

    const card=document.getElementById(idCard);

    const alto=card.style.height;
    const overflow=card.style.overflow;

    card.style.height="auto";
    card.style.overflow="visible";

    html2canvas(card,{

        scale:3,
        useCORS:true,
        backgroundColor:"#ffffff"

    }).then(function(canvas){

        let enlace=document.createElement("a");

        enlace.download=nombre+".png";

        enlace.href=canvas.toDataURL("image/png");

        enlace.click();

        card.style.height=alto;
        card.style.overflow=overflow;

    });

}



/////////////// PORTADA  //////////////


function cargarDatosInformesFreErgo()
{

    $.get('/obtenerDatosInformesFreErgo/' + recsensorial)

    .done(function(validacion)
    {
    
        let esFreErgo = validacion && Array.isArray(validacion.data) && validacion.data.length > 0;

        if(esFreErgo)
        {
            cargarInformacion(validacion,'/mostrarportadafreergo/0/');
        }
        else
        {
            let urlReco = '/obtenerDatosInformesRecoergo/' + recsensorial;


            $.get(urlReco)

            .done(function(responseReco)
            {
                cargarInformacion(responseReco,'/mostrarportadarecoergo/0/');
            })

            .fail(function(xhr)
            {
                console.error('ERROR RECO:', xhr.status);
                console.error('URL RECO:', urlReco);
                console.error('RESPUESTA:', xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los datos del informe'
                });
            });
        }
    })

    .fail(function(xhr)
    {
        console.error('ERROR FRE:', xhr.status);
        console.error('RESPUESTA FRE:', xhr.responseText);

        $.get('/obtenerDatosInformesRecoergo/' + recsensorial)

        .done(function(responseReco)
        {
            cargarInformacion(responseReco,'/mostrarportadarecoergo/0/');
        })

        .fail(function(xhrReco)
        {
            console.error('ERROR RECO:', xhrReco.status);
            console.error('RESPUESTA RECO:', xhrReco.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los datos del informe'
            });
        });
    });


    function cargarInformacion(response, rutaImagen)
    {
        //-----------------------------------------
        // LLENAR SELECTS
        //-----------------------------------------

        $('#NIVEL1').html(response.opciones);
        $('#NIVEL2').html(response.opciones);
        $('#NIVEL3').html(response.opciones);
        $('#NIVEL4').html(response.opciones);
        $('#NIVEL5').html(response.opciones);

        $('#OPCION_PORTADA1').html(response.checks);
        $('#OPCION_PORTADA2').html(response.checks);
        $('#OPCION_PORTADA3').html(response.checks);
        $('#OPCION_PORTADA4').html(response.checks);
        $('#OPCION_PORTADA5').html(response.checks);
        $('#OPCION_PORTADA6').html(response.checks);

        $('#INFORME_MES').val("");
        $('#INFORME_ANIO').val("");

        //-----------------------------------------
        // SI EXISTE INFORMACION
        //-----------------------------------------

        if(response.data != 'No se encontraron datos')
        {
            let data = response.data[0];

            //-----------------------------------------
            // ASIGNAR VALORES
            //-----------------------------------------

            $('#NIVEL1').val(data.NIVEL1).trigger('change');
            $('#NIVEL2').val(data.NIVEL2).trigger('change');
            $('#NIVEL3').val(data.NIVEL3).trigger('change');
            $('#NIVEL4').val(data.NIVEL4).trigger('change');
            $('#NIVEL5').val(data.NIVEL5).trigger('change');

            $('#OPCION_PORTADA1').val(data.OPCION_PORTADA1).trigger('change');
            $('#OPCION_PORTADA2').val(data.OPCION_PORTADA2).trigger('change');
            $('#OPCION_PORTADA3').val(data.OPCION_PORTADA3).trigger('change');
            $('#OPCION_PORTADA4').val(data.OPCION_PORTADA4).trigger('change');
            $('#OPCION_PORTADA5').val(data.OPCION_PORTADA5).trigger('change');
            $('#OPCION_PORTADA6').val(data.OPCION_PORTADA6).trigger('change');

            //-----------------------------------------
            // MES Y AÑO
            //-----------------------------------------

            $('#INFORME_MES').val(data.INFORME_MES);
            $('#INFORME_ANIO').val(data.INFORME_ANIO);

            //-----------------------------------------
            // IMAGEN PORTADA
            //-----------------------------------------

            if(data.RUTA_IMAGEN_PORTADA)
            {
                var archivo = data.RUTA_IMAGEN_PORTADA;

                var extension = archivo.substring(
                    archivo.lastIndexOf(".")
                );

                var imagenUrl =
                    rutaImagen +
                    recsensorial +
                    extension;

                //-----------------------------------------
                // DROPIFY ORIGINAL
                //-----------------------------------------

                if ($('#RUTA_IMAGEN_PORTADA').data('dropify')) {

                    $('#RUTA_IMAGEN_PORTADA')
                        .dropify()
                        .data('dropify')
                        .destroy();

                    $('#RUTA_IMAGEN_PORTADA')
                        .dropify()
                        .data('dropify')
                        .settings.defaultFile = imagenUrl;

                    $('#RUTA_IMAGEN_PORTADA')
                        .dropify()
                        .data('dropify')
                        .init();

                }
                else {

                    $('#RUTA_IMAGEN_PORTADA')
                        .attr('data-default-file', imagenUrl);

                    $('#RUTA_IMAGEN_PORTADA').dropify({

                        messages: {
                            'default': 'Arrastre la imagen aquí o haga click',
                            'replace': 'Arrastre la imagen o haga clic para reemplazar',
                            'remove': 'Quitar',
                            'error': 'Ooops, ha ocurrido un error.'
                        },

                        error: {
                            'fileSize': 'Demasiado grande ({{ value }} max).',
                            'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                            'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                            'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                            'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                            'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                        }

                    });
                }

                $('#RUTA_IMAGEN_PORTADA').attr('required', false);

            }

        }

    }

}


$("#form_informe_portada").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID', recsensorial);

    $.ajax({
        url: '/guardarPortadaFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {

            $("#botonguardar_reporte_portada").prop('disabled', true);

            $("#botonguardar_reporte_portada").html(
                'Guardando... <i class="fa fa-spinner fa-spin"></i>'
            );

        },

        success: function(response)
        {

            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });


            cargarDatosInformesFreErgo();

        },

        error: function(xhr)
        {

            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al guardar'
            });

        },

        complete: function()
        {

            $("#botonguardar_reporte_portada").prop('disabled', false);

            $("#botonguardar_reporte_portada").html(
                'Guardar portadas <i class="fa fa-save"></i>'
            );

        }

    });

});


/////  DATOS GENERALES



function cargarDatosGeneralesInformeReco()
{

    $.get(

        '/obtenerDatosGeneralesInformeReco/' + recsensorial,

        function(response)
        {

        

            if(response.msj){

                return;
            }

                    
			$('#INFORME_UBICACIONINSTALACION').val(response.INFORME_UBICACIONINSTALACION);
        
            

			   if(response.RUTA_IMAGEN_UBICACION)
            {

                var archivo = response.RUTA_IMAGEN_UBICACION;

                var extension = archivo.substring(
                    archivo.lastIndexOf(".")
                );



                var imagenUrl =
                    '/mostrarubicacionrecoergo/0/' +
                    recsensorial +
                    extension;


                if ($('#RUTA_IMAGEN_UBICACION').data('dropify')) {

                    $('#RUTA_IMAGEN_UBICACION')
                        .dropify()
                        .data('dropify')
                        .destroy();


                    $('#RUTA_IMAGEN_UBICACION')
                        .dropify()
                        .data('dropify')
                        .settings.defaultFile = imagenUrl;


                    $('#RUTA_IMAGEN_UBICACION')
                        .dropify()
                        .data('dropify')
                        .init();

                }
                else {

                    $('#RUTA_IMAGEN_UBICACION')
                        .attr('data-default-file', imagenUrl);


                    $('#RUTA_IMAGEN_UBICACION').dropify({

                        messages: {
                            'default': 'Arrastre la imagen aquí o haga click',
                            'replace': 'Arrastre la imagen o haga clic para reemplazar',
                            'remove': 'Quitar',
                            'error': 'Ooops, ha ocurrido un error.'
                        },

                        error: {
                            'fileSize': 'Demasiado grande ({{ value }} max).',
                            'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                            'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                            'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                            'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                            'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                        }

                    });
                }


                $('#RUTA_IMAGEN_UBICACION')
                    .attr('required', false);

			}
			

        }

    );

}


function cargarDatosGeneralesInformeFre()
{

    $.get(

        '/obtenerDatosGeneralesInformeFre/' + recsensorial,

        function(response)
        {

        

            if(response.msj){

                return;
            }


            if (response.INFORME_INTRODUCCION &&
                response.INFORME_INTRODUCCION.trim() != '') {

                $('#INFORME_INTRODUCCION').summernote(
                    'code',
                    response.INFORME_INTRODUCCION
                );

            } else {

                $('#INFORME_INTRODUCCION').summernote(
                    'code',
                    `<p>Los trastornos musculoesqueléticos (TME) constituyen un problema prioritario de salud pública y de la salud en el trabajo, debido a su impacto sobre la capacidad funcional, el bienestar y la participación laboral. Según la Organización Mundial de la Salud (OMS, 2022)<sup>1</sup>, aproximadamente 1.710 millones de personas vivían con estas afecciones en el mundo, de acuerdo con los datos del estudio de carga mundial de enfermedad de 2019. Aunque esta cifra comprende los TME de origen laboral y no laboral, permite dimensionar la magnitud del problema y la importancia de prevenir la exposición que contribuya a su aparición o agravamiento en el trabajo.</p>

            <p>En el ámbito laboral, las estimaciones conjuntas de la Organización Mundial de la Salud y la Organización Internacional del Trabajo (OMS y OIT, 2021)<sup>2</sup> atribuyen a los factores de riesgo ergonómico 12,27 millones de años de vida ajustados debido a la discapacidad por dolor de espalda y cuello en 2016. Esta carga aumentó un 20,1 % respecto al año 2000. El informe identifica, entre las exposiciones pertinentes, la manipulación manual de cargas, las vibraciones de cuerpo entero y la permanencia prolongada en posición sentada.</p>

            <p>En México, el Instituto Mexicano del Seguro Social (IMSS, 2025)<sup>3</sup>, registró un total de 19,803 casos reportados de enfermedad de trabajo, donde aproximadamente el 57% de los casos, están relacionados con TME, encontrando determinadas dorsopatías; lesiones del hombro; síndrome del túnel carpiano; tenosinovitis de estiloides radial de Quervain; otras sinovitis, tenosinovitis o bursitis y artrosis, donde la naturaleza de la lesión puede ser un indicador importante para atribuir la causalidad al factor de riesgo ergonómico; por tal razón los TME representan en la actualidad un importante tipo de enfermedad laboral que afecta a la población trabajadora en México. Por otra parte, el Reglamento Federal de Seguridad y Salud en el Trabajo (RFSST), publicado en el Diario Oficial de la Federación (DOF) el día 13 de noviembre de 2014, establece en su artículo 42, que las empresas deben contar con un análisis de los Factores de Riesgo Ergonómico de los puestos de trabajo; adicionalmente, la Secretaría de Trabajo y Previsión Social (STPS) emitió la Norma Oficial Mexicana (NOM-036-1-STPS-2018) la cual establece los elementos para identificar, analizar, prevenir y controlar los factores de riesgo ergonómico en los centros de trabajo derivados del manejo manual de cargas, a efecto de prevenir alteraciones a la salud de los trabajadores, y aplica en los centros de trabajo donde existan trabajadores cuya actividad implique realizar manejo manual de cargas de forma cotidiana (más de una vez al día); así mismo el 19 diciembre de 2024 se publicó una reforma a la Ley Federal del Trabajo por el Congreso de la Unión, conocida como la “Ley Silla” y el 17 de julio de 2025, la STPS emitió las “Disposiciones sobre los factores de riesgos de trabajo para garantizar el derecho al descanso de las personas trabajadoras en bipedestación”.</p>

            <p>En este contexto, la magnitud de los TME como problema de salud laboral y el marco normativo descrito sustentan la necesidad de identificar y evaluar los factores de riesgo ergonómico presentes en los centros de trabajo. El presente informe se realizó en <font color="#000000" style="background-color: rgb(255, 255, 0);">el/la INSTALACION, durante el mes de XX del AÑO</font>, donde se describen los resultados y evidencias obtenidas de la identificación del peligro y riesgo ergonómico mediante el uso de las fichas de la ISO-TR 12295-2014 y los criterios establecidos en la NOM-036-1-STPS-2018 (Reconocimiento), así como la valoración de los factores de riesgo ergonómico en las tareas y/o puestos de trabajo (categorías), mediante el uso de diferentes metodologías ergonómicas validadas a nivel internacional, que permiten al empleador cuantificar el riesgo ergonómico en el centro de trabajo y tomar las medidas de intervención o recomendaciones incluidas y acordes con las actividades o tareas que realiza el personal, para mantener una condición de trabajo óptima, que permita reducir la sobrecarga física, proteger la salud músculoesquelética y mejorar la productividad de los trabajadores.</p>

            <p><sup>1</sup> World Health Organization. (2022, 14 de julio). <em>Musculoskeletal health</em>. <a href="https://www.who.int/news-room/fact-sheets/detail/musculoskeletal-conditions" target="_blank">https://www.who.int/news-room/fact-sheets/detail/musculoskeletal-conditions</a></p>

            <p><sup>2</sup> World Health Organization, &amp; International Labour Organization. (2021). <em>WHO/ILO joint estimates of the work-related burden of disease and injury, 2000–2016: Global monitoring report</em>. World Health Organization.</p>

            <p><a href="https://iris.who.int/bitstream/handle/10665/345242/9789240034945-eng.pdf" target="_blank">https://iris.who.int/bitstream/handle/10665/345242/9789240034945-eng.pdf</a></p>

            <p><sup>3</sup> <a href="https://www.imss.gob.mx/conoce-al-imss/memoria-estadistica-2025" target="_blank">IMSS — Memoria Estadística 2025</a>. Selecciona “Capítulo VII. Salud en el Trabajo – (VII.28)”.</p>`
                );

            }




            
          if (response.INFORME_OBJETIVOGENERALES &&
                response.INFORME_OBJETIVOGENERALES.trim() != '') {
                $('#INFORME_OBJETIVOGENERALES').val(response.INFORME_OBJETIVOGENERALES);
            } else {
                $('#INFORME_OBJETIVOGENERALES')
                    .val(`Evaluar los factores de riesgo ergonómico de las actividades o tareas laborales que impliquen postura, movimientos repetitivos, manipulación manual de cargas y fuerza manual, mediante el análisis biomecánico y la aplicación de métodos ergonómicos para la evaluación de la carga física, con el fin de prevenir los trastornos músculo esqueléticos de origen laboral.Evaluar los factores de riesgo ergonómicos de las actividades laborales que impliquen postura, movimientos repetitivos, manipulación manual de cargas y fuerza manual, mediante el análisis biomecánico y aplicación de métodos de carga física para la prevención de trastornos músculo esqueléticos de origen laboral.`);
            }



            if (response.INFORME_OBJETIVOSESPECIFICOS &&
                response.INFORME_OBJETIVOSESPECIFICOS.trim() != '') {
                $('#INFORME_OBJETIVOSESPECIFICOS').val(response.INFORME_OBJETIVOSESPECIFICOS);
            } else {
                $('#INFORME_OBJETIVOSESPECIFICOS')
                    .val(`•	Realizar las valoraciones ergonómicas con métodos específicos de cuantificación del riesgo, a partir de la identificación de peligros y valoración del riesgo ergonómico, conforme a lo establecido en la ISO TR 12295:2014 y en la NOM-036-1-STPS-2018.

•   Determinar el nivel de riesgo por carga física a la cual se encuentran expuestos los trabajadores mediante el analisis  y evaluación de las actividades o tareas que ejecutan en el centro de trabajo.

•	Estudiar la relación entre las exigencias físicas de las tareas y el riesgo biomecánico de acuerdo con los criterios establecidos en la NOM-036-1-STPS-2018, ISO-TR-12295:2014 y la reforma a la Ley Federal del Trabajo conocida como “Ley Silla”, publicada en el DOF el 19 de diciembre de 2024, que permitan el mejoramiento de las condiciones de trabajo.

•	Generar recomendaciones o medidas de intervención derivadas de la cuantificación del riesgo ergonómico para mitigar la probabilidad de ocurrencia de los Trastornos Músculo Esqueléticos (TME) de origen laboral.`);

            }
            
            



            if (response.INFORME_RECONOCIMIENTO &&
                response.INFORME_RECONOCIMIENTO.trim() != '') {

                $('#INFORME_RECONOCIMIENTO').summernote(
                    'code',
                    response.INFORME_RECONOCIMIENTO
                );

            } else {

                $('#INFORME_RECONOCIMIENTO').summernote(
                    'code',
                    `
                    <p>Mediante la aplicación de la norma  ISO-TR-12295:2014 y los criterios de la NOM-036-1-STPS-2018, se realiza la identificación de peligros y riesgos ergonómicos, a través de la aplicación de las fichas técnicas que permiten hacer una evaluación inicial rápida de los siguientes aspectos de la carga física: levantamiento, transporte, empuje y tracción de cargas, movimientos repetitivos de la extremidad superior, posturas estáticas y dinámicas forzadas, siendo este el punto de partida para el reconocimiento del factor de riesgo ergonómico por exposición a sobrecarga biomecánica. A continuación, se presenta el reconocimiento de los peligros y riesgos ergonómicos detectados,  la aplicación del modelo conceptual de un estudio ergonómico (trabajador; tareas; herramientas/equipo y entorno), en  <font color="#000000" style="background-color: rgb(255, 255, 0);">el/la INSTALACION</font> y el resumen de los seis criterios de la carga física referidos en la ISO-TR-12295:2014, relacionados con los respectivos puestos de trabajo valorados, donde el verde corresponde a un “Riesgo aceptable” y el rojo a un “Riesgo crítico”.</p>`
                );

            }






            
            $('#INFORME_ANALISISRECONOCIMIENTO').val(response.INFORME_ANALISISRECONOCIMIENTO);

            if (response.INFORME_PROCESOINSTALACION &&
                response.INFORME_PROCESOINSTALACION.trim() != '') {
                $('#INFORME_PROCESOINSTALACION').val(response.INFORME_PROCESOINSTALACION);
            } else {
                $('#INFORME_PROCESOINSTALACION').val(`DESCRIPCIONPROCESO`);
            }
           
            if (response.INFORME_ACTIVIDADPRINCIPAL &&
                response.INFORME_ACTIVIDADPRINCIPAL.trim() != '') {
                $('#INFORME_ACTIVIDADPRINCIPAL').val(response.INFORME_ACTIVIDADPRINCIPAL);
            } else {
                $('#INFORME_ACTIVIDADPRINCIPAL').val(`DESCRIPCIONACTIVIDAD`);
            }
		


	        $('#INFORME_ANTROPOMETRICAS').val(response.INFORME_ANTROPOMETRICAS);

            $('#OBSERVACIONES_ESQUELETICAS1').val(response.OBSERVACIONES_ESQUELETICAS1);
	        $('#OBSERVACIONES_ESQUELETICAS2').val(response.OBSERVACIONES_ESQUELETICAS2);
	        $('#OBSERVACIONES_ESQUELETICAS3').val(response.OBSERVACIONES_ESQUELETICAS3);
	        $('#OBSERVACIONES_ESQUELETICAS4').val(response.OBSERVACIONES_ESQUELETICAS4);
	        $('#OBSERVACIONES_ESQUELETICAS5').val(response.OBSERVACIONES_ESQUELETICAS5);
	        $('#OBSERVACIONES_ESQUELETICAS6').val(response.OBSERVACIONES_ESQUELETICAS6);

            $('#SELECT_CONCLUSION').val(response.SELECT_CONCLUSION);
			$('#INFORME_CONCLUSION').val(response.INFORME_CONCLUSION);
			
			$('#INFORME_RESPONSABLE1')
				.val(response.INFORME_RESPONSABLE1);


			$('#INFORME_RESPONSABLE1CARGO')
				.val(response.INFORME_RESPONSABLE1CARGO);



			$('#INFORME_RESPONSABLE2')
				.val(response.INFORME_RESPONSABLE2);



		    $('#INFORME_RESPONSABLE2CARGO')
                .val(response.INFORME_RESPONSABLE2CARGO);
            
            
            $('#INTRODUCCION_GRAFICASNOM036')
                .val(response.INTRODUCCION_GRAFICASNOM036);
            
            
            $('#CONCLUSION_GRAFICASNOM036')
                .val(response.CONCLUSION_GRAFICASNOM036);
            
            
            $('#INTRODUCCION_GRAFICASISO12995')
                .val(response.INTRODUCCION_GRAFICASISO12995);
            
             
            $('#CONCLUSION_GRAFICASISO12995')
                .val(response.CONCLUSION_GRAFICASISO12995);
                    
            
            $('#INFORME_RESPONSABLE1')
                .val(response.INFORME_RESPONSABLE1);


            $('#INFORME_RESPONSABLE1CARGO')
                .val(response.INFORME_RESPONSABLE1CARGO);



        if(response.INFORME_RESPONSABLE1DOCUMENTO)
        {

            var archivo =
                response.INFORME_RESPONSABLE1DOCUMENTO;



            var extension = archivo.substring(
                archivo.lastIndexOf(".")
            );



            var imagenUrl =
                '/mostrarresponsable1freergo/0/' +
                recsensorial +
                extension;

            if ($('#INFORME_RESPONSABLE1DOCUMENTO')
                .data('dropify')) {

                $('#INFORME_RESPONSABLE1DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .destroy();



                $('#INFORME_RESPONSABLE1DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .settings.defaultFile = imagenUrl;



                $('#INFORME_RESPONSABLE1DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .init();

            }
            else {

                $('#INFORME_RESPONSABLE1DOCUMENTO')
                    .attr('data-default-file', imagenUrl);



                $('#INFORME_RESPONSABLE1DOCUMENTO')
                    .dropify({

                    messages: {
                        'default': 'Arrastre la imagen aquí o haga click',
                        'replace': 'Arrastre la imagen o haga clic para reemplazar',
                        'remove': 'Quitar',
                        'error': 'Ooops, ha ocurrido un error.'
                    },

                    error: {
                        'fileSize': 'Demasiado grande ({{ value }} max).',
                        'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                        'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                        'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                        'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                        'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                    }

                });

            }


            $('#INFORME_RESPONSABLE1DOCUMENTO')
                .attr('required', false);

            $("#boton_descargarresponsabledoc1")
                .css('display', 'block');

        }
        else {

            $("#boton_descargarresponsabledoc1")
                .css('display', 'none');

        }



        $('#INFORME_RESPONSABLE2')
            .val(response.INFORME_RESPONSABLE2);


        $('#INFORME_RESPONSABLE2CARGO')
            .val(response.INFORME_RESPONSABLE2CARGO);



        if(response.INFORME_RESPONSABLE2DOCUMENTO)
        {

            var archivo =
                response.INFORME_RESPONSABLE2DOCUMENTO;



            var extension = archivo.substring(
                archivo.lastIndexOf(".")
            );



            var imagenUrl =
                '/mostrarresponsable2freergo/0/' +
                recsensorial +
                extension;



            if ($('#INFORME_RESPONSABLE2DOCUMENTO')
                .data('dropify')) {

                $('#INFORME_RESPONSABLE2DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .destroy();



                $('#INFORME_RESPONSABLE2DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .settings.defaultFile = imagenUrl;



                $('#INFORME_RESPONSABLE2DOCUMENTO')
                    .dropify()
                    .data('dropify')
                    .init();

            }
            else {

                $('#INFORME_RESPONSABLE2DOCUMENTO')
                    .attr('data-default-file', imagenUrl);



                $('#INFORME_RESPONSABLE2DOCUMENTO')
                    .dropify({

                    messages: {
                        'default': 'Arrastre la imagen aquí o haga click',
                        'replace': 'Arrastre la imagen o haga clic para reemplazar',
                        'remove': 'Quitar',
                        'error': 'Ooops, ha ocurrido un error.'
                    },

                    error: {
                        'fileSize': 'Demasiado grande ({{ value }} max).',
                        'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                        'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                        'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                        'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                        'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                    }

                });

            }

            $('#INFORME_RESPONSABLE2DOCUMENTO')
                .attr('required', false);



            $("#boton_descargarresponsabledoc2")
                .css('display', 'block');

        }
        else {

            $("#boton_descargarresponsabledoc2")
                .css('display', 'none');

        }

        }

    );

}

/////////////// INTRODUCCION  //////////////


$("#form_informe_introduccion").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('RECO_ID', recsensorial);

    $.ajax({

        url: '/guardarIntroduccionFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_introduccion").prop('disabled', true);
            $("#botonguardar_reporte_introduccion").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al guardar'
            });

        },

        complete: function()
        {

            $("#botonguardar_reporte_introduccion").prop('disabled', false);
            $("#botonguardar_reporte_introduccion").html('Guardar introducción <i class="fa fa-save"></i>');
        }
    });

});

/////////////// DEFINICIONES  //////////////


$("#form_informe_listadefiniciones").on("submit", function(e)
{
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('RECO_ID', recsensorial);

    $.ajax({

        url: '/guardarDefinicionesFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_definiciones").prop('disabled', true);
            $("#botonguardar_reporte_definiciones").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });

        },
        error: function(xhr)
        {
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al guardar'
            });

        },

        complete: function()
        {
            $("#botonguardar_reporte_definiciones").prop('disabled', false);
            $("#botonguardar_reporte_definiciones").html('Guardar definiciones <i class="fa fa-save"></i>');
        }
    });
});


function cargarDefinicionesFreErgo()
{

    $.get(
        '/obtenerDefinicionesFreErgo/' + recsensorial,

        function(response)
        {  
            $('input[name="DEFINICONES_INFORME[]"]').prop('checked', false);
            response.forEach(function(item)
            {
                $('input[name="DEFINICONES_INFORME[]"][value="' + item.CATALOGO_DEFINICIONES_ID + '"]').prop('checked', true);
            });
        }
    );
}



/////////////// OBJETIVOS GENERALES Y ESPECIFICOS   //////////////


$("#form_informe_objetivogeneral").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID', recsensorial);

    $.ajax({
        url: '/guardarObjetivoGeneralFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_objetivogeneral").prop('disabled', true);
            $("#botonguardar_reporte_objetivogeneral").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_objetivogeneral").prop('disabled', false);
            $("#botonguardar_reporte_objetivogeneral").html('Guardar objetivo general <i class="fa fa-save"></i>');
        }
    });
});


$("#form_informe_objetivoespecifico").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID', recsensorial);

    $.ajax({
        url: '/guardarObjetivoEspecificoFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_objetivoespecifico").prop('disabled', true);
            $("#botonguardar_reporte_objetivoespecifico").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_objetivoespecifico").prop('disabled', false);
            $("#botonguardar_reporte_objetivoespecifico").html('Guardar objetivos específicos <i class="fa fa-save"></i>');
        }
    });
});

/////////////// RECONOCIMIENTO   //////////////

$("#form_informe_reconocimiento").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID', recsensorial);

    $.ajax({
        url: '/guardarReconocimientoFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_reconocimiento").prop('disabled', true);
            $("#botonguardar_reporte_reconocimiento").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_reconocimiento").prop('disabled', false);
            $("#botonguardar_reporte_reconocimiento").html('Guardar reconocimiento <i class="fa fa-save"></i>');
        }
    });
});


$("#form_informe_analisisreconocimiento").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID', recsensorial);

    $.ajax({
        url: '/guardarAnalisisRecoFreErgo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_analisisreconocimiento").prop('disabled', true);
            $("#botonguardar_reporte_analisisreconocimiento").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_analisisreconocimiento").prop('disabled', false);
            $("#botonguardar_reporte_analisisreconocimiento").html('Guardar análisis <i class="fa fa-save"></i>');
        }
    });
});


////// MAPA DE RIESGO


function cargarMapaPeligros()
{
    $.get(
        '/getMapaPeligros/' + recsensorial,
        function (response)
        {
            generarTablaMapaPeligros(response);
        }
    );
}



function generarTablaMapaPeligros(response)
{

    $('#TABLE_MAPEOPELIGRO').empty();

    let fichas = response.fichas;
    let criterios = response.criterios;


    let html = `

        <div style="width:100%; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:center; font-size:16px; border:3px solid #0B2C6B;">
                <thead>
                    <tr>
                        <th
                            colspan="${fichas.length + 1}"
                            style="
                                background:#FFF;
                                font-size:32px;
                                font-weight:bold;
                                text-align:center;
                                padding:12px;
                                border:3px solid #0B2C6B;">
                            MAPA DE RECONOCIMIENTO
                        </th>
                    </tr>
                    <tr>
                        <th
                            rowspan="2"
                            style="
                                width:450px;
                                text-align:center;
                                vertical-align:middle;
                                padding:10px;
                                font-size:20px;
                                font-weight:bold;
                                border:2px solid #000;">
                            Criterios de carga física
                        </th>
                        <th
                            colspan="${fichas.length}"
                            style="
                                text-align:center;
                                vertical-align:middle;
                                font-size:20px;
                                font-weight:bold;
                                border:2px solid #000;">
                            Personas evaluadas
                        </th>
                    </tr>
                    <tr>
    `;



    fichas.forEach(function (ficha)
    {
        html += `
            <th
                style="
                    width:60px;
                    padding:8px;
                    text-align:center;
                    vertical-align:middle;
                    font-size:20px;
                    font-weight:bold;
                    border:2px solid #000;">
                ${ficha.PE_EVALUADAS || '-'}
            </th>
        `;
    });



    html += `
                    </tr>
                </thead>
                <tbody>
    `;



    criterios.forEach(function (criterio)
    {

        html += `
            <tr>
                <td
                    style="
                        text-align:left;
                        padding:10px;
                        font-size:18px;
                        border:2px solid #000;">
                    ${criterio.titulo}
                </td>
        `;



        fichas.forEach(function (ficha)
        {

            let resultado =
                criterio.resultados[ficha.ID_FICHAS_TECNICAS];

            let color = '#28a745';

            if (resultado === 'ROJO')
            {
                color = '#dc3545';
            }

            html += `
                <td
                    style="
                        background:${color};
                        height:55px;
                        border:2px solid #000;">
                </td>
            `;
        });



        html += `
            </tr>
        `;
    });



    html += `
                </tbody>
            </table>
        </div>
    `;

    $('#TABLE_MAPEOPELIGRO').html(html);

}


/////////////// DESCRIPCION DEL PROCESO DE LA INSTALACION   //////////////


$("#form_reporte_procesoinstalacion").on(
    "submit",
    function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarProcesoInstalacionFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_procesoinstalacion").prop('disabled', true);
            $("#botonguardar_reporte_procesoinstalacion").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },
        complete: function()
        {
            $("#botonguardar_reporte_procesoinstalacion").prop('disabled', false);
            $("#botonguardar_reporte_procesoinstalacion").html('Guardar proceso instalación <i class="fa fa-save"></i>');
        }
    });
});

/////////////// CICLO   //////////////


$("#form_informe_ciclos").on(
    "submit",
    function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarCicloFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_ciclos").prop('disabled', true);
            $("#botonguardar_reporte_ciclos").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },
        complete: function()
        {
            $("#botonguardar_reporte_ciclos").prop('disabled', false);
            $("#botonguardar_reporte_ciclos").html('Guardar ciclo <i class="fa fa-save"></i>');
        }
    });
});


function mostrartablaactividadesfre() {
    try {

        if (datatableTablaActividadesFre !== null) {
            datatableTablaActividadesFre.ajax.reload();
            return;
        }

        datatableTablaActividadesFre = $('#TablaActividadesFre').DataTable({
            "ajax": {
                "url": "/TablaActividadesFre",
                "type": "GET",
                "cache": false,
                "dataSrc": "data",

                "data": function (data) {
                    data.ergoid = recsensorial;
                },

                "error": function (xhr, error, code) {
                    console.error(
                        "Error en TablaActividadesFre:",
                        xhr.responseJSON || xhr.responseText
                    );
                }
            },

            "columns": [
                {
                    "data": "CATEGORIA",
					"defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "TURNO",
					"defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "ACTIVIDAD",
					"defaultContent": "-",
                },
                {
                    "data": "TAREA",
					"defaultContent": "-",
                },
                {
                    "data": "DURACION",
					"defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "FRECUENCIA",
					"defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "NUMERO_VECES",
					"defaultContent": "-",
                    "className": "text-center"
                }
            ],

            "columnDefs": [
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": $.fn.dataTable.render.text()
                }
            ],

            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "Todos"]
            ],
			 rowsGroup: [0,1,2,4,5,6], //agrupar filas
            "pageLength": 20,
            "ordering": false,
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,

            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron registros",
                "info": "Página _PAGE_ de _PAGES_ (Total _TOTAL_ registros)",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "emptyTable": "No hay datos disponibles en la tabla",
                "loadingRecords": "Cargando datos...",
                "processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

    } catch (exception) {
        console.error("Error en TablaActividadesFre:", exception);
    }
}


/// ANTROPOMETRICAS


function mostrartablaimcfre() {
    try {
        if (datatableTablaImcFre !== null) {
            datatableTablaImcFre.ajax.reload();
            return;
        }

        datatableTablaImcFre = $('#TablaImcFre').DataTable({
            "ajax": {
                "url": "/TablaImcFre",
                "type": "GET",
                "cache": false,
                "dataSrc": "data",

                "data": function (data) {
                    data.ergoid = recsensorial;
                },

                "error": function (xhr, error, code) {
                    console.error(
                        "Error en TablaImcFre:",
                        xhr.responseJSON || xhr.responseText
                    );
                }
            },

            "columns": [
                {
                    "data": "NUMERO",
                    "className": "text-center"
                },
                  {
                    "data": "EMPLEADO",
                    "defaultContent": "-"
                },
                {
                    "data": "CATEGORIA",
                    "defaultContent": "-"
                },
              
                {
                    "data": "AREA",
                    "defaultContent": "-"
                },
                {
                    "data": "ESTATURA",
                    "defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "PESO",
                    "defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "IMC",
                    "defaultContent": "-",
                    "className": "text-center"
                },
                {
                    "data": "INTERPRETACION",
                    "defaultContent": "-",
                    "className": "text-center"
                }
            ],

            "columnDefs": [
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": $.fn.dataTable.render.text()
                }
            ],

            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "Todos"]
            ],

            "pageLength": 20,
            "ordering": false,
            "processing": true,
            "serverSide": false,
            "responsive": true,
            "autoWidth": false,

            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron registros",
                "info": "Página _PAGE_ de _PAGES_ (Total _TOTAL_ registros)",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "emptyTable": "No hay datos disponibles en la tabla",
                "loadingRecords": "Cargando datos...",
                "processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

    } catch (exception) {
        console.error("Error en TablaImcFre:", exception);
    }
}



$("#form_informe_antropometricas").on("submit",function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarAntopometricasFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_antropometricas").prop('disabled', true);
            $("#botonguardar_reporte_antropometricas").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },
        complete: function()
        {
            $("#botonguardar_reporte_antropometricas").prop('disabled', false);
            $("#botonguardar_reporte_antropometricas").html('Guardar antropométricas <i class="fa fa-save"></i>');
        }
    });
    });



/// MUSCULO ESQUELETICO

$("#form_informe_esqueletico").on("submit",function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarMusculoFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_esqueletico").prop('disabled', true);
            $("#botonguardar_reporte_esqueletico").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },
        complete: function()
        {
            $("#botonguardar_reporte_esqueletico").prop('disabled', false);
            $("#botonguardar_reporte_esqueletico").html('Guardar músculo esqueléticos <i class="fa fa-save"></i>');
        }
    });
});


/// METODOS



function cargarMetodosFre() {

    try {

        if (typeof recsensorial === 'undefined' || !recsensorial || !Number.isInteger(Number(recsensorial)) || Number(recsensorial) < 1)
        {

            $('#contenedorMetodosFre').html( '<p class="text-muted">No se ha seleccionado un reconocimiento.</p>');

            return;
        }

        $('#contenedorMetodosFre').html('<p class="text-muted">Cargando metodologías...</p>');

        $.ajax({

            url: '/ObtenerMetodosFre',
            type: 'GET',
            dataType: 'json',
            cache: false,

            data: {
                ergoid: recsensorial
            },

            success: function (respuesta) {

                const contenedor = $('#contenedorMetodosFre');

                contenedor.empty();

                if (!respuesta.success) {

                    contenedor.append($('<p>').addClass('text-muted').text('No fue posible obtener la información de las metodologías.'));

                    return;
                }
                if (respuesta.aplica_metodos === false) {

                    const nota = $('<p>').addClass('metodo-fre-nota').text(respuesta.nota);
                    contenedor.append(nota);

                    return;
                }

                if (!Array.isArray(respuesta.data) || respuesta.data.length === 0)
                {

                    contenedor.append($('<p>').addClass('text-muted').text('No hay metodologías registradas para este reconocimiento.'));

                    return;
                }

                respuesta.data.forEach(function (metodo) {

                    const tarjeta = $('<div>').addClass('metodo-fre-descripcion');
                    const titulo = $('<h5>').addClass('metodo-fre-titulo').text(metodo.NOMBRE);
                    const nombreIngles = $('<p>').addClass('metodo-fre-nombre-ingles').text(metodo.NOMBRE_INGLES);
                    const nombreEspanol = $('<p>').addClass('metodo-fre-nombre-espanol').text('Nombre en español: ' + metodo.NOMBRE_ESPANOL);
                    const descripcion = $('<p>').addClass('metodo-fre-texto').text(metodo.DESCRIPCION);

                    tarjeta.append(titulo);
                    tarjeta.append(nombreIngles);
                    tarjeta.append(nombreEspanol);
                    tarjeta.append(descripcion);

                    contenedor.append(tarjeta);

                });

            },

            error: function (xhr, error, code) {

                console.error(
                    'Error al consultar las metodologías FRE:',
                    xhr.responseJSON || xhr.responseText
                );

                $('#contenedorMetodosFre').empty().append($('<p>').addClass('text-danger').text('No fue posible cargar las metodologías.'));

            }

        });

    } catch (exception) {

        console.error('Error en cargarMetodosFre:',exception);

    }

}


/// CATEGORIAS EVALUADAS



function tablaReporteTrabajadoresErgo() {

    try {

        var ruta = "/tablaReporteTrabajadoresErgo";

        if ($.fn.DataTable.isDataTable('#tabla_reporte_trabajadores_ergo'))
        {
            $('#tabla_reporte_trabajadores_ergo').DataTable().clear().destroy();
            $('#tabla_reporte_trabajadores_ergo tbody').empty();
        }

        tabla_reporte_trabajadores_ergo =  $('#tabla_reporte_trabajadores_ergo').DataTable({

                ajax: {
                    url: ruta,
                    type: "GET",
                    cache: false,
                    data: {ergoid: recsensorial},
                dataSrc: function (json) {
                        
                        return json.data || [];
                    },

                    error: function (xhr, error, thrown) {
                        console.error('Error al cargar trabajadores evaluados:',xhr.responseText || error || thrown);
                    }
                },

                columns: [
                    {
                        data: "AREA",
                        defaultContent: "-"
                    },
                    {
                        data: "CATEGORIA",
                        defaultContent: "-"
                    },
                    {
                        data: "TRABAJADORES_EVALUADOS",
                        defaultContent: ""
                    }
                ],

                paging: false,
                searching: false,
                info: false,
                ordering: false,
                processing: true,
                responsive: false,
                autoWidth: false,
                columnDefs: [
                    {
                        targets: [0, 1, 2],
                        className: "text-center align-middle"
                    }
                ],

                drawCallback: function () {

                    var api = this.api();

                    var filas = api.rows({
                        page: 'current'
                    }).nodes().toArray();

                    var datos = api.rows({
                        page: 'current'
                    }).data().toArray();

                    if (datos.length === 0) {
                        return;
                    }

                    var grupos = [];
                    var grupoActual = null;

                    datos.forEach(function (fila, i) {

                        var nombreArea = String(fila.AREA ?? '').trim();

                        if (grupoActual === null || grupoActual.area !== nombreArea)
                        {
                            grupoActual = {
                                area: nombreArea,
                                filas: [],
                                total: ''
                            };

                            grupos.push(grupoActual);
                        }

                        grupoActual.filas.push({
                            datos: fila,
                            nodo: filas[i]
                        });

                        var valorTotal = fila.TRABAJADORES_EVALUADOS;

                        if (grupoActual.total === '' && valorTotal !== null && valorTotal !== undefined && String(valorTotal).trim() !== '')
                        {
                            grupoActual.total = valorTotal;
                        }
                    });

                    grupos.forEach(function (grupo) {

                        if (grupo.filas.length === 0) {
                            return;
                        }

                        var primeraFila = grupo.filas[0].nodo;

                        var celdaArea = $(primeraFila).children('td').eq(0);
                        var celdaTotal = $(primeraFila).children('td').eq(2);

                        celdaArea.text(grupo.area || '-').attr('rowspan', grupo.filas.length).css('vertical-align', 'middle');
                        celdaTotal.text(grupo.total !== ''? grupo.total : '0').attr('rowspan', grupo.filas.length).css('vertical-align', 'middle');

                        for (var i = 1; i < grupo.filas.length; i++)
                        {

                            var filaHTML = $(grupo.filas[i].nodo);
                            filaHTML.children('td').eq(2).remove();
                            filaHTML.children('td').eq(0).remove();
                        }
                    });

                },

                language: {
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron registros",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros",
                    infoFiltered: "(Filtrado de _MAX_ registros)",
                    emptyTable: "No hay datos disponibles en la tabla",
                    loadingRecords: "Cargando...",
                    "processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

    } catch (exception) {

        console.error("Error en tablaReporteTrabajadoresErgo:",exception);
    }
}   

/// CONCLUSION

$('#SELECT_CONCLUSION').on('change', function () {
    var selectedOption = $(this).find('option:selected');
    var conclusion = selectedOption.data('conclusion');
    $('#INFORME_CONCLUSION').val(conclusion);
});


$("#form_informe_conclusiones").on(
    "submit",
    function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarConclusionFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_conclusion").prop('disabled', true);
            $("#botonguardar_reporte_conclusion").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_conclusion").prop('disabled', false);
            $("#botonguardar_reporte_conclusion").html('Guardar conclusión <i class="fa fa-save"></i>');
        }
    });
    });


    ///// RECOMENDACIONES



// ACTIVAR O DESACTIVAR RECOMENDACION DEL CATALOGO

$(document).on('change', '.recomendacion_checkbox', function () {

    let fila = $(this).closest('tr');
    let descripcion = fila.find('.descripcion-recomendacion');

    if ($(this).is(':checked')) {

        descripcion.prop('disabled', false);

    } else {

        descripcion.prop('disabled', true);

    }

});


// AGREGAR NUEVA RECOMENDACION

$('#agregar_recomendacion_manual').on('click', function () {

    let fila = `
        <tr class="fila-recomendacion recomendacion-manual">

            <td>
                <input type="text"
                       class="form-control tipo-recomendacion"
                       placeholder="Tipo de recomendación">
            </td>

            <td>
                <textarea
                    class="form-control descripcion-recomendacion"
                    rows="3"
                    placeholder="Escribe la recomendación..."></textarea>
            </td>

            <td class="text-center">

                <span class="badge badge-success">
                    Nueva
                </span>

            </td>

            <td class="text-center">

                <button type="button"
                        class="btn btn-danger btn-sm eliminar-recomendacion">

                    <i class="fa fa-trash"></i>

                </button>

            </td>

        </tr>
    `;

    $('#tbody_recomendaciones').append(fila);

});


// ELIMINAR RECOMENDACION MANUAL

$(document).on('click', '.eliminar-recomendacion', function () {

    $(this).closest('tr').remove();

});




$("#form_informe_listarecomendaciones").on("submit", function(e) {

    e.preventDefault();

    let recomendaciones = [];

    $('#tbody_recomendaciones .catalogo-recomendacion').each(function() {

        let fila = $(this);

        if (fila.find('.recomendacion_checkbox').is(':checked')) {

            recomendaciones.push({
                catalogo_id: fila.attr('data-catalogo'),
                descripcion: fila.find('.descripcion-recomendacion').val(),
                tipo: fila.find('td:first').text().trim()
            });
        }

    });


    $('#tbody_recomendaciones .recomendacion-manual').each(function() {
        let fila = $(this);
        let descripcion = fila.find('.descripcion-recomendacion').val().trim();
        let tipo = fila.find('.tipo-recomendacion').val().trim();
        if (descripcion !== '') {

            recomendaciones.push({
                catalogo_id: 0,
                descripcion: descripcion,
                tipo: tipo
            });
        }
    });


    let formData = new FormData();
    formData.append('RECO_ID', recsensorial);
    formData.append('RECOMENDACIONES', JSON.stringify(recomendaciones));


    $.ajax({

        url: '/guardarRecomendacionesInformeFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function() {
            $("#botonguardar_reporte_recomendaciones").prop('disabled', true);
            $("#botonguardar_reporte_recomendaciones").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');

        },

        success: function(response) {

            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false

            });

            cargarRecomendacionesInformeFreErgo();

        },

        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.msj || 'No fue posible guardar las recomendaciones.'

            });

        },

        complete: function() {
            $("#botonguardar_reporte_recomendaciones").prop('disabled', false);
            $("#botonguardar_reporte_recomendaciones").html('Guardar recomendaciones <i class="fa fa-save"></i>');

        }

    });

});




function cargarRecomendacionesInformeFreErgo()
{

    $.get(
        '/obtenerRecomendacionesInformeFreErgo/' + recsensorial,

        function(response)
        {
            $('#tbody_recomendaciones .catalogo-recomendacion').each(function() {

                let fila = $(this);
                fila.find('.recomendacion_checkbox').prop('checked', false);
                fila.find('.descripcion-recomendacion').prop('disabled', true);

            });

            $('#tbody_recomendaciones .recomendacion-manual').remove();

            response.forEach(function(item)
            {

                let catalogoId = parseInt(item.CATALOGO_RECOMENDACIONES_ID);

            let descripcion = item.DESCRIPCION_PERSONALIZADA ||
                $('#tbody_recomendaciones .catalogo-recomendacion[data-catalogo="' + item.CATALOGO_RECOMENDACIONES_ID + '"]')
                .find('.descripcion-recomendacion').val() || '';
                            

                if (catalogoId > 0) {

                    let fila = $('#tbody_recomendaciones .catalogo-recomendacion[data-catalogo="' + catalogoId + '"]');

                    if (fila.length) {

                        fila.find('.recomendacion_checkbox').prop('checked', true);

                        fila.find('.descripcion-recomendacion')
                            .val(descripcion)
                            .prop('disabled', false);

                    }

                }

                else {

                    let fila = `
                        <tr class="fila-recomendacion recomendacion-manual">

                            <td>
                                <span class="badge badge-info">-</span>
                            </td>

                            <td>
                                <textarea class="form-control descripcion-recomendacion" rows="3" placeholder="Escribe la recomendación...">${$('<div>').text(descripcion).html()}</textarea>
                            </td>

                            <td class="text-center">
                                <span class="badge badge-success">Nueva</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm eliminar-recomendacion">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#tbody_recomendaciones').append(fila);

                }

            });

        }
    );

}

/// RESPONSABLES


$("#form_informe_responsablesinforme").on("submit",function(e)
{

    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarResponsablesInformeFreErgo',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,

        headers: {
            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_responsablesinforme").prop('disabled', true);
            $("#botonguardar_reporte_responsablesinforme").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_responsablesinforme").prop('disabled', false);
            $("#botonguardar_reporte_responsablesinforme").html('Guardar responsables del informe <i class="fa fa-save"></i>');
        }
    });
});



//// METODOS

let selectMetodosFRE;

$(document).ready(function () {

    selectMetodosFRE = $('#CAT_METODOS_FRE').selectize({
        placeholder: 'Seleccione una o varias opciones',
        maxItems: null,
    })[0].selectize;

});


/// METODOS 
$(document).ready(function () {

    function mostrarMetodosSeleccionados() {

        const seleccionados = $('#CAT_METODOS_FRE').val() || [];

        $('#contenedorMetodoOWAS').hide();
        $('#contenedorMetodoROSA').hide();
        $('#contenedorMetodoRULA').hide();
        $('#contenedorMetodoREBA').hide();
        $('#contenedorMetodoMAC').hide();
        $('#contenedorMetodoRAPP').hide();



        if (seleccionados.includes('1')) {
            $('#contenedorMetodoOWAS').show();
        }

        if (seleccionados.includes('2')) {
            $('#contenedorMetodoROSA').show();
        }

        if (seleccionados.includes('3')) {
            $('#contenedorMetodoRULA').show();
        }

        if (seleccionados.includes('4')) {
            $('#contenedorMetodoREBA').show();
        }
          
        if (seleccionados.includes('5')) {
            $('#contenedorMetodoMAC').show();
        }

        if (seleccionados.includes('6')) {
            $('#contenedorMetodoRAPP').show();
        }
    }

    $('#CAT_METODOS_FRE').on('change', function () {
        mostrarMetodosSeleccionados();
    });

    mostrarMetodosSeleccionados();

});


/// OWAS

document.addEventListener('DOMContentLoaded', function () {

    const owasCampos = {
        espalda: document.getElementById('OWAS_ESPALDA'),
        brazos: document.getElementById('OWAS_BRAZOS'),
        piernas: document.getElementById('OWAS_PIERNAS'),
        carga: document.getElementById('OWAS_CARGA')
    };

    const owasCodigos = {
        espalda: document.getElementById('OWAS_COD_ESPALDA'),
        brazos: document.getElementById('OWAS_COD_BRAZOS'),
        piernas: document.getElementById('OWAS_COD_PIERNAS'),
        carga: document.getElementById('OWAS_COD_CARGA')
    };

    const owasCodigoCompleto = document.getElementById('OWAS_CODIGO_COMPLETO');
    const owasCardResultado = document.getElementById('OWAS_CARD_RESULTADO');
    const owasResultadoCategoria = document.getElementById('OWAS_RESULTADO_CATEGORIA');

   
    const tablaOWAS = {
        1: {
            1: {
                1: [1, 1, 1],
                2: [1, 1, 1],
                3: [1, 1, 1],
                4: [2, 2, 2],
                5: [2, 2, 2],
                6: [1, 1, 1],
                7: [1, 1, 1]
            },
            2: {
                1: [1, 1, 1],
                2: [1, 1, 1],
                3: [1, 1, 1],
                4: [2, 2, 2],
                5: [2, 2, 2],
                6: [1, 1, 1],
                7: [1, 1, 1]
            },
            3: {
                1: [1, 1, 1],
                2: [1, 1, 1],
                3: [1, 1, 1],
                4: [2, 2, 3],
                5: [2, 2, 3],
                6: [1, 1, 1],
                7: [1, 1, 2]
            }
        },

        2: {
            1: {
                1: [2, 2, 3],
                2: [2, 2, 3],
                3: [2, 2, 3],
                4: [3, 3, 3],
                5: [3, 3, 3],
                6: [2, 2, 2],
                7: [3, 3, 3]
            },
            2: {
                1: [2, 2, 3],
                2: [2, 2, 3],
                3: [2, 3, 3],
                4: [3, 4, 4],
                5: [3, 4, 3],
                6: [3, 3, 4],
                7: [2, 3, 4]
            },
            3: {
                1: [3, 3, 4],
                2: [2, 2, 3],
                3: [3, 3, 3],
                4: [3, 4, 4],
                5: [4, 4, 4],
                6: [4, 4, 4],
                7: [2, 3, 4]
            }
        },

        3: {
            1: {
                1: [1, 1, 1],
                2: [1, 1, 1],
                3: [1, 1, 2],
                4: [3, 3, 3],
                5: [4, 4, 4],
                6: [1, 1, 1],
                7: [1, 1, 1]
            },
            2: {
                1: [2, 2, 3],
                2: [1, 1, 1],
                3: [1, 1, 2],
                4: [4, 4, 4],
                5: [4, 4, 4],
                6: [3, 3, 3],
                7: [1, 1, 1]
            },
            3: {
                1: [2, 2, 3],
                2: [1, 1, 1],
                3: [2, 3, 3],
                4: [4, 4, 4],
                5: [4, 4, 4],
                6: [4, 4, 4],
                7: [1, 1, 1]
            }
        },

        4: {
            1: {
                1: [2, 3, 3],
                2: [2, 2, 3],
                3: [2, 2, 3],
                4: [4, 4, 4],
                5: [4, 4, 4],
                6: [4, 4, 4],
                7: [2, 3, 4]
            },
            2: {
                1: [3, 3, 4],
                2: [2, 3, 4],
                3: [3, 3, 4],
                4: [4, 4, 4],
                5: [4, 4, 4],
                6: [4, 4, 4],
                7: [2, 3, 4]
            },
            3: {
                1: [4, 4, 4],
                2: [2, 3, 4],
                3: [3, 3, 4],
                4: [4, 4, 4],
                5: [4, 4, 4],
                6: [4, 4, 4],
                7: [2, 3, 4]
            }
        }
    };

   
    const resultadosOWAS = {
        1: {
            efecto: 'Postura normal y natural sin efectos dañinos en el sistema músculo-esquelético.',
            accion: 'No requiere acción.'
        },
        2: {
            efecto: 'Postura con posibilidad de causar daño al sistema músculo-esquelético.',
            accion: 'Se requieren acciones correctivas en un futuro cercano.'
        },
        3: {
            efecto: 'Postura con efectos dañinos sobre el sistema músculo-esquelético.',
            accion: 'Se requieren acciones correctivas lo antes posible.'
        },
        4: {
            efecto: 'La carga causada por esta postura tiene efectos sumamente dañinos sobre el sistema músculo-esquelético.',
            accion: 'Se requieren tomar acciones correctivas inmediatamente.'
        }
    };


    function calcularOWAS() {

        const espalda = owasCampos.espalda.value;
        const brazos = owasCampos.brazos.value;
        const piernas = owasCampos.piernas.value;
        const carga = owasCampos.carga.value;

        owasCodigos.espalda.textContent = espalda || '—';
        owasCodigos.brazos.textContent = brazos || '—';
        owasCodigos.piernas.textContent = piernas || '—';
        owasCodigos.carga.textContent = carga || '—';

        document.querySelectorAll(
            '#OWAS_TABLA_RESULTADOS tbody tr'
        ).forEach(function (fila) {
            fila.classList.remove('owas-fila-seleccionada');
        });

        if (!espalda || !brazos || !piernas || !carga) {
            owasCodigoCompleto.value = '';
            owasCardResultado.style.display = 'none';
            owasResultadoCategoria.textContent = '';
            owasResultadoCategoria.className = 'badge ml-2';

            return;
        }

        owasCodigoCompleto.value =
            String(espalda) +
            String(brazos) +
            String(piernas) +
            String(carga);

        const categoriasPierna =
            tablaOWAS[espalda] &&
            tablaOWAS[espalda][brazos] &&
            tablaOWAS[espalda][brazos][piernas];

        if (!categoriasPierna) {
            owasCardResultado.style.display = 'none';
            console.error('No se encontró la combinación en la tabla OWAS.');
            return;
        }

        const categoria = categoriasPierna[Number(carga) - 1];

        if (!resultadosOWAS[categoria]) {
            owasCardResultado.style.display = 'none';
            console.error('La categoría OWAS obtenida no es válida.');
            return;
        }

        const resultado = resultadosOWAS[categoria];

        owasResultadoCategoria.textContent = categoria;
        owasResultadoCategoria.className =
            'badge ml-2 owas-riesgo-' + categoria;

        const filaResultado = document.getElementById(
            'OWAS_FILA_' + categoria
        );

        if (filaResultado) {
            filaResultado.classList.add('owas-fila-seleccionada');
        }

        owasCardResultado.style.display = 'block';
    }

    Object.values(owasCampos).forEach(function (campo) {
        campo.addEventListener('change', calcularOWAS);
    });

    calcularOWAS();

});

/// ROSA
(function () {

    const contenedor = document.getElementById('contenedorMetodoROSA');

    if (!contenedor || contenedor.dataset.rosaInicializado === '1') {
        return;
    }

    contenedor.dataset.rosaInicializado = '1';

    const matrices = {

        A: [
            [2, 2, 3, 4, 5, 6, 7, 8],
            [2, 2, 3, 4, 5, 6, 7, 8],
            [3, 3, 3, 4, 5, 6, 7, 8],
            [4, 4, 4, 4, 5, 6, 7, 8],
            [5, 5, 5, 5, 6, 7, 8, 9],
            [6, 6, 6, 6, 7, 8, 8, 9],
            [7, 7, 7, 7, 8, 9, 9, 9]
        ],

        B: [
            [1, 1, 1, 2, 3, 4, 5, 6, 6],
            [1, 1, 2, 2, 3, 4, 5, 6, 6],
            [1, 2, 2, 3, 3, 4, 6, 7, 7],
            [2, 2, 3, 3, 4, 5, 6, 8, 8],
            [3, 3, 4, 4, 5, 6, 7, 8, 8],
            [4, 4, 5, 5, 6, 7, 8, 9, 9],
            [5, 5, 6, 7, 8, 8, 9, 9, 9]
        ],

        C: [
            [1, 1, 1, 2, 3, 4, 5],
            [1, 1, 2, 3, 4, 5, 6],
            [2, 3, 3, 3, 5, 6, 7],
            [3, 4, 4, 5, 5, 6, 7],
            [4, 5, 5, 6, 6, 7, 8],
            [5, 6, 6, 7, 7, 8, 8],
            [6, 7, 7, 8, 8, 9, 9],
            [7, 8, 8, 9, 9, 9, 9]
        ],

        D: [
            [1, 2, 3, 4, 5, 6, 7, 8, 9],
            [2, 2, 3, 4, 5, 6, 7, 8, 9],
            [3, 3, 3, 4, 5, 6, 7, 8, 9],
            [4, 4, 4, 4, 5, 6, 7, 8, 9],
            [5, 5, 5, 5, 5, 6, 7, 8, 9],
            [6, 6, 6, 6, 6, 6, 7, 8, 9],
            [7, 7, 7, 7, 7, 7, 7, 8, 9],
            [8, 8, 8, 8, 8, 8, 8, 8, 9],
            [9, 9, 9, 9, 9, 9, 9, 9, 9]
        ],

        E: [
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            [2, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            [3, 3, 3, 4, 5, 6, 7, 8, 9, 10],
            [4, 4, 4, 4, 4, 6, 7, 8, 9, 10],
            [5, 5, 5, 5, 5, 6, 7, 8, 9, 10],
            [6, 6, 6, 6, 6, 6, 7, 8, 9, 10],
            [7, 7, 7, 7, 7, 7, 7, 8, 9, 10],
            [8, 8, 8, 8, 8, 8, 8, 8, 9, 10],
            [9, 9, 9, 9, 9, 9, 9, 9, 9, 10],
            [10, 10, 10, 10, 10, 10, 10, 10, 10, 10]
        ]

    };

    const campos = {
        A1: 'ROSA_ALTURA_ASIENTO',
        A2: 'ROSA_PROFUNDIDAD_ASIENTO',
        A3: 'ROSA_REPOSABRAZOS',
        A4: 'ROSA_RESPALDO',
        B1: 'ROSA_TELEFONO',
        B2: 'ROSA_PANTALLA',
        C1: 'ROSA_RATON',
        C2: 'ROSA_TECLADO'
    };

    const nombres = {
        A1: 'Silla: altura (A-1)',
        A2: 'Silla: profundidad (A-2)',
        A3: 'Silla: reposabrazos (A-3)',
        A4: 'Silla: respaldo (A-4)',
        B1: 'Teléfono (B-1)',
        B2: 'Pantalla (B-2)',
        C1: 'Ratón (C-1)',
        C2: 'Teclado (C-2)'
    };

    function valorCampo(id) {

        const elemento = document.getElementById(id);

        return elemento && elemento.value !== ''
            ? Number(elemento.value)
            : null;

    }

    function adicionales(apartado) {

        return Array.from(
            contenedor.querySelectorAll('.rosa-extra:checked')
        ).filter(c => c.dataset.apartado === apartado);

    }

    function sumaAdicionales(apartado) {

        return adicionales(apartado).reduce((total, checkbox) => {
            return total + Number(checkbox.value || 0);
        }, 0);

    }

    function tiempo(id) {

        const elemento = document.getElementById(id);

        return elemento && elemento.value !== ''
            ? Number(elemento.value)
            : 0;

    }

    function puntuacionApartado(apartado) {

        const base = valorCampo(campos[apartado]);

        if (base === null) {
            return null;
        }

        return Math.max(
            1,
            base + sumaAdicionales(apartado)
        );

    }

    function limitar(valor, minimo, maximo) {

        return Math.max(minimo, Math.min(maximo, valor));

    }

    function buscarMatriz(matriz, fila, columna, inicioFila, inicioColumna) {

        const f = fila - inicioFila;
        const c = columna - inicioColumna;

        if (
            f < 0 ||
            c < 0 ||
            f >= matriz.length ||
            c >= matriz[f].length
        ) {
            return null;
        }

        return matriz[f][c];

    }

    function crearMatriz(id, matriz, tituloFila, columnas, inicioFila, inicioColumna) {

        const tabla = document.getElementById(id);

        if (!tabla) {
            return;
        }

        let html = '<thead><tr><th>' + tituloFila + '</th>';

        columnas.forEach(columna => {
            html += '<th>' + columna + '</th>';
        });

        html += '</tr></thead><tbody>';

        matriz.forEach((fila, indice) => {

            html += '<tr><th>' + (inicioFila + indice) + '</th>';

            fila.forEach((valor, indiceColumna) => {

                html += '<td data-fila="' + (inicioFila + indice) +
                    '" data-columna="' + (inicioColumna + indiceColumna) +
                    '">' + valor + '</td>';

            });

            html += '</tr>';

        });

        html += '</tbody>';

        tabla.innerHTML = html;

    }

    function generarMatrices() {

        crearMatriz(
            'ROSA_MATRIZ_A',
            matrices.A,
            'A-1 + A-2 / A-3 + A-4',
            [2, 3, 4, 5, 6, 7, 8, 9],
            2,
            2
        );

        crearMatriz(
            'ROSA_MATRIZ_B',
            matrices.B,
            'B-1',
            [0, 1, 2, 3, 4, 5, 6, 7, 8],
            0,
            0
        );

        crearMatriz(
            'ROSA_MATRIZ_C',
            matrices.C,
            'C-1',
            [0, 1, 2, 3, 4, 5, 6],
            0,
            0
        );

        crearMatriz(
            'ROSA_MATRIZ_D',
            matrices.D,
            'B',
            [1, 2, 3, 4, 5, 6, 7, 8, 9],
            1,
            1
        );

        crearMatriz(
            'ROSA_MATRIZ_E',
            matrices.E,
            'Combinación',
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            1,
            1
        );

    }

    function marcarCelda(id, fila, columna) {

        const tabla = document.getElementById(id);

        if (!tabla) {
            return;
        }

        tabla.querySelectorAll('.rosa-celda-seleccionada').forEach(celda => {
            celda.classList.remove('rosa-celda-seleccionada');
        });

        const celda = tabla.querySelector(
            'td[data-fila="' + fila + '"][data-columna="' + columna + '"]'
        );

        if (celda) {
            celda.classList.add('rosa-celda-seleccionada');
        }

    }

    function marcarRiesgo(puntuacion) {

        contenedor.querySelectorAll('[data-rosa-rango]').forEach(fila => {
            fila.classList.remove('rosa-seleccionada');
        });

        let rango;

        if (puntuacion === 1) {
            rango = '1';
        } else if (puntuacion >= 2 && puntuacion <= 4) {
            rango = '2-4';
        } else if (puntuacion === 5) {
            rango = '5';
        } else if (puntuacion >= 6 && puntuacion <= 8) {
            rango = '6-8';
        } else {
            rango = '9-10';
        }

        const fila = contenedor.querySelector(
            '[data-rosa-rango="' + rango + '"]'
        );

        if (fila) {
            fila.classList.add('rosa-seleccionada');
        }

        const puntuacionElemento =
            document.getElementById('ROSA_PUNTUACION_FINAL');

        const riesgoElemento =
            document.getElementById('ROSA_RIESGO_FINAL');

        if (puntuacionElemento) {
            puntuacionElemento.textContent = puntuacion;
        }

        if (riesgoElemento) {

            const interpretaciones = {
                '1': 'Riesgo inapreciable — Nivel 0. No es necesaria actuación.',
                '2-4': 'Riesgo mejorable — Nivel 1. Pueden mejorarse algunos elementos del puesto.',
                '5': 'Riesgo alto — Nivel 2. Es necesaria la actuación.',
                '6-8': 'Riesgo muy alto — Nivel 3. Es necesaria la actuación cuanto antes.',
                '9-10': 'Riesgo extremo — Nivel 4. Es necesaria la actuación urgentemente.'
            };

            riesgoElemento.textContent = interpretaciones[rango] || '';

        }

    }

    function calcularROSA() {

        const valores = {};

        Object.keys(campos).forEach(apartado => {
            valores[apartado] = puntuacionApartado(apartado);
        });

        const tiempoA = tiempo('ROSA_TIEMPO_A');
        const tiempoB1 = tiempo('ROSA_TIEMPO_B1');
        const tiempoB2 = tiempo('ROSA_TIEMPO_B2');
        const tiempoC1 = tiempo('ROSA_TIEMPO_C1');
        const tiempoC2 = tiempo('ROSA_TIEMPO_C2');

        const completosA =
            valores.A1 !== null &&
            valores.A2 !== null &&
            valores.A3 !== null &&
            valores.A4 !== null;

        const completosB =
            valores.B1 !== null &&
            valores.B2 !== null;

        const completosC =
            valores.C1 !== null &&
            valores.C2 !== null;

        let resultadoA = null;
        let resultadoB = null;
        let resultadoC = null;
        let resultadoD = null;
        let resultadoE = null;

        if (completosA) {

            const asiento = limitar(
                valores.A1 + valores.A2,
                2,
                8
            );

            const reposabrazosRespaldo = limitar(
                valores.A3 + valores.A4,
                2,
                9
            );

            resultadoA = buscarMatriz(
                matrices.A,
                asiento,
                reposabrazosRespaldo,
                2,
                2
            );

            if (resultadoA !== null) {
                resultadoA = limitar(resultadoA + tiempoA, 1, 10);
            }

            marcarCelda(
                'ROSA_MATRIZ_A',
                asiento,
                reposabrazosRespaldo
            );

        }

        if (completosB) {

            // B-1: el tiempo de uso solo modifica la puntuación del teléfono.
            const telefono = limitar(
                valores.B1 + sumaAdicionales('B1') + tiempoB1,
                0,
                matrices.B.length - 1
            );

            // B-2: el tiempo de uso solo modifica la puntuación de la pantalla.
            const pantalla = limitar(
                valores.B2 + sumaAdicionales('B2') + tiempoB2,
                0,
                matrices.B[0].length - 1
            );

            resultadoB = buscarMatriz(
                matrices.B,
                telefono,
                pantalla,
                0,
                0
            );

            marcarCelda(
                'ROSA_MATRIZ_B',
                telefono,
                pantalla
            );

        } else {

            const tablaB = document.getElementById('ROSA_MATRIZ_B');

            if (tablaB) {
                tablaB.querySelectorAll('.rosa-celda-seleccionada').forEach(celda => {
                    celda.classList.remove('rosa-celda-seleccionada');
                });
            }

        }

        if (completosC) {

            const raton = limitar(
                valores.C1 + sumaAdicionales('C1') + tiempoC1,
                0,
                7
            );

            const teclado = limitar(
                valores.C2 + sumaAdicionales('C2') + tiempoC2,
                0,
                6
            );

            resultadoC = buscarMatriz(
                matrices.C,
                raton,
                teclado,
                0,
                0
            );

            marcarCelda(
                'ROSA_MATRIZ_C',
                raton,
                teclado
            );

        }

        if (resultadoB !== null && resultadoC !== null) {

            resultadoD = buscarMatriz(
                matrices.D,
                resultadoB,
                resultadoC,
                1,
                1
            );

            marcarCelda(
                'ROSA_MATRIZ_D',
                resultadoB,
                resultadoC
            );

        }

        if (resultadoA !== null && resultadoD !== null) {

            resultadoE = buscarMatriz(
                matrices.E,
                resultadoA,
                resultadoD,
                1,
                1
            );

            marcarCelda(
                'ROSA_MATRIZ_E',
                resultadoA,
                resultadoD
            );

        }

        if (resultadoE !== null) {

            marcarRiesgo(resultadoE);

        } else {

            contenedor.querySelectorAll('[data-rosa-rango]').forEach(fila => {
                fila.classList.remove('rosa-seleccionada');
            });

            const puntuacionElemento =
                document.getElementById('ROSA_PUNTUACION_FINAL');

            const riesgoElemento =
                document.getElementById('ROSA_RIESGO_FINAL');

            if (puntuacionElemento) {
                puntuacionElemento.textContent = 'Pendiente';
            }

            if (riesgoElemento) {
                riesgoElemento.textContent =
                    'Completa todos los campos de las secciones A, B y C para obtener la puntuación final.';
            }

        }

        // =====================================================
        // NUEVO: GUARDAR EXTRAS Y RESULTADOS EN ROSA_DATOS_JSON
        // =====================================================

        let rangoRiesgo = null;
        let riesgo = null;
        let nivel = null;
        let actuacion = null;

        if (resultadoE !== null) {

            if (resultadoE === 1) {
                rangoRiesgo = '1';
                riesgo = 'Inapreciable';
                nivel = 0;
                actuacion = 'No es necesaria actuación.';

            } else if (resultadoE >= 2 && resultadoE <= 4) {
                rangoRiesgo = '2-4';
                riesgo = 'Mejorable';
                nivel = 1;
                actuacion = 'Pueden mejorarse algunos elementos del puesto.';

            } else if (resultadoE === 5) {
                rangoRiesgo = '5';
                riesgo = 'Alto';
                nivel = 2;
                actuacion = 'Es necesaria la actuación.';

            } else if (resultadoE >= 6 && resultadoE <= 8) {
                rangoRiesgo = '6-8';
                riesgo = 'Muy alto';
                nivel = 3;
                actuacion = 'Es necesaria la actuación cuanto antes.';

            } else {
                rangoRiesgo = '9-10';
                riesgo = 'Extremo';
                nivel = 4;
                actuacion = 'Es necesaria la actuación urgentemente.';
            }

        }

        const datosROSA = {

            extras: Array.from(
                contenedor.querySelectorAll('.rosa-extra:checked')
            ).map(checkbox => ({
                apartado: checkbox.dataset.apartado,
                valor: Number(checkbox.value),
                texto: checkbox.dataset.texto
            })),

            matrices: {
                matriz_A: resultadoA,
                matriz_B: resultadoB,
                matriz_C: resultadoC,
                matriz_D: resultadoD,
                matriz_E: resultadoE
            },

            resultados: {
                puntuacion_final: resultadoE,
                riesgo: riesgo,
                nivel: nivel,
                actuacion: actuacion
            }

        };

        const campoJSON = document.getElementById('ROSA_DATOS_JSON');

        if (campoJSON) {
            campoJSON.value = JSON.stringify(datosROSA);
        }

    }

    function inicializarEventos() {

        contenedor.querySelectorAll(
            '.rosa-campo, .rosa-extra, .rosa-tiempo'
        ).forEach(elemento => {

            elemento.addEventListener('change', calcularROSA);

        });

    }

    generarMatrices();

    inicializarEventos();

    calcularROSA();

})();

/// RULA
(function() {
    'use strict';

    const contenedor = document.getElementById('contenedorMetodoRULA');

    if (!contenedor || contenedor.dataset.rulaInicializado === '1') {
        return;
    }

    contenedor.dataset.rulaInicializado = '1';

    const obtener = id => contenedor.querySelector('#' + id);

    const idsSelectores = [
        'RULA_BRAZO',
        'RULA_BRAZO_ABDUCIDO',
        'RULA_HOMBRO_ELEVADO',
        'RULA_BRAZO_APOYADO',
        'RULA_ANTEBRAZO',
        'RULA_ANTEBRAZO_PROYECCION',
        'RULA_ANTEBRAZO_CRUZA',
        'RULA_MUNECA',
        'RULA_MUNECA_DESVIACION',
        'RULA_GIRO_MUNECA',
        'RULA_CUELLO',
        'RULA_CUELLO_ROTADO',
        'RULA_CUELLO_LATERAL',
        'RULA_TRONCO',
        'RULA_TRONCO_TORSION',
        'RULA_TRONCO_LATERAL',
        'RULA_PIERNAS',
        'RULA_ACTIVIDAD',
        'RULA_CARGA'
    ];

    const tablaA = {
        '1-1': [1, 2, 2, 2, 2, 3, 3, 3],
        '1-2': [2, 2, 2, 2, 3, 3, 3, 3],
        '1-3': [2, 3, 3, 3, 3, 3, 4, 4],

        '2-1': [2, 3, 3, 3, 3, 4, 4, 4],
        '2-2': [3, 3, 3, 3, 3, 4, 4, 4],
        '2-3': [3, 4, 4, 4, 4, 4, 5, 5],

        '3-1': [3, 3, 4, 4, 4, 4, 5, 5],
        '3-2': [3, 4, 4, 4, 4, 4, 5, 5],
        '3-3': [4, 4, 4, 4, 4, 5, 5, 5],

        '4-1': [4, 4, 4, 4, 4, 5, 5, 5],
        '4-2': [4, 4, 4, 4, 4, 5, 5, 5],
        '4-3': [4, 4, 4, 5, 5, 5, 6, 6],

        '5-1': [5, 5, 5, 5, 5, 6, 6, 7],
        '5-2': [5, 6, 6, 6, 6, 7, 7, 7],
        '5-3': [6, 6, 6, 7, 7, 7, 7, 8],

        '6-1': [7, 7, 7, 7, 7, 8, 8, 9],
        '6-2': [8, 8, 8, 8, 8, 9, 9, 9],
        '6-3': [9, 9, 9, 9, 9, 9, 9, 9]
    };

    const tablaB = {
        1: {
            1: [1, 3],
            2: [2, 3],
            3: [3, 4],
            4: [5, 5],
            5: [6, 6],
            6: [7, 7]
        },
        2: {
            1: [2, 3],
            2: [2, 3],
            3: [4, 5],
            4: [5, 5],
            5: [6, 7],
            6: [7, 7]
        },
        3: {
            1: [3, 3],
            2: [3, 4],
            3: [4, 5],
            4: [5, 6],
            5: [6, 7],
            6: [7, 7]
        },
        4: {
            1: [5, 5],
            2: [5, 6],
            3: [6, 7],
            4: [7, 7],
            5: [7, 7],
            6: [8, 8]
        },
        5: {
            1: [7, 7],
            2: [7, 7],
            3: [7, 8],
            4: [8, 8],
            5: [8, 8],
            6: [8, 8]
        },
        6: {
            1: [8, 8],
            2: [8, 8],
            3: [8, 8],
            4: [8, 9],
            5: [9, 9],
            6: [9, 9]
        }
    };

    const tablaFinal = [
        [1, 2, 3, 3, 4, 5, 5],
        [2, 2, 3, 4, 4, 5, 5],
        [2, 3, 3, 4, 4, 5, 6],
        [3, 3, 3, 4, 5, 6, 6],
        [4, 4, 4, 5, 6, 7, 7],
        [4, 4, 5, 6, 6, 7, 7],
        [5, 5, 5, 6, 7, 7, 7],
        [5, 6, 6, 7, 7, 7, 7]
    ];

    const limitar = (valor, minimo, maximo) =>
        Math.max(minimo, Math.min(maximo, valor));

    function numero(id) {
        const campo = obtener(id);

        if (!campo || campo.value === '') {
            return null;
        }

        const valor = Number(campo.value);

        return Number.isFinite(valor) ? valor : null;
    }

    function adicional(id) {
        const valor = numero(id);
        return valor === null ? 0 : valor;
    }

    function limpiarSeleccion(tabla) {
        if (!tabla) return;

        tabla.querySelectorAll('.rula-celda-seleccionada')
            .forEach(celda => celda.classList.remove('rula-celda-seleccionada'));

        tabla.querySelectorAll('.rula-fila-seleccionada')
            .forEach(fila => fila.classList.remove('rula-fila-seleccionada'));
    }

    function construirTablaA() {
        const tbody = obtener('RULA_TABLA_A').querySelector('tbody');
        tbody.innerHTML = '';

        for (let brazo = 1; brazo <= 6; brazo++) {
            for (let antebrazo = 1; antebrazo <= 3; antebrazo++) {
                const fila = document.createElement('tr');

                fila.dataset.brazo = brazo;
                fila.dataset.antebrazo = antebrazo;

                if (antebrazo === 1) {
                    const celdaBrazo = document.createElement('th');
                    celdaBrazo.rowSpan = 3;
                    celdaBrazo.className = 'rula-fila-azul';
                    celdaBrazo.textContent = brazo;
                    fila.appendChild(celdaBrazo);
                }

                const celdaAntebrazo = document.createElement('th');
                celdaAntebrazo.className = 'rula-fila-azul';
                celdaAntebrazo.textContent = antebrazo;
                fila.appendChild(celdaAntebrazo);

                tablaA[brazo + '-' + antebrazo].forEach((valor, indice) => {
                    const td = document.createElement('td');
                    td.textContent = valor;
                    td.dataset.indice = indice;
                    td.dataset.valor = valor;
                    fila.appendChild(td);
                });

                tbody.appendChild(fila);
            }
        }
    }

    function construirTablaB() {
        const tbody = obtener('RULA_TABLA_B').querySelector('tbody');
        tbody.innerHTML = '';

        for (let cuello = 1; cuello <= 6; cuello++) {
            const fila = document.createElement('tr');
            fila.dataset.cuello = cuello;

            const th = document.createElement('th');
            th.className = 'rula-fila-azul';
            th.textContent = cuello;
            fila.appendChild(th);

            for (let tronco = 1; tronco <= 6; tronco++) {
                for (let piernas = 1; piernas <= 2; piernas++) {
                    const td = document.createElement('td');
                    td.textContent = tablaB[cuello][tronco][piernas - 1];
                    td.dataset.tronco = tronco;
                    td.dataset.piernas = piernas;
                    td.dataset.valor = td.textContent;
                    fila.appendChild(td);
                }
            }

            tbody.appendChild(fila);
        }
    }

    function nivelActuacion(puntuacion) {
        if (puntuacion <= 2) {
            return {
                nivel: 1,
                texto: 'Riesgo aceptable.'
            };
        }

        if (puntuacion <= 4) {
            return {
                nivel: 2,
                texto: 'Pueden requerirse cambios en la tarea; es conveniente profundizar en el estudio.'
            };
        }

        if (puntuacion <= 6) {
            return {
                nivel: 3,
                texto: 'Se requiere el rediseño de la tarea.'
            };
        }

        return {
            nivel: 4,
            texto: 'Se requieren cambios urgentes en la tarea.'
        };
    }

    function actualizarJson(datos) {
        const campo = obtener('RULA_DATOS_JSON');

        if (campo) {
            campo.value = JSON.stringify(datos);
        }
    }

    function calcularRULA() {
        const principales = [
            'RULA_BRAZO',
            'RULA_ANTEBRAZO',
            'RULA_MUNECA',
            'RULA_GIRO_MUNECA',
            'RULA_CUELLO',
            'RULA_TRONCO',
            'RULA_PIERNAS'
        ];

        const completos = principales.every(id => numero(id) !== null);

        contenedor.querySelectorAll('.rula-modificador').forEach(campo => {
            campo.classList.toggle(
                'rula-adicional-activo',
                campo.value !== '' && Number(campo.value) !== 0
            );
        });

        const tablaMatrizA = obtener('RULA_TABLA_A');
        const tablaMatrizB = obtener('RULA_TABLA_B');
        const tablaMatrizFinal = obtener('RULA_TABLA_FINAL');

        limpiarSeleccion(tablaMatrizA);
        limpiarSeleccion(tablaMatrizB);
        limpiarSeleccion(tablaMatrizFinal);

        if (!completos) {
            obtener('RULA_PUNTUACION_A').textContent = '—';
            obtener('RULA_PUNTUACION_B').textContent = '—';
            obtener('RULA_PUNTUACION').textContent = '—';

            obtener('RULA_RESUMEN_FINAL').textContent =
                'Puntuación final: — | Nivel de actuación: —';

            actualizarJson({});
            return;
        }

        const brazoBase = numero('RULA_BRAZO');

        const brazoCalculado = limitar(
            brazoBase +
            adicional('RULA_BRAZO_ABDUCIDO') +
            adicional('RULA_HOMBRO_ELEVADO') +
            adicional('RULA_BRAZO_APOYADO'),
            1,
            6
        );

        const antebrazoBase = numero('RULA_ANTEBRAZO');

        const antebrazoCalculado = limitar(
            antebrazoBase +
            adicional('RULA_ANTEBRAZO_PROYECCION') +
            adicional('RULA_ANTEBRAZO_CRUZA'),
            1,
            3
        );

        const munecaBase = numero('RULA_MUNECA');

        const munecaCalculada = limitar(munecaBase + adicional('RULA_MUNECA_DESVIACION'),1,4);

        const giroMuneca = numero('RULA_GIRO_MUNECA');

        const claveA = brazoCalculado + '-' + antebrazoCalculado;
        const indiceA = ((munecaCalculada - 1) * 2) + (giroMuneca - 1);

        const puntuacionBaseA = tablaA[claveA][indiceA];

        const cuelloBase = numero('RULA_CUELLO');

        const cuelloCalculado = limitar(
            cuelloBase +
            adicional('RULA_CUELLO_ROTADO') +
            adicional('RULA_CUELLO_LATERAL'),
            1,
            6
        );

        const troncoBase = numero('RULA_TRONCO');

        const troncoCalculado = limitar(
            troncoBase +
            adicional('RULA_TRONCO_TORSION') +
            adicional('RULA_TRONCO_LATERAL'),
            1,
            6
        );

        const piernas = numero('RULA_PIERNAS');

        const puntuacionBaseB = tablaB[cuelloCalculado][troncoCalculado][piernas - 1];

        const actividad = adicional('RULA_ACTIVIDAD');
        const carga = adicional('RULA_CARGA');

        const puntuacionA = limitar(
            puntuacionBaseA + actividad + carga,
            1,
            8
        );

        const puntuacionB = limitar(
            puntuacionBaseB + actividad + carga,
            1,
            8
        );

        const filaA = tablaMatrizA.querySelector(
            'tr[data-brazo="' + brazoCalculado +
            '"][data-antebrazo="' + antebrazoCalculado + '"]'
        );

        if (filaA) {
            filaA.classList.add('rula-fila-seleccionada');

            const celdaA = filaA.querySelector(
                'td[data-indice="' + indiceA + '"]'
            );

            if (celdaA) {
                celdaA.classList.add('rula-celda-seleccionada');
            }
        }

        const filaB = tablaMatrizB.querySelector(
            'tr[data-cuello="' + cuelloCalculado + '"]'
        );

        if (filaB) {
            filaB.classList.add('rula-fila-seleccionada');

            const celdaB = filaB.querySelector(
                'td[data-tronco="' + troncoCalculado +
                '"][data-piernas="' + piernas + '"]'
            );

            if (celdaB) {
                celdaB.classList.add('rula-celda-seleccionada');
            }
        }

        const indiceFilaFinal = puntuacionB - 1;
        const indiceColumnaFinal = limitar(puntuacionA, 1, 7) - 1;

        const puntuacionFinal =
            tablaFinal[indiceFilaFinal][indiceColumnaFinal];

        const filaFinal = tablaMatrizFinal.querySelector(
            'tr[data-c="' + puntuacionB + '"]'
        );

        if (filaFinal) {
            filaFinal.classList.add('rula-fila-seleccionada');

            const celdaFinal = filaFinal.querySelector(
                'td[data-d="' + limitar(puntuacionA, 1, 7) + '"]'
            );

            if (celdaFinal) {
                celdaFinal.classList.add('rula-celda-seleccionada');
            }
        }

        obtener('RULA_PUNTUACION_A').textContent = puntuacionA;
        obtener('RULA_PUNTUACION_B').textContent = puntuacionB;
        obtener('RULA_PUNTUACION').textContent = puntuacionFinal;

        const nivel = nivelActuacion(puntuacionFinal);

        obtener('RULA_RESUMEN_FINAL').textContent =
            'Puntuación final: ' + puntuacionFinal +
            ' | Nivel de actuación: ' + nivel.nivel +
            ' | ' + nivel.texto;

        const filasNivel = obtener('RULA_TABLA_NIVEL')
            .querySelectorAll('tbody tr');

        filasNivel.forEach(fila => {
            fila.classList.remove('rula-fila-seleccionada');

            if (Number(fila.dataset.nivel) === nivel.nivel) {
                fila.classList.add('rula-fila-seleccionada');
            }
        });

        actualizarJson({
            puntuacion_base_brazo: brazoBase,
            puntuacion_brazo: brazoCalculado,
            puntuacion_base_antebrazo: antebrazoBase,
            puntuacion_antebrazo: antebrazoCalculado,
            puntuacion_base_muneca: munecaBase,
            puntuacion_muneca: munecaCalculada,
            giro_muneca: giroMuneca,
            puntuacion_base_A: puntuacionBaseA,
            puntuacion_A: puntuacionA,
            puntuacion_base_cuello: cuelloBase,
            puntuacion_cuello: cuelloCalculado,
            puntuacion_base_tronco: troncoBase,
            puntuacion_tronco: troncoCalculado,
            puntuacion_piernas: piernas,
            puntuacion_base_B: puntuacionBaseB,
            puntuacion_B: puntuacionB,
            actividad_muscular: actividad,
            fuerza_carga: carga,
            puntuacion_final: puntuacionFinal,
            nivel_actuacion: nivel.nivel,
            actuacion: nivel.texto
        });
    }

    idsSelectores.forEach(id => {
        const campo = obtener(id);

        if (campo) {
            campo.addEventListener('change', calcularRULA);
            campo.addEventListener('input', calcularRULA);
        }
    });

    construirTablaA();
    construirTablaB();
    calcularRULA();

    window.cargarDatosRULA = function(data) {
        if (!data) return;

        idsSelectores.forEach(id => {
            const campo = obtener(id);

            if (
                campo &&
                data[id] !== undefined &&
                data[id] !== null
            ) {
                campo.value = String(data[id]);
            }
        });

        const analisis = obtener('ANALISIS_METODO_RULA');

        if (
            analisis &&
            data.ANALISIS_METODO_RULA !== undefined &&
            data.ANALISIS_METODO_RULA !== null
        ) {
            analisis.value = data.ANALISIS_METODO_RULA;
        }

        

        calcularRULA();
    };

    

})();

/// REBA
(function () {

    const contenedor = document.getElementById("contenedorMetodoREBA");

    if (!contenedor || contenedor.dataset.rebaInicializado === "1") return;

    contenedor.dataset.rebaInicializado = "1";

   

    const matrizA = [
        [
            [1, 2, 3, 4],
            [1, 2, 3, 4],
            [3, 3, 5, 6]
        ],
        [
            [2, 3, 4, 5],
            [3, 4, 5, 6],
            [4, 5, 6, 7]
        ],
        [
            [2, 4, 5, 6],
            [4, 5, 6, 7],
            [5, 6, 7, 8]
        ],
        [
            [3, 5, 6, 7],
            [5, 6, 7, 8],
            [6, 7, 8, 9]
        ],
        [
            [4, 6, 7, 8],
            [6, 7, 8, 9],
            [7, 8, 9, 9]
        ]
    ];



    const matrizB = [
        [[1, 2, 2], [1, 2, 3]],
        [[1, 2, 3], [2, 3, 4]],
        [[3, 4, 5], [4, 5, 5]],
        [[4, 5, 5], [5, 6, 7]],
        [[6, 7, 8], [7, 8, 8]],
        [[7, 8, 8], [8, 9, 9]]
    ];

    

    const matrizC = [
        [1, 1, 1, 2, 3, 3, 4, 5, 6, 7, 7, 7],
        [1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 7, 8],
        [2, 3, 3, 3, 4, 5, 6, 7, 7, 8, 8, 8],
        [3, 4, 4, 4, 5, 6, 7, 8, 8, 9, 9, 9],
        [4, 4, 4, 5, 6, 7, 8, 8, 9, 9, 9, 9],
        [6, 6, 6, 7, 8, 8, 9, 9, 10, 10, 10, 10],
        [7, 7, 7, 8, 9, 9, 9, 10, 10, 11, 11, 11],
        [8, 8, 8, 9, 10, 10, 10, 10, 10, 11, 11, 11],
        [9, 9, 9, 10, 10, 10, 11, 11, 11, 12, 12, 12],
        [10, 10, 10, 11, 11, 11, 11, 12, 12, 12, 12, 12],
        [11, 11, 11, 11, 12, 12, 12, 12, 12, 12, 12, 12],
        [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12]
    ];



    function generarTablaA() {

        const tabla = document.getElementById("REBA_TABLA_A");

        let html = `
            <thead>
                <tr>
                    <th rowspan="2" class="reba-encabezado-verde">Tronco</th>
                    <th colspan="12" class="reba-encabezado-verde">Cuello</th>
                </tr>
                <tr>
                    <th colspan="4" class="reba-encabezado-verde">1</th>
                    <th colspan="4" class="reba-encabezado-verde">2</th>
                    <th colspan="4" class="reba-encabezado-verde">3</th>
                </tr>
                <tr>
                    <th class="reba-encabezado-azul">Puntuación</th>
                    <th colspan="4" class="reba-encabezado-azul">Piernas</th>
                    <th colspan="4" class="reba-encabezado-azul">Piernas</th>
                    <th colspan="4" class="reba-encabezado-azul">Piernas</th>
                </tr>
                <tr>
                    <th class="reba-encabezado-azul"></th>
                    ${Array(3).fill(
                        [1, 2, 3, 4].map(n =>
                            `<th class="reba-encabezado-azul">${n}</th>`
                        ).join("")
                    ).join("")}
                </tr>
            </thead>
            <tbody>
        `;

        matrizA.forEach((fila, i) => {

            html += `<tr><th class="reba-fila">${i + 1}</th>`;

            fila.forEach((bloque, j) => {

                bloque.forEach((puntuacion, k) => {

                    html += `
                        <td data-reba-a="${i + 1}-${j + 1}-${k + 1}">
                            ${puntuacion}
                        </td>
                    `;

                });

            });

            html += "</tr>";

        });

        tabla.innerHTML = html + "</tbody>";
    }



    function generarTablaB() {

        const tabla = document.getElementById("REBA_TABLA_B");

        let html = `
            <thead>
                <tr>
                    <th rowspan="3" class="reba-encabezado-verde">Brazo</th>
                    <th colspan="6" class="reba-encabezado-verde">Antebrazo</th>
                </tr>
                <tr>
                    <th colspan="3" class="reba-encabezado-verde">1</th>
                    <th colspan="3" class="reba-encabezado-verde">2</th>
                </tr>
                <tr>
                    <th class="reba-encabezado-azul">Muñeca 1</th>
                    <th class="reba-encabezado-azul">Muñeca 2</th>
                    <th class="reba-encabezado-azul">Muñeca 3</th>
                    <th class="reba-encabezado-azul">Muñeca 1</th>
                    <th class="reba-encabezado-azul">Muñeca 2</th>
                    <th class="reba-encabezado-azul">Muñeca 3</th>
                </tr>
            </thead>
            <tbody>
        `;

        matrizB.forEach((fila, i) => {

            html += `<tr><th class="reba-fila">${i + 1}</th>`;

            fila.forEach((bloque, j) => {

                bloque.forEach((puntuacion, k) => {

                    html += `
                        <td data-reba-b="${i + 1}-${j + 1}-${k + 1}">
                            ${puntuacion}
                        </td>
                    `;

                });

            });

            html += "</tr>";

        });

        tabla.innerHTML = html + "</tbody>";
    }



    function generarTablaC() {

        const tabla = document.getElementById("REBA_TABLA_C");

        let html = `
            <thead>
                <tr>
                    <th class="reba-encabezado-verde"></th>
                    <th colspan="12" class="reba-encabezado-verde">Puntuación B</th>
                </tr>
                <tr>
                    <th class="reba-encabezado-azul">Puntuación A</th>
        `;

        for (let i = 1; i <= 12; i++) {
            html += `<th class="reba-encabezado-azul">${i}</th>`;
        }

        html += "</tr></thead><tbody>";

        matrizC.forEach((fila, i) => {

            html += `<tr><th class="reba-fila">${i + 1}</th>`;

            fila.forEach((puntuacion, j) => {

                html += `
                    <td data-reba-c="${i + 1}-${j + 1}">
                        ${puntuacion}
                    </td>
                `;

            });

            html += "</tr>";

        });

        tabla.innerHTML = html + "</tbody>";
    }


    function valor(id) {

        const elemento = document.getElementById(id);

        if (!elemento || elemento.value === "") {
            return null;
        }

        return Number(elemento.value);
    }

    function valorOpcional(id) {

        const resultado = valor(id);

        return resultado === null ? 0 : resultado;
    }


    function obtenerPuntuacionMuneca() {

        const seleccion = document.getElementById("REBA_MUNECA").value;

        if (seleccion === "1_neutra" || seleccion === "1_flexion") {
            return 1;
        }

        if (seleccion === "2") {
            return 2;
        }

        return null;
    }

   

    function obtenerModificacionBrazo() {

        const seleccion = document.getElementById("REBA_BRAZO_MOD").value;

        if (seleccion === "abducido") {
            return 1;
        }

        if (seleccion === "hombro") {
            return 1;
        }

        if (seleccion === "apoyo") {
            return -1;
        }

        return 0;
    }



    function calcularActividadREBA() {

        const seleccion = document.getElementById("REBA_ACTIVIDAD_MUSCULAR").value;

        if (
            seleccion === "estatica" ||
            seleccion === "repetitiva" ||
            seleccion === "inestable"
        ) {
            return 1;
        }

        return 0;
    }


    function mostrar(id, resultado) {

        const elemento = document.getElementById(id);

        if (!elemento) return;

        elemento.textContent =
            resultado === null ? "—" : resultado;
    }



    function limpiarResultados() {

        const resultados = [
            "REBA_RESULTADO_A",
            "REBA_RESULTADO_B",
            "REBA_RESULTADO_C",
            "REBA_RESULTADO_A_FINAL",
            "REBA_RESULTADO_B_FINAL",
            "REBA_PUNTUACION_FINAL"
        ];

        resultados.forEach(id => mostrar(id, null));

        document.getElementById("REBA_RESUMEN_FINAL").textContent =
            "Completa las posiciones corporales para obtener el resultado.";

        contenedor.querySelectorAll(".reba-celda-seleccionada").forEach(celda => {
            celda.classList.remove("reba-celda-seleccionada");
        });

        contenedor.querySelectorAll("#REBA_TABLA_NIVEL tbody tr").forEach(fila => {
            fila.style.outline = "none";
            fila.style.fontWeight = "normal";
        });
    }



    function calcularREBA() {

        const camposObligatorios = [
            "REBA_TRONCO",
            "REBA_CUELLO",
            "REBA_PIERNAS",
            "REBA_BRAZO",
            "REBA_ANTEBRAZO"
        ];

        const incompletos = camposObligatorios.some(id => valor(id) === null);

        if (incompletos || obtenerPuntuacionMuneca() === null) {
            limpiarResultados();
            return;
        }


        const tronco = valor("REBA_TRONCO");
        const cuello = valor("REBA_CUELLO");
        const piernas = valor("REBA_PIERNAS");

        const troncoMod = valorOpcional("REBA_TRONCO_MOD");
        const cuelloMod = valorOpcional("REBA_CUELLO_MOD");
        const rodillas = valorOpcional("REBA_RODILLAS");

        const puntuacionTronco = Math.min(5, tronco + troncoMod);
        const puntuacionCuello = Math.min(3, cuello + cuelloMod);
        const puntuacionPiernas = Math.min(4, piernas + rodillas);

        const puntuacionInicialA =
            matrizA[puntuacionTronco - 1]
                   [puntuacionCuello - 1]
                   [puntuacionPiernas - 1];

        const carga = valorOpcional("REBA_CARGA");
        const fuerzaBrusca = valorOpcional("REBA_FUERZA_BRUSCA");

        const puntuacionA =
            puntuacionInicialA + carga + fuerzaBrusca;


        const brazoBase = valor("REBA_BRAZO");
        const modificacionBrazo = obtenerModificacionBrazo();

        const puntuacionBrazo = Math.min(
            6,
            Math.max(1, brazoBase + modificacionBrazo)
        );

        const antebrazo = valor("REBA_ANTEBRAZO");
        const munecaBase = obtenerPuntuacionMuneca();
        const munecaMod = valorOpcional("REBA_MUNECA_MOD");

        const puntuacionMuneca = Math.min(
            3,
            munecaBase + munecaMod
        );

        const puntuacionInicialB =
            matrizB[puntuacionBrazo - 1]
                   [antebrazo - 1]
                   [puntuacionMuneca - 1];

        const agarre = valorOpcional("REBA_AGARRE");

        const puntuacionB =
            puntuacionInicialB + agarre;


        const puntuacionAjustada = Math.min(12, puntuacionA);
        const puntuacionBAjustada = Math.min(12, puntuacionB);

        const puntuacionC =
            matrizC[puntuacionAjustada - 1]
                   [puntuacionBAjustada - 1];


        const actividadMuscular = calcularActividadREBA();

        const puntuacionFinal =
            puntuacionC + actividadMuscular;


        let nivel;
        let riesgo;
        let actuacion;

        if (puntuacionFinal === 1) {
            nivel = 0;
            riesgo = "Inapreciable";
            actuacion = "No es necesaria actuación.";
        } else if (puntuacionFinal <= 3) {
            nivel = 1;
            riesgo = "Bajo";
            actuacion = "Puede ser necesaria la actuación.";
        } else if (puntuacionFinal <= 7) {
            nivel = 2;
            riesgo = "Medio";
            actuacion = "Es necesaria la actuación.";
        } else if (puntuacionFinal <= 10) {
            nivel = 3;
            riesgo = "Alto";
            actuacion = "Es necesaria la actuación cuanto antes.";
        } else {
            nivel = 4;
            riesgo = "Muy alto";
            actuacion = "Es necesaria la actuación de inmediato.";
        }


        mostrar("REBA_RESULTADO_A", puntuacionInicialA);
        mostrar("REBA_RESULTADO_B", puntuacionInicialB);
        mostrar("REBA_RESULTADO_C", puntuacionC);
        mostrar("REBA_RESULTADO_A_FINAL", puntuacionA);
        mostrar("REBA_RESULTADO_B_FINAL", puntuacionB);
        mostrar("REBA_PUNTUACION_FINAL", puntuacionFinal);

        document.getElementById("REBA_RESUMEN_FINAL").textContent =
            "Puntuación final: " + puntuacionFinal +
            " | Nivel de actuación: " + nivel +
            " | Riesgo: " + riesgo +
            " | " + actuacion;


        contenedor.querySelectorAll("#REBA_TABLA_A td").forEach(celda => {
            celda.classList.remove("reba-celda-seleccionada");
        });

        const celdaA = contenedor.querySelector(
            `[data-reba-a="${puntuacionTronco}-${puntuacionCuello}-${puntuacionPiernas}"]`
        );

        if (celdaA) {
            celdaA.classList.add("reba-celda-seleccionada");
        }


        contenedor.querySelectorAll("#REBA_TABLA_B td").forEach(celda => {
            celda.classList.remove("reba-celda-seleccionada");
        });

        const celdaB = contenedor.querySelector(
            `[data-reba-b="${puntuacionBrazo}-${antebrazo}-${puntuacionMuneca}"]`
        );

        if (celdaB) {
            celdaB.classList.add("reba-celda-seleccionada");
        }


        contenedor.querySelectorAll("#REBA_TABLA_C td").forEach(celda => {
            celda.classList.remove("reba-celda-seleccionada");
        });

        const celdaC = contenedor.querySelector(
            `[data-reba-c="${puntuacionAjustada}-${puntuacionBAjustada}"]`
        );

        if (celdaC) {
            celdaC.classList.add("reba-celda-seleccionada");
        }

        contenedor.querySelectorAll("#REBA_TABLA_NIVEL tbody tr").forEach(fila => {

            fila.style.outline = "none";
            fila.style.fontWeight = "normal";

            if (Number(fila.dataset.rebaNivel) === nivel) {
                fila.style.outline = "2px solid #ff0000";
                fila.style.fontWeight = "bold";
            }

        });

    }

    generarTablaA();
    generarTablaB();
    generarTablaC();


    contenedor.addEventListener("change", function (evento) {

        if (
            evento.target.matches("select") ||
            evento.target.matches('input[type="checkbox"]')
        ) {
            calcularREBA();
        }

    });

    calcularREBA();


    window.calcularREBA = calcularREBA;

})();


/// MAC


(function () {

    const selectoresMAC = [
        {
            select: "MAC_TAREAS_EQUIPO",
            ficha: "fichaMACTareasEquipo"
        },
        {
            select: "MAC_LEVANTAMIENTO_INDIVIDUAL",
            ficha: "fichaMACLevantamiento"
        },
        {
            select: "MAC_TRANSPORTE_CARGA",
            ficha: "fichaMACTransporte"
        }
    ];

    function controlarFichasMAC() {

        selectoresMAC.forEach(function (item) {

            const selector = document.getElementById(item.select);
            const ficha = document.getElementById(item.ficha);

            if (!selector || !ficha) return;

            ficha.style.display = selector.value === "SI" ? "block" : "none";

        });

    }

    selectoresMAC.forEach(function (item) {

        const selector = document.getElementById(item.select);

        if (selector) {
            selector.addEventListener("change", controlarFichasMAC);
        }

    });

    controlarFichasMAC();

    window.controlarFichasMAC = controlarFichasMAC;

})();


// Tareas con operaciones de manejo manual de carga en equipo
(function () {

    const contenedor = document.getElementById("fichaMACTareasEquipo");

    if (!contenedor) return;

    const factores = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K"];

    const puntuaciones = {
        A: {
            A_2_MENOS_35: 0,
            A_3_MENOS_55: 0,
            A_4_MENOS_75: 0,
            A_2_35_65: 4,
            A_3_55_95: 4,
            A_4_75_130: 4,
            A_2_65_85: 6,
            A_3_95_130: 6,
            A_4_130_170: 6,
            A_2_MAS_85: 10,
            A_3_MAS_130: 10,
            A_4_MAS_170: 10
        },
        B: { B_0: 0, B_3: 3, B_6: 6 },
        C: { C_0: 0, C_1: 1, C_3: 3 },
        D: { D_0: 0, D_1: 1, D_2: 2 },
        E: { E_0: 0, E_1: 1, E_3: 3 },
        F: { F_0: 0, F_2: 2, F_4: 4 },
        G: { G_0: 0, G_1: 1, G_3: 3 },
        H: { H_0: 0, H_1: 1, H_3: 3 },
        I: { I_0: 0, I_2: 2, I_3: 3 },
        J: { J_0: 0, J_1: 1, J_3: 3 },
        K: { K_0: 0, K_1: 1, K_2: 2 }
    };

    const coloresFactor = {
        A: { 0: "#70b85a", 4: "#f49a35", 6: "#d92332", 10: "#75449b" },
        B: { 0: "#70b85a", 3: "#f49a35", 6: "#d92332" },
        C: { 0: "#70b85a", 1: "#f49a35", 3: "#d92332" },
        D: { 0: "#70b85a", 1: "#f49a35", 2: "#d92332" },
        E: { 0: "#70b85a", 1: "#f49a35", 3: "#d92332" },
        F: { 0: "#70b85a", 2: "#f49a35", 4: "#d92332" },
        G: { 0: "#70b85a", 1: "#f49a35", 3: "#d92332" },
        H: { 0: "#70b85a", 1: "#f49a35", 3: "#d92332" },
        I: { 0: "#70b85a", 2: "#f49a35", 3: "#d92332" },
        J: { 0: "#70b85a", 1: "#f49a35", 3: "#d92332" },
        K: { 0: "#70b85a", 1: "#f49a35", 2: "#d92332" }
    };

    const filasRiesgo = [
        "MAC_EQ_RIESGO_BAJO",
        "MAC_EQ_RIESGO_MEDIO",
        "MAC_EQ_RIESGO_ALTO",
        "MAC_EQ_RIESGO_MUY_ALTO"
    ];

    function obtenerPuntuacion(factor, valor) {

        if (!valor || !puntuaciones[factor]) return null;

        const puntuacion = puntuaciones[factor][valor];

        return puntuacion === undefined ? null : puntuacion;
    }

    function obtenerColor(factor, valor) {

        const colores = coloresFactor[factor];

        if (!colores) return "#ffffff";

        return colores[valor] || "#ffffff";
    }

    function limpiarClasificacion() {

        filasRiesgo.forEach(function (id) {

            const fila = contenedor.querySelector("#" + id);

            if (fila) {
                fila.classList.remove("mac-eq-seleccionado");
            }
        });
    }

    function actualizarResumen(factor, valor) {

        const fila = contenedor.querySelector(
            '#tablaResumenMACEq tbody tr[data-factor="' + factor + '"]'
        );

        if (!fila) return;

        const celdaColor = fila.querySelector(".mac-eq-color");
        const celdaValor = fila.querySelector(".mac-eq-valor");

        if (valor === null) {
            celdaColor.style.backgroundColor = "#ffffff";
            celdaColor.textContent = "";
            celdaValor.textContent = "-";
            return;
        }

        celdaColor.style.backgroundColor = obtenerColor(factor, valor);
        celdaColor.textContent = "";
        celdaValor.textContent = valor;
    }

    function calcularMACEq() {

        let total = 0;
        let completos = 0;

        factores.forEach(function (factor) {

            const selector = contenedor.querySelector("#MAC_EQ_" + factor);

            if (!selector) return;

            const valor = obtenerPuntuacion(factor, selector.value);

            if (valor === null) {
                actualizarResumen(factor, null);
                return;
            }

            total += valor;
            completos++;

            actualizarResumen(factor, valor);
        });

        const elementoTotal = contenedor.querySelector("#MAC_EQ_TOTAL");
        const resultado = contenedor.querySelector("#MAC_EQ_RESULTADO");

        if (elementoTotal) {
            elementoTotal.textContent = total;
        }

        limpiarClasificacion();

        if (!resultado) return;

        if (completos !== factores.length) {

            resultado.style.backgroundColor = "#f8f9fa";
            resultado.style.color = "#333333";
            resultado.style.borderColor = "#cccccc";

            resultado.innerHTML =
                "Seleccione todos los factores de riesgo." +
                "<br>Factores seleccionados: " + completos + " de 11" +
                "<br>Puntaje parcial: " + total;

            return;
        }

        let nivel = "";
        let prioridad = "";
        let color = "";
        let filaActiva = "";

        if (total >= 0 && total <= 4) {

            nivel = "Bajo – Aceptable";
            prioridad = "No se requieren acciones correctivas";
            color = "#00ef00";
            filaActiva = "MAC_EQ_RIESGO_BAJO";

        } else if (total >= 5 && total <= 12) {

            nivel = "Medio – Posible";
            prioridad = "Se requieren acciones correctivas a corto plazo";
            color = "#ffff00";
            filaActiva = "MAC_EQ_RIESGO_MEDIO";

        } else if (total >= 13 && total <= 20) {

            nivel = "Alto – Significativo";
            prioridad = "Se requieren acciones correctivas pronto";
            color = "#ff0000";
            filaActiva = "MAC_EQ_RIESGO_ALTO";

        } else if (total >= 21 && total <= 32) {

            nivel = "Muy Alto – Inaceptable";
            prioridad = "Se requieren acciones correctivas inmediatamente";
            color = "#ed00ed";
            filaActiva = "MAC_EQ_RIESGO_MUY_ALTO";

        } else {

            resultado.style.backgroundColor = "#f8d7da";
            resultado.style.color = "#721c24";
            resultado.style.borderColor = "#dc3545";

            resultado.innerHTML =
                "PUNTAJE TOTAL: " + total +
                "<br>El resultado supera el rango de clasificación de la tabla (0 a 32).";

            return;
        }

        const filaSeleccionada = contenedor.querySelector("#" + filaActiva);

        if (filaSeleccionada) {
            filaSeleccionada.classList.add("mac-eq-seleccionado");
        }

        resultado.style.backgroundColor = color;
        resultado.style.color =
            color === "#00ef00" || color === "#ffff00" ? "#000000" : "#ffffff";
        resultado.style.borderColor = "#333333";

        resultado.innerHTML =
            "NIVEL DE RIESGO: " + nivel +
            "<br>PUNTAJE TOTAL: " + total +
            "<br>" + prioridad;
    }

    factores.forEach(function (factor) {

        const selector = contenedor.querySelector("#MAC_EQ_" + factor);

        if (selector) {
            selector.addEventListener("change", calcularMACEq);
        }
    });

    const pesoCarga = contenedor.querySelector("#MAC_EQ_PESO_CARGA");
    const numeroPersonas = contenedor.querySelector("#MAC_EQ_NUM_PERSONAS");
    const selectorA = contenedor.querySelector("#MAC_EQ_A");

    if (pesoCarga && numeroPersonas && selectorA) {

        function seleccionarPuntajeA() {

            const peso = parseFloat(pesoCarga.value);
            const personas = numeroPersonas.value;

            if (!personas || pesoCarga.value === "" || peso < 0) {
                selectorA.value = "";
                calcularMACEq();
                return;
            }

            let opcion = "";

            if (personas === "2") {
                if (peso < 35) opcion = "A_2_MENOS_35";
                else if (peso <= 65) opcion = "A_2_35_65";
                else if (peso <= 85) opcion = "A_2_65_85";
                else opcion = "A_2_MAS_85";
            }

            if (personas === "3") {
                if (peso < 55) opcion = "A_3_MENOS_55";
                else if (peso <= 95) opcion = "A_3_55_95";
                else if (peso <= 130) opcion = "A_3_95_130";
                else opcion = "A_3_MAS_130";
            }

            if (personas === "4") {
                if (peso < 75) opcion = "A_4_MENOS_75";
                else if (peso <= 130) opcion = "A_4_75_130";
                else if (peso <= 170) opcion = "A_4_130_170";
                else opcion = "A_4_MAS_170";
            }

            selectorA.value = opcion;
            calcularMACEq();
        }

        pesoCarga.addEventListener("input", seleccionarPuntajeA);
        numeroPersonas.addEventListener("change", seleccionarPuntajeA);
    }

    calcularMACEq();

    window.calcularMACEq = calcularMACEq;

})();

// Tareas de levantamiento individual de carga
(function () {

    const contenedor = document.getElementById('fichaMACLevantamiento');

    if (!contenedor || contenedor.dataset.macIndividualInicializado === '1') {
        return;
    }

    contenedor.dataset.macIndividualInicializado = '1';

    const configuracion = {
        B: {
            id: 'MAC_IND_B',
            valores: {
                B_0: 0,
                B_3: 3,
                B_6: 6
            }
        },
        C: {
            id: 'MAC_IND_C',
            valores: {
                C_0: 0,
                C_1A: 1,
                C_1B: 1,
                C_3A: 3,
                C_3B: 3
            }
        },
        D: {
            id: 'MAC_IND_D',
            valores: {
                D_0: 0,
                D_1A: 1,
                D_1B: 1,
                D_2: 2
            }
        },
        E: {
            id: 'MAC_IND_E',
            valores: {
                E_0: 0,
                E_1: 1,
                E_3: 3
            }
        },
        F: {
            id: 'MAC_IND_F',
            valores: {
                F_0: 0,
                F_1: 1,
                F_2: 2
            }
        },
        G: {
            id: 'MAC_IND_G',
            valores: {
                G_0: 0,
                G_1: 1,
                G_2: 2
            }
        },
        H: {
            id: 'MAC_IND_H',
            valores: {
                H_0: 0,
                H_1: 1,
                H_2: 2
            }
        }
    };

    const camposA = [
        'MAC_IND_PESO_CARGA',
        'MAC_IND_NUM_OBJETOS',
        'MAC_IND_NUM_PERSONAS',
        'MAC_IND_HORAS'
    ];

    const frecuenciasGrafica = [0, 2, 12, 30, 60, 250, 400, 720];

    const limitesGrafica = {
        verde:  [15, 13, 11, 10, 9, 7, 6, 5],
        naranja: [45, 40, 38, 35, 30, 20, 16, 12],
        rojo:   [50, 50, 50, 50, 48, 33, 28, 20]
    };

    function obtenerValor(id) {
        const elemento = contenedor.querySelector('#' + id);

        if (!elemento) {
            return '';
        }

        return elemento.value;
    }

    function obtenerNumero(id) {
        const valor = obtenerValor(id);

        if (valor === '' || valor === null) {
            return null;
        }

        const numero = Number(valor);

        return Number.isFinite(numero) ? numero : null;
    }

    function interpolarLimite(frecuencia, limites) {

        if (frecuencia <= frecuenciasGrafica[0]) {
            return limites[0];
        }

        for (let i = 1; i < frecuenciasGrafica.length; i++) {

            if (frecuencia <= frecuenciasGrafica[i]) {

                const frecuenciaAnterior = frecuenciasGrafica[i - 1];
                const frecuenciaActual = frecuenciasGrafica[i];

                const limiteAnterior = limites[i - 1];
                const limiteActual = limites[i];

                const proporcion =
                    (frecuencia - frecuenciaAnterior) /
                    (frecuenciaActual - frecuenciaAnterior);

                return limiteAnterior +
                    (limiteActual - limiteAnterior) * proporcion;
            }
        }

        return limites[limites.length - 1];
    }

    function calcularFactorA() {

        const peso = obtenerNumero('MAC_IND_PESO_CARGA');
        const objetos = obtenerNumero('MAC_IND_NUM_OBJETOS');
        const personas = obtenerNumero('MAC_IND_NUM_PERSONAS');
        const horas = obtenerNumero('MAC_IND_HORAS');

        const campoFrecuencia = contenedor.querySelector('#MAC_IND_FRECUENCIA');
        const campoPuntuacion = contenedor.querySelector('#MAC_IND_A');

        if (
            peso === null ||
            objetos === null ||
            personas === null ||
            horas === null ||
            peso < 0 ||
            objetos <= 0 ||
            personas <= 0 ||
            horas <= 0
        ) {
            campoFrecuencia.value = '';
            campoPuntuacion.value = '';
            return null;
        }

        const frecuencia = objetos / personas / horas;

        campoFrecuencia.value = frecuencia.toFixed(2);

        let puntuacion;

        if (peso >= 50) {

            puntuacion = 10;

        } else {

            const limiteVerde = interpolarLimite(
                frecuencia,
                limitesGrafica.verde
            );

            const limiteNaranja = interpolarLimite(
                frecuencia,
                limitesGrafica.naranja
            );

            const limiteRojo = interpolarLimite(
                frecuencia,
                limitesGrafica.rojo
            );

            if (peso <= limiteVerde) {
                puntuacion = 0;
            } else if (peso <= limiteNaranja) {
                puntuacion = 4;
            } else if (peso <= limiteRojo) {
                puntuacion = 6;
            } else {
                puntuacion = 10;
            }
        }

        campoPuntuacion.value = puntuacion;

        return puntuacion;
    }

    function obtenerColor(puntuacion) {

        if (puntuacion === 0) {
            return {
                nombre: 'Verde',
                clase: 'mac-ind-color-verde'
            };
        }

        if (puntuacion <= 4) {
            return {
                nombre: 'Naranja',
                clase: 'mac-ind-color-naranja'
            };
        }

        if (puntuacion <= 6) {
            return {
                nombre: 'Rojo',
                clase: 'mac-ind-color-rojo'
            };
        }

        return {
            nombre: 'Morado',
            clase: 'mac-ind-color-morado'
        };
    }

    function actualizarFilaResumen(factor, puntuacion) {

        const fila = contenedor.querySelector(
            '#tablaResumenMACIndividual tr[data-factor="' + factor + '"]'
        );

        if (!fila) {
            return;
        }

        const celdaColor = fila.querySelector('.mac-ind-color');
        const celdaValor = fila.querySelector('.mac-ind-valor');

        celdaColor.className = 'mac-ind-color';
        celdaValor.textContent = '-';

        if (puntuacion === null || puntuacion === undefined) {
            celdaColor.textContent = '';
            return;
        }

        const color = obtenerColor(puntuacion);

        celdaColor.classList.add(color.clase);
        celdaColor.textContent = color.nombre;

        celdaValor.textContent = puntuacion;
    }

    function obtenerPuntuacionFactor(factor) {

        if (factor === 'A') {
            return calcularFactorA();
        }

        const datos = configuracion[factor];

        if (!datos) {
            return null;
        }

        const valor = obtenerValor(datos.id);

        if (!valor || datos.valores[valor] === undefined) {
            return null;
        }

        return datos.valores[valor];
    }

    function actualizarNivelRiesgo(total) {

        const niveles = [
            'MAC_IND_RIESGO_BAJO',
            'MAC_IND_RIESGO_MEDIO',
            'MAC_IND_RIESGO_ALTO',
            'MAC_IND_RIESGO_MUY_ALTO'
        ];

        niveles.forEach(function (id) {
            const fila = contenedor.querySelector('#' + id);

            if (fila) {
                fila.classList.remove('mac-ind-seleccionado');
            }
        });

        let nivelSeleccionado = null;
        let mensaje = '';

        if (total <= 4) {

            nivelSeleccionado = 'MAC_IND_RIESGO_BAJO';
            mensaje = 'Bajo – Aceptable';

        } else if (total <= 12) {

            nivelSeleccionado = 'MAC_IND_RIESGO_MEDIO';
            mensaje = 'Medio – Posible';

        } else if (total <= 20) {

            nivelSeleccionado = 'MAC_IND_RIESGO_ALTO';
            mensaje = 'Alto – Significativo';

        } else {

            nivelSeleccionado = 'MAC_IND_RIESGO_MUY_ALTO';
            mensaje = 'Muy Alto – Inaceptable';

        }

        const filaSeleccionada = contenedor.querySelector(
            '#' + nivelSeleccionado
        );

        if (filaSeleccionada) {
            filaSeleccionada.classList.add('mac-ind-seleccionado');
        }

        contenedor.querySelector('#MAC_IND_RESULTADO').textContent =
            'Puntaje total: ' + total + ' puntos | Nivel de riesgo: ' + mensaje;
    }

    function actualizarMACIndividual() {

        let total = 0;
        let factoresCompletos = 0;

        const factores = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        factores.forEach(function (factor) {

            const puntuacion = obtenerPuntuacionFactor(factor);

            actualizarFilaResumen(factor, puntuacion);

            if (puntuacion !== null && puntuacion !== undefined) {
                total += puntuacion;
                factoresCompletos++;
            }

        });

        contenedor.querySelector('#MAC_IND_TOTAL').textContent = total;

        if (factoresCompletos === factores.length) {
            actualizarNivelRiesgo(total);
        } else {

            const niveles = [
                'MAC_IND_RIESGO_BAJO',
                'MAC_IND_RIESGO_MEDIO',
                'MAC_IND_RIESGO_ALTO',
                'MAC_IND_RIESGO_MUY_ALTO'
            ];

            niveles.forEach(function (id) {
                const fila = contenedor.querySelector('#' + id);

                if (fila) {
                    fila.classList.remove('mac-ind-seleccionado');
                }
            });

            contenedor.querySelector('#MAC_IND_RESULTADO').textContent =
                'Seleccione todos los factores y complete los datos del peso manejado para obtener el nivel de riesgo.';
        }
    }

    camposA.forEach(function (id) {

        const campo = contenedor.querySelector('#' + id);

        if (campo) {
            campo.addEventListener('input', actualizarMACIndividual);
            campo.addEventListener('change', actualizarMACIndividual);
        }

    });

    Object.keys(configuracion).forEach(function (factor) {

        const campo = contenedor.querySelector(
            '#' + configuracion[factor].id
        );

        if (campo) {
            campo.addEventListener('change', actualizarMACIndividual);
        }

    });

    actualizarMACIndividual();

})();

///  Tareas de transporte de carga
(function () {

    const contenedor = document.getElementById('fichaMACTransporte');

    if (!contenedor || contenedor.dataset.macTransporteInicializado === '1') {
        return;
    }

    contenedor.dataset.macTransporteInicializado = '1';

    const configuracion = {
        B: {
            id: 'MAC_TRANS_B',
            valores: {
                B_0: 0,
                B_3: 3,
                B_6: 6
            }
        },
        C: {
            id: 'MAC_TRANS_C',
            valores: {
                C_0: 0,
                C_1A: 1,
                C_1B: 1,
                C_2: 2
            }
        },
        D: {
            id: 'MAC_TRANS_D',
            valores: {
                D_0: 0,
                D_1: 1,
                D_3: 3
            }
        },
        E: {
            id: 'MAC_TRANS_E',
            valores: {
                E_0: 0,
                E_1: 1,
                E_2: 2
            }
        },
        F: {
            id: 'MAC_TRANS_F',
            valores: {
                F_0: 0,
                F_1: 1,
                F_3: 3
            }
        },
        G: {
            id: 'MAC_TRANS_G',
            valores: {
                G_0: 0,
                G_1: 1,
                G_2: 2
            }
        },
        H: {
            id: 'MAC_TRANS_H',
            valores: {
                H_0: 0,
                H_2: 2,
                H_3: 3
            }
        },
        I: {
            id: 'MAC_TRANS_I',
            valores: {
                I_0: 0,
                I_1: 1,
                I_2: 2
            }
        }
    };

    const frecuenciasGrafica = [0, 2, 12, 30, 60, 300];

    /*
       Límites aproximados de la gráfica del PDF.
       Los valores intermedios se interpolan.
    */

    const limitesGrafica = {
        verde: [15, 13, 11, 10, 9, 7],
        naranja: [45, 40, 38, 35, 30, 20],
        rojo: [50, 50, 50, 50, 48, 33]
    };

    function obtenerValor(id) {
        const elemento = contenedor.querySelector('#' + id);

        return elemento ? elemento.value : '';
    }

    function obtenerNumero(id) {
        const valor = obtenerValor(id);

        if (valor === '') {
            return null;
        }

        const numero = Number(valor);

        return Number.isFinite(numero) ? numero : null;
    }

    function interpolarLimite(frecuencia, limites) {

        if (frecuencia <= frecuenciasGrafica[0]) {
            return limites[0];
        }

        for (let i = 1; i < frecuenciasGrafica.length; i++) {

            if (frecuencia <= frecuenciasGrafica[i]) {

                const frecuenciaAnterior = frecuenciasGrafica[i - 1];
                const frecuenciaActual = frecuenciasGrafica[i];

                const limiteAnterior = limites[i - 1];
                const limiteActual = limites[i];

                const proporcion =
                    (frecuencia - frecuenciaAnterior) /
                    (frecuenciaActual - frecuenciaAnterior);

                return limiteAnterior +
                    (limiteActual - limiteAnterior) * proporcion;
            }
        }

        return limites[limites.length - 1];
    }

    function calcularFactorA() {

        const peso = obtenerNumero('MAC_TRANS_PESO_CARGA');
        const objetos = obtenerNumero('MAC_TRANS_NUM_OBJETOS');
        const personas = obtenerNumero('MAC_TRANS_NUM_PERSONAS');
        const horas = obtenerNumero('MAC_TRANS_HORAS');

        const campoFrecuencia = contenedor.querySelector('#MAC_TRANS_FRECUENCIA');
        const campoPuntuacion = contenedor.querySelector('#MAC_TRANS_A');

        if (
            peso === null ||
            objetos === null ||
            personas === null ||
            horas === null ||
            peso < 0 ||
            objetos <= 0 ||
            personas <= 0 ||
            horas <= 0
        ) {
            campoFrecuencia.value = '';
            campoPuntuacion.value = '';
            return null;
        }

        const frecuencia = objetos / personas / horas;

        campoFrecuencia.value = frecuencia.toFixed(2);

        let puntuacion;

        if (peso >= 50) {

            puntuacion = 10;

        } else {

            const limiteVerde = interpolarLimite(
                frecuencia,
                limitesGrafica.verde
            );

            const limiteNaranja = interpolarLimite(
                frecuencia,
                limitesGrafica.naranja
            );

            const limiteRojo = interpolarLimite(
                frecuencia,
                limitesGrafica.rojo
            );

            if (peso <= limiteVerde) {
                puntuacion = 0;
            } else if (peso <= limiteNaranja) {
                puntuacion = 4;
            } else if (peso <= limiteRojo) {
                puntuacion = 6;
            } else {
                puntuacion = 10;
            }
        }

        campoPuntuacion.value = puntuacion;

        return puntuacion;
    }

    function obtenerColor(puntuacion) {

        if (puntuacion === 0) {
            return {
                nombre: 'Verde',
                clase: 'mac-trans-color-verde'
            };
        }

        if (puntuacion <= 4) {
            return {
                nombre: 'Naranja',
                clase: 'mac-trans-color-naranja'
            };
        }

        if (puntuacion <= 6) {
            return {
                nombre: 'Rojo',
                clase: 'mac-trans-color-rojo'
            };
        }

        return {
            nombre: 'Morado',
            clase: 'mac-trans-color-morado'
        };
    }

    function actualizarFilaResumen(factor, puntuacion) {

        const fila = contenedor.querySelector(
            '#tablaResumenMACTransporte tr[data-factor="' + factor + '"]'
        );

        if (!fila) {
            return;
        }

        const celdaColor = fila.querySelector('.mac-trans-color');
        const celdaValor = fila.querySelector('.mac-trans-valor');

        celdaColor.className = 'mac-trans-color';
        celdaValor.textContent = '-';

        if (puntuacion === null || puntuacion === undefined) {
            celdaColor.textContent = '';
            return;
        }

        const color = obtenerColor(puntuacion);

        celdaColor.classList.add(color.clase);
        celdaColor.textContent = color.nombre;

        celdaValor.textContent = puntuacion;
    }

    function obtenerPuntuacionFactor(factor) {

        if (factor === 'A') {
            return calcularFactorA();
        }

        const datos = configuracion[factor];

        if (!datos) {
            return null;
        }

        const valor = obtenerValor(datos.id);

        if (!valor || datos.valores[valor] === undefined) {
            return null;
        }

        return datos.valores[valor];
    }

    function actualizarNivelRiesgo(total) {

        const niveles = [
            'MAC_TRANS_RIESGO_BAJO',
            'MAC_TRANS_RIESGO_MEDIO',
            'MAC_TRANS_RIESGO_ALTO',
            'MAC_TRANS_RIESGO_MUY_ALTO'
        ];

        niveles.forEach(function (id) {

            const fila = contenedor.querySelector('#' + id);

            if (fila) {
                fila.classList.remove('mac-trans-seleccionado');
            }

        });

        let nivelSeleccionado;
        let mensaje;

        if (total <= 4) {

            nivelSeleccionado = 'MAC_TRANS_RIESGO_BAJO';
            mensaje = 'Bajo – Aceptable';

        } else if (total <= 12) {

            nivelSeleccionado = 'MAC_TRANS_RIESGO_MEDIO';
            mensaje = 'Medio – Posible';

        } else if (total <= 20) {

            nivelSeleccionado = 'MAC_TRANS_RIESGO_ALTO';
            mensaje = 'Alto – Significativo';

        } else {

            nivelSeleccionado = 'MAC_TRANS_RIESGO_MUY_ALTO';
            mensaje = 'Muy Alto – Inaceptable';

        }

        const filaSeleccionada = contenedor.querySelector(
            '#' + nivelSeleccionado
        );

        if (filaSeleccionada) {
            filaSeleccionada.classList.add('mac-trans-seleccionado');
        }

        contenedor.querySelector('#MAC_TRANS_RESULTADO').textContent =
            'Puntaje total: ' + total +
            ' puntos | Nivel de riesgo: ' + mensaje;
    }

    function actualizarMACTransporte() {

        let total = 0;
        let factoresCompletos = 0;

        const factores = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

        factores.forEach(function (factor) {

            const puntuacion = obtenerPuntuacionFactor(factor);

            actualizarFilaResumen(factor, puntuacion);

            if (puntuacion !== null && puntuacion !== undefined) {
                total += puntuacion;
                factoresCompletos++;
            }

        });

        contenedor.querySelector('#MAC_TRANS_TOTAL').textContent = total;

        if (factoresCompletos === factores.length) {

            actualizarNivelRiesgo(total);

        } else {

            const niveles = [
                'MAC_TRANS_RIESGO_BAJO',
                'MAC_TRANS_RIESGO_MEDIO',
                'MAC_TRANS_RIESGO_ALTO',
                'MAC_TRANS_RIESGO_MUY_ALTO'
            ];

            niveles.forEach(function (id) {

                const fila = contenedor.querySelector('#' + id);

                if (fila) {
                    fila.classList.remove('mac-trans-seleccionado');
                }

            });

            contenedor.querySelector('#MAC_TRANS_RESULTADO').textContent =
                'Seleccione todos los factores y complete los datos del peso manejado para obtener el nivel de riesgo.';
        }
    }

    [
        'MAC_TRANS_PESO_CARGA',
        'MAC_TRANS_NUM_OBJETOS',
        'MAC_TRANS_NUM_PERSONAS',
        'MAC_TRANS_HORAS'
    ].forEach(function (id) {

        const campo = contenedor.querySelector('#' + id);

        if (campo) {
            campo.addEventListener('input', actualizarMACTransporte);
            campo.addEventListener('change', actualizarMACTransporte);
        }

    });

    Object.keys(configuracion).forEach(function (factor) {

        const campo = contenedor.querySelector(
            '#' + configuracion[factor].id
        );

        if (campo) {
            campo.addEventListener('change', actualizarMACTransporte);
        }

    });

    actualizarMACTransporte();

})();


// RAPP

$("#RAPP_CON_RUEDAS").on("change", function () {

    if ($(this).val() === "SI") {
        $("#fichaRAPPConRuedas").show();
    } else {
        $("#fichaRAPPConRuedas").hide();
    }

});

$("#RAPP_SIN_RUEDAS").on("change", function () {

    if ($(this).val() === "SI") {
        $("#fichaRAPPSinRuedas").show();
    } else {
        $("#fichaRAPPSinRuedas").hide();
    }

});


/// Empujar o traccionar cargas por medio de equipo con ruedas

$(document).ready(function() {

    const contenedor = document.getElementById("fichaRAPPConRuedas");

    if (!contenedor || contenedor.dataset.rappInicializado === "1") {
        return;
    }

    contenedor.dataset.rappInicializado = "1";

    const equipos = [{
            nombre: "PEQUENO",
            id: "RAPP_RUEDAS_A1_PEQUENO"
        },
        {
            nombre: "MEDIANO",
            id: "RAPP_RUEDAS_A1_MEDIANO"
        },
        {
            nombre: "GRANDE",
            id: "RAPP_RUEDAS_A1_GRANDE"
        }
    ];

    const factores = [{
            numero: "A2",
            id: "RAPP_RUEDAS_A2_POSTURA"
        },
        {
            numero: "A3",
            id: "RAPP_RUEDAS_A3_AGARRE"
        },
        {
            numero: "A4",
            id: "RAPP_RUEDAS_A4_SISTEMA_TRABAJO"
        },
        {
            numero: "A5",
            id: "RAPP_RUEDAS_A5_DISTANCIA"
        },
        {
            numero: "A6",
            id: "RAPP_RUEDAS_A6_CONDICIONES_EQUIPO"
        },
        {
            numero: "A7",
            id: "RAPP_RUEDAS_A7_SUPERFICIE_PISO"
        },
        {
            numero: "A8",
            id: "RAPP_RUEDAS_A8_OBSTACULOS"
        },
        {
            numero: "A9",
            id: "RAPP_RUEDAS_A9_OTROS_FACTORES"
        }
    ];

    function obtenerValorRAPP(id) {

        const elemento = contenedor.querySelector("#" + id);

        if (!elemento || !elemento.value) {
            return null;
        }

        const partes = elemento.value.split("|");

        if (partes.length !== 2) {
            return null;
        }

        if (partes[0] === "M") {
            return {
                puntaje: null,
                banda: "M",
                inaceptable: true
            };
        }

        const puntaje = Number(partes[0]);

        if (!Number.isFinite(puntaje)) {
            return null;
        }

        return {
            puntaje: puntaje,
            banda: partes[1],
            inaceptable: false
        };

    }

    function colorRAPP(banda) {

        const colores = {
            V: {
                fondo: "#159d50",
                texto: "#ffffff"
            },
            A: {
                fondo: "#f7941d",
                texto: "#222222"
            },
            R: {
                fondo: "#ed1c24",
                texto: "#ffffff"
            },
            M: {
                fondo: "#75449b",
                texto: "#ffffff"
            }
        };

        return colores[banda] || {
            fondo: "",
            texto: ""
        };

    }

    function limpiarCelda(celda) {

        if (!celda) return;

        celda.textContent = "";
        celda.style.backgroundColor = "";
        celda.style.color = "";
        celda.style.fontWeight = "";

    }

    function pintarCelda(celda, resultado) {

        if (!celda) return;

        if (!resultado) {
            limpiarCelda(celda);
            return;
        }

        const color = colorRAPP(resultado.banda);

        celda.style.backgroundColor = color.fondo;
        celda.style.color = color.texto;
        celda.style.fontWeight = "bold";

        if (resultado.inaceptable) {
            celda.textContent = "M - Inaceptable";
        } else {
            celda.textContent = resultado.banda + " / " + resultado.puntaje;
        }

    }

    function pintarA1(equipo) {

        const resultado = obtenerValorRAPP(equipo.id);

        const celdaColor = contenedor.querySelector(
            "#RAPP_RUEDAS_TABLA_A1_" + equipo.nombre + "_COLOR"
        );

        const celdaPuntaje = contenedor.querySelector(
            "#RAPP_RUEDAS_TABLA_A1_" + equipo.nombre + "_PUNTAJE"
        );

        if (!resultado) {

            limpiarCelda(celdaColor);
            limpiarCelda(celdaPuntaje);

            return null;

        }

        pintarCelda(celdaColor, resultado);

        if (resultado.inaceptable) {

            limpiarCelda(celdaPuntaje);

            celdaPuntaje.textContent = "Sin puntuación";
            celdaPuntaje.style.backgroundColor = "#75449b";
            celdaPuntaje.style.color = "#ffffff";
            celdaPuntaje.style.fontWeight = "bold";

            return resultado;

        }

        celdaPuntaje.textContent = resultado.puntaje;
        celdaPuntaje.style.backgroundColor = "";
        celdaPuntaje.style.color = "#000000";
        celdaPuntaje.style.fontWeight = "bold";

        return resultado;

    }

    function obtenerNivelRAPP(total) {

        if (total >= 0 && total <= 4) {
            return {
                id: "BAJO",
                nombre: "Bajo – Aceptable",
                prioridad: "No se requieren acciones correctivas"
            };
        }

        if (total >= 5 && total <= 12) {
            return {
                id: "MEDIO",
                nombre: "Medio – Posible",
                prioridad: "Se requieren acciones correctivas a corto plazo"
            };
        }

        if (total >= 13 && total <= 20) {
            return {
                id: "ALTO",
                nombre: "Alto – Significativo",
                prioridad: "Se requieren acciones correctivas pronto"
            };
        }

        if (total >= 21 && total <= 32) {
            return {
                id: "MUY_ALTO",
                nombre: "Muy Alto – Inaceptable",
                prioridad: "Se requieren acciones correctivas inmediatamente"
            };
        }

        return null;

    }

    function limpiarClasificacion() {

        const filas = [
            "BAJO",
            "MEDIO",
            "ALTO",
            "MUY_ALTO"
        ];

        filas.forEach(function(nivel) {

            const fila = contenedor.querySelector(
                "#RAPP_RUEDAS_RIESGO_" + nivel
            );

            if (fila) {
                fila.classList.remove("rapp-seleccionado");
            }

        });

    }

    function actualizarClasificacion(total) {

        limpiarClasificacion();

        const nivel = obtenerNivelRAPP(total);

        if (!nivel) return;

        const fila = contenedor.querySelector(
            "#RAPP_RUEDAS_RIESGO_" + nivel.id
        );

        if (fila) {
            fila.classList.add("rapp-seleccionado");
        }

    }

    function limpiarTotales() {

        equipos.forEach(function(equipo) {

            const total = contenedor.querySelector(
                "#RAPP_RUEDAS_TOTAL_" + equipo.nombre
            );

            const nivel = contenedor.querySelector(
                "#RAPP_RUEDAS_NIVEL_" + equipo.nombre
            );

            if (total) total.textContent = "";
            if (nivel) nivel.textContent = "";

        });

    }

    function limpiarResumenFactores() {

        equipos.forEach(function(equipo) {

            factores.forEach(function(factor) {

                const celda = contenedor.querySelector(
                    "#RAPP_RUEDAS_TABLA_" + factor.numero + "_" + equipo.nombre
                );

                limpiarCelda(celda);

            });

        });

    }

    function actualizarTablaRAPP() {

        let equipoSeleccionado = null;
        let cantidadEquipos = 0;

        equipos.forEach(function(equipo) {

            const elemento = contenedor.querySelector("#" + equipo.id);

            if (elemento && elemento.value) {
                cantidadEquipos++;
                equipoSeleccionado = equipo;
            }

        });

        equipos.forEach(function(equipo) {
            pintarA1(equipo);
        });

        limpiarTotales();
        limpiarResumenFactores();
        limpiarClasificacion();

        const resultadoGeneral = contenedor.querySelector(
            "#RAPP_RUEDAS_RESULTADO_GENERAL"
        );

        if (cantidadEquipos === 0) {

            resultadoGeneral.textContent =
                "Seleccione el tipo de equipo y complete los nueve criterios.";

            resultadoGeneral.style.backgroundColor = "";
            resultadoGeneral.style.color = "";

            return;

        }

        if (cantidadEquipos > 1) {

            resultadoGeneral.textContent =
                "Seleccione solamente un tipo de equipo para realizar esta evaluación.";

            resultadoGeneral.style.backgroundColor = "#fff3cd";
            resultadoGeneral.style.color = "#856404";

            return;

        }

        const resultadoA1 = obtenerValorRAPP(equipoSeleccionado.id);

        if (!resultadoA1) {

            resultadoGeneral.textContent = "Seleccione el peso de la carga.";

            resultadoGeneral.style.backgroundColor = "";
            resultadoGeneral.style.color = "";

            return;

        }

        if (resultadoA1.inaceptable) {

            const total = contenedor.querySelector(
                "#RAPP_RUEDAS_TOTAL_" + equipoSeleccionado.nombre
            );

            const nivel = contenedor.querySelector(
                "#RAPP_RUEDAS_NIVEL_" + equipoSeleccionado.nombre
            );

            total.textContent = "M";
            nivel.textContent = "Inaceptable M - No continuar";

            nivel.style.backgroundColor = "#75449b";
            nivel.style.color = "#ffffff";
            nivel.style.fontWeight = "bold";

            resultadoGeneral.textContent =
                "Inaceptable M: la carga excede la capacidad del fabricante. No continúe la evaluación hasta corregir esta condición.";

            resultadoGeneral.style.backgroundColor = "#75449b";
            resultadoGeneral.style.color = "#ffffff";

            return;

        }

        let total = resultadoA1.puntaje;
        let incompleto = false;

        factores.forEach(function(factor) {

            const resultado = obtenerValorRAPP(factor.id);

            if (!resultado) {
                incompleto = true;
            }

            equipos.forEach(function(equipo) {

                const celda = contenedor.querySelector(
                    "#RAPP_RUEDAS_TABLA_" + factor.numero + "_" + equipo.nombre
                );

                if (equipo.nombre === equipoSeleccionado.nombre) {
                    pintarCelda(celda, resultado);
                } else {
                    limpiarCelda(celda);
                }

            });

            if (resultado && resultado.inaceptable) {
                incompleto = true;
            } else if (resultado) {
                total += resultado.puntaje;
            }

        });

        if (incompleto) {

            const totalCelda = contenedor.querySelector(
                "#RAPP_RUEDAS_TOTAL_" + equipoSeleccionado.nombre
            );

            const nivelCelda = contenedor.querySelector(
                "#RAPP_RUEDAS_NIVEL_" + equipoSeleccionado.nombre
            );

            totalCelda.textContent = "";
            nivelCelda.textContent = "Pendiente de evaluación";

            resultadoGeneral.textContent =
                "Complete los nueve criterios para obtener la suma y el nivel de riesgo.";

            resultadoGeneral.style.backgroundColor = "";
            resultadoGeneral.style.color = "";

            return;

        }

        const totalCelda = contenedor.querySelector(
            "#RAPP_RUEDAS_TOTAL_" + equipoSeleccionado.nombre
        );

        const nivelCelda = contenedor.querySelector(
            "#RAPP_RUEDAS_NIVEL_" + equipoSeleccionado.nombre
        );

        totalCelda.textContent = total;

        const nivel = obtenerNivelRAPP(total);

        if (!nivel) {
            return;
        }

        nivelCelda.textContent = nivel.nombre;
        nivelCelda.style.fontWeight = "bold";

        if (nivel.id === "BAJO") {
            nivelCelda.style.backgroundColor = "#00ed00";
            nivelCelda.style.color = "#000000";
        } else if (nivel.id === "MEDIO") {
            nivelCelda.style.backgroundColor = "#ffff00";
            nivelCelda.style.color = "#000000";
        } else if (nivel.id === "ALTO") {
            nivelCelda.style.backgroundColor = "#ff0000";
            nivelCelda.style.color = "#ffffff";
        } else {
            nivelCelda.style.backgroundColor = "#ed00ed";
            nivelCelda.style.color = "#ffffff";
        }

        actualizarClasificacion(total);

        resultadoGeneral.textContent =
            "Equipo " + equipoSeleccionado.nombre.toLowerCase() +
            " | Puntaje total: " + total +
            " | Nivel de riesgo: " + nivel.nombre +
            " | " + nivel.prioridad;

        resultadoGeneral.style.backgroundColor =
            nivel.id === "BAJO" ? "#00ed00" :
            nivel.id === "MEDIO" ? "#ffff00" :
            nivel.id === "ALTO" ? "#ff0000" : "#ed00ed";

        resultadoGeneral.style.color =
            nivel.id === "ALTO" || nivel.id === "MUY_ALTO" ?
            "#ffffff" :
            "#000000";

    }

    $("#fichaRAPPConRuedas").on(
        "change",
        ".rapp-ruedas-calculo",
        function() {

            if (
                this.id === "RAPP_RUEDAS_A1_PEQUENO" ||
                this.id === "RAPP_RUEDAS_A1_MEDIANO" ||
                this.id === "RAPP_RUEDAS_A1_GRANDE"
            ) {

                equipos.forEach(function(equipo) {

                    if (equipo.id !== this.id) {
                        $("#" + equipo.id).val("");
                    }

                }, this);

            }

            actualizarTablaRAPP();

        }
    );

    actualizarTablaRAPP();

});


/// Empujar o traccionar cargas por medio de equipo sin ruedas
       
$(document).ready(function() {

    const contenedor = document.getElementById("fichaRAPPSinRuedas");

    if (!contenedor || contenedor.dataset.rappSinRuedasInicializado === "1") {
        return;
    }

    contenedor.dataset.rappSinRuedasInicializado = "1";

    const actividades = [{
            nombre: "RODADO",
            titulo: "Rodado",
            b1: "RAPP_SIN_RUEDAS_B1_RODADO"
        },
        {
            nombre: "PIVOTEO",
            titulo: "Pivoteo y rodado",
            b1: "RAPP_SIN_RUEDAS_B1_PIVOTEO"
        },
        {
            nombre: "ARRASTRAR",
            titulo: "Arrastrar / Arrastrar y deslizar",
            b1: "RAPP_SIN_RUEDAS_B1_ARRASTRAR"
        }
    ];

    const factores = [{
            numero: "B2",
            id: "RAPP_SIN_RUEDAS_B2_POSTURA"
        },
        {
            numero: "B3",
            id: "RAPP_SIN_RUEDAS_B3_AGARRE"
        },
        {
            numero: "B4",
            id: "RAPP_SIN_RUEDAS_B4_SISTEMA_TRABAJO"
        },
        {
            numero: "B5",
            id: "RAPP_SIN_RUEDAS_B5_DISTANCIA"
        },
        {
            numero: "B6",
            id: "RAPP_SIN_RUEDAS_B6_SUPERFICIE_PISO"
        },
        {
            numero: "B7",
            id: "RAPP_SIN_RUEDAS_B7_OBSTACULOS"
        },
        {
            numero: "B8",
            id: "RAPP_SIN_RUEDAS_B8_OTROS_FACTORES"
        }
    ];

    function obtenerValorRAPP(id) {

        const elemento = contenedor.querySelector("#" + id);

        if (!elemento || !elemento.value) {
            return null;
        }

        const partes = elemento.value.split("|");

        if (partes.length !== 2) {
            return null;
        }

        const puntaje = Number(partes[0]);

        if (!Number.isFinite(puntaje)) {
            return null;
        }

        return {
            puntaje: puntaje,
            banda: partes[1]
        };

    }

    function colorRAPP(banda) {

        const colores = {
            V: {
                fondo: "#159d50",
                texto: "#ffffff"
            },
            A: {
                fondo: "#f7941d",
                texto: "#222222"
            },
            R: {
                fondo: "#ed1c24",
                texto: "#ffffff"
            }
        };

        return colores[banda] || {
            fondo: "",
            texto: ""
        };

    }

    function limpiarCelda(celda) {

        if (!celda) return;

        celda.textContent = "";
        celda.style.backgroundColor = "";
        celda.style.color = "";
        celda.style.fontWeight = "";

    }

    function pintarCelda(celda, resultado, mostrarPuntaje) {

        if (!celda) return;

        if (!resultado) {
            limpiarCelda(celda);
            return;
        }

        const color = colorRAPP(resultado.banda);

        celda.style.backgroundColor = color.fondo;
        celda.style.color = color.texto;
        celda.style.fontWeight = "bold";

        if (mostrarPuntaje) {
            celda.textContent = resultado.puntaje;
        } else {
            celda.textContent = resultado.banda;
        }

    }

    function obtenerNivelRAPP(total) {

        if (total >= 0 && total <= 4) {
            return {
                id: "BAJO",
                nombre: "Bajo – Aceptable",
                prioridad: "No se requieren acciones correctivas",
                fondo: "#00ed00",
                texto: "#000000"
            };
        }

        if (total >= 5 && total <= 12) {
            return {
                id: "MEDIO",
                nombre: "Medio – Posible",
                prioridad: "Se requieren acciones correctivas a corto plazo",
                fondo: "#ffff00",
                texto: "#000000"
            };
        }

        if (total >= 13 && total <= 20) {
            return {
                id: "ALTO",
                nombre: "Alto – Significativo",
                prioridad: "Se requieren acciones correctivas pronto",
                fondo: "#ff0000",
                texto: "#ffffff"
            };
        }

        if (total >= 21 && total <= 32) {
            return {
                id: "MUY_ALTO",
                nombre: "Muy Alto – Inaceptable",
                prioridad: "Se requieren acciones correctivas inmediatamente",
                fondo: "#ed00ed",
                texto: "#ffffff"
            };
        }

        return null;

    }

    function limpiarClasificacion() {

        const niveles = [
            "BAJO",
            "MEDIO",
            "ALTO",
            "MUY_ALTO"
        ];

        niveles.forEach(function(nivel) {

            const fila = contenedor.querySelector(
                "#RAPP_SIN_RUEDAS_RIESGO_" + nivel
            );

            if (fila) {
                fila.classList.remove("rapp-seleccionado");
            }

        });

    }

    function actualizarClasificacion(total) {

        limpiarClasificacion();

        const nivel = obtenerNivelRAPP(total);

        if (!nivel) return;

        const fila = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_RIESGO_" + nivel.id
        );

        if (fila) {
            fila.classList.add("rapp-seleccionado");
        }

    }

    function limpiarResultadoActividad(actividad) {

        const total = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TOTAL_" + actividad.nombre
        );

        const nivel = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_NIVEL_" + actividad.nombre
        );

        if (total) {
            total.textContent = "";
        }

        if (nivel) {
            nivel.textContent = "";
            nivel.style.backgroundColor = "";
            nivel.style.color = "";
        }

        const b1Color = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TABLA_B1_" + actividad.nombre + "_COLOR"
        );

        const b1Puntaje = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TABLA_B1_" + actividad.nombre + "_PUNTAJE"
        );

        limpiarCelda(b1Color);
        limpiarCelda(b1Puntaje);

        factores.forEach(function(factor) {

            const color = contenedor.querySelector(
                "#RAPP_SIN_RUEDAS_TABLA_" + factor.numero + "_" + actividad.nombre + "_COLOR"
            );

            const puntaje = contenedor.querySelector(
                "#RAPP_SIN_RUEDAS_TABLA_" + factor.numero + "_" + actividad.nombre + "_PUNTAJE"
            );

            limpiarCelda(color);
            limpiarCelda(puntaje);

        });

    }

    function actualizarActividad(actividad) {

        const resultadoB1 = obtenerValorRAPP(actividad.b1);

        const celdaB1Color = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TABLA_B1_" + actividad.nombre + "_COLOR"
        );

        const celdaB1Puntaje = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TABLA_B1_" + actividad.nombre + "_PUNTAJE"
        );

        const totalCelda = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_TOTAL_" + actividad.nombre
        );

        const nivelCelda = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_NIVEL_" + actividad.nombre
        );

        if (!resultadoB1) {

            limpiarResultadoActividad(actividad);

            return {
                completo: false,
                seleccionado: false
            };

        }

        pintarCelda(celdaB1Color, resultadoB1, false);
        pintarCelda(celdaB1Puntaje, resultadoB1, true);

        let total = resultadoB1.puntaje;
        let incompleto = false;

        factores.forEach(function(factor) {

            const resultado = obtenerValorRAPP(factor.id);

            const celdaColor = contenedor.querySelector(
                "#RAPP_SIN_RUEDAS_TABLA_" + factor.numero + "_" + actividad.nombre + "_COLOR"
            );

            const celdaPuntaje = contenedor.querySelector(
                "#RAPP_SIN_RUEDAS_TABLA_" + factor.numero + "_" + actividad.nombre + "_PUNTAJE"
            );

            if (!resultado) {

                incompleto = true;

                limpiarCelda(celdaColor);
                limpiarCelda(celdaPuntaje);

                return;

            }

            pintarCelda(celdaColor, resultado, false);
            pintarCelda(celdaPuntaje, resultado, true);

            total += resultado.puntaje;

        });

        if (incompleto) {

            totalCelda.textContent = "";
            nivelCelda.textContent = "Pendiente de evaluación";
            nivelCelda.style.backgroundColor = "";
            nivelCelda.style.color = "";

            return {
                completo: false,
                seleccionado: true
            };

        }

        const nivel = obtenerNivelRAPP(total);

        totalCelda.textContent = total;

        nivelCelda.textContent = nivel.nombre;
        nivelCelda.style.backgroundColor = nivel.fondo;
        nivelCelda.style.color = nivel.texto;
        nivelCelda.style.fontWeight = "bold";

        return {
            completo: true,
            seleccionado: true,
            total: total,
            nivel: nivel,
            actividad: actividad
        };

    }

    function actualizarTablaRAPP() {

        limpiarClasificacion();

        const resultados = [];

        actividades.forEach(function(actividad) {

            const resultado = actualizarActividad(actividad);

            if (resultado.seleccionado) {
                resultados.push(resultado);
            }

        });

        const resultadoGeneral = contenedor.querySelector(
            "#RAPP_SIN_RUEDAS_RESULTADO_GENERAL"
        );

        if (resultados.length === 0) {

            resultadoGeneral.textContent =
                "Seleccione el peso de la carga para una o más actividades y complete los criterios.";

            resultadoGeneral.style.backgroundColor = "";
            resultadoGeneral.style.color = "";

            return;

        }

        const incompletos = resultados.filter(function(resultado) {
            return !resultado.completo;
        });

        if (incompletos.length > 0) {

            resultadoGeneral.textContent =
                "Hay evaluaciones pendientes. Complete los ocho criterios de cada actividad seleccionada para obtener sus resultados.";

            resultadoGeneral.style.backgroundColor = "#fff3cd";
            resultadoGeneral.style.color = "#856404";

            return;

        }

        const resumen = resultados.map(function(resultado) {

            actualizarClasificacion(resultado.total);

            return resultado.actividad.titulo +
                ": " + resultado.total +
                " puntos - " + resultado.nivel.nombre;

        });

        resultadoGeneral.textContent = resumen.join(" | ");

        if (resultados.length === 1) {

            resultadoGeneral.style.backgroundColor = resultados[0].nivel.fondo;
            resultadoGeneral.style.color = resultados[0].nivel.texto;

        } else {

            resultadoGeneral.style.backgroundColor = "#d1ecf1";
            resultadoGeneral.style.color = "#0c5460";

        }

    }

    $("#fichaRAPPSinRuedas").on(
        "change",
        ".rapp-sin-ruedas-calculo",
        function() {
            actualizarTablaRAPP();
        }
    );

    actualizarTablaRAPP();

});
                                                
//// ANGULOS


$('#modal_angulos').on('hidden.bs.modal', function (e) {

	ID_ANGULOS_FRE = 0;

    $('#form_angulo')[0].reset();

    $('#ACTIVIDAD_ANGULO').html('<option value="" selected disabled>Seleccione una opción</option>');
    $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una actividad primero</option>');
    $('#DESCRIPCION_TAREA').val('');


})





var actividadesFreAngulos = [];

function cargarActividadesFreAngulos(callback = null) {

    $('#ACTIVIDAD_ANGULO').html('<option value="" selected disabled>Cargando actividades...</option>');
    $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una actividad primero</option>');

    $.ajax({

        url: '/obtenerActividadesFreAngulos/' + fre_id,
        type: 'GET',
        success: function(response) {

            actividadesFreAngulos = response.actividades || [];

            $('#ACTIVIDAD_ANGULO').html('<option value="" selected disabled>Seleccione una opción</option>');
            $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una actividad primero</option>');

            actividadesFreAngulos.forEach(function(actividad, index) {

                $('#ACTIVIDAD_ANGULO').append($('<option>', {value: index,text: actividad.nombre}));

            });

            if (typeof callback === 'function') {
                callback();
            }

        },

        error: function(xhr) {

            actividadesFreAngulos = [];

            console.error(xhr.responseJSON);

            Swal.fire(
                'Error',
                'No se pudieron consultar las actividades.',
                'error'
            );

        }

    });

}

$('#ACTIVIDAD_ANGULO').on('change', function() {

    let indiceActividad = $(this).val();

    $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una opción</option>');
    $('#DESCRIPCION_TAREA').val('');
    if (indiceActividad === null || indiceActividad === '') {
        return;
    }

    let actividad = actividadesFreAngulos[indiceActividad];
    if (!actividad || !Array.isArray(actividad.tareas)) {
        return;
    }

    if (actividad.tareas.length === 0) {
        $('#TAREA_ANGULO').html('<option value="" selected disabled>Esta actividad no tiene tareas</option>');
        return;
    }

    actividad.tareas.forEach(function(tarea, index) {

        $('#TAREA_ANGULO').append($('<option>', {value: index,text: tarea.nombre}));

    });

});


$('#TAREA_ANGULO').on('change', function() {

    let indiceActividad = $('#ACTIVIDAD_ANGULO').val();
    let indiceTarea = $(this).val();

    if (indiceActividad === null || indiceActividad === '' || indiceTarea === null || indiceTarea === '')
    {
        return;
    }

    let actividad = actividadesFreAngulos[indiceActividad];

    if (!actividad || !actividad.tareas[indiceTarea]) {
        return;
    }

    let tarea = actividad.tareas[indiceTarea];

    $('#DESCRIPCION_TAREA').val(tarea.nombre);

});



$("#boton_nuevo_angulos").click(function (e) {

    e.preventDefault();

    $('#form_angulo').each(function() {
        this.reset();
    });

    $('#ACTIVIDAD_ANGULO').html('<option value="" selected disabled>Seleccione una opción</option>');
    $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una actividad primero</option>');
    $('#DESCRIPCION_TAREA').val('');

    cargarActividadesFreAngulos();

    var drEvent = $('#FOTO_ANGULO').dropify({

        messages: {

            'default': 'Arrastre la imagen aquí o haga clic',
            'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
            'remove': 'Quitar',
            'error': 'Ooops, ha ocurrido un error.'

        },

        error: {
            'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
            'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
            'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
            'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
            'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
            'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'

        }

    });

    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();

    $("#modal_angulos").modal("show");

});




$("#boton_guardar_angulo").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#form_angulo'))

    if (formularioValido) {

    if (ID_ANGULOS_FRE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_angulo')
            await ajaxAwaitFormData({ api: 2,FRE_ID:fre_id, ID_ANGULOS_FRE: ID_ANGULOS_FRE }, 'evaluacionfre', 'form_angulo', 'boton_guardar_angulo', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ANGULOS_FRE = data.angulos.ID_ANGULOS_FRE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modal_angulos').modal('hide')
                    document.getElementById('form_angulo').reset();


                    
                    if ($.fn.DataTable.isDataTable('#tabla_angulos_fre')) {
                        TablangulosFre.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_angulo')
            await ajaxAwaitFormData({ api: 2,FRE_ID:fre_id ,ID_ANGULOS_FRE: ID_ANGULOS_FRE }, 'evaluacionfre', 'form_angulo', 'boton_guardar_angulo', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ANGULOS_FRE = data.angulos.ID_ANGULOS_FRE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modal_angulos').modal('hide')
                    document.getElementById('form_angulo').reset();


                    
                    if ($.fn.DataTable.isDataTable('#tabla_angulos_fre')) {
                        TablangulosFre.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});





function tabla_angulos_fre()
{
    try 
    {
        var ruta = "/tablangulosfre/" + fre_id;

        if (TablangulosFre != null)
        {
            // Recargar tabla
            TablangulosFre.clear().draw();
            TablangulosFre.ajax.url(ruta).load();
        }
        else
        {
            TablangulosFre = $('#tabla_angulos_fre').DataTable({
                "ajax": {
                    "url": ruta,
                    "type": "get",
                    "cache": false,
                    error: function (xhr, error, code)
                    {
                        console.error("Error AJAX tabla_angulos_fre:", xhr.responseText);
                    }
                },
                "columns": [
                    {
                        "data": "numero_registro" 
                    },
                     {
                        "data": "FOTO_TABLA_DOCUMENTO"
                    },
                    {
                        "className": 'Editar',
                        "orderable": false,
                        "data": "boton_editar",
                        "defaultContent": "-"
                    }
                ],
                "lengthMenu": [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Todos"]],
                "order": [[0, "asc"]],
                "processing": true,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ Registros",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Página _PAGE_ de _PAGES_ (Total _TOTAL_ registros)",
                    "infoEmpty": "No se encontraron registros",
                    "infoFiltered": "(Filtrado de _MAX_ registros)",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "loadingRecords": "Cargando datos....",
                    "processing": "Procesando <i class=\"fa fa-spin fa-spinner fa-3x\"></i>",
                    "search": "Buscar",
                    "paginate": {
                        "first": "Primera",
                        "last": "Ultima",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        }
    }
    catch (exception)
    {
        console.error("Error general tabla_angulos_fre():", exception);
    }
}




function seleccionarActividadTareaGuardada(actividadGuardada, tareaGuardada) {

    
    let indiceActividad = parseInt(actividadGuardada);
    let indiceTarea = parseInt(tareaGuardada)

    if (isNaN(indiceActividad) || !actividadesFreAngulos[indiceActividad])
    {
        return;
    }


    $('#ACTIVIDAD_ANGULO').val(String(indiceActividad));
    let actividad = actividadesFreAngulos[indiceActividad];

    $('#TAREA_ANGULO').html('<option value="" selected disabled>Seleccione una opción</option>');


    actividad.tareas.forEach(function(tarea, index) {
        $('#TAREA_ANGULO').append($('<option>', {value: index,text: tarea.nombre}));

    });


    $('#TAREA_ANGULO').val(String(indiceTarea));

}






$('#tabla_angulos_fre tbody').on('click', 'td.Editar', function () {
    var tr = $(this).closest('tr');
    var row = TablangulosFre.row(tr);


    ID_ANGULOS_FRE = row.data().ID_ANGULOS_FRE;

    editarDatoTabla(row.data(), 'form_angulo', 'modal_angulos',1);



    let actividadGuardada = row.data().ACTIVIDAD_ANGULO;
    let tareaGuardada = row.data().TAREA_ANGULO;

    cargarActividadesFreAngulos(function() {
        seleccionarActividadTareaGuardada(actividadGuardada,tareaGuardada);
    });


	 if (row.data().FOTO_ANGULO) {
        var archivo = row.data().FOTO_ANGULO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/verfotoangulofre/' + row.data().ID_ANGULOS_FRE + extension;

        if ($('#FOTO_ANGULO').data('dropify')) {
            $('#FOTO_ANGULO').dropify().data('dropify').destroy();
            $('#FOTO_ANGULO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_ANGULO').dropify().data('dropify').init();
        } else {
            $('#FOTO_ANGULO').attr('data-default-file', imagenUrl);
            $('#FOTO_ANGULO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_ANGULO').dropify().data('dropify').resetPreview();
        $('#FOTO_ANGULO').dropify().data('dropify').clearElement();
        }
  

});



$(document).ready(function () {

    const textosPredeterminados = {
        APLICA_POSTURA: {
            textarea: '#DESCRIPCION_POSTURA',
            texto: 'No se identificó exposición postural relevante, debido a que las actividades se realizan dentro de los ángulos de confort articular, con variabilidad postural y sin mantenimiento prolongado de posiciones estáticas o forzadas.'
        },

        APLICA_MOVIMIENTO: {
            textarea: '#DESCRIPCION_MOVIMIENTO',
            texto: 'No se considera necesario aplicar la evaluación por movimientos repetitivos, ya que las actividades del trabajador no implican una secuencia continua y reiterada de acciones técnicas que cumpla los criterios de repetitividad, duración del ciclo y tiempo de exposición establecidos en la metodología de referencia.'
        },

        APLICA_FUERZA: {
            textarea: '#DESCRIPCION_FUERZA',
            texto: 'El trabajador durante su jornada laboral presenta una postura adecuada al realizar las tareas que le implican manejo de cargas al levantar y bajar cargas, así como tracción sin generar fatiga muscular que le ocasione molestias en espalda baja.'
        }
    };


    Object.keys(textosPredeterminados).forEach(function (selectId) {

        const configuracion = textosPredeterminados[selectId];

        $('#' + selectId).on('change', function () {

            const valorSeleccionado = $(this).val();
            const $textarea = $(configuracion.textarea);

            if (valorSeleccionado === '2') {

                $textarea.val(configuracion.texto);

            } else if (valorSeleccionado === '1') {

                $textarea.val('');

            }

        });

    });

});


/// VERSIONES
	

function tablaVersionesRecoErgo()
{

    try {

        let ruta =
            "/tablaVersionesFreErgo/" +
            recsensorial;

        if(tabla_reporte_revisiones != null)
        {
            tabla_reporte_revisiones
                .destroy();
        }

        tabla_reporte_revisiones =
            $('#tabla_reporte_revisiones')
            .DataTable({

            ajax: {
                url: ruta,
                type: "get",
                cache: false
            },

            columns: [
                {
                    data: "NUMERO_REVISION"
                },
                {
                    data: "FECHA_FINALIZADO"
                },
                {
                    data: "FINALIZADO_NOMBRE"
                },
                {
                    data: "CHECKBOX_CANCELADO"
                },
                {
                    data: "CANCELADO_NOMBRE"
                },
                {
                    data: "ESTADO"
                },
                {
                    data: "BOTON_DESCARGAR"
                }
            ],
            
            ordering: true,
            processing: true,
            responsive: true,
            
            language: {
                emptyTable:
                    "No hay revisiones"
            }
        });
    }
    catch(exception) {
        console.error(exception);
    }

}

$("#boton_reporte_nuevarevision").on("click", function()
{

    $.ajax({

        url: '/crearRevisionFreErgo',
        type: 'POST',
        data: {
            RECO_ID: recsensorial,
            _token:
                $('meta[name="csrf-token"]')
                .attr('content')
        },

        success: function(response)
        {
            Swal.fire({
                icon: 'success',
                title: 'Correcto',
                text: response.msj
            });

            tablaVersionesRecoErgo();
			validarEdicionRecoErgo()
        }
    });
});

function cancelarRevisionRecoErgo(ID_VERSION_RECO_ERGO,checkbox)
{

    if(!checkbox.checked)
    {
        return;
    }

    Swal.fire({
        title: 'Cancelar revisión',
        input: 'textarea',
        inputLabel: 'Motivo de cancelación',
        inputPlaceholder:
        'Escriba el motivo...',
        inputAttributes: {
            'required': true
        },
        showCancelButton: true,
        confirmButtonText: 'Cancelar revisión',
        cancelButtonText: 'Cerrar'
    }).then((result) => {


        if(result.isConfirmed)
        {
            $.ajax({
                url:'/cancelarRevisionFreErgo',
                type: 'POST',
                data: {
                    ID_VERSION_RECO_ERGO: ID_VERSION_RECO_ERGO,
                    MOTIVO_CANCELACION: result.value,

                    _token:
                        $('meta[name="csrf-token"]')
                        .attr('content')
                },

                success: function(response)
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Correcto',
                        text: response.msj
                    });

                    tablaVersionesRecoErgo();
                    validarEdicionRecoErgo();
                },

                error: function(xhr)
                {
                    console.log(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text:'No se pudo cancelar'
                    });
                }
            });
        }
        else {

            checkbox.checked = false;
        }
    });
}

function validarEdicionRecoErgo() {

    $.get(
        '/validarEdicionFreErgo/' + recsensorial,
        function(response) {

            let botones = [
                '#botonguardar_reporte_introduccion',
                '#botonguardar_reporte_definiciones',
                '#botonguardar_reporte_objetivogeneral',
                '#botonguardar_reporte_objetivoespecifico',
                '#botonguardar_reporte_reconocimiento',
                '#botonguardar_reporte_procesoinstalacion',
                '#botonguardar_reporte_antropometricas',
                '#botonguardar_reporte_esqueletico',
                '#botonguardar_reporte_conclusion',
                '#botonguardar_reporte_recomendaciones',
                '#botonguardar_reporte_responsablesinforme',
                '#boton_reporte_nuevarevision',
                '#botonguardar_reporte_portada',
                '#botonguardar_reporte_analisisreconocimiento'

            ].join(',');

            if (response.permite_guardar == 0) {

                $(botones).prop('disabled', true);

                $('input, textarea, select').not('.checkbox_cancelado_revision').prop('disabled', false);

                Swal.fire({
                    icon: 'warning',
                    title: 'Informe finalizado',
                    text: 'La revisión fue finalizada y ya no puede editarse'
                });

            } else {

                $(botones).prop('disabled', false);

                $('input, textarea, select').prop('disabled', false);

            }

            if (response.cancelado == 1) {

                Swal.fire({
                    icon: 'info',
                    title: 'Revisión cancelada',
                    text: 'La última revisión fue cancelada, puede continuar editando'
                });

            }

        }
    );

}

async function descargarRevisionFreErgo(RECO_ID) {

    Swal.fire({
        title: 'Descargando reporte...',
        html: 'Capturando las seis tarjetas y preparando el documento Word.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: function () {
            Swal.showLoading();
        }
    });

    let form = null;

    const tarjetas = [
        { id: 'cardPregunta1', marcador: 'GRAFICA_1' },
        { id: 'cardPregunta2', marcador: 'GRAFICA_2' },
        { id: 'cardPregunta3', marcador: 'GRAFICA_3' },
        { id: 'cardPregunta4', marcador: 'GRAFICA_4' },
        { id: 'cardPregunta5', marcador: 'GRAFICA_5' },
        { id: 'cardPregunta6', marcador: 'GRAFICA_6' }
    ];

    try {

        if (typeof html2canvas === 'undefined') {
            throw new Error(
                'No está cargada la librería html2canvas.'
            );
        }

        const metaToken = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (!metaToken) {
            throw new Error(
                'No se encontró el token CSRF de Laravel.'
            );
        }

        await document.fonts.ready;

        form = document.createElement('form');
        form.method = 'POST';
        form.action = '/descargarRevisionFreErgo/' +
            encodeURIComponent(RECO_ID);
        form.target = '_blank';

        const inputToken = document.createElement('input');

        inputToken.type = 'hidden';
        inputToken.name = '_token';
        inputToken.value = metaToken.content;

        form.appendChild(inputToken);

        for (const tarjetaInfo of tarjetas) {

            const tarjeta = document.getElementById(
                tarjetaInfo.id
            );

            if (!tarjeta) {
                console.warn(
                    'No se encontró la tarjeta:',
                    tarjetaInfo.id
                );

                continue;
            }

            const imagenes = Array.from(
                tarjeta.querySelectorAll('img')
            );

            await Promise.all(
                imagenes.map(function (img) {

                    if (img.complete) {
                        return Promise.resolve();
                    }

                    return new Promise(function (resolve) {
                        img.onload = resolve;
                        img.onerror = resolve;
                    });
                })
            );

            const canvas = await html2canvas(tarjeta, {
                scale: 3,
                useCORS: true,
                allowTaint: false,
                backgroundColor: '#FFFFFF',
                logging: false,
                scrollX: 0,
                scrollY: 0
            });

            const imagenBase64 = canvas.toDataURL('image/png');

            const inputImagen = document.createElement('input');

            inputImagen.type = 'hidden';
            inputImagen.name = tarjetaInfo.marcador;
            inputImagen.value = imagenBase64;

            form.appendChild(inputImagen);

            console.log(
                'Tarjeta capturada:',
                tarjetaInfo.id,
                'Marcador:',
                tarjetaInfo.marcador
            );
        }

        document.body.appendChild(form);

        form.submit();

        Swal.close();

    } catch (error) {

        console.error(
            'Error al preparar las tarjetas del reporte:',
            error
        );

        Swal.fire({
            icon: 'error',
            title: 'Error al preparar la descarga',
            text: error.message ||
                'Ocurrió un problema al preparar el documento.'
        });

    } finally {

        if (form) {
            setTimeout(function () {
                form.remove();
            }, 5000);
        }
    }
}

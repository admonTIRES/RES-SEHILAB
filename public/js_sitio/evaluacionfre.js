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
            
            
        const textareasInformeFre = [
            '#INFORME_INTRODUCCION',
            '#INFORME_OBJETIVOGENERALES',
            '#INFORME_OBJETIVOSESPECIFICOS',
            '#INFORME_RECONOCIMIENTO',
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


           
            
            cargarDatosInformesFreErgo();
            cargarDatosGeneralesInformeFre();
            cargarDefinicionesFreErgo();
            cargarDatosGeneralesInformeReco();
            cargarMapaPeligros();
            mostrartablaactividadesfre();
            tablaReporteAreasErgo();
            mostrartablaimcfre();
             cargarGraficaPregunta1();
            cargarGraficaPregunta2();
            cargarGraficaPregunta3();
            cargarGraficaPregunta4();
            cargarGraficaPregunta5();
            cargarGraficaPregunta6();
            tablaReporteTrabajadoresErgo();
            cargarDefinicionesInformeFreErgo()
            
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

                        // RECONOCIMIENTO


                         let reco = $('#INFORME_RECONOCIMIENTO').val();

                        if (reco) {

                            $.each(resp.data, function(marcador, valor) {
                                reco = reco.split(marcador).join(valor || '');
                            });

                            $('#INFORME_RECONOCIMIENTO').val(reco);
                        }
                       

                        // UBICACIÓN
                        let ubicacion = $('#INFORME_UBICACIONINSTALACION').val();

                        if (ubicacion) {

                            $.each(resp.data, function(marcador, valor) {
                                ubicacion = ubicacion.split(marcador).join(valor || '');
                            });

                            $('#INFORME_UBICACIONINSTALACION').val(ubicacion);
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
                        console.log(xhr.responseText);
                    }
                });
            
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


            $('#RUTA_IMAGEN_PORTADA').val('');
	        $('#RUTA_IMAGEN_PORTADA').dropify().data('dropify').resetPreview();
            $('#RUTA_IMAGEN_PORTADA').dropify().data('dropify').clearElement();
            

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

            $('#RUTA_IMAGEN_UBICACION').val('');
	        $('#RUTA_IMAGEN_UBICACION').dropify().data('dropify').resetPreview();
            $('#RUTA_IMAGEN_UBICACION').dropify().data('dropify').clearElement();

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

			console.log(HIGIENE);
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

				//console.log(response.info[0].CLIENTE_ID,contrato,requiereContrato,response.info[0].NOMBRE_CONTRATO,response.info[0].RAZON_SOCIAL);


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

			console.log("Respuesta AJAX:", fre);

			if (fre && fre.ID_EVALUACION_FRE) {

				console.log("Entró al if");

				cargarEvaluacionFre(fre);

			} else {

				console.log("Entró al else");
				console.log(row.data());

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


    // Recuperar los valores guardados.
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
                        <option value="U" ${item.tipo == 'U' ? 'selected' : ''}>U (Utensilios)</option>
                        <option value="OTROS" ${item.tipo == 'OTROS' ? 'selected' : ''}>Otros</option>
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
    
    $('#ROSA_DATOS_JSON').val('')
    $('#RULA_DATOS_JSON').val('')


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
                    <option value="U">U (Utensilios)</option>
                    <option value="OTROS">Otros</option>
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

    $.get('/obtenerDatosInformesRecoergo/' + recsensorial, function(response)
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
                    '/mostrarportadarecoergo/0/' +
                    recsensorial +
                    extension;



                //-----------------------------------------
                // DROPIFY
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



                //-----------------------------------------
                // NO REQUERIDO
                //-----------------------------------------

                $('#RUTA_IMAGEN_PORTADA')
                    .attr('required', false);

            }

        }

    }).fail(function(xhr)
    {

        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los datos del informe'
        });

    });

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


            if (response.INFORME_UBICACIONINSTALACION &&
                response.INFORME_UBICACIONINSTALACION.trim() != '') {
                $('#INFORME_UBICACIONINSTALACION').val(response.INFORME_UBICACIONINSTALACION);
            } else {
                $('#INFORME_UBICACIONINSTALACION')
                    .val(` Este estudio se realizó en las áreas de la INSTALACION, con domicilio DIRECCION.

Se localiza en las coordenadas  COORDENADAS.`);

            }
        
                    
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
                    `<p>Los factores de riesgo ergonómico contribuyen a la aparición de enfermedades de tipo músculo esquelético, según los datos revelados por la Organización Internacional del Trabajo (OIT) estos a nivel mundial representan una de las principales causas de enfermedad laboral, seguido por exposición a material particulado, los gases, los humos, y el ruido (Discroll, 2018). Por otra parte, la OMS indicó que a nivel mundial cerca del 20% de los dolores lumbares y cervicales son atribuibles a exposiciones en el trabajo (2018).</p>

<p>De acuerdo con el Instituto Mexicano del Seguro Social (IMSS) en 2020, se registraron más de 100.000 casos nuevos de enfermedades laborales, la naturaleza de la lesión indica que hay un número importante de enfermedades que se agrupan como trastornos músculo-esqueléticos (TME), entre ellas, síndrome del túnel carpiano, lesiones de hombro, tenosinovitis del pulgar (“De Quervain”), bursitis, epicondilitis y artrosis; por tal razón los TME representa en la actualidad un importante tipo de enfermedad laboral que afecta a la planta laboral de México. </p>

<p>En México el Reglamento Federal de Seguridad y Salud en el trabajo (RFST), publicado en el Diario Oficial de la Federación (DOF) el día 13 de noviembre de 2014, establece en su artículo 42, que las empresas deben contar con un análisis de los Factores de Riesgo Ergonómico de los puestos de trabajo. Además, la NOM-036-1-STPS-2018 establece los elementos para identificar, analizar, prevenir y controlar los factores de riesgo ergonómico en los centros de trabajo derivados del manejo manual de cargas, a efecto de prevenir alteraciones a la salud de los trabajadores, y aplica en los centros de trabajo donde existan trabajadores cuya actividad implique realizar manejo manual de cargas de forma cotidiana (más de una vez al día); así mismo la LEY SILLA - DOF 19/12/24 en lo referente a el empleador.</p>

<p>Dentro del medio ambiente laboral existen condiciones de riesgo de tipo ergonómico, que de no encontrarse identificados pueden poner en riesgo la salud y la productividad del trabajador; por lo que la identificación temprana y el establecimiento de estrategias de control son primordiales para mantener una condición de trabajo óptima.</p>

<p>En el presente estudio se describen los resultados y evidencias obtenidas posterior a haber identificado el riesgo y peligro ergonómico por medio de las fichas de la ISO-TR 12295-2014 (Reconocimiento); posteriormente se aplican métodos ergonómicos específicos que permiten identificar el riesgo ergonómico para que la empresa tome las medidas preventivas respectivas</p>`
                );

            }



          if (response.INFORME_OBJETIVOGENERALES &&
                response.INFORME_OBJETIVOGENERALES.trim() != '') {
                $('#INFORME_OBJETIVOGENERALES').val(response.INFORME_OBJETIVOGENERALES);
            } else {
                $('#INFORME_OBJETIVOGENERALES')
                    .val(`Evaluar los factores de riesgo ergonómicos de las actividades laborales que impliquen postura, movimientos repetitivos, manipulación manual de cargas y fuerza manual, mediante el análisis biomecánico y aplicación de métodos de carga física para la prevención de trastornos músculo esqueléticos de origen laboral.`);
            }



            if (response.INFORME_OBJETIVOSESPECIFICOS &&
                response.INFORME_OBJETIVOSESPECIFICOS.trim() != '') {
                $('#INFORME_OBJETIVOSESPECIFICOS').val(response.INFORME_OBJETIVOSESPECIFICOS);
            } else {
                $('#INFORME_OBJETIVOSESPECIFICOS')
                    .val(`•	A partir de la ISO TR 12295 como insumo de identificación de los peligros y riesgos ergonómicos, el riesgo Elevado, se someterá a valoraciones ergonómicas con métodos específicos de cuantificación del riesgo. 

• Determinar el nivel de riesgo por carga física a la cual se encuentran expuestos los trabajadores de cada planta objeto del estudio en las tareas que son analizadas

• Generar recomendaciones derivadas de la cuantificación del riesgo ergonómico para mitigar la probabilidad de ocurrencia de Trastornos Músculo Esqueléticos (TME) de origen laboral.

•	Estudiar la relación del riesgo Biomecánicos de acuerdo a los criterios de la NOM-036-1-SPTS-2018, ISO-TR-12295 y la LEY SILLA DOF 19/12/24.`);

            }
            
            


             if (response.INFORME_RECONOCIMIENTO &&
                response.INFORME_RECONOCIMIENTO.trim() != '') {
                $('#INFORME_RECONOCIMIENTO').val(response.INFORME_RECONOCIMIENTO);
            } else {
                $('#INFORME_RECONOCIMIENTO')
                    .val(`Se realiza observación de cada uno de los procesos con el objetivo de analizar la situación de trabajo, la cual enmarca las múltiples tareas, funciones, y entornos en los que se debe desempeñar un trabajador (Castillo, 2013). Se aplicó el procedimiento para la identificación y evaluación de los factores de riesgo ergonómico, el cual se detalla en el punto 4, relacionado con la metodología, así mismo mediante la aplicación de la ISO TR 12295, que permite la identificación de peligros y riesgos ergonómicos, la cual permite hacer una evaluación inicial rápida de: levantamiento de cargas, transporte de cargas, empuje y tracción de cargas, movimientos repetitivos de la extremidad superior, posturas estáticas forzadas y posturas dinámicas forzadas, fichas técnicas que nos permiten ser el punto de partida inicial de evaluación del riesgo como modelo expositivo del riesgo por exposición a sobrecarga biomecánica.

A continuación, se presenta la determinación de los factores de riesgo detectados y la aplicación del modelo conceptual de un estudio ergonómico, en la INSTALACION.

En la aplicación de las fichas técnicas de identificación del riesgo ergonómico de acuerdo con la ISO-TR 12295, se evidenció que las categorías estudiadas tienen tareas que presentan riesgo Elevado; se procedió a hacer un análisis especifico con métodos ergonómicos en las categorías objeto de este estudio; así mismo cabe señalar que esto se correlaciona con los dispuesto en la NOM-036-1-STPS-2018, en cuanto al levantamiento y transporte de cargas.`);

            }
            

         
            


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
                            MAPA DE PELIGROS
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

/// CONDICIONES DE OPERACION DURANTE LA EVALUACION

function tablaReporteAreasErgo()
{
	try {

		var ruta = "/tablaReporteAreasErgo";

		if ($.fn.DataTable.isDataTable('#tabla_reporte_area')) {

			tabla_reporte_area.clear().destroy();

			$('#tabla_reporte_area tbody').empty();
		}

		tabla_reporte_area = $('#tabla_reporte_area').DataTable({

			"ajax": {
				"url": ruta,
				"type": "GET",
				"cache": false,
				"data": {
					ergoid: recsensorial
				},
				"dataSrc": "data"
			},

			"columns": [
				{
					"data": "AREA",
					"defaultContent": "-"
				},
				{
					"data": "CATEGORIA",
					"defaultContent": "-"
                },
			],

			"paging": false,
			"searching": false,
			"info": false,
			"ordering": false,
			"processing": true,
			"responsive": true,
			"autoWidth": false,

            

			"drawCallback": function () {
				var api = this.api();
				var rows = api.rows({
					page: 'current'
				}).nodes();
				var lastArea = null;
				var rowspan = 1;
				var firstRow = null;

				api.column(0, {
					page: 'current'
				}).data().each(function (area, i) {

					var row = rows[i];
					var cell = $('td:eq(0)', row);

					if (lastArea === area) {

						rowspan++;
						cell.remove();
						$('td:eq(0)', firstRow).attr('rowspan', rowspan);

					} else {

						lastArea = area;
						rowspan = 1;
						firstRow = row;
					}
				});
			},

			"language": {
				"lengthMenu": "Mostrar _MENU_ registros",
				"zeroRecords": "No se encontraron registros",
				"info": "Página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros",
				"infoFiltered": "(Filtrado de _MAX_ registros)",
				"emptyTable": "No hay datos disponibles en la tabla",
				"loadingRecords": "Cargando...",
				"processing": "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
				"search": "Buscar:",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			}
		});

	}
	catch (exception) {

		console.error("Error en tablaReporteAreasErgo:", exception);

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
                        console.log('Datos recibidos del controlador:',json.data);
                        (json.data || []).forEach(function (fila) {
                            console.log('Área:',fila.AREA,'| Categoría:',fila.CATEGORIA,'| Total:',fila.TRABAJADORES_EVALUADOS);
                        });

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

$("#form_informe_listarecomendaciones").on(
    "submit",
    function(e)
{

    e.preventDefault();

    let formData = new FormData(this);

    formData.append('RECO_ID',recsensorial);

    $.ajax({
        url: '/guardarRecomendacionesInformeFreErgo',
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
            $("#botonguardar_reporte_recomendaciones").prop('disabled', true);
            $("#botonguardar_reporte_recomendaciones").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
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
            $("#botonguardar_reporte_recomendaciones").prop('disabled', false);
            $("#botonguardar_reporte_recomendaciones").html('Guardar recomendaciones <i class="fa fa-save"></i>');
        }
    });
});





function cargarDefinicionesInformeFreErgo()
{

    $.get(
        '/obtenerRecomendacionesInformeFreErgo/' + recsensorial,

        function(response)
        {  
            $('input[name="DESCRIPCION_RECOMENDACIONES[]"]').prop('checked', false);
            response.forEach(function(item)
            {
                $('input[name="DESCRIPCION_RECOMENDACIONES[]"][value="' + item.CATALOGO_RECOMENDACIONES_ID + '"]').prop('checked', true);
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

        if (seleccionados.includes('1')) {
            $('#contenedorMetodoOWAS').show();
        }

        if (seleccionados.includes('2')) {
            $('#contenedorMetodoROSA').show();
        }

        if (seleccionados.includes('3')) {
            $('#contenedorMetodoRULA').show();
        }
    }

    $('#CAT_METODOS_FRE').on('change', function () {
        mostrarMetodosSeleccionados();
    });

    mostrarMetodosSeleccionados();

});


/// OWAS

document.addEventListener('DOMContentLoaded', function () {

    /* ========================= OWAS ========================= */

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

    /*
     * Textos de la tabla 7 del PDF OWAS.
     */
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

    /*
     * Calcula la categoría, actualiza el código y marca la fila
     * correspondiente en la tabla completa.
     */
    function calcularOWAS() {

        const espalda = owasCampos.espalda.value;
        const brazos = owasCampos.brazos.value;
        const piernas = owasCampos.piernas.value;
        const carga = owasCampos.carga.value;

        // Mostrar individualmente cada dígito.
        owasCodigos.espalda.textContent = espalda || '—';
        owasCodigos.brazos.textContent = brazos || '—';
        owasCodigos.piernas.textContent = piernas || '—';
        owasCodigos.carga.textContent = carga || '—';

        // Limpiar la selección anterior de la tabla.
        document.querySelectorAll(
            '#OWAS_TABLA_RESULTADOS tbody tr'
        ).forEach(function (fila) {
            fila.classList.remove('owas-fila-seleccionada');
        });

        // Si falta algún dato, no mostrar resultados.
        if (!espalda || !brazos || !piernas || !carga) {
            owasCodigoCompleto.value = '';
            owasCardResultado.style.display = 'none';

            owasResultadoCategoria.textContent = '';
            owasResultadoCategoria.className = 'badge ml-2';

            return;
        }

        // Construir el código completo de cuatro dígitos.
        owasCodigoCompleto.value =
            String(espalda) +
            String(brazos) +
            String(piernas) +
            String(carga);

        /*
         * Obtener la categoría usando la tabla 4:
         * la carga 1 corresponde al índice 0,
         * la carga 2 al índice 1,
         * la carga 3 al índice 2.
         */
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

        // Mostrar categoría obtenida.
        owasResultadoCategoria.textContent = categoria;
        owasResultadoCategoria.className =
            'badge ml-2 owas-riesgo-' + categoria;

        // Marcar con borde rojo la fila correspondiente.
        const filaResultado = document.getElementById(
            'OWAS_FILA_' + categoria
        );

        if (filaResultado) {
            filaResultado.classList.add('owas-fila-seleccionada');
        }

        // Mostrar el resultado.
        owasCardResultado.style.display = 'block';
    }

    // Recalcular cuando cambie cualquiera de los cuatro selects.
    Object.values(owasCampos).forEach(function (campo) {
        campo.addEventListener('change', calcularOWAS);
    });

    // Estado inicial.
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



//// ANGULOS




$('#modal_angulos').on('hidden.bs.modal', function (e) {

	ID_ANGULOS_FRE = 0;

    $('#form_angulo')[0].reset();

})



$("#boton_nuevo_angulos").click(function (e) {
    e.preventDefault();

    $('#form_angulo').each(function(){
        this.reset();
    });


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



$('#tabla_angulos_fre tbody').on('click', 'td.Editar', function () {
    var tr = $(this).closest('tr');
    var row = TablangulosFre.row(tr);


    ID_ANGULOS_FRE = row.data().ID_ANGULOS_FRE;

    editarDatoTabla(row.data(), 'form_angulo', 'modal_angulos',1);




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

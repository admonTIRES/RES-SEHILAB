// modulo EPP
var opciones_catepp = "";
var ambientechart = null;
var chartPngs = {};
var generoschart = null;
var categoriaschart = null;
var dominioschart = null;
var acontecimientoschart = null;
var calificacionchart = null;


var tabla_reporte_revisiones  = null 


//=================================================
// MENU INDICE


$(".stickyside").stick_in_parent({
	offset_top: 150 // Margin Top del menu
});


$('.stickyside a').click(function () {
	// $('.list-group-item').removeClass('active');
	// $(this).addClass('active');

	$('html, body').animate({
		scrollTop: $($(this).attr('href')).offset().top - 150 // Margin TOP del DIV al que hace referencia el menu
	}, 1200);
	return false;
});


// This is auto select left sidebar
var lastId,
	topMenu = $(".stickyside");
topMenuHeight = topMenu.outerHeight();


// All list items
menuItems = topMenu.find("a");


// Anchors corresponding to menu items
scrollItems = menuItems.map(function () {
	var item = $($(this).attr("href"));
	if (item.length) {
		return item;
	}
});


// Menu al mover el scroll
$(window).scroll(function () {
	// Get container scroll position
	var fromTop = $(this).scrollTop() + topMenuHeight - 100;
	// var fromTop = $(this).scrollTop() + topMenuHeight;

	// Get id of current scroll item
	var cur = scrollItems.map(function () {
		if ($(this).offset().top < fromTop)
			return this;
	});

	// Get the id of the current element
	cur = cur[cur.length - 1];
	var id = cur && cur.length ? cur[0].id : "";

	if (lastId !== id) {
		lastId = id;
		// Set/remove active class
		menuItems.removeClass("active").filter("[href='#" + id + "']").addClass("active");
	}
});


//=================================================
// LOAD PAGINA

var meses = ["VACIO", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
var reporteregistro_id = 0;
var agente_id = 353;
var agente_nombre = "NOM 0353 - Guia 3";



// Activar Tooltip
$('[data-toggle="tooltip"]').tooltip();


var tiempoespera = 10; // Segundos
function updateClock() {
	if (parseInt(tiempoespera) > 0) {
		$('#segundos_espera').html((tiempoespera - 1));

		tiempoespera = (parseInt(tiempoespera) - 1);

		setTimeout(function () {
			updateClock();
		}, 1000);
	}
	else {
		$('#modal_cargando').modal('hide');
	}
}


$(document).ready(function () {
	// Modal cargando
	$('#modal_cargando .modal-title').html('Cargando Informe de ' + agente_nombre); // Titulo modal
	$('#modal_cargando').modal(); // Abrir modal
	updateClock(); // Ejecutar tiempo de espera



	// Inicializar campos datepicker
	jQuery('.mydatepicker').datepicker({
		format: 'yyyy-mm-dd', //'dd-mm-yyyy'
		weekStart: 1, //dia que inicia la semana, 1 = Lunes
		// startDate: new Date('11/17/2020'), // deshabilitar dias anteriores con fecha
		// startDate: '-3d', // deshabilitar dias anteriores del dia actual
		// endDate: '+3d', //deshabilitar dias despues del dia actual
		calendarWeeks: true,
		autoclose: true,
		todayHighlight: true, //Dia de hoy marcado en el calendario
		toggleActive: true,
		// setDate: new Date('11/17/2020'), // "2020/11/25", //Fecha marcada en el caledario
		forceParse: false, //mantiene la fecha del input si no se selecciona otra
		showOnFocus: true
	});

	// Si selecciona un campo tipo datepicker
	$('.mydatepicker').on('click', function () {
		$(this).datepicker('setDate', $(this).val());// Mostrar fecha del input y marcar en el calendario
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

		
            cargarDatosInformesPsico();
            cargarDatosGeneralesInformePsico();
            cargarDefinicionesInformepsico();
            cargarRecomendacionesInformepsico();
            tablaVersionesinfopsico();
            validarEdicioninfopsico();
            obtenerNumeroTrabajadoresPsico();
            cargarGraficaGeneroPsico();
            cargarGraficaEdadesPsico();
            cargarGraficaEscolaridadPsico();
            cargarGraficaEstadoCivilPsico();
            cargarGraficaRegimenPsico();
            cargarGraficaExperienciaPsico();
    
            $.ajax({
                    url: 'obtenerDatosPlantillaPsico',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: recsensorial.id
                    },
                    success: function(resp) {

                        if (!resp.success) {
                            return;
                        }


                         // INTRODUCCIÓN
                        let contenido = $('#INFORME_INTRODUCCION').val();

                        if (contenido) {

                            $.each(resp.data, function(marcador, valor) {
                                contenido = contenido.split(marcador).join(valor || '');
                            });

                            $('#INFORME_INTRODUCCION').val(contenido);
                        }


                        //  OBJETIVO GENERAL 
                        let objetivogeneral = $('#INFORME_OBJETIVOGENERALES').val();

                        if (objetivogeneral) {

                            $.each(resp.data, function(marcador, valor) {
                                objetivogeneral = objetivogeneral.split(marcador).join(valor || '');
                            });

                            $('#INFORME_OBJETIVOGENERALES').val(objetivogeneral);
                        }



                        // // UBICACIÓN
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

                        // // ACTIVIDAD PRINCIPAL
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
            
    
    

    

});




function cargarDatosInformesPsico()
{

    $.get('/obtenerDatosInformesPsico/' + proyecto.id, function(response)
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
                    '/mostrarportadainfopsico/0/' +
                    proyecto.id +
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

$("#form_reporte_portada").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarPortadaInfopsico',
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


            cargarDatosInformesPsico();

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



////// Datos generales



function cargarDatosGeneralesInformePsico()
{

    $.get(

        '/obtenerDatosGeneralesInformePsico/' + proyecto.id,

        function(response)
        {

            if(response.msj){

                return;
            }


             if (response.INFORME_INTRODUCCION &&
                response.INFORME_INTRODUCCION.trim() != '') {
                $('#INFORME_INTRODUCCION').val(response.INFORME_INTRODUCCION);
            } else {
                $('#INFORME_OBJETIVOGENERALES')
                    .val(`Es un hecho que los Factores de Riesgo Psicosocial (FRPS) inherentes a las diversas actividades que se desarrollan en la industria petrolera no son la excepción. La forma en que las personas se desenvuelven en los ámbitos social y económico encuentra una de sus principales expresiones en el trabajo. Su vida cotidiana, su proyecto de vida y sus experiencias emocionales, cognitivas y sociales se desarrollan, en gran medida, dentro del entorno laboral, considerando el tiempo que se dedica al desempeño de las actividades propias de cada puesto.
                        
Tomando en cuenta la importancia de la evaluación e intervención sobre los Factores de Riesgo Psicosocial para promover un estado de bienestar entre las personas trabajadoras, de conformidad con lo establecido en la Norma Oficial Mexicana NOM-035-STPS-2018, Factores de riesgo psicosocial en el trabajo–Identificación, análisis y prevención, "NOMBRE EMPRESA" mantiene su compromiso con el cumplimiento de los estándares en materia de seguridad y salud en el trabajo, verificando que la salud de las personas trabajadoras expuestas a Factores de Riesgo Psicosocial no se vea afectada por las condiciones existentes en el centro de trabajo. Para ello, realiza de manera periódica las evaluaciones correspondientes, en apego a la normatividad aplicable y a sus procedimientos internos.

En el presente estudio se describen los resultados obtenidos durante la evaluación de Factores de Riesgo Psicosocial en el ambiente laboral, de acuerdo con lo establecido en la Norma Oficial Mexicana NOM-035-STPS2018, Factores de riesgo psicosocial en el trabajo–Identificación, análisis y prevención, realizada en las áreas de la INSTALACION, los días del XX al XX de MES de AÑO."`);
            }



    


          if (response.INFORME_OBJETIVOGENERALES &&
                response.INFORME_OBJETIVOGENERALES.trim() != '') {
                $('#INFORME_OBJETIVOGENERALES').val(response.INFORME_OBJETIVOGENERALES);
            } else {
                $('#INFORME_OBJETIVOGENERALES')
                    .val(`Identificar y analizar los Factores de Riesgo Psicosocial en la INSTALACION.`);
            }


    
            $('#INFORME_OBJETIVOSESPECIFICOS')
                .val(response.INFORME_OBJETIVOSESPECIFICOS);
            
            
            //   if (response.INFORME_OBJETIVOSESPECIFICOS &&
            //     response.INFORME_OBJETIVOSESPECIFICOS.trim() != '') {
            //     $('#INFORME_PROCESOINSTALACION').val(response.INFORME_OBJETIVOSESPECIFICOS);
            // } else {
            //     $('#INFORME_PROCESOINSTALACION').val(`DESCRIPCIONPROCESO`);
            // }


            
            

            if (response.INFORME_UBICACIONINSTALACION &&
                response.INFORME_UBICACIONINSTALACION.trim() != '') {
                $('#INFORME_UBICACIONINSTALACION').val(response.INFORME_UBICACIONINSTALACION);
            } else {
                $('#INFORME_UBICACIONINSTALACION')
                    .val(` Este estudio se realizó en las áreas de la INSTALACION, con domicilio DIRECCION.

Se localiza en las coordenadas  COORDENADAS.`);

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
		

            $('#DESCRIPCION_METODO')
                .val(response.DESCRIPCION_METODO);
            
            $('#REPORTE_ACONTECIMIENTOS_CONCLUSIONES')
                .val(response.REPORTE_ACONTECIMIENTOS_CONCLUSIONES);

            $('#REPORTE_AMBIENTE_CONCLUSIONES')
                .val(response.REPORTE_AMBIENTE_CONCLUSIONES);

            $('#REPORTE_CONDICIONES_CONCLUSIONES')
                .val(response.REPORTE_CONDICIONES_CONCLUSIONES);

            $('#REPORTE_FACTORES_CONCLUSIONES')
                .val(response.REPORTE_FACTORES_CONCLUSIONES);

            $('#REPORTE_CARGA_CONCLUSIONES')
                .val(response.REPORTE_CARGA_CONCLUSIONES);

            $('#REPORTE_FALTA_CONCLUSIONES')
                .val(response.REPORTE_FALTA_CONCLUSIONES);

            $('#REPORTE_ORGANIZACION_CONCLUSIONES')
                .val(response.REPORTE_ORGANIZACION_CONCLUSIONES);

            $('#REPORTE_JORNADA_CONCLUSIONES')
                .val(response.REPORTE_JORNADA_CONCLUSIONES);

            $('#REPORTE_INTERFERENCIA_CONCLUSIONES')
                .val(response.REPORTE_INTERFERENCIA_CONCLUSIONES);

            $('#REPORTE_LIDERAZGORELACIONES_CONCLUSIONES')
                .val(response.REPORTE_LIDERAZGORELACIONES_CONCLUSIONES);

            $('#REPORTE_LIDERAZGO_CONCLUSIONES')
                .val(response.REPORTE_LIDERAZGO_CONCLUSIONES);

            $('#REPORTE_RELACIONES_CONCLUSIONES')
                .val(response.REPORTE_RELACIONES_CONCLUSIONES);

            $('#REPORTE_VIOLENCIA_CONCLUSIONES')
                .val(response.REPORTE_VIOLENCIA_CONCLUSIONES);

            $('#REPORTE_ENTORNO_CONCLUSIONES')
                .val(response.REPORTE_ENTORNO_CONCLUSIONES);

            $('#REPORTE_RECONOCIMIENTO_CONCLUSIONES')
                .val(response.REPORTE_RECONOCIMIENTO_CONCLUSIONES);

            $('#REPORTE_INSUFICIENTE_CONCLUSIONES')
                .val(response.REPORTE_INSUFICIENTE_CONCLUSIONES);
			
			$('#INFORME_RESPONSABLE1')
				.val(response.INFORME_RESPONSABLE1);


			$('#INFORME_RESPONSABLE1CARGO')
				.val(response.INFORME_RESPONSABLE1CARGO);



			$('#INFORME_RESPONSABLE2')
				.val(response.INFORME_RESPONSABLE2);



		    $('#INFORME_RESPONSABLE2CARGO')
                .val(response.INFORME_RESPONSABLE2CARGO);
            
            
            
                    
			   if(response.RUTA_IMAGEN_UBICACION)
            {

                var archivo = response.RUTA_IMAGEN_UBICACION;

                var extension = archivo.substring(
                    archivo.lastIndexOf(".")
                );



                var imagenUrl =
                    '/mostrarubicacioninformepsico/0/' +
                    proyecto.id +
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
                '/mostrarresponsable1infopsico/0/' +
                 proyecto.id +
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
                '/mostrarresponsable2infopsico/0/' +
                proyecto.id +
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



///// INTRODUCCION


$("#form_reporte_introduccion").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardarIntroduccioninfopsico',
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


//// DEFINICIONES


$("#form_reporte_listadefiniciones").on("submit", function(e)
{
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardarDefinicionesInformepsico',
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


function cargarDefinicionesInformepsico()
{

    $.get(
        '/obtenerDefinicionesInformepsico/' + proyecto.id,

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


///// OBJETIVOS GENERALES Y ESPECIFICO 


$("#form_reporte_objetivogeneral").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarObjetivoGeneralinformepsico',
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

$("#form_reporte_objetivoespecifico").on("submit", function (e)
{
    e.preventDefault();

    let formData = new FormData(this);

    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarObjetivoEspecificoinformepsico',
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

//// RECONOCIMIENTO
$("#form_reporte_ubicacion").on("submit", function(e)
{
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarUbicacioninformepsico',
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
            $("#botonguardar_reporte_ubicacion").prop('disabled', true);
            $("#botonguardar_reporte_ubicacion").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
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
            $("#botonguardar_reporte_ubicacion").prop('disabled', false);
            $("#botonguardar_reporte_ubicacion").html('Guardar ubicación <i class="fa fa-save"></i>');
        }
    });
});

//// DESCRIPCION DEL PROCESO DE INSTALACION

$("#form_reporte_procesoinstalacion").on(
    "submit",
    function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarProcesoInstalacioninformepsico',
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


//// DESCRIPCION METODO REALIZADO PARA LA EVALUACION


$("#form_reporte_descripcionmetodo").on(
    "submit",
    function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardardescripcionmetodoinformepsicio',
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
            $("#botonguardar_reporte_descripcionmetodo").prop('disabled', true);
            $("#botonguardar_reporte_descripcionmetodo").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
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
            $("#botonguardar_reporte_descripcionmetodo").prop('disabled', false);
            $("#botonguardar_reporte_descripcionmetodo").html('Guardar método realizado para la evaluación <i class="fa fa-save"></i>');
        }
    });
});

/// CONCLUSIONES


$("#form_reporte_conclusion").on(
    "submit",
    function(e)
{

    e.preventDefault();
    let formData = new FormData(this);
    
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarconclusionesinformepsicio',
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
            $("#botonguardar_reporte_conclusion").html('Guardar conclusiones <i class="fa fa-save"></i>');
        }
    });
});

/// RECOMENDACIONES

$("#form_reporte_recomendaciones_control").on(
    "submit",
    function(e)
{

    e.preventDefault();

    let formData = new FormData(this);

    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarRecomendacionesInformepsico',
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
            $("#botonguardar_reporte_recomendaciones_control").prop('disabled', true);
            $("#botonguardar_reporte_recomendaciones_control").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
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
            $("#botonguardar_reporte_recomendaciones_control").prop('disabled', false);
            $("#botonguardar_reporte_recomendaciones_control").html('Guardar recomendaciones <i class="fa fa-save"></i>');
        }
    });
});


function cargarRecomendacionesInformepsico()
{

    $.get(
        '/obtenerRecomendacionesInformepsico/' + proyecto.id,

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



/// RESPONSABLE


$("#form_reporte_responsablesinforme").on(
    "submit",
    function(e)
{

    e.preventDefault();

    let formData = new FormData(this);

    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardarResponsablesInformepsico',
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


tablaVersionesinfopsico();
validarEdicioninfopsico();
            
/// VERSIONES

function tablaVersionesinfopsico()
{

    try {

        let ruta =
            "/tablaVersionesinfopsico/" +
            proyecto.id;

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


$("#boton_reporte_nuevarevision")
.on("click", function()
{

    $.ajax({

        url: '/crearRevisioninfopsico',
        type: 'POST',
        data: {
            PROYECTO_ID: proyecto.id,
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

            tablaVersionesinfopsico();
			validarEdicioninfopsico()
        }
    });
});


function cancelarRevisioninfopsico(ID_VERSION_INFO_PSICO,checkbox)
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
                url:'/cancelarRevisionpsicoinfo',
                type: 'POST',
                data: {
                    ID_VERSION_INFO_PSICO: ID_VERSION_INFO_PSICO,
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

                    tablaVersionesinfopsico();
                    validarEdicioninfopsico();
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


function validarEdicioninfopsico()
{

    $.get(
        '/validarEdicioninfopsico/' +  proyecto.id,
        function(response)
        {

            let botones = `
                #botonguardar_reporte_portada,
                #botonguardar_reporte_introduccion,
                #botonguardar_reporte_definiciones,
                #botonguardar_reporte_objetivogeneral,
                #botonguardar_reporte_objetivoespecifico,
                #botonguardar_reporte_ubicacion,
                #botonguardar_reporte_procesoinstalacion,
                #botonguardar_reporte_descripcionmetodo,
                #botonguardar_reporte_conclusion,
                #botonguardar_reporte_recomendaciones_control,
                #botonguardar_reporte_recomendaciones_categoria,
                #botonguardar_reporte_responsablesinforme

            `;


            if(response.permite_guardar == 0)
            {

                $(botones).prop('disabled', true);
                $('input, textarea, select').not('.checkbox_cancelado_revision').prop('disabled', true);

                Swal.fire({
                    icon: 'warning',
                    title: 'Informe finalizado',
                    text:'La revisión fue finalizada y ya no puede editarse'
                });
            }
            else
            {

                $(botones).prop('disabled', false);
                $('input, textarea, select').prop('disabled', false);

            }


            if(response.cancelado == 1)
            {

                Swal.fire({
                    icon: 'info',
                    title: 'Revisión cancelada',
                    text: 'La última revisión fue cancelada, puede continuar editando'
                });
            }
        }
    );
}

//// ADICIONAL


function obtenerNumeroTrabajadoresPsico()
{
    $.get(
        '/obtenerNumeroTrabajadoresPsico/' + proyecto.id,
        function(response)
        {
            $('#NUMERO_TRABAJADORES').text(response.numero_trabajadores);
        }
    );
}

///// DESCARGAR INFO


async function descargarRevisioninfopsico(PROYECTO_ID)
{
    try {

        const dashboard =
            document.querySelector(
                '#tabla_dashboard'
            );

        if (!dashboard) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontró el dashboard para generar la imagen'
            });

            return;
        }


        if (document.fonts && document.fonts.ready) {

            await document.fonts.ready;
        }

        window.dispatchEvent(
            new Event('resize')
        );


        await new Promise(function(resolve)
        {
            setTimeout(resolve, 1000);
        });


        const canvas = await html2canvas(
            dashboard,
            {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#FFFFFF',
                logging: false,
                scrollX: 0,
                scrollY: -window.scrollY,
                width: dashboard.scrollWidth,
                height: dashboard.scrollHeight,
                windowWidth: document.documentElement.scrollWidth,
                windowHeight: document.documentElement.scrollHeight
            }
        );




        const dashboardBase64 =
            canvas.toDataURL(
                'image/jpeg',
                0.95
            );


        if (
            !dashboardBase64 ||
            dashboardBase64.length < 100
        ) {

            throw new Error(
                'No fue posible generar la imagen del dashboard'
            );
        }


        let form = $('<form>', {

            action:
                '/descargarRevisioninfopsico/' + proyecto.id,
            method:'POST',
            target:'_blank',
            style: 'display:none;'

        });


        form.append(
            $('<input>', {
                type:'hidden',
                name:'_token',
                value:
                    $('meta[name="csrf-token"]')
                    .attr('content')

            })

        );

        form.append(
            $('<input>', {
                type:'hidden',
                name:'DASHBOARD_FOTO',
                value:  dashboardBase64

            })

        );


        $('body').append(form);

        form.submit();

        setTimeout(function()
        {
            form.remove();

        }, 2000);

    } catch (error) {

        console.error(
            'Error al capturar el dashboard:',
            error
        );

        Swal.fire({
            icon:'error',
            title: 'Error',
            text: 'No fue posible generar la imagen del dashboard'
        });
    }
}


// async function descargarRevisioninfopsico(PROYECTO_ID)
// {


//     let form = $('<form>', {

//         action: '/descargarRevisioninfopsico/' + proyecto.id,
//         method: 'POST',
//         target: '_blank'
//     });



//     form.append(

//         $('<input>', {
//             type: 'hidden',
//             name: '_token',
//             value: $('meta[name="csrf-token"]').attr('content')
//         })
//     );

//     $('body').append(form);

//     form.submit();

//     setTimeout(function () {
//         form.remove();
//     }, 1000);

// }




////// GRAFICAS


// GENERO


function cargarGraficaGeneroPsico()
{
    $.get(
        '/obtenerGraficaGeneroPsico/' + proyecto.id,
        function(response)
        {
           let hombres = parseInt(response.hombres);
            let mujeres = parseInt(response.mujeres);

            let total = hombres + mujeres;

            let porcentajeHombres = total > 0 ? ((hombres * 100) / total).toFixed(2) : 0;
            let porcentajeMujeres = total > 0 ? ((mujeres * 100) / total).toFixed(2) : 0;

            $('#lblHombres').html('Hombres: ' + hombres + ' (' + porcentajeHombres + '%)');
            $('#lblMujeres').html('Mujeres: ' + mujeres + ' (' + porcentajeMujeres + '%)');
            $('#stopHombreColor').attr('offset', porcentajeHombres + '%');
            $('#stopHombreBlanco').attr('offset', porcentajeHombres + '%');
            $('#stopMujerColor').attr('offset', porcentajeMujeres + '%');
            $('#stopMujerBlanco').attr('offset', porcentajeMujeres + '%');

        }
    );
}

// EDADES

let chartEdades = null;
let edadeschart = null;

function cargarGraficaEdadesPsico()
{
    $.get(
        '/obtenerGraficaEdadesPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaEdadesPsico(
                response.data,
                response.maximo
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar las edades'
        });
    });
}



function generarGraficaEdadesPsico(edadData, maximo)
{
    if (!Array.isArray(edadData)) {
        edadData = [];
    }

    if (chartEdades) {
        chartEdades.destroy();
        chartEdades = null;
    }

    $('#grafica_edad').empty();


    const categoriasEdad = edadData.map(function(item) {
        return item.categoria;
    });

    const valoresEdad = edadData.map(function(item) {
        return parseInt(item.total) || 0;
    });

    const coloresEdad = edadData.map(function(item) {
        return item.color;
    });


    const totalTrabajadores = valoresEdad.reduce(
        function(acumulado, valor)
        {
            return acumulado + valor;
        },
        0
    );


    let maximoEscala = parseInt(maximo) || 1;

    maximoEscala = maximoEscala + 1;


    const optionsEdades = {

        series: [
            {
                name: 'Trabajadores',
                data: valoresEdad
            }
        ],

        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true
            }
        },

        colors: coloresEdad,
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                barHeight: '58%',
                borderRadius: 4,
                dataLabels: {
                    position: 'center'
                }
            }
        },

        dataLabels: {
            enabled: true,

            formatter: function(valor)
            {
                let cantidad = parseInt(valor) || 0;

                let porcentaje = totalTrabajadores > 0
                    ? (
                        cantidad * 100 /
                        totalTrabajadores
                    ).toFixed(2)
                    : '0.00';

                return cantidad +
                    ' (' +
                    porcentaje +
                    '%)';
            },
            style: {
                fontSize: '11px',
                fontWeight: 'bold',
                colors: ['#FFFFFF']
            },
            dropShadow: {
                enabled: true,
                left: 1,
                top: 1,
                opacity: 0.5
            }
        },

        xaxis: {
            categories: categoriasEdad,
            min: 0,
            max: maximoEscala,
            tickAmount: Math.min(
                maximoEscala,
                10
            ),
            labels: {
                formatter: function(valor) {
                    return Math.round(valor);
                },
                style: {
                    fontSize: '12px'
                }
            }
        },

        yaxis: {
            labels: {
                maxWidth: 190,
                style: {
                    fontSize: '13px',
                    fontWeight: 600,
                    colors: coloresEdad
                }
            }
        },

        grid: {
            borderColor: '#E5E5E5',
            strokeDashArray: 3,
            padding: {
                left: 10,
                right: 20,
                top: 10,
                bottom: 5
            }
        },

        legend: {
            show: false
        },


        tooltip: {
            y: {
                formatter: function(valor)
                {
                    let cantidad = parseInt(valor) || 0;
                    let porcentaje = totalTrabajadores > 0
                        ? (
                            cantidad * 100 /
                            totalTrabajadores
                        ).toFixed(2)
                        : '0.00';
                    return cantidad +
                        (
                            cantidad === 1
                                ? ' trabajador'
                                : ' trabajadores'
                        ) +
                        ' (' +
                        porcentaje +
                        '%)';
                }
            }
        }
    };


    chartEdades = new ApexCharts(
        document.querySelector('#grafica_edad'),
        optionsEdades
    );

    chartEdades.render()
        .then(function()
        {
            setTimeout(function()
            {
                chartEdades.dataURI()
                    .then(function(uri)
                    {
                        edadeschart = uri;
                    })
                    .catch(function(error)
                    {
                      console.error('Error al exportar gráfica de edades:',error);
                    });
            }, 1000);
        });
}

// ESCOLARIDAD

let chartEscolaridad = null;
let escolaridadchart = null;



function cargarGraficaEscolaridadPsico()
{
    $.get(
        '/obtenerGraficaEscolaridadPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaEscolaridadPsico(
                response.data,
                response.total_trabajadores,
                response.maximo
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la escolaridad'
        });
    });
}



function generarGraficaEscolaridadPsico(datosEscolaridad, totalTrabajadores,maximo)
{

    if (!Array.isArray(datosEscolaridad)) {
        datosEscolaridad = [];
    }

    if (chartEscolaridad) {
        chartEscolaridad.destroy();
        chartEscolaridad = null;
    }

    $('#grafica_escolaridad').empty();

    const datosFiltrados =
        datosEscolaridad.filter(function(item)
        {
            return parseInt(item.valor) > 0;
        });


    if (datosFiltrados.length === 0) {

        $('#grafica_escolaridad').html(`
            <div
                style="
                    width:100%;
                    padding:40px 10px;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información de escolaridad
            </div>
        `);

        escolaridadchart = null;

        return;
    }


    const categorias =
        datosFiltrados.map(function(item)
        {
            return item.categoria;
        });

    const valores =
        datosFiltrados.map(function(item)
        {
            return parseInt(item.valor) || 0;
        });


    let total = parseInt(totalTrabajadores) || 0;

   
    if (total === 0) {

        total = valores.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    let maximoEscala = parseInt(maximo) || 1;

    maximoEscala = maximoEscala + 1;

    const alturaGrafica =
        Math.max(
            240,
            datosFiltrados.length * 48
        );

    const optionsEscolaridad = {

        chart: {
            type: 'bar',
            height: alturaGrafica,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true
            }

        },

        series: [
            {
                name: 'Escolaridad',
                data: valores
            }
        ],

        colors: ['#98c11d'],

        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 4,
                barHeight: '70%',
                dataLabels: { position: 'center'}
            }
        },




        dataLabels: {
            enabled: true,
            formatter: function(valor)
            {
                const cantidad =
                    parseInt(valor) || 0;

                const porcentaje =
                    total > 0
                        ? (
                            cantidad *
                            100 /
                            total
                        ).toFixed(2)
                        : '0.00';

                return cantidad +
                    ' (' +
                    porcentaje +
                    '%)';
            },

            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                colors: ['#FFFFFF']
            },

            dropShadow: {
                enabled: true,
                left: 1,
                top: 1,
                opacity: 0.5
            }
        },

        xaxis: {
            categories: categorias,
            min: 0,
            max: maximoEscala,
            tickAmount: Math.min(
                maximoEscala,
                10
            ),
            labels: {
                formatter: function(valor)
                {
                    return Math.round(valor);
                },
                style: { fontSize: '12px'
                }
            }
        },

        yaxis: {
            labels: {
                maxWidth: 180,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            }
        },

        grid: {
            borderColor: '#E5E5E5',
            strokeDashArray: 3,
            padding: {
                left: 10,
                right: 20,
                top: 5,
                bottom: 5
            }
        },

        legend: { show: false },

        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(valor)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const porcentaje =
                        total > 0
                            ? (
                                cantidad *
                                100 /
                                total
                            ).toFixed(2)
                            : '0.00';

                    return cantidad +
                        (
                            cantidad === 1
                                ? ' trabajador'
                                : ' trabajadores'
                        ) +
                        ' (' +
                        porcentaje +
                        '%)';
                }
            }
        }
    };


    chartEscolaridad = new ApexCharts(
        document.querySelector('#grafica_escolaridad'),
        optionsEscolaridad
    );

    chartEscolaridad.render()
        .then(function()
        {
            setTimeout(function()
            {
                chartEscolaridad.dataURI()
                    .then(function(uri)
                    {
                        escolaridadchart = uri;
                    })
                    .catch(function(error)
                    {
                        console.error(
                            'Error al exportar gráfica de escolaridad:',
                            error
                        );
                    });

            }, 1000);
        });
}

// ESTADO CIVIL


let chartEstadoCivil = null;
let estadocivilchart = null;



function cargarGraficaEstadoCivilPsico()
{
    $.get(
        '/obtenerGraficaEstadoCivilPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaEstadoCivilPsico(
                response.data,
                response.total_trabajadores,
                response.maximo
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar el estado civil'
        });
    });
}



function generarGraficaEstadoCivilPsico(estadoCivilData, totalTrabajadores, maximo)
{



    if (!Array.isArray(estadoCivilData)) {
        estadoCivilData = [];
    }


    if (chartEstadoCivil) {
        chartEstadoCivil.destroy();
        chartEstadoCivil = null;
    }

    $('#grafica_estadocivil').empty();


    const datosFiltrados =
        estadoCivilData.filter(function(item)
        {
            return parseInt(item.total) > 0;
        });

   
    if (datosFiltrados.length === 0) {

        $('#grafica_estadocivil').html(`
            <div
                style="
                    width:100%;
                    padding:40px 10px;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información de estado civil
            </div>
        `);

        estadocivilchart = null;

        return;
    }

    const categoriasEstadoCivil =
        datosFiltrados.map(function(item)
        {
            return item.categoria;
        });

    const valoresEstadoCivil =
        datosFiltrados.map(function(item)
        {
            return parseInt(item.total) || 0;
        });

    const coloresEstadoCivil =
        datosFiltrados.map(function(item)
        {
            return item.color;
        });


    let total = parseInt(totalTrabajadores) || 0;

    if (total === 0) {

        total = valoresEstadoCivil.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }


    let maximoEscala = parseInt(maximo) || 1;

    maximoEscala = maximoEscala + 1;

    const optionsEstadoCivil = {
        series: [
            {
                name: 'Trabajadores',
                data: valoresEstadoCivil
            }
        ],

      chart: {
            type: 'bar',
            height: 250,
            offsetY: -8,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true
            }
        },

        colors: coloresEstadoCivil,

        plotOptions: {
            bar: {
                columnWidth: '65%',
                distributed: true,
                borderRadius: 3,
                dataLabels: {
                    position: 'top'
                }
            }
        },

        dataLabels: {
            enabled: true,
            offsetY: -24,
            formatter: function(valor)
            {
                const cantidad =
                    parseInt(valor) || 0;

                const porcentaje =
                    total > 0
                        ? (
                            cantidad *
                            100 /
                            total
                        ).toFixed(2)
                        : '0.00';

                return cantidad +
                    ' (' +
                    porcentaje +
                    '%)';
            },

            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                colors: [
                    '#000000'
                ]
            },
            dropShadow: {
                enabled: false
            }
        },

     xaxis: {
            categories: categoriasEstadoCivil,

            labels: {
                offsetY: -3,
                trim: false,
                rotate: 0,

                style: {
                    colors: coloresEstadoCivil,
                    fontSize: '12px',
                    fontWeight: 600
                }
            }
        },

        yaxis: {
            min: 0,
            max: maximoEscala,
            tickAmount: Math.min(
                maximoEscala,
                10
            ),
            labels: {
                formatter: function(valor)
                {
                    return Math.round(valor);
                },
                style: {fontSize: '11px'}
            }
        },

      grid: {
            padding: {
                left: 5,
                right: 10,
                top: 10,
                bottom: 0
            }
        },


        legend: {show: false},

        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(valor)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const porcentaje =
                        total > 0
                            ? (
                                cantidad *
                                100 /
                                total
                            ).toFixed(2)
                            : '0.00';

                    return cantidad +
                        (
                            cantidad === 1
                                ? ' trabajador'
                                : ' trabajadores'
                        ) +
                        ' (' +
                        porcentaje +
                        '%)';
                }
            }
        }
    };

    chartEstadoCivil = new ApexCharts(
        document.querySelector('#grafica_estadocivil'),
        optionsEstadoCivil
    );


    chartEstadoCivil.render()
        .then(function()
        {
            setTimeout(function()
            {
                chartEstadoCivil.dataURI()
                    .then(function(uri)
                    {
                        estadocivilchart = uri;
                    })
                    .catch(function(error)
                    {
                        console.error(
                            'Error al exportar gráfica de estado civil:',
                            error
                        );
                    });

            }, 1000);
        });
}


// REGIMEN

let chartRegimen = null;
let regimenchart = null;



function cargarGraficaRegimenPsico()
{
    $.get(
        '/obtenerGraficaRegimenPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaRegimenPsico(
                response.data,
                response.total_trabajadores
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar el régimen'
        });
    });
}



function generarGraficaRegimenPsico(regimenData, totalTrabajadores)
{

    if (!Array.isArray(regimenData)) {
        regimenData = [];
    }

    if (chartRegimen) {

        chartRegimen.destroy();

        chartRegimen = null;
    }

    $('#grafica_regimen').empty();

    const datosFiltrados =
        regimenData.filter(function(item)
        {
            return parseInt(item.valor) > 0;
        });



    if (datosFiltrados.length === 0) {

        $('#grafica_regimen').html(`
            <div
                style="
                    width:100%;
                    padding:40px 10px;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información de régimen
            </div>
        `);
        regimenchart = null;
        return;
    }



    const valoresRegimen =
        datosFiltrados.map(function(item)
        {
            return parseInt(item.valor) || 0;
        });

    const coloresRegimen =
        datosFiltrados.map(function(item)
        {
            return item.color;
        });

    const categoriasRegimen =
        datosFiltrados.map(function(item)
        {
            return item.categoria;
        });

    let total = parseInt(totalTrabajadores) || 0;
    if (total === 0) {
        total = valoresRegimen.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    const optionsRegimen = {

        series: valoresRegimen,

        chart: {
            type: 'donut',
            height: 240,
            toolbar: {
                show: false
            },
            animations: {
                enabled: true
            }
        },

        colors: coloresRegimen,
        labels: categoriasRegimen,

        dataLabels: {
            enabled: false
        },


        plotOptions: {
            pie: {
                offsetY: 2,
                donut: {
                    size: '45%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '12px'
                        },
                        value: {
                            show: true,
                            fontSize: '18px',
                            fontWeight: 'bold'
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '12px',
                            formatter: function()
                            {
                                return total;
                            }
                        }
                    }
                }
            }
        },


        legend: {
            show: true,
            position: 'bottom',
            fontSize: '10px',
            horizontalAlign: 'center',

            offsetY: -4,
            itemMargin: {
                horizontal: 5,
                vertical: 1
            },

            formatter: function(seriesName, opts)
            {
                const cantidad =
                    opts.w.globals.series[
                        opts.seriesIndex
                    ];

                const porcentaje =
                    total > 0
                        ? (
                            cantidad *
                            100 /
                            total
                        ).toFixed(2)
                        : '0.00';

                return seriesName +
                    ': ' +
                    cantidad +
                    ' (' +
                    porcentaje +
                    '%)';
            }

        },


        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(valor)
                {
                    const cantidad =
                        parseInt(valor) || 0;
                    const porcentaje =
                        total > 0
                            ? (
                                cantidad *
                                100 /
                                total
                            ).toFixed(2)
                            : '0.00';
                    return cantidad +
                        (
                            cantidad === 1
                                ? ' trabajador'
                                : ' trabajadores'
                        ) +
                        ' (' +
                        porcentaje +
                        '%)';
                }
            }
        },

        responsive: [

            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 230
                    },
                    plotOptions: {
                        pie: {
                            offsetY: 0
                        }
                    },
                    legend: {
                        position: 'bottom',
                        offsetY: -3
                    }
                }
            }
        ]
    };
    
    chartRegimen = new ApexCharts(
        document.querySelector('#grafica_regimen'),
        optionsRegimen
    );

    chartRegimen.render()
        .then(function()
        {
            setTimeout(function()
            {
                chartRegimen.dataURI()
                    .then(function(uri)
                    {
                        regimenchart = uri;
                    })
                    .catch(function(error)
                    {
                        console.error(
                            'Error al exportar gráfica de régimen:',
                            error
                        );
                    });

            }, 1000);
        });
}

// EXPERIENCIA LABORAL

let chartExperiencia = null;
let experienciachart = null;



function cargarGraficaExperienciaPsico()
{
    $.get(
        '/obtenerGraficaExperienciaPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaExperienciaPsico(
                response.data,
                response.total_trabajadores
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la experiencia laboral'
        });
    });
}



function generarGraficaExperienciaPsico(experienciaData,totalTrabajadores)
{

    if (!Array.isArray(experienciaData)) {
        experienciaData = [];
    }

    if (chartExperiencia) {
        chartExperiencia.destroy();
        chartExperiencia = null;
    }

    $('#grafica_experiencia').empty();

    const datosFiltrados =
        experienciaData.filter(function(item)
        {
            return parseInt(item.valor) > 0;
        });



    if (datosFiltrados.length === 0) {

        $('#grafica_experiencia').html(`
            <div
                style="
                    width:100%;
                    padding:40px 10px;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información de experiencia laboral
            </div>
        `);

        experienciachart = null;

        return;
    }

    const valoresExperiencia =
        datosFiltrados.map(function(item)
        {
            return parseInt(item.valor) || 0;
        });

    const coloresExperiencia =
        datosFiltrados.map(function(item)
        {
            return item.color;
        });

    const rangosExperiencia =
        datosFiltrados.map(function(item)
        {
            return item.rango;
        });


    let total = parseInt(totalTrabajadores) || 0;

    if (total === 0) {

        total = valoresExperiencia.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    const optionsExperiencia = {

        series: valoresExperiencia,
        chart: {
            type: 'pie',
            height: 240,
            toolbar: {
                show: false
            },

            animations: {
                enabled: false
            }
        },



        labels: rangosExperiencia,


        colors: coloresExperiencia,

        dataLabels: {
            enabled: false
        },

        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '9px',
            offsetY: -3,
            itemMargin: {
                horizontal: 4,
                vertical: 1

            },

            formatter: function(
                seriesName,
                opts
            ) {

                const cantidad =
                    opts.w.globals.series[
                        opts.seriesIndex
                    ];

                const porcentaje =
                    total > 0
                        ? (
                            cantidad *
                            100 /
                            total
                        ).toFixed(2)
                        : '0.00';

                return seriesName +
                    ': ' +
                    cantidad +
                    ' (' +
                    porcentaje +
                    '%)';
            }
        },


        tooltip: {
            theme: 'dark',
            y: {

                formatter: function(valor)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const porcentaje =
                        total > 0
                            ? (
                                cantidad *
                                100 /
                                total
                            ).toFixed(2)
                            : '0.00';

                    return cantidad +
                        (
                            cantidad === 1
                                ? ' trabajador'
                                : ' trabajadores'
                        ) +
                        ' (' +
                        porcentaje +
                        '%)';
                }
            }
        },


        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 230
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '8px',
                        offsetY: -2
                    }
                }
            }
        ]
    };

    chartExperiencia = new ApexCharts(
        document.querySelector('#grafica_experiencia'),optionsExperiencia
    );

    chartExperiencia.render()
        .then(function()
        {
            setTimeout(function()
            {
                chartExperiencia.dataURI()
                    .then(function(uri)
                    {
                        experienciachart = uri;
                    })
                    .catch(function(error)
                    {
                        console.error(
                            'Error al exportar gráfica de experiencia:',
                            error
                        );
                    });
            }, 1000);
        });
}

am5.ready(function () {
	function createChart(containerId, titleText, subtitleText, data, chartName) {
		// Crear root
		var root = am5.Root.new(containerId);
		root.setThemes([am5themes_Animated.new(root)]);

		// Crear el gráfico
		var chart = root.container.children.push(am5xy.XYChart.new(root, {
			panX: false,
			panY: false,
			wheelX: "none",
			wheelY: "none",
			layout: root.verticalLayout
		}));

		// Títulos
		// chart.children.unshift(
		// 	am5.Label.new(root, {
		// 		text: subtitleText,
		// 		fontSize: 20,
		// 		textAlign: "center",
		// 		x: am5.p50,
		// 		centerX: am5.p50,
		// 		marginTop: 10,
		// 	})
		// );
		chart.children.unshift(
			am5.Label.new(root, {
				text: titleText,
				fontSize: 18,
				fontWeight: "bold",
				textAlign: "center",
				x: am5.p50,
				centerX: am5.p50
			})
		);

		// Leyenda
		var legend = chart.children.push(
			am5.Legend.new(root, {
				centerX: am5.p50,
				x: am5.p50
			})
		);
		legend.labels.template.set("fontSize", 20);

		// Ejes
		var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
			categoryField: "category",
			renderer: am5xy.AxisRendererY.new(root, {
				inversed: true,
				cellStartLocation: 0,
				cellEndLocation: 0.9,
				minGridDistance: 0,
				// opposite: true
			}),
			tooltip: am5.Tooltip.new(root, {})
		}));

		yAxis.get("renderer").grid.template.set("forceHidden", true);

		yAxis.get("renderer").labels.template.setAll({
            fontSize: 18,
            fontWeight: "70",
            centerY: am5.p50,
            centerX: am5.p0,
            textAlign: "center",
            inside: true,  // Poner las etiquetas dentro del área del gráfico
            rotation: 0,
            paddingTop: -100  // Ajustar la posición vertical de las etiquetas
        }); 

		yAxis.data.setAll(data);

		var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
			renderer: am5xy.AxisRendererX.new(root, {
				minGridDistance: 50
			}),
			min: 0,
			strictMinMax: true,  // Esto fuerza a que solo se muestre hasta el valor máximo real
			maxDeviation: 0
		}));

		xAxis.get("renderer").grid.template.set("forceHidden", true);
		xAxis.get("renderer").labels.template.setAll({
			forceHidden: true
		});
		// Formatear etiquetas de categorías
		yAxis.get("renderer").labels.template.adapters.add("text", function (text, target) {
			if (target.dataItem) {
				let category = target.dataItem.get("category");
				if (category.startsWith("g1")) {
					return "[bold]" + category.split("-")[1] + "[/]";
				}
				if (category.startsWith("g3")) {
					target.set("x", target.get("x") + 28); // Mover la categoría a la derecha
					//return category.split("-")[1];  // No hace falta modificar el texto, solo moverlo
				}
				return "[bold]" + category.split("-")[1] + "[/]";
			}
			return text;
		});

		// Calcular porcentajes y agregar al dataset
		function calculatePercentages(data) {
			return data.map(item => {
				const total = (item.s1 || 0) + (item.s2 || 0) + (item.s3 || 0) + (item.s4 || 0) + (item.s5 || 0);
				if (total > 0) {
					return {
						...item,
						percentage_s1: ((item.s1 || 0) / total * 100).toFixed(1),
						percentage_s2: ((item.s2 || 0) / total * 100).toFixed(1),
						percentage_s3: ((item.s3 || 0) / total * 100).toFixed(1),
						percentage_s4: ((item.s4 || 0) / total * 100).toFixed(1),
						percentage_s5: ((item.s5 || 0) / total * 100).toFixed(1),
					};
				}
				return { ...item, percentage_s1: 0, percentage_s2: 0, percentage_s3: 0, percentage_s4: 0, percentage_s5: 0 };
			});
		}

		const processedData = calculatePercentages(data);

		// Series
		function makeSeries(name, fieldName, percentageFieldName, color) {
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name: name,
				xAxis: xAxis,
				yAxis: yAxis,
				stacked: true,
				valueXField: fieldName,
				categoryYField: "category",
				stroke: color,
				fill: color
			}));

			series.columns.template.setAll({
				//tooltipText: "{name}, {categoryY}: {valueX} ({percentage}%)",
				width: am5.percent(100),
				tooltipY: 0
			});

			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 0.5,
					locationY: 0.5,
					sprite: am5.Label.new(root, {
						text: "{valueX} ({percentage}%)",
						centerX: am5.p50,
						centerY: am5.p50,
						populateText: true,
						fontSize: "18px",
						fill: am5.color(0x000000),
						fontWeight: "bold"
					})
				});
			});

			series.data.setAll(
				processedData.map(item => ({
					...item,
					percentage: item[percentageFieldName],
				}))
			);
			series.appear();
			legend.data.push(series);
		}

		// Crear series
		makeSeries("Muy alto", "s1", "percentage_s1", am5.color(0xFF0000));
		makeSeries("Alto", "s2", "percentage_s2", am5.color(0xF7AA32));
		makeSeries("Medio", "s3", "percentage_s3", am5.color(0xFFFF00));
		makeSeries("Bajo", "s4", "percentage_s4", am5.color(0x00B050));
		makeSeries("Nulo", "s5", "percentage_s5", am5.color(0x00B0F0));


		chart.appear(1000, 100).then(() => {
			setTimeout(() => {
				if (typeof am5plugins_exporting !== 'undefined') {
					console.log('Plugin de exportación dispo');

					var exporting = am5plugins_exporting.Exporting.new(root, {
						menu: am5plugins_exporting.ExportingMenu.new(root, {}),
						dpi: 300, // Ajusta el DPI para mejorar la calidad de la imagen exportada
						// También puedes ajustar el tamaño de la imagen, si lo deseas
						maxWidth: 2000, // Ancho máximo en píxeles
						maxHeight: 2000,
					});
					console.log('si creo el exporting');

					exporting.export("png").then(function (data) {
						chartPngs[chartName] = data;
						console.log(chartName + " exportado exitosamente");
					}).catch(error => console.error('Error al exportar:', error));
				} else {
					console.log('Plugin de exportación no disponible');
				}
			}, 1000); // Aumenté el timeout
		});
	}




	// Crear gráficos
	createChart(
		"ambienteChart",
		"Categoría\n\n\n",
		"(Nivel de riesgo/NOM-035-STPS-2018)\n\n",
		[{
			category: "g1-Ambiente de trabajo\n",
			s1: 2, s2: 3, s3: 1, s4: 3, s5: 1
		}, {
			category: "g3-\n\n\nDominios:"
		}, {
			category: "g2-Condiciones del ambiente de trabajo\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		}],
		'ambienteChart'
	);

	createChart(
		"factoresChart",
		"Categoría\n\n\n",
		"(Nivel de riesgo/NOM-035-STPS-2018)\n\n",
		[{
			category: "g1-Factores propios de la actividad\n",
			s1: 2, s2: 3, s3: 1, s4: 3, s5: 1
		}, {
			category: "g3-\n\n\nDominios:"
		}, {
			category: "g2-Carga de trabajo\n",
			s1: 5, s2: 1, s3: 2, s4: 1, s5: 1
		}, {
			category: "g2-Falta de control sobre el trabajo\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		}],
		'factoresChart'
	);

	createChart(
		"organizacionChart",
		"Categoría\n\n\n",
		"(Nivel de riesgo/NOM-035-STPS-2018)\n\n",
		[{
			category: "g1-Organización del tiempo de trabajo\n",
			s1: 2, s2: 3, s3: 1, s4: 3, s5: 1
		}, {
			category: "g3-\n\n\nDominios:"
		}, {
			category: "g2-Jornada de trabajo\n",
			s1: 5, s2: 1, s3: 2, s4: 1, s5: 1
		},  {
			category: "g2-Interferencia trabajo/familia\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		}],
		'organizacionChart'
	);

	createChart(
		"liderazgoChart",
		"Categoría\n\n\n",
		"(Nivel de riesgo/NOM-035-STPS-2018)\n\n",
		[{
			category: "g1-Liderazgo y relaciones en el trabajo\n",
			s1: 2, s2: 3, s3: 1, s4: 3, s5: 1
		}, {
			category: "g3-\n\n\nDominios:"
		},
		{
			category: "g2-Liderazgo\n",
			s1: 5, s2: 1, s3: 2, s4: 1, s5: 1
		},
		 {
			category: "g2-Relaciones en el trabajo\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		},
		{
			category: "g2-Violencia\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		}],
		'liderazgoChart'
	);

	createChart(
		"entornoChart",
		"Categoría\n\n\n",
		"(Nivel de riesgo/NOM-035-STPS-2018)\n\n",
		[{
			category: "g1-Entorno organizacional\n",
			s1: 2, s2: 3, s3: 1, s4: 3, s5: 1
		}, {
			category: "g3-\n\n\nDominios:"
		}, {
			category: "g2-Reconocimiento del desempeño\n",
			s1: 5, s2: 1, s3: 2, s4: 1, s5: 1
		},
		 {
			category: "g2-Insuficiente sentido de pertenencia e inestabilidad\n",
			s1: 3, s2: 2, s3: 2, s4: 2, s5: 1
		}],
		'entornoChart'
	);
	// dashboard

	var guia1_root = am5.Root.new("guia1Chart");

	// Establecer temas
	guia1_root.setThemes([
		am5themes_Animated.new(guia1_root)
	]);
	
	// Crear gráfico
	var guia1_chart = guia1_root.container.children.push(am5percent.PieChart.new(guia1_root, {
		startAngle: 180,
		endAngle: 360,
		layout: guia1_root.verticalLayout,
		innerRadius: am5.percent(50),
		paddingBottom: 0
	}));
	
	// Definir los colores primero
	const colors2 = {
		"Requiere valoración clinica": 0xFF0000,
		"No requiere valoración clinica": 0x00B0F0
	};
	
	// Crear leyenda con texto más grande y grueso
	let legend3 = guia1_chart.children.push(
		am5.Legend.new(guia1_root, {
			centerX: am5.percent(50),
			x: am5.percent(50),
			layout: guia1_root.verticalLayout,
			fontSize: 19,
			fontWeight: "bold",
			marginTop: -10,  // Reducir el margen superior
			dy: -10 // Mover la leyenda hacia arriba
		})
	);
	
	// Crear serie
	var guia1_series = guia1_chart.series.push(am5percent.PieSeries.new(guia1_root, {
		startAngle: 180,
		endAngle: 360,
		valueField: "value",
		categoryField: "category",
		alignLabels: false
	}));
	
	// Configurar etiquetas
	guia1_series.labels.template.setAll({
		fontSize: 19,
		fontWeight: "bold",
		text: "{value}"
	});
	
	// Configurar los colores y estilos de la leyenda
	legend3.labels.template.setAll({
		fontSize: 19,
		fontWeight: "bold"
	});
	
	legend3.valueLabels.template.setAll({
		fontSize: 19,
		fontWeight: "bold"
	});
	
	legend3.markers.template.setAll({
		width: 20,
		height: 20
	});
	
	// Estilo de las rebanadas
	guia1_series.slices.template.setAll({
		cornerRadius: 5,
		stroke: am5.color(0xFFFFFF)
	});
	
	guia1_series.slices.template.adapters.add("fill", function(fill, target) {
		var category = target.dataItem.get("category");
		return am5.color(colors2[category] || fill);
	});
	
	// Establecer datos
	guia1_series.data.setAll([
		{ value: 2, category: "Requiere valoración clinica" },
		{ value: 69, category: "No requiere valoración clinica" },
	]);
	
	// Conectar la leyenda con la serie
	legend3.data.setAll(guia1_series.dataItems);
	
	// Animación
	guia1_series.appear(1000, 100).then(() => {
		setTimeout(() => {
			if (typeof am5plugins_exporting !== 'undefined') {
				var exporting = am5plugins_exporting.Exporting.new(guia1_root, {
					menu: am5plugins_exporting.ExportingMenu.new(guia1_root, {}),
					dpi: 300,
					maxWidth: 2000,
					maxHeight: 2000,
				});
	
				exporting.export("png").then(function (data) {
					acontecimientoschart = data;
					console.log("guia1_chart exportado exitosamente");
				}).catch(error => console.error('Error al exportar:', error));
			} else {
				console.log('Plugin de exportación no disponible');
			}
		}, 1000);
	});
	

// 	// Crear un nuevo objeto root para el gráfico de régimen
// 	var rootGraficoGuia1 = am5.Root.new("guia1Chart"); // Cambié root a rootGraficoRegimen

// 	// Establecer el tema para el gráfico
// 	rootGraficoGuia1.setThemes([
// 		am5themes_Animated.new(rootGraficoGuia1)
// 	]);

// 	// Crear el gráfico de tipo Pie para el régimen
// 	var graficoguia1 = rootGraficoGuia1.container.children.push(am5percent.PieChart.new(rootGraficoGuia1, {
// 		layout: rootGraficoGuia1.verticalLayout,
// 		innerRadius: am5.percent(50)
// 	}));

// 	// Crear la serie de tipo Pie para el gráfico de régimen
// 	var seriegrafica1 = graficoguia1.series.push(am5percent.PieSeries.new(rootGraficoGuia1, {
// 		valueField: "valorgrafica1",  // Personalizado
// 		categoryField: "categoriagrafica1",  // Personalizado
// 		alignLabels: false
// 	}));

// 	// Configuración de las etiquetas en formato circular
// 	seriegrafica1.labels.template.setAll({
// 		textType: "circular",
// 		centerX: 0,
// 		centerY: 0
// 	});
// 	seriegrafica1.slices.template.setAll({
// 		tooltipText: "{categoryField}: {valueField}%", // Personaliza el texto del tooltip
// 		stroke: am5.color(0xffffff), // Color del borde
// 		strokeWidth: 2 // Grosor del borde
// 	});

// 	// Cambiar colores de las secciones
// 	seriegrafica1.get("colors").set("colors", [
// 		am5.color(0xff0000), // Rojo
// 		am5.color(0x0098c7)  // Verde
// 	]);
// 	// Establecer los datos para el gráfico de régimen (por ejemplo, plantas, sindicalizados, etc.)
// 	seriegrafica1.data.setAll([
// 		{ valorgrafica1: 2, categoriagrafica1: "Requiere valoración clinica" },
// 		{ valorgrafica1: 69, categoriagrafica1: "No requiere valoración clinica" },
// 	]);

// 	// Crear la leyenda para el gráfico de régimen
// 	var leyendagrafico1 = graficoguia1.children.push(am5.Legend.new(rootGraficoGuia1, {
// 		centerX: am5.percent(50),
// 		x: am5.percent(50),
// 		marginTop: 15,
// 		marginBottom: 15,
// 	}));
// 	leyendagrafico1.labels.template.setAll({
// 		fontSize: 14, // Tamaño de letra
// 		fontWeight: "bold", // Peso de la fuente
// 		fill: am5.color(0x333333) // Color de la letra
// 	});

// 	leyendagrafico1.markers.template.setAll({
// 		width: 20, // Ancho del marcador
// 		height: 20 // Alto del marcador
// 	});
// 	leyendagrafico1.data.setAll(seriegrafica1.dataItems);

// 	seriegrafica1.appear(1000, 100).then(() => {
// 		setTimeout(() => {
// 			if (typeof am5plugins_exporting !== 'undefined') {
// 				console.log('Plugin de exportación dispo');

// 				var exporting = am5plugins_exporting.Exporting.new(rootGraficoGuia1, {
// 					menu: am5plugins_exporting.ExportingMenu.new(rootGraficoGuia1, {}),
// 					dpi: 300, // Ajusta el DPI para mejorar la calidad de la imagen exportada
// 					// También puedes ajustar el tamaño de la imagen, si lo deseas
// 					maxWidth: 2000, // Ancho máximo en píxeles
// 					maxHeight: 2000,
// 				});
// 				console.log('si creo el exporting');

// 				exporting.export("png").then(function (data) {
// 					acontecimientoschart = data;
// 					console.log("acontecimientochart exportado exitosamente");
// 				}).catch(error => console.error('Error al exportar:', error));
// 			} else {
// 				console.log('Plugin de exportación no disponible');
// 			}
// 		}, 1000); // Aumenté el timeout
// 	});

});
var rootConsolidadoChart2 = am5.Root.new("consolidadoChart2");

// Crear tema personalizado
const customThemeConsolidado2 = am5.Theme.new(rootConsolidadoChart2);
customThemeConsolidado2.rule("Label").set("fontSize", 20);
customThemeConsolidado2.rule("Grid").set("strokeOpacity", 0); // Ocultar las líneas de porcentaje

// Definir los estilos para los ejes dentro del tema
customThemeConsolidado2.rule("AxisRenderer").setAll({
	background: am5.Rectangle.new(rootConsolidadoChart2, {
		fill: am5.color(0x000000),
		fillOpacity: 0.7
	})
});

// Establecer temas
rootConsolidadoChart2.setThemes([am5themes_Animated.new(rootConsolidadoChart2), customThemeConsolidado2]);

// Datos (con valores fijos para las 5 series)
var dataConsolidado2 = [
	{ "category": "Interferencia en la\n relacion\n trabajo-familia", "Nulo": 0.16, "Bajo": 0.20, "Medio": 0.24, "Alto": 0.29, "Muy alto": 0.11 },
	{ "category": "Jornada de\n trabajo", "Nulo": 0.14, "Bajo": 0.19, "Medio": 0.23, "Alto": 0.27, "Muy alto": 0.17 },
		{ "category": "Condiciones en el \nambiente de trabajo", "Nulo": 0.10, "Bajo": 0.15, "Medio": 0.20, "Alto": 0.25, "Muy alto": 0.30 },
		{ "category": "Liderazgo", "Nulo": 0.11, "Bajo": 0.16, "Medio": 0.19, "Alto": 0.24, "Muy alto": 0.30 },
		
		{ "category": "Carga de trabajo", "Nulo": 0.09, "Bajo": 0.36, "Medio": 0.21, "Alto": 0.26, "Muy alto": 0.08 },
		{ "category": "Relaciones en el trabajo", "Nulo": 0.14, "Bajo": 0.17, "Medio": 0.22, "Alto": 0.27, "Muy alto": 0.20 },
		{ "category": "Falta de control \nsobre el trabajo", "Nulo": 0.35, "Bajo": 0.18, "Medio": 0.22, "Alto": 0.15, "Muy alto": 0.10 },

		{ "category": "Violencia", "Nulo": 0.25, "Bajo": 0.10, "Medio": 0.20, "Alto": 0.40, "Muy alto": 0.05 }
	];

var colorSetConsolidado2 = am5.ColorSet.new(rootConsolidadoChart2, {});

// Modificar formato de números
rootConsolidadoChart2.numberFormatter.set("numberFormat", "#%");

// Crear gráfico
var chartConsolidado2 = rootConsolidadoChart2.container.children.push(am5radar.RadarChart.new(rootConsolidadoChart2, {
	panX: false,
	panY: false,
	wheelX: "none", // Removed zoom functionality
    wheelY: "none",
	innerRadius: am5.percent(10),
	radius: am5.percent(85)
}));

// Crear ejes
var categoryAxisRendererConsolidado2 = am5radar.AxisRendererCircular.new(rootConsolidadoChart2, {
	innerRadius: am5.percent(10)
});
var categoryAxisConsolidado2 = chartConsolidado2.xAxes.push(am5xy.CategoryAxis.new(rootConsolidadoChart2, {
	categoryField: "category",
	renderer: categoryAxisRendererConsolidado2
}));

categoryAxisRendererConsolidado2.labels.template.setAll({
	fill: am5.color(0x000000),
	fontSize: 24,
	fontWeight: "bold",
	paddingLeft: 5,
	paddingRight: 5,
	paddingTop: 2,
	paddingBottom: 2,
	radius: 5,
	centerX: am5.p50,
    centerY: am5.p50,
	 textAlign: "center"
});

categoryAxisConsolidado2.data.setAll(dataConsolidado2);

// Crear eje de valor
var valueAxisConsolidado2 = chartConsolidado2.yAxes.push(am5xy.ValueAxis.new(rootConsolidadoChart2, {
	renderer: am5radar.AxisRendererRadial.new(rootConsolidadoChart2, {}),
	min: 0,
	max: 1,
	strictMinMax: true,
	extraMax: 0.1
}));

valueAxisConsolidado2.get("renderer").labels.template.setAll({
	visible: false
});

// Crear series apiladas
var seriesNamesConsolidado2 = ["Nulo", "Bajo", "Medio", "Alto", "Muy alto"];
var seriesColorsConsolidado2 = [
	am5.color(0x00B0F0),
	am5.color(0x00B050),
	am5.color(0xFFFF00),
	am5.color(0xF7AA32),
	am5.color(0xFF0000)
];

seriesNamesConsolidado2.forEach((seriesName, index) => {
	var series = chartConsolidado2.series.push(am5radar.RadarColumnSeries.new(rootConsolidadoChart2, {
		stacked: true,
		name: seriesName,
		xAxis: categoryAxisConsolidado2,
		yAxis: valueAxisConsolidado2,
		valueYField: seriesName,
		categoryXField: "category"
	}));

	series.columns.template.setAll({
		tooltipText: "{name}: {valueY.formatNumber('#.##%')}",
		cornerRadius: 0,
		strokeOpacity: 1, // Changed from 0 to 1 to show borders
        stroke: am5.color(0x000000), // Added black border
        strokeWidth: 0.5, // Added border width
		fill: seriesColorsConsolidado2[index],
		width: am5.percent(100)
	});

	// Agregar etiquetas con porcentajes
	series.bullets.push(function () {
		return am5.Bullet.new(rootConsolidadoChart2, {
			sprite: am5.Label.new(rootConsolidadoChart2, {
				text: "{valueY.formatNumber('#.##%')}",
				populateText: true,
				centerX: am5.p50,
				centerY: am5.p50,
				fill: am5.color(0x000000),
				fontWeight: "bold"
			})
		});
	});

	// Asignar datos
	series.data.setAll(dataConsolidado2);
});

// Añadir un título al gráfico
// var title = chartConsolidado2.children.unshift(am5.Label.new(rootConsolidadoChart2, {
// 	text: "FACTORES PSICOSOCIALES NOM-035-STPS-2028\n Dominios",
// 	fontSize: 14,
// 	fontWeight: "bold",
// 	textAlign: "center",
// 	x: am5.p50,
// 	centerX: am5.p50,
// 	y: 0,
// 	paddingBottom: 1
// }));

// Crear la leyenda
var legendConsolidado2 = chartConsolidado2.children.push(am5.Legend.new(rootConsolidadoChart2, {
	centerX: am5.p50,
	x: am5.p50,
	y: am5.p100,
	layout: rootConsolidadoChart2.horizontalLayout,
	marginTop: 1
}));

// Vincular colores y nombres de las series a la leyenda
seriesNamesConsolidado2.forEach((seriesName, index) => {
	var series = chartConsolidado2.series.getIndex(index);
	series.legendSettings = {
		labelText: `Factor ${seriesName}`,
		fill: seriesColorsConsolidado2[index]
	};
});

// Agregar leyenda con los datos correctos
legendConsolidado2.data.setAll(chartConsolidado2.series.values);

chartConsolidado2.appear(1000, 100).then(() => {
		setTimeout(() => {
			if (typeof am5plugins_exporting !== 'undefined') {
				console.log('Plugin de exportación dispo');
	
				var exporting = am5plugins_exporting.Exporting.new(rootConsolidadoChart2, {
					menu: am5plugins_exporting.ExportingMenu.new(rootConsolidadoChart2, {}),
					dpi: 300, // Ajusta el DPI para mejorar la calidad de la imagen exportada
					// También puedes ajustar el tamaño de la imagen, si lo deseas
					maxWidth: 2000, // Ancho máximo en píxeles
					maxHeight: 2000,
				});
				console.log('si creo el exporting');
	
				exporting.export("png").then(function (data) {
					dominioschart = data;
					console.log("consolidado1 categorias exportado exitosamente");
				}).catch(error => console.error('Error al exportar:', error));
			} else {
				console.log('Plugin de exportación no disponible');
			}
		}, 1000); // Aumenté el timeout
	});

var calificaciones_root = am5.Root.new("calificacionChart");

// Establecer temas
calificaciones_root.setThemes([
    am5themes_Animated.new(calificaciones_root)
]);

// Crear gráfico
var calificaciones_chart = calificaciones_root.container.children.push(am5percent.PieChart.new(calificaciones_root, {
    startAngle: 180,
    endAngle: 360,
    layout: calificaciones_root.verticalLayout,
    innerRadius: am5.percent(50),
	paddingBottom: 0 
}));

// Definir los colores primero
const colors = {
    "Muy Alto": 0xFF0000,
    "Alto": 0xF7AA32,
    "Medio": 0xFFFF00,
    "Bajo": 0x00B050,
    "Nulo": 0x00B0F0
};

// Crear leyenda con texto más grande y grueso
let legend2 = calificaciones_chart.children.push(
    am5.Legend.new(calificaciones_root, {
        centerX: am5.percent(50),
        x: am5.percent(50),
        layout: calificaciones_root.verticalLayout,
        fontSize: 14,
        fontWeight: "bold",
		marginTop: -10,  // Reducir el margen superior
        dy: -10 // Mover la leyenda hacia arriba
    })
);

// Crear serie
var calificaciones_series = calificaciones_chart.series.push(am5percent.PieSeries.new(calificaciones_root, {
    startAngle: 180,
    endAngle: 360,
    valueField: "value",
    categoryField: "category",
    alignLabels: false
}));

// Configurar etiquetas
calificaciones_series.labels.template.setAll({
    fontSize: 14,
    fontWeight: "bold",
    text: "{value}"
});

// Configurar los colores y estilos de la leyenda
legend2.labels.template.setAll({
    fontSize: 14,
    fontWeight: "bold"
});

legend2.valueLabels.template.setAll({
    fontSize: 14,
    fontWeight: "bold"
});

legend2.markers.template.setAll({
    width: 20,
    height: 20
});

// Estilo de las rebanadas
calificaciones_series.slices.template.setAll({
    cornerRadius: 5,
    stroke: am5.color(0xFFFFFF)
});

calificaciones_series.slices.template.adapters.add("fill", function(fill, target) {
    var category = target.dataItem.get("category");
    return am5.color(colors[category] || fill);
});

// Establecer datos
calificaciones_series.data.setAll([
    { value: 1, category: "Muy Alto" },
    { value: 31, category: "Alto" },
    { value: 75, category: "Medio" },
    { value: 89, category: "Bajo" },
    { value: 55, category: "Nulo" }
]);

// Conectar la leyenda con la serie
legend2.data.setAll(calificaciones_series.dataItems);

// Animación
calificaciones_series.appear(1000, 100).then(() => {
    setTimeout(() => {
        if (typeof am5plugins_exporting !== 'undefined') {
            var exporting = am5plugins_exporting.Exporting.new(calificaciones_root, {
                menu: am5plugins_exporting.ExportingMenu.new(calificaciones_root, {}),
                dpi: 300,
                maxWidth: 2000,
                maxHeight: 2000,
            });

            exporting.export("png").then(function (data) {
                calificacionchart = data;
                console.log("calificacion chart exportado exitosamente");
            }).catch(error => console.error('Error al exportar:', error));
        } else {
            console.log('Plugin de exportación no disponible');
        }
    }, 1000);
});



var rootConsolidadoChart1 = am5.Root.new("consolidadoChart");

// Crear tema personalizado
const customThemeConsolidado1 = am5.Theme.new(rootConsolidadoChart1);
customThemeConsolidado1.rule("Label").set("fontSize", 17);
customThemeConsolidado1.rule("Grid").set("strokeOpacity", 0); // Ocultar las líneas de porcentaje

// Definir los estilos para los ejes dentro del tema
customThemeConsolidado1.rule("AxisRenderer").setAll({
	background: am5.Rectangle.new(rootConsolidadoChart1, {
		fill: am5.color(0x000000),
		fillOpacity: 0.7
	})
});

// Establecer temas
rootConsolidadoChart1.setThemes([am5themes_Animated.new(rootConsolidadoChart1), customThemeConsolidado1]);

// Datos (con valores fijos para las 5 series)
var dataConsolidado1 = [
	{ "category": "Ambiente de\n trabajo", "Nulo": 0.35, "Bajo": 0.18, "Medio": 0.22, "Alto": 0.15, "Muy alto": 0.10 },
	{ "category": "Factores Propios\n de la actividad", "Nulo": 0.09, "Bajo": 0.36, "Medio": 0.21, "Alto": 0.26, "Muy alto": 0.08 },
	{ "category": "Entorno organizacional", "Nulo": 0.11, "Bajo": 0.16, "Medio": 0.19, "Alto": 0.24, "Muy alto": 0.30 },
	{ "category": "Liderazgo y relaciones\n en el trabajo", "Nulo": 0.16, "Bajo": 0.20, "Medio": 0.24, "Alto": 0.29, "Muy alto": 0.11 },
	{ "category": "Organización del \ntiempo de trabajo", "Nulo": 0.14, "Bajo": 0.19, "Medio": 0.23, "Alto": 0.27, "Muy alto": 0.17 },

];

var colorSetConsolidado1 = am5.ColorSet.new(rootConsolidadoChart1, {});

// Modificar formato de números
rootConsolidadoChart1.numberFormatter.set("numberFormat", "#%");

// Crear gráfico
var chartConsolidado1 = rootConsolidadoChart1.container.children.push(am5radar.RadarChart.new(rootConsolidadoChart1, {
	panX: false,
	panY: false,
	wheelX: "none", // Removed zoom functionality
    wheelY: "none",
	innerRadius: am5.percent(10),
	radius: am5.percent(85)
}));

chartConsolidado1.zoomOutButton.set("forceHidden", true);

// Crear ejes
var categoryAxisRendererConsolidado1 = am5radar.AxisRendererCircular.new(rootConsolidadoChart1, {
	innerRadius: am5.percent(10)
});


var categoryAxisConsolidado1 = chartConsolidado1.xAxes.push(am5xy.CategoryAxis.new(rootConsolidadoChart1, {
	categoryField: "category",
	renderer: categoryAxisRendererConsolidado1
}));

categoryAxisRendererConsolidado1.labels.template.setAll({
	fill: am5.color(0x000000),
	fontSize: 20,
	fontWeight: "bold",
	paddingLeft: 5,
	paddingRight: 5,
	paddingTop: 2,
	paddingBottom: 2
});

categoryAxisConsolidado1.data.setAll(dataConsolidado1);

// Crear eje de valor
var valueAxisConsolidado1 = chartConsolidado1.yAxes.push(am5xy.ValueAxis.new(rootConsolidadoChart1, {
	renderer: am5radar.AxisRendererRadial.new(rootConsolidadoChart1, {}),
	min: 0,
	max: 1,
	strictMinMax: true,
	extraMax: 0.1
}));

valueAxisConsolidado1.get("renderer").labels.template.setAll({
	visible: false
});

// Crear series apiladas
var seriesNamesConsolidado1 = ["Nulo", "Bajo", "Medio", "Alto", "Muy alto"];
var seriesColorsConsolidado1 = [
	am5.color(0x00B0F0),
	am5.color(0x00B050),
	am5.color(0xFFFF00),
	am5.color(0xF7AA32),
	am5.color(0xFF0000)
];

seriesNamesConsolidado1.forEach((seriesName, index) => {
	var series = chartConsolidado1.series.push(am5radar.RadarColumnSeries.new(rootConsolidadoChart1, {
		stacked: true,
		name: seriesName,
		xAxis: categoryAxisConsolidado1,
		yAxis: valueAxisConsolidado1,
		valueYField: seriesName,
		categoryXField: "category"
	}));

	series.columns.template.setAll({
		tooltipText: "{name}: {valueY.formatNumber('#.##%')}",
		cornerRadius: 0,
		strokeOpacity: 1, // Changed from 0 to 1 to show borders
        stroke: am5.color(0x000000), // Added black border
        strokeWidth: 0.5, // Added border width
		fill: seriesColorsConsolidado1[index],
		width: am5.percent(100)
	});

	// Agregar etiquetas con porcentajes
	series.bullets.push(function () {
		return am5.Bullet.new(rootConsolidadoChart1, {
			sprite: am5.Label.new(rootConsolidadoChart1, {
				text: "{valueY.formatNumber('#.##%')}",
				populateText: true,
				centerX: am5.p50,
				centerY: am5.p50,
				fill: am5.color(0x000000),
				fontWeight: "bold"
			})
		});
	});

	// Asignar datos
	series.data.setAll(dataConsolidado1);
});

// Añadir un título al gráfico
// var title = chartConsolidado1.children.unshift(am5.Label.new(rootConsolidadoChart1, {
// 	text: "FACTORES PSICOSOCIALES NOM-035-STPS-2028\n Categorias",
// 	fontSize: 14,
// 	fontWeight: "bold",
// 	textAlign: "center",
// 	x: am5.p50,
// 	centerX: am5.p50,
// 	y: 0,
// 	paddingBottom: 1
// }));

// Crear la leyenda








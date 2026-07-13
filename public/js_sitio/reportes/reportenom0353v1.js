// modulo EPP
var opciones_catepp = "";
var ambientechart = null;
var chartPngs = {};
var edadeschart = null;
var escolaridadchart = null;
var estadocivilchart = null;
var regimenchart = null;
var experienciachart = null;
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



            //---------------------------------------
            // SI NO PERMITE GUARDAR
            //---------------------------------------

            if(response.permite_guardar == 0)
            {

                //---------------------------------------
                // DESACTIVAR BOTONES
                //---------------------------------------

                $(botones)
                    .prop('disabled', true);



                //---------------------------------------
                // INPUTS
                //---------------------------------------

               $('input, textarea, select')
				.not('.checkbox_cancelado_revision')
				.prop('disabled', true);


                //---------------------------------------
                // MENSAJE
                //---------------------------------------

                Swal.fire({

                    icon: 'warning',

                    title: 'Informe finalizado',

                    text:
                        'La revisión fue finalizada y ya no puede editarse'

                });

            }
            else
            {

                //---------------------------------------
                // ACTIVAR BOTONES
                //---------------------------------------

                $(botones)
                    .prop('disabled', false);



                //---------------------------------------
                // INPUTS
                //---------------------------------------

                $('input, textarea, select')
                    .prop('disabled', false);

            }



            //---------------------------------------
            // SI ESTA CANCELADO
            //---------------------------------------

            if(response.cancelado == 1)
            {

                Swal.fire({

                    icon: 'info',

                    title: 'Revisión cancelada',

                    text:
                        'La última revisión fue cancelada, puede continuar editando'

                });

            }

        }

    );

}


////// GRAFICAS
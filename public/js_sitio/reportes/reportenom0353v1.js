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
            tabla_areas();
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
            cargarGraficaCalificacionPsico();
            cargarGraficaCategoriasGuiaIII();
            cargarGraficaDominiosGuiaIII();
            cargarGraficaGuiaIPsico();
            cargarGraficaAmbienteGuiaIII();
            cargarGraficaFactoresGuiaIII();
            cargarGraficaOrganizacionGuiaIII();
            cargarGraficaLiderazgoGuiaIII();
            cargarGraficaEntornoGuiaIII();
            totalfotospsico();
    
    
            //// DASHBOARD
            cargarTotalTrabajadoresATSpsico();
            cargarTotalTrabajadoresRequierenAtencionPsico();
            cargarCategoriaODominioMayorRiesgoPsico();
            cargarGraficasMayorRiesgoPsico();
            cargarGraficaDistribucionRiesgoPsico();
            cargarGraficaTrabajadoresATSpsico();
            cargarGraficaCumplimientoNormativoPsico();
    cargarRecomendacionesPrioritariasPsico();
    
            consultarEstadosMenusReportePsico();
    

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



                        // INTRODUCCIÓN (SUMMERNOTE)
                        let contenido = $('#INFORME_INTRODUCCION').summernote('code');

                        if (contenido) {

                            $.each(resp.data, function(marcador, valor) {
                                contenido = contenido.split(marcador).join(valor || '');
                            });

                            $('#INFORME_INTRODUCCION').summernote('code', contenido);
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

            consultarEstadosMenusReportePsico();

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

                $('#INFORME_INTRODUCCION').summernote(
                    'code',
                    response.INFORME_INTRODUCCION
                );

            } else {

                $('#INFORME_INTRODUCCION').summernote(
                    'code',
                    `<p>Es un hecho que los Factores de Riesgo Psicosocial (FRPS) inherentes a las diversas actividades que se desarrollan en la industria petrolera no son la excepción. La forma en que las personas se desenvuelven en los ámbitos social y económico encuentra una de sus principales expresiones en el trabajo. Su vida cotidiana, su proyecto de vida y sus experiencias emocionales, cognitivas y sociales se desarrollan, en gran medida, dentro del entorno laboral, considerando el tiempo que se dedica al desempeño de las actividades propias de cada puesto.</p>

            <p>Tomando en cuenta la importancia de la evaluación e intervención sobre los Factores de Riesgo Psicosocial para promover un estado de bienestar entre las personas trabajadoras, de conformidad con lo establecido en la Norma Oficial Mexicana NOM-035-STPS-2018, Factores de riesgo psicosocial en el trabajo–Identificación, análisis y prevención, NOMBRE_EMPRESA mantiene su compromiso con el cumplimiento de los estándares en materia de seguridad y salud en el trabajo, verificando que la salud de las personas trabajadoras expuestas a Factores de Riesgo Psicosocial no se vea afectada por las condiciones existentes en el centro de trabajo. Para ello, realiza de manera periódica las evaluaciones correspondientes, en apego a la normatividad aplicable y a sus procedimientos internos.</p>

            <p>En el presente estudio se describen los resultados obtenidos durante la evaluación de Factores de Riesgo Psicosocial en el ambiente laboral, de acuerdo con lo establecido en la Norma Oficial Mexicana NOM-035-STPS2018, Factores de riesgo psicosocial en el trabajo–Identificación, análisis y prevención, realizada en las áreas de la INSTALACION, <font color="#000000" style="background-color: rgb(255, 255, 0);">"los días del XX al XX de MES de AÑO."</font></p>`
                );

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
            
          
			$('#INFORME_RESPONSABLE1')
				.val(response.INFORME_RESPONSABLE1);

			$('#INFORME_RESPONSABLE1CARGO')
				.val(response.INFORME_RESPONSABLE1CARGO);

			$('#INFORME_RESPONSABLE2')
				.val(response.INFORME_RESPONSABLE2);

		    $('#INFORME_RESPONSABLE2CARGO')
                .val(response.INFORME_RESPONSABLE2CARGO);
                        
            //// ANALISIS GRAFICA 
            $('#ANALISIS_GRAFICACALIFICACIONES')
                .val(response.ANALISIS_GRAFICACALIFICACIONES);
                    
             $('#ANALISIS_GRAFICA_CATEGORIAS')
                .val(response.ANALISIS_GRAFICA_CATEGORIAS);
                    
            $('#ANALISIS_GRAFICA_DOMINIOS')
                .val(response.ANALISIS_GRAFICA_DOMINIOS);
                         
            $('#ANALISIS_GRAFICA_GUIA1')
                .val(response.ANALISIS_GRAFICA_GUIA1);       
            
            
           $('#ANALISIS_GRAFICA_CATAMBIENTE')
                .val(response.ANALISIS_GRAFICA_CATAMBIENTE);

            $('#ANALISIS_GRAFICA_DOMAMBIENTE')
                .val(response.ANALISIS_GRAFICA_DOMAMBIENTE);

            $('#ANALISIS_GRAFICA_CATFACTORES')
                .val(response.ANALISIS_GRAFICA_CATFACTORES);

            $('#ANALISIS_GRAFICA_DOMFACTORES_1')
                .val(response.ANALISIS_GRAFICA_DOMFACTORES_1);

            $('#ANALISIS_GRAFICA_DOMFACTORES_2')
                .val(response.ANALISIS_GRAFICA_DOMFACTORES_2);

            $('#ANALISIS_GRAFICA_CATORGANIZACION')
                .val(response.ANALISIS_GRAFICA_CATORGANIZACION);

            $('#ANALISIS_GRAFICA_DOMORGANIZACION_1')
                .val(response.ANALISIS_GRAFICA_DOMORGANIZACION_1);

            $('#ANALISIS_GRAFICA_DOMORGANIZACION_2')
                .val(response.ANALISIS_GRAFICA_DOMORGANIZACION_2);

            $('#ANALISIS_GRAFICA_CATLIDERAZGO')
                .val(response.ANALISIS_GRAFICA_CATLIDERAZGO);

            $('#ANALISIS_GRAFICA_DOMLIDERAZGO_1')
                .val(response.ANALISIS_GRAFICA_DOMLIDERAZGO_1);

            $('#ANALISIS_GRAFICA_DOMLIDERAZGO_2')
                .val(response.ANALISIS_GRAFICA_DOMLIDERAZGO_2);

            $('#ANALISIS_GRAFICA_DOMLIDERAZGO_3')
                .val(response.ANALISIS_GRAFICA_DOMLIDERAZGO_3);

            $('#ANALISIS_GRAFICA_CATENTORNO')
                .val(response.ANALISIS_GRAFICA_CATENTORNO);

            $('#ANALISIS_GRAFICA_DOMENTORNO_1')
                .val(response.ANALISIS_GRAFICA_DOMENTORNO_1);

            $('#ANALISIS_GRAFICA_DOMENTORNO_2')
                .val(response.ANALISIS_GRAFICA_DOMENTORNO_2);
                        
            
            
            $('#NIVEL_RIESGO_AMBIENTE')
                .val(response.NIVEL_RIESGO_AMBIENTE); 
            
            $('#NIVEL_RIESGO_FACTORES')
                .val(response.NIVEL_RIESGO_FACTORES); 
            
            $('#NIVEL_RIESGO_ORGANIZACION')
                .val(response.NIVEL_RIESGO_ORGANIZACION); 
            
            $('#NIVEL_RIESGO_LIDERAZGO')
                .val(response.NIVEL_RIESGO_LIDERAZGO); 
            
            $('#NIVEL_RIESGO_ENTORNO')
                .val(response.NIVEL_RIESGO_ENTORNO); 
            
            mostrarConclusiones(response.INFORME_CONCLUSION);
            
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

            consultarEstadosMenusReportePsico();

            
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

            consultarEstadosMenusReportePsico();

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
            consultarEstadosMenusReportePsico();

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

            consultarEstadosMenusReportePsico();

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
            consultarEstadosMenusReportePsico();

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
            consultarEstadosMenusReportePsico();

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


$("#form_reporte_descripcionmetodo").on("submit",function(e)
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

            consultarEstadosMenusReportePsico();

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


$("#form_reporte_conclusion").on("submit",function(e)
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

            consultarEstadosMenusReportePsico();

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


$(document).on("change", ".recomendacion_checkbox", function()
{
    var id = $(this).data("id");
    var selector = $("#ES_PRIORITARIA_" + id);

    if ($(this).is(":checked")) {
        selector.prop("disabled", false);
    } else {
        selector.val("0");
        selector.prop("disabled", true);
    }
});


$(document).on("change", ".selector_prioritaria", function()
{
    var totalPrioritarias = 0;

    $(".selector_prioritaria").each(function()
    {
        var id = $(this).data("id");

        var activa = $(
            '.recomendacion_checkbox[data-id="' + id + '"]'
        ).is(":checked");

        if (
            activa &&
            $(this).val() == "1"
        ) {
            totalPrioritarias++;
        }
    });

    if (totalPrioritarias > 3) {

        $(this).val("0");

        Swal.fire({
            icon: "warning",
            title: "Límite alcanzado",
            text: "Solo puede seleccionar un máximo de 3 recomendaciones prioritarias"
        });
    }
});


$("#form_reporte_recomendaciones_control").on("submit", function(e)
{
    e.preventDefault();

    var totalPrioritarias = 0;

    $(".selector_prioritaria").each(function()
    {
        var id = $(this).data("id");

        var activa = $(
            '.recomendacion_checkbox[data-id="' + id + '"]'
        ).is(":checked");

        if (
            activa &&
            $(this).val() == "1"
        ) {
            totalPrioritarias++;
        }
    });

    if (totalPrioritarias > 3) {

        Swal.fire({
            icon: "warning",
            title: "Aviso",
            text: "Solo puede seleccionar un máximo de 3 recomendaciones prioritarias"
        });

        return;
    }

    let formData = new FormData(this);

    formData.append(
        "PROYECTO_ID",
        proyecto.id
    );

    $.ajax({
        url: "/guardarRecomendacionesInformepsico",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,

        headers: {
            "X-CSRF-TOKEN":
                $('meta[name="csrf-token"]')
                .attr("content")
        },

        beforeSend: function()
        {
            $("#botonguardar_reporte_recomendaciones_control").prop("disabled", true);
            $("#botonguardar_reporte_recomendaciones_control").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();
            cargarRecomendacionesPrioritariasPsico();

            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: response.msj,
                timer: 2000,
                showConfirmButton: false
            });
        },

        error: function(xhr)
        {
            var mensaje = "Ocurrió un error al guardar";

            if (
                xhr.responseJSON &&
                xhr.responseJSON.msj
            ) {
                mensaje = xhr.responseJSON.msj;
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: mensaje
            });
        },

        complete: function()
        {
            $("#botonguardar_reporte_recomendaciones_control")
                .prop("disabled", false);

            $("#botonguardar_reporte_recomendaciones_control")
                .html(
                    'Guardar recomendaciones <i class="fa fa-save"></i>'
                );
        }
    });
});


function cargarRecomendacionesInformepsico()
{
    $.get(
        "/obtenerRecomendacionesInformepsico/" + proyecto.id,

        function(response)
        {
            $('input[name="DESCRIPCION_RECOMENDACIONES[]"]')
                .prop("checked", false);

            $(".selector_prioritaria")
                .val("0")
                .prop("disabled", true);

            response.forEach(function(item)
            {
                var id =
                    item.CATALOGO_RECOMENDACIONES_ID;

                $('input[name="DESCRIPCION_RECOMENDACIONES[]"][value="' + id + '"]')
                    .prop("checked", true);

                $("#ES_PRIORITARIA_" + id)
                    .prop("disabled", false)
                    .val(
                        String(
                            item.ES_PRIORITARIA || 0
                        )
                    );
            });
        }
    );
}


/// RESPONSABLE


$("#form_reporte_responsablesinforme").on("submit",function(e)
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
            consultarEstadosMenusReportePsico();

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




$("#boton_reporte_nuevarevision").on(
    "click",
    function()
    {
        var boton = $(this);
        var contenidoOriginal = boton.html();

        $.ajax({

            url: '/crearRevisioninfopsico',
            type: 'POST',
            data: {
                PROYECTO_ID:proyecto.id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function()
            {
                boton.prop('disabled', true).html('Validando información... ' +'<i class="fa fa-spinner fa-spin"></i>');
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
                consultarEstadosMenusReportePsico();
            },

            error: function(xhr)
            {
                console.log(xhr.responseText);
                var response = xhr.responseJSON || {};
                var mensaje = response.msj || 'No fue posible crear la revisión.';
                var seccionesFaltantes = response.secciones_faltantes || [];

                if (
                    Array.isArray(
                        seccionesFaltantes
                    ) &&
                    seccionesFaltantes.length > 0
                ) {

                    var lista =
                        $('<ul>', {
                            css: {
                                'padding-left': '22px',
                                'margin-bottom': '0',
                                'text-align': 'left'
                            }
                        });

                    seccionesFaltantes.forEach(
                        function(seccion)
                        {
                            lista.append(
                                $('<li>', {
                                    text: seccion,
                                    css: {
                                        'margin-bottom':
                                            '6px'
                                    }
                                })
                            );
                        }
                    );

                    var contenido =
                        $('<div>', {
                            css: {
                                'text-align': 'left'
                            }
                        });

                    contenido.append(
                        $('<p>', {
                            text: mensaje
                        })
                    );

                    contenido.append(
                        $('<p>', {
                            text:
                                'Falta completar las siguientes secciones:'
                        })
                    );

                    contenido.append(lista);

                    Swal.fire({
                        icon: 'warning',
                        title: 'Reporte incompleto',
                        html: contenido[0],
                        confirmButtonText: 'Entendido'
                    });

                    consultarEstadosMenusReportePsico();

                    return;
                }

        
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: mensaje
                });
            },

            complete: function()
            {
                boton
                    .prop('disabled', false)
                    .html(contenidoOriginal);
            }
        });
    }
);


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
                #botonguardar_reporte_responsablesinforme,
                #botonguardar_analisis_graficaglobal,
                #botonguardar_analisis_grafica_categorias,
                #botonguardar_analisis_grafica_dominio,
                #botonguardar_analisis_grafica_guia1,
                #botonguardar_analisis_grafica_ambiente,
                #botonguardar_analisis_grafica_factores,
                #botonguardar_analisis_grafica_organizacion,
                #botonguardar_analisis_grafica_liderazgo,
                #botonguardar_analisis_grafica_entorno,
                #botonguardar_nivel_riesgo_categorias

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
            $('#total_trabajadores_evaluados').text(response.numero_trabajadores);

        }
    );
}

///// DESCARGAR INFO


function recortarEspacioBlancoBase64(imagenBase64, padding)
{
    return new Promise(function(resolve)
    {
        if (!imagenBase64) {
            resolve('');
            return;
        }

        var imagen = new Image();

        imagen.onload = function()
        {
            var canvas = document.createElement('canvas');
            var contexto = canvas.getContext('2d');

            canvas.width = imagen.naturalWidth;
            canvas.height = imagen.naturalHeight;

            contexto.drawImage(imagen, 0, 0);

            var datos = contexto.getImageData(
                0,
                0,
                canvas.width,
                canvas.height
            );

            var pixeles = datos.data;

            var minimoX = canvas.width;
            var minimoY = canvas.height;
            var maximoX = 0;
            var maximoY = 0;
            var encontrado = false;

            for (var y = 0; y < canvas.height; y++) {

                for (var x = 0; x < canvas.width; x++) {

                    var indice =
                        (y * canvas.width + x) * 4;

                    var rojo = pixeles[indice];
                    var verde = pixeles[indice + 1];
                    var azul = pixeles[indice + 2];
                    var alfa = pixeles[indice + 3];

                    var esBlanco =
                        rojo >= 248 &&
                        verde >= 248 &&
                        azul >= 248;

                    var esTransparente =
                        alfa <= 10;

                    if (!esBlanco && !esTransparente) {

                        encontrado = true;

                        if (x < minimoX) {
                            minimoX = x;
                        }

                        if (x > maximoX) {
                            maximoX = x;
                        }

                        if (y < minimoY) {
                            minimoY = y;
                        }

                        if (y > maximoY) {
                            maximoY = y;
                        }
                    }
                }
            }

            if (!encontrado) {
                resolve(imagenBase64);
                return;
            }

            padding = parseInt(padding, 10) || 0;

            minimoX = Math.max(0, minimoX - padding);
            minimoY = Math.max(0, minimoY - padding);

            maximoX = Math.min(
                canvas.width - 1,
                maximoX + padding
            );

            maximoY = Math.min(
                canvas.height - 1,
                maximoY + padding
            );

            var anchoRecorte =
                maximoX - minimoX + 1;

            var altoRecorte =
                maximoY - minimoY + 1;

            var canvasRecortado =
                document.createElement('canvas');

            canvasRecortado.width =
                anchoRecorte;

            canvasRecortado.height =
                altoRecorte;

            var contextoRecortado =
                canvasRecortado.getContext('2d');

            contextoRecortado.fillStyle = '#FFFFFF';

            contextoRecortado.fillRect(
                0,
                0,
                anchoRecorte,
                altoRecorte
            );

            contextoRecortado.drawImage(
                canvas,
                minimoX,
                minimoY,
                anchoRecorte,
                altoRecorte,
                0,
                0,
                anchoRecorte,
                altoRecorte
            );

            resolve(
                canvasRecortado.toDataURL(
                    'image/png'
                )
            );
        };

        imagen.onerror = function()
        {
            resolve(imagenBase64);
        };

        imagen.src = imagenBase64;
    });
}

function recortarImagenBase64(imagenBase64, padding)
{
    return new Promise(function(resolve)
    {
        if (
            !imagenBase64 ||
            typeof imagenBase64 !== 'string'
        ) {
            resolve('');
            return;
        }

        var imagen = new Image();

        imagen.onload = function()
        {
            var canvas = document.createElement('canvas');
            var contexto = canvas.getContext('2d');

            canvas.width =
                imagen.naturalWidth || imagen.width;

            canvas.height =
                imagen.naturalHeight || imagen.height;

            contexto.clearRect(
                0,
                0,
                canvas.width,
                canvas.height
            );

            contexto.drawImage(
                imagen,
                0,
                0
            );

            var informacion = contexto.getImageData(
                0,
                0,
                canvas.width,
                canvas.height
            );

            var pixeles = informacion.data;

            var minimoX = canvas.width;
            var minimoY = canvas.height;
            var maximoX = 0;
            var maximoY = 0;
            var encontrado = false;

            var anchoZonaLogo = Math.round(
                canvas.width * 0.12
            );

            var altoZonaLogo = Math.round(
                canvas.height * 0.12
            );

            var inicioZonaLogoY =
                canvas.height - altoZonaLogo;

            for (var y = 0; y < canvas.height; y++) {

                for (var x = 0; x < canvas.width; x++) {

                    var estaEnZonaLogo =
                        x <= anchoZonaLogo &&
                        y >= inicioZonaLogoY;

                    if (estaEnZonaLogo) {
                        continue;
                    }

                    var indice =
                        (y * canvas.width + x) * 4;

                    var rojo =
                        pixeles[indice];

                    var verde =
                        pixeles[indice + 1];

                    var azul =
                        pixeles[indice + 2];

                    var alfa =
                        pixeles[indice + 3];

                    var transparente =
                        alfa <= 10;

                    var blanco =
                        rojo >= 245 &&
                        verde >= 245 &&
                        azul >= 245;

                    if (
                        !transparente &&
                        !blanco
                    ) {
                        encontrado = true;

                        if (x < minimoX) {
                            minimoX = x;
                        }

                        if (x > maximoX) {
                            maximoX = x;
                        }

                        if (y < minimoY) {
                            minimoY = y;
                        }

                        if (y > maximoY) {
                            maximoY = y;
                        }
                    }
                }
            }

            if (!encontrado) {
                resolve(imagenBase64);
                return;
            }

            padding =
                parseInt(padding, 10);

            if (isNaN(padding)) {
                padding = 15;
            }

            minimoX = Math.max(
                0,
                minimoX - padding
            );

            minimoY = Math.max(
                0,
                minimoY - padding
            );

            maximoX = Math.min(
                canvas.width - 1,
                maximoX + padding
            );

            maximoY = Math.min(
                canvas.height - 1,
                maximoY + padding
            );

            var anchoRecorte =
                maximoX - minimoX + 1;

            var altoRecorte =
                maximoY - minimoY + 1;

            if (
                anchoRecorte <= 0 ||
                altoRecorte <= 0
            ) {
                resolve(imagenBase64);
                return;
            }

            var escalaSalida = 3;

            var canvasRecortado =
                document.createElement('canvas');

            var contextoRecortado =
                canvasRecortado.getContext('2d');

            canvasRecortado.width =
                anchoRecorte * escalaSalida;

            canvasRecortado.height =
                altoRecorte * escalaSalida;

            contextoRecortado.clearRect(
                0,
                0,
                canvasRecortado.width,
                canvasRecortado.height
            );

            contextoRecortado.imageSmoothingEnabled =
                true;

            contextoRecortado.imageSmoothingQuality =
                'high';

            contextoRecortado.drawImage(
                canvas,
                minimoX,
                minimoY,
                anchoRecorte,
                altoRecorte,
                0,
                0,
                canvasRecortado.width,
                canvasRecortado.height
            );

            resolve(
                canvasRecortado.toDataURL(
                    'image/png'
                )
            );
        };

        imagen.onerror = function()
        {
            resolve(imagenBase64);
        };

        imagen.src = imagenBase64;
    });
}

// async function descargarRevisioninfopsico(PROYECTO_ID)
// {
//     try {

//         window.chartPngs =
//             window.chartPngs || {};

//         if (
//             !window.chartPngs[
//                 'calificacionChart'
//             ] &&
//             typeof calificacionchart !==
//                 'undefined' &&
//             calificacionchart
//         ) {
//             window.chartPngs[
//                 'calificacionChart'
//             ] = calificacionchart;
//         }

//         if (
//             !window.chartPngs[
//                 'consolidadoChart'
//             ] &&
//             typeof categoriaschart !==
//                 'undefined' &&
//             categoriaschart
//         ) {
//             window.chartPngs[
//                 'consolidadoChart'
//             ] = categoriaschart;
//         }

//         if (
//             !window.chartPngs[
//                 'consolidadoChart2'
//             ] &&
//             typeof dominioschart !==
//                 'undefined' &&
//             dominioschart
//         ) {
//             window.chartPngs[
//                 'consolidadoChart2'
//             ] = dominioschart;
//         }

//         if (
//             !window.chartPngs[
//                 'guia1Chart'
//             ] &&
//             typeof acontecimientoschart !==
//                 'undefined' &&
//             acontecimientoschart
//         ) {
//             window.chartPngs[
//                 'guia1Chart'
//             ] = acontecimientoschart;
//         }

//         const dashboard =
//             document.querySelector(
//                 '#tabla_dashboard'
//             );

//         if (!dashboard) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: 'No se encontró el dashboard para generar la imagen'
//             });

//             return;
//         }

//         if (
//             document.fonts &&
//             document.fonts.ready
//         ) {
//             await document.fonts.ready;
//         }

//         window.dispatchEvent(
//             new Event('resize')
//         );

//         await new Promise(
//             function(resolve)
//             {
//                 setTimeout(
//                     resolve,
//                     1800
//                 );
//             }
//         );

//         var imagenesGraficas = {
//             GRAFICA_CALIFICACION:
//                 window.chartPngs[
//                     'calificacionChart'
//                 ] || '',

//             GRAFICA_CATEGORIAS:
//                 window.chartPngs[
//                     'consolidadoChart'
//                 ] || '',

//             GRAFICA_DOMINIOS:
//                 window.chartPngs[
//                     'consolidadoChart2'
//                 ] || '',

//             GRAFICA_1:
//                 window.chartPngs[
//                     'guia1Chart'
//                 ] || '',

//             ambienteCategoriaChart:
//                 window.chartPngs[
//                     'ambienteCategoriaChart'
//                 ] || '',

//             ambienteDominioChart:
//                 window.chartPngs[
//                     'ambienteDominioChart'
//                 ] || '',

//             factoresCategoriaChart:
//                 window.chartPngs[
//                     'factoresCategoriaChart'
//                 ] || '',

//             factoresDominio1Chart:
//                 window.chartPngs[
//                     'factoresDominio1Chart'
//                 ] || '',

//             factoresDominio2Chart:
//                 window.chartPngs[
//                     'factoresDominio2Chart'
//                 ] || '',

//             organizacionCategoriaChart:
//                 window.chartPngs[
//                     'organizacionCategoriaChart'
//                 ] || '',

//             organizacionDominio1Chart:
//                 window.chartPngs[
//                     'organizacionDominio1Chart'
//                 ] || '',

//             organizacionDominio2Chart:
//                 window.chartPngs[
//                     'organizacionDominio2Chart'
//                 ] || '',

//             liderazgoCategoriaChart:
//                 window.chartPngs[
//                     'liderazgoCategoriaChart'
//                 ] || '',

//             liderazgoDominio1Chart:
//                 window.chartPngs[
//                     'liderazgoDominio1Chart'
//                 ] || '',

//             liderazgoDominio2Chart:
//                 window.chartPngs[
//                     'liderazgoDominio2Chart'
//                 ] || '',

//             liderazgoDominio3Chart:
//                 window.chartPngs[
//                     'liderazgoDominio3Chart'
//                 ] || '',

//             entornoCategoriaChart:
//                 window.chartPngs[
//                     'entornoCategoriaChart'
//                 ] || '',

//             entornoDominio1Chart:
//                 window.chartPngs[
//                     'entornoDominio1Chart'
//                 ] || '',

//             entornoDominio2Chart:
//                 window.chartPngs[
//                     'entornoDominio2Chart'
//                 ] || ''
//         };

//        var graficasParaRecortar = [
//         'GRAFICA_CALIFICACION',
//         'GRAFICA_CATEGORIAS',
//         'GRAFICA_DOMINIOS',
//         'GRAFICA_1'
//     ];

//     for (
//         var indice = 0;
//         indice < graficasParaRecortar.length;
//         indice++
//     ) {
//         var nombreGrafica =
//             graficasParaRecortar[indice];

//         if (
//             imagenesGraficas[nombreGrafica] &&
//             imagenesGraficas[nombreGrafica].length > 100
//         ) {
//             imagenesGraficas[nombreGrafica] =
//                 await recortarImagenBase64(
//                     imagenesGraficas[nombreGrafica],
//                     10
//                 );
//         }
//     }

//         var graficasFaltantes =
//             [];

//         Object.keys(
//             imagenesGraficas
//         ).forEach(
//             function(nombreGrafica)
//             {
//                 if (
//                     !imagenesGraficas[
//                         nombreGrafica
//                     ] ||
//                     imagenesGraficas[
//                         nombreGrafica
//                     ].length < 100
//                 ) {
//                     graficasFaltantes.push(
//                         nombreGrafica
//                     );
//                 }
//             }
//         );

//         if (
//             graficasFaltantes.length > 0
//         ) {
//             console.warn(
//                 'Las siguientes gráficas no están disponibles:',
//                 graficasFaltantes
//             );
//         }

//         const canvas =
//             await html2canvas(
//                 dashboard,
//                 {
//                     scale: 4,
//                     useCORS: true,
//                     allowTaint: true,
//                     backgroundColor:
//                         '#FFFFFF',
//                     logging: false,
//                     scrollX: 0,
//                     scrollY:
//                         -window.scrollY,
//                     width:
//                         dashboard.scrollWidth,
//                     height:
//                         dashboard.scrollHeight,
//                     windowWidth:
//                         document
//                             .documentElement
//                             .scrollWidth,
//                     windowHeight:
//                         document
//                             .documentElement
//                             .scrollHeight
//                 }
//             );

//         const dashboardBase64 =
//             canvas.toDataURL(
//                 'image/png',
//                 1
//             );

//         if (
//             !dashboardBase64 ||
//             dashboardBase64.length < 100
//         ) {
//             throw new Error(
//                 'No fue posible generar la imagen del dashboard'
//             );
//         }

//         var form =
//             $('<form>', {
//                 action:
//                     '/descargarRevisioninfopsico/' +
//                     PROYECTO_ID,

//                 method:
//                     'POST',

//                 target:
//                     '_blank',

//                 style:
//                     'display:none;'
//             });

//         form.append(
//             $('<input>', {
//                 type: 'hidden',
//                 name: '_token',
//                 value:
//                     $(
//                         'meta[name="csrf-token"]'
//                     ).attr(
//                         'content'
//                     )
//             })
//         );

//         form.append(
//             $('<input>', {
//                 type: 'hidden',
//                 name:
//                     'DASHBOARD_FOTO',
//                 value:
//                     dashboardBase64
//             })
//         );

//         Object.keys(
//             imagenesGraficas
//         ).forEach(
//             function(nombreInput)
//             {
//                 form.append(
//                     $('<input>', {
//                         type:
//                             'hidden',

//                         name:
//                             nombreInput,

//                         value:
//                             imagenesGraficas[
//                                 nombreInput
//                             ]
//                     })
//                 );
//             }
//         );

//         $('body').append(form);

//         form.submit();

//         setTimeout(
//             function()
//             {
//                 form.remove();
//             },
//             5000
//         );

//     } catch (error) {

//         console.error(
//             'Error al generar el informe:',
//             error
//         );

//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'No fue posible generar las imágenes del informe'
//         });
//     }
// }

async function descargarRevisioninfopsico(PROYECTO_ID)
{
    try {

        window.chartPngs =
            window.chartPngs || {};

        if (
            !window.chartPngs[
                'calificacionChart'
            ] &&
            typeof calificacionchart !==
                'undefined' &&
            calificacionchart
        ) {
            window.chartPngs[
                'calificacionChart'
            ] = calificacionchart;
        }

        if (
            !window.chartPngs[
                'consolidadoChart'
            ] &&
            typeof categoriaschart !==
                'undefined' &&
            categoriaschart
        ) {
            window.chartPngs[
                'consolidadoChart'
            ] = categoriaschart;
        }

        if (
            !window.chartPngs[
                'consolidadoChart2'
            ] &&
            typeof dominioschart !==
                'undefined' &&
            dominioschart
        ) {
            window.chartPngs[
                'consolidadoChart2'
            ] = dominioschart;
        }

        if (
            !window.chartPngs[
                'guia1Chart'
            ] &&
            typeof acontecimientoschart !==
                'undefined' &&
            acontecimientoschart
        ) {
            window.chartPngs[
                'guia1Chart'
            ] = acontecimientoschart;
        }

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

        const dashboardGeneral =
            document.querySelector(
                '#dashboard_nom035_captura'
            );

        if (!dashboardGeneral) {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontró el dashboard general para generar la imagen'
            });

            return;
        }

        if (
            document.fonts &&
            document.fonts.ready
        ) {
            await document.fonts.ready;
        }

        window.dispatchEvent(
            new Event('resize')
        );

        await new Promise(
            function(resolve)
            {
                setTimeout(
                    resolve,
                    1800
                );
            }
        );

        var imagenesGraficas = {

            GRAFICA_CALIFICACION:
                window.chartPngs[
                    'calificacionChart'
                ] || '',

            GRAFICA_CATEGORIAS:
                window.chartPngs[
                    'consolidadoChart'
                ] || '',

            GRAFICA_DOMINIOS:
                window.chartPngs[
                    'consolidadoChart2'
                ] || '',

            GRAFICA_1:
                window.chartPngs[
                    'guia1Chart'
                ] || '',

            ambienteCategoriaChart:
                window.chartPngs[
                    'ambienteCategoriaChart'
                ] || '',

            ambienteDominioChart:
                window.chartPngs[
                    'ambienteDominioChart'
                ] || '',

            factoresCategoriaChart:
                window.chartPngs[
                    'factoresCategoriaChart'
                ] || '',

            factoresDominio1Chart:
                window.chartPngs[
                    'factoresDominio1Chart'
                ] || '',

            factoresDominio2Chart:
                window.chartPngs[
                    'factoresDominio2Chart'
                ] || '',

            organizacionCategoriaChart:
                window.chartPngs[
                    'organizacionCategoriaChart'
                ] || '',

            organizacionDominio1Chart:
                window.chartPngs[
                    'organizacionDominio1Chart'
                ] || '',

            organizacionDominio2Chart:
                window.chartPngs[
                    'organizacionDominio2Chart'
                ] || '',

            liderazgoCategoriaChart:
                window.chartPngs[
                    'liderazgoCategoriaChart'
                ] || '',

            liderazgoDominio1Chart:
                window.chartPngs[
                    'liderazgoDominio1Chart'
                ] || '',

            liderazgoDominio2Chart:
                window.chartPngs[
                    'liderazgoDominio2Chart'
                ] || '',

            liderazgoDominio3Chart:
                window.chartPngs[
                    'liderazgoDominio3Chart'
                ] || '',

            entornoCategoriaChart:
                window.chartPngs[
                    'entornoCategoriaChart'
                ] || '',

            entornoDominio1Chart:
                window.chartPngs[
                    'entornoDominio1Chart'
                ] || '',

            entornoDominio2Chart:
                window.chartPngs[
                    'entornoDominio2Chart'
                ] || ''
        };

        var graficasParaRecortar = [
            'GRAFICA_CALIFICACION',
            'GRAFICA_CATEGORIAS',
            'GRAFICA_DOMINIOS',
            'GRAFICA_1'
        ];

        for (
            var indice = 0;
            indice < graficasParaRecortar.length;
            indice++
        ) {
            var nombreGrafica =
                graficasParaRecortar[indice];

            if (
                imagenesGraficas[nombreGrafica] &&
                imagenesGraficas[nombreGrafica].length > 100
            ) {
                imagenesGraficas[nombreGrafica] =
                    await recortarImagenBase64(
                        imagenesGraficas[nombreGrafica],
                        10
                    );
            }
        }

        var graficasFaltantes = [];

        Object.keys(
            imagenesGraficas
        ).forEach(
            function(nombreGrafica)
            {
                if (
                    !imagenesGraficas[
                        nombreGrafica
                    ] ||
                    imagenesGraficas[
                        nombreGrafica
                    ].length < 100
                ) {
                    graficasFaltantes.push(
                        nombreGrafica
                    );
                }
            }
        );

        if (
            graficasFaltantes.length > 0
        ) {
            console.warn(
                'Las siguientes gráficas no están disponibles:',
                graficasFaltantes
            );
        }

        const canvasDashboard =
            await html2canvas(
                dashboard,
                {
                    scale: 4,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#FFFFFF',
                    logging: false,
                    scrollX: 0,
                    scrollY: -window.scrollY,
                    width:
                        dashboard.scrollWidth,
                    height:
                        dashboard.scrollHeight,
                    windowWidth:
                        document
                            .documentElement
                            .scrollWidth,
                    windowHeight:
                        document
                            .documentElement
                            .scrollHeight
                }
            );

        const dashboardBase64 =
            canvasDashboard.toDataURL(
                'image/png',
                1
            );

        if (
            !dashboardBase64 ||
            dashboardBase64.length < 100
        ) {
            throw new Error(
                'No fue posible generar la imagen del dashboard'
            );
        }

        const canvasDashboardGeneral =
            await html2canvas(
                dashboardGeneral,
                {
                    scale: 4,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#FFFFFF',
                    logging: false,
                    scrollX: 0,
                    scrollY: -window.scrollY,
                    width:
                        dashboardGeneral.scrollWidth,
                    height:
                        dashboardGeneral.scrollHeight,
                    windowWidth:
                        document
                            .documentElement
                            .scrollWidth,
                    windowHeight:
                        document
                            .documentElement
                            .scrollHeight
                }
            );

        const dashboardGeneralBase64 =
            canvasDashboardGeneral.toDataURL(
                'image/png',
                1
            );

        if (
            !dashboardGeneralBase64 ||
            dashboardGeneralBase64.length < 100
        ) {
            throw new Error(
                'No fue posible generar la imagen del dashboard general'
            );
        }

        var form =
            $('<form>', {

                action:
                    '/descargarRevisioninfopsico/' +
                    PROYECTO_ID,

                method: 'POST',

                target: '_blank',

                style: 'display:none;'
            });

        form.append(
            $('<input>', {
                type: 'hidden',
                name: '_token',
                value:
                    $(
                        'meta[name="csrf-token"]'
                    ).attr(
                        'content'
                    )
            })
        );

        form.append(
            $('<input>', {
                type: 'hidden',
                name: 'DASHBOARD_FOTO',
                value: dashboardBase64
            })
        );

        form.append(
            $('<input>', {
                type: 'hidden',
                name: 'DASHBOARDA_GENERAL',
                value: dashboardGeneralBase64
            })
        );

        Object.keys(
            imagenesGraficas
        ).forEach(
            function(nombreInput)
            {
                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: nombreInput,
                        value:
                            imagenesGraficas[
                                nombreInput
                            ]
                    })
                );
            }
        );

        $('body').append(form);

        form.submit();

        setTimeout(
            function()
            {
                form.remove();
            },
            5000
        );

    } catch (error) {

        console.error(
            'Error al generar el informe:',
            error
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible generar las imágenes del informe'
        });
    }
}
// GENERO

function cargarGraficaGeneroPsico()
{
    $.get(
        '/obtenerGraficaGeneroPsico/' + proyecto.id,
        function(response)
        {
            let hombres = parseInt(response.hombres) || 0;
            let mujeres = parseInt(response.mujeres) || 0;

            let total = hombres + mujeres;

            let porcentajeHombres = total > 0
                ? Number(((hombres * 100) / total).toFixed(1))
                : 0;

            let porcentajeMujeres = total > 0
                ? Number(((mujeres * 100) / total).toFixed(1))
                : 0;

            $('#lblHombres').html(
                'Hombres: ' + hombres + ' (' + porcentajeHombres + '%)'
            );

            $('#lblMujeres').html(
                'Mujeres: ' + mujeres + ' (' + porcentajeMujeres + '%)'
            );

            $('#stopHombreColor').attr(
                'offset',
                porcentajeHombres + '%'
            );

            $('#stopHombreBlanco').attr(
                'offset',
                porcentajeHombres + '%'
            );

            $('#stopMujerColor').attr(
                'offset',
                porcentajeMujeres + '%'
            );

            $('#stopMujerBlanco').attr(
                'offset',
                porcentajeMujeres + '%'
            );
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
                    ? Number(
                        (
                            cantidad * 100 /
                            totalTrabajadores
                        ).toFixed(1)
                    )
                    : 0;

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
                formatter: function(valor)
                {
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
                        ? Number(
                            (
                                cantidad * 100 /
                                totalTrabajadores
                            ).toFixed(1)
                        )
                        : 0;

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
                        console.error(
                            'Error al exportar gráfica de edades:',
                            error
                        );
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

function generarGraficaEscolaridadPsico(datosEscolaridad,totalTrabajadores,maximo)
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

                dataLabels: {
                    position: 'center'
                }
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
                        ? Number(
                            (
                                cantidad *
                                100 /
                                total
                            ).toFixed(1)
                        )
                        : 0;

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

                style: {
                    fontSize: '12px'
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

        legend: {
            show: false
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
                            ? Number(
                                (
                                    cantidad *
                                    100 /
                                    total
                                ).toFixed(1)
                            )
                            : 0;

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
        document.querySelector(
            '#grafica_escolaridad'
        ),
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

function generarGraficaEstadoCivilPsico(estadoCivilData,totalTrabajadores,maximo)
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

    let total =
        parseInt(totalTrabajadores) || 0;

    if (total === 0) {

        total = valoresEstadoCivil.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    const porcentajesEstadoCivil =
        valoresEstadoCivil.map(function(cantidad)
        {
            return total > 0
                ? Number(
                    (
                        cantidad * 100 / total
                    ).toFixed(1)
                )
                : 0;
        });

    if (
        total > 0 &&
        porcentajesEstadoCivil.length > 0
    ) {

        const sumaPorcentajes =
            porcentajesEstadoCivil.reduce(
                function(acumulado, porcentaje)
                {
                    return acumulado + porcentaje;
                },
                0
            );

        const diferencia =
            Number(
                (
                    100 - sumaPorcentajes
                ).toFixed(1)
            );

        const valorMayor =
            Math.max.apply(
                null,
                valoresEstadoCivil
            );

        const indiceMayor =
            valoresEstadoCivil.indexOf(
                valorMayor
            );

        porcentajesEstadoCivil[indiceMayor] =
            Number(
                (
                    porcentajesEstadoCivil[indiceMayor] +
                    diferencia
                ).toFixed(1)
            );
    }

    let maximoEscala =
        parseInt(maximo) || 1;

    maximoEscala =
        maximoEscala + 1;

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

            formatter: function(valor, opciones)
            {
                const cantidad =
                    parseInt(valor) || 0;

                const indice =
                    opciones.dataPointIndex;

                const porcentaje =
                    porcentajesEstadoCivil[indice] || 0;

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

                style: {
                    fontSize: '11px'
                }
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

        legend: {
            show: false
        },

        tooltip: {
            theme: 'dark',

            y: {
                formatter: function(valor, opciones)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const indice =
                        opciones.dataPointIndex;

                    const porcentaje =
                        porcentajesEstadoCivil[indice] || 0;

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
        document.querySelector(
            '#grafica_estadocivil'
        ),
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

function generarGraficaRegimenPsico(regimenData,totalTrabajadores)
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

    let total =
        parseInt(totalTrabajadores) || 0;

    if (total === 0) {

        total = valoresRegimen.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    const porcentajesRegimen =
        valoresRegimen.map(function(cantidad)
        {
            return total > 0
                ? Number(
                    (
                        cantidad * 100 / total
                    ).toFixed(1)
                )
                : 0;
        });


    if (
        total > 0 &&
        porcentajesRegimen.length > 0
    ) {

        const sumaPorcentajes =
            porcentajesRegimen.reduce(
                function(acumulado, porcentaje)
                {
                    return acumulado + porcentaje;
                },
                0
            );

        const diferencia =
            Number(
                (
                    100 - sumaPorcentajes
                ).toFixed(1)
            );

        const valorMayor =
            Math.max.apply(
                null,
                valoresRegimen
            );

        const indiceMayor =
            valoresRegimen.indexOf(
                valorMayor
            );

        porcentajesRegimen[indiceMayor] =
            Number(
                (
                    porcentajesRegimen[indiceMayor] +
                    diferencia
                ).toFixed(1)
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
                const indice =
                    opts.seriesIndex;

                const cantidad =
                    valoresRegimen[indice] || 0;

                const porcentaje =
                    porcentajesRegimen[indice] || 0;

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
                formatter: function(valor, opts)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const indice =
                        opts.seriesIndex;

                    const porcentaje =
                        porcentajesRegimen[indice] || 0;

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
        document.querySelector(
            '#grafica_regimen'
        ),
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

    let total =
        parseInt(totalTrabajadores) || 0;

    if (total === 0) {

        total = valoresExperiencia.reduce(
            function(acumulado, valor)
            {
                return acumulado + valor;
            },
            0
        );
    }

    const porcentajesExperiencia =
        valoresExperiencia.map(function(cantidad)
        {
            return total > 0
                ? Number(
                    (
                        cantidad * 100 / total
                    ).toFixed(1)
                )
                : 0;
        });

    if (
        total > 0 &&
        porcentajesExperiencia.length > 0
    ) {

        const sumaPorcentajes =
            porcentajesExperiencia.reduce(
                function(acumulado, porcentaje)
                {
                    return acumulado + porcentaje;
                },
                0
            );

        const diferencia =
            Number(
                (
                    100 - sumaPorcentajes
                ).toFixed(1)
            );

        const valorMayor =
            Math.max.apply(
                null,
                valoresExperiencia
            );

        const indiceMayor =
            valoresExperiencia.indexOf(
                valorMayor
            );

        porcentajesExperiencia[indiceMayor] =
            Number(
                (
                    porcentajesExperiencia[indiceMayor] +
                    diferencia
                ).toFixed(1)
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
            )
            {
                const indice =
                    opts.seriesIndex;

                const cantidad =
                    valoresExperiencia[indice] || 0;

                const porcentaje =
                    porcentajesExperiencia[indice] || 0;

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
                formatter: function(valor, opts)
                {
                    const cantidad =
                        parseInt(valor) || 0;

                    const indice =
                        opts.seriesIndex;

                    const porcentaje =
                        porcentajesExperiencia[indice] || 0;

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
        document.querySelector(
            '#grafica_experiencia'
        ),
        optionsExperiencia
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

/// CALIFICACION GLOBAL

function cargarGraficaCalificacionPsico()
{
    $.get(
        '/obtenerGraficaCalificacionPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaCalificacionPsico(
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
            text: 'No fue posible consultar las calificaciones'
        });
    });
}

function generarGraficaCalificacionPsico(datosCalificacion,totalTrabajadores)
{
    if (!Array.isArray(datosCalificacion)) {
        datosCalificacion = [];
    }

    if (window.calificacionesRootPsico) {
        window.calificacionesRootPsico.dispose();
        window.calificacionesRootPsico = null;
    }

    $('#calificacionChart').empty();

    var datosFiltrados =
        datosCalificacion.filter(function(item)
        {
            return parseInt(item.value) > 0;
        });

    if (datosFiltrados.length === 0) {

        $('#calificacionChart').html(`
            <div
                style="
                    width:100%;
                    padding:60px 10px;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay respuestas válidas de la Guía III
            </div>
        `);

        calificacionchart = null;

        return;
    }

    datosFiltrados =
        datosFiltrados.map(function(item)
        {
            return {
                category: item.category,
                value: parseInt(item.value) || 0,
                color: item.color,
                porcentaje: 0
            };
        });

    var totalCalificaciones =
        datosFiltrados.reduce(
            function(acumulado, item)
            {
                return acumulado + item.value;
            },
            0
        );


    datosFiltrados.forEach(function(item)
    {
        item.porcentaje =
            totalCalificaciones > 0
                ? Math.round(
                    item.value *
                    100 /
                    totalCalificaciones
                )
                : 0;
    });

    if (
        totalCalificaciones > 0 &&
        datosFiltrados.length > 0
    ) {
        var sumaPorcentajes =
            datosFiltrados.reduce(
                function(acumulado, item)
                {
                    return acumulado +
                        item.porcentaje;
                },
                0
            );

        var diferencia =
            100 - sumaPorcentajes;

        var indiceMayor = 0;

        datosFiltrados.forEach(
            function(item, indice)
            {
                if (
                    item.value >
                    datosFiltrados[indiceMayor].value
                ) {
                    indiceMayor = indice;
                }
            }
        );

        datosFiltrados[indiceMayor].porcentaje =
            datosFiltrados[indiceMayor].porcentaje +
            diferencia;
    }

    window.calificacionesRootPsico =
        am5.Root.new(
            'calificacionChart'
        );

    var calificacionesRoot =
        window.calificacionesRootPsico;

    calificacionesRoot.setThemes([
        am5themes_Animated.new(
            calificacionesRoot
        )
    ]);

    var calificacionesChart =
        calificacionesRoot
            .container
            .children
            .push(
                am5percent.PieChart.new(
                    calificacionesRoot,
                    {
                        startAngle: 180,
                        endAngle: 360,

                        layout:
                            calificacionesRoot
                                .verticalLayout,

                        innerRadius:
                            am5.percent(50),

                        paddingTop: 10,
                        paddingBottom: 0
                    }
                )
            );

    var calificacionesSeries =
        calificacionesChart
            .series
            .push(
                am5percent.PieSeries.new(
                    calificacionesRoot,
                    {
                        startAngle: 180,
                        endAngle: 360,
                        valueField: 'value',
                        categoryField: 'category',
                        alignLabels: false
                    }
                )
            );

    calificacionesSeries
        .slices
        .template
        .adapters
        .add(
            'fill',
            function(fill, target)
            {
                if (
                    target.dataItem &&
                    target.dataItem.dataContext &&
                    target.dataItem.dataContext.color
                ) {
                    return am5.color(
                        target.dataItem
                            .dataContext
                            .color
                    );
                }

                return fill;
            }
        );

    calificacionesSeries
        .slices
        .template
        .adapters
        .add(
            'stroke',
            function(stroke, target)
            {
                if (
                    target.dataItem &&
                    target.dataItem.dataContext &&
                    target.dataItem.dataContext.color
                ) {
                    return am5.color(
                        target.dataItem
                            .dataContext
                            .color
                    );
                }

                return stroke;
            }
        );

    calificacionesSeries
        .slices
        .template
        .setAll({
            cornerRadius: 5,
            strokeWidth: 2,

            tooltipText:
                '{category}: {value} trabajadores ({porcentaje}%)'
        });

    calificacionesSeries
        .labels
        .template
        .setAll({
            fontSize: 23,
            fontWeight: 'bold',
            text: '{value} ({porcentaje}%)',
            radius: 8
        });

    calificacionesSeries
        .ticks
        .template
        .setAll({
            visible: false
        });

    var leyendaCalificaciones =
        calificacionesChart
            .children
            .push(
                am5.Legend.new(
                    calificacionesRoot,
                    {
                        centerX: am5.percent(50),
                        x: am5.percent(50),

                        layout:
                            calificacionesRoot
                                .horizontalLayout,

                        marginTop: -15,
                        dy: -10
                    }
                )
            );

    leyendaCalificaciones
        .labels
        .template
        .setAll({
            fontSize: 23,
            fontWeight: 'bold',

            text:
                '{category}: {value} ({porcentaje}%)'
        });

    leyendaCalificaciones
        .valueLabels
        .template
        .setAll({
            forceHidden: true
        });

    leyendaCalificaciones
        .markers
        .template
        .setAll({
            width: 18,
            height: 18
        });

    calificacionesChart
        .seriesContainer
        .children
        .push(
            am5.Label.new(
                calificacionesRoot,
                {
                    text:
                        'Total\n' +
                        (
                            parseInt(
                                totalTrabajadores
                            ) ||
                            totalCalificaciones
                        ),

                    centerX: am5.percent(50),
                    centerY: am5.percent(35),
                    textAlign: 'center',
                    fontSize: 23,
                    fontWeight: 'bold'
                }
            )
        );

    calificacionesSeries
        .data
        .setAll(
            datosFiltrados
        );

    leyendaCalificaciones
        .data
        .setAll(
            calificacionesSeries.dataItems
        );

    calificacionesSeries
        .appear(1000, 100)
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting
                    !== 'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                calificacionesRoot,
                                {
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(data)
                        {
                            calificacionchart =
                                data;

                            console.log(
                                'Gráfica de calificación exportada correctamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar gráfica de calificación:',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}


/// GRAFICA DE CATEGORIAS
function cargarGraficaCategoriasGuiaIII()
{
    $.get(
        '/obtenerGraficaCategoriasGuiaIIIPsicologia/' + proyecto.id,
        function(response)
        {
            generarGraficaCategoriasGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar las categorías de la Guía III'
        });
    });
}

function generarGraficaCategoriasGuiaIII(dataConsolidado1)
{
    if (!Array.isArray(dataConsolidado1)) {
        dataConsolidado1 = [];
    }

    if (
        window.rootConsolidadoChart1 &&
        !window.rootConsolidadoChart1.isDisposed()
    ) {

        window.rootConsolidadoChart1.dispose();

        window.rootConsolidadoChart1 = null;
    }

    $('#consolidadoChart').empty();


    if (dataConsolidado1.length === 0) {

        $('#consolidadoChart').html(`
            <div
                style="
                    width: 100%;
                    height: 600px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    font-weight: bold;
                    color: #777;
                "
            >
                No hay información disponible
            </div>
        `);

        categoriaschart = null;

        return;
    }


    window.rootConsolidadoChart1 =
        am5.Root.new(
            'consolidadoChart'
        );

    var rootConsolidadoChart1 =
        window.rootConsolidadoChart1;


    const customThemeConsolidado1 =
        am5.Theme.new(
            rootConsolidadoChart1
        );



    customThemeConsolidado1
        .rule('Label')
        .set(
            'fontSize',
            17
        );



    customThemeConsolidado1
        .rule('Grid')
        .set(
            'strokeOpacity',
            0
        );

    customThemeConsolidado1
        .rule('AxisRenderer')
        .setAll({

            background:
                am5.Rectangle.new(
                    rootConsolidadoChart1,
                    {
                        fill:
                            am5.color(0x000000),

                        fillOpacity:
                            0.7
                    }
                )

        });


    rootConsolidadoChart1.setThemes([

        am5themes_Animated.new(
            rootConsolidadoChart1
        ),

        customThemeConsolidado1

    ]);

    rootConsolidadoChart1
        .numberFormatter
        .set(
            'numberFormat',
            '0%'
        );

    var chartConsolidado1 =
        rootConsolidadoChart1
            .container
            .children
            .push(

                am5radar.RadarChart.new(
                    rootConsolidadoChart1,
                    {
                        panX:
                            false,

                        panY:
                            false,

                        wheelX:
                            'none',

                        wheelY:
                            'none',

                        innerRadius:
                            am5.percent(10),

                        radius:
                            am5.percent(85)
                    }
                )

            );



    chartConsolidado1
        .zoomOutButton
        .set(
            'forceHidden',
            true
        );


    var categoryAxisRendererConsolidado1 =
        am5radar.AxisRendererCircular.new(
            rootConsolidadoChart1,
            {
                innerRadius:
                    am5.percent(10)
            }
        );



    var categoryAxisConsolidado1 =
        chartConsolidado1
            .xAxes
            .push(

                am5xy.CategoryAxis.new(
                    rootConsolidadoChart1,
                    {
                        categoryField:
                            'category',

                        renderer:
                            categoryAxisRendererConsolidado1
                    }
                )

            );

    categoryAxisRendererConsolidado1
        .labels
        .template
        .setAll({

            fill:
                am5.color(0x000000),

            fontSize:
                20,

            fontWeight:
                'bold',

            paddingLeft:
                5,

            paddingRight:
                5,

            paddingTop:
                2,

            paddingBottom:
                2

        });


    categoryAxisConsolidado1
        .data
        .setAll(
            dataConsolidado1
        );



    var valueAxisConsolidado1 =
        chartConsolidado1
            .yAxes
            .push(

                am5xy.ValueAxis.new(
                    rootConsolidadoChart1,
                    {
                        renderer:
                            am5radar
                                .AxisRendererRadial
                                .new(
                                    rootConsolidadoChart1,
                                    {}
                                ),

                        min:
                            0,

                        max:
                            1,

                        strictMinMax:
                            true,

                        extraMax:
                            0.1
                    }
                )

            );


    valueAxisConsolidado1
        .get('renderer')
        .labels
        .template
        .setAll({
            visible:
                false
        });


    var seriesNamesConsolidado1 = [
        'Nulo',
        'Bajo',
        'Medio',
        'Alto',
        'Muy alto'
    ];


    var seriesColorsConsolidado1 = [

        am5.color(0x00B0F0),

        am5.color(0x00B050),

        am5.color(0xFFFF00),

        am5.color(0xF7AA32),

        am5.color(0xFF0000)

    ];

    seriesNamesConsolidado1.forEach(
        function(seriesName, index)
        {

            var series =
                chartConsolidado1
                    .series
                    .push(

                        am5radar
                            .RadarColumnSeries
                            .new(
                                rootConsolidadoChart1,
                                {
                                    stacked:
                                        true,

                                    name:
                                        seriesName,

                                    xAxis:
                                        categoryAxisConsolidado1,

                                    yAxis:
                                        valueAxisConsolidado1,

                                    valueYField:
                                        seriesName,

                                    categoryXField:
                                        'category'
                                }
                            )

                    );

            series
                .columns
                .template
                .setAll({

                    cornerRadius:
                        0,

                    strokeOpacity:
                        1,

                    stroke:
                        am5.color(0x000000),

                    strokeWidth:
                        0.5,

                    fill:
                        seriesColorsConsolidado1[index],

                    width:
                        am5.percent(100),

                    tooltipText:
                        seriesName

                });


            series
                .columns
                .template
                .adapters
                .add(
                    'tooltipText',

                    function(text, target)
                    {
                        if (
                            !target.dataItem ||
                            target.dataItem.get('valueY') === undefined
                        ) {

                            return seriesName;
                        }



                        var valor =
                            parseFloat(
                                target.dataItem.get('valueY')
                            ) || 0;



                        var porcentaje =
                            Math.round(
                                valor * 100
                            );



                        return seriesName +
                            ': ' +
                            porcentaje +
                            '%';
                    }
                );


            series
                .bullets
                .push(function(
                    root,
                    serie,
                    dataItem
                ) {

                    var valor =
                        parseFloat(
                            dataItem.get('valueY')
                        ) || 0;

                    if (valor <= 0) {
                        return undefined;
                    }

                    var porcentaje =
                        Math.round(
                            valor * 100
                        ) + '%';


                    return am5.Bullet.new(
                        rootConsolidadoChart1,
                        {
                            locationY:
                                0.5,

                            sprite:
                                am5.Label.new(
                                    rootConsolidadoChart1,
                                    {
                                        text:
                                            porcentaje,

                                        centerX:
                                            am5.p50,

                                        centerY:
                                            am5.p50,

                                        fill:
                                            am5.color(0x000000),

                                        fontSize:
                                            12,

                                        fontWeight:
                                            'bold',

                                        textAlign:
                                            'center'
                                    }
                                )
                        }
                    );

                });

            series
                .data
                .setAll(
                    dataConsolidado1
                );

        }
    );

    var legendConsolidado1 =
        chartConsolidado1
            .children
            .push(

                am5.Legend.new(
                    rootConsolidadoChart1,
                    {
                        centerX:
                            am5.p50,

                        x:
                            am5.p50,

                        y:
                            am5.p100,

                        layout:
                            rootConsolidadoChart1
                                .horizontalLayout,

                        marginTop:
                            1
                    }
                )

            );

    seriesNamesConsolidado1.forEach(
        function(seriesName, index)
        {

            var series =
                chartConsolidado1
                    .series
                    .getIndex(index);

            series.legendSettings = {

                labelText:
                    seriesName,

                fill:
                    seriesColorsConsolidado1[index]

            };

        }
    );


    legendConsolidado1
        .markers
        .template
        .setAll({

            width:
                20,

            height:
                20

        });


    legendConsolidado1
        .labels
        .template
        .setAll({

            fontSize:
                14,

            fontWeight:
                'bold'

        });


    legendConsolidado1
        .data
        .setAll(
            chartConsolidado1
                .series
                .values
        );


    chartConsolidado1
        .appear(
            1000,
            100
        )
        .then(function()
        {

            setTimeout(function()
            {



                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {

                    console.log(
                        'Plugin de exportación disponible'
                    );



                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                rootConsolidadoChart1,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                rootConsolidadoChart1,
                                                {}
                                            ),

                                    dpi:
                                        300,

                                    maxWidth:
                                        2000,

                                    maxHeight:
                                        2000
                                }
                            );



                    exporting
                        .export('png')
                        .then(function(data)
                        {

                            categoriaschart =
                                data;

                            console.log(
                                'Gráfica de categorías exportada exitosamente'
                            );

                        })
                        .catch(function(error)
                        {

                            console.error(
                                'Error al exportar:',
                                error
                            );

                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );

                }

            }, 1000);

        });
}

// DOMINIOS
function cargarGraficaDominiosGuiaIII()
{
    $.get(
        '/obtenerGraficaDominiosGuiaIIIPsicologia/' + proyecto.id,

        function(response)
        {
            generarGraficaDominiosGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar los dominios de la Guía III'
        });
    });
}

function generarGraficaDominiosGuiaIII(dataConsolidado2)
{
   

    if (!Array.isArray(dataConsolidado2)) {
        dataConsolidado2 = [];
    }



    if (
        window.rootConsolidadoChart2 &&
        !window.rootConsolidadoChart2.isDisposed()
    ) {

        window.rootConsolidadoChart2.dispose();

        window.rootConsolidadoChart2 = null;
    }



    $('#consolidadoChart2').empty();



    if (dataConsolidado2.length === 0) {

        $('#consolidadoChart2').html(`
            <div
                style="
                    width:100%;
                    height:750px;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información disponible
            </div>
        `);

        dominioschart = null;

        return;
    }


    window.rootConsolidadoChart2 =
        am5.Root.new(
            'consolidadoChart2'
        );

    var rootConsolidadoChart2 =
        window.rootConsolidadoChart2;


    const customThemeConsolidado2 =
        am5.Theme.new(
            rootConsolidadoChart2
        );



    customThemeConsolidado2
        .rule('Label')
        .set(
            'fontSize',
            20
        );



    customThemeConsolidado2
        .rule('Grid')
        .set(
            'strokeOpacity',
            0
        );



    customThemeConsolidado2
        .rule('AxisRenderer')
        .setAll({

            background:
                am5.Rectangle.new(
                    rootConsolidadoChart2,
                    {
                        fill:
                            am5.color(0x000000),

                        fillOpacity:
                            0.7
                    }
                )

        });


    rootConsolidadoChart2.setThemes([

        am5themes_Animated.new(
            rootConsolidadoChart2
        ),

        customThemeConsolidado2

    ]);



    rootConsolidadoChart2
        .numberFormatter
        .set(
            'numberFormat',
            '0%'
        );

    var chartConsolidado2 =
        rootConsolidadoChart2
            .container
            .children
            .push(

                am5radar.RadarChart.new(
                    rootConsolidadoChart2,
                    {
                        panX:
                            false,

                        panY:
                            false,

                        wheelX:
                            'none',

                        wheelY:
                            'none',

                        innerRadius:
                            am5.percent(10),

                        radius:
                            am5.percent(82)
                    }
                )

            );



    chartConsolidado2
        .zoomOutButton
        .set(
            'forceHidden',
            true
        );


    var categoryAxisRendererConsolidado2 =
        am5radar.AxisRendererCircular.new(
            rootConsolidadoChart2,
            {
                innerRadius:
                    am5.percent(10)
            }
        );



    var categoryAxisConsolidado2 =
        chartConsolidado2
            .xAxes
            .push(

                am5xy.CategoryAxis.new(
                    rootConsolidadoChart2,
                    {
                        categoryField:
                            'category',

                        renderer:
                            categoryAxisRendererConsolidado2
                    }
                )

            );


    categoryAxisRendererConsolidado2
        .labels
        .template
        .setAll({

            fill:
                am5.color(0x000000),

            fontSize:
                16,

            fontWeight:
                'bold',

            paddingLeft:
                5,

            paddingRight:
                5,

            paddingTop:
                2,

            paddingBottom:
                2,

            radius:
                5,

            centerX:
                am5.p50,

            centerY:
                am5.p50,

            textAlign:
                'center',

            oversizedBehavior:
                'wrap',

            maxWidth:
                170
        });


    categoryAxisConsolidado2
        .data
        .setAll(
            dataConsolidado2
        );



    var valueAxisConsolidado2 =
        chartConsolidado2
            .yAxes
            .push(

                am5xy.ValueAxis.new(
                    rootConsolidadoChart2,
                    {
                        renderer:
                            am5radar
                                .AxisRendererRadial
                                .new(
                                    rootConsolidadoChart2,
                                    {}
                                ),

                        min:
                            0,

                        max:
                            1,

                        strictMinMax:
                            true,

                        extraMax:
                            0.1
                    }
                )

            );



    valueAxisConsolidado2
        .get('renderer')
        .labels
        .template
        .setAll({
            visible:
                false
        });


    var seriesNamesConsolidado2 = [
        'Nulo',
        'Bajo',
        'Medio',
        'Alto',
        'Muy alto'
    ];



    var seriesColorsConsolidado2 = [

        am5.color(0x00B0F0),

        am5.color(0x00B050),

        am5.color(0xFFFF00),

        am5.color(0xF7AA32),

        am5.color(0xFF0000)

    ];


    seriesNamesConsolidado2.forEach(
        function(seriesName, index)
        {

            var series =
                chartConsolidado2
                    .series
                    .push(

                        am5radar
                            .RadarColumnSeries
                            .new(
                                rootConsolidadoChart2,
                                {
                                    stacked:
                                        true,

                                    name:
                                        seriesName,

                                    xAxis:
                                        categoryAxisConsolidado2,

                                    yAxis:
                                        valueAxisConsolidado2,

                                    valueYField:
                                        seriesName,

                                    categoryXField:
                                        'category'
                                }
                            )

                    );



            series
                .columns
                .template
                .setAll({

                    cornerRadius:
                        0,

                    strokeOpacity:
                        1,

                    stroke:
                        am5.color(0x000000),

                    strokeWidth:
                        0.5,

                    fill:
                        seriesColorsConsolidado2[index],

                    width:
                        am5.percent(100),

                    tooltipText:
                        seriesName

                });


            series
                .columns
                .template
                .adapters
                .add(
                    'tooltipText',

                    function(text, target)
                    {
                        if (
                            !target.dataItem ||
                            target.dataItem.get('valueY') === undefined
                        ) {

                            return seriesName;
                        }



                        var valor =
                            parseFloat(
                                target.dataItem.get('valueY')
                            ) || 0;



                        var porcentaje =
                            Math.round(
                                valor * 100
                            );



                        return seriesName +
                            ': ' +
                            porcentaje +
                            '%';
                    }
                );

            series
                .bullets
                .push(function(
                    root,
                    serie,
                    dataItem
                ) {

                    var valor =
                        parseFloat(
                            dataItem.get('valueY')
                        ) || 0;



                    if (valor <= 0) {
                        return undefined;
                    }



                    var porcentaje =
                        Math.round(
                            valor * 100
                        ) + '%';



                    return am5.Bullet.new(
                        rootConsolidadoChart2,
                        {
                            locationY:
                                0.5,

                            sprite:
                                am5.Label.new(
                                    rootConsolidadoChart2,
                                    {
                                        text:
                                            porcentaje,

                                        centerX:
                                            am5.p50,

                                        centerY:
                                            am5.p50,

                                        fill:
                                            am5.color(0x000000),

                                        fontSize:
                                            10,

                                        fontWeight:
                                            'bold',

                                        textAlign:
                                            'center'
                                    }
                                )
                        }
                    );

                });


            series
                .data
                .setAll(
                    dataConsolidado2
                );

        }
    );


    var legendConsolidado2 =
        chartConsolidado2
            .children
            .push(

                am5.Legend.new(
                    rootConsolidadoChart2,
                    {
                        centerX:
                            am5.p50,

                        x:
                            am5.p50,

                        y:
                            am5.p100,

                        layout:
                            rootConsolidadoChart2
                                .horizontalLayout,

                        marginTop:
                            1
                    }
                )

            );


    seriesNamesConsolidado2.forEach(
        function(seriesName, index)
        {

            var series =
                chartConsolidado2
                    .series
                    .getIndex(index);

            series.legendSettings = {

                labelText:
                    seriesName,

                fill:
                    seriesColorsConsolidado2[index]

            };

        }
    );



    legendConsolidado2
        .markers
        .template
        .setAll({

            width:
                20,

            height:
                20

        });



    legendConsolidado2
        .labels
        .template
        .setAll({

            fontSize:
                14,

            fontWeight:
                'bold'

        });



    legendConsolidado2
        .data
        .setAll(
            chartConsolidado2
                .series
                .values
        );

    chartConsolidado2
        .appear(
            1000,
            100
        )
        .then(function()
        {

            setTimeout(function()
            {

                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {

                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                rootConsolidadoChart2,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                rootConsolidadoChart2,
                                                {}
                                            ),

                                    dpi:
                                        300,

                                    maxWidth:
                                        2000,

                                    maxHeight:
                                        2000
                                }
                            );



                    exporting
                        .export('png')
                        .then(function(data)
                        {

                            dominioschart =
                                data;

                            console.log(
                                'Gráfica de dominios exportada correctamente'
                            );

                        })
                        .catch(function(error)
                        {

                            console.error(
                                'Error al exportar gráfica de dominios:',
                                error
                            );

                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );

                }

            }, 1000);

        });
}

/// GUIA I
function cargarGraficaGuiaIPsico()
{
    $.get(
        '/obtenerGraficaGuiaIPsico/' + proyecto.id,
        function(response)
        {
            generarGraficaGuiaIPsico(
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
            text: 'No fue posible consultar los resultados de la Guía I'
        });
    });
}

function generarGraficaGuiaIPsico(guia1Data,totalTrabajadores)
{
    if (!Array.isArray(guia1Data)) {
        guia1Data = [];
    }

    if (
        window.guia1Root &&
        !window.guia1Root.isDisposed()
    ) {
        window.guia1Root.dispose();
        window.guia1Root = null;
    }

    $('#guia1Chart').empty();

    var datosFiltrados =
        guia1Data.filter(function(item)
        {
            return parseInt(item.value) > 0;
        });

    if (datosFiltrados.length === 0) {

        $('#guia1Chart').html(`
            <div
                style="
                    width:100%;
                    height:500px;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    text-align:center;
                    font-weight:bold;
                    color:#777;
                "
            >
                No hay información disponible de la Guía I
            </div>
        `);

        acontecimientoschart = null;

        return;
    }

    datosFiltrados =
        datosFiltrados.map(function(item)
        {
            return {
                category: item.category,
                value: parseInt(item.value) || 0,
                color: item.color,
                porcentaje: 0
            };
        });

    var totalGrafica =
        datosFiltrados.reduce(
            function(acumulado, item)
            {
                return acumulado + item.value;
            },
            0
        );

    var total =
        parseInt(totalTrabajadores) || 0;

    if (total === 0) {
        total = totalGrafica;
    }


    datosFiltrados.forEach(function(item)
    {
        item.porcentaje =
            totalGrafica > 0
                ? Math.round(
                    item.value *
                    100 /
                    totalGrafica
                )
                : 0;
    });


    if (
        totalGrafica > 0 &&
        datosFiltrados.length > 0
    ) {
        var sumaPorcentajes =
            datosFiltrados.reduce(
                function(acumulado, item)
                {
                    return acumulado +
                        item.porcentaje;
                },
                0
            );

        var diferencia =
            100 - sumaPorcentajes;

        var indiceMayor = 0;

        datosFiltrados.forEach(
            function(item, indice)
            {
                if (
                    item.value >
                    datosFiltrados[indiceMayor].value
                ) {
                    indiceMayor = indice;
                }
            }
        );

        datosFiltrados[indiceMayor].porcentaje =
            datosFiltrados[indiceMayor].porcentaje +
            diferencia;
    }

    window.guia1Root =
        am5.Root.new(
            'guia1Chart'
        );

    var guia1_root =
        window.guia1Root;

    guia1_root.setThemes([
        am5themes_Animated.new(
            guia1_root
        )
    ]);

    var guia1_chart =
        guia1_root
            .container
            .children
            .push(
                am5percent.PieChart.new(
                    guia1_root,
                    {
                        startAngle: 180,
                        endAngle: 360,

                        layout:
                            guia1_root.verticalLayout,

                        innerRadius:
                            am5.percent(50),

                        paddingBottom: 0
                    }
                )
            );

    var guia1_series =
        guia1_chart
            .series
            .push(
                am5percent.PieSeries.new(
                    guia1_root,
                    {
                        startAngle: 180,
                        endAngle: 360,

                        valueField:
                            'value',

                        categoryField:
                            'category',

                        alignLabels:
                            false,

                        
                        legendLabelText:
                            '{category}',

                        legendValueText:
                            '{porcentaje.formatNumber("0")}%'
                    }
                )
            );

    guia1_series
        .slices
        .template
        .adapters
        .add(
            'fill',
            function(fill, target)
            {
                if (
                    target.dataItem &&
                    target.dataItem.dataContext &&
                    target.dataItem.dataContext.color
                ) {
                    return am5.color(
                        target.dataItem
                            .dataContext
                            .color
                    );
                }

                return fill;
            }
        );

    guia1_series
        .slices
        .template
        .adapters
        .add(
            'stroke',
            function(stroke, target)
            {
                if (
                    target.dataItem &&
                    target.dataItem.dataContext &&
                    target.dataItem.dataContext.color
                ) {
                    return am5.color(
                        target.dataItem
                            .dataContext
                            .color
                    );
                }

                return stroke;
            }
        );

    guia1_series
        .slices
        .template
        .setAll({
            cornerRadius: 5,
            stroke: am5.color(0xFFFFFF),
            strokeWidth: 2,

            tooltipText:
                '{category}: ' +
                '{value.formatNumber("0")} trabajadores ' +
                '({porcentaje.formatNumber("0")}%)'
        });

    
    guia1_series
        .labels
        .template
        .setAll({
            fontSize: 23,
            fontWeight: 'bold',

            text:
                '{value.formatNumber("0")} ' +
                '({porcentaje.formatNumber("0")}%)'
        });

    guia1_series
        .ticks
        .template
        .setAll({
            visible: false
        });

    var legend3 =
        guia1_chart
            .children
            .push(
                am5.Legend.new(
                    guia1_root,
                    {
                        centerX: am5.percent(50),
                        x: am5.percent(50),

                        layout:
                            guia1_root.verticalLayout,

                        marginTop: -10,
                        dy: -10
                    }
                )
            );

    legend3
        .labels
        .template
        .setAll({
            fontSize: 23,
            fontWeight: 'bold'
        });

    legend3
        .valueLabels
        .template
        .setAll({
            fontSize: 23,
            fontWeight: 'bold'
        });

    legend3
        .markers
        .template
        .setAll({
            width: 20,
            height: 20
        });

    guia1_series
        .data
        .setAll(
            datosFiltrados
        );

    legend3
        .data
        .setAll(
            guia1_series.dataItems
        );

    guia1_series
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                guia1_root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                guia1_root,
                                                {}
                                            ),

                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(data)
                        {
                            acontecimientoschart =
                                data;

                            console.log(
                                'Gráfica de Guía I exportada correctamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar gráfica de Guía I:',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

// CATEGORIA AMBIENTE DE TRABAJO -> ACTUALIZADO  
function cargarGraficaAmbienteGuiaIII()
{
    $.get(
        '/obtenerGraficaAmbienteGuiaIII/' + proyecto.id,
        function(response)
        {
            var datos =
                Array.isArray(response.data)
                    ? response.data
                    : [];

            var indiceDominios =
                datos.findIndex(function(item)
                {
                    var categoria =
                        item.category || '';

                    return categoria.indexOf('g3-') === 0;
                });

            var datosCategoria = [];
            var datosDominio = [];

            if (indiceDominios >= 0) {

                datosCategoria =
                    datos.slice(
                        0,
                        indiceDominios
                    );

                datosDominio =
                    datos.slice(
                        indiceDominios + 1
                    );

            } else {

                datos.forEach(function(item)
                {
                    var categoria =
                        (
                            item.category || ''
                        )
                        .replace(/^g[123]-/, '')
                        .trim()
                        .toLowerCase();

                    if (
                        categoria.indexOf(
                            'condiciones del ambiente'
                        ) !== -1
                    ) {
                        datosDominio.push(item);
                    } else {
                        datosCategoria.push(item);
                    }
                });
            }

            crearGraficaAmbienteSeparada(
                datosCategoria,
                'ambienteCategoriaChart',
                'ambienteCategoriaChart',
                'Ambiente de trabajo'
            );

            crearGraficaAmbienteSeparada(
                datosDominio,
                'ambienteDominioChart',
                'ambienteDominioChart',
                'Condiciones del ambiente de trabajo'
            );
        }
    )
    .fail(function(xhr)
    {
        console.error(
            xhr.responseText
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar las gráficas de ambiente de trabajo'
        });
    });
}

function crearGraficaAmbienteSeparada( data,contenedorId,nombreGrafica,titulo)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    window.graficasAmbienteRoots =
        window.graficasAmbienteRoots || {};

    if (
        window.graficasAmbienteRoots[nombreGrafica] &&
        !window.graficasAmbienteRoots[nombreGrafica].isDisposed()
    ) {
        window.graficasAmbienteRoots[nombreGrafica].dispose();
        window.graficasAmbienteRoots[nombreGrafica] = null;
    }

    var contenedor =
        document.getElementById(
            contenedorId
        );

    if (!contenedor) {

        console.error(
            'No existe el contenedor #' +
            contenedorId
        );

        return;
    }

    contenedor.innerHTML = '';

    if (data.length === 0) {

        contenedor.innerHTML = `
            <div style="
                width:100%;
                height:320px;
                display:flex;
                justify-content:center;
                align-items:center;
                text-align:center;
                font-weight:bold;
                color:#777;
            ">
                No hay información disponible
            </div>
        `;

        window.chartPngs =
            window.chartPngs || {};

        window.chartPngs[
            nombreGrafica
        ] = null;

        return;
    }

    var dataGrafica =
        data.slice();

    var root =
        am5.Root.new(
            contenedorId
        );

    window.graficasAmbienteRoots[
        nombreGrafica
    ] = root;

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart =
        root.container.children.push(
            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    layout: root.verticalLayout,
                    paddingTop: 0,
                    paddingBottom: 0,
                    paddingLeft: 0,
                    paddingRight: 20
                }
            )
        );

    chart.children.unshift(
        am5.Label.new(
            root,
            {
                text: titulo,
                fontSize: 18,
                fontWeight: 'bold',
                textAlign: 'center',
                x: am5.p50,
                centerX: am5.p50,
                marginTop: 5,
                marginBottom: 15,
                paddingTop: 0,
                paddingBottom: 0
            }
        )
    );

    var legend =
        chart.children.push(
            am5.Legend.new(
                root,
                {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 5,
                    marginBottom: 0,
                    paddingTop: 0,
                    paddingBottom: 0
                }
            )
        );

    legend.labels.template.setAll({
        fontSize: 20,
        fontWeight: 'bold'
    });

    legend.valueLabels.template.setAll({
        forceHidden: true,
        visible: false
    });

    legend.markers.template.setAll({
        width: 20,
        height: 20
    });

    var yAxisRenderer =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                cellStartLocation: 0.15,
                cellEndLocation: 0.85,
                minGridDistance: 0
            }
        );

    var yAxis =
        chart.yAxes.push(
            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField: 'category',
                    renderer: yAxisRenderer,
                    tooltip:
                        am5.Tooltip.new(
                            root,
                            {}
                        )
                }
            )
        );

    yAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    yAxis.data.setAll(
        dataGrafica
    );

    var xAxisRenderer =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 50
            }
        );

    var xAxis =
        chart.xAxes.push(
            am5xy.ValueAxis.new(
                root,
                {
                    renderer: xAxisRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    maxDeviation: 0
                }
            )
        );

    xAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    xAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    xAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    if (xAxisRenderer.baseGrid) {

        xAxisRenderer.baseGrid.setAll({
            forceHidden: true,
            visible: false,
            strokeOpacity: 0
        });
    }

    function obtenerPorcentajesEnteros(valores)
    {
        var total =
            valores.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        if (total <= 0) {

            return [
                0,
                0,
                0,
                0,
                0
            ];
        }

        var porcentajesExactos =
            valores.map(function(valor)
            {
                return (
                    valor /
                    total
                ) * 100;
            });

        var porcentajesEnteros =
            porcentajesExactos.map(function(valor)
            {
                return Math.floor(valor);
            });

        var sumaEnteros =
            porcentajesEnteros.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        var faltantes =
            100 - sumaEnteros;

        var residuos =
            porcentajesExactos.map(
                function(valor, indice)
                {
                    return {
                        indice: indice,
                        residuo:
                            valor -
                            porcentajesEnteros[
                                indice
                            ]
                    };
                }
            );

        residuos.sort(function(a, b)
        {
            return b.residuo - a.residuo;
        });

        for (
            var indice = 0;
            indice < faltantes;
            indice++
        ) {
            porcentajesEnteros[
                residuos[indice].indice
            ]++;
        }

        return porcentajesEnteros;
    }

    function calcularDatos(datos)
    {
        return datos.map(function(item)
        {
            var category =
                item.category || '';

            var s1 =
                parseInt(
                    item.s1,
                    10
                ) || 0;

            var s2 =
                parseInt(
                    item.s2,
                    10
                ) || 0;

            var s3 =
                parseInt(
                    item.s3,
                    10
                ) || 0;

            var s4 =
                parseInt(
                    item.s4,
                    10
                ) || 0;

            var s5 =
                parseInt(
                    item.s5,
                    10
                ) || 0;

            var valores = [
                s1,
                s2,
                s3,
                s4,
                s5
            ];

            var total =
                valores.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (total <= 0) {

                return {
                    category: category,
                    s1: s1,
                    s2: s2,
                    s3: s3,
                    s4: s4,
                    s5: s5,
                    percentage_s1: 0,
                    percentage_s2: 0,
                    percentage_s3: 0,
                    percentage_s4: 0,
                    percentage_s5: 0,
                    visual_s1: 0,
                    visual_s2: 0,
                    visual_s3: 0,
                    visual_s4: 0,
                    visual_s5: 0
                };
            }

            var porcentajesEnteros =
                obtenerPorcentajesEnteros(
                    valores
                );

            var porcentajesExactos =
                valores.map(function(valor)
                {
                    return (
                        valor /
                        total
                    ) * 100;
                });

            var minimoVisual = 8;

            var valoresVisuales =
                porcentajesExactos.map(
                    function(porcentaje, indice)
                    {
                        if (
                            valores[indice] <= 0
                        ) {
                            return 0;
                        }

                        return Math.max(
                            porcentaje,
                            minimoVisual
                        );
                    }
                );

            var totalVisual =
                valoresVisuales.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (totalVisual > 0) {

                valoresVisuales =
                    valoresVisuales.map(
                        function(valor)
                        {
                            return (
                                valor /
                                totalVisual
                            ) * 100;
                        }
                    );
            }

            return {
                category: category,
                s1: s1,
                s2: s2,
                s3: s3,
                s4: s4,
                s5: s5,
                percentage_s1:
                    porcentajesEnteros[0],
                percentage_s2:
                    porcentajesEnteros[1],
                percentage_s3:
                    porcentajesEnteros[2],
                percentage_s4:
                    porcentajesEnteros[3],
                percentage_s5:
                    porcentajesEnteros[4],
                visual_s1:
                    valoresVisuales[0],
                visual_s2:
                    valoresVisuales[1],
                visual_s3:
                    valoresVisuales[2],
                visual_s4:
                    valoresVisuales[3],
                visual_s5:
                    valoresVisuales[4]
            };
        });
    }

    var processedData =
        calcularDatos(
            dataGrafica
        );

    function makeSeries(
        name,
        cantidadField,
        porcentajeField,
        visualField,
        color
    ) {
        var series =
            chart.series.push(
                am5xy.ColumnSeries.new(
                    root,
                    {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        stacked: true,
                        valueXField:
                            visualField,
                        categoryYField:
                            'category',
                        stroke: color,
                        fill: color
                    }
                )
            );

        series.columns.template.setAll({
            height: am5.percent(70),
            tooltipY: 0,
            stroke:
                am5.color(
                    0x000000
                ),
            strokeWidth: 0.5,
            tooltipText:
                '{name}: {cantidad} trabajadores ({porcentaje}%)'
        });

        series.bullets.push(function(
            rootBullet,
            serie,
            dataItem
        ) {
            var contexto =
                dataItem.dataContext || {};

            var cantidad =
                parseInt(
                    contexto.cantidad,
                    10
                ) || 0;

            if (cantidad <= 0) {
                return undefined;
            }

            var porcentaje =
                parseInt(
                    contexto.porcentaje,
                    10
                ) || 0;

            var tamanioLetra = 17;

            if (porcentaje <= 3) {
                tamanioLetra = 13;
            } else if (porcentaje <= 5) {
                tamanioLetra = 14;
            } else if (porcentaje <= 10) {
                tamanioLetra = 15;
            }

            return am5.Bullet.new(
                root,
                {
                    locationX: 0.5,
                    locationY: 0.5,
                    sprite:
                        am5.Label.new(
                            root,
                            {
                                text:
                                    cantidad +
                                    ' (' +
                                    porcentaje +
                                    '%)',
                                centerX: am5.p50,
                                centerY: am5.p50,
                                populateText: false,
                                fontSize:
                                    tamanioLetra,
                                fill:
                                    am5.color(
                                        0x000000
                                    ),
                                fontWeight:
                                    'bold',
                                textAlign:
                                    'center',
                                paddingLeft: 1,
                                paddingRight: 1
                            }
                        )
                }
            );
        });

        var datosSerie =
            processedData.map(
                function(item)
                {
                    var fila = {
                        category:
                            item.category,
                        cantidad:
                            item[cantidadField],
                        porcentaje:
                            item[porcentajeField]
                    };

                    fila[visualField] =
                        item[visualField];

                    return fila;
                }
            );

        series.data.setAll(
            datosSerie
        );

        series.appear();

        legend.data.push(
            series
        );
    }

    makeSeries(
        'Muy alto',
        's1',
        'percentage_s1',
        'visual_s1',
        am5.color(0xFF0000)
    );

    makeSeries(
        'Alto',
        's2',
        'percentage_s2',
        'visual_s2',
        am5.color(0xF7AA32)
    );

    makeSeries(
        'Medio',
        's3',
        'percentage_s3',
        'visual_s3',
        am5.color(0xFFFF00)
    );

    makeSeries(
        'Bajo',
        's4',
        'percentage_s4',
        'visual_s4',
        am5.color(0x00B050)
    );

    makeSeries(
        'Nulo',
        's5',
        'percentage_s5',
        'visual_s5',
        am5.color(0x00B0F0)
    );

    chart
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                root,
                                                {}
                                            ),
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(imagen)
                        {
                            window.chartPngs =
                                window.chartPngs || {};

                            window.chartPngs[
                                nombreGrafica
                            ] = imagen;

                            console.log(
                                nombreGrafica +
                                ' exportado exitosamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar ' +
                                nombreGrafica +
                                ':',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

// CATEGORIA FACTORES PROPIOS DE LA ACTIVIDAD -> ACTUALIZADO 
function cargarGraficaFactoresGuiaIII()
{
    $.get(
        '/obtenerGraficaFactoresGuiaIII/' + proyecto.id,
        function(response)
        {
            crearGraficaFactoresGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.error(
            xhr.responseText
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la gráfica de factores propios de la actividad'
        });
    });
}

function crearGraficaFactoresGuiaIII(data)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    var datosCategoria = [];
    var datosDominios = [];
    var encontroSeparador = false;

    data.forEach(function(item)
    {
        var category =
            item.category || '';

        if (
            category.indexOf('g3-') === 0
        ) {
            encontroSeparador = true;
            return;
        }

        if (encontroSeparador) {
            datosDominios.push(item);
        } else {
            datosCategoria.push(item);
        }
    });

    if (!encontroSeparador) {

        datosCategoria = [];
        datosDominios = [];

        data.forEach(function(item)
        {
            var category =
                item.category || '';

            var nombre =
                category
                    .replace(/^g[123]-/, '')
                    .trim()
                    .toLowerCase();

            if (
                nombre.indexOf(
                    'carga de trabajo'
                ) !== -1 ||
                nombre.indexOf(
                    'falta de control sobre el trabajo'
                ) !== -1
            ) {
                datosDominios.push(item);
            } else {
                datosCategoria.push(item);
            }
        });
    }

    var datosDominio1 = [];
    var datosDominio2 = [];

    datosDominios.forEach(function(item)
    {
        var category =
            item.category || '';

        var nombre =
            category
                .replace(/^g[123]-/, '')
                .trim()
                .toLowerCase();

        if (
            nombre.indexOf(
                'carga de trabajo'
            ) !== -1
        ) {
            datosDominio1.push(item);
        }

        if (
            nombre.indexOf(
                'falta de control sobre el trabajo'
            ) !== -1
        ) {
            datosDominio2.push(item);
        }
    });

    if (
        datosDominio1.length === 0 &&
        datosDominios.length > 0
    ) {
        datosDominio1.push(
            datosDominios[0]
        );
    }

    if (
        datosDominio2.length === 0 &&
        datosDominios.length > 1
    ) {
        datosDominio2.push(
            datosDominios[1]
        );
    }

    crearGraficaFactoresIndividual(
        datosCategoria,
        'factoresCategoriaChart',
        'factoresCategoriaChartRoot',
        'factoresCategoriaChart',
        'Factores propios de la actividad'
    );

    crearGraficaFactoresIndividual(
        datosDominio1,
        'factoresDominio1Chart',
        'factoresDominio1ChartRoot',
        'factoresDominio1Chart',
        'Carga de trabajo'
    );

    crearGraficaFactoresIndividual(
        datosDominio2,
        'factoresDominio2Chart',
        'factoresDominio2ChartRoot',
        'factoresDominio2Chart',
        'Falta de control sobre el trabajo'
    );
}

function crearGraficaFactoresIndividual( data,contenedorId,rootNombre,nombreGrafica,titulo)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    if (
        window[rootNombre] &&
        !window[rootNombre].isDisposed()
    ) {
        window[rootNombre].dispose();
        window[rootNombre] = null;
    }

    var contenedor =
        document.getElementById(
            contenedorId
        );

    if (!contenedor) {
        console.error(
            'No existe el contenedor #' +
            contenedorId
        );

        return;
    }

    contenedor.innerHTML = '';

    if (data.length === 0) {

        contenedor.innerHTML = `
            <div style="
                width:100%;
                height:320px;
                display:flex;
                justify-content:center;
                align-items:center;
                text-align:center;
                font-weight:bold;
                color:#777;
            ">
                No hay información disponible
            </div>
        `;

        window.chartPngs =
            window.chartPngs || {};

        window.chartPngs[
            nombreGrafica
        ] = null;

        return;
    }

    window[rootNombre] =
        am5.Root.new(
            contenedorId
        );

    var root =
        window[rootNombre];

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart =
        root.container.children.push(
            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    layout: root.verticalLayout,
                    paddingTop: 0,
                    paddingBottom: 0,
                    paddingLeft: 0,
                    paddingRight: 20
                }
            )
        );

    chart.children.unshift(
        am5.Label.new(
            root,
            {
                text: titulo,
                fontSize: 18,
                fontWeight: 'bold',
                textAlign: 'center',
                x: am5.p50,
                centerX: am5.p50,
                marginTop: 5,
                marginBottom: 15,
                paddingTop: 0,
                paddingBottom: 0
            }
        )
    );

    var legend =
        chart.children.push(
            am5.Legend.new(
                root,
                {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 5,
                    marginBottom: 0,
                    paddingTop: 0,
                    paddingBottom: 0
                }
            )
        );

    legend.labels.template.setAll({
        fontSize: 20,
        fontWeight: 'bold'
    });

    legend.valueLabels.template.setAll({
        forceHidden: true,
        visible: false
    });

    legend.markers.template.setAll({
        width: 20,
        height: 20
    });

    var yAxisRenderer =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                cellStartLocation: 0.15,
                cellEndLocation: 0.85,
                minGridDistance: 0
            }
        );

    var yAxis =
        chart.yAxes.push(
            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField: 'category',
                    renderer: yAxisRenderer,
                    tooltip:
                        am5.Tooltip.new(
                            root,
                            {}
                        )
                }
            )
        );

    yAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    yAxis.data.setAll(data);

    var xAxisRenderer =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 50
            }
        );

    var xAxis =
        chart.xAxes.push(
            am5xy.ValueAxis.new(
                root,
                {
                    renderer: xAxisRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    maxDeviation: 0
                }
            )
        );

    xAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    xAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    xAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    if (xAxisRenderer.baseGrid) {
        xAxisRenderer.baseGrid.setAll({
            forceHidden: true,
            visible: false,
            strokeOpacity: 0
        });
    }

    function obtenerPorcentajesEnteros(valores)
    {
        var total =
            valores.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        if (total <= 0) {
            return [0, 0, 0, 0, 0];
        }

        var porcentajesExactos =
            valores.map(function(valor)
            {
                return (
                    valor /
                    total
                ) * 100;
            });

        var porcentajesEnteros =
            porcentajesExactos.map(function(valor)
            {
                return Math.floor(valor);
            });

        var sumaEnteros =
            porcentajesEnteros.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        var faltantes =
            100 - sumaEnteros;

        var residuos =
            porcentajesExactos.map(
                function(valor, indice)
                {
                    return {
                        indice: indice,
                        residuo:
                            valor -
                            porcentajesEnteros[
                                indice
                            ]
                    };
                }
            );

        residuos.sort(function(a, b)
        {
            return b.residuo - a.residuo;
        });

        for (
            var indice = 0;
            indice < faltantes;
            indice++
        ) {
            porcentajesEnteros[
                residuos[indice].indice
            ]++;
        }

        return porcentajesEnteros;
    }

    function calcularDatos(datos)
    {
        return datos.map(function(item)
        {
            var s1 =
                parseInt(
                    item.s1,
                    10
                ) || 0;

            var s2 =
                parseInt(
                    item.s2,
                    10
                ) || 0;

            var s3 =
                parseInt(
                    item.s3,
                    10
                ) || 0;

            var s4 =
                parseInt(
                    item.s4,
                    10
                ) || 0;

            var s5 =
                parseInt(
                    item.s5,
                    10
                ) || 0;

            var valores = [
                s1,
                s2,
                s3,
                s4,
                s5
            ];

            var total =
                valores.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (total <= 0) {
                return {
                    category: item.category,
                    s1: s1,
                    s2: s2,
                    s3: s3,
                    s4: s4,
                    s5: s5,
                    percentage_s1: 0,
                    percentage_s2: 0,
                    percentage_s3: 0,
                    percentage_s4: 0,
                    percentage_s5: 0,
                    visual_s1: 0,
                    visual_s2: 0,
                    visual_s3: 0,
                    visual_s4: 0,
                    visual_s5: 0
                };
            }

            var porcentajesEnteros =
                obtenerPorcentajesEnteros(
                    valores
                );

            var porcentajesExactos =
                valores.map(function(valor)
                {
                    return (
                        valor /
                        total
                    ) * 100;
                });

            var minimoVisual = 8;

            var valoresVisuales =
                porcentajesExactos.map(
                    function(porcentaje, indice)
                    {
                        if (
                            valores[indice] <= 0
                        ) {
                            return 0;
                        }

                        return Math.max(
                            porcentaje,
                            minimoVisual
                        );
                    }
                );

            var totalVisual =
                valoresVisuales.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (totalVisual > 0) {
                valoresVisuales =
                    valoresVisuales.map(
                        function(valor)
                        {
                            return (
                                valor /
                                totalVisual
                            ) * 100;
                        }
                    );
            }

            return {
                category: item.category,
                s1: s1,
                s2: s2,
                s3: s3,
                s4: s4,
                s5: s5,
                percentage_s1:
                    porcentajesEnteros[0],
                percentage_s2:
                    porcentajesEnteros[1],
                percentage_s3:
                    porcentajesEnteros[2],
                percentage_s4:
                    porcentajesEnteros[3],
                percentage_s5:
                    porcentajesEnteros[4],
                visual_s1:
                    valoresVisuales[0],
                visual_s2:
                    valoresVisuales[1],
                visual_s3:
                    valoresVisuales[2],
                visual_s4:
                    valoresVisuales[3],
                visual_s5:
                    valoresVisuales[4]
            };
        });
    }

    var processedData =
        calcularDatos(data);

    function makeSeries(
        name,
        cantidadField,
        porcentajeField,
        visualField,
        color
    ) {
        var series =
            chart.series.push(
                am5xy.ColumnSeries.new(
                    root,
                    {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        stacked: true,
                        valueXField: visualField,
                        categoryYField: 'category',
                        stroke: color,
                        fill: color
                    }
                )
            );

        series.columns.template.setAll({
            height: am5.percent(70),
            tooltipY: 0,
            stroke: am5.color(0x000000),
            strokeWidth: 0.5,
            tooltipText:
                '{name}: {cantidad} trabajadores ({porcentaje}%)'
        });

        series.bullets.push(function(
            rootBullet,
            serie,
            dataItem
        ) {
            var contexto =
                dataItem.dataContext || {};

            var cantidad =
                parseInt(
                    contexto.cantidad,
                    10
                ) || 0;

            if (cantidad <= 0) {
                return undefined;
            }

            var porcentaje =
                parseInt(
                    contexto.porcentaje,
                    10
                ) || 0;

            var tamanioLetra = 17;

            if (porcentaje <= 3) {
                tamanioLetra = 13;
            } else if (porcentaje <= 5) {
                tamanioLetra = 14;
            } else if (porcentaje <= 10) {
                tamanioLetra = 15;
            }

            return am5.Bullet.new(
                root,
                {
                    locationX: 0.5,
                    locationY: 0.5,
                    sprite:
                        am5.Label.new(
                            root,
                            {
                                text:
                                    cantidad +
                                    ' (' +
                                    porcentaje +
                                    '%)',
                                centerX: am5.p50,
                                centerY: am5.p50,
                                populateText: false,
                                fontSize: tamanioLetra,
                                fill:
                                    am5.color(
                                        0x000000
                                    ),
                                fontWeight: 'bold',
                                textAlign: 'center',
                                paddingLeft: 1,
                                paddingRight: 1
                            }
                        )
                }
            );
        });

        var datosSerie =
            processedData.map(
                function(item)
                {
                    var fila = {
                        category:
                            item.category,
                        cantidad:
                            item[cantidadField],
                        porcentaje:
                            item[porcentajeField]
                    };

                    fila[visualField] =
                        item[visualField];

                    return fila;
                }
            );

        series.data.setAll(
            datosSerie
        );

        series.appear();

        legend.data.push(
            series
        );
    }

    makeSeries(
        'Muy alto',
        's1',
        'percentage_s1',
        'visual_s1',
        am5.color(0xFF0000)
    );

    makeSeries(
        'Alto',
        's2',
        'percentage_s2',
        'visual_s2',
        am5.color(0xF7AA32)
    );

    makeSeries(
        'Medio',
        's3',
        'percentage_s3',
        'visual_s3',
        am5.color(0xFFFF00)
    );

    makeSeries(
        'Bajo',
        's4',
        'percentage_s4',
        'visual_s4',
        am5.color(0x00B050)
    );

    makeSeries(
        'Nulo',
        's5',
        'percentage_s5',
        'visual_s5',
        am5.color(0x00B0F0)
    );

    chart
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                root,
                                                {}
                                            ),
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(imagen)
                        {
                            window.chartPngs =
                                window.chartPngs || {};

                            window.chartPngs[
                                nombreGrafica
                            ] = imagen;

                            console.log(
                                nombreGrafica +
                                ' exportado exitosamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar ' +
                                nombreGrafica +
                                ':',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

// ORGANIZACION DEL TIEMPO DE TRABAJO -> ACTUALIZADO 
function cargarGraficaOrganizacionGuiaIII()
{
    $.get(
        '/obtenerGraficaOrganizacionGuiaIII/' + proyecto.id,
        function(response)
        {
            crearGraficaOrganizacionGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.error(
            xhr.responseText
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la gráfica de organización del tiempo de trabajo'
        });
    });
}

function crearGraficaOrganizacionGuiaIII(data)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    var datosCategoria = [];
    var datosDominios = [];
    var encontroSeparador = false;

    data.forEach(function(item)
    {
        var category =
            item.category || '';

        if (
            category.indexOf('g3-') === 0
        ) {
            encontroSeparador = true;
            return;
        }

        if (encontroSeparador) {
            datosDominios.push(item);
        } else {
            datosCategoria.push(item);
        }
    });

    if (!encontroSeparador) {

        datosCategoria = [];
        datosDominios = [];

        data.forEach(function(item)
        {
            var category =
                item.category || '';

            var nombre =
                category
                    .replace(/^g[123]-/, '')
                    .trim()
                    .toLowerCase();

            if (
                nombre.indexOf(
                    'jornada de trabajo'
                ) !== -1 ||
                nombre.indexOf(
                    'interferencia en la relación trabajo-familia'
                ) !== -1 ||
                nombre.indexOf(
                    'interferencia en la relacion trabajo-familia'
                ) !== -1
            ) {
                datosDominios.push(item);
            } else {
                datosCategoria.push(item);
            }
        });
    }

    var datosDominio1 = [];
    var datosDominio2 = [];

    datosDominios.forEach(function(item)
    {
        var category =
            item.category || '';

        var nombre =
            category
                .replace(/^g[123]-/, '')
                .trim()
                .toLowerCase();

        if (
            nombre.indexOf(
                'jornada de trabajo'
            ) !== -1
        ) {
            datosDominio1.push(item);
        }

        if (
            nombre.indexOf(
                'interferencia en la relación trabajo-familia'
            ) !== -1 ||
            nombre.indexOf(
                'interferencia en la relacion trabajo-familia'
            ) !== -1
        ) {
            datosDominio2.push(item);
        }
    });

    if (
        datosDominio1.length === 0 &&
        datosDominios.length > 0
    ) {
        datosDominio1.push(
            datosDominios[0]
        );
    }

    if (
        datosDominio2.length === 0 &&
        datosDominios.length > 1
    ) {
        datosDominio2.push(
            datosDominios[1]
        );
    }

    crearGraficaOrganizacionIndividual(
        datosCategoria,
        'organizacionCategoriaChart',
        'organizacionCategoriaChartRoot',
        'organizacionCategoriaChart',
        'Organización del tiempo de trabajo'
    );

    crearGraficaOrganizacionIndividual(
        datosDominio1,
        'organizacionDominio1Chart',
        'organizacionDominio1ChartRoot',
        'organizacionDominio1Chart',
        'Jornada de trabajo'
    );

    crearGraficaOrganizacionIndividual(
        datosDominio2,
        'organizacionDominio2Chart',
        'organizacionDominio2ChartRoot',
        'organizacionDominio2Chart',
        'Interferencia en la relación trabajo-familia'
    );
}

function crearGraficaOrganizacionIndividual(data,contenedorId,rootNombre,nombreGrafica,titulo)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    if (
        window[rootNombre] &&
        !window[rootNombre].isDisposed()
    ) {
        window[rootNombre].dispose();
        window[rootNombre] = null;
    }

    var contenedor =
        document.getElementById(
            contenedorId
        );

    if (!contenedor) {

        console.error(
            'No existe el contenedor #' +
            contenedorId
        );

        return;
    }

    contenedor.innerHTML = '';

    if (data.length === 0) {

        contenedor.innerHTML = `
            <div style="
                width:100%;
                height:320px;
                display:flex;
                justify-content:center;
                align-items:center;
                text-align:center;
                font-weight:bold;
                color:#777;
            ">
                No hay información disponible
            </div>
        `;

        window.chartPngs =
            window.chartPngs || {};

        window.chartPngs[
            nombreGrafica
        ] = null;

        return;
    }

    window[rootNombre] =
        am5.Root.new(
            contenedorId
        );

    var root =
        window[rootNombre];

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart =
        root.container.children.push(
            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    layout: root.verticalLayout,
                    paddingTop: 0,
                    paddingBottom: 0,
                    paddingLeft: 0,
                    paddingRight: 20
                }
            )
        );

    chart.children.unshift(
        am5.Label.new(
            root,
            {
                text: titulo,
                fontSize: 18,
                fontWeight: 'bold',
                textAlign: 'center',
                x: am5.p50,
                centerX: am5.p50,
                marginTop: 5,
                marginBottom: 15,
                paddingTop: 0,
                paddingBottom: 0
            }
        )
    );

    var legend =
        chart.children.push(
            am5.Legend.new(
                root,
                {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 5,
                    marginBottom: 0,
                    paddingTop: 0,
                    paddingBottom: 0
                }
            )
        );

    legend.labels.template.setAll({
        fontSize: 20,
        fontWeight: 'bold'
    });

    legend.valueLabels.template.setAll({
        forceHidden: true,
        visible: false
    });

    legend.markers.template.setAll({
        width: 20,
        height: 20
    });

    var yAxisRenderer =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                cellStartLocation: 0.15,
                cellEndLocation: 0.85,
                minGridDistance: 0
            }
        );

    var yAxis =
        chart.yAxes.push(
            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField: 'category',
                    renderer: yAxisRenderer,
                    tooltip:
                        am5.Tooltip.new(
                            root,
                            {}
                        )
                }
            )
        );

    yAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    yAxis.data.setAll(
        data
    );

    var xAxisRenderer =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 50
            }
        );

    var xAxis =
        chart.xAxes.push(
            am5xy.ValueAxis.new(
                root,
                {
                    renderer: xAxisRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    maxDeviation: 0
                }
            )
        );

    xAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    xAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    xAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    if (xAxisRenderer.baseGrid) {

        xAxisRenderer.baseGrid.setAll({
            forceHidden: true,
            visible: false,
            strokeOpacity: 0
        });
    }

    function obtenerPorcentajesEnteros(valores)
    {
        var total =
            valores.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        if (total <= 0) {

            return [
                0,
                0,
                0,
                0,
                0
            ];
        }

        var porcentajesExactos =
            valores.map(function(valor)
            {
                return (
                    valor /
                    total
                ) * 100;
            });

        var porcentajesEnteros =
            porcentajesExactos.map(function(valor)
            {
                return Math.floor(valor);
            });

        var sumaEnteros =
            porcentajesEnteros.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        var faltantes =
            100 - sumaEnteros;

        var residuos =
            porcentajesExactos.map(
                function(valor, indice)
                {
                    return {
                        indice: indice,
                        residuo:
                            valor -
                            porcentajesEnteros[
                                indice
                            ]
                    };
                }
            );

        residuos.sort(function(a, b)
        {
            return b.residuo - a.residuo;
        });

        for (
            var indice = 0;
            indice < faltantes;
            indice++
        ) {
            porcentajesEnteros[
                residuos[indice].indice
            ]++;
        }

        return porcentajesEnteros;
    }

    function calcularDatos(datos)
    {
        return datos.map(function(item)
        {
            var category =
                item.category || '';

            var s1 =
                parseInt(
                    item.s1,
                    10
                ) || 0;

            var s2 =
                parseInt(
                    item.s2,
                    10
                ) || 0;

            var s3 =
                parseInt(
                    item.s3,
                    10
                ) || 0;

            var s4 =
                parseInt(
                    item.s4,
                    10
                ) || 0;

            var s5 =
                parseInt(
                    item.s5,
                    10
                ) || 0;

            var valores = [
                s1,
                s2,
                s3,
                s4,
                s5
            ];

            var total =
                valores.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (total <= 0) {

                return {
                    category: category,
                    s1: s1,
                    s2: s2,
                    s3: s3,
                    s4: s4,
                    s5: s5,
                    percentage_s1: 0,
                    percentage_s2: 0,
                    percentage_s3: 0,
                    percentage_s4: 0,
                    percentage_s5: 0,
                    visual_s1: 0,
                    visual_s2: 0,
                    visual_s3: 0,
                    visual_s4: 0,
                    visual_s5: 0
                };
            }

            var porcentajesEnteros =
                obtenerPorcentajesEnteros(
                    valores
                );

            var porcentajesExactos =
                valores.map(function(valor)
                {
                    return (
                        valor /
                        total
                    ) * 100;
                });

            var minimoVisual = 8;

            var valoresVisuales =
                porcentajesExactos.map(
                    function(porcentaje, indice)
                    {
                        if (
                            valores[indice] <= 0
                        ) {
                            return 0;
                        }

                        return Math.max(
                            porcentaje,
                            minimoVisual
                        );
                    }
                );

            var totalVisual =
                valoresVisuales.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (totalVisual > 0) {

                valoresVisuales =
                    valoresVisuales.map(
                        function(valor)
                        {
                            return (
                                valor /
                                totalVisual
                            ) * 100;
                        }
                    );
            }

            return {
                category: category,
                s1: s1,
                s2: s2,
                s3: s3,
                s4: s4,
                s5: s5,
                percentage_s1:
                    porcentajesEnteros[0],
                percentage_s2:
                    porcentajesEnteros[1],
                percentage_s3:
                    porcentajesEnteros[2],
                percentage_s4:
                    porcentajesEnteros[3],
                percentage_s5:
                    porcentajesEnteros[4],
                visual_s1:
                    valoresVisuales[0],
                visual_s2:
                    valoresVisuales[1],
                visual_s3:
                    valoresVisuales[2],
                visual_s4:
                    valoresVisuales[3],
                visual_s5:
                    valoresVisuales[4]
            };
        });
    }

    var processedData =
        calcularDatos(
            data
        );

    function makeSeries(
        name,
        cantidadField,
        porcentajeField,
        visualField,
        color
    ) {
        var series =
            chart.series.push(
                am5xy.ColumnSeries.new(
                    root,
                    {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        stacked: true,
                        valueXField:
                            visualField,
                        categoryYField:
                            'category',
                        stroke: color,
                        fill: color
                    }
                )
            );

        series.columns.template.setAll({
            height: am5.percent(70),
            tooltipY: 0,
            stroke:
                am5.color(
                    0x000000
                ),
            strokeWidth: 0.5,
            tooltipText:
                '{name}: {cantidad} trabajadores ({porcentaje}%)'
        });

        series.bullets.push(function(
            rootBullet,
            serie,
            dataItem
        ) {
            var contexto =
                dataItem.dataContext || {};

            var cantidad =
                parseInt(
                    contexto.cantidad,
                    10
                ) || 0;

            if (cantidad <= 0) {
                return undefined;
            }

            var porcentaje =
                parseInt(
                    contexto.porcentaje,
                    10
                ) || 0;

            var tamanioLetra = 17;

            if (porcentaje <= 3) {
                tamanioLetra = 13;
            } else if (porcentaje <= 5) {
                tamanioLetra = 14;
            } else if (porcentaje <= 10) {
                tamanioLetra = 15;
            }

            return am5.Bullet.new(
                root,
                {
                    locationX: 0.5,
                    locationY: 0.5,
                    sprite:
                        am5.Label.new(
                            root,
                            {
                                text:
                                    cantidad +
                                    ' (' +
                                    porcentaje +
                                    '%)',
                                centerX: am5.p50,
                                centerY: am5.p50,
                                populateText: false,
                                fontSize:
                                    tamanioLetra,
                                fill:
                                    am5.color(
                                        0x000000
                                    ),
                                fontWeight:
                                    'bold',
                                textAlign:
                                    'center',
                                paddingLeft: 1,
                                paddingRight: 1
                            }
                        )
                }
            );
        });

        var datosSerie =
            processedData.map(
                function(item)
                {
                    var fila = {
                        category:
                            item.category,
                        cantidad:
                            item[cantidadField],
                        porcentaje:
                            item[porcentajeField]
                    };

                    fila[visualField] =
                        item[visualField];

                    return fila;
                }
            );

        series.data.setAll(
            datosSerie
        );

        series.appear();

        legend.data.push(
            series
        );
    }

    makeSeries(
        'Muy alto',
        's1',
        'percentage_s1',
        'visual_s1',
        am5.color(0xFF0000)
    );

    makeSeries(
        'Alto',
        's2',
        'percentage_s2',
        'visual_s2',
        am5.color(0xF7AA32)
    );

    makeSeries(
        'Medio',
        's3',
        'percentage_s3',
        'visual_s3',
        am5.color(0xFFFF00)
    );

    makeSeries(
        'Bajo',
        's4',
        'percentage_s4',
        'visual_s4',
        am5.color(0x00B050)
    );

    makeSeries(
        'Nulo',
        's5',
        'percentage_s5',
        'visual_s5',
        am5.color(0x00B0F0)
    );

    chart
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                root,
                                                {}
                                            ),
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(imagen)
                        {
                            window.chartPngs =
                                window.chartPngs || {};

                            window.chartPngs[
                                nombreGrafica
                            ] = imagen;

                            console.log(
                                nombreGrafica +
                                ' exportado exitosamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar ' +
                                nombreGrafica +
                                ':',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

// CATEGORIA LIDERAZGO Y RELACIONES EN EL TRABAJO  -> ACTUALIZADO
function cargarGraficaLiderazgoGuiaIII() 
{
    $.get(
        '/obtenerGraficaLiderazgoGuiaIII/' + proyecto.id,
        function(response)
        {
            crearGraficaLiderazgoGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.error(
            xhr.responseText
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la gráfica de liderazgo y relaciones en el trabajo'
        });
    });
}

function crearGraficaLiderazgoGuiaIII(data)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    var datosCategoria = [];
    var datosDominios = [];
    var encontroSeparador = false;

    data.forEach(function(item)
    {
        var category =
            item.category || '';

        if (
            category.indexOf('g3-') === 0
        ) {
            encontroSeparador = true;
            return;
        }

        if (encontroSeparador) {
            datosDominios.push(item);
        } else {
            datosCategoria.push(item);
        }
    });

    if (!encontroSeparador) {

        datosCategoria = [];
        datosDominios = [];

        data.forEach(function(item)
        {
            var category =
                item.category || '';

            var nombre =
                category
                    .replace(/^g[123]-/, '')
                    .trim()
                    .toLowerCase();

            if (
                nombre === 'liderazgo' ||
                nombre.indexOf(
                    'relaciones en el trabajo'
                ) !== -1 ||
                nombre.indexOf(
                    'violencia'
                ) !== -1
            ) {
                datosDominios.push(item);
            } else {
                datosCategoria.push(item);
            }
        });
    }

    var datosDominio1 = [];
    var datosDominio2 = [];
    var datosDominio3 = [];

    datosDominios.forEach(function(item)
    {
        var category =
            item.category || '';

        var nombre =
            category
                .replace(/^g[123]-/, '')
                .trim()
                .toLowerCase();

        if (
            nombre === 'liderazgo' ||
            nombre.indexOf('liderazgo') !== -1
        ) {
            datosDominio1.push(item);
        }

        if (
            nombre.indexOf(
                'relaciones en el trabajo'
            ) !== -1
        ) {
            datosDominio2.push(item);
        }

        if (
            nombre.indexOf(
                'violencia'
            ) !== -1
        ) {
            datosDominio3.push(item);
        }
    });

    if (
        datosDominio1.length === 0 &&
        datosDominios.length > 0
    ) {
        datosDominio1.push(
            datosDominios[0]
        );
    }

    if (
        datosDominio2.length === 0 &&
        datosDominios.length > 1
    ) {
        datosDominio2.push(
            datosDominios[1]
        );
    }

    if (
        datosDominio3.length === 0 &&
        datosDominios.length > 2
    ) {
        datosDominio3.push(
            datosDominios[2]
        );
    }

    crearGraficaLiderazgoIndividual(
        datosCategoria,
        'liderazgoCategoriaChart',
        'liderazgoCategoriaChartRoot',
        'liderazgoCategoriaChart',
        'Liderazgo y relaciones en el trabajo'
    );

    crearGraficaLiderazgoIndividual(
        datosDominio1,
        'liderazgoDominio1Chart',
        'liderazgoDominio1ChartRoot',
        'liderazgoDominio1Chart',
        'Liderazgo'
    );

    crearGraficaLiderazgoIndividual(
        datosDominio2,
        'liderazgoDominio2Chart',
        'liderazgoDominio2ChartRoot',
        'liderazgoDominio2Chart',
        'Relaciones en el trabajo'
    );

    crearGraficaLiderazgoIndividual(
        datosDominio3,
        'liderazgoDominio3Chart',
        'liderazgoDominio3ChartRoot',
        'liderazgoDominio3Chart',
        'Violencia'
    );
}

function crearGraficaLiderazgoIndividual(data,contenedorId,rootNombre,nombreGrafica,titulo)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    if (
        window[rootNombre] &&
        !window[rootNombre].isDisposed()
    ) {
        window[rootNombre].dispose();
        window[rootNombre] = null;
    }

    var contenedor =
        document.getElementById(
            contenedorId
        );

    if (!contenedor) {

        console.error(
            'No existe el contenedor #' +
            contenedorId
        );

        return;
    }

    contenedor.innerHTML = '';

    if (data.length === 0) {

        contenedor.innerHTML = `
            <div style="
                width:100%;
                height:320px;
                display:flex;
                justify-content:center;
                align-items:center;
                text-align:center;
                font-weight:bold;
                color:#777;
            ">
                No hay información disponible
            </div>
        `;

        window.chartPngs =
            window.chartPngs || {};

        window.chartPngs[
            nombreGrafica
        ] = null;

        return;
    }

    window[rootNombre] =
        am5.Root.new(
            contenedorId
        );

    var root =
        window[rootNombre];

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart =
        root.container.children.push(
            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    layout: root.verticalLayout,
                    paddingTop: 0,
                    paddingBottom: 0,
                    paddingLeft: 0,
                    paddingRight: 20
                }
            )
        );

    chart.children.unshift(
        am5.Label.new(
            root,
            {
                text: titulo,
                fontSize: 18,
                fontWeight: 'bold',
                textAlign: 'center',
                x: am5.p50,
                centerX: am5.p50,
                marginTop: 5,
                marginBottom: 15,
                paddingTop: 0,
                paddingBottom: 0
            }
        )
    );

    var legend =
        chart.children.push(
            am5.Legend.new(
                root,
                {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 5,
                    marginBottom: 0,
                    paddingTop: 0,
                    paddingBottom: 0
                }
            )
        );

    legend.labels.template.setAll({
        fontSize: 20,
        fontWeight: 'bold'
    });

    legend.valueLabels.template.setAll({
        forceHidden: true,
        visible: false
    });

    legend.markers.template.setAll({
        width: 20,
        height: 20
    });

    var yAxisRenderer =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                cellStartLocation: 0.15,
                cellEndLocation: 0.85,
                minGridDistance: 0
            }
        );

    var yAxis =
        chart.yAxes.push(
            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField: 'category',
                    renderer: yAxisRenderer,
                    tooltip:
                        am5.Tooltip.new(
                            root,
                            {}
                        )
                }
            )
        );

    yAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    yAxis.data.setAll(
        data
    );

    var xAxisRenderer =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 50
            }
        );

    var xAxis =
        chart.xAxes.push(
            am5xy.ValueAxis.new(
                root,
                {
                    renderer: xAxisRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    maxDeviation: 0
                }
            )
        );

    xAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    xAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    xAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    if (xAxisRenderer.baseGrid) {

        xAxisRenderer.baseGrid.setAll({
            forceHidden: true,
            visible: false,
            strokeOpacity: 0
        });
    }

    function obtenerPorcentajesEnteros(valores)
    {
        var total =
            valores.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        if (total <= 0) {

            return [
                0,
                0,
                0,
                0,
                0
            ];
        }

        var porcentajesExactos =
            valores.map(function(valor)
            {
                return (
                    valor /
                    total
                ) * 100;
            });

        var porcentajesEnteros =
            porcentajesExactos.map(function(valor)
            {
                return Math.floor(valor);
            });

        var sumaEnteros =
            porcentajesEnteros.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        var faltantes =
            100 - sumaEnteros;

        var residuos =
            porcentajesExactos.map(
                function(valor, indice)
                {
                    return {
                        indice: indice,
                        residuo:
                            valor -
                            porcentajesEnteros[
                                indice
                            ]
                    };
                }
            );

        residuos.sort(function(a, b)
        {
            return b.residuo - a.residuo;
        });

        for (
            var indice = 0;
            indice < faltantes;
            indice++
        ) {
            porcentajesEnteros[
                residuos[indice].indice
            ]++;
        }

        return porcentajesEnteros;
    }

    function calcularDatos(datos)
    {
        return datos.map(function(item)
        {
            var category =
                item.category || '';

            var s1 =
                parseInt(
                    item.s1,
                    10
                ) || 0;

            var s2 =
                parseInt(
                    item.s2,
                    10
                ) || 0;

            var s3 =
                parseInt(
                    item.s3,
                    10
                ) || 0;

            var s4 =
                parseInt(
                    item.s4,
                    10
                ) || 0;

            var s5 =
                parseInt(
                    item.s5,
                    10
                ) || 0;

            var valores = [
                s1,
                s2,
                s3,
                s4,
                s5
            ];

            var total =
                valores.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (total <= 0) {

                return {
                    category: category,
                    s1: s1,
                    s2: s2,
                    s3: s3,
                    s4: s4,
                    s5: s5,
                    percentage_s1: 0,
                    percentage_s2: 0,
                    percentage_s3: 0,
                    percentage_s4: 0,
                    percentage_s5: 0,
                    visual_s1: 0,
                    visual_s2: 0,
                    visual_s3: 0,
                    visual_s4: 0,
                    visual_s5: 0
                };
            }

            var porcentajesEnteros =
                obtenerPorcentajesEnteros(
                    valores
                );

            var porcentajesExactos =
                valores.map(function(valor)
                {
                    return (
                        valor /
                        total
                    ) * 100;
                });

            var minimoVisual = 8;

            var valoresVisuales =
                porcentajesExactos.map(
                    function(porcentaje, indice)
                    {
                        if (
                            valores[indice] <= 0
                        ) {
                            return 0;
                        }

                        return Math.max(
                            porcentaje,
                            minimoVisual
                        );
                    }
                );

            var totalVisual =
                valoresVisuales.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (totalVisual > 0) {

                valoresVisuales =
                    valoresVisuales.map(
                        function(valor)
                        {
                            return (
                                valor /
                                totalVisual
                            ) * 100;
                        }
                    );
            }

            return {
                category: category,
                s1: s1,
                s2: s2,
                s3: s3,
                s4: s4,
                s5: s5,
                percentage_s1:
                    porcentajesEnteros[0],
                percentage_s2:
                    porcentajesEnteros[1],
                percentage_s3:
                    porcentajesEnteros[2],
                percentage_s4:
                    porcentajesEnteros[3],
                percentage_s5:
                    porcentajesEnteros[4],
                visual_s1:
                    valoresVisuales[0],
                visual_s2:
                    valoresVisuales[1],
                visual_s3:
                    valoresVisuales[2],
                visual_s4:
                    valoresVisuales[3],
                visual_s5:
                    valoresVisuales[4]
            };
        });
    }

    var processedData =
        calcularDatos(
            data
        );

    function makeSeries(
        name,
        cantidadField,
        porcentajeField,
        visualField,
        color
    ) {
        var series =
            chart.series.push(
                am5xy.ColumnSeries.new(
                    root,
                    {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        stacked: true,
                        valueXField:
                            visualField,
                        categoryYField:
                            'category',
                        stroke: color,
                        fill: color
                    }
                )
            );

        series.columns.template.setAll({
            height: am5.percent(70),
            tooltipY: 0,
            stroke:
                am5.color(
                    0x000000
                ),
            strokeWidth: 0.5,
            tooltipText:
                '{name}: {cantidad} trabajadores ({porcentaje}%)'
        });

        series.bullets.push(function(
            rootBullet,
            serie,
            dataItem
        ) {
            var contexto =
                dataItem.dataContext || {};

            var cantidad =
                parseInt(
                    contexto.cantidad,
                    10
                ) || 0;

            if (cantidad <= 0) {
                return undefined;
            }

            var porcentaje =
                parseInt(
                    contexto.porcentaje,
                    10
                ) || 0;

            var tamanioLetra = 17;

            if (porcentaje <= 3) {
                tamanioLetra = 13;
            } else if (porcentaje <= 5) {
                tamanioLetra = 14;
            } else if (porcentaje <= 10) {
                tamanioLetra = 15;
            }

            return am5.Bullet.new(
                root,
                {
                    locationX: 0.5,
                    locationY: 0.5,
                    sprite:
                        am5.Label.new(
                            root,
                            {
                                text:
                                    cantidad +
                                    ' (' +
                                    porcentaje +
                                    '%)',
                                centerX: am5.p50,
                                centerY: am5.p50,
                                populateText: false,
                                fontSize:
                                    tamanioLetra,
                                fill:
                                    am5.color(
                                        0x000000
                                    ),
                                fontWeight:
                                    'bold',
                                textAlign:
                                    'center',
                                paddingLeft: 1,
                                paddingRight: 1
                            }
                        )
                }
            );
        });

        var datosSerie =
            processedData.map(
                function(item)
                {
                    var fila = {
                        category:
                            item.category,
                        cantidad:
                            item[cantidadField],
                        porcentaje:
                            item[porcentajeField]
                    };

                    fila[visualField] =
                        item[visualField];

                    return fila;
                }
            );

        series.data.setAll(
            datosSerie
        );

        series.appear();

        legend.data.push(
            series
        );
    }

    makeSeries(
        'Muy alto',
        's1',
        'percentage_s1',
        'visual_s1',
        am5.color(0xFF0000)
    );

    makeSeries(
        'Alto',
        's2',
        'percentage_s2',
        'visual_s2',
        am5.color(0xF7AA32)
    );

    makeSeries(
        'Medio',
        's3',
        'percentage_s3',
        'visual_s3',
        am5.color(0xFFFF00)
    );

    makeSeries(
        'Bajo',
        's4',
        'percentage_s4',
        'visual_s4',
        am5.color(0x00B050)
    );

    makeSeries(
        'Nulo',
        's5',
        'percentage_s5',
        'visual_s5',
        am5.color(0x00B0F0)
    );

    chart
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                root,
                                                {}
                                            ),
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(imagen)
                        {
                            window.chartPngs =
                                window.chartPngs || {};

                            window.chartPngs[
                                nombreGrafica
                            ] = imagen;

                            console.log(
                                nombreGrafica +
                                ' exportado exitosamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar ' +
                                nombreGrafica +
                                ':',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

// CATEGORIA ENTORNO ORGANIZACIONAL 

function cargarGraficaEntornoGuiaIII()
{
    $.get(
        '/obtenerGraficaEntornoGuiaIII/' + proyecto.id,
        function(response)
        {
            crearGraficaEntornoGuiaIII(
                response.data
            );
        }
    )
    .fail(function(xhr)
    {
        console.error(
            xhr.responseText
        );

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la gráfica de entorno organizacional'
        });
    });
}


function crearGraficaEntornoGuiaIII(data)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    var datosCategoria = [];
    var datosDominios = [];
    var encontroSeparador = false;

    data.forEach(function(item)
    {
        var category =
            item.category || '';

        if (
            category.indexOf('g3-') === 0
        ) {
            encontroSeparador = true;
            return;
        }

        if (encontroSeparador) {
            datosDominios.push(item);
        } else {
            datosCategoria.push(item);
        }
    });

    if (!encontroSeparador) {

        datosCategoria = [];
        datosDominios = [];

        data.forEach(function(item)
        {
            var category =
                item.category || '';

            var nombre =
                category
                    .replace(/^g[123]-/, '')
                    .trim()
                    .toLowerCase();

            if (
                nombre.indexOf(
                    'reconocimiento del desempeño'
                ) !== -1 ||
                nombre.indexOf(
                    'reconocimiento del desempeno'
                ) !== -1 ||
                nombre.indexOf(
                    'insuficiente sentido de pertenencia'
                ) !== -1 ||
                nombre.indexOf(
                    'inestabilidad'
                ) !== -1
            ) {
                datosDominios.push(item);
            } else {
                datosCategoria.push(item);
            }
        });
    }

    var datosDominio1 = [];
    var datosDominio2 = [];

    datosDominios.forEach(function(item)
    {
        var category =
            item.category || '';

        var nombre =
            category
                .replace(/^g[123]-/, '')
                .trim()
                .toLowerCase();

        if (
            nombre.indexOf(
                'reconocimiento del desempeño'
            ) !== -1 ||
            nombre.indexOf(
                'reconocimiento del desempeno'
            ) !== -1
        ) {
            datosDominio1.push(item);
        }

        if (
            nombre.indexOf(
                'insuficiente sentido de pertenencia'
            ) !== -1 ||
            nombre.indexOf(
                'inestabilidad'
            ) !== -1
        ) {
            datosDominio2.push(item);
        }
    });

    if (
        datosDominio1.length === 0 &&
        datosDominios.length > 0
    ) {
        datosDominio1.push(
            datosDominios[0]
        );
    }

    if (
        datosDominio2.length === 0 &&
        datosDominios.length > 1
    ) {
        datosDominio2.push(
            datosDominios[1]
        );
    }

    crearGraficaEntornoIndividual(
        datosCategoria,
        'entornoCategoriaChart',
        'entornoCategoriaChartRoot',
        'entornoCategoriaChart',
        'Entorno organizacional'
    );

    crearGraficaEntornoIndividual(
        datosDominio1,
        'entornoDominio1Chart',
        'entornoDominio1ChartRoot',
        'entornoDominio1Chart',
        'Reconocimiento del desempeño'
    );

    crearGraficaEntornoIndividual(
        datosDominio2,
        'entornoDominio2Chart',
        'entornoDominio2ChartRoot',
        'entornoDominio2Chart',
        'Insuficiente sentido de pertenencia e inestabilidad'
    );
}

function crearGraficaEntornoIndividual(data,contenedorId,rootNombre,nombreGrafica,titulo)
{
    if (!Array.isArray(data)) {
        data = [];
    }

    if (
        window[rootNombre] &&
        !window[rootNombre].isDisposed()
    ) {
        window[rootNombre].dispose();
        window[rootNombre] = null;
    }

    var contenedor =
        document.getElementById(
            contenedorId
        );

    if (!contenedor) {

        console.error(
            'No existe el contenedor #' +
            contenedorId
        );

        return;
    }

    contenedor.innerHTML = '';

    if (data.length === 0) {

        contenedor.innerHTML = `
            <div style="
                width:100%;
                height:320px;
                display:flex;
                justify-content:center;
                align-items:center;
                text-align:center;
                font-weight:bold;
                color:#777;
            ">
                No hay información disponible
            </div>
        `;

        window.chartPngs =
            window.chartPngs || {};

        window.chartPngs[
            nombreGrafica
        ] = null;

        return;
    }

    window[rootNombre] =
        am5.Root.new(
            contenedorId
        );

    var root =
        window[rootNombre];

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    var chart =
        root.container.children.push(
            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    layout: root.verticalLayout,
                    paddingTop: 0,
                    paddingBottom: 0,
                    paddingLeft: 0,
                    paddingRight: 20
                }
            )
        );

    chart.children.unshift(
        am5.Label.new(
            root,
            {
                text: titulo,
                fontSize: 18,
                fontWeight: 'bold',
                textAlign: 'center',
                x: am5.p50,
                centerX: am5.p50,
                marginTop: 5,
                marginBottom: 15,
                paddingTop: 0,
                paddingBottom: 0
            }
        )
    );

    var legend =
        chart.children.push(
            am5.Legend.new(
                root,
                {
                    centerX: am5.p50,
                    x: am5.p50,
                    marginTop: 5,
                    marginBottom: 0,
                    paddingTop: 0,
                    paddingBottom: 0
                }
            )
        );

    legend.labels.template.setAll({
        fontSize: 20,
        fontWeight: 'bold'
    });

    legend.valueLabels.template.setAll({
        forceHidden: true,
        visible: false
    });

    legend.markers.template.setAll({
        width: 20,
        height: 20
    });

    var yAxisRenderer =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                cellStartLocation: 0.15,
                cellEndLocation: 0.85,
                minGridDistance: 0
            }
        );

    var yAxis =
        chart.yAxes.push(
            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField: 'category',
                    renderer: yAxisRenderer,
                    tooltip:
                        am5.Tooltip.new(
                            root,
                            {}
                        )
                }
            )
        );

    yAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    yAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    yAxis.data.setAll(
        data
    );

    var xAxisRenderer =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 50
            }
        );

    var xAxis =
        chart.xAxes.push(
            am5xy.ValueAxis.new(
                root,
                {
                    renderer: xAxisRenderer,
                    min: 0,
                    max: 100,
                    strictMinMax: true,
                    maxDeviation: 0
                }
            )
        );

    xAxisRenderer.grid.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    xAxisRenderer.labels.template.setAll({
        forceHidden: true,
        visible: false
    });

    xAxisRenderer.ticks.template.setAll({
        forceHidden: true,
        visible: false,
        strokeOpacity: 0
    });

    if (xAxisRenderer.baseGrid) {

        xAxisRenderer.baseGrid.setAll({
            forceHidden: true,
            visible: false,
            strokeOpacity: 0
        });
    }

    function obtenerPorcentajesEnteros(valores)
    {
        var total =
            valores.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        if (total <= 0) {

            return [
                0,
                0,
                0,
                0,
                0
            ];
        }

        var porcentajesExactos =
            valores.map(function(valor)
            {
                return (
                    valor /
                    total
                ) * 100;
            });

        var porcentajesEnteros =
            porcentajesExactos.map(function(valor)
            {
                return Math.floor(valor);
            });

        var sumaEnteros =
            porcentajesEnteros.reduce(
                function(acumulado, valor)
                {
                    return acumulado + valor;
                },
                0
            );

        var faltantes =
            100 - sumaEnteros;

        var residuos =
            porcentajesExactos.map(
                function(valor, indice)
                {
                    return {
                        indice: indice,
                        residuo:
                            valor -
                            porcentajesEnteros[
                                indice
                            ]
                    };
                }
            );

        residuos.sort(function(a, b)
        {
            return b.residuo - a.residuo;
        });

        for (
            var indice = 0;
            indice < faltantes;
            indice++
        ) {
            porcentajesEnteros[
                residuos[indice].indice
            ]++;
        }

        return porcentajesEnteros;
    }

    function calcularDatos(datos)
    {
        return datos.map(function(item)
        {
            var category =
                item.category || '';

            var s1 =
                parseInt(
                    item.s1,
                    10
                ) || 0;

            var s2 =
                parseInt(
                    item.s2,
                    10
                ) || 0;

            var s3 =
                parseInt(
                    item.s3,
                    10
                ) || 0;

            var s4 =
                parseInt(
                    item.s4,
                    10
                ) || 0;

            var s5 =
                parseInt(
                    item.s5,
                    10
                ) || 0;

            var valores = [
                s1,
                s2,
                s3,
                s4,
                s5
            ];

            var total =
                valores.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (total <= 0) {

                return {
                    category: category,
                    s1: s1,
                    s2: s2,
                    s3: s3,
                    s4: s4,
                    s5: s5,
                    percentage_s1: 0,
                    percentage_s2: 0,
                    percentage_s3: 0,
                    percentage_s4: 0,
                    percentage_s5: 0,
                    visual_s1: 0,
                    visual_s2: 0,
                    visual_s3: 0,
                    visual_s4: 0,
                    visual_s5: 0
                };
            }

            var porcentajesEnteros =
                obtenerPorcentajesEnteros(
                    valores
                );

            var porcentajesExactos =
                valores.map(function(valor)
                {
                    return (
                        valor /
                        total
                    ) * 100;
                });

            var minimoVisual = 8;

            var valoresVisuales =
                porcentajesExactos.map(
                    function(porcentaje, indice)
                    {
                        if (
                            valores[indice] <= 0
                        ) {
                            return 0;
                        }

                        return Math.max(
                            porcentaje,
                            minimoVisual
                        );
                    }
                );

            var totalVisual =
                valoresVisuales.reduce(
                    function(acumulado, valor)
                    {
                        return acumulado + valor;
                    },
                    0
                );

            if (totalVisual > 0) {

                valoresVisuales =
                    valoresVisuales.map(
                        function(valor)
                        {
                            return (
                                valor /
                                totalVisual
                            ) * 100;
                        }
                    );
            }

            return {
                category: category,
                s1: s1,
                s2: s2,
                s3: s3,
                s4: s4,
                s5: s5,
                percentage_s1:
                    porcentajesEnteros[0],
                percentage_s2:
                    porcentajesEnteros[1],
                percentage_s3:
                    porcentajesEnteros[2],
                percentage_s4:
                    porcentajesEnteros[3],
                percentage_s5:
                    porcentajesEnteros[4],
                visual_s1:
                    valoresVisuales[0],
                visual_s2:
                    valoresVisuales[1],
                visual_s3:
                    valoresVisuales[2],
                visual_s4:
                    valoresVisuales[3],
                visual_s5:
                    valoresVisuales[4]
            };
        });
    }

    var processedData =
        calcularDatos(
            data
        );

    function makeSeries(
        name,
        cantidadField,
        porcentajeField,
        visualField,
        color
    ) {
        var series =
            chart.series.push(
                am5xy.ColumnSeries.new(
                    root,
                    {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        stacked: true,
                        valueXField:
                            visualField,
                        categoryYField:
                            'category',
                        stroke: color,
                        fill: color
                    }
                )
            );

        series.columns.template.setAll({
            height: am5.percent(70),
            tooltipY: 0,
            stroke:
                am5.color(
                    0x000000
                ),
            strokeWidth: 0.5,
            tooltipText:
                '{name}: {cantidad} trabajadores ({porcentaje}%)'
        });

        series.bullets.push(function(
            rootBullet,
            serie,
            dataItem
        ) {
            var contexto =
                dataItem.dataContext || {};

            var cantidad =
                parseInt(
                    contexto.cantidad,
                    10
                ) || 0;

            if (cantidad <= 0) {
                return undefined;
            }

            var porcentaje =
                parseInt(
                    contexto.porcentaje,
                    10
                ) || 0;

            var tamanioLetra = 17;

            if (porcentaje <= 3) {
                tamanioLetra = 13;
            } else if (porcentaje <= 5) {
                tamanioLetra = 14;
            } else if (porcentaje <= 10) {
                tamanioLetra = 15;
            }

            return am5.Bullet.new(
                root,
                {
                    locationX: 0.5,
                    locationY: 0.5,
                    sprite:
                        am5.Label.new(
                            root,
                            {
                                text:
                                    cantidad +
                                    ' (' +
                                    porcentaje +
                                    '%)',
                                centerX: am5.p50,
                                centerY: am5.p50,
                                populateText: false,
                                fontSize:
                                    tamanioLetra,
                                fill:
                                    am5.color(
                                        0x000000
                                    ),
                                fontWeight:
                                    'bold',
                                textAlign:
                                    'center',
                                paddingLeft: 1,
                                paddingRight: 1
                            }
                        )
                }
            );
        });

        var datosSerie =
            processedData.map(
                function(item)
                {
                    var fila = {
                        category:
                            item.category,
                        cantidad:
                            item[cantidadField],
                        porcentaje:
                            item[porcentajeField]
                    };

                    fila[visualField] =
                        item[visualField];

                    return fila;
                }
            );

        series.data.setAll(
            datosSerie
        );

        series.appear();

        legend.data.push(
            series
        );
    }

    makeSeries(
        'Muy alto',
        's1',
        'percentage_s1',
        'visual_s1',
        am5.color(0xFF0000)
    );

    makeSeries(
        'Alto',
        's2',
        'percentage_s2',
        'visual_s2',
        am5.color(0xF7AA32)
    );

    makeSeries(
        'Medio',
        's3',
        'percentage_s3',
        'visual_s3',
        am5.color(0xFFFF00)
    );

    makeSeries(
        'Bajo',
        's4',
        'percentage_s4',
        'visual_s4',
        am5.color(0x00B050)
    );

    makeSeries(
        'Nulo',
        's5',
        'percentage_s5',
        'visual_s5',
        am5.color(0x00B0F0)
    );

    chart
        .appear(
            1000,
            100
        )
        .then(function()
        {
            setTimeout(function()
            {
                if (
                    typeof am5plugins_exporting !==
                    'undefined'
                ) {
                    var exporting =
                        am5plugins_exporting
                            .Exporting
                            .new(
                                root,
                                {
                                    menu:
                                        am5plugins_exporting
                                            .ExportingMenu
                                            .new(
                                                root,
                                                {}
                                            ),
                                    dpi: 300,
                                    maxWidth: 2000,
                                    maxHeight: 2000
                                }
                            );

                    exporting
                        .export('png')
                        .then(function(imagen)
                        {
                            window.chartPngs =
                                window.chartPngs || {};

                            window.chartPngs[
                                nombreGrafica
                            ] = imagen;

                            console.log(
                                nombreGrafica +
                                ' exportado exitosamente'
                            );
                        })
                        .catch(function(error)
                        {
                            console.error(
                                'Error al exportar ' +
                                nombreGrafica +
                                ':',
                                error
                            );
                        });

                } else {

                    console.log(
                        'Plugin de exportación no disponible'
                    );
                }

            }, 1000);
        });
}

////// GUARDAR ANALISIS DE LAS GRAFICAS

$("#form_analisis_graficaglobal").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardaranalisisgraficaglobal',
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
            $("#botonguardar_analisis_graficaglobal").prop('disabled', true);
            $("#botonguardar_analisis_graficaglobal").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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

            $("#botonguardar_analisis_graficaglobal").prop('disabled', false);
            $("#botonguardar_analisis_graficaglobal").html('Guardar <i class="fa fa-save"></i>');
        }
    });

});

$("#form_analisis_grafica_categorias").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardaranalisisgraficacategoria',
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
            $("#botonguardar_analisis_grafica_categorias").prop('disabled', true);
            $("#botonguardar_analisis_grafica_categorias").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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

            $("#botonguardar_analisis_grafica_categorias").prop('disabled', false);
            $("#botonguardar_analisis_grafica_categorias").html('Guardar <i class="fa fa-save"></i>');
        }
    });

});

$("#form_analisis_grafica_dominio").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardaranalisisgraficadominio',
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
            $("#botonguardar_analisis_grafica_dominio").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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

            $("#botonguardar_analisis_grafica_dominio").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio").html('Guardar <i class="fa fa-save"></i>');
        }
    });

});

$("#form_analisis_grafica_guia1").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardaranalisisgraficaguia1',
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
            $("#botonguardar_analisis_grafica_guia1").prop('disabled', true);
            $("#botonguardar_analisis_grafica_guia1").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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

            $("#botonguardar_analisis_grafica_guia1").prop('disabled', false);
            $("#botonguardar_analisis_grafica_guia1").html('Guardar <i class="fa fa-save"></i>');
        }
    });

});




////// GUARDAR ANALISIS DE LAS GRAFICAS CATEGORIAS Y DOMINIOS

$("#form_analisis_grafica_ambiente").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficacatambiente',
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
            $("#botonguardar_analisis_grafica_ambiente").prop('disabled', true);
            $("#botonguardar_analisis_grafica_ambiente").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_ambiente").prop('disabled', false);
            $("#botonguardar_analisis_grafica_ambiente").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_ambiente").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomambiente',
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
            $("#botonguardar_analisis_grafica_dominio_ambiente").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_ambiente").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_ambiente").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_ambiente").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_factores").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficacatfactores',
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
            $("#botonguardar_analisis_grafica_factores").prop('disabled', true);
            $("#botonguardar_analisis_grafica_factores").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_factores").prop('disabled', false);
            $("#botonguardar_analisis_grafica_factores").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_factores_1").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomfactores1',
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
            $("#botonguardar_analisis_grafica_dominio_factores_1").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_factores_1").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_factores_1").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_factores_1").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_factores_2").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomfactores2',
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
            $("#botonguardar_analisis_grafica_dominio_factores_2").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_factores_2").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_factores_2").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_factores_2").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_organizacion").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficacatorganizacion',
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
            $("#botonguardar_analisis_grafica_organizacion").prop('disabled', true);
            $("#botonguardar_analisis_grafica_organizacion").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_organizacion").prop('disabled', false);
            $("#botonguardar_analisis_grafica_organizacion").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_organizacion_1").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomorganizacion1',
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
            $("#botonguardar_analisis_grafica_dominio_organizacion_1").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_organizacion_1").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_organizacion_1").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_organizacion_1").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_organizacion_2").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomorganizacion2',
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
            $("#botonguardar_analisis_grafica_dominio_organizacion_2").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_organizacion_2").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_organizacion_2").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_organizacion_2").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_liderazgo").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficacatliderazgo',
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
            $("#botonguardar_analisis_grafica_liderazgo").prop('disabled', true);
            $("#botonguardar_analisis_grafica_liderazgo").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_liderazgo").prop('disabled', false);
            $("#botonguardar_analisis_grafica_liderazgo").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_liderazgo_1").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomliderazgo1',
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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_1").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_1").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_1").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_1").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_liderazgo_2").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomliderazgo2',
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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_2").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_2").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_2").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_2").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_liderazgo_3").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomliderazgo3',
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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_3").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_3").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_liderazgo_3").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_liderazgo_3").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_entorno").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficacatentorno',
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
            $("#botonguardar_analisis_grafica_entorno").prop('disabled', true);
            $("#botonguardar_analisis_grafica_entorno").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_entorno").prop('disabled', false);
            $("#botonguardar_analisis_grafica_entorno").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_entorno_1").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomentorno1',
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
            $("#botonguardar_analisis_grafica_dominio_entorno_1").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_entorno_1").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_entorno_1").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_entorno_1").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});

$("#form_analisis_grafica_dominio_entorno_2").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({
        url: '/guardaranalisisgraficadomentorno2',
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
            $("#botonguardar_analisis_grafica_dominio_entorno_2").prop('disabled', true);
            $("#botonguardar_analisis_grafica_dominio_entorno_2").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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
            $("#botonguardar_analisis_grafica_dominio_entorno_2").prop('disabled', false);
            $("#botonguardar_analisis_grafica_dominio_entorno_2").html('Guardar <i class="fa fa-save"></i>');
        }
    });
});


////  CONTAR CUANTAS FOTOS HAY DE EVIDENCIA


function totalfotospsico() {

    $.ajax({
        url: '/totalfotospsico/' + proyecto.id,
        type: 'GET',
        dataType: 'json',
        cache: false,

        success: function(resp) {

            if (resp.code == 1) {
                $('#memoriafotografica_total').text(resp.total);
            } else {
                $('#memoriafotografica_total').text(0);
            }

        },

        error: function() {
            $('#memoriafotografica_total').text(0);
        }

    });

}



/// NIVEL DE RIESGO POR CATEGORIA 
  

$("#form_nivel_riesgo_categorias").on("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);
    formData.append('PROYECTO_ID', proyecto.id);

    $.ajax({

        url: '/guardarnivelriesgocategorias',
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
            $("#botonguardar_nivel_riesgo_categorias").prop('disabled', true);
            $("#botonguardar_nivel_riesgo_categorias").html('Guardando... <i class="fa fa-spinner fa-spin"></i>');
        },

        success: function(response)
        {
            consultarEstadosMenusReportePsico();

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

            $("#botonguardar_nivel_riesgo_categorias").prop('disabled', false);
            $("#botonguardar_nivel_riesgo_categorias").html('Guardar <i class="fa fa-save"></i>');
        }
    });

});


//// GUARDAR CONCLUSIONES



var contadorConclusiones = 0;

function agregarConclusion(titulo, descripcion)
{
    contadorConclusiones++;

    titulo = titulo || '';
    descripcion = descripcion || '';

    var html = `
        <div
            class="card conclusion-item mb-3"
            id="conclusion_item_${contadorConclusiones}"
            data-indice="${contadorConclusiones}"
        >
            <div class="card-header" style="background:#F5F5F5;">
                <div class="row">
                    <div class="col-10">
                        <b>
                            Conclusión
                            <span class="numero-conclusion"></span>
                        </b>
                    </div>

                    <div class="col-2 text-right">
                        <button
                            type="button"
                            class="btn btn-danger btn-sm boton_eliminar_conclusion"
                            data-indice="${contadorConclusiones}"
                            title="Eliminar conclusión"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Título
                            </label>

                            <input
                                type="text"
                                class="form-control titulo-conclusion"
                                name="TITULO_CONCLUSION[]"
                                value=""
                                required
                            >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                Descripción
                            </label>

                            <textarea
                                class="form-control descripcion-conclusion"
                                name="DESCRIPCION_CONCLUSION[]"
                                rows="5"
                                required
                            ></textarea>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    `;

    $("#contenedor_conclusiones").append(html);

    var item = $("#conclusion_item_" + contadorConclusiones);

    item.find(".titulo-conclusion").val(titulo);
    item.find(".descripcion-conclusion").val(descripcion);

    actualizarNumeracionConclusiones();
}

function actualizarNumeracionConclusiones()
{
    $("#contenedor_conclusiones .conclusion-item").each(
        function(indice)
        {
            $(this)
                .find(".numero-conclusion")
                .text(indice + 1);
        }
    );
}

function mostrarConclusiones(datos)
{
    $("#contenedor_conclusiones").empty();

    contadorConclusiones = 0;

    if (!datos) {
        agregarConclusion('', '');
        return;
    }

    var conclusiones = datos;

    if (typeof conclusiones === "string") {

        conclusiones = conclusiones.trim();

        if (conclusiones === "") {
            agregarConclusion('', '');
            return;
        }

        try {
            conclusiones = JSON.parse(conclusiones);
        } catch (error) {
            console.error(
                "No fue posible convertir INFORME_CONCLUSION:",
                error
            );

            agregarConclusion('', conclusiones);
            return;
        }
    }

    if (
        !Array.isArray(conclusiones) ||
        conclusiones.length === 0
    ) {
        agregarConclusion('', '');
        return;
    }

    conclusiones.forEach(
        function(conclusion)
        {
            agregarConclusion(
                conclusion.TITULO || '',
                conclusion.DESCRIPCION || ''
            );
        }
    );
}

$(document).on("click","#boton_nueva_conclusion",
    function()
    {
        agregarConclusion('', '');
    }
);

$(document).on("click",".boton_eliminar_conclusion",
    function()
    {
        var totalConclusiones = $("#contenedor_conclusiones .conclusion-item").length;
        if (totalConclusiones <= 1) {
            Swal.fire({
                icon: "warning",
                title: "Aviso",
                text: "Debe conservar al menos una conclusión"
            });

            return;
        }

        var indice = $(this).data("indice");
        $("#conclusion_item_" + indice).remove();
        actualizarNumeracionConclusiones();
    }
);

$("#form_reporte_conclusion").on(
    "submit",
    function(e)
    {
        e.preventDefault();

        var conclusiones = [];

        $("#contenedor_conclusiones .conclusion-item").each(
            function()
            {
                var titulo =
                    $(this)
                        .find(".titulo-conclusion")
                        .val()
                        .trim();

                var descripcion =
                    $(this)
                        .find(".descripcion-conclusion")
                        .val()
                        .trim();

                if (
                    titulo !== "" ||
                    descripcion !== ""
                ) {
                    conclusiones.push({
                        TITULO: titulo,
                        DESCRIPCION: descripcion
                    });
                }
            }
        );

        if (conclusiones.length === 0) {

            Swal.fire({
                icon: "warning",
                title: "Aviso",
                text: "Debe agregar al menos una conclusión"
            });

            return;
        }

        var formData = new FormData();

        formData.append(
            "_token",
            $('meta[name="csrf-token"]').attr("content")
        );

        formData.append(
            "PROYECTO_ID",
            proyecto.id
        );

        formData.append(
            "INFORME_CONCLUSION",
            JSON.stringify(conclusiones)
        );

        $.ajax({

            url: "/guardarinformeconclusionpsico",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            headers: {
                "X-CSRF-TOKEN":
                    $('meta[name="csrf-token"]').attr("content")
            },

            beforeSend: function()
            {
                $("#botonguardar_reporte_conclusion")
                    .prop(
                        "disabled",
                        true
                    );

                $("#botonguardar_reporte_conclusion")
                    .html(
                        'Guardando... <i class="fa fa-spinner fa-spin"></i>'
                    );
            },

            success: function(response)
            {
                Swal.fire({
                    icon: "success",
                    title: "Correcto",
                    text: response.msj,
                    timer: 2000,
                    showConfirmButton: false
                });

                if (response.INFORME_CONCLUSION) {
                    mostrarConclusiones(
                        response.INFORME_CONCLUSION
                    );
                }
            },

            error: function(xhr)
            {
                console.log(
                    xhr.responseText
                );

                var mensaje =
                    "Ocurrió un error al guardar";

                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.msj
                ) {
                    mensaje =
                        xhr.responseJSON.msj;
                }

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje
                });
            },

            complete: function()
            {
                $("#botonguardar_reporte_conclusion")
                    .prop(
                        "disabled",
                        false
                    );

                $("#botonguardar_reporte_conclusion")
                    .html(
                        'Guardar conclusiones <i class="fa fa-save"></i>'
                    );
            }
        });
    }
);

/// DASHBOARD

/// Trabajadores Acontecimiento Traumático Severo (ATS)

function cargarTotalTrabajadoresATSpsico()
{
    actualizarIndicadorTrabajadoresATS(0);

    $.get(
        '/obtenerTotalTrabajadoresATSpsico/' +
        proyecto.id,

        function(response)
        {
            var totalATS =
                parseInt(
                    response.total_trabajadores_ats
                ) || 0;

            actualizarIndicadorTrabajadoresATS(
                totalATS
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        actualizarIndicadorTrabajadoresATS(0);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar el total de trabajadores con ATS'
        });
    });
}

function actualizarIndicadorTrabajadoresATS(
    totalATS
)
{
    totalATS =
        parseInt(totalATS) || 0;

    var imagen =
        $('#imagen_trabajadores_ats');

    var texto =
        $('#texto_trabajadores_ats');

    $('#total_trabajadores_ats').text(
        totalATS
    );

    if (totalATS >= 1) {

        imagen.attr(
            'src',
            imagen.attr('data-imagen-roja')
        );

        texto
            .removeClass(
                'texto-ats-azul texto-rojo'
            )
            .addClass(
                'texto-ats-rojo'
            );

        return;
    }

    imagen.attr(
        'src',
        imagen.attr('data-imagen-azul')
    );

    texto
        .removeClass(
            'texto-ats-rojo texto-rojo'
        )
        .addClass(
            'texto-ats-azul'
        );
}

///  Trabajadores requieren atención

function cargarTotalTrabajadoresRequierenAtencionPsico()
{
  
    actualizarIndicadorRequierenAtencion(0);

    $.get('/obtenerTotalTrabajadoresRequierenAtencionPsico/' + proyecto.id,
        function(response)
        {
            var totalRequierenAtencion = parseInt(response.total_requieren_atencion) || 0;
            actualizarIndicadorRequierenAtencion(totalRequierenAtencion);
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        actualizarIndicadorRequierenAtencion(0);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar los trabajadores que requieren atención'
        });
    });
}

function actualizarIndicadorRequierenAtencion(totalRequierenAtencion)
{
    totalRequierenAtencion =
        parseInt(
            totalRequierenAtencion
        ) || 0;

    var imagen = $('#imagen_requieren_atencion');
    var texto = $('#texto_requieren_atencion');
    $('#total_requieren_atencion').text(totalRequierenAtencion);


    if (totalRequierenAtencion >= 1) {

        imagen.attr('src',imagen.attr('data-imagen-roja'));
        texto
            .removeClass('texto-atencion-azul texto-rojo')
            .addClass('texto-atencion-rojo');
        return;
    }

    imagen.attr('src',imagen.attr('data-imagen-azul'));

    texto
        .removeClass('texto-atencion-rojo texto-rojo')
        .addClass('texto-atencion-azul');
}

/// CATEOGIRA O DIMINIO MAS ALTO 
function cargarCategoriaODominioMayorRiesgoPsico()
{
    $('#nombre_categoria_dominio_mayor_riesgo')
        .text('Sin información');

    $('#tipo_categoria_dominio_mayor_riesgo')
        .text('Categoría o dominio');

    $.get(
        '/obtenerCategoriaODominioMayorRiesgoPsico/' +
        proyecto.id,

        function(response)
        {
            var nombre =
                response.nombre ||
                'Sin información';

            var tipo =
                response.tipo ||
                'Categoría o dominio';

            var nivel =
                response.nivel ||
                '';

            var totalTrabajadores =
                parseInt(
                    response.total_trabajadores
                ) || 0;

            $('#nombre_categoria_dominio_mayor_riesgo')
                .text(nombre);

            $('#tipo_categoria_dominio_mayor_riesgo')
                .text(tipo);
            
            console.log(
                'Mayor riesgo:',
                {
                    nombre: nombre,
                    tipo: tipo,
                    nivel: nivel,
                    total_trabajadores: totalTrabajadores
                }
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        $('#nombre_categoria_dominio_mayor_riesgo')
            .text('Sin información');

        $('#tipo_categoria_dominio_mayor_riesgo')
            .text('Categoría o dominio');

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la categoría o dominio con mayor riesgo'
        });
    });
}

///  Trabajadores con mayor riesgo (categorías) / Trabajadores con mayor riesgo (dominios)

function cargarGraficasMayorRiesgoPsico()
{
    $('#grafica_categorias').html(`
        <div class="mensaje-sin-datos-grafica">
            Consultando información...
        </div>
    `);

    $('#grafica_dominios').html(`
        <div class="mensaje-sin-datos-grafica">
            Consultando información...
        </div>
    `);

    $.get(
        '/obtenerGraficasMayorRiesgoPsico/' +
        proyecto.id,

        function(response)
        {
            generarGraficaBarrasMayorRiesgo(
                'grafica_categorias',
                response.categorias || [],
                'categorias'
            );

            generarGraficaBarrasMayorRiesgo(
                'grafica_dominios',
                response.dominios || [],
                'dominios'
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        $('#grafica_categorias').html(`
            <div class="mensaje-sin-datos-grafica">
                No hay información disponible
            </div>
        `);

        $('#grafica_dominios').html(`
            <div class="mensaje-sin-datos-grafica">
                No hay información disponible
            </div>
        `);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar las categorías y dominios'
        });
    });
}

function generarGraficaBarrasMayorRiesgo(contenedorId,datos,tipoGrafica)
{
    if (!Array.isArray(datos)) {
        datos = [];
    }

    if (
        tipoGrafica === 'categorias' &&
        window.rootMayorRiesgoCategorias
    ) {

        if (
            !window.rootMayorRiesgoCategorias
                .isDisposed()
        ) {

            window.rootMayorRiesgoCategorias
                .dispose();
        }

        window.rootMayorRiesgoCategorias = null;
    }

    if (
        tipoGrafica === 'dominios' &&
        window.rootMayorRiesgoDominios
    ) {

        if (
            !window.rootMayorRiesgoDominios
                .isDisposed()
        ) {

            window.rootMayorRiesgoDominios
                .dispose();
        }

        window.rootMayorRiesgoDominios = null;
    }

    $('#' + contenedorId).empty();

    var datosValidos =
        datos
            .filter(function(item)
            {
                return (
                    item &&
                    item.category
                );
            })
            .map(function(item)
            {
                return {
                    category:
                        item.category,

                    value:
                        parseInt(item.value) || 0,

                    nivel:
                        item.nivel ||
                        'Sin información',

                    color:
                        item.color ||
                        '#BDBDBD'
                };
            });

    var tieneInformacion =
        datosValidos.some(function(item)
        {
            return item.value > 0;
        });

    if (
        datosValidos.length === 0 ||
        !tieneInformacion
    ) {

        $('#' + contenedorId).html(`
            <div class="mensaje-sin-datos-grafica">
                No hay información disponible
            </div>
        `);

        return;
    }

    var root =
        am5.Root.new(
            contenedorId
        );

    if (tipoGrafica === 'categorias') {

        window.rootMayorRiesgoCategorias =
            root;

    } else {

        window.rootMayorRiesgoDominios =
            root;
    }

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    if (root._logo) {
        root._logo.dispose();
    }

    var chart =
        root.container.children.push(

            am5xy.XYChart.new(
                root,
                {
                    panX: false,
                    panY: false,
                    wheelX: 'none',
                    wheelY: 'none',
                    paddingTop: 5,
                    paddingBottom: 5,
                    paddingLeft: 0,
                    paddingRight: 30,
                    layout: root.verticalLayout
                }
            )
        );

    var rendererValores =
        am5xy.AxisRendererX.new(
            root,
            {
                minGridDistance: 30
            }
        );

    rendererValores
        .labels
        .template
        .setAll({
            forceHidden: true
        });

    rendererValores
        .grid
        .template
        .setAll({
            stroke: am5.color(0xCCCCCC),
            strokeOpacity: 0.5
        });

    var ejeValores =
        chart.xAxes.push(

            am5xy.ValueAxis.new(
                root,
                {
                    min: 0,
                    extraMax: 0.18,
                    strictMinMax: false,
                    renderer: rendererValores
                }
            )
        );

    var rendererCategorias =
        am5xy.AxisRendererY.new(
            root,
            {
                inversed: true,
                minGridDistance:
                    tipoGrafica ===
                    'categorias'
                        ? 50
                        : 25
            }
        );

    rendererCategorias
        .grid
        .template
        .setAll({
            forceHidden: true
        });

    rendererCategorias
        .labels
        .template
        .setAll({
            fill: am5.color(0x222222),

            fontSize:
                tipoGrafica ===
                'categorias'
                    ? 12
                    : 11,

            fontWeight: '400',

            maxWidth:
                tipoGrafica ===
                'categorias'
                    ? 220
                    : 250,

            oversizedBehavior: 'wrap',
            textAlign: 'right',
            paddingRight: 8
        });

    var ejeCategorias =
        chart.yAxes.push(

            am5xy.CategoryAxis.new(
                root,
                {
                    categoryField:
                        'category',

                    renderer:
                        rendererCategorias
                }
            )
        );

    ejeCategorias.data.setAll(
        datosValidos
    );

    var serie =
        chart.series.push(

            am5xy.ColumnSeries.new(
                root,
                {
                    name: 'Trabajadores',
                    xAxis: ejeValores,
                    yAxis: ejeCategorias,
                    valueXField: 'value',
                    categoryYField: 'category',
                    sequencedInterpolation: true,
                    maskBullets: false
                }
            )
        );

    serie.columns.template.setAll({

        height:
            tipoGrafica === 'categorias'
                ? am5.percent(48)
                : am5.percent(68),

        strokeOpacity: 0,

        cornerRadiusTR: 5,
        cornerRadiusBR: 5,

        tooltipText:
            '{category}\n' +
            'Nivel: {nivel}\n' +
            'Trabajadores: {value}'
    });

    serie.columns.template.adapters.add(
        'fill',

        function(fill, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return fill;
        }
    );

    serie.columns.template.adapters.add(
        'stroke',

        function(stroke, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return stroke;
        }
    );

    serie.bullets.push(function()
    {
        return am5.Bullet.new(
            root,
            {
                locationX: 1,

                sprite:
                    am5.Label.new(
                        root,
                        {
                            text: '{valueX}',
                            populateText: true,
                            centerY:
                                am5.percent(50),
                            centerX:
                                am5.percent(0),
                            dx: 6,
                            fill:
                                am5.color(
                                    0x111111
                                ),
                            fontSize: 12,
                            fontWeight: '500'
                        }
                    )
            }
        );
    });

    serie.data.setAll(
        datosValidos
    );

    serie.appear(
        800
    );

    chart.appear(
        800,
        100
    );
}

///Distribución general de riesgo

function cargarGraficaDistribucionRiesgoPsico()
{
    limpiarValoresDistribucionRiesgo();

    $.get(
        '/obtenerGraficaCalificacionPsico/' +
        proyecto.id,

        function(response)
        {
            generarGraficaDistribucionRiesgoPsico(
                response.data || [],
                response.total_trabajadores || 0
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        limpiarValoresDistribucionRiesgo();

        $('#distribucionRiesgoChart').html(`
            <div
                style="
                    width:100%;
                    height:100%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:#777;
                    font-weight:bold;
                    text-align:center;
                "
            >
                No hay información disponible
            </div>
        `);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar la distribución general de riesgo'
        });
    });
}

function limpiarValoresDistribucionRiesgo()
{
    $('#distribucion_muy_alto').text('0');
    $('#distribucion_alto').text('0');
    $('#distribucion_medio').text('0');
    $('#distribucion_bajo').text('0');
    $('#distribucion_nulo').text('0');
}

function generarGraficaDistribucionRiesgoPsico(datos,totalTrabajadores)
{
    if (!Array.isArray(datos)) {
        datos = [];
    }

    if (window.rootDistribucionRiesgoPsico) {

        if (
            !window.rootDistribucionRiesgoPsico
                .isDisposed()
        ) {

            window.rootDistribucionRiesgoPsico
                .dispose();
        }

        window.rootDistribucionRiesgoPsico =
            null;
    }

    $('#distribucionRiesgoChart').empty();

    var datosNormalizados =
        datos.map(function(item)
        {
            return {
                category:
                    item.category,

                value:
                    parseInt(item.value) || 0,

                color:
                    item.color || '#BDBDBD'
            };
        });


    datosNormalizados.forEach(function(item)
    {
        if (item.category === 'Muy alto') {

            $('#distribucion_muy_alto')
                .text(item.value);

        } else if (item.category === 'Alto') {

            $('#distribucion_alto')
                .text(item.value);

        } else if (item.category === 'Medio') {

            $('#distribucion_medio')
                .text(item.value);

        } else if (item.category === 'Bajo') {

            $('#distribucion_bajo')
                .text(item.value);

        } else if (
            item.category ===
            'Nulo o despreciable'
        ) {

            $('#distribucion_nulo')
                .text(item.value);
        }
    });

    var datosGrafica =
        datosNormalizados.filter(
            function(item)
            {
                return item.value > 0;
            }
        );

    if (datosGrafica.length === 0) {

        $('#distribucionRiesgoChart').html(`
            <div
                style="
                    width:100%;
                    height:100%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    color:#777;
                    font-weight:bold;
                    text-align:center;
                "
            >
                No hay información disponible
            </div>
        `);

        return;
    }

    var root =
        am5.Root.new(
            'distribucionRiesgoChart'
        );

    window.rootDistribucionRiesgoPsico =
        root;

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    if (root._logo) {
        root._logo.dispose();
    }

    var chart =
        root.container.children.push(

            am5percent.PieChart.new(
                root,
                {
                    layout:
                        root.verticalLayout,

                    innerRadius:
                        am5.percent(50),

                    radius:
                        am5.percent(82),

                    paddingTop: 15,
                    paddingBottom: 15,
                    paddingLeft: 15,
                    paddingRight: 15
                }
            )
        );

    var series =
        chart.series.push(

            am5percent.PieSeries.new(
                root,
                {
                    valueField:
                        'value',

                    categoryField:
                        'category',

                    alignLabels:
                        true
                }
            )
        );

    series.slices.template.adapters.add(
        'fill',

        function(fill, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return fill;
        }
    );

    series.slices.template.adapters.add(
        'stroke',

        function(stroke, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return stroke;
        }
    );

    series.slices.template.setAll({
        stroke: am5.color(0xFFFFFF),
        strokeWidth: 1,
        tooltipText:
            '{category}: {value} trabajadores ' +
            '({valuePercentTotal.formatNumber("0.0")}%)'
    });

    series.labels.template.setAll({
        text:
            '{category}\n' +
            '{valuePercentTotal.formatNumber("0.0")}%',
        fontSize: 9,
        fill: am5.color(0x222222),
        textAlign: 'center',
        radius: 5
    });

    series.ticks.template.setAll({
        stroke: am5.color(0x777777),
        strokeOpacity: 0.6
    });

    series.data.setAll(
        datosGrafica
    );

    series.appear(
        800,
        100
    );

    chart.appear(
        800,
        100
    );
}

/// Trabajadores con ATS
function cargarGraficaTrabajadoresATSpsico()
{
    if (window.rootTrabajadoresATSpsico) {

        if (
            !window.rootTrabajadoresATSpsico
                .isDisposed()
        ) {

            window.rootTrabajadoresATSpsico
                .dispose();
        }

        window.rootTrabajadoresATSpsico =
            null;
    }

    $('#grafica_trabajadores_ats').html(`
        <div class="mensaje-sin-datos-ats">
            Consultando información...
        </div>
    `);

    $.get(
        '/obtenerGraficaGuiaIPsico/' +
        proyecto.id,

        function(response)
        {
            generarGraficaTrabajadoresATSpsico(
                response.data || [],
                response.requiere_valoracion || 0,
                response.no_requiere_valoracion || 0,
                response.total_trabajadores || 0
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        $('#grafica_trabajadores_ats').html(`
            <div class="mensaje-sin-datos-ats">
                No hay información disponible
            </div>
        `);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar los trabajadores con ATS'
        });
    });
}

function generarGraficaTrabajadoresATSpsico(datos,requiereValoracion,noRequiereValoracion,totalTrabajadores)
{
    if (!Array.isArray(datos)) {
        datos = [];
    }

    requiereValoracion =
        parseInt(requiereValoracion) || 0;

    noRequiereValoracion =
        parseInt(noRequiereValoracion) || 0;

    totalTrabajadores =
        parseInt(totalTrabajadores) || 0;

    var porcentajeATS = 0;

    if (totalTrabajadores > 0) {

        porcentajeATS =
            (
                requiereValoracion /
                totalTrabajadores
            ) * 100;
    }

    if (window.rootTrabajadoresATSpsico) {

        if (
            !window.rootTrabajadoresATSpsico
                .isDisposed()
        ) {

            window.rootTrabajadoresATSpsico
                .dispose();
        }

        window.rootTrabajadoresATSpsico =
            null;
    }

    var datosNormalizados =
        datos.map(function(item)
        {
            return {
                category:
                    item.category || '',

                value:
                    parseInt(item.value) || 0,

                color:
                    item.color || '#BDBDBD'
            };
        });

    var datosGrafica =
        datosNormalizados.filter(
            function(item)
            {
                return item.value > 0;
            }
        );

    if (
        totalTrabajadores === 0 ||
        datosGrafica.length === 0
    ) {

        $('#grafica_trabajadores_ats').html(`
            <div class="mensaje-sin-datos-ats">
                No hay información disponible
            </div>
        `);

        return;
    }

    $('#grafica_trabajadores_ats').html(`
        <div
            class="ats-chart-contenedor"
            id="atsChartContenedor"
        ></div>

        <div
            class="ats-porcentaje-centro"
            id="ats_porcentaje_centro"
        >
            ${porcentajeATS.toFixed(1)}%
        </div>
    `);

    var root =
        am5.Root.new(
            'atsChartContenedor'
        );

    window.rootTrabajadoresATSpsico =
        root;

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    if (root._logo) {
        root._logo.dispose();
    }

    var chart =
        root.container.children.push(

            am5percent.PieChart.new(
                root,
                {
                    innerRadius:
                        am5.percent(57),

                    radius:
                        am5.percent(90),

                    paddingTop: 10,
                    paddingBottom: 10,
                    paddingLeft: 10,
                    paddingRight: 10
                }
            )
        );

    var series =
        chart.series.push(

            am5percent.PieSeries.new(
                root,
                {
                    valueField:
                        'value',

                    categoryField:
                        'category',

                    alignLabels:
                        false
                }
            )
        );

    series.slices.template.adapters.add(
        'fill',

        function(fill, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return fill;
        }
    );

    series.slices.template.adapters.add(
        'stroke',

        function(stroke, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return stroke;
        }
    );

    series.slices.template.setAll({
        stroke: am5.color(0xFFFFFF),
        strokeWidth: 1,

        tooltipText:
            '{category}\n' +
            '{value} trabajadores\n' +
            '{valuePercentTotal.formatNumber("0.0")}%'
    });

    series.labels.template.setAll({
        text:
            '{valuePercentTotal.formatNumber("0.0")}%',
        inside: true,
        radius: am5.percent(72),
        centerX: am5.percent(50),
        centerY: am5.percent(50),
        fill: am5.color(0xFFFFFF),
        fontSize: 12,
        fontWeight: '700',
        textAlign: 'center'
    });

    series.ticks.template.setAll({
        forceHidden: true
    });

    series.data.setAll(
        datosGrafica
    );

    series.appear(
        800,
        100
    );

    chart.appear(
        800,
        100
    );
}

/// Cumplimiento Normativo

function cargarGraficaCumplimientoNormativoPsico()
{
    if (window.rootCumplimientoNormativo) {

        if (
            !window.rootCumplimientoNormativo
                .isDisposed()
        ) {

            window.rootCumplimientoNormativo
                .dispose();
        }

        window.rootCumplimientoNormativo = null;
    }

    $('#grafica_nivel_riesgo').html(`
        <div class="mensaje-sin-datos-cumplimiento">
            Consultando información...
        </div>
    `);

    $.get(
        '/obtenerGraficaCalificacionPsico/' +
        proyecto.id,

        function(response)
        {
            generarGraficaCumplimientoNormativoPsico(
                response.data || [],
                response.total_trabajadores || 0
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        $('#grafica_nivel_riesgo').html(`
            <div class="mensaje-sin-datos-cumplimiento">
                No hay información disponible
            </div>
        `);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar el cumplimiento normativo'
        });
    });
}

function generarGraficaCumplimientoNormativoPsico(datos,totalTrabajadores)
{
    if (!Array.isArray(datos)) {
        datos = [];
    }

    totalTrabajadores =
        parseInt(totalTrabajadores) || 0;

 
    if (window.rootCumplimientoNormativo) {

        if (
            !window.rootCumplimientoNormativo
                .isDisposed()
        ) {

            window.rootCumplimientoNormativo
                .dispose();
        }

        window.rootCumplimientoNormativo = null;
    }

    var muyAlto = 0;
    var alto = 0;
    var medio = 0;
    var bajo = 0;
    var nulo = 0;

    datos.forEach(function(item)
    {
        var cantidad =
            parseInt(item.value) || 0;

        if (item.category === 'Muy alto') {

            muyAlto = cantidad;

        } else if (item.category === 'Alto') {

            alto = cantidad;

        } else if (item.category === 'Medio') {

            medio = cantidad;

        } else if (item.category === 'Bajo') {

            bajo = cantidad;

        } else if (
            item.category ===
            'Nulo o despreciable'
        ) {

            nulo = cantidad;
        }
    });


    if (totalTrabajadores === 0) {

        totalTrabajadores =
            muyAlto +
            alto +
            medio +
            bajo +
            nulo;
    }

    if (totalTrabajadores === 0) {

        $('#grafica_nivel_riesgo').html(`
            <div class="mensaje-sin-datos-cumplimiento">
                No hay información disponible
            </div>
        `);

        return;
    }

    var totalFueraNorma =
        muyAlto +
        alto +
        medio;

    var totalDentroNorma =
        bajo +
        nulo;

    var porcentajeFueraNorma =
        (
            totalFueraNorma /
            totalTrabajadores
        ) * 100;

    var porcentajeDentroNorma =
        (
            totalDentroNorma /
            totalTrabajadores
        ) * 100;

    porcentajeFueraNorma =
        Math.max(
            0,
            Math.min(
                100,
                porcentajeFueraNorma
            )
        );

    porcentajeDentroNorma =
        Math.max(
            0,
            Math.min(
                100,
                porcentajeDentroNorma
            )
        );

    if (
        porcentajeFueraNorma +
        porcentajeDentroNorma > 0
    ) {

        porcentajeDentroNorma =
            100 -
            porcentajeFueraNorma;
    }

    var posicionAguja = 0;

    if (porcentajeDentroNorma > 0) {

        posicionAguja =
            porcentajeFueraNorma +
            (
                porcentajeDentroNorma /
                2
            );

    } else if (porcentajeFueraNorma > 0) {

        posicionAguja =
            porcentajeFueraNorma /
            2;
    }

    var anguloAguja =
        180 +
        (
            posicionAguja *
            1.8
        );

  
    $('#grafica_nivel_riesgo').html(`
        <div class="cumplimiento-chart" id="cumplimientoNormativoChart"></div>
        <div id="aguja_cumplimiento" style="position:absolute; left:50%; top:68%; z-index:5; width:31%; max-width:125px; height:7px; background:#222222; border-radius:7px; transform-origin:0 50%;
                transform: translateY(-50%) rotate(${anguloAguja}deg); pointer-events:none;"></div>
        <div id="centro_aguja_cumplimiento" style=" position:absolute; left:50%; top:68%; z-index:6; width:18px; height:18px; background:#222222; border-radius:50%; transform:translate(-50%, -50%); pointer-events:none;"></div>
        <div id="texto_centro_cumplimiento" style=" position:absolute; top:43%; left:50%; z-index:7; width:160px; color:#222222; text-align:center; transform:translate(-50%, -50%); pointer-events:none">
            <div id="porcentaje_dentro_norma" style=" font-size:24px; font-weight:700; line-height:1;">
                ${porcentajeDentroNorma.toFixed(1)}%
            </div>
            <div id="descripcion_dentro_norma" style=" margin-top:5px; font-size:11px; font-weight:600; line-height:1.1;">
                Dentro de norma
            </div>
        </div>
        <div class="cumplimiento-resultados"id="cumplimiento_resultados">
            <div class="cumplimiento-resultado-item fuera-norma" id="resultado_fuera_norma">
                <span class="cumplimiento-color color-rojo"></span>
                <span>
                    Fuera de norma
                </span>
                <strong id="porcentaje_fuera_norma">
                    ${porcentajeFueraNorma.toFixed(1)}%
                </strong>
            </div>

            <div class="cumplimiento-resultado-item dentro-norma" id="resultado_dentro_norma">
                <span class="cumplimiento-color color-verde"></span>
                <span>
                    Dentro de norma
                </span
                <strong id="porcentaje_dentro_norma_leyenda">
                    ${porcentajeDentroNorma.toFixed(1)}%
                </strong>
            </div>
        </div>
    `);

    if (porcentajeFueraNorma <= 0) {

        $('#resultado_fuera_norma').hide();

    } else {

        $('#resultado_fuera_norma').show();
    }


    if (porcentajeDentroNorma <= 0) {

        $('#resultado_dentro_norma').hide();

        $('#texto_centro_cumplimiento').hide();

    } else {

        $('#resultado_dentro_norma').show();

        $('#texto_centro_cumplimiento').show();
    }


    var datosVelocimetro = [];

    if (porcentajeFueraNorma > 0) {

        datosVelocimetro.push({
            category:
                'Fuera de norma',

            value:
                porcentajeFueraNorma,

            color:
                '#E30613'
        });
    }

    if (porcentajeDentroNorma > 0) {

        datosVelocimetro.push({
            category:
                'Dentro de norma',

            value:
                porcentajeDentroNorma,

            color:
                '#00B050'
        });
    }

    var root =
        am5.Root.new(
            'cumplimientoNormativoChart'
        );

    window.rootCumplimientoNormativo =
        root;

    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    if (root._logo) {
        root._logo.dispose();
    }

    var chart =
        root.container.children.push(

            am5percent.PieChart.new(
                root,
                {
                    startAngle:
                        180,

                    endAngle:
                        360,

                    innerRadius:
                        am5.percent(61),

                    radius:
                        am5.percent(94),

                    paddingTop:
                        5,

                    paddingBottom:
                        0,

                    paddingLeft:
                        10,

                    paddingRight:
                        10
                }
            )
        );

    var series =
        chart.series.push(

            am5percent.PieSeries.new(
                root,
                {
                    startAngle:
                        180,

                    endAngle:
                        360,

                    valueField:
                        'value',

                    categoryField:
                        'category',

                    alignLabels:
                        false
                }
            )
        );

    series.slices.template.adapters.add(
        'fill',

        function(fill, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return fill;
        }
    );

    series.slices.template.adapters.add(
        'stroke',

        function(stroke, target)
        {
            if (
                target.dataItem &&
                target.dataItem.dataContext &&
                target.dataItem
                    .dataContext
                    .color
            ) {

                return am5.color(
                    target.dataItem
                        .dataContext
                        .color
                );
            }

            return stroke;
        }
    );

    series.slices.template.setAll({
        strokeWidth: 0,

        toggleKey:
            'none',

        interactive:
            false,

        tooltipText:
            '{category}: ' +
            '{value.formatNumber("0.0")}%'
    });

    series.labels.template.setAll({
        forceHidden: true
    });

    series.ticks.template.setAll({
        forceHidden: true
    });

    series.data.setAll(
        datosVelocimetro
    );

    series.appear(
        800,
        100
    );

    chart.appear(
        800,
        100
    );
}

/// Recomendaciones prioritarias

function cargarRecomendacionesPrioritariasPsico()
{
    $('#lista_recomendaciones_prioritarias').html(`
        <div class="recomendaciones-mensaje">
            Consultando recomendaciones...
        </div>
    `);

    $.get(
        '/obtenerRecomendacionesPrioritariasPsico/' +
        proyecto.id,

        function(response)
        {
            mostrarRecomendacionesPrioritariasPsico(
                response.data || []
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(xhr.responseText);

        $('#lista_recomendaciones_prioritarias').html(`
            <div class="recomendaciones-mensaje">
                No fue posible consultar las recomendaciones.
            </div>
        `);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible consultar las recomendaciones prioritarias'
        });
    });
}

function mostrarRecomendacionesPrioritariasPsico(
    recomendaciones
)
{
    if (!Array.isArray(recomendaciones)) {
        recomendaciones = [];
    }

    var contenedor =
        $('#lista_recomendaciones_prioritarias');

    contenedor.empty();

    if (recomendaciones.length === 0) {

        contenedor.html(`
            <div class="recomendaciones-mensaje">
                No hay recomendaciones prioritarias.
            </div>
        `);

        return;
    }

    var iconos = [
        'fa-bullseye'
    ];

    recomendaciones.forEach(
        function(recomendacion, indice)
        {
            var texto =
                recomendacion
                    .RECOMENDACION_CONTROL ||
                '';

            if (!texto.trim()) {
                return;
            }

            var claseIcono =
                iconos[
                    indice % iconos.length
                ];
            
            var item =
                $('<div>', {
                    class:
                        'recomendacion-item'
                });

            var iconoContenedor =
                $('<div>', {
                    class:
                        'recomendacion-icono'
                });

            var icono =
                $('<i>', {
                    class:
                        'fa ' + claseIcono
                });

            var textoContenedor =
                $('<div>', {
                    class:
                        'recomendacion-texto'
                });

            textoContenedor.text(
                texto
            );

            iconoContenedor.append(
                icono
            );

            item.append(
                iconoContenedor,
                textoContenedor
            );

            contenedor.append(
                item
            );
        }
    );

    if (
        contenedor
            .find('.recomendacion-item')
            .length === 0
    ) {

        contenedor.html(`
            <div class="recomendaciones-mensaje">
                No hay recomendaciones prioritarias.
            </div>
        `);
    }
}


/// ESTADO MENU

function consultarEstadosMenusReportePsico()
{
    if (
        typeof proyecto === 'undefined' ||
        !proyecto ||
        !proyecto.id
    ) {

        console.log(
            'No se encontró el ID del proyecto'
        );

        return;
    }

    $.get(
        '/consultarEstadosMenusReportePsico/' +
        proyecto.id,

        function(response)
        {
            var estados =
                response.estados || {};

            actualizarEstadosMenusReportePsico(
                estados
            );
        }
    )
    .fail(function(xhr)
    {
        console.log(
            'Error al consultar estados del menú:',
            xhr.responseText
        );
    });
}


function actualizarEstadosMenusReportePsico(
    estados
)
{
    $.each(
        estados,

        function(menuId, completado)
        {
            if (completado) {

                marcarMenuCompleto(
                    menuId
                );

            } else {

                marcarMenuPendiente(
                    menuId
                );
            }
        }
    );
}


function marcarMenuCompleto(menuId)
{
    var icono =
        $('#' + menuId);

    if (!icono.length) {
        return;
    }

    icono
        .removeClass('fa-times')
        .addClass('fa-check')
        .css('color', '#64bd44');
}


function marcarMenuPendiente(menuId)
{
    var icono =
        $('#' + menuId);

    if (!icono.length) {
        return;
    }

    icono
        .removeClass('fa-check')
        .addClass('fa-times')
        .css('color', '#FF0000');
}


/// AREAS CATEGORIAS PSICO



var datatable_areas = null;

function tabla_areas(proyecto_id)
{
    try
    {
        var ruta = "/areascategoriaspsico/" + proyecto.id;

        if (datatable_areas != null)
        {
            datatable_areas.clear().draw();
            datatable_areas.ajax.url(ruta).load();

            return;
        }

        var numeroejecucion = 1;

        datatable_areas = $('#tabla_areas').DataTable({
            ajax: {
                url: ruta,
                type: "GET",
                cache: false,
                dataType: "json",

                dataSrc: function (json)
                {
                    return json.data;
                },

                error: function (xhr, error, code)
                {
                    console.log(
                        'Error en datatable_areas: ' + code
                    );

                    if (numeroejecucion <= 1)
                    {
                        numeroejecucion++;
                        tabla_areas(proyecto_id);
                    }
                }
            },

            columns: [
                {
                    data: "numero_registro",
                    defaultContent: "-",
                    orderable: false
                },
                {
                    data: "reportearea_nombre",
                    defaultContent: "-",
                    orderable: false
                },
                {
                    data: "reportecategoria_nombre",
                    defaultContent: "-",
                    orderable: false
                },
                {
                    data: "reporteareacategoria_total",
                    defaultContent: "-",
                    orderable: false
                },
                {
                    data: "actividadprincipal",
                    defaultContent: "Sin descripción registrada",
                    orderable: false,
                    render: function (data, type, row)
                    {
                        if (
                            data === null ||
                            data === undefined ||
                            $.trim(data) === ''
                        ) {
                            return 'Sin descripción registrada';
                        }

                        return data;
                    }
                }
            ],

            lengthMenu: [
                [30, 50, 100, -1],
                [30, 50, 100, "Todos"]
            ],

            rowsGroup: [4, 0, 1],
            ordering: false,
            processing: true,
            searching: true,
            paging: true,

            language: {
                lengthMenu: "Mostrar _MENU_ Registros",
                zeroRecords: "No se encontraron registros",
                info: "Página _PAGE_ de _PAGES_ (Total _TOTAL_ registros)",
                infoEmpty: "No se encontraron registros",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                emptyTable: "No hay datos disponibles en la tabla",
                loadingRecords: "Cargando datos....",
                processing: "Procesando <i class='fa fa-spin fa-spinner fa-3x'></i>",
                search: "Buscar",

                paginate: {
                    first: "Primera",
                    last: "Última",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    }
    catch (exception)
    {
        console.log(
            'Error al construir la tabla de áreas:',
            exception
        );
    }
}

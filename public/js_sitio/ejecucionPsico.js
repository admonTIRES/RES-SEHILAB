//variables globales
var proyecto_id = 0;


var datatable_ejecuciones = null;
var datatable_trabajadores_presencial = null;
var datatable_trabajadores_online = null;

ID_FOTOS_EJECUCION = 0;


//CARGA INCIIAL
$(document).ready(function () {
	oculta_menustab_principal();
	tabla_ejecucion();

	$('[data-toggle="tooltip"]').tooltip();
	$('#tab_tabla_ejecucion').click();

});

//======================================NAV==================================//
// navegar menu Tab principal
$('.nav-link').click(function () {
	switch (this.id) {
		case "tab_tabla_ejecucion":
			$('#tab_info_ejecucion').css('display', 'none');
			break;

		case "tab_evidencias_ejecucion":
			consulta_evidencia_fotos(proyecto_id);

			$('#tabmenu_evidencia_3').removeClass('active');
			$('#tab_evidencia_3').removeClass('active show');

			$('#tabmenu_evidencia_2').addClass('active');
			$('#tab_evidencia_2').addClass('active show');
			break;

		case "tabmenu_evidencia_2":
			$('#tabmenu_evidencia_3').removeClass('active');
			$('#tab_evidencia_3').removeClass('active show');

			$('#tabmenu_evidencia_2').addClass('active');
			$('#tab_evidencia_2').addClass('active show');
			break;

		case "tabmenu_evidencia_3":
			$('#tabmenu_evidencia_2').removeClass('active');
			$('#tab_evidencia_2').removeClass('active show');

			$('#tabmenu_evidencia_3').addClass('active');
			$('#tab_evidencia_3').addClass('active show');

			cargarevidenciafotos();
			break;

		default:
			break;
	}
});

//=======================================TABLAS==================================================//
$('#tabla_ejecucion tbody').on('click', 'td>button.mostrar', function () {
	var tr = $(this).closest('tr');
	var row = datatable_ejecuciones.row(tr);

	proyecto_id = row.data().ID_PROYECTO


	//DIV NOMBRE DEL PROYECTO
	$('.div_folio_proyecto').html(row.data().FOLIO);
	$('.div_folio_reconocimiento').html(row.data().RECONOCIMIENTO_VINCULADO);

	// mostrar menu tab
	muestra_menustab_principal();
	tabla_trabajadores_online();
	tabla_trabajadores_presencial();

	// Selecciona step form 1
	$("#tab_info_ejecucion").click();

});

//======================================BOTONES===================================================//

$("#botocargar_respuestas_trabajadores").click(function () {
	$('#modal_cargarRespuestasTrabajadores').modal({ backdrop: false });
});

$("#botonactualizar_fechas_online").click(function () {
	var valida = this.form.checkValidity();
	if (valida) {
		swal({
			title: "¡Confirme que desea actualizar las fechas!",
			text: "Actualizar fechas de TODOS los trabajadores",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Actualizar!",
			cancelButtonText: "Cancelar!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
			function (isConfirm) {
				if (isConfirm) {
					// cerrar msj confirmacion
					swal.close();
					let datosEnviar = [];

					let table = $('#tabla_trabajadores_online').DataTable();

					let allData = table.rows().data();

					allData.each(function (row) {
						let trabajadorNombre = row.TRABAJADOR_NOMBRE;
						let fechaInicio = row.FECHAINICIO;
						let fechaFin = row.FECHAFIN;

						let trabajadorId = row.TRABAJADOR_ID;

			

						datosEnviar.push({
							trabajadorNombre: trabajadorNombre,
							trabajadorId: trabajadorId,
							fechaInicio: fechaInicio,
							fechaFin: fechaFin,

						});
					});


					$('#form_actualizarFechasOnline').ajaxForm({
						dataType: 'json',
						type: 'PUT',
						url: '/actualizarFechasOnline',
						data: {
							proyecto_id: proyecto_id,
							opcion: 0,
							datos: JSON.stringify(datosEnviar)
						},
						resetForm: false,
						success: function (dato) {

							// mensaje
							swal({
								title: "Correcto",
								text: "" + dato.msj,
								type: "success", // warning, error, success, info
								buttons: {
									visible: false, // true , false
								},
								timer: 1500,
								showConfirmButton: false
							});


							tabla_trabajadores_online();
							// actualiza boton
							$('#botonactualizar_fechas_online').html('Guardar <i class="fa fa-save"></i>');
						},
						beforeSend: function () {
							$('#botonactualizar_fechas_online').html('Guardando <i class="fa fa-spin fa-spinner"></i>');

						},
						error: function (dato) {
							// actualiza boton
							$('#botonactualizar_fechas_online').html('Guardar <i class="fa fa-save"></i>');
							
							// mensaje
							swal({
								title: "Error",
								text: "" + dato.msj,
								type: "error", // warning, error, success, info
								buttons: {
									visible: false, // true , false
								},
								timer: 1500,
								showConfirmButton: false
							});
							return false;
						}
					}).submit();
					return false;
				}
				else {
					// mensaje
					swal({
						title: "Cancelado",
						text: "Acción cancelada",
						type: "error", // warning, error, success, info
						buttons: {
							visible: false, // true , false
						},
						timer: 500,
						showConfirmButton: false
					});
				}
			});
		return false;
	}
});



$("#botonactualizar_fechaaplicacion").click(function () {
	var valida = this.form.checkValidity();
	if (valida) {
		swal({
			title: "¡Confirme que desea actualizar!",
			text: "Actualizar fecha de aplicación de TODOS los trabajadores de la modalidad presencial",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Actualizar!",
			cancelButtonText: "Cancelar!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
			function (isConfirm) {
				if (isConfirm) {
					// cerrar msj confirmacion
					swal.close();

					// enviar datos
					// $('#form_proyectoequipos').ajaxForm({
					// 	dataType: 'json',
					// 	type: 'POST',
					// 	url: '/proyectoequipos',
					// 	data: {
					// 		proyecto_id: proyecto_id,
					// 		opcion: 0,
					// 	},
					// 	resetForm: false,
					// 	success: function(dato){

					// 		// mensaje
					// 		swal({
					// 			title: "Correcto",
					// 			text: ""+dato.msj,
					// 			type: "success", // warning, error, success, info
					// 			buttons: {
					// 				visible: false, // true , false
					// 			},
					// 			timer: 1500,
					// 			showConfirmButton: false
					// 		});

					// 		// actualiza boton
					// 		$('#boton_guardar_proyectoequipos').html('Guardar <i class="fa fa-save"></i>');
					// 	},
					// 	beforeSend: function(){
					// 		$('#boton_guardar_proyectoequipos').html('Guardando <i class="fa fa-spin fa-spinner"></i>');
					// 	},
					// 	error: function(dato) {
					// 		// actualiza boton
					// 		$('#boton_guardar_proyectoequipos').html('Guardar <i class="fa fa-save"></i>');

					// 		// mensaje
					// 		swal({
					// 			title: "Error",
					// 			text: ""+dato.msj,
					// 			type: "error", // warning, error, success, info
					// 			buttons: {
					// 				visible: false, // true , false
					// 			},
					// 			timer: 1500,
					// 			showConfirmButton: false
					// 		});
					// 		return false;
					// 	}
					// }).submit();
					return false;
				}
				else {
					// mensaje
					swal({
						title: "Cancelado",
						text: "Acción cancelada",
						type: "error", // warning, error, success, info
						buttons: {
							visible: false, // true , false
						},
						timer: 500,
						showConfirmButton: false
					});
				}
			});
		return false;
	}
});

$("#botonenviar_todos_correos").click(function () {
	swal({
		title: "¡Confirme que desea enviar correos!",
		text: "Enviar correos a todos los trabajadores",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#db6f02",
		confirmButtonText: "Enviar!",
		cancelButtonText: "Cancelar!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				// cerrar msj confirmacion
				swal.close();

				// enviar datos
				// $('#form_proyectoequipos').ajaxForm({
				// 	dataType: 'json',
				// 	type: 'POST',
				// 	url: '/proyectoequipos',
				// 	data: {
				// 		proyecto_id: proyecto_id,
				// 		opcion: 0,
				// 	},
				// 	resetForm: false,
				// 	success: function(dato){

				// 		// mensaje
				// 		swal({
				// 			title: "Correcto",
				// 			text: ""+dato.msj,
				// 			type: "success", // warning, error, success, info
				// 			buttons: {
				// 				visible: false, // true , false
				// 			},
				// 			timer: 1500,
				// 			showConfirmButton: false
				// 		});

				// 		// actualiza boton
				// 		$('#boton_guardar_proyectoequipos').html('Guardar <i class="fa fa-save"></i>');
				// 	},
				// 	beforeSend: function(){
				// 		$('#boton_guardar_proyectoequipos').html('Guardando <i class="fa fa-spin fa-spinner"></i>');
				// 	},
				// 	error: function(dato) {
				// 		// actualiza boton
				// 		$('#boton_guardar_proyectoequipos').html('Guardar <i class="fa fa-save"></i>');

				// 		// mensaje
				// 		swal({
				// 			title: "Error",
				// 			text: ""+dato.msj,
				// 			type: "error", // warning, error, success, info
				// 			buttons: {
				// 				visible: false, // true , false
				// 			},
				// 			timer: 1500,
				// 			showConfirmButton: false
				// 		});
				// 		return false;
				// 	}
				// }).submit();
				return false;
			}
			else {
				// mensaje
				swal({
					title: "Cancelado",
					text: "Acción cancelada",
					type: "error", // warning, error, success, info
					buttons: {
						visible: false, // true , false
					},
					timer: 500,
					showConfirmButton: false
				});
			}
		});
	return false;
});


//======================================FUNCIONES=================================================//

function oculta_menustab_principal() {
	$("#tab_info_ejecucion").css('display', 'none');
	$("#tab_evidencias_ejecucion").css('display', 'none');
}

function muestra_menustab_principal() {
	$("#tab_info_ejecucion").css('display', 'block');
	$("#tab_evidencias_ejecucion").css('display', 'block');
}

function tabla_ejecucion() {
	try {
		var ruta = "/ejecucionPsicoTabla";

		if (datatable_ejecuciones != null) {
			datatable_ejecuciones.clear().draw();
			datatable_ejecuciones.ajax.url(ruta).load();
		}
		else {
			var numeroejecucion = 1;
			datatable_ejecuciones = $('#tabla_ejecucion').DataTable({
				"ajax": {
					"url": ruta,
					"type": "get",
					"cache": false,
					error: function (xhr, error, code) {
						// console.log(xhr); console.log(code);

						console.log('error en datatable_ejecuciones');
						if (numeroejecucion <= 1) {
							tabla_ejecucion();
							numeroejecucion += 1;
						}
					},
					"data": {}
				},
				"columns": [
					// {
					//     "data": "id" 
					// },
					{
						"data": "COUNT",
						"defaultContent": "-"
					},
					{
						"data": "FOLIO",
						"defaultContent": "-"
					},
					{
						"data": "instalacion_y_direccion",
						"defaultContent": "-"
					},
					{
						"data": "FECHA_INICIO",
						"defaultContent": "-"
					},
					{
						"data": "FECHA_FIN",
						"defaultContent": "-"
					},
					{
						"orderable": false,
						"data": 'boton_mostrar',
						"defaultContent": '-'
					}
				],
				"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todos"]],
				// "rowsGroup": [0, 1], //agrupar filas
				"order": [[0, "DESC"]],
				"ordering": true,
				"processing": true,
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
						"last": "Ultima",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				}
			});
		}

		// Tooltip en DataTable
		datatable_ejecuciones.on('draw', function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
	}
	catch (exception) {
		tabla_ejecucion()
	}
}

function tabla_trabajadores_online() {
	try {
		if (datatable_trabajadores_online != null) {
			datatable_trabajadores_online.destroy();
			//datatable_trabajadores_online.clear().destroy();
			//datatable_trabajadores_online.ajax.url(ruta).load();
		}
		datatable_trabajadores_online = $('#tabla_trabajadores_online').DataTable({
			"ajax": {
				"url": "/trabajadoresOnlineEjecucionPsico/" + proyecto_id,
				"type": "get",
				"cache": false,
				"error": function (xhr, error, code) {
					console.log('error en tabla_trabajadores_online');
				},
				"data": {}
			},
			"columns": [
				{
					"data": "COUNT",
					"defaultContent": "-"
				},
				{
					"data": "TRABAJADOR_NOMBRE",
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<div data-trabajador-nombre="' + data + '">' + data + '</div>';
						}
						return data;
					}
				},
				{
					"data": "FECHAINICIO",
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<div class="input-group">' +
								'<input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAINICIO[]" value="' + data + '">' +
								'<span class="input-group-addon"><i class="icon-calender"></i></span>' +
								'</div>';
						}
						return data;
					}
				},
				{
					"data": "FECHAFIN",
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<div class="input-group">' +
								'<input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAFIN[]" value="' + data + '">' +
								'<span class="input-group-addon"><i class="icon-calender"></i></span>' +
								'</div>';
						}
						return data;
					}
				},
				{
					"data": "TRABAJADOR_CORREO",
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<div class="input-group">' +
								'<input type="text" class="form-control " name="CORREO_TRABAJADOR[]" value="' + data + '">' +
								'</div>';
						}
						return data;
					}
				},
				{
					"data": "TRABAJADOR_ESTADOCORREO",
					"defaultContent": "-",
				},
				{
					"data": "TRABAJADOR_ESTADOCONTESTADO",
					"defaultContent": "-"
				},
				{
					"orderable": false,
					"data": 'boton_enviarCorreo',
					"defaultContent": '-'
				},
				{
					"orderable": false,
					"data": 'boton_guardarCambios',
					"defaultContent": '-'
				},
				{
					"data": "TRABAJADOR_ID",
					"visible": false,
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<input type="hidden" name="TRABAJADOR_ID[]" value="' + data + '">';
						}
						return data;
					}
				}
			],
			"drawCallback": function (settings) {
				$('.mydatepicker').datepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
					todayHighlight: true
				});
			},
			"lengthMenu": [[10, 50, -1], [10, 50, 100, "Todos"]],
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

		datatable_trabajadores_online.on('draw', function () {
			$('[data-toggle="tooltip"]').tooltip();
		});

	}
	catch (exception) {
		console.error("Error en tabla_trabajadores_psico:", exception);
	}
}



function cargarTrabajadoresNombres(elementId) {
	const selectElement = document.getElementById(elementId);
	if (!selectElement) {
		console.error('Error en consultar los datos');
		return;
	}

	selectElement.innerHTML = '';

	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/ejecuciontrabajadoresnombres",
		data: {},
		cache: false,
		success: function (data) {

			data.forEach(trabajador => {
				const option = document.createElement('option');
				option.value = trabajador.ID_RECOPSICOTRABAJADOR;
				option.textContent = trabajador.RECPSICOTRABAJADOR_NOMBRE;
				selectElement.appendChild(option);
			});

			$(selectElement).selectize({
				create: false,
				sortField: 'text',
				placeholder: 'Seleccione un trabajador'
			});
		},
		beforeSend: function () {
			selectElement.innerHTML = '<option value="" disabled selected>Consultando trabajadores...</option>';
		},
		error: function (error) {
			console.error('Error:', error.responseText);
		}
	});
}

function enviarCorreo(trabajadorId, idRecsensorial) {
	//envio único
	let tipo = 0;

	let url = `/envioGuia/${tipo}/${trabajadorId}/${idRecsensorial}`;

	$.ajax({
		url: url,
		method: 'GET',
		success: function (response) {
			if (response.msj) {
				swal({
					title: "¡Envío exitoso!",
					text: "" + response.msj,
					type: "success", // warning, error, success, info
					buttons: {
						visible: false, // true , false
					},
					timer: 1500,
					showConfirmButton: false
				});
				tabla_trabajadores_online();
			} else {
				swal({
					title: "Error",
					text: "" + response.msj,
					type: "error", // warning, error, success, info
					buttons: {
						visible: false, // true , false
					},
					timer: 1500,
					showConfirmButton: false
				});
			}

		},
		beforeSend: function () {
			swal({
				title: "Espere un momento...",
				text: "Enviando correo",
				type: "info", // warning, error, success, info
				buttons: {
					visible: false, // true , false
				},
				showConfirmButton: false
			});
		},
		error: function (xhr, status, error) {
			swal({
				title: "Error",
				text: "" + response.msj,
				type: "error", // warning, error, success, info
				buttons: {
					visible: false, // true , false
				},
				timer: 1500,
				showConfirmButton: false
			});
		}
	});
}

function guardarCambios(trabajadorId, idRecsensorial) {
	let botonGuardar = $('#guardarCambiosTrabajador' + trabajadorId);
	botonGuardar.prop('disabled', true);
    botonGuardar.html('<i class="fa fa-spinner fa-spin"></i>');
	//envio único
	swal({
		title: "¡Confirme que desea guardar!",
		text: "Guardar cambios del trabajador",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Guardar!",
		cancelButtonText: "Cancelar!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
		function (isConfirm) {
			if (isConfirm) {
				// cerrar msj confirmacion
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('#csrf-token').text() 
					}
				});
				swal.close();
				let datosEnviar = {};
				let table = $('#tabla_trabajadores_online').DataTable();
				let rowNode = table.row(function (idx, data, node) {
					return data.TRABAJADOR_ID === trabajadorId;
				}).node();

				if (rowNode) {
					let fechaInicio = $(rowNode).find('input[name="FECHAINICIO[]"]').val();
					let fechaFin = $(rowNode).find('input[name="FECHAFIN[]"]').val();
					let correoTrabajador = $(rowNode).find('input[name="CORREO_TRABAJADOR[]"]').val();

					datosEnviar = {
						trabajadorId: trabajadorId,
						fechaInicio: fechaInicio,
						fechaFin: fechaFin,
						trabajadorCorreo: correoTrabajador,
						idRecsensorial: idRecsensorial
					};


					let url = `/guardarCambiosTrabajador`;

					$.ajax({
						url: url,
						method: 'PUT',
						dataType: 'json',
						data: {
							datos: JSON.stringify(datosEnviar)
						},
						success: function (response) {
							if (response.msj) {
								swal({
									title: "¡Correcto!",
									text: "" + response.msj,
									type: "success",
									buttons: {
										visible: false,
									},
									timer: 1500,
									showConfirmButton: false
								});
							} else {
								swal({
									title: "Error",
									text: "Error al guardar.",
									type: "error",
									buttons: {
										visible: false,
									},
									timer: 1500,
									showConfirmButton: false
								});
							}
						},
						beforeSend: function () {
							botonGuardar.prop('disabled', true);
                        	botonGuardar.html('<i class="fa fa-spinner fa-spin"></i>');
						},
						complete: function () {
							botonGuardar.prop('disabled', false);
							botonGuardar.html('<i class="fa fa-save"></i>');
						},
						error: function (xhr, status, error) {
							swal({
								title: "Error",
								text: "Hubo un problema al guardar los datos: " + xhr.responseText,
								type: "error",
								buttons: {
									visible: false,
								},
								timer: 1500,
								showConfirmButton: false
							});
							botonGuardar.prop('disabled', false);
                        	botonGuardar.html('<i class="fa fa-save"></i>');
						}
					});

				} else {
					console.error("No se encontró la fila con TRABAJADOR_ID:", trabajadorId);
				}
			}
			else {
				// mensaje
				swal({
					title: "Cancelado",
					text: "Acción cancelada",
					type: "error", // warning, error, success, info
					buttons: {
						visible: false, // true , false
					},
					timer: 500,
					showConfirmButton: false
				});
				botonGuardar.prop('disabled', false);
            	botonGuardar.html('<i class="fa fa-save"></i>');
			}
		});

}

function consulta_evidencia_fotos(proyecto_id)
{
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/psicoevidenciafotosonline/"+proyecto_id,
		data:{},
		cache: false,
		success:function(dato)
		{
			$('#evidencia_galeria_fotos_online').html('');

			if (parseInt(dato.fotos_total) > 0)
			{
				$("#evidencia_galeria_fotos_online").html(dato.fotos);
				$('#tabmenu_evidencia_2').addClass('active');
				$('#tab_evidencia_2').addClass('active show');	
			}
			else
			{
				$('#evidencia_galeria_fotos_online').html('<div class="col-12" style="text-align: center;">No hay fotos que mostrar</div>');
			}

			$('[data-toggle="tooltip"]').tooltip();
		},
		beforeSend: function(){
			$('#evidencia_galeria_fotos_online').html('<div class="col-12" style="text-align: center;"><i class="fa fa-spin fa-spinner fa-5x"></i></div>');
		},
		error: function(dato){			
			$('#evidencia_galeria_fotos_online').html('<div class="col-12" style="text-align: center;">Error al cargar las fotos</div>');
			return false;
		}
	});//Fin ajax
}






$("#boton_enviarcorreomasivo").click(function () {

    let tipo = 1;

    let url = `/envioGuia/${tipo}/0/${proyecto_id}`;

    $.ajax({
        url: url,
        method: 'GET',

        success: function (response) {

            swal({
                title: "¡Envío exitoso!",
                text: response.msj,
                type: "success",
                buttons: {
                    visible: false,
                },
                timer: 1500,
                showConfirmButton: false
            });

            tabla_trabajadores_online();
        },

        beforeSend: function () {

            swal({
                title: "Espere un momento...",
                text: "Enviando correos",
                type: "info",
                buttons: {
                    visible: false,
                },
                showConfirmButton: false
            });

        },

        error: function (xhr) {

            swal({
                title: "Error",
                text: xhr.responseJSON.msj,
                type: "error",
                buttons: {
                    visible: false,
                },
                timer: 1500,
                showConfirmButton: false
            });

        }
    });

});



////// EVALUACION CONTESTAR

function tabla_trabajadores_presencial() {
	try {
		if (datatable_trabajadores_presencial != null) {
			datatable_trabajadores_presencial.destroy();
		}
		datatable_trabajadores_presencial = $('#tabla_trabajadores_presencial').DataTable({
			"ajax": {
				"url": "/trabajadoresPresencialEjecucionPsico/" + proyecto_id,
				"type": "get",
				"cache": false,
				"error": function (xhr, error, code) {
					console.log('error en tabla_trabajadores_online');
				},
				"data": {}
			},
			"columns": [
				{
					"data": "COUNT",
					"defaultContent": "-"
				},
				{
					"data": "NOMBRE",
					"defaultContent": "-"
				},
				{
					"data": "BTN_EDITAR",
					"defaultContent": "-"
				},
				{
					"data": "TRABAJADOR_ID",
					"visible": false,
					"defaultContent": "-",
					"render": function (data, type, row) {
						if (type === 'display') {
							return '<input type="hidden" name="TRABAJADOR_ID[]" value="' + data + '">';
						}
						return data;
					}
				},
				{
					"data": "RECPSICO_ID",
					"visible": false,
					"defaultContent": "-"
				},
			],
			"drawCallback": function (settings) {
				$('.mydatepicker').datepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
					todayHighlight: true
				});
			},
			"lengthMenu": [[10, 50, -1], [10, 50, 100, "Todos"]],
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

		datatable_trabajadores_presencial.on('draw', function () {
			$('[data-toggle="tooltip"]').tooltip();
		});


	}
	catch (exception) {
		console.error("Error en tabla_trabajadores_presencial:", exception);
	}
}


function validarPregunta() {

    const divPreguntas = $('.divPreguntas');

    for (let pregunta of divPreguntas) {

        if (!$(pregunta).is(':visible')) {
            continue;
        }

        const divActual = $(pregunta);
        const opciones = pregunta.querySelectorAll('input[type="radio"]');

        let contestado = false;

        for (let opcion of opciones) {

            if (opcion.checked) {
                contestado = true;
                break;
            }
        }

        if (!contestado) {

            divActual.css('border', '2px solid red');

            opciones.forEach(opcion => {
                opcion.onchange = function () {
                    divActual.css('border', 'none');
                };
            });

            return [false, pregunta];
        }

        divActual.css('border', 'none');
    }

    return [true, ''];
}


function botonradio(radioClass) {
    const radios = document.querySelectorAll(`.${radioClass}`);

    radios.forEach((radio) => {
        radio.addEventListener('change', function () {
            const radiosWithSameName = document.querySelectorAll(`input[name="${this.name}"]`);

            radiosWithSameName.forEach(radio => {
                const label = document.querySelector(`label[for="${radio.id}"]`);
                label.classList.remove('selected');
            });

            const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
            selectedLabel.classList.add('selected');
        });
    });
}

function mostrarGuias(requiereGuia1, requiereGuia2, requiereGuia3) {

    const guia1 = document.getElementById('guia1');
    if (requiereGuia1 === 1) {
        guia1.style.display = 'block';
    } else {
        guia1.style.display = 'none';
    }


    const guia2 = document.getElementById('guia2');
    if (requiereGuia2 === 1) {
        guia2.style.display = 'block';
        $('.guia2').addClass('divPreguntas');
    } else {
        guia2.style.display = 'none';
        $('.guia2').removeClass('divPreguntas');
    }

    const guia3 = document.getElementById('guia3');
    if (requiereGuia3 === 1) {
        guia3.style.display = 'block';
        $('.guia3').addClass('divPreguntas');
    } else {
        guia3.style.display = 'none';
        $('.guia3').removeClass('divPreguntas');
    }
}

function guia1() {
    const pregunta1Si = document.getElementById("pregunta1_si").checked;
    const pregunta1No = document.getElementById("pregunta1_no").checked;

    if (pregunta1Si) {
        document.getElementById("seccion2").style.display = "block";
        document.getElementById("seccion3").style.display = "block";
        document.getElementById("seccion4").style.display = "block";
        $('.ocultas').addClass('divPreguntas');

    } else {
        document.getElementById("seccion2").style.display = "none";
        document.getElementById("seccion3").style.display = "none";
        document.getElementById("seccion4").style.display = "none";
        $('.ocultas').removeClass('divPreguntas');
        const radiosSecciones = document.querySelectorAll('#seccion2 input[type="radio"], #seccion3 input[type="radio"], #seccion4 input[type="radio"]');
        radiosSecciones.forEach(function (radio) {
            radio.checked = false;
        });
    }
}

function clientesyusuarios() {
    const siSeleccionado = document.getElementById("preguntaadi1_si").checked;

    if (siSeleccionado) {
        document.getElementById("seccion2_2").style.display = "block";
        $('.ocultas2_1').addClass('divPreguntas');
    } else {
        document.getElementById("seccion2_2").style.display = "none";
        $('.ocultas2_1').removeClass('divPreguntas');
        const inputsSeccion = document.querySelectorAll('#seccion2_2 input[type="radio"]');
        inputsSeccion.forEach(function (input) {
            if (input.type === "radio" || input.type === "checkbox") {
                input.checked = false;
            } else {
                input.value = "";
            }
        });
    }
}

function jefetrabajadores() {
    const sijefe = document.getElementById("preguntaadi2_si").checked;

    if (sijefe) {
        document.getElementById("seccion4_2").style.display = "block";
        $('.ocultas2_2').addClass('divPreguntas');
    } else {
        document.getElementById("seccion4_2").style.display = "none";
        $('.ocultas2_2').removeClass('divPreguntas');
        const seccion4guia2 = document.querySelectorAll('#seccion4_2 input[type="radio"]');
        seccion4guia2.forEach(function (input) {
            if (input.type === "radio" || input.type === "checkbox") {
                input.checked = false;
            } else {
                input.value = "";
            }
        });
    }
}

function clientesyusuariosguia3() {
    const siSeleccionadoguia3 = document.getElementById("preguntaadi1_3si").checked;

    if (siSeleccionadoguia3) {
        document.getElementById("seccion2_3").style.display = "block";
        $('.ocultas3_1').addClass('divPreguntas');
    } else {
        document.getElementById("seccion2_3").style.display = "none";
        $('.ocultas3_1').removeClass('divPreguntas');
        const inputsSeccionguia3 = document.querySelectorAll('#seccion2_3 input[type="radio"]');
        inputsSeccionguia3.forEach(function (input) {
            if (input.type === "radio" || input.type === "checkbox") {
                input.checked = false;
            } else {
                input.value = "";
            }
        });
    }
}

function jefetrabajadoresguia3() {
    const sijefeguia3 = document.getElementById("preguntaadi2_3si").checked;

    if (sijefeguia3) {
        document.getElementById("seccion4_3").style.display = "block";
        $('.ocultas3_2').addClass('divPreguntas');

    } else {
        document.getElementById("seccion4_3").style.display = "none";
        $('.ocultas3_2').removeClass('divPreguntas');

        const seccion4guia3 = document.querySelectorAll('#seccion4_3 input[type="radio"]');
        seccion4guia3.forEach(function (input) {
            if (input.type === "radio" || input.type === "checkbox") {
                input.checked = false;
            } else {
                input.value = "";
            }
        });
    }
}


$('#modal_evaluacion').on('hidden.bs.modal', function () {

	$('#titulo_modal_evaluacion').text('Nueva evaluación');

	    resetModalEvaluacion();

    $('#guia1').css('display', 'block');
    $('#guia2').css('display', 'block');
    $('#guia3').css('display', 'block');

    $('.guia2').addClass('divPreguntas');
    $('.guia3').addClass('divPreguntas');

});


$('#tabla_trabajadores_presencial tbody').on('click', 'td>button.editar', function () {

    var tr = $(this).closest('tr');
    var row = datatable_trabajadores_presencial.row(tr);

    $('#modal_evaluacion').modal({ backdrop: false });


	$('#titulo_modal_evaluacion').text(row.data().NOMBRE);

	
    botonradio('radio-group');

    console.log(row.data().TRABAJADOR_ID);
    console.log(proyecto_id);

    $.ajax({

        url: '/obtenerGuiasTrabajadorPresencial/' + proyecto_id + '/' + row.data().TRABAJADOR_ID,

        type: 'GET',
        dataType: 'json',
		success: function (response) {
			if (response.success) {

				$('#TRABAJADOR_ID').val(response.TRABAJADOR_ID);
				console.log('TRABAJADOR_ID:', response.TRABAJADOR_ID);
				console.log('GUIA I:', response.GUIA1);
				console.log('GUIA II:', response.GUIA2);
				console.log('GUIA III:', response.GUIA3);
				console.log('GUIA V:', response.GUIA5);

				mostrarGuias(
					response.GUIA1,
					response.GUIA2,
					response.GUIA3
				);


				resetModalEvaluacion();
				consultarRespuestasGuardadas(response.TRABAJADOR_ID);
			}
		},
        error: function (xhr) {
            console.log(xhr);
        }
    });




});





$('#guardar_guia3').on('click', function (e) {

    e.preventDefault();
    document.getElementById("guardar_guia3").blur();

    $("#GUIAI_TRABAJADOR_ID").val($("#TRABAJADOR_ID").val());
    $("#GUIAI_ID_RECOPSICORESPUESTAS").val($("#ID_RECOPSICORESPUESTAS").val());

    $("#GUIAIII_TRABAJADOR_ID").val($("#TRABAJADOR_ID").val());
    $("#GUIAIII_ID_RECOPSICORESPUESTAS").val($("#ID_RECOPSICORESPUESTAS").val());

    $("#GUIAV_TRABAJADOR_ID").val($("#TRABAJADOR_ID").val());

    var form1Data = new FormData(document.getElementById('guia_1'));
    form1Data.append('option', 1);

    Swal.fire({
        title: "¿Desea guardar sus respuestas?",
        icon: "question",
        width: "700px",
        showDenyButton: true,
        showCancelButton: true,
        denyButtonColor: "#5F9EA0",
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: "Guardar y finalizar",
        denyButtonText: "Guardar y continuar más tarde",
        cancelButtonText: "Cancelar",
    }).then((result) => {


        if (result.isConfirmed) {

            swal.close();

            form1Data.append('tipoGuardado', 1);

            const [validado, div] = validarPregunta();

            if (!validado) {

                Swal.fire({
                    title: "Advertencia",
                    text: "Por favor, completa todas las preguntas antes de enviar.",
                    icon: "warning",
                    confirmButtonText: "Aceptar"
                });

                div.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

                return;
            }

            var form2Data = new FormData(document.getElementById('guia_3'));
            form2Data.append('option', 3);
            form2Data.append('tipoGuardado', 1);

            $.ajax({

                url: '/guardarGuiasPsico',
                type: 'POST',
                data: form1Data,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    $('#guardar_guia3').html('Guardando <i class="fa fa-spin fa-spinner"></i>');
                },

                success: function () {

                    $.ajax({

                        url: '/guardarGuiasPsico',
                        type: 'POST',
                        data: form2Data,
                        processData: false,
                        contentType: false,

                        success: function () {

                            Swal.fire({
                                title: "Guardado correctamente",
                                text: "La evaluación ha sido finalizada.",
                                icon: "success"
                            }).then(function () {

                                $('#modal_evaluacion').modal('hide');

                                tabla_trabajadores_presencial();

                            });

                        },

                        complete: function () {
                            $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');
                        },

                        error: function (jqXHR, textStatus, errorThrown) {

                            console.error('Error en Guia 3:', textStatus, errorThrown);

                            $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');
                        }

                    });

                },

                error: function (jqXHR, textStatus, errorThrown) {

                    console.error('Error en Guia 1:', textStatus, errorThrown);

                    $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');
                }

            });

        }

        else if (result.isDenied) {

            swal.close();

            form1Data.append('tipoGuardado', 2);

            $.ajax({

                url: '/guardarGuiasPsico',
                type: 'POST',
                data: form1Data,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    $('#guardar_guia3').html('Guardando <i class="fa fa-spin fa-spinner"></i>');
                },

                success: function () {

                    var form2Data = new FormData(document.getElementById('guia_3'));

                    form2Data.append('option', 3);
                    form2Data.append('tipoGuardado', 2);

                    $.ajax({

                        url: '/guardarGuiasPsico',
                        type: 'POST',
                        data: form2Data,
                        processData: false,
                        contentType: false,

                        success: function () {

                            Swal.fire(
                                "Guardado",
                                "Las respuestas fueron guardadas correctamente.",
                                "success"
                            );

                            $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');

                        },

                        error: function (jqXHR, textStatus, errorThrown) {

                            console.error('Error en Guia 3:', textStatus, errorThrown);

                            $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');
                        }

                    });

                },

                error: function (jqXHR, textStatus, errorThrown) {

                    console.error('Error en Guia 1:', textStatus, errorThrown);

                    $('#guardar_guia3').html('Guardar <i class="fa fa-save"></i>');
                }
            });
        }
    });
});




function consultarRespuestasGuardadas(idTrabajador) {

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        type: "POST",
        url: "/consultarRespuestasGuardadasPresencial",
        dataType: "json",
        data: {
            id_trabajador: idTrabajador,
            _token: csrfToken
        },
        success: function (data) {

            if (data) {

                // ===========================
                // GUIA I
                // ===========================
                if (data.RECPSICO_GUIAI_RESPUESTAS) {

                    const respuestasGuiaIArray = JSON.parse(data.RECPSICO_GUIAI_RESPUESTAS);

                    respuestasGuiaIArray.forEach((respuesta, index) => {

                        if (respuesta !== null) {

                            const preguntaDiv = document.getElementById(`pregunta${index + 1}_1`);

                            if (preguntaDiv) {

                                const radioInput = preguntaDiv.querySelector(`input[type="radio"][value="${respuesta}"]`);

                                if (radioInput) {
                                    radioInput.checked = true;
                                }

                            }

                        }

                    });

                    guia1();

                }


                if (data.RECPSICO_GUIAIII_RESPUESTAS) {

                    const respuestasGuiaIIIArray = JSON.parse(data.RECPSICO_GUIAIII_RESPUESTAS);

                    respuestasGuiaIIIArray.forEach((respuesta, index) => {

                        if (respuesta !== null) {

                            const preguntaDiv3 = document.getElementById(`pregunta${index + 1}_3`);

                            if (preguntaDiv3) {

                                const radioInput3 = preguntaDiv3.querySelector(`input[type="radio"][value="${respuesta}"]`);

                                if (radioInput3) {

                                    radioInput3.checked = true;

                                    const label3 = preguntaDiv3.querySelector(`label[for="${radioInput3.id}"]`);

                                    if (label3) {
                                        label3.classList.add('selected');
                                    }
                                }
                            }
                        }
                    });
                    clientesyusuariosguia3();
                    jefetrabajadoresguia3();
                }
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


function resetModalEvaluacion() {

    $('#seccion2_2').show();
    $('#seccion4_2').show();
    $('#seccion2_3').show();
    $('#seccion4_3').show();

    $('.ocultas2_1').addClass('divPreguntas');
    $('.ocultas2_2').addClass('divPreguntas');
    $('.ocultas3_1').addClass('divPreguntas');
	$('.ocultas3_2').addClass('divPreguntas');
	
    $('#modal_evaluacion input[type="radio"]').prop('checked', false);
	$('#modal_evaluacion label').removeClass('selected');
	$('#modal_evaluacion .divPreguntas').css('border', 'none');


}



////// DESCARGAR PLANTILLAS DE INFORMES


$('#modal_cargarRespuestasTrabajadores').on('hidden.bs.modal', function () {

	$("#tipoGuia").val("");
	$("#excelRespuestasTrabajadores").val("");
	$("#input_file_excel_documento_trabajadores .fileinput-filename").html("");
	$('.fileinput').removeClass('fileinput-exists').addClass('fileinput-new');
	
});


$('#btnPlantilla12').on('click', function () {
    window.location.href = '/mostrarplantillaguia1y2';
});


$('#btnPlantilla13').on('click', function () {
    window.location.href = '/mostrarplantillaguia1y3';
});


$('#tipoGuia').on('change', function () {

    $('#btnPlantilla12').hide();
    $('#btnPlantilla13').hide();

    if ($(this).val() == '12') {
        $('#btnPlantilla12').show();
    }

    if ($(this).val() == '13') {
        $('#btnPlantilla13').show();
    }

});


$("#form_cargaRespuestasTrabajadores").submit(function (e) {

    e.preventDefault();

    var valida = this.checkValidity();

    if (!valida) {
        this.reportValidity();
        return;
    }
    var formData = new FormData(this);

    formData.append("proyecto_id", proyecto_id);
    $.ajax({

        url: "/importarRespuestasTrabajadores",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {

            $("#boton_cargarTrabajadores")
                .html('Guardando <i class="fa fa-spin fa-spinner"></i>')
                .prop("disabled", true);

        },

        success: function (response) {

            let mensaje = response.mensaje;

            if (response.guardados) {
                mensaje += "<br><br><b>Trabajadores guardados:</b> " + response.guardados;
            }
            if (response.errores.length > 0) {
                mensaje += "<br><br><b>No encontrados:</b><br>";
                response.errores.forEach(function (error) {
                    mensaje += error + "<br>";
                });
            }

            Swal.fire({
                title: "Proceso terminado",
                html: mensaje,
                icon: "success"

            });

            $("#boton_cargarTrabajadores")
                .html('Guardar <i class="fa fa-save"></i>')
                .prop("disabled", false);

            $("#modal_cargarRespuestasTrabajadores").modal("hide");

            $("#form_cargaRespuestasTrabajadores")[0].reset();

        },
       error: function (xhr) {

				console.log(xhr.responseJSON);

				Swal.fire({
					title: "Error",
					text: xhr.responseJSON.error,
					icon: "error"
				});

				$("#boton_cargarTrabajadores")
					.html('Guardar <i class="fa fa-save"></i>')
					.prop("disabled", false);
			}
    });
});


//// CARGAR EVIDENCIAS FOTOGRAFICAS


$("#boton_nuevo_fotosevidencia").click(function (e) {
    e.preventDefault();

    ID_FOTOS_EJECUCION = 0;
       
    $('#form_evidencia_fotos').each(function(){
        this.reset();
    });

    $("#modal_evidencia_fotos").modal("show");

});




$("#boton_guardar_evidencia_fotos").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#form_evidencia_fotos'))

    if (formularioValido) {

    if (ID_FOTOS_EJECUCION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_evidencia_fotos')
            await ajaxAwaitFormData({ api: 1,PROYECTO_ID: proyecto_id, ID_FOTOS_EJECUCION: ID_FOTOS_EJECUCION }, 'ejecucionPsicosocial', 'form_evidencia_fotos', 'boton_guardar_evidencia_fotos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_FOTOS_EJECUCION = data.fotos.ID_FOTOS_EJECUCION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modal_evidencia_fotos').modal('hide')
                    document.getElementById('form_evidencia_fotos').reset();
                    cargarevidenciafotos();                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_evidencia_fotos')
            await ajaxAwaitFormData({ api: 1, PROYECTO_ID: proyecto_id, ID_FOTOS_EJECUCION: ID_FOTOS_EJECUCION }, 'ejecucionPsicosocial', 'form_evidencia_fotos', 'boton_guardar_evidencia_fotos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FOTOS_EJECUCION = data.fotos.ID_FOTOS_EJECUCION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modal_evidencia_fotos').modal('hide')
                    document.getElementById('form_evidencia_fotos').reset();
                    cargarevidenciafotos();

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




function cargarevidenciafotos(){

    $.ajax({

        url:'/evidenciafotospsico/'+ proyecto_id,
        type:'GET',
        dataType:'json',

        beforeSend:function(){

            $('#galeria_fotos').html(
                '<div class="col-12 text-center">'+
                '<i class="fa fa-spinner fa-spin fa-4x"></i>'+
                '</div>'
            );

        },

        success:function(resp){

            if(resp.fotos_total > 0){

                $('#galeria_fotos').html(resp.fotos);

                $('#galeria_fotos').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    removalDelay: 300,
                    mainClass: 'mfp-3d-unfold'
                });

            }else{

                $('#galeria_fotos').html(
                    '<div class="col-12 text-center">No hay imágenes</div>'
                );

            }

            $('[data-toggle="tooltip"]').tooltip();

}

    });

}




function eliminarPlano(id) {

    alertMensajeConfirm({
        title: "¿Desea eliminar esta imagen?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning"
    }, async function () {

        $.ajax({
            type: "POST",
            url: "/ejecucionPsicosocial",
            data: {
                _token: $('input[name="_token"]').val(),
                api: 1,
                ELIMINAR: 1,
                ID_FOTOS_EJECUCION: id
            },
            dataType: "json",
            success: function (data) {

                if (data.code == 1) {

                    alertMensaje(
                        'success',
                        'Imagen eliminada correctamente',
                        'La imagen fue eliminada'
                    );

                    cargarevidenciafotos();
                    totalPlanosErgo();

                } else {

                    alertMensaje(
                        'error',
                        'Error',
                        'No fue posible eliminar la imagen'
                    );

                }

            },
            error: function () {

                alertMensaje(
                    'error',
                    'Error',
                    'Ocurrió un error al eliminar la imagen'
                );

            }

        });

    }, 1);

}

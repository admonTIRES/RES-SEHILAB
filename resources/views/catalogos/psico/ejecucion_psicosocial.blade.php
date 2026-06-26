@extends('template/maestra')
@section('contenido')




<style type="text/css" media="screen">
    table th {
        font-size: 12px !important;
        color: #777777 !important;
        font-weight: 600 !important;
    }

    table td {
        font-size: 12px !important;
    }

    table td i {
        font-size: 20px !important;
        margin: -1px 0px 0px 0px;
    }

    table td b {
        font-weight: 600 !important;
    }

    form label {
        color: #999999;
    }

    table td i {
        font-size: 20px !important;
        margin: -1px 0px 0px 0px;
    }

    h4 b {
        color: #0BACDB;
    }

    /*Tabla asignar proveedores*/

    .round {
        width: 42px;
        height: 42px;
        padding: 0px !important;
    }

    .round i {
        margin: 0px !important;
        font-size: 16px !important;
    }

    .badge-verde {
        background-color: green;
        color: white;
    }
</style>


<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card mt-4">
            <!-- Menu tabs -->
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab_1" role="tab" id="tab_tabla_ejecucion">
                        <span class="hidden-sm-up"><i class="ti-list"></i></span>
                        <span class="hidden-xs-down">Lista de Ejecuciones</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_2" role="tab" id="tab_info_ejecucion">
                        <span class="hidden-sm-up"><i class="ti-archive"></i></span>
                        <span class="hidden-xs-down">Aplicación de NOM-035-STPS-2018</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_3" role="tab" id="tab_evidencias_ejecucion">
                        <span class="hidden-sm-up"><i class="ti-archive"></i></span>
                        <span class="hidden-xs-down">Evidencia fotográfica</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane p-20 active" id="tab_1" role="tabpanel">
                    <div class="table-responsive">
                        <ol class="breadcrumb m-b-10">
                            <h2 style="color: #ffff; margin: 0;"><i class="fa fa-cogs"></i> Ejecuciones </h2>
                        </ol>
                        <table class="table table-hover stylish-table" id="tabla_ejecucion" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Folio Proyecto</th>
                                    <th width="600">Intalación / Dirrección</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th width="60">Mostrar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane p-20" id="tab_2" role="tabpanel">
                    <div class="card wizard-content" style="border: none; box-shadow: 0 0 0;">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body m-t-10" style="padding: 6px 10px">
                                        <table class="table" style="border: 0px #000 solid; margin: 0px;">
                                            <tbody>
                                                <tr>
                                                    <td width="40" style="text-align: center; border: none;">
                                                        <span class="btn btn-success btn-circle"><i class="fa fa-suitcase"></i></span>
                                                    </td>
                                                    <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                        <h4 style="margin: 0px;"><a class="text-success div_folio_proyecto">FOLIO PROYECTO</a></h4>
                                                        <small style="color: #AAAAAA; font-size: 12px;">Folio</small>
                                                    </td>
                                                    <td width="auto" style="text-align: right; border: none; vertical-align: middle;">
                                                        <h4 style="margin: 0px;"><a class="text-success div_folio_reconocimiento">FOLIO RECONOCIMIENTO</a></h4>
                                                        <small style="color: #AAAAAA; font-size: 12px;">Reconocimiento</small>
                                                    </td>
                                                    <td width="40" style="text-align: center; border: none;">
                                                        <span class="btn btn-success btn-circle"><i class="fa fa-eercast"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ============= STEPS ============= -->
                        <div style="min-width: 700px; width: 100% ; margin: 0px auto;">

                            <div class="row">
                                <div class="col-12">
                                    <ol class="breadcrumb m-b-10 p-t-10">
                                        <h2 style="color: #ffffff">
                                            <i class="fa fa-braille" aria-hidden="true"></i> Trabajadores modalidad online
                                        </h2>
                                    </ol>
                                    <div class="card">
                                        <div class="card-body m-t-10" style="padding: 10px;">
                                            <h3 style="color: #9C9C9C; text-align: center;">
                                                <i class="fa fa-calendar-o" aria-hidden="true"></i> Ajustar plazo de tiempo para presentar las GUIAS online
                                            </h3>
                                            <form enctype="multipart/form-data" method="POST" name="form_actualizarFechasOnline" id="form_actualizarFechasOnline">
                                                <input type="hidden" name="_method" value="PUT">
                                                {!! csrf_field() !!}
                                                <div class="form-group m-t-30 m-r-30 m-l-30" style="display: flex; align-items: center; gap: 30px; justify-content: center;">
                                                    <div style="display: flex; flex-direction: column; align-items: flex-start; max-width: 380px;">
                                                        <label for="fechaInicio" style="margin-bottom: 5px;">Fecha de inicio:</label>
                                                        <div style="display: flex; width: 100%;">
                                                            <input type="text" id="fechaInicio" name="fechaInicio" class="form-control mydatepicker" placeholder="aaaa-mm-dd"
                                                                style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; border-right: none; max-width: 280px;" required>
                                                            <span class="input-group-addon" style="display: flex; align-items: center; padding: 0 10px; background-color: #f8f9fa; border: 1px solid #ced4da; border-left: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                                <i class="icon-calender"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div style="display: flex; flex-direction: column; align-items: flex-start; max-width: 380px;">
                                                        <label for="fechaFin" style="margin-bottom: 5px;">Fecha de finalización:</label>
                                                        <div style="display: flex; width: 100%;">
                                                            <input type="text" id="fechaFin" name="fechaFin" class="form-control mydatepicker" placeholder="aaaa-mm-dd"
                                                                style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; border-right: none; max-width: 280px;" required>
                                                            <span class="input-group-addon" style="display: flex; align-items: center; padding: 0 10px; background-color: #f8f9fa; border: 1px solid #ced4da; border-left: none; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                                <i class="icon-calender"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success botonactualizar_fechas_online" id="botonactualizar_fechas_online" style="margin-right: 10px; align-self: flex-end; margin-bottom: 5px;">
                                                        Actualizar fechas de TODOS los trabajadores <i class="fa fa-save"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--form panels-->
                            <div id="csrf-token" style="display: none;">{{ csrf_token() }}</div>
                            <div class="col-12" style="text-align: center;">

                                <button type="submit" class="btn btn-success" id="boton_enviarcorreomasivo" style="margin-right: 10px; align-self: flex-end; margin-bottom: 5px;">
                                    Envió masivo de correo <i class="fa fa-paper-plane"></i>
                                </button>



                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover stylish-table" width="100%" id="tabla_trabajadores_online">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">No. Orden</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Nombre completo del trabajador</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Fecha de inicio</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Fecha de fin</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Correo</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Estado del correo</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Estado de cuestionario</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Enviar link del cuestionario</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Guardar cambios</th>
                                                <th style="display: none;">TRABAJADOR_ID</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12" style="text-align: center;">
                            <hr>
                            <ol class="breadcrumb m-b-10 green-breadcrumb">
                                <h2 style="color: #ffff; margin: 0;"> <i class="fa fa-braille" aria-hidden="true"></i> Trabajadores modalidad presencial</h2>
                                <div style="display: flex; justify-content: flex-end;">
                                    <button type="submit" class="btn btn-light botocargar_respuestas_trabajadores" id="botocargar_respuestas_trabajadores" style="margin-right: 10px;">
                                        Cargar respuestas de todos los trabajadores <i class="fa fa-file-excel-o"></i>
                                    </button>
                                </div>
                            </ol>
                            <div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover stylish-table" width="100%" id="tabla_trabajadores_presencial">
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">No. Orden</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Nombre completo del trabajador</th>
                                                <th class="sorting_disabled text-center" rowspan="1" colspan="1">Evaluación</th>
                                                <th style="display: none;"></th>
                                                <th style="display: none;"></th>

                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane p-20" id="tab_3" role="tabpanel">
                    <div class="card wizard-content" style="border: none; box-shadow: 0 0 0;">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 6px 10px">
                                        <table class="table" style="border: 0px #000 solid; margin: 0px;">
                                            <tbody>
                                                <tr>
                                                    <td width="40" style="text-align: center; border: none;">
                                                        <span class="btn btn-success btn-circle"><i class="fa fa-suitcase"></i></span>
                                                    </td>
                                                    <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                        <h4 style="margin: 0px;"><a class="text-success div_folio_proyecto">FOLIO PROYECTO</a></h4>
                                                        <small style="color: #AAAAAA; font-size: 12px;">Folio</small>
                                                    </td>
                                                    <td width="auto" style="text-align: right; border: none; vertical-align: middle;">
                                                        <h4 style="margin: 0px;"><a class="text-success div_folio_reconocimiento">FOLIO RECONOCIMIENTO</a></h4>
                                                        <small style="color: #AAAAAA; font-size: 12px;">Reconocimiento</small>
                                                    </td>
                                                    <td width="40" style="text-align: center; border: none;">
                                                        <span class="btn btn-success btn-circle"><i class="fa fa-eercast"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ============= STEPS ============= -->
                        <div style="min-width: 700px; width: 100% ; margin: 0px auto;">

                            <!--form panels-->
                            <div class="row">
                                <div class="col-12">
                                    <ol class="breadcrumb m-b-10">
                                        <h2 style="color: #ffff; margin: 0;"> <i class="fa fa-info-circle" aria-hidden="true"></i> Evidencia fotogáfica</h2>
                                    </ol>

                                    <!-- DIV GENERAL -->
                                    <div class="row  mt-4">
                                        <div class="col-4">
                                            <div class="card">
                                                <div class="card-body bg-secondary" style="padding: 20px 20px 0px 20px;">
                                                    <h4 class="text-white card-title" style="line-height: 14px!important; margin: 0px; padding: 0px;">Informes y evidencias</h4>
                                                    <small style="color: #DDDDDD; font-size: 12px; margin: 0px; padding: 0px;">Información general</small>
                                                </div>
                                                <div class="card-body" style="border: 0px #f00 solid; min-height: 856px;">
                                                    <div class="vtabs" style="width: 100%!important;">
                                                        <ul class="nav nav-tabs tabs-vertical" role="tablist" style="border-right: none;" id="lista_menu_parametros_evidencia">
                                                            <li class="nav-item" style="border-bottom: 1px #F0F0F0 solid;">
                                                                <span class="nav-link menulista_evidencia active" style="margin: 2px 0px; padding: 8px; cursor: pointer;">
                                                                    • <b style="font-weight: bold; color: #000000;">Evidencias fotográficas</b>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="card">
                                                <div class="card-body bg-info">
                                                    <h4 class="text-white card-title" style="line-height: 18px!important; margin: 0px; padding: 0px;" id="evidencia_agente_titulo">Evidencias fotográficas</h4>
                                                </div>
                                                <!-- Tab panes -->
                                                <div id="seccion_proyectoevidencias">
                                                    <ul class="nav nav-tabs customtab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" id="tabmenu_evidencia_2" href="#tab_evidencia_2" role="tab">Fotos Online</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" id="tabmenu_evidencia_3" href="#tab_evidencia_3" role="tab">Fotos Presencial</a>
                                                        </li>
                                                    </ul>
                                                    <div id="image-popups">
                                                        <div class="tab-content" style="height: 800px; max-height: 800px!important; overflow-x: none; overflow-y: auto;">
                                                            <div class="tab-pane p-20" id="tab_evidencia_2" role="tabpanel">
                                                                <style type="text/css">
                                                                    #image-popups .foto_galeria:hover i {
                                                                        opacity: 1 !important;
                                                                        cursor: pointer;
                                                                    }
                                                                </style>
                                                                <div class="row" id="evidencia_galeria_fotos_online"></div>
                                                            </div>
                                                            <div class="tab-pane p-20" id="tab_evidencia_3" role="tabpanel">

                                                                <ol class="breadcrumb m-b-10">
                                                                    <button type="button" class="btn btn-secondary waves-effect waves-light botonnuevo_moduloproyecto" data-toggle="tooltip" title="Agregar fotos" id="boton_nuevo_fotosevidencia">
                                                                        <span class="btn-label"><i class="fa fa-plus"></i></span>Foto (s)
                                                                    </button>
                                                                </ol>

                                                                <style type="text/css">
                                                                    #image-popups .foto_galeria:hover i {
                                                                        opacity: 1 !important;
                                                                        cursor: pointer;
                                                                    }
                                                                </style>
                                                                <div class="row" id="evidencia_galeria_fotos_presencial"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!-- End Tab panes -->
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Inicio modales -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- MODAL-EVIDENCIA-FOTOS -->
<!-- ============================================================== -->
<style type="text/css" media="screen">
    #modal_evidencia_fotos .modal-body .form-group {
        margin: 0px 0px 12px 0px !important;
        padding: 0px !important;
    }

    #modal_evidencia_fotos .modal-body .form-group label {
        margin: 0px !important;
        padding: 0px 0px 3px 0px !important;
    }
</style>




<div id="modal_evidencia_fotos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 900px!important;">
        <form method="post" enctype="multipart/form-data" name="form_evidencia_fotos" id="form_evidencia_fotos">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Fotos evidencia</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            {!! csrf_field() !!}
                            <input type="hidden" class="form-control" id="evidenciafotos_id" name="evidenciafotos_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 divevidencia_seccion_fotoscarpeta">
                            <div class="form-group">
                                <label>Nombre del trabajador*</label>
                                <select class="custom-select form-control" id="trabajador_nombre_foto" name="trabajador_nombre_foto">
                                    <option value="" disabled selected>Seleccione un trabajador</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 divevidencia_seccion_fotoscarpeta">
                            <div class="form-group">
                                <label>Fotos (máximo 2) *</label>
                                <input type="file" multiple class="form-control" accept=".jpg, .jpeg, .png, .gif" placeholder="Maximo 20 fotos" id="inputevidenciafotosquimicos" name="inputevidenciafotosquimicos[]" onchange="valida_totalfotos_quimicos(this);" required>
                            </div>
                        </div>
                        <div class="col-12 divevidencia_seccion_fotoscarpeta">
                            <p style="text-align: justify;"><b style="color: #555555;">Nota:</b> Solo se pueden subir máximo 2 fotos por cada trabajador</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="display: none;" id="mensaje_cargando_fotos">
                            <p class="text-info" style="text-align: center; margin: 0px; padding: 0px;"><i class="fa fa-spin fa-spinner"></i> Cargando fotos, espere un momento por favor...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger botonguardar_moduloproyecto" id="boton_guardar_evidencia_fotos">
                        Guardar <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- ============================================================== -->
<!-- MODAL-EVIDENCIA-FOTOS -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- MODAL-EXCEL-RESPUESTAS -->
<!-- ============================================================== -->
<div id="modal_cargarRespuestasTrabajador" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" name="form_cargaRespuestasTrabajador" id="form_cargaRespuestasTrabajador">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Respuestas del trabajador</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" id="RECPSICO_ID_TRABAJADOR" name="RECPSICO_ID" value="0">
                            <input type="number" class="form-control" id="RECPSICOTRABAJADOR_ID" name="RECPSICOTRABAJADOR_ID" style="visibility: hidden;">
                            <div class="col-12" id="cargarRespuestasTrabajador_excel">
                            </div>
                            <div class="form-group">
                                <label> Cargar excel con respuestas del trabajador *</label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput" id="input_file_excel_documento_trabajador">
                                        <i class="fa fa-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-secondary btn-file">
                                        <span class="fileinput-new">Seleccione</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" accept=".xls,.xlsx" name="excelRespuestasTrabajador" id="excelRespuestasTrabajador" required>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">Quitar</a>
                                </div>
                            </div>
                            <div class="row mx-2 mb-2" id="alertaVerificacion" style="display:none">
                                <p class="text-danger"><i class="fa fa-info-circle" aria-hidden="true"></i> Por favor, asegúrese de que el excel contenga las respuestas correspondientes al trabajador seleccionado</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light" id="boton_cargarRespuestasTrabajadores">
                            Guardar <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- MODAL-EXCEL-RESPUESTAS -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- MODAL-EXCEL-RESPUESTAS-TODOS -->
<!-- ============================================================== -->
<div id="modal_cargarRespuestasTrabajadores" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" name="form_cargaRespuestasTrabajadores" id="form_cargaRespuestasTrabajadores">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Respuestas de los trabajadores</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" id="RECPSICO_ID_TRABAJADOR" name="RECPSICO_ID" value="0">
                            <div class="col-12" id="cargaRespuestasTrabajadores_excel">
                            </div>

                            <div class="form-group">
                                <label>Tipo de calificación *</label>
                                <select class="form-control" id="tipoGuia" name="tipoGuia" required>
                                    <option value="">Seleccione una opción...</option>
                                    <option value="12">Calificación Guía 1 y 2 NOM035</option>
                                    <option value="13">Calificación Guía 1 y 3 NOM035</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 text-center">

                                    <button type="button"
                                        class="btn btn-success"
                                        id="btnPlantilla12"
                                        style="display:none;">
                                        <i class="fa fa-download"></i>
                                        Descargar plantilla Guía 1 y 2
                                    </button>

                                    <button type="button"
                                        class="btn btn-success"
                                        id="btnPlantilla13"
                                        style="display:none;">
                                        <i class="fa fa-download"></i>
                                        Descargar plantilla Guía 1 y 3
                                    </button>

                                </div>
                            </div>

                            <div class="form-group">
                                <label> Cargar excel con respuestas de los trabajadores *</label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput" id="input_file_excel_documento_trabajadores">
                                        <i class="fa fa-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-secondary btn-file">
                                        <span class="fileinput-new">Seleccione</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input type="file" accept=".xls,.xlsx" name="excelRespuestasTrabajador" id="excelRespuestasTrabajadores" required>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">Quitar</a>
                                </div>
                            </div>
                            <div class="row mx-2 mb-2" id="alertaVerificacion" style="display:none">
                                <p class="text-danger"><i class="fa fa-info-circle" aria-hidden="true"></i> Por favor, asegúrese de que el excel contenga las respuestas correspondientes por cada trabajador</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light" id="boton_cargarRespuestasTrabajadores">
                            Guardar <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- MODAL-EXCEL-RESPUESTAS-TODOS -->
<!-- ============================================================== -->



<!-- ============================================================== -->
<!-- MODAL EVALUACION -->
<!-- ============================================================== -->


<style>
    /* VARIABLES DE COLORES USADAS*/
    :root {
        --azul-oscuro: #003d6b;
        --azul-cielo: #009bcf;
        --verde: #88bd23;
        --gris-claro: #f8f9fa;
        --gris-medio: #e9ecef;
        --negro: #1a1a1a;
        --blanco: #ffffff;
    }


    /* Estilos para las tarjetas/guías */
    #guia1,
    #guia2,
    #guia3 {
        border: 1px solid #e0e0e0;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        width: 100%;
        transition: all 0.3s ease;
        background: #fff;
    }

    #guia1:hover,
    #guia2:hover,
    #guia3:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para los radio sean color verde */
    input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid var(--negro);
        /* Color verde */
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        position: relative;
        margin-right: 8px;
    }

    input[type="radio"]:checked {
        background-color: var(--verde);
        /* Color verde cuando está seleccionado */
    }

    input[type="radio"]:checked::before {
        content: '';
        position: absolute;
        width: 5px;
        height: 6px;
        background-color: white;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }


    /* Mejorar los contenedores de las preguntas */
    [id^="pregunta"] {
        padding: 1rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    [id^="pregunta"]:hover {
        background-color: var(--gris-medio);
    }

    /* Estilos para los títulos */
    h3.card-title {
        color: var(--azul-oscuro);
        margin-bottom: 1.5rem;
        font-weight: 900;
    }

    h5.titulo-seccion {
        color: var(--azul-cielo);
        margin-bottom: 1rem;
        font-family: 'Arial', sans-serif;
        /* Puedes cambiarlo por una fuente diferente */
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid var(--verde);
        padding-bottom: 0.3rem;
    }

    /* ESTILO ESPECIFICO PARA LAS H6 FR GUIAS 1 2 Y 3 */

    .text-guia {
        font-size: 0.7rem;
        color: var(--blanco);
        text-transform: uppercase;
        font-weight: 680;
        letter-spacing: 1px;
        padding: 5px 20px;
        background: var(--verde);
        border-radius: 30px;
        margin: 15px auto;
        box-shadow: 0 2px 10px rgba(33, 150, 243, 0.2);
        max-width: fit-content;
        border: 2px solid var(--gris-claro);
    }


    #datos {
        display: flex;
        flex-direction: column;
        padding: 1.2rem;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        background: white;
        position: sticky;
        top: 1px;
    }

    /* Ícono principal grande verde */
    #datos .fa-2x {
        font-size: 2rem !important;
        color: #4CAF50;
        margin-bottom: 0.5rem;
    }

    /* Íconos de encabezado h4 en verde */
    #datos h5 .fa {
        color: #4CAF50;
        font-size: 1.2rem;
        margin-right: 8px;
    }

    /* Íconos pequeños en azul */
    #datos .info-section .fa {
        color: #2196F3;
        margin-right: 8px;
        font-size: 1rem;
    }

    #datos h5 {
        color: #2c3e50;
        font-size: 1rem;
        font-weight: 600;
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        padding-bottom: 0.3rem;
        border-bottom: 2px solid #4CAF50;
    }

    #datos .text-center {
        text-align: center;
        font-size: 0.9rem;
        padding: 0.5rem 0;
        background-color: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }

    #datos .text-center p {
        margin-top: 0.3rem;
        font-style: italic;
        color: #37474F;
    }

    #datos .info-section span {
        margin-left: 4px;
        font-size: 0.8rem;
        color: #37474F;
    }

    /* Efecto hover en los iconos */
    #datos .fa:hover {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }

    .radio-group {
        display: none;
    }

    .radio-label {
        background-color: #99abb4;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .radio-label.selected {
        background-color: var(--verde);
    }


    h5 {
        font-size: 15px;
        margin-bottom: 10px;
        color: #333;
    }

    .info-section p {
        font-size: 15px;
        margin: 10px 0;
    }

    .info-section strong {
        font-size: 13px;
        display: flex;
        align-items: center;
    }

    .info-section span {
        display: block;
        margin-top: 3px;
        font-size: 8px;
    }

    .info-section i {
        margin-right: 10px;
        color: #0099c7;
    }


    hr {
        border: 0;
        height: 1px;
        background: #ddd;
        margin: 20px 0;
    }

    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        color: var(--azul-cielo);
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }

    @keyframes spinner-border {
        100% {
            transform: rotate(360deg);
        }
    }

    /* Estilos de Texto */
    .text-muted {
        color: #6c757d !important;
    }

    .text-info {
        color: var(--azul-cielo) !important;
    }

    .text-nota {
        background-color: #f0f8ff;
        border-left: 4px solid var(--verde);
        padding: 0.5rem;
        border-radius: 4px;
        color: var(--negro);
        font-weight: 500;
        margin: 1rem 0;
        line-height: 1;
        font-size: 0.9rem;
    }

    input[type="radio"].error {
        appearance: none;
        width: 16px;
        height: 16px;
        border: 2px solid red;
        border-radius: 50%;
        position: relative;
    }

    input[type="radio"].error:checked::before {
        content: "";
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
    }

    #loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        /* Centra horizontalmente */
        align-items: center;
        /* Centra verticalmente */
        z-index: 1000;
        /* Asegúrate de que esté por encima de otros elementos */
    }


    #guia1 input[type="radio"],
    #pregunta47_2 input[type="radio"],
    #pregunta73_3 input[type="radio"],
    #seccion3_3 input[type="radio"],
    #seccion3_2 input[type="radio"] {
        position: static !important;
        left: auto !important;
        opacity: 1 !important;
    }
</style>


<div id="modal_evaluacion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 90%!important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="titulo_modal_evaluacion">Nueva evaluación</h4>
            </div>
            <div class="modal-body">
                {!! csrf_field() !!}
                <div class="row" id="contenidoCuestionarios">

                    <div class="col-12 mt-3">
                        <div class="card-container">
                            <div class="col-12">
                                <input type="hidden" class="form-control" id="ID_RECOPSICORESPUESTAS" name="ID_RECOPSICORESPUESTAS" value="0">
                                <input type="hidden" class="form-control" id="TRABAJADOR_ID" name="TRABAJADOR_ID" value="0">
                            </div>

                            <div id="guia1" class="card" style="display: block">
                                <h6 style="text-align: center" class="text-guia">Guía de referencia I</h6>
                                <h3 class="card-title"><b>GUÍA PARA IDENTIFICAR A LOS TRABAJADORES QUE FUERON SUJETOS A ACONTECIMIENTOS TRAUMÁTICOS SEVEROS</b></h3>
                                <hr>
                                <form enctype="multipart/form-data" method="post" name="guia_1" id="guia_1">
                                    {!! csrf_field() !!}

                                    <div id="seccion1" style="padding: 10px;">
                                        <div id="titulo1">
                                            <h5 style="text-align: left; width: 70%;" class="titulo-seccion"><b>I.- Acontecimiento traumático severo (DURANTE EL ÚLTIMO MES)</b></h5>
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" class="form-control" id="GUIAI_ID_RECOPSICORESPUESTAS" name="ID_RECOPSICORESPUESTAS" value="0">
                                            <input type="hidden" class="form-control" id="GUIAI_TRABAJADOR_ID" name="TRABAJADOR_ID" value="0">
                                        </div>
                                        <div id="pregunta1_1" class="mt-4 divPreguntas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 0 !important;">
                                            <p style="margin: 0; flex: 1; font-style: italic; margin-bottom: 10px;"><i class="fa fa-info-circle" id="Exp1_1" data-toggle="tooltip" title=""></i>
                                                1. ¿Ha presenciado o sufrido alguna vez, durante o con motivo del trabajo un acontecimiento como los siguientes:</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta1_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta1_si" name="GUIA1_1" value="1" onchange="guia1()">
                                                </div>
                                                <div>
                                                    <label for="pregunta1_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta1_no" name="GUIA1_1" value="0" onchange="guia1()">
                                                </div>
                                            </div>

                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;">
                                                <i class="fa fa-info-circle" id="Exp1_2" data-toggle="tooltip" title=""></i>
                                                accidente que tenga como consecuencia la muerte, la pérdida de un miembro o una lesión grave?
                                            </p>
                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;"><i class="fa fa-info-circle" id="Exp1_3" data-toggle="tooltip" title=""></i>
                                                asaltos?</p>
                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;"><i class="fa fa-info-circle" id="Exp1_4" data-toggle="tooltip" title=""></i>
                                                actos violentos que derivaron en lesiones graves?</p>
                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;"><i class="fa fa-info-circle" id="Exp1_5" data-toggle="tooltip" title=""></i>
                                                secuestro?</p>
                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;"><i class="fa fa-info-circle" id="Exp1_6" data-toggle="tooltip" title=""></i>
                                                amenazas?</p>
                                        </div>
                                        <div style="margin: 0 0 0 25px !important; padding: 0 !important; border-radius: 0 !important; transition: none !important; margin-bottom: 0px !important;">
                                            <p style="margin: 0 0 0 25px !important; flex: 1; font-style: italic;"><i class="fa fa-info-circle" id="Exp1_7" data-toggle="tooltip" title=""></i>
                                                cualquier otro que ponga en riesgo su vida o salud, y/o la de otras personas?</p>
                                        </div>
                                    </div>

                                    <div id="seccion2" class="mt-3" style="display: none; padding: 10px;">
                                        <div id="titulo2">
                                            <h5 style="text-align: left; width: 70%;" class="titulo-seccion"><b>II.- Recuerdos persistentes sobre el acontecimiento (durante el último mes):</b></h5>
                                        </div>
                                        <div id="pregunta2_1" class="mt-4 ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_8" data-toggle="tooltip" title=""></i>
                                                2. ¿Ha tenido recuerdos recurrentes sobre el acontecimiento que le provocan malestares?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta2_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguta2_si" name="GUIA1_2" value="1">
                                                </div>

                                                <div>
                                                    <label for="preguta2_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguta2_no" name="GUIA1_2" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta3_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_9" data-toggle="tooltip" title=""></i>
                                                3. ¿Ha tenido sueños de carácter recurrente sobre el acontecimiento, que le producen malestar?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta3_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta3_si" name="GUIA1_3" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta3_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta3_no" name="GUIA1_3" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="seccion3" class="mt-3" style="display: none; padding: 10px;">
                                        <div id="titulo3">
                                            <h5 style="text-align: left; width: 70%;" class="titulo-seccion"><b>III.- Esfuerzo por evitar circunstancias parecidas o asociadas al acontecimiento (durante el último mes):</b></h5>
                                        </div>
                                        <div id="pregunta4_1" class="mt-4 ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_10" data-toggle="tooltip" title=""></i>
                                                4. ¿Se ha esforzado por evitar todo tipo de sentimientos, conversaciones o situaciones que le puedan recordar el acontecimiento?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta4_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguta4_si" name="GUIA1_4" value="1">
                                                </div>

                                                <div>
                                                    <label for="preguta4_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguta4_no" name="GUIA1_4" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta5_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_11" data-toggle="tooltip" title=""></i>
                                                5. ¿Se ha esforzado por evitar todo tipo de actividades, lugares o personas que motivan recuerdos del acontecimiento?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta5_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta5_si" name="GUIA1_5" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta5_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta5_no" name="GUIA1_5" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta6_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_12" data-toggle="tooltip" title=""></i>
                                                6. ¿Ha tenido dificultad para recordar alguna parte importante del evento?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta6_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta6_si" name="GUIA1_6" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta6_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta6_no" name="GUIA1_6" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta7_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_13" data-toggle="tooltip" title=""></i>
                                                7. ¿Ha disminuido su interés en sus actividades cotidianas?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta7_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta7_si" name="GUIA1_7" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta7_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta7_no" name="GUIA1_7" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta8_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_14" data-toggle="tooltip" title=""></i>
                                                8. ¿Se ha sentido usted alejado o distante de los demás?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta8_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta8_si" name="GUIA1_8" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta8_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta8_no" name="GUIA1_8" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta9_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_15" data-toggle="tooltip" title=""></i>
                                                9. ¿Ha notado que tiene dificultad para expresar sus sentimientos?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta9_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta9_si" name="GUIA1_9" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta9_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta9_no" name="GUIA1_9" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta10_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_16" data-toggle="tooltip" title=""></i>
                                                10. ¿Ha tenido la impresión de que su vida se va a acortar, que va a morir antes que otras personas o que tiene un futuro limitado?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta10_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta10_si" name="GUIA1_10" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta10_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta10_no" name="GUIA1_10" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="seccion4" class="mt-3" style="display: none; padding: 10px; ">
                                        <div id="titulo4">
                                            <h5 style="text-align: left; width: 70%;" class="titulo-seccion"><b>IV.- Afectación (durante el último mes):</b></h5>
                                        </div>
                                        <div id="pregunta11_1" class="mt-4 ocultas" class="mt-4 divPreguntas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_17" data-toggle="tooltip" title=""></i>
                                                11. ¿Ha tenido usted dificultades para dormir?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta11_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguta11_si" name="GUIA1_11" value="1">
                                                </div>

                                                <div>
                                                    <label for="preguta11_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguta11_no" name="GUIA1_11" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta12_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_18" data-toggle="tooltip" title=""></i>
                                                12. ¿Ha estado particularmente irritable o le han dado arranques de coraje?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta12_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta12_si" name="GUIA1_12" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta12_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta12_no" name="GUIA1_12" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta13_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_19" data-toggle="tooltip" title=""></i>
                                                13. ¿Ha tenido dificultad para concentrarse?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta13_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta13_si" name="GUIA1_13" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta13_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta13_no" name="GUIA1_13" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta14_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_20" data-toggle="tooltip" title=""></i>
                                                14. ¿Ha estado nervioso o constantemente en alerta?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta14_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta14_si" name="GUIA1_14" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta14_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta14_no" name="GUIA1_14" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta15_1" class="ocultas" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp1_21" data-toggle="tooltip" title=""></i>
                                                15. ¿Se ha sobresaltado fácilmente por cualquier cosa?</p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="pregunta15_si" style="margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="pregunta15_si" name="GUIA1_15" value="1">
                                                </div>

                                                <div>
                                                    <label for="pregunta15_no" style="margin-right: 1px;">No</label>
                                                    <input type="radio" id="pregunta15_no" name="GUIA1_15" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>

                            <div id="guia2" class="card mt-4" style="display: block">
                                <h6 style="text-align: center" class="text-guia" class="text-guia">Guía de referencia II</h6>
                                <h3 class="card-title"><b>GUÍA PARA IDENTIFICAR LOS FACTORES DE RIESGO PSICOSOCIAL EN LOS CENTROS DE TRABAJO</b></h3>
                                <hr>
                                <form enctype="multipart/form-data" method="post" name="guia_2" id="guia_2">
                                    {!! csrf_field() !!}

                                    <div class="col-12">
                                        <input type="hidden" class="form-control" id="GUIAII_ID_RECOPSICORESPUESTAS" name="ID_RECOPSICORESPUESTAS" value="0">
                                        <input type="hidden" class="form-control" id="GUIAII_TRABAJADOR_ID" name="TRABAJADOR_ID" value="0">
                                    </div>
                                    <div id="seccion1_2" class="mt-3" style="display: block; padding: 10px;">

                                        <div id="pregunta1_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;">
                                                <i class="fa fa-info-circle" id="Exp2_1" data-toggle="tooltip" title=""></i>
                                                Mi trabajo me exige hacer mucho esfuerzo <br> físico
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta1_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta1_siempre" name="GUIA2_1" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta1_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta1_casi" name="GUIA2_1" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta1_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta1_algunas" name="GUIA2_1" value="2" ">
                                                     </div>
                                                    <div>
                                                        <label for=" preguta1_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta1_casinunca" name="GUIA2_1" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta1_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta1_nunca" name="GUIA2_1" value="0">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta2_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_2" data-toggle="tooltip" title=""></i>
                                                Me preocupa sufrir un accidente en mi
                                                trabajo </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta2_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta2_siempre" name="GUIA2_2" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta2_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta2_casi" name="GUIA2_2" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta2_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta2_algunas" name="GUIA2_2" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta2_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta2_casinunca" name="GUIA2_2" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta2_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta2_nunca" name="GUIA2_2" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta3_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_3" data-toggle="tooltip" title=""></i>
                                                Considero que las actividades que <br> realizo
                                                son peligrosas
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta3_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta3_siempre" name="GUIA2_3" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta3_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta3_casi" name="GUIA2_3" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta3_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta3_algunas" name="GUIA2_3" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta3_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta3_casinunca" name="GUIA2_3" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta3_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta3_nunca" name="GUIA2_3" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta4_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_4" data-toggle="tooltip" title=""></i>
                                                Por la cantidad de trabajo que tengo debo quedarme tiempo adicional a mi turno
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta4_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta4_siempre" name="GUIA2_4" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta4_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta4_casi" name="GUIA2_4" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta4_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta4_algunas" name="GUIA2_4" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta4_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta4_casinunca" name="GUIA2_4" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta4_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta4_nunca" name="GUIA2_4" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta5_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_5" data-toggle="tooltip" title=""></i>
                                                Por la cantidad de trabajo que tengo debo trabajar sin parar
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta5_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta5_siempre" name="GUIA2_5" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta5_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta5_casi" name="GUIA2_5" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta5_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta5_algunas" name="GUIA2_5" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta5_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta5_casinunca" name="GUIA2_5" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta5_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta5_nunca" name="GUIA2_5" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta6_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_6" data-toggle="tooltip" title=""></i>
                                                Considero que es necesario mantener un <br> ritmo de trabajo acelerado
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta6_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta6_siempre" name="GUIA2_6" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta6_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta6_casi" name="GUIA2_6" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta6_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta6_algunas" name="GUIA2_6" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta6_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta6_casinunca" name="GUIA2_6" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta6_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta6_nunca" name="GUIA2_6" value="0">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta7_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_7" data-toggle="tooltip" title=""></i>
                                                Mi trabajo exige que esté muy concentrado
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta7_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta7_siempre" name="GUIA2_7" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta7_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta7_casi" name="GUIA2_7" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta7_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta7_algunas" name="GUIA2_7" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta7_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta7_casinunca" name="GUIA2_7" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta7_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta7_nunca" name="GUIA2_7" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta8_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_8" data-toggle="tooltip" title=""></i>
                                                Mi trabajo requiere que memorice mucha información
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta8_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta8_siempre" name="GUIA2_8" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta8_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta8_casi" name="GUIA2_8" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta8_algunas" class="radio-label" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta8_algunas" name="GUIA2_8" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta8_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta8_casinunca" name="GUIA2_8" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta8_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta8_nunca" name="GUIA2_8" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta9_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_9" data-toggle="tooltip" title=""></i>
                                                Mi trabajo exige que atienda varios asuntos <br>
                                                al mismo tiempo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta9_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta9_siempre" name="GUIA2_9" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta9_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta9_casi" name="GUIA2_9" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta9_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta9_algunas" name="GUIA2_9" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta9_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta9_casinunca" name="GUIA2_9" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta9_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta9_nunca" name="GUIA2_9" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con las actividades que realiza en su trabajo y las responsabilidades que tiene.</h6>
                                        </div>
                                        <div id="pregunta10_2" class="mt-5 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_10" data-toggle="tooltip" title=""></i>
                                                En mi trabajo soy responsable de cosas de mucho valor
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta10_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta10_siempre" name="GUIA2_10" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta10_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta10_casi" name="GUIA2_10" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta10_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta10_algunas" name="GUIA2_10" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta10_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta10_casinunca" name="GUIA2_10" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta10_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta10_nunca" name="GUIA2_10" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta11_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_11" data-toggle="tooltip" title=""></i>
                                                Respondo ante mi jefe por los resultados <br>de toda mi área de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta11_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta11_siempre" name="GUIA2_11" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta11_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta11_casi" name="GUIA2_11" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta11_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta11_algunas" name="GUIA2_11" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta11_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta11_casinunca" name="GUIA2_11" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta11_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta11_nunca" name="GUIA2_11" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta12_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_12" data-toggle="tooltip" title=""></i>
                                                En mi trabajo me dan órdenes contradictorias
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta12_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta12_siempre" name="GUIA2_12" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta12_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta12_casi" name="GUIA2_12" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta12_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta12_algunas" name="GUIA2_12" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta12_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta12_casinunca" name="GUIA2_12" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta12_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta12_nunca" name="GUIA2_12" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta13_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_13" data-toggle="tooltip" title=""></i>
                                                Considero que en mi trabajo me piden <br> hacer cosas innecesarias
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta13_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta13_siempre" name="GUIA2_13" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta13_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta13_casi" name="GUIA2_13" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta13_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta13_algunas" name="GUIA2_13" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta13_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta13_casinunca" name="GUIA2_13" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta13_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta13_nunca" name="GUIA2_13" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con el tiempo destinado a su trabajo y sus responsabilidades familiares.</h6>
                                        </div>
                                        <div id="pregunta14_2" class="mt-5 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_14" data-toggle="tooltip" title=""></i>
                                                Trabajo horas extras más de tres veces <br> a la semana
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta14_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta14_siempre" name="GUIA2_14" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta14_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta14_casi" name="GUIA2_14" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta14_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta14_algunas" name="GUIA2_14" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta14_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta14_casinunca" name="GUIA2_14" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta14_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta14_nunca" name="GUIA2_14" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta15_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_15" data-toggle="tooltip" title=""></i>
                                                Mi trabajo me exige laborar en días de <br> descanso, festivos o fines de semana
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta15_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta15_siempre" name="GUIA2_15" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta15_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta15_casi" name="GUIA2_15" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta15_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta15_algunas" name="GUIA2_15" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta15_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta15_casinunca" name="GUIA2_15" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta15_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta15_nunca" name="GUIA2_15" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta16_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_16" data-toggle="tooltip" title=""></i>
                                                Considero que el tiempo en el trabajo <br>
                                                es mucho y perjudica mis actividades familiares o personales
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta16_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta16_siempre" name="GUIA2_16" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta16_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta16_casi" name="GUIA2_16" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta16_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta16_algunas" name="GUIA2_16" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta16_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta16_casinunca" name="GUIA2_16" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta16_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta16_nunca" name="GUIA2_16" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta17_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_17" data-toggle="tooltip" title=""></i>
                                                Pienso en las actividades familiares o <br> personales cuando estoy en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta17_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta17_siempre" name="GUIA2_17" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta17_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta17_casi" name="GUIA2_17" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta17_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta17_algunas" name="GUIA2_17" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta17_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta17_casinunca" name="GUIA2_17" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta17_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta17_nunca" name="GUIA2_17" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con las decisiones que puede tomar en su trabajo.
                                            </h6>
                                        </div>

                                        <div id="pregunta18_2" class="mt-5 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_18" data-toggle="tooltip" title=""></i>
                                                Mi trabajo permite que desarrolle nuevas habilidades
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta18_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta18_siempre" name="GUIA2_18" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta18_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta18_casi" name="GUIA2_18" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta18_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta18_algunas" name="GUIA2_18" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta18_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta18_casinunca" name="GUIA2_18" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta18_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta18_nunca" name="GUIA2_18" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta19_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_19" data-toggle="tooltip" title=""></i>
                                                En mi trabajo puedo aspirar a un mejor <br>
                                                puesto
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta19_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta19_siempre" name="GUIA2_19" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta19_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta19_casi" name="GUIA2_19" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta19_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta19_algunas" name="GUIA2_19" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta19_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta19_casinunca" name="GUIA2_19" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta19_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta19_nunca" name="GUIA2_19" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta20_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_20" data-toggle="tooltip" title=""></i>
                                                Durante mi jornada de trabajo puedo <br> tomar pausas cuando las necesito
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta20_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta20_siempre" name="GUIA2_20" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta20_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta20_casi" name="GUIA2_20" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta20_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta20_algunas" name="GUIA2_20" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta20_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta20_casinunca" name="GUIA2_20" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta20_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta20_nunca" name="GUIA2_20" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta21_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_21" data-toggle="tooltip" title=""></i>
                                                Puedo decidir la velocidad a la que realizo mis actividades en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta21_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta21_siempre" name="GUIA2_21" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta21_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta21_casi" name="GUIA2_21" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta21_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta21_algunas" name="GUIA2_21" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta21_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta21_casinunca" name="GUIA2_21" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta21_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta21_nunca" name="GUIA2_21" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta22_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_22" data-toggle="tooltip" title=""></i>
                                                Puedo cambiar el orden de las actividades <br> que realizo en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta22_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta22_siempre" name="GUIA2_22" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta22_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta22_casi" name="GUIA2_22" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta22_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta22_algunas" name="GUIA2_22" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta22_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta22_casinunca" name="GUIA2_22" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta22_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta22_nunca" name="GUIA2_22" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con la capacitación e información que recibe sobre su trabajo.
                                            </h6>
                                        </div>


                                        <div id="pregunta23_2" class="mt-5 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_23" data-toggle="tooltip" title=""></i>
                                                Me informan con claridad cuáles son mis funciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta23_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta23_siempre" name="GUIA2_23" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta23_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta23_casi" name="GUIA2_23" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta23_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta23_algunas" name="GUIA2_23" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta23_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta23_casinunca" name="GUIA2_23" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta23_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta23_nunca" name="GUIA2_23" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta24_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_24" data-toggle="tooltip" title=""></i>
                                                Me explican claramente los resultados <br> que debo obtener en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta24_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta24_siempre" name="GUIA2_24" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta24_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta24_casi" name="GUIA2_24" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta24_algunas" class="radio-label" class="radio-label" z style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta24_algunas" name="GUIA2_24" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta24_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta24_casinunca" name="GUIA2_24" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta24_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta24_nunca" name="GUIA2_24" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta25_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_25" data-toggle="tooltip" title=""></i>
                                                Me informan con quién puedo resolver problemas o asuntos de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta25_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta25_siempre" name="GUIA2_25" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta25_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta25_casi" name="GUIA2_25" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta25_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta25_algunas" name="GUIA2_25" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta25_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta25_casinunca" name="GUIA2_25" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta25_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta25_nunca" name="GUIA2_25" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta26_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_26" data-toggle="tooltip" title=""></i>
                                                Me permiten asistir a capacitaciones relacionadas con mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta26_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta26_siempre" name="GUIA2_26" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta26_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta26_casi" name="GUIA2_26" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta26_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta26_algunas" name="GUIA2_26" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta26_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta26_casinunca" name="GUIA2_26" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta26_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta26_nunca" name="GUIA2_26" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta27_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_27" data-toggle="tooltip" title=""></i>
                                                Recibo capacitación útil para hacer mi <br>
                                                trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta27_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta27_siempre" name="GUIA2_27" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta27_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta27_casi" name="GUIA2_27" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta27_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta27_algunas" name="GUIA2_27" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta27_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta27_casinunca" name="GUIA2_27" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta27_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta27_nunca" name="GUIA2_27" value="4">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes se refieren a las relaciones con sus compañeros de trabajo y su jefe.
                                            </h6>
                                        </div>

                                        <div id="pregunta28_2" class="mt-5 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_28" data-toggle="tooltip" title=""></i>
                                                Mi jefe tiene en cuenta mis puntos de vista <br> y opiniones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta28_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta28_siempre" name="GUIA2_28" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta28_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta28_casi" name="GUIA2_28" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta28_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta28_algunas" name="GUIA2_28" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta28_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta28_casinunca" name="GUIA2_28" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta28_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta28_nunca" name="GUIA2_28" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta29_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_29" data-toggle="tooltip" title=""></i>
                                                Mi jefe ayuda a solucionar los problemas <br> que se presentan en el trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta29_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta29_siempre" name="GUIA2_29" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta29_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta29_casi" name="GUIA2_29" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta29_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta29_algunas" name="GUIA2_29" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta29_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta29_casinunca" name="GUIA2_29" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta29_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta29_nunca" name="GUIA2_29" value="4">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta30_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_30" data-toggle="tooltip" title=""></i>
                                                Puedo confiar en mis compañeros de <br>trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta30_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta30_siempre" name="GUIA2_30" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta30_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta30_casi" name="GUIA2_30" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta30_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta30_algunas" name="GUIA2_30" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta30_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta30_casinunca" name="GUIA2_30" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta30_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta30_nunca" name="GUIA2_30" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta31_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_31" data-toggle="tooltip" title=""></i>
                                                Cuando tenemos que realizar trabajo de <br> equipo los compañeros colaboran
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta31_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta31_siempre" name="GUIA2_31" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta31_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta31_casi" name="GUIA2_31" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta31_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta31_algunas" name="GUIA2_31" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta31_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta31_casinunca" name="GUIA2_31" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta31_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta31_nunca" name="GUIA2_31" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta32_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_32" data-toggle="tooltip" title=""></i>
                                                Mis compañeros de trabajo me ayudan <br> cuando tengo dificultades
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta32_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta32_siempre" name="GUIA2_32" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta32_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta32_casi" name="GUIA2_32" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta32_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta32_algunas" name="GUIA2_32" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta32_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta32_casinunca" name="GUIA2_32" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta32_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta32_nunca" name="GUIA2_32" value="4">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta33_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_33" data-toggle="tooltip" title=""></i>
                                                En mi trabajo puedo expresarme <br> libremente sin interrupciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta33_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta33_siempre" name="GUIA2_33" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta33_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta33_casi" name="GUIA2_33" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta33_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta33_algunas" name="GUIA2_33" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta33_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta33_casinunca" name="GUIA2_33" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta33_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta33_nunca" name="GUIA2_33" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta34_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_34" data-toggle="tooltip" title=""></i>
                                                Recibo críticas constantes a mi <br> persona y/o trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta34_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta34_siempre" name="GUIA2_34" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta34_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta34_casi" name="GUIA2_34" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta34_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta34_algunas" name="GUIA2_34" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta34_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta34_casinunca" name="GUIA2_34" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta34_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta34_nunca" name="GUIA2_34" value="0">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta35_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_35" data-toggle="tooltip" title=""></i>
                                                Recibo burlas, calumnias, difamaciones, humillaciones o ridiculizaciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta35_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta35_siempre" name="GUIA2_35" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta35_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta35_casi" name="GUIA2_35" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta35_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta35_algunas" name="GUIA2_35" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta35_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta35_casinunca" name="GUIA2_35" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta35_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta35_nunca" name="GUIA2_35" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta36_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_36" data-toggle="tooltip" title=""></i>
                                                Se ignora mi presencia o se me excluye <br> de las reuniones de trabajo y en la toma <br>de decisiones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta36_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta36_siempre" name="GUIA2_36" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta36_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta36_casi" name="GUIA2_36" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta36_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta36_algunas" name="GUIA2_36" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta36_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta36_casinunca" name="GUIA2_36" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta36_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta36_nunca" name="GUIA2_36" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta37_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_37" data-toggle="tooltip" title=""></i>
                                                Se manipulan las situaciones de trabajo <br> para hacerme parecer un mal trabajador
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta37_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta37_siempre" name="GUIA2_37" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta37_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta37_casi" name="GUIA2_37" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta37_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta37_algunas" name="GUIA2_37" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta37_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta37_casinunca" name="GUIA2_37" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta37_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta37_nunca" name="GUIA2_37" value="0">
                                                </div>
                                            </div>
                                        </div>


                                        <div id="pregunta38_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_38" data-toggle="tooltip" title=""></i>
                                                Se ignoran mis éxitos laborales y se <br> atribuyen a otros trabajadores
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta38_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta38_siempre" name="GUIA2_38" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta38_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta38_casi" name="GUIA2_38" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta38_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta38_algunas" name="GUIA2_38" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta38_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta38_casinunca" name="GUIA2_38" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta38_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta38_nunca" name="GUIA2_38" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta39_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_39" data-toggle="tooltip" title=""></i>
                                                Me bloquean o impiden las oportunidades <br> que tengo para obtener ascenso o mejora <br>en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta39_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta39_siempre" name="GUIA2_39" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta39_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta39_casi" name="GUIA2_39" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta39_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta39_algunas" name="GUIA2_39" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta39_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta39_casinunca" name="GUIA2_39" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta39_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta39_nunca" name="GUIA2_39" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta40_2" class="mt-4 guia2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_40" data-toggle="tooltip" title=""></i>
                                                He presenciado actos de violencias en mi <br> centro de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta40_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta40_siempre" name="GUIA2_40" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta40_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta40_casi" name="GUIA2_40" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta40_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta40_algunas" name="GUIA2_40" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta40_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta40_casinunca" name="GUIA2_40" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta40_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta40_nunca" name="GUIA2_40" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con la atención a clientes y usuarios.
                                            </h6>
                                        </div>

                                        <div id="pregunta47_2" class="mt-5 guia2" style="display: flex; align-items: center; margin-bottom: 10px;">
                                            <p style="margin: 0; white-space: nowrap; margin-right: 10px;"><i class="fa fa-info-circle" id="Exp2_1ADI" data-toggle="tooltip" title=""></i>
                                                En mi trabajo debo brindar servicio a clientes o usuarios:
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-left: 10px;">
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi1_si" style="line-height: 1; margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguntaadi1_si" name="GUIA2_47" value="1" style="vertical-align: middle;" onchange="clientesyusuarios()">
                                                </div>
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi1_no" style="line-height: 1; margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguntaadi1_no" name="GUIA2_47" value="0" style="vertical-align: middle;" onchange="clientesyusuarios()">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mt-3">
                                            <h6 class="text-nota">Si su respuesta fue "SI", responda las preguntas siguientes. Si su respuesta fue "NO" pase a las preguntas de la sección siguiente.
                                            </h6>
                                        </div>

                                    </div>


                                    <div id="seccion2_2" class="mt-2" style="display: none; padding: 10px;">

                                        <div id="pregunta41_2" class="mt-3 ocultas2_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_41" data-toggle="tooltip" title=""></i>
                                                Atiendo clientes o usuarios muy enojados
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta41_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta41_siempre" name="GUIA2_41" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta41_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta41_casi" name="GUIA2_41" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta41_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta41_algunas" name="GUIA2_41" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta41_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta41_casinunca" name="GUIA2_41" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta41_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta41_nunca" name="GUIA2_41" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta42_2" class="mt-4 ocultas2_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_42" data-toggle="tooltip" title=""></i>
                                                Mi trabajo me exige atender personas muy necesitadas de ayuda o enfermas
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta42_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta42_siempre" name="GUIA2_42" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta42_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta42_casi" name="GUIA2_42" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta42_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta42_algunas" name="GUIA2_42" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta42_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta42_casinunca" name="GUIA2_42" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta42_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta42_nunca" name="GUIA2_42" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta43_2" class="mt-4 ocultas2_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_43" data-toggle="tooltip" title=""></i>
                                                Para hacer mi trabajo debo demostrar sentimientos distintos a los míos
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta43_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta43_siempre" name="GUIA2_43" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta43_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta43_casi" name="GUIA2_43" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta43_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta43_algunas" name="GUIA2_43" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta43_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta43_casinunca" name="GUIA2_43" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta43_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta43_nunca" name="GUIA2_43" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="seccion3_2" class="mt-2" style="display: block; padding: 10px;">
                                        <div id="pregunta48_2" class="mt-2" style="display: flex; align-items: center; margin-bottom: 10px;">
                                            <p style="margin: 0; white-space: nowrap; margin-right: 10px;"><i class="fa fa-info-circle" id="Exp2_2ADI" data-toggle="tooltip" title=""></i>
                                                Soy jefe de otros trabajadores:
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-left: 10px;">
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi2_si" style="line-height: 1; margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguntaadi2_si" name="GUIA2_48" value="1" style="vertical-align: middle;" onchange="jefetrabajadores()">
                                                </div>
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi2_no" style="line-height: 1; margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguntaadi2_no" name="GUIA2_48" value="0" style="vertical-align: middle;" onchange="jefetrabajadores()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-nota">Si su respuesta fue "SI", responda las preguntas siguientes. Si su respuesta fue "NO", ha concluido el cuestionario.
                                            </h6>
                                        </div>
                                    </div>
                                    <div id="seccion4_2" class="mt-2" style="display: none; padding: 10px;">
                                        <div class="mt-3">
                                            <h6>Las siguientes preguntas están relacionadas con las actitudes de los trabajadores que supervisa.
                                            </h6>
                                        </div>
                                        <div id="pregunta44_2" class="mt-4 ocultas2_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_44" data-toggle="tooltip" title=""></i>
                                                Comunican tarde los asuntos de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta44_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta44_siempre" name="GUIA2_44" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta44_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta44_casi" name="GUIA2_44" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta44_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta44_algunas" name="GUIA2_44" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta44_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta44_casinunca" name="GUIA2_44" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta44_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta44_nunca" name="GUIA2_44" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta45_2" class="mt-4 ocultas2_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_45" data-toggle="tooltip" title=""></i>
                                                Dificultan el logro de los resultados del <br>
                                                trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta45_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta45_siempre" name="GUIA2_45" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta45_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta45_casi" name="GUIA2_45" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta45_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta45_algunas" name="GUIA2_45" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta45_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta45_casinunca" name="GUIA2_45" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta45_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta45_nunca" name="GUIA2_45" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta46_2" class="mt-4 ocultas2_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp2_46" data-toggle="tooltip" title=""></i>
                                                Ignoran las sugerencias para mejorar <br> su trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta46_siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta46_siempre" name="GUIA2_46" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta46_casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta46_casi" name="GUIA2_46" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta46_algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta46_algunas" name="GUIA2_46" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta46_casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta46_casinunca" name="GUIA2_46" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta46_nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta46_nunca" name="GUIA2_46" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" id="guardar_guia2" onclick="submitGuia1y2()">
                                        Guardar <i class="fa fa-save"></i>
                                    </button>
                                </form>
                            </div>

                            <div id="guia3" class="card mt-4" style="display: block">
                                <h6 style="text-align: center" class="text-guia">Guía de referencia III</h6>
                                <h3 class="card-title"><b>GUÍA PARA IDENTIFICAR LOS FACTORES DE RIESGO PSICOSOCIAL Y EVALUAR EL ENTORNO ORGANIZACIONAL EN LOS CENTROS DE TRABAJO</b></h3>
                                <hr>
                                <form enctype="multipart/form-data" method="post" name="guia_3" id="guia_3">
                                    {!! csrf_field() !!}

                                    <div class="col-12">
                                        <input type="hidden" class="form-control" id="GUIAIII_ID_RECOPSICORESPUESTAS" name="ID_RECOPSICORESPUESTAS" value="0">
                                        <input type="hidden" class="form-control" id="GUIAIII_TRABAJADOR_ID" name="TRABAJADOR_ID" value="0">
                                    </div>
                                    <div class="mt-3">
                                        <p style="margin: 0; flex: 1; font-style: italic;">
                                            Para responder las siguientes preguntas considere las condiciones ambientales de su centro de trabajo.</p>
                                    </div>
                                    <div id="seccion1_3" style="display: block;">
                                        <div id="pregunta1_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_1" data-toggle="tooltip" title=""></i>
                                                1. El espacio donde trabajo me permite <br> realizar mis actividades de manera segura <br> e higiénica
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta1_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta1_3siempre" name="GUIA3_1" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta1_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta1_3casi" name="GUIA3_1" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta1_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta1_3algunas" name="GUIA3_1" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta1_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta1_3casinunca" name="GUIA3_1" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta1_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta1_3nunca" name="GUIA3_1" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta2_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_2" data-toggle="tooltip" title=""></i>
                                                2. Mi trabajo me exige hacer mucho <br> esfuerzo físico
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta2_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta2_3siempre" name="GUIA3_2" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta2_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta2_3casi" name="GUIA3_2" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta2_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta2_3algunas" name="GUIA3_2" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta2_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta2_3casinunca" name="GUIA3_2" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta2_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta2_3nunca" name="GUIA3_2" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta3_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_3" data-toggle="tooltip" title=""></i>
                                                3. Me preocupa sufrir un accidente en mi <br> trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta3_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta3_3siempre" name="GUIA3_3" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta3_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta3_3casi" name="GUIA3_3" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta3_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta3_3algunas" name="GUIA3_3" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta3_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta3_3casinunca" name="GUIA3_3" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta3_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta3_3nunca" name="GUIA3_3" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta4_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_4" data-toggle="tooltip" title=""></i>
                                                4. Considero que en mi trabajo se aplican las normas de seguridad y salud en el trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta4_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta4_3siempre" name="GUIA3_4" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta4_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta4_3casi" name="GUIA3_4" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta4_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta4_3algunas" name="GUIA3_4" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta4_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta4_3casinunca" name="GUIA3_4" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta4_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta4_3nunca" name="GUIA3_4" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta5_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_5" data-toggle="tooltip" title=""></i>
                                                5. Considero que las actividades que realizo <br> son peligrosas
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta5_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta5_3siempre" name="GUIA3_5" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta5_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta5_3casi" name="GUIA3_5" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta5_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta5_3algunas" name="GUIA3_5" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta5_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta5_3casinunca" name="GUIA3_5" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta5_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta5_3nunca" name="GUIA3_5" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Para responder a las preguntas siguientes piense en la cantidad y ritmo de trabajo que tiene.</p>
                                        </div>
                                        <div id="pregunta6_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_6" data-toggle="tooltip" title=""></i>
                                                6. Por la cantidad de trabajo que tengo debo quedarme tiempo adicional a mi turno
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta6_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta6_3siempre" name="GUIA3_6" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta6_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta6_3casi" name="GUIA3_6" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta6_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta6_3algunas" name="GUIA3_6" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta6_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta6_3casinunca" name="GUIA3_6" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta6_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta6_3nunca" name="GUIA3_6" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta7_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_7" data-toggle="tooltip" title=""></i>
                                                7. Por la cantidad de trabajo que tengo debo trabajar sin parar
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta7_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta7_3siempre" name="GUIA3_7" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta7_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta7_3casi" name="GUIA3_7" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta7_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta7_3algunas" name="GUIA3_7" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta7_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta7_3casinunca" name="GUIA3_7" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta7_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta7_3nunca" name="GUIA3_7" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta8_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_8" data-toggle="tooltip" title=""></i>
                                                8. Considero que es necesario mantener un <br> ritmo de trabajo acelerado
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta8_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta8_3siempre" name="GUIA3_8" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta8_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta8_3casi" name="GUIA3_8" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta8_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta8_3algunas" name="GUIA3_8" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta8_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta8_3casinunca" name="GUIA3_8" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta8_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta8_3nunca" name="GUIA3_8" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con el esfuerzo mental que le exige su trabajo.</p>
                                        </div>
                                        <div id="pregunta9_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_9" data-toggle="tooltip" title=""></i>
                                                9. Mi trabajo exige que esté muy concentrado
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta9_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta9_3siempre" name="GUIA3_9" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta9_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta9_3casi" name="GUIA3_9" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta9_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta9_3algunas" name="GUIA3_9" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta9_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta9_3casinunca" name="GUIA3_9" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta9_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta9_3nunca" name="GUIA3_9" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta10_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_10" data-toggle="tooltip" title=""></i>
                                                10. Mi trabajo requiere que memorice mucha información
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta10_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta10_3siempre" name="GUIA3_10" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta10_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta10_3casi" name="GUIA3_10" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta10_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta10_3algunas" name="GUIA3_10" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta10_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta10_3casinunca" name="GUIA3_10" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta10_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta10_3nunca" name="GUIA3_10" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta11_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_11" data-toggle="tooltip" title=""></i>
                                                11. En mi trabajo tengo que tomar decisiones difíciles muy rápido
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta11_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta11_3siempre" name="GUIA3_11" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta11_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta11_3casi" name="GUIA3_11" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta11_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta11_3algunas" name="GUIA3_11" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta11_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta11_3casinunca" name="GUIA3_11" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta11_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta11_3nunca" name="GUIA3_11" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta12_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_12" data-toggle="tooltip" title=""></i>
                                                12. Mi trabajo exige que atienda varios <br> asuntos
                                                al mismo tiempo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta12_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta12_3siempre" name="GUIA3_12" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta12_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta12_3casi" name="GUIA3_12" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta12_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta12_3algunas" name="GUIA3_12" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta12_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta12_3casinunca" name="GUIA3_12" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta12_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta12_3nunca" name="GUIA3_12" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con las actividades que realiza en su trabajo y las responsabilidades que tiene.</p>
                                        </div>
                                        <div id="pregunta13_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_13" data-toggle="tooltip" title=""></i>
                                                13. En mi trabajo soy responsable de cosas de mucho valor
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta13_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta13_3siempre" name="GUIA3_13" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta13_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta13_3casi" name="GUIA3_13" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta13_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta13_3algunas" name="GUIA3_13" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta13_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta13_3casinunca" name="GUIA3_13" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta13_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta13_3nunca" name="GUIA3_13" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta14_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_14" data-toggle="tooltip" title=""></i>
                                                14. Respondo ante mi jefe por los resultados <br> de toda mi área de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta14_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta14_3siempre" name="GUIA3_14" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta14_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta14_3casi" name="GUIA3_14" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta14_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta14_3algunas" name="GUIA3_14" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta14_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta14_3casinunca" name="GUIA3_14" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta14_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta14_3nunca" name="GUIA3_14" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta15_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_15" data-toggle="tooltip" title=""></i>
                                                15. En el trabajo me dan órdenes <br>contradictorias
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta15_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta15_3siempre" name="GUIA3_15" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta15_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta15_3casi" name="GUIA3_15" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta15_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta15_3algunas" name="GUIA3_15" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta15_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta15_3casinunca" name="GUIA3_15" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta15_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta15_3nunca" name="GUIA3_15" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta16_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_16" data-toggle="tooltip" title=""></i>
                                                16. Considero que en mi trabajo me piden<br> hacer cosas innecesarias
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta16_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta16_3siempre" name="GUIA3_16" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta16_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta16_3casi" name="GUIA3_16" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta16_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta16_3algunas" name="GUIA3_16" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta16_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta16_3casinunca" name="GUIA3_16" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta16_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta16_3nunca" name="GUIA3_16" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <h6>Las preguntas siguientes están relacionadas con su jornada de trabajo.
                                            </h6>
                                        </div>
                                        <div id="pregunta17_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_17" data-toggle="tooltip" title=""></i>
                                                17. Trabajo horas extras más de tres veces a<br> la semana
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta17_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta17_3siempre" name="GUIA3_17" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta17_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta17_3casi" name="GUIA3_17" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta17_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta17_3algunas" name="GUIA3_17" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta17_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta17_3casinunca" name="GUIA3_17" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta17_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta17_3nunca" name="GUIA3_17" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta18_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_18" data-toggle="tooltip" title=""></i>
                                                18. Mi trabajo me exige laborar en días de <br> descanso, festivos o fines de semana
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta18_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta18_3siempre" name="GUIA3_18" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta18_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta18_3casi" name="GUIA3_18" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta18_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta18_3algunas" name="GUIA3_18" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta18_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta18_3casinunca" name="GUIA3_18" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta18_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta18_3nunca" name="GUIA3_18" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta19_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_19" data-toggle="tooltip" title=""></i>
                                                19. Considero que el tiempo en el trabajo es <br> mucho y perjudica mis actividades familiares <br> o personales
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta19_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta19_3siempre" name="GUIA3_19" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta19_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta19_3casi" name="GUIA3_19" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta19_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta19_3algunas" name="GUIA3_19" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta19_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta19_3casinunca" name="GUIA3_19" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta19_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta19_3nunca" name="GUIA3_19" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta20_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_20" data-toggle="tooltip" title=""></i>
                                                20. Debo atender asuntos de trabajo cuando <br> estoy en casa
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta20_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta20_3siempre" name="GUIA3_20" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta20_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta20_3casi" name="GUIA3_20" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta20_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta20_3algunas" name="GUIA3_20" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta20_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta20_3casinunca" name="GUIA3_20" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta20_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta20_3nunca" name="GUIA3_20" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta21_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_21" data-toggle="tooltip" title=""></i>
                                                21. Pienso en las actividades familiares o <br> personales cuando estoy en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta21_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta21_3siempre" name="GUIA3_21" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta21_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta21_3casi" name="GUIA3_21" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta21_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta21_3algunas" name="GUIA3_21" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta21_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta21_3casinunca" name="GUIA3_21" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta21_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta21_3nunca" name="GUIA3_21" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta22_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_22" data-toggle="tooltip" title=""></i>
                                                22. Pienso que mis responsabilidades<br>familiares afectan mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta22_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta22_3siempre" name="GUIA3_22" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta22_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta22_3casi" name="GUIA3_22" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta22_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta22_3algunas" name="GUIA3_22" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta22_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta22_3casinunca" name="GUIA3_22" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta22_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta22_3nunca" name="GUIA3_22" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con las decisiones que puede tomar en su trabajo.</p>
                                        </div>
                                        <div id="pregunta23_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_23" data-toggle="tooltip" title=""></i>
                                                23. Mi trabajo permite que desarrolle nuevas habilidades
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta23_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta23_3siempre" name="GUIA3_23" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta23_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta23_3casi" name="GUIA3_23" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta23_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta23_3algunas" name="GUIA3_23" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta23_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta23_3casinunca" name="GUIA3_23" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta23_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta23_3nunca" name="GUIA3_23" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta24_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_24" data-toggle="tooltip" title=""></i>
                                                24. En mi trabajo puedo aspirar a un mejor <br>
                                                puesto
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta24_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta24_3siempre" name="GUIA3_24" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta24_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta24_3casi" name="GUIA3_24" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta24_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta24_3algunas" name="GUIA3_24" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta24_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta24_3casinunca" name="GUIA3_24" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta24_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta24_3nunca" name="GUIA3_24" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta25_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_25" data-toggle="tooltip" title=""></i>
                                                25. Durante mi jornada de trabajo puedo<br> tomar pausas cuando las necesito
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta25_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta25_3siempre" name="GUIA3_25" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta25_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta25_3casi" name="GUIA3_25" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta25_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta25_3algunas" name="GUIA3_25" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta25_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta25_3casinunca" name="GUIA3_25" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta25_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta25_3nunca" name="GUIA3_25" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta26_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_26" data-toggle="tooltip" title=""></i>
                                                26. Puedo decidir cuánto trabajo realizo <br> durante la jornada laboral
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta26_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta26_3siempre" name="GUIA3_26" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta26_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta26_3casi" name="GUIA3_26" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta26_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta26_3algunas" name="GUIA3_26" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta26_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta26_3casinunca" name="GUIA3_26" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta26_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta26_3nunca" name="GUIA3_26" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta27_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_27" data-toggle="tooltip" title=""></i>
                                                27. Puedo decidir la velocidad a la que realizo mis actividades en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta27_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta27_3siempre" name="GUIA3_27" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta27_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta27_3casi" name="GUIA3_27" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta27_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta27_3algunas" name="GUIA3_27" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta27_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta27_3casinunca" name="GUIA3_27" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta27_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta27_3nunca" name="GUIA3_27" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta28_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_28" data-toggle="tooltip" title=""></i>
                                                28. Puedo cambiar el orden de las actividades que realizo en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta28_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta28_3siempre" name="GUIA3_28" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta28_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta28_3casi" name="GUIA3_28" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta28_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta28_3algunas" name="GUIA3_28" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta28_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta28_3casinunca" name="GUIA3_28" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta28_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta28_3nunca" name="GUIA3_28" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con cualquier tipo de cambio que ocurra en su trabajo (considere los últimos cambios realizados).</p>
                                        </div>
                                        <div id="pregunta29_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_29" data-toggle="tooltip" title=""></i>
                                                29. Los cambios que se presentan en mi <br>trabajo dificultan mi labor
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta29_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta29_3siempre" name="GUIA3_29" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta29_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta29_3casi" name="GUIA3_29" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta29_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta29_3algunas" name="GUIA3_29" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta29_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta29_3casinunca" name="GUIA3_29" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta29_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta29_3nunca" name="GUIA3_29" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta30_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_30" data-toggle="tooltip" title=""></i>
                                                30. Cuando se presentan cambios en mi <br> trabajo se tienen en cuenta mis ideas o aportaciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta30_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta30_3siempre" name="GUIA3_30" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta30_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta30_3casi" name="GUIA3_30" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta30_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta30_3algunas" name="GUIA3_30" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta30_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta30_3casinunca" name="GUIA3_30" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta30_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta30_3nunca" name="GUIA3_30" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con la capacitación e información que se le proporciona sobre su trabajo.</p>
                                        </div>

                                        <div id="pregunta31_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_31" data-toggle="tooltip" title=""></i>
                                                31. Me informan con claridad cuáles son mis funciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta31_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta31_3siempre" name="GUIA3_31" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta31_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta31_3casi" name="GUIA3_31" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta31_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta31_3algunas" name="GUIA3_31" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta31_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta31_3casinunca" name="GUIA3_31" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta31_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta31_3nunca" name="GUIA3_31" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta32_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_32" data-toggle="tooltip" title=""></i>
                                                32. Me explican claramente los resultados que debo obtener en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta32_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta32_3siempre" name="GUIA3_32" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta32_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta32_3casi" name="GUIA3_32" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta32_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta32_3algunas" name="GUIA3_32" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta32_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta32_3casinunca" name="GUIA3_32" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta32_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta32_3nunca" name="GUIA3_32" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta33_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_33" data-toggle="tooltip" title=""></i>
                                                33. Me explican claramente los objetivos de mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta33_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta33_3siempre" name="GUIA3_33" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta33_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta33_3casi" name="GUIA3_33" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta33_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta33_3algunas" name="GUIA3_33" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta33_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta33_3casinunca" name="GUIA3_33" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta33_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta33_3nunca" name="GUIA3_33" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta34_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_34" data-toggle="tooltip" title=""></i>
                                                34. Me informan con quién puedo resolver problemas o asuntos de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta34_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta34_3siempre" name="GUIA3_34" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta34_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta34_3casi" name="GUIA3_34" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta34_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta34_3algunas" name="GUIA3_34" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta34_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta34_3casinunca" name="GUIA3_34" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta34_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta34_3nunca" name="GUIA3_34" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta35_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_35" data-toggle="tooltip" title=""></i>
                                                35. Me permiten asistir a capacitaciones relacionadas con mi trabajo

                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta35_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta35_3siempre" name="GUIA3_35" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta35_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta35_3casi" name="GUIA3_35" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta35_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta35_3algunas" name="GUIA3_35" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta35_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta35_3casinunca" name="GUIA3_35" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta35_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta35_3nunca" name="GUIA3_35" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta36_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_36" data-toggle="tooltip" title=""></i>

                                                36. Recibo capacitación útil para hacer mi <br>
                                                trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta36_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta36_3siempre" name="GUIA3_36" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta36_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta36_3casi" name="GUIA3_36" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta36_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta36_3algunas" name="GUIA3_36" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta36_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta36_3casinunca" name="GUIA3_36" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta36_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta36_3nunca" name="GUIA3_36" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con el o los jefes con quien tiene contacto.</p>
                                        </div>
                                        <div id="pregunta37_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_37" data-toggle="tooltip" title=""></i>
                                                37. Mi jefe me ayuda organizar mejor el <br>trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta37_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta37_3siempre" name="GUIA3_37" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta37_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta37_3casi" name="GUIA3_37" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta37_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta37_3algunas" name="GUIA3_37" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta37_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta37_3casinunca" name="GUIA3_37" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta37_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta37_3nunca" name="GUIA3_37" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta38_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_38" data-toggle="tooltip" title=""></i>
                                                38. Mi jefe tiene en cuenta mis puntos de<br>vista y opiniones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta38_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta38_3siempre" name="GUIA3_38" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta38_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta38_3casi" name="GUIA3_38" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta38_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta38_3algunas" name="GUIA3_38" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta38_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta38_3casinunca" name="GUIA3_38" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta38_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta38_3nunca" name="GUIA3_38" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta39_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_39" data-toggle="tooltip" title=""></i>
                                                39. Mi jefe me comunica a tiempo la <br> información relacionada con el trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta39_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta39_3siempre" name="GUIA3_39" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta39_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta39_3casi" name="GUIA3_39" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta39_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta39_3algunas" name="GUIA3_39" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta39_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta39_3casinunca" name="GUIA3_39" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta39_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta39_3nunca" name="GUIA3_39" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta40_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_40" data-toggle="tooltip" title=""></i>
                                                40. La orientación que me da mi jefe me <br>ayuda a realizar mejor mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta40_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta40_3siempre" name="GUIA3_40" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta40_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta40_3casi" name="GUIA3_40" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta40_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta40_3algunas" name="GUIA3_40" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta40_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta40_3casinunca" name="GUIA3_40" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta40_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta40_3nunca" name="GUIA3_40" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta41_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_41" data-toggle="tooltip" title=""></i>
                                                41. Mi jefe ayuda a solucionar los problemas <br> que se presentan en el trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta41_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta41_3siempre" name="GUIA3_41" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta41_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta41_3casi" name="GUIA3_41" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta41_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta41_3algunas" name="GUIA3_41" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta41_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta41_3casinunca" name="GUIA3_41" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta41_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta41_3nunca" name="GUIA3_41" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes se refieren a las relaciones con sus compañeros.</p>
                                        </div>
                                        <div id="pregunta42_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_42" data-toggle="tooltip" title=""></i>
                                                42. Puedo confiar en mis compañeros de <br> trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta42_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta42_3siempre" name="GUIA3_42" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta42_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta42_3casi" name="GUIA3_42" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta42_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta42_3algunas" name="GUIA3_42" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta42_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta42_3casinunca" name="GUIA3_42" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta42_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta42_3nunca" name="GUIA3_42" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta43_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_43" data-toggle="tooltip" title=""></i>
                                                43. Entre compañeros solucionamos los <br> problemas de trabajo de forma respetuosa
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta43_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta43_3siempre" name="GUIA3_43" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta43_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta43_3casi" name="GUIA3_43" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta43_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta43_3algunas" name="GUIA3_43" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta43_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta43_3casinunca" name="GUIA3_43" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta43_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta43_3nunca" name="GUIA3_43" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta44_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_44" data-toggle="tooltip" title=""></i>
                                                44. En mi trabajo me hacen sentir parte del<br>
                                                grupo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta44_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta44_3siempre" name="GUIA3_44" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta44_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta44_3casi" name="GUIA3_44" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta44_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta44_3algunas" name="GUIA3_44" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta44_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta44_3casinunca" name="GUIA3_44" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta44_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta44_3nunca" name="GUIA3_44" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta45_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_45" data-toggle="tooltip" title=""></i>
                                                45. Cuando tenemos que realizar trabajo de <br> equipo los compañeros colaboran
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta45_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta45_3siempre" name="GUIA3_45" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta45_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta45_3casi" name="GUIA3_45" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta45_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta45_3algunas" name="GUIA3_45" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta45_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta45_3casinunca" name="GUIA3_45" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta45_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta45_3nunca" name="GUIA3_45" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta46_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_46" data-toggle="tooltip" title=""></i>
                                                46. Mis compañeros de trabajo me ayudan <br> cuando tengo dificultades
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta46_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta46_3siempre" name="GUIA3_46" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta46_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta46_3casi" name="GUIA3_46" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta46_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta46_3algunas" name="GUIA3_46" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta46_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta46_3casinunca" name="GUIA3_46" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta46_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta46_3nunca" name="GUIA3_46" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con la información que recibe sobre su rendimiento en el trabajo, el reconocimiento, el sentido
                                                de pertenencia y la estabilidad que le ofrece su trabajo.</p>
                                        </div>
                                        <div id="pregunta47_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_47" data-toggle="tooltip" title=""></i>
                                                47. Me informan sobre lo que hago bien en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta47_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta47_3siempre" name="GUIA3_47" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta47_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta47_3casi" name="GUIA3_47" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta47_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta47_3algunas" name="GUIA3_47" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta47_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta47_3casinunca" name="GUIA3_47" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta47_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta47_3nunca" name="GUIA3_47" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta48_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_48" data-toggle="tooltip" title=""></i>
                                                48. La forma como evalúan mi trabajo en mi <br>centro de trabajo me ayuda a mejorar mi desempeño
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta48_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta48_3siempre" name="GUIA3_48" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta48_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta48_3casi" name="GUIA3_48" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta48_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta48_3algunas" name="GUIA3_48" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta48_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta48_3casinunca" name="GUIA3_48" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta48_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta48_3nunca" name="GUIA3_48" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta49_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_49" data-toggle="tooltip" title=""></i>
                                                49. En mi centro de trabajo me pagan a <br> tiempo mi salario
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta49_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta49_3siempre" name="GUIA3_49" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta49_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta49_3casi" name="GUIA3_49" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta49_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta49_3algunas" name="GUIA3_49" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta49_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta49_3casinunca" name="GUIA3_49" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta49_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta49_3nunca" name="GUIA3_49" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta50_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_50" data-toggle="tooltip" title=""></i>
                                                50. El pago que recibo es el que merezco por <br> el trabajo que realizo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta50_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta50_3siempre" name="GUIA3_50" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta50_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta50_3casi" name="GUIA3_50" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta50_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta50_3algunas" name="GUIA3_50" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta50_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta50_3casinunca" name="GUIA3_50" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta50_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta50_3nunca" name="GUIA3_50" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta51_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_51" data-toggle="tooltip" title=""></i>
                                                51. Si obtengo los resultados esperados en mi trabajo me recompensan o reconocen
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta51_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta51_3siempre" name="GUIA3_51" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta51_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta51_3casi" name="GUIA3_51" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta51_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta51_3algunas" name="GUIA3_51" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta51_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta51_3casinunca" name="GUIA3_51" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta51_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta51_3nunca" name="GUIA3_51" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta52_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_52" data-toggle="tooltip" title=""></i>
                                                52. Las personas que hacen bien el trabajo <br> pueden crecer laboralmente
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta52_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta52_3siempre" name="GUIA3_52" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta52_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta52_3casi" name="GUIA3_52" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta52_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta52_3algunas" name="GUIA3_52" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta52_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta52_3casinunca" name="GUIA3_52" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta52_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta52_3nunca" name="GUIA3_52" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta53_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_53" data-toggle="tooltip" title=""></i>
                                                53. Considero que mi trabajo es estable
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta53_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta53_3siempre" name="GUIA3_53" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta53_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta53_3casi" name="GUIA3_53" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta53_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta53_3algunas" name="GUIA3_53" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta53_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta53_3casinunca" name="GUIA3_53" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta53_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta53_3nunca" name="GUIA3_53" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta54_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_54" data-toggle="tooltip" title=""></i>
                                                54. En mi trabajo existe continua rotación de personal
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta54_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta54_3siempre" name="GUIA3_54" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta54_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta54_3casi" name="GUIA3_54" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta54_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta54_3algunas" name="GUIA3_54" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta54_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta54_3casinunca" name="GUIA3_54" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta54_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta54_3nunca" name="GUIA3_54" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta55_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_55" data-toggle="tooltip" title=""></i>
                                                55. Siento orgullo de laborar en este centro de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta55_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta55_3siempre" name="GUIA3_55" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta55_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta55_3casi" name="GUIA3_55" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta55_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta55_3algunas" name="GUIA3_55" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta55_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta55_3casinunca" name="GUIA3_55" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta55_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta55_3nunca" name="GUIA3_55" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta56_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_56" data-toggle="tooltip" title=""></i>
                                                56. Me siento comprometido con mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta56_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta56_3siempre" name="GUIA3_56" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta56_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta56_3casi" name="GUIA3_56" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta56_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta56_3algunas" name="GUIA3_56" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta56_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta56_3casinunca" name="GUIA3_56" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta56_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta56_3nunca" name="GUIA3_56" value="4">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 ">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionados con actos de violencia laboral (malos tratos, acoso,
                                                hostigamiento, acoso psicológico).</p>
                                        </div>
                                        <div id="pregunta57_3" class="mt-5 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_57" data-toggle="tooltip" title=""></i>
                                                57. En mi trabajo puedo expresarme <br> libremente sin interrupciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta57_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta57_3siempre" name="GUIA3_57" value="0">
                                                </div>
                                                <div>
                                                    <label for="preguta57_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta57_3casi" name="GUIA3_57" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta57_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta57_3algunas" name="GUIA3_57" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta57_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta57_3casinunca" name="GUIA3_57" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta57_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta57_3nunca" name="GUIA3_57" value="4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta58_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_58" data-toggle="tooltip" title=""></i>
                                                58. Recibo críticas constantes a mi persona <br> y/o trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta58_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta58_3siempre" name="GUIA3_58" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta58_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta58_3casi" name="GUIA3_58" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta58_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta58_3algunas" name="GUIA3_58" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta58_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta58_3casinunca" name="GUIA3_58" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta58_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta58_3nunca" name="GUIA3_58" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta59_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_59" data-toggle="tooltip" title=""></i>
                                                59. Recibo burlas, calumnias, difamaciones, humillaciones o ridiculizaciones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta59_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta59_3siempre" name="GUIA3_59" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta59_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta59_3casi" name="GUIA3_59" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta59_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta59_3algunas" name="GUIA3_59" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta59_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta59_3casinunca" name="GUIA3_59" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta59_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta59_3nunca" name="GUIA3_59" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta60_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_60" data-toggle="tooltip" title=""></i>
                                                <!-- 60. Se ignora mi presencia o se me excluye de <br> las reuniones de trabajo y en la toma de decisiones -->
                                                60. Se ignora mi presencia o se me excluye de las reuniones de trabajo y en la toma de decisiones
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta60_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta60_3siempre" name="GUIA3_60" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta60_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta60_3casi" name="GUIA3_60" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta60_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta60_3algunas" name="GUIA3_60" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta60_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta60_3casinunca" name="GUIA3_60" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta60_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta60_3nunca" name="GUIA3_60" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta61_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_61" data-toggle="tooltip" title=""></i>
                                                61. Se manipulan las situaciones de trabajo <br> para hacerme parecer un mal trabajador
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta61_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta61_3siempre" name="GUIA3_61" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta61_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta61_3casi" name="GUIA3_61" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta61_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta61_3algunas" name="GUIA3_61" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta61_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta61_3casinunca" name="GUIA3_61" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta61_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta61_3nunca" name="GUIA3_61" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta62_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_62" data-toggle="tooltip" title=""></i>
                                                62. Se ignoran mis éxitos laborales y se <br> atribuyen a otros trabajadores
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta62_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta62_3siempre" name="GUIA3_62" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta62_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta62_3casi" name="GUIA3_62" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta62_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta62_3algunas" name="GUIA3_62" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta62_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta62_3casinunca" name="GUIA3_62" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta62_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta62_3nunca" name="GUIA3_62" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta63_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_63" data-toggle="tooltip" title=""></i>
                                                63. Me bloquean o impiden las oportunidades que tengo para obtener ascenso o mejora en mi trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta63_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta63_3siempre" name="GUIA3_63" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta63_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta63_3casi" name="GUIA3_63" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta63_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta63_3algunas" name="GUIA3_63" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta63_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta63_3casinunca" name="GUIA3_63" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta63_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta63_3nunca" name="GUIA3_63" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta64_3" class="mt-4 guia3" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_64" data-toggle="tooltip" title=""></i>
                                                64. He presenciado actos de violencia en mi <br> centro de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta64_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta64_3siempre" name="GUIA3_64" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta64_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta64_3casi" name="GUIA3_64" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta64_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta64_3algunas" name="GUIA3_64" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta64_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta64_3casinunca" name="GUIA3_64" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta64_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta64_3nunca" name="GUIA3_64" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <hr>
                                            <p style="margin: 0; flex: 1; font-style: italic;">
                                                Las preguntas siguientes están relacionadas con la atención a clientes y usuarios.</p>
                                        </div>

                                        <div id="pregunta73_3" class="mt-5 guia3" style="display: flex; align-items: center; margin-bottom: 10px;">
                                            <p style="margin: 0; white-space: nowrap; margin-right: 10px;"><i class="fa fa-info-circle" id="Exp3_1ADI" data-toggle="tooltip" title=""></i>
                                                En mi trabajo debo brindar servicio a clientes o usuarios:
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-left: 10px;">
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi1_3si" style="line-height: 1; margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguntaadi1_3si" name="GUIA3_73" value="1" style="vertical-align: middle;" onchange="clientesyusuariosguia3()">
                                                </div>
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi1_3no" style="line-height: 1; margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguntaadi1_3no" name="GUIA3_73" value="0" style="vertical-align: middle;" onchange="clientesyusuariosguia3()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-nota">Si su respuesta fue "SI", responda las preguntas siguientes. Si su respuesta fue "NO" pase a las preguntas de la sección siguiente.
                                            </h6>
                                        </div>
                                    </div>

                                    <div id="seccion2_3" class="mt-2" style="display: none; padding: 10px;">
                                        <div id="pregunta65_3" class="mt-3 ocultas3_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_65" data-toggle="tooltip" title=""></i>
                                                65. Atiendo clientes o usuarios muy enojados
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta65_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta65_3siempre" name="GUIA3_65" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta65_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta65_3casi" name="GUIA3_65" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta65_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta65_3algunas" name="GUIA3_65" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta65_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta65_3casinunca" name="GUIA3_65" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta65_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta65_3nunca" name="GUIA3_65" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta66_3" class="mt-4 ocultas3_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_66" data-toggle="tooltip" title=""></i>
                                                66. Mi trabajo me exige atender personas muy necesitadas de ayuda o enfermas
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta66_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta66_3siempre" name="GUIA3_66" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta66_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta66_3casi" name="GUIA3_66" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta66_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta66_3algunas" name="GUIA3_66" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta66_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta66_3casinunca" name="GUIA3_66" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta66_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta66_3nunca" name="GUIA3_66" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta67_3" class="mt-4 ocultas3_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_67" data-toggle="tooltip" title=""></i>
                                                67. Para hacer mi trabajo debo demostrar sentimientos distintos a los míos
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta67_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta67_3siempre" name="GUIA3_67" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta67_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta67_3casi" name="GUIA3_67" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta67_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta67_3algunas" name="GUIA3_67" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta67_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta67_3casinunca" name="GUIA3_67" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta67_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta67_3nunca" name="GUIA3_67" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta68_3" class="mt-4 ocultas3_1" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_68" data-toggle="tooltip" title=""></i>
                                                68. Mi trabajo me exige atender situaciones de violencia
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta68_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta68_3siempre" name="GUIA3_68" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta68_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta68_3casi" name="GUIA3_68" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta68_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta68_3algunas" name="GUIA3_68" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta68_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta68_3casinunca" name="GUIA3_68" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta68_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta68_3nunca" name="GUIA3_68" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="seccion3_3" class="mt-2" style="display: block; padding: 10px;">
                                        <div id="pregunta74_3" class="mt-2 guia3" style="display: flex; align-items: center; margin-bottom: 10px;">
                                            <p style="margin: 0; white-space: nowrap; margin-right: 10px;"><i class="fa fa-info-circle" id="Exp3_2ADI" data-toggle="tooltip" title=""></i>
                                                Soy jefe de otros trabajadores:
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-left: 10px;">
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi2_3si" style="line-height: 1; margin-right: 1px;">Sí</label>
                                                    <input type="radio" id="preguntaadi2_3si" name="GUIA3_74" value="1" style="vertical-align: middle;" onchange="jefetrabajadoresguia3()">
                                                </div>
                                                <div style="display: inline-block;">
                                                    <label for="preguntaadi2_3no" style="line-height: 1; margin-right: 1px;">No</label>
                                                    <input type="radio" id="preguntaadi2_3no" name="GUIA3_74" value="0" style="vertical-align: middle;" onchange="jefetrabajadoresguia3()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-nota">Si su respuesta fue "SI", responda las preguntas siguientes. Si su respuesta fue "NO", ha concluido el cuestionario.
                                            </h6>
                                        </div>
                                    </div>


                                    <div id="seccion4_3" class="mt-2" style="display: none; padding: 10px;">
                                        <div class="mt-3">
                                            <h6>Las siguientes preguntas están relacionadas con las actitudes de los trabajadores que supervisa.
                                            </h6>
                                        </div>
                                        <div id="pregunta69_3" class="mt-4 ocultas3_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_69" data-toggle="tooltip" title=""></i>
                                                69. Comunican tarde los asuntos de trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta69_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta69_3siempre" name="GUIA3_69" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta69_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta69_3casi" name="GUIA3_69" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta69_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta69_3algunas" name="GUIA3_69" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta69_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta69_3casinunca" name="GUIA3_69" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta69_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta69_3nunca" name="GUIA3_69" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pregunta70_3" class="mt-4 ocultas3_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_70" data-toggle="tooltip" title=""></i>
                                                70. Dificultan el logro de los resultados del <br> trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta70_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta70_3siempre" name="GUIA3_70" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta70_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta70_3casi" name="GUIA3_70" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta70_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta70_3algunas" name="GUIA3_70" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta70_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta70_3casinunca" name="GUIA3_70" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta70_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta70_3nunca" name="GUIA3_70" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta71_3" class="mt-4 ocultas3_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_71" data-toggle="tooltip" title=""></i>
                                                71. Cooperan poco cuando se necesita
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta71_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta71_3siempre" name="GUIA3_71" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta71_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta71_3casi" name="GUIA3_71" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta71_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta71_3algunas" name="GUIA3_71" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta71_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta71_3casinunca" name="GUIA3_71" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta71_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta71_3nunca" name="GUIA3_71" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="pregunta72_3" class="mt-4 ocultas3_2" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 10px;">
                                            <p style="margin: 0; flex: 1;"><i class="fa fa-info-circle" id="Exp3_72" data-toggle="tooltip" title=""></i>
                                                72. Ignoran las sugerencias para mejorar <br> su trabajo
                                            </p>
                                            <div style="display: flex; align-items: center; gap: 20px;">
                                                <div>
                                                    <label for="preguta72_3siempre" class="radio-label" style="margin-right: 1px;">Siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta72_3siempre" name="GUIA3_72" value="4">
                                                </div>
                                                <div>
                                                    <label for="preguta72_3casi" class="radio-label" style="margin-right: 1px;">Casi siempre</label>
                                                    <input type="radio" class="radio-group" id="preguta72_3casi" name="GUIA3_72" value="3">
                                                </div>
                                                <div>
                                                    <label for="preguta72_3algunas" class="radio-label" style="margin-right: 1px;">Algunas veces</label>
                                                    <input type="radio" class="radio-group" id="preguta72_3algunas" name="GUIA3_72" value="2">
                                                </div>
                                                <div>
                                                    <label for="preguta72_3casinunca" class="radio-label" style="margin-right: 1px;">Casi nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta72_3casinunca" name="GUIA3_72" value="1">
                                                </div>
                                                <div>
                                                    <label for="preguta72_3nunca" class="radio-label" style="margin-right: 1px;">Nunca</label>
                                                    <input type="radio" class="radio-group" id="preguta72_3nunca" name="GUIA3_72" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" id="guardar_guia3">
                                        Guardar <i class="fa fa-save"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <div>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL EVALUACION -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- Fin modales -->
<!-- ============================================================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js"></script>


@endsection
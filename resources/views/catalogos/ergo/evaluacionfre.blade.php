@extends('template/maestra')
@section('contenido')
{{-- ========================================================================= --}}




<style type="text/css" media="screen">
    table th {
        font-size: 12px !important;
        color: #777777 !important;
        font-weight: 600 !important;
    }

    table td {
        font-size: 12px !important;
    }

    table td b {
        font-weight: 600 !important;
    }

    form label {
        color: #999999;
    }

    form #visor_mapa {
        width: 100%;
        height: 320px;
        border: 1px #DDDDDD solid;
    }

    .checkbox_warning {
        border: 2px #F00 solid;
    }

    .green-breadcrumb {
        /* background-color: #8bd249; 
    color: white; 
    padding: 5px 10px; 
    border-radius: 5px;  */
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        background-color: rgb(139, 210, 73);
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
    }

    .blue-breadcrumb {
        /* background-color: #8bd249; 
    color: white; 
    padding: 5px 10px; 
    border-radius: 5px;  */
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        background-color: rgb(0, 152, 199);
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
    }

    tr.error {
        background-color: #ffe5e5 !important;
    }
</style>



<style>
    #Tablarecoareasergo tbody td,
    #Tablarecoareasergo thead th {
        font-size: 15px !important;
    }

    #Tablarecocategoriasergo tbody td,
    #Tablarecocategoriasergo thead th {
        font-size: 15px !important;
    }

    #Tablafichasevaluacionfre tbody td,
    #Tablafichasevaluacionfre thead th {
        font-size: 15px !important;
    }

    #TablaActividadesFre {
        border-collapse: collapse !important;
        border-left: 1px solid #e9ecef !important;
    }

    #TablaActividadesFre.stylish-table>tbody>tr,
    #TablaActividadesFre.stylish-table>tbody>tr:hover,
    #TablaActividadesFre.stylish-table>tbody>tr.active {
        border-left: 1px solid #e9ecef !important;
    }

    #TablaActividadesFre>thead>tr>th:first-child,
    #TablaActividadesFre>tbody>tr>td:first-child {
        border-left: 1px solid #e9ecef !important;
    }


    #TablaImcFre {
        border-collapse: collapse !important;
    }

    #TablaImcFre>thead>tr>th,
    #TablaImcFre>tbody>tr>td {
        border: 1px solid #e9ecef !important;
        vertical-align: middle;
    }

    #TablaImcFre.stylish-table>tbody>tr {
        border-left: 1px solid #e9ecef !important;
    }
</style>



<style>
    .bloqueado:hover {
        cursor: not-allowed;
    }

    .error {
        border: 2px solid red;
    }
</style>

<div class="row">
    <div class="col-12 mt-4">
        <div class="card">
            <!-- MENU DE TABS -->
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link link_menuprincipal active" data-toggle="tab" href="#tab_1" id="tab_menu1" role="tab">
                        <span class="hidden-sm-up"><i class="ti-list"></i></span>
                        <span class="hidden-xs-down">Lista de FRE</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link_menuprincipal" data-toggle="tab" href="#tab_2" id="tab_menu2" role="tab">
                        <span class="hidden-sm-up"><i class="ti-pencil-alt"></i></span>
                        <span class="hidden-xs-down">Datos del FRE</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link_menuprincipal" data-toggle="tab" href="#tab_3" id="tab_menu3" role="tab">
                        <span class="hidden-sm-up"><i class="ti-pencil-alt"></i></span>
                        <span class="hidden-xs-down">Informe</span>
                    </a>
                </li>
            </ul>
            <!-- CONTENIDO DE TABS -->
            <div class="tab-content">
                <!-- LISTA DE RECONOCIMEITNOS -->
                <div class="tab-pane p-20 active" id="tab_1" role="tabpanel">
                    <ol class="breadcrumb m-b-10">
                        <h2 style="color: #ffff; margin: 0;"> <i class="fa fa-braille" aria-hidden="true"></i> Evaluación FRE </h2>

                    </ol>

                    <div class="table-responsive">
                        <table class="table table-hover stylish-table" width="100%" id="tabla_reconocimiento_sensorial">
                            <thead>
                                <tr>
                                    <th width="60">No.</th>
                                    <th width="130">RFC</th>
                                    <th width="110">C.P</th>
                                    <th>Folio Proyecto</th>
                                    <th>Instalación</th>
                                    <th width="70">Mostrar</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- DATOS DEL RECONOCIMIENTO -->
                <div class="tab-pane p-20" id="tab_2" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body" style="padding: 6px 10px">
                                    <table class="table" style="border: 0px #000 solid; margin: 0px;">
                                        <tbody>
                                            <tr>
                                                <td width="40" style="text-align: center; border: none;">
                                                    <span class="btn btn-success btn-circle"><i class="fa fa-file-text-o"></i></span>
                                                </td>
                                                <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                    <h4 style="margin: 0px;"><a class="text-success div_reconocimiento_folios">FOLIO</a></h4>
                                                    <small style="color: #AAAAAA; font-size: 12px;" class="div_reconocimiento_alcance">Reconocimiento</small>
                                                </td>
                                                <td width="auto" style="text-align: right; border: none; vertical-align: middle;">
                                                    <h4 style="margin: 0px;"><a class="text-success div_reconocimiento_instalacion">INSTALACIÓN</a></h4>
                                                    <small style="color: #AAAAAA; font-size: 12px;">Instalación</small>
                                                </td>
                                                <td width="40" style="text-align: center; border: none;">
                                                    <span class="btn btn-success btn-circle"><i class="fa fa-industry"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card wizard-content" style="border: none; box-shadow: 0 0 0;">
                        <!-- ============= STEPS ============= -->
                        <div style="min-width: 700px; width: 100% margin: 0px auto;">
                            <!--multisteps-form-->
                            <div class="multisteps-form">
                                <!--progress bar-->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="multisteps-form__progress">
                                            <div class="multisteps-form__progress-btn js-active" id="steps_menu_tab1">
                                                <i class="fa fa-file-text-o"></i><br>
                                                <span>Datos generales</span>
                                            </div>
                                            <div class="multisteps-form__progress-btn" id="steps_menu_tab4">
                                                <i class="fa fa-address-card"></i><br>
                                                <span>Fichas técnicas</span>
                                            </div>
                                            <div class="multisteps-form__progress-btn" id="steps_menu_tab5">
                                                <i class="fa fa-address-card"></i><br>
                                                <span>Gráficas</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!--form panels-->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="multisteps-form__form">
                                            <!--STEP 1-->
                                            <div class="multisteps-form__panel js-active" data-animation="scaleIn" id="steps_contenido_tab1">
                                                <div class="multisteps-form__content">
                                                    <form name="form_recsensorial" id="form_recsensorial" enctype="multipart/form-data" method="post">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <style type="text/css">
                                                                                .tooltip-inner {
                                                                                    max-width: 320px;
                                                                                    /*tooltip tamaño*/
                                                                                    padding: 6px 8px;
                                                                                    color: #fff;
                                                                                    text-align: justify;
                                                                                    background-color: #000;
                                                                                    border-radius: 0.25rem;
                                                                                    line-height: 16px;
                                                                                }

                                                                                #rol_lista:hover label {
                                                                                    color: #000000;
                                                                                    font-weight: bold;
                                                                                }
                                                                            </style>
                                                                            <div class="col-6 text-center" id="primeraParte" data-toggle="tooltip" title="¡Asegúrese de vincular primero el Reconocimiento con un folio de la lista de proyectos!">
                                                                                <div class="form-group">
                                                                                    <label style="font-weight: bold;font-size: 20px;">Relación a Proyecto (Folio) *</label>
                                                                                    <select class="custom-select form-control" id="proyecto_folio" name="proyecto_folio" required>
                                                                                        <option value="">&nbsp;</option>
                                                                                    </select>
                                                                                </div>


                                                                            </div>
                                                                            <div class="col-6 text-center">
                                                                                <div class="form-group" data-toggle="tooltip" title="No disponible por el momento.">
                                                                                    <label style="font-weight: bold;font-size: 20px;"> Relación a OT (Orden de trabajo)</label>
                                                                                    <select class="custom-select form-control" id="ordentrabajo_id" name="ordentrabajo_id">
                                                                                        <option value="1" disabled></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h4 class="card-title">Datos generales</h4>
                                                                        <h6 class="card-subtitle text-white m-b-0 op-5">&nbsp;</h6>
                                                                        <div class="row">
                                                                            {!! csrf_field() !!}

                                                                            <div class="col-12 mt-3 mb-3">
                                                                                <input type="hidden" class="form-control" id="recsensorial_id" name="recsensorial_id" value="0">
                                                                                <input type="hidden" class="form-control" id="tipocliente" name="tipocliente" value="1">
                                                                            </div>
                                                                            <div class="col-12 text-center" id="infoCliente">
                                                                                <!-- <style>
                                                                                    /* Estilos para el elemento select */
                                                                                    .custom-select {

                                                                                        padding: 8px;
                                                                                        /* Espacio interior */
                                                                                        border: 1px solid #ccc;
                                                                                        /* Borde */
                                                                                        border-radius: 4px;
                                                                                        /* Borde redondeado */
                                                                                    }

                                                                                    /* Estilo para las opciones cuando el mouse pasa sobre ellas */
                                                                                    .select2-results__option:hover {
                                                                                        color: #000;
                                                                                        /* Color de las letras */
                                                                                        font-size: 1.2em;
                                                                                        /* Tamaño de fuente más grande */
                                                                                        transition: all 0.3s ease-in-out;
                                                                                        /* Efecto de transición suave */
                                                                                    }

                                                                                    .select2-results__option[aria-disabled=true] {
                                                                                        opacity: 0.5;
                                                                                        /* Opacidad reducida para el texto de la opción deshabilitada */
                                                                                        color: red !important;
                                                                                        cursor: not-allowed;
                                                                                    }

                                                                                    .select2-container .select2-selection--single {
                                                                                        height: 40px;
                                                                                        /* Define la altura deseada */
                                                                                    }
                                                                                </style> -->

                                                                            </div>
                                                                            <!-- Datos del cliente Obtenidos del proyecto -->
                                                                            <input type="hidden" name="higiene" id="higiene">
                                                                            <input type="hidden" name="cliente_id" id="cliente_id">
                                                                            <input type="hidden" name="requiere_contrato" id="requiere_contrato">
                                                                            <input type="hidden" name="contrato_id" id="contrato_id">
                                                                            <input type="hidden" name="descripcion_cliente" id="descripcion_cliente">
                                                                            <input type="hidden" name="descripcion_contrato" id="descripcion_contrato">


                                                                            <input type="hidden" id="hidden_fotomapa_ruta" name="hidden_fotomapa_ruta">
                                                                            <input type="hidden" id="hidden_fotoplano_ruta" name="hidden_fotoplano_ruta">
                                                                            <input type="hidden" id="hidden_fotoinstalacion_ruta" name="hidden_fotoinstalacion_ruta">

                                                                            <!-- Guardamos la data de los clientes para poder usarla en JS -->
                                                                            <script type="text/javascript">


                                                                            </script>



                                                                            <!-- Datos del cliente -->
                                                                            <div class="col-12 mt-3 clienteblock"></div>

                                                                            <div class="col-12 " style="display: none;">
                                                                                <div class="form-group">
                                                                                    <label> Orden de trabajo / Licitacion </label>
                                                                                    <input type="text" class="form-control" id="ordenTrabajoLicitacion" name="ordenTrabajoLicitacion" placeholder="Eje: RES-OT24-XXX ó N/A" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 text-center organizacional" id="titleOrganizacionLabel">
                                                                                <h3 class="mb-2" style="font-weight: bold">La estructura organizacional depende del proyecto</h3>
                                                                            </div>


                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <div id="estructura-container" class="row mx-0">
                                                                                        <!-- Aquí se insertarán los datos -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 mt-2 p-2 d-flex justify-content-start  clienteblock">
                                                                                <h3 class="clienteblock">¿Este informe es para el cliente seleccionado?</h3>
                                                                                <div class="form-check mx-4 clienteblock">
                                                                                    <input class="form-check-input" type="radio" name="informe_del_cliente" id="informe_del_cliente_si" value="1" checked>
                                                                                    <label class="form-check-label" for="informe_del_cliente_si">
                                                                                        Si
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mx-4 clienteblock">
                                                                                    <input class="form-check-input" type="radio" name="informe_del_cliente" id="informe_del_cliente_no" value="0">
                                                                                    <label class="form-check-label" for="informe_del_cliente_no">
                                                                                        No
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-4 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Empresa *</label>
                                                                                    <input type="text" class="form-control" id="empresa" name="empresa" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> R.F.C. *</label>
                                                                                    <input type="text" class="form-control" id="rfc" name="rfc" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Orden servicio </label>
                                                                                    <input type="text" class="form-control" id="ordenservicio" name="ordenservicio" placeholder="Eje: CEN-004-2022 ó N/A">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Repr. legal *</label>
                                                                                    <input type="text" class="form-control" id="representantelegal" name="representantelegal" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Repr. Seg. Industrial *</label>
                                                                                    <input type="text" class="form-control" id="representanteseguridad" name="representanteseguridad" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Instalación *</label>
                                                                                    <input type="text" class="form-control" id="instalacion" name="instalacion" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Dirección de la instalación *</label>
                                                                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Código postal *</label>
                                                                                    <input type="number" class="form-control" id="codigopostal" name="codigopostal" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label>Coordenadas *</label>

                                                                                    <input type="text" class="form-control" id="coordenadas" name="coordenadas" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Actividad principal *</label>
                                                                                    <textarea class="form-control" rows="4" id="actividadprincipal" name="actividadprincipal" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Descripción del proceso en la instalación *</label>
                                                                                    <textarea class="form-control" rows="4" id="descripcionproceso" name="descripcionproceso" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Observación sobre el horario del personal *</label>
                                                                                    <textarea class="form-control" rows="3" id="observaciones" name="observaciones" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Fecha inicio del reconocimiento *</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="fechainicio" name="fechainicio" required>
                                                                                        <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 clienteblock">
                                                                                <div class="form-group">
                                                                                    <label> Fecha fin del reconocimiento *</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="fechafin" name="fechafin" required>
                                                                                        <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 clienteblock">
                                                                <div class="row">
                                                                    <div class="col-12" id="seccion_foto_ubicacion">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: -4px; margin-left: 160px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar mapa ubicación" id="boton_descargarmapaubicacion"></i>
                                                                                <h4 class="card-title">Mapa ubicación </h4>
                                                                                <div class="row">
                                                                                    <div class="col-12 clienteblock">
                                                                                        <div class="form-group">
                                                                                            <style type="text/css" media="screen">
                                                                                                .dropify-wrapper {
                                                                                                    height: 300px !important;
                                                                                                    /*tamaño estatico del campo foto*/
                                                                                                }
                                                                                            </style>
                                                                                            <input type="file" accept="image/jpeg,image/x-png,image/gif" id="inputfotomapa" name="inputfotomapa" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 clienteblock" id="seccion_foto_plano">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: -4px; margin-left: 160px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF, -1px 0px 0 #FFFFFF, 0px -1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar plano instalación" id="boton_descargarplanoinstalacion"></i>
                                                                                <h4 class="card-title">Plano instalación <br> con áreas </h4>
                                                                                <div class="row">
                                                                                    <div class="col-12 clienteblock">
                                                                                        <div class="form-group">
                                                                                            <style type="text/css" media="screen">
                                                                                                .dropify-wrapper {
                                                                                                    height: 300px !important;
                                                                                                    /*tamaño estatico del campo foto*/
                                                                                                }
                                                                                            </style>
                                                                                            <input type="file" accept="image/jpeg,image/x-png,image/gif" id="inputfotoplano" name="inputfotoplano" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 clienteblock" id="seccion_foto_instalacion">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: -4px; margin-left: 160px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar foto instalación" id="boton_descargarfotoinstalacion"></i>
                                                                                <h4 class="card-title">Foto instalación </h4>
                                                                                <div class="row">
                                                                                    <div class="col-12 clienteblock">
                                                                                        <div class="form-group">
                                                                                            <style type="text/css" media="screen">
                                                                                                .dropify-wrapper {
                                                                                                    height: 300px !important;
                                                                                                    /*tamaño estatico del campo foto*/
                                                                                                }
                                                                                            </style>
                                                                                            <input type="file" accept="image/jpeg,image/x-png,image/gif" id="inputfotoinstalacion" name="inputfotoinstalacion" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>



                                                        </div>
                                                        <!-- Botones de envio y desactivacion -->
                                                        <div class="row">

                                                            <div class="col-12">
                                                                @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Coordinador FRE']))
                                                                <div class="form-group" style="text-align: right;">
                                                                    <button type="submit" class="btn btn-danger botonguardar_modulorecsensorial" id="boton_guardar_recsensorial">
                                                                        Guardar <i class="fa fa-save"></i>
                                                                    </button>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>



                                            <!--STEP 4-->
                                            <div class="multisteps-form__panel" data-animation="scaleIn" id="steps_contenido_tab4">
                                                <div class="multisteps-form__content">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Coordinador FRE','Especialista FRE']))

                                                            <ol class="breadcrumb m-b-10">
                                                                <h2 style="color: #ffff; margin: 0;"><i class="fa fa-user"></i> Fichas técnicas</h2>
                                                            </ol>
                                                            @else
                                                            <ol class="breadcrumb m-b-10">
                                                                <h2 style="color: #ffff; margin: 0;"><i class="fa fa-user"></i> Fichas técnicas </h2>
                                                            </ol>
                                                            @endif
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover stylish-table" width="100%" id="Tablafichasevaluacionfre">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 60px!important;">No.</th>
                                                                            <th>No.PE</th>
                                                                            <th>Área</th>
                                                                            <th>Categoría</th>
                                                                            <th>Nombre del empleado </th>
                                                                            <th>Ficha / No empleado</th>
                                                                            <th style="width: 80px!important;">Visualizar</th>
                                                                            <th style="width: 80px!important;">Iniciar FRE</th>
                                                                            <th>Estatus FRE</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="5">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="multisteps-form__panel mt-4" data-animation="scaleIn" id="steps_contenido_tab5">
                                                <div class="multisteps-form__content">
                                                    <div class="row">

                                                        <style>
                                                            .mapa-corporal {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo1 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }

                                                            .porcentaje {
                                                                position: absolute;
                                                                font-size: 12px;
                                                                font-weight: bold;
                                                                color: #ffffff;
                                                                background: #FF585D;
                                                                padding: 2px 6px;
                                                                border: 2px solid #000;
                                                                border-radius: 25px;
                                                                width: 70px;
                                                                text-align: center;

                                                            }

                                                            /* DERECHA */

                                                            .cuellop1 {

                                                                top: 138px;
                                                                left: 412px;

                                                            }

                                                            .dorsalp1 {

                                                                top: 245px;
                                                                left: 441px;

                                                            }

                                                            .manop1 {

                                                                top: 356px;
                                                                left: 460px;

                                                            }

                                                            .caderap1 {

                                                                top: 453px;
                                                                left: 463px;

                                                            }

                                                            .tobillop1 {

                                                                top: 645px;
                                                                left: 438px;

                                                            }


                                                            /* IZQUIERDA */

                                                            .hombrop1 {

                                                                top: 191px;
                                                                left: 14px;

                                                            }

                                                            .codop1 {

                                                                top: 289px;
                                                                left: 8px;

                                                            }

                                                            .lumbarp1 {

                                                                top: 368px;
                                                                left: -5px;

                                                            }

                                                            .rodillap1 {

                                                                top: 507px;
                                                                left: 18px;

                                                            }
                                                        </style>


                                                        <div class="col-lg-4 col-md-6 mb-4">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta1','Pregunta 1')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta1">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        1.- ¿En algún momento durante los últimos 12 meses, ha tenido problemas (dolor, molestias, disconfort) ?
                                                                    </h6>
                                                                    <div class="mapa-corporal">
                                                                        <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="img-cuerpo1">
                                                                        <span class="porcentaje cuellop1" id="CUELLOP1"></span>
                                                                        <span class="porcentaje hombrop1" id="HOMBREOP1"></span>
                                                                        <span class="porcentaje dorsalp1" id="DORSALP1"></span>
                                                                        <span class="porcentaje codop1" id="CODOP1"></span>
                                                                        <span class="porcentaje manop1" id="MANOP1"></span>
                                                                        <span class="porcentaje lumbarp1" id="LUMBARP1"></span>
                                                                        <span class="porcentaje caderap1" id="CADERAP1"></span>
                                                                        <span class="porcentaje rodillap1" id="RODILLAP1"></span>
                                                                        <span class="porcentaje tobillop1" id="TOBILLOP1"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <style>
                                                            .mapa-corporal2 {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo2 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }

                                                            /* DERECHA */

                                                            .cuellop2 {

                                                                top: 138px;
                                                                left: 412px;

                                                            }

                                                            .dorsalp2 {

                                                                top: 245px;
                                                                left: 441px;

                                                            }

                                                            .manop2 {

                                                                top: 356px;
                                                                left: 460px;

                                                            }

                                                            .caderap2 {

                                                                top: 453px;
                                                                left: 463px;

                                                            }

                                                            .tobillop2 {

                                                                top: 645px;
                                                                left: 438px;

                                                            }


                                                            /* IZQUIERDA */

                                                            .hombrop2 {

                                                                top: 191px;
                                                                left: 14px;

                                                            }

                                                            .codop2 {

                                                                top: 289px;
                                                                left: 8px;

                                                            }

                                                            .lumbarp2 {

                                                                top: 368px;
                                                                left: -5px;

                                                            }

                                                            .rodillap2 {

                                                                top: 507px;
                                                                left: 18px;

                                                            }
                                                        </style>

                                                        <div class="col-lg-4 col-md-6 mb-4">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta2','Pregunta 2')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta2">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        2.- ¿En algún momento, durante los últimos 12 meses, ha tenido algún impedimento para hacer su trabajo normal (en casa o fuera de casa) debido a sus molestias?
                                                                    </h6>
                                                                    <div class="mapa-corporal2">
                                                                        <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="img-cuerpo2">
                                                                        <span class="porcentaje cuellop2" id="CUELLOP2"></span>
                                                                        <span class="porcentaje hombrop2" id="HOMBREOP2"></span>
                                                                        <span class="porcentaje dorsalp2" id="DORSALP2"></span>
                                                                        <span class="porcentaje codop2" id="CODOP2"></span>
                                                                        <span class="porcentaje manop2" id="MANOP2"></span>
                                                                        <span class="porcentaje lumbarp2" id="LUMBARP2"></span>
                                                                        <span class="porcentaje caderap2" id="CADERAP2"></span>
                                                                        <span class="porcentaje rodillap2" id="RODILLAP2"></span>
                                                                        <span class="porcentaje tobillop2" id="TOBILLOP2"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <style>
                                                            .mapa-corporal3 {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo3 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }

                                                            /* DERECHA */

                                                            .cuellop3 {

                                                                top: 138px;
                                                                left: 412px;

                                                            }

                                                            .dorsalp3 {

                                                                top: 245px;
                                                                left: 441px;

                                                            }

                                                            .manop3 {

                                                                top: 356px;
                                                                left: 460px;

                                                            }

                                                            .caderap3 {

                                                                top: 453px;
                                                                left: 463px;

                                                            }

                                                            .tobillop3 {

                                                                top: 645px;
                                                                left: 438px;

                                                            }


                                                            /* IZQUIERDA */

                                                            .hombrop3 {

                                                                top: 191px;
                                                                left: 14px;

                                                            }

                                                            .codop3 {

                                                                top: 289px;
                                                                left: 8px;

                                                            }

                                                            .lumbarp3 {

                                                                top: 368px;
                                                                left: -5px;

                                                            }

                                                            .rodillap3 {

                                                                top: 507px;
                                                                left: 18px;

                                                            }
                                                        </style>

                                                        <div class="col-lg-4 col-md-6 mb-4">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta3','Pregunta 3')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta3">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        3.- ¿En algún momento, durante los últimos 7 días, ha tenido algún impedimento para hacer su trabajo normal debido a sus molestias?
                                                                    </h6>
                                                                    <div class="mapa-corporal3">
                                                                        <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="img-cuerpo3">
                                                                        <span class="porcentaje cuellop3" id="CUELLOP3"></span>
                                                                        <span class="porcentaje hombrop3" id="HOMBREOP3"></span>
                                                                        <span class="porcentaje dorsalp3" id="DORSALP3"></span>
                                                                        <span class="porcentaje codop3" id="CODOP3"></span>
                                                                        <span class="porcentaje manop3" id="MANOP3"></span>
                                                                        <span class="porcentaje lumbarp3" id="LUMBARP3"></span>
                                                                        <span class="porcentaje caderap3" id="CADERAP3"></span>
                                                                        <span class="porcentaje rodillap3" id="RODILLAP3"></span>
                                                                        <span class="porcentaje tobillop3" id="TOBILLOP3"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta3">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>




                                                        <style>
                                                            .mapa-corporal4 {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo4 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }



                                                            .lumbarp4 {

                                                                top: 338px;
                                                                left: 4px;

                                                            }
                                                        </style>

                                                        <div class="col-lg-4 col-md-6 mb-4 mt-5">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta4','Pregunta 4')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta4">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        4.- COLUMNA LUMBAR (Espalda baja) </h6>
                                                                    <div class="mapa-corporal4">
                                                                        <img src="{{ asset('assets/images/ergo/COLUMNA LUMBAR.png') }}" class="img-cuerpo4">
                                                                        <span class="porcentaje lumbarp4" id="LUMBARP4"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta4">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <style>
                                                            .mapa-corporal5 {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo5 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }



                                                            .cuellop5 {

                                                                top: 110px;
                                                                left: 408px;

                                                            }
                                                        </style>

                                                        <div class="col-lg-4 col-md-6 mb-4 mt-5">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta5','Pregunta 5')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta5">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        5.- CUELLO </h6>
                                                                    <div class="mapa-corporal5">
                                                                        <img src="{{ asset('assets/images/ergo/CUELLO.png') }}" class="img-cuerpo5">
                                                                        <span class="porcentaje cuellop5" id="CUELLOP5"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <style>
                                                            .mapa-corporal6 {

                                                                position: relative;
                                                                width: 768px;
                                                                margin: auto;

                                                            }

                                                            .img-cuerpo6 {
                                                                width: 51%;
                                                                display: block;
                                                                margin-left: 64px;
                                                            }



                                                            .hombrop6 {

                                                                top: 151px;
                                                                left: 14px;

                                                            }
                                                        </style>

                                                        <div class="col-lg-4 col-md-6 mb-4 mt-5">
                                                            <button class="btn btn-danger waves-effect waves-light" onclick="descargarCard('cardPregunta6','Pregunta 6')">
                                                                Descargar <i class="fa fa-save"></i>
                                                            </button>
                                                            <div class="card shadow h-100" id="cardPregunta6">
                                                                <div class="card-body">
                                                                    <h6 class="text-center font-weight-bold mb-3">
                                                                        6.-HOMBROS </h6>
                                                                    <div class="mapa-corporal6">
                                                                        <img src="{{ asset('assets/images/ergo/HOMBRO.png') }}" class="img-cuerpo6">
                                                                        <span class="porcentaje hombrop6" id="HOMBROP6"></span>
                                                                    </div>
                                                                    <hr>
                                                                    <div id="tablaPregunta6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div> -->


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============= /STEPS ============= -->
                    </div>
                </div> <!-- /FIN TAB 2 -->

                <div class="tab-pane p-20" id="tab_3" role="tabpanel">

                    <style type="text/css">
                        .reporte_iluminacion {
                            font-size: 14px !important;
                            line-height: 14px;
                        }

                        .list-group-item {
                            padding: 2px 1px;
                            font-family: Agency FB;
                            /*font-family: Calibri;*/
                            font-size: 0.55vw !important;
                            line-height: 1;
                        }

                        .list-group-item.active {
                            font-size: 1.2vw !important;
                        }

                        .list-group-item i {
                            color: #fc4b6c;
                        }

                        .list-group-item:hover {
                            font-size: 1.2vw !important;
                        }

                        .list-group .submenu {
                            padding: 2px 1px 2px 8px;
                        }

                        .list-group .subsubmenu {
                            padding: 2px 1px 2px 20px;
                        }

                        .form-group {
                            margin: 0px 0px 12px 0px !important;
                            padding: 0px !important;
                        }

                        .form-group label {
                            margin: 0px !important;
                            padding: 0px 0px 3px 0px !important;
                        }


                        p.justificado {
                            text-align: justify !important;
                            margin: 0px !important;
                            padding: 0px !important;
                        }


                        div.informacion_estatica {
                            font-size: 14px;
                            line-height: 14px !important;
                            text-align: justify;
                        }

                        div.informacion_estatica .imagen_formula {
                            text-align: center;
                        }

                        div.informacion_estatica b {
                            font-size: 13px;
                            font-weight: bold;
                            color: #777777;
                        }

                        .tabla_info_centrado th {
                            background: #F9F9F9;
                            border: 1px #E5E5E5 solid !important;
                            padding: 2px !important;
                            text-align: center;
                            vertical-align: middle;
                        }

                        .tabla_info_centrado td {
                            border: 1px #E5E5E5 solid !important;
                            padding: 4px !important;
                            text-align: center;
                            vertical-align: middle;
                        }

                        .tabla_info_justificado th {
                            background: #F9F9F9;
                            border: 1px #E5E5E5 solid !important;
                            padding: 2px !important;
                            text-align: center;
                            vertical-align: middle;
                        }

                        .tabla_info_justificado td {
                            border: 1px #E5E5E5 solid !important;
                            padding: 4px !important;
                            text-align: justify;
                            vertical-align: middle;
                        }
                    </style>

                    <div class="row" class="reporte_iluminacion">
                        <div class="col-xlg-2 col-lg-3 col-md-5">
                            <div class="stickyside">
                                <div class="list-group" id="top-menu">
                                    <a href="#0" class="list-group-item active">Portada <i class="fa" id="menureporte_0"></i></a>
                                    <a href="#1" class="list-group-item">1.- Introducción <i class="fa" id="menureporte_1"></i></a>
                                    <a href="#2" class="list-group-item">2.- Definiciones <i class="fa" id="menureporte_2"></i></a>
                                    <a href="#3" class="list-group-item">3.- Objetivos</a>
                                    <a href="#3_1" class="list-group-item submenu">3.1.- Objetivo general <i class="fa" id="menureporte_3_1"></i></a>
                                    <a href="#3_2" class="list-group-item submenu">3.2.- Objetivos específicos <i class="fa" id="menureporte_3_2"></i></a>
                                    <a href="#4" class="list-group-item">4.- Metodología</a>
                                    <a href="#5" class="list-group-item">5.- Reconocimiento</a>
                                    <a href="#5_1" class="list-group-item submenu">5.1.- Ubicación de la instalación<i class="fa" id="menureporte_5_1"></i></a>
                                    <a href="#5_2" class="list-group-item submenu">5.2.- Descripción del proceso en la instalación <i class="fa " id="menureporte_5_2"></i></a>
                                    <a href="#5_3" class="list-group-item submenu">5.3.- Ciclos de trabajo de las categorías a evaluar <i class="fa " id="menureporte_5_3"></i></a>
                                    <a href="#6" class="list-group-item">6.- Evaluación</a>
                                    <a href="#6_1" class="list-group-item submenu">6.1.- Condiciones de operación durante la evaluación <i class="fa " id="menureporte_6_1"></i></a>
                                    <a href="#6_2" class="list-group-item submenu">6.2.- Variables antropométricas (peso y talla) <i class="fa " id="menureporte_6_2"></i></a>
                                    <a href="#6_3" class="list-group-item submenu">6.3.- Registro de trastornos músculo esqueléticos <i class="fa " id="menureporte_6_3"></i></a>


                                    <a href="#7" class="list-group-item">7.- Categorías evaluadas <i class="fa " id="menureporte_7"></i></a>
                                    <a href="#7_1" class="list-group-item submenu">7.1.- Método de ergonomía aplicado<i class="fa " id="menureporte_7_1"></i></a>
                                    <a href="#7_2" class="list-group-item submenu">7.2.- Resultados de la aplicación del método<i class="fa " id="menureporte_7_2"></i></a>
                                    <a href="#8" class="list-group-item">8.- Conclusiones <i class="fa" id="menureporte_8"></i></a>
                                    <a href="#9" class="list-group-item">9.- Recomendaciones de control <i class="fa" id="menureporte_9"></i></a>
                                    <a href="#10" class="list-group-item">10.- Responsables del informe <i class="fa" id="menureporte_10"></i></a>
                                    <a href="#11" class="list-group-item">11.- Anexos <i class="fa" id="menureporte_11"></i></a>
                                    <a href="#11_1" class="list-group-item submenu">11.1.- Anexo 1 Equipo utilizado en la medición <i class="fa " id="menureporte_11_1"></i></a>
                                    <a href="#12" class="list-group-item">12.- Generar informe <i class="fa" id="menureporte_12"></i></a>



                                </div>
                            </div>
                        </div>
                        <div class="col-xlg-10 col-lg-9 col-md-7">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body" style="padding: 6px 10px">
                                            <table class="table" style="border: 0px #000 solid; margin: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <td width="40" style="text-align: center; border: none;">
                                                        </td>
                                                        <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                        </td>
                                                        <td width="auto" style="text-align: right; border: none; vertical-align: middle;">
                                                            <h4 style="margin: 0px;"><a class="text-success div_reconocimiento_instalacion">INSTALACIÓN</a></h4>
                                                            <small style="color: #AAAAAA; font-size: 12px;">Instalación</small>
                                                        </td>
                                                        <td width="40" style="text-align: center; border: none;">
                                                            <span class="btn btn-success btn-circle"><i class="fa fa-industry"></i></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="padding: 0px!important;" id="0">Portadas</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_portada" id="form_informe_portada">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                            </div>

                                            <div class="row w-100">
                                                <div class="col-5">
                                                    <div class="col-12">
                                                        <label> Imagen Portada Exterior * </label>
                                                        <div class="form-group">
                                                            <style type="text/css" media="screen">
                                                                .dropify-wrapper {
                                                                    height: 400px !important;
                                                                    /*tamaño estatico del campo foto*/
                                                                }
                                                            </style>
                                                            <input type="file" accept="image/jpeg,image/x-png" id="RUTA_IMAGEN_PORTADA" name="RUTA_IMAGEN_PORTADA" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-7">
                                                    <div class="col-12">
                                                        <h3 class=" mt-1 mb-4">Selecciona hasta 5 opciones (Cuerpo del Encabezado en el Informe)</h3>
                                                    </div>

                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label> Nivel 1 </label>
                                                            <select class="custom-select form-control" style="width: 90%;" id="NIVEL1" name="NIVEL1">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label> Nivel 2 </label>
                                                            <select class="custom-select form-control" style="width: 90%;" id="NIVEL2" name="NIVEL2">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label> Nivel 3 </label>
                                                            <select class="custom-select form-control" style="width: 90%;" id="NIVEL3" name="NIVEL3">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label> Nivel 4 </label>
                                                            <select class="custom-select form-control" style="width: 90%;" id="NIVEL4" name="NIVEL4">

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label> Nivel 5 </label>
                                                            <select class="custom-select form-control" style="width: 90%;" id="NIVEL5" name="NIVEL5">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <h3 class="mx-4 mt-5 mb-4">Seleccione las opciones que desee mostrar en la Portada Interna del Informe</h3>



                                            <div class="row w-100 mt-4">
                                                <div class="col-8">
                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 1 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA1" name="OPCION_PORTADA1">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 2 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA2" name="OPCION_PORTADA2">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 3 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA3" name="OPCION_PORTADA3">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 4 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA4" name="OPCION_PORTADA4">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 5 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA5" name="OPCION_PORTADA5">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label> Opción 6 </label>
                                                            <select class="custom-select form-control" style="width: 80%;" id="OPCION_PORTADA6" name="OPCION_PORTADA6">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="col-12 text-center mt-4">
                                                        <div class="form-group">
                                                            <label>Mes</label>
                                                            <select class="custom-select form-control" id="INFORME_MES" name="INFORME_MES">
                                                                <option value="" selected disabled></option>
                                                                <option value="Enero">Enero</option>
                                                                <option value="Febrero">Febrero</option>
                                                                <option value="Marzo">Marzo</option>
                                                                <option value="Abril">Abril</option>
                                                                <option value="Mayo">Mayo</option>
                                                                <option value="Junio">Junio</option>
                                                                <option value="Julio">Julio</option>
                                                                <option value="Agosto">Agosto</option>
                                                                <option value="Septiembre">Septiembre</option>
                                                                <option value="Octubre">Octubre</option>
                                                                <option value="Noviembre">Noviembre</option>
                                                                <option value="Diciembre">Diciembre</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-center mt-4 mb-4">
                                                        <label> <b>del</b></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <div class="form-group">
                                                            <label>Año</label>
                                                            <select class="custom-select form-control" id="INFORME_ANIO" name="INFORME_ANIO">
                                                                <option value="" selected disabled></option>
                                                                <script>
                                                                    const currentYear = new Date().getFullYear();
                                                                    for (let i = currentYear; i >= 2017; i--) {
                                                                        document.write('<option value="' + i + '">' + i + '</option>');
                                                                    }
                                                                </script>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_portada">Guardar portadas <i class="fa fa-save"></i></button>
                                            </div> -->
                                        </div>
                                    </form>
                                    <h4 class="card-title" id="1">1.- Introducción</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_introduccion" id="form_informe_introduccion">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! csrf_field() !!}


                                                    <textarea class="form-control"
                                                        style="margin-bottom: 0px;"
                                                        rows="20"
                                                        id="INFORME_INTRODUCCION"
                                                        name="INFORME_INTRODUCCION"
                                                        required><p>Los factores de riesgo ergonómico contribuyen a la aparición de enfermedades de tipo músculo esquelético, según los datos revelados por la Organización Internacional del Trabajo (OIT) estos a nivel mundial representan una de las principales causas de enfermedad laboral, seguido por exposición a material particulado, los gases, los humos, y el ruido (Discroll, 2018). Por otra parte, la OMS indicó que a nivel mundial cerca del 20% de los dolores lumbares y cervicales son atribuibles a exposiciones en el trabajo (2018).</p>

<p>De acuerdo con el Instituto Mexicano del Seguro Social (IMSS) en 2020, se registraron más de 100.000 casos nuevos de enfermedades laborales, la naturaleza de la lesión indica que hay un número importante de enfermedades que se agrupan como trastornos músculo-esqueléticos (TME), entre ellas, síndrome del túnel carpiano, lesiones de hombro, tenosinovitis del pulgar (“De Quervain”), bursitis, epicondilitis y artrosis; por tal razón los TME representa en la actualidad un importante tipo de enfermedad laboral que afecta a la planta laboral de México. </p>

<p>En México el Reglamento Federal de Seguridad y Salud en el trabajo (RFST), publicado en el Diario Oficial de la Federación (DOF) el día 13 de noviembre de 2014, establece en su artículo 42, que las empresas deben contar con un análisis de los Factores de Riesgo Ergonómico de los puestos de trabajo. Además, la NOM-036-1-STPS-2018 establece los elementos para identificar, analizar, prevenir y controlar los factores de riesgo ergonómico en los centros de trabajo derivados del manejo manual de cargas, a efecto de prevenir alteraciones a la salud de los trabajadores, y aplica en los centros de trabajo donde existan trabajadores cuya actividad implique realizar manejo manual de cargas de forma cotidiana (más de una vez al día); así mismo la LEY SILLA - DOF 19/12/24 en lo referente a el empleador.</p>

<p>Dentro del medio ambiente laboral existen condiciones de riesgo de tipo ergonómico, que de no encontrarse identificados pueden poner en riesgo la salud y la productividad del trabajador; por lo que la identificación temprana y el establecimiento de estrategias de control son primordiales para mantener una condición de trabajo óptima.</p>

<p>En el presente estudio se describen los resultados y evidencias obtenidas posterior a haber identificado el riesgo y peligro ergonómico por medio de las fichas de la ISO-TR 12295-2014 (Reconocimiento); posteriormente se aplican métodos ergonómicos específicos que permiten identificar el riesgo ergonómico para que la empresa tome las medidas preventivas respectivas</p> </textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_introduccion">Guardar introducción <i class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- ======== ELIMINAR DESPUES DE SUBIR AL SERVIDOR =============-->
                                    <div class="col-12 mt-4" style="text-align: center; display: none;">
                                        <button type="submit" class="btn btn-info waves-effect waves-light" id="btn_descargar_plantilla">Descargar plantilla principal <i class="fa fa-download"></i></button>
                                    </div>
                                    <!-- ======== ELIMINAR DESPUES DE SUBIR AL SERVIDOR =============-->

                                    <h4 class="card-title" id="2">2.- Definiciones</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <form enctype="multipart/form-data" method="post" name="form_informe_listadefiniciones" id="form_informe_listadefiniciones">
                                                <div class="row mb-3">
                                                    <table class="table-sm" style="width: 96%; table-layout: fixed;">
                                                        <table class="table-hover tabla_info_centrado" width="100%" id="tabla_reporte_definiciones">
                                                            <thead>
                                                                <tr>
                                                                    <th width="130">Concepto</th>
                                                                    <th>Descripción / Fuente</th>
                                                                    <th width="80">Activo</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($catdefiniciones as $dato)
                                                                <tr>
                                                                    <td>
                                                                        {{ $dato->CONCEPTO_DEFINICION }}
                                                                    </td>

                                                                    <td class="justificado">
                                                                        {{ $dato->DESCRIPCION_DEFINICION }}

                                                                        @if($dato->FUENTE_DEFINICION)
                                                                        <br>
                                                                        <span style="font-style: italic; color: gray;">
                                                                            Fuente: {{ $dato->FUENTE_DEFINICION }}
                                                                        </span>
                                                                        @endif
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <div class="switch">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="recomendacion_checkbox"
                                                                                    name="DEFINICONES_INFORME[]"
                                                                                    value="{{ $dato->ID_DEFINICIONES }}"
                                                                                    onclick="activa_recomendacion(this);"
                                                                                    {{ $dato->ACTIVO == 1 ? '' : '' }}>
                                                                                <span class="lever switch-col-light-blue"></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                </div>
                                                <div class="col-12" style="text-align: right;">
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_definiciones">Guardar definiciones <i class="fa fa-save"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <h4 class="card-title mt-2" id="3">3.- Objetivos</h4>
                                    <h4 class="card-title" id="3_1">3.1.- Objetivo general</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_objetivogeneral" id="form_informe_objetivogeneral">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! csrf_field() !!}
                                                    <textarea
                                                        class="form-control"
                                                        style="margin-bottom: 0px;"
                                                        rows="8"
                                                        id="INFORME_OBJETIVOGENERALES"
                                                        name="INFORME_OBJETIVOGENERALES"
                                                        required>Evaluar los factores de riesgo ergonómicos de las actividades laborales que impliquen postura, movimientos repetitivos, manipulación manual de cargas y fuerza manual, mediante el análisis biomecánico y aplicación de métodos de carga física para la prevención de trastornos músculo esqueléticos de origen laboral.</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_objetivogeneral">Guardar objetivo general <i class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title" id="3_2">3.2.- Objetivos específicos</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_objetivoespecifico" id="form_informe_objetivoespecifico">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! csrf_field() !!}

                                                    <textarea
                                                        class="form-control"
                                                        style="margin-bottom: 0px;"
                                                        rows="12"
                                                        id="INFORME_OBJETIVOSESPECIFICOS"
                                                        name="INFORME_OBJETIVOSESPECIFICOS"
                                                        required>•	A partir de la ISO TR 12295 como insumo de identificación de los peligros y riesgos ergonómicos, el riesgo Elevado, se someterá a valoraciones ergonómicas con métodos específicos de cuantificación del riesgo. 

•	Determinar el nivel de riesgo por carga física a la cual se encuentran expuestos los trabajadores de cada planta objeto del estudio en las tareas que son analizadas

•	Generar recomendaciones derivadas de la cuantificación del riesgo ergonómico para mitigar la probabilidad de ocurrencia de Trastornos Músculo Esqueléticos (TME) de origen laboral.

•	Estudiar la relación del riesgo Biomecánicos de acuerdo a los criterios de la NOM-036-1-SPTS-2018, ISO-TR-12295 y la LEY SILLA DOF 19/12/24.</textarea>

                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_objetivoespecifico">Guardar objetivos específicos <i class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title" id="4">4.- Metodología</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_reporte_metodologia_4_1" id="form_reporte_metodologia_4_1">
                                        <div class="row">
                                            <div class="col-12">

                                                <p>
                                                    Con el objetivo de recabar la información de forma objetiva se procedió de la siguiente manera:
                                                </p>

                                                <p>
                                                    <strong>a)</strong> Entrevista al trabajador donde se tiene en cuenta los siguientes aspectos:
                                                </p>

                                                <ul style="list-style-type: circle;">
                                                    <li>
                                                        Datos personales, generales y antecedentes laborales.
                                                    </li>
                                                    <li>
                                                        Actividad laboral ejecutada de acuerdo con la categoría, con el fin de identificar la presencia de factores de riesgo ergonómico.
                                                    </li>
                                                    <li>
                                                        Percepción de condiciones ambientales del lugar de trabajo.
                                                    </li>
                                                    <li>
                                                        Reporte de molestias músculo esqueléticas por medio de “Standardised Nordic questionnaires for the analysis of musculoskeletal symptoms” de Kuorinka et col, por Jaime Ibacache Araya, Profesional Ergónomo del Instituto de Salud Pública de Chile.
                                                    </li>
                                                    <li>
                                                        Medición de composición corporal (estatura y peso).
                                                    </li>
                                                </ul>

                                                <p>
                                                    <strong>b)</strong> Inspección visual de los puestos de trabajo operativo y/o de oficina, para:
                                                </p>

                                                <ul style="list-style-type: circle;">
                                                    <li>
                                                        Tomar medidas de los planos y alcances utilizando una cinta métrica.
                                                    </li>
                                                    <li>
                                                        Tomar registro fotográfico y de video de la actividad laboral a evaluar,
                                                        con énfasis en los criterios de la carga física.
                                                    </li>
                                                </ul>

                                                <p>
                                                    <strong>c)</strong> Valoración de Fuerza de Miembros Superiores por medio de Dinamometría Manual (Digital).
                                                </p>

                                                <p>
                                                    <strong>d)</strong> Valoración de la Escala de Borg de acuerdo con las tareas ergonómicas analizadas dentro de su ejercicio laboral.
                                                </p>

                                                <p>
                                                    <strong>e)</strong> Aplicación del método de evaluación específico en ergonomía.
                                                </p>

                                                <ul style="list-style-type: circle;">
                                                    <li>
                                                        En la visita a campo se utiliza la lista de verificación ergonómica según aplique a cada una de las categorías objeto de evaluación.
                                                    </li>
                                                </ul>

                                                <p>
                                                    <strong>f)</strong> Análisis de la situación de trabajo de cada una de las categorías y estimación del riesgo ergonómico.
                                                </p>

                                                <ul style="list-style-type: circle;">
                                                    <li>
                                                        Elaboración del documento de evaluación de factores de riesgo ergonómico con sus respectivas conclusiones y recomendaciones para prevenir los riesgos ergonómicos detectados durante la evaluación.
                                                    </li>
                                                </ul>

                                                <p>
                                                    <strong>g)</strong> Aplicación de criterios de la Ley Silla: DOF 19/12/24.
                                                </p>

                                            </div>
                                        </div>
                                    </form>

                                    <h4 class="card-title mt-5" id="5">5.- Reconocimiento</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_reconocimiento" id="form_informe_reconocimiento">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! csrf_field() !!}
                                                    <textarea
                                                        class="form-control"
                                                        style="margin-bottom: 0px;"
                                                        rows="8"
                                                        id="INFORME_RECONOCIMIENTO"
                                                        name="INFORME_RECONOCIMIENTO"
                                                        required>Se realiza observación de cada uno de los procesos con el objetivo de analizar la situación de trabajo, la cual enmarca las múltiples tareas, funciones, y entornos en los que se debe desempeñar un trabajador (Castillo, 2013). Se aplicó el procedimiento para la identificación y evaluación de los factores de riesgo ergonómico, el cual se detalla en el punto 4, relacionado con la metodología, así mismo mediante la aplicación de la ISO TR 12295, que permite la identificación de peligros y riesgos ergonómicos, la cual permite hacer una evaluación inicial rápida de: levantamiento de cargas, transporte de cargas, empuje y tracción de cargas, movimientos repetitivos de la extremidad superior, posturas estáticas forzadas y posturas dinámicas forzadas, fichas técnicas que nos permiten ser el punto de partida inicial de evaluación del riesgo como modelo expositivo del riesgo por exposición a sobrecarga biomecánica.

A continuación, se presenta la determinación de los factores de riesgo detectados y la aplicación del modelo conceptual de un estudio ergonómico, en la INSTALACION.

En la aplicación de las fichas técnicas de identificación del riesgo ergonómico de acuerdo con la ISO-TR 12295, se evidenció que las categorías estudiadas tienen tareas que presentan riesgo Elevado; se procedió a hacer un análisis especifico con métodos ergonómicos en las categorías objeto de este estudio; así mismo cabe señalar que esto se correlaciona con los dispuesto en la NOM-036-1-STPS-2018, en cuanto al levantamiento y transporte de cargas.
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_reconocimiento">Guardar reconocimiento <i class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="mt-4">
                                        <label>A continuación, se presenta el resumen de los criterios referidos en la ISO TR 12295, para identificación de Peligros/Riesgos, mismos que relacionan los 6 criterios de la carga física con los respetivos puestos de trabajo valorados, donde el verde corresponde a un Riesgo Controlado y Rojo a un Riesgo Elevado</label>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <div id="TABLE_MAPEOPELIGRO"></div>
                                        </div>
                                    </div>
                                    <h4 class="card-title" id="5_1">5.1.- Ubicación de la instalación</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_ubicacion" id="form_informe_ubicacion">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        {!! csrf_field() !!}
                                                        <textarea class="form-control" style="margin-bottom: 0px;" rows="14" id="INFORME_UBICACIONINSTALACION" name="INFORME_UBICACIONINSTALACION" required>
Este estudio se realizó en las áreas de la INSTALACION, con domicilio DIRECCION.

Se localiza en las coordenadas  COORDENADAS.
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: 6px; margin-left: 8px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF, -1px 0px 0 #FFFFFF, 0px -1px 0 #FFFFFF; cursor: pointer; display: block;" data-toggle="tooltip" title="Descargar mapa ubicación" id="boton_descargarmapaubicacion"></i>

                                                <input type="file" accept="image/jpeg,image/x-png" id="RUTA_IMAGEN_UBICACION" name="RUTA_IMAGEN_UBICACION" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" required />
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-12 mt-3" style="text-align: right;">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_ubicacion">Guardar ubicación <i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </div> -->
                                    </form>
                                    <h4 class="card-title" id="5_2">5.2.- Descripción del proceso en la instalación</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_procesoinstalacion" id="form_reporte_procesoinstalacion">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <label>Descripción del proceso en la instalación</label>
                                                    <textarea class="form-control" style="margin-bottom: 0px;" rows="20" id="INFORME_PROCESOINSTALACION" name="INFORME_PROCESOINSTALACION" required>
DESCRIPCIONPROCESO
                                                    </textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Descripción de la actividad principal de la instalación</label>
                                                    <textarea class="form-control" style="margin-bottom: 0px;" rows="7" id="INFORME_ACTIVIDADPRINCIPAL" name="INFORME_ACTIVIDADPRINCIPAL" required>
DESCRIPCIONACTIVIDAD
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_procesoinstalacion">Guardar proceso instalación <i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title" id="5_3">5.3.- Ciclos de trabajo de las categorías a evaluar</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_ciclos" id="form_informe_ciclos">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <p>
                                                        Un ciclo de trabajo es aquel realizado por el trabajador bajo una secuencia de acciones con la característica particular de que se repiten de una misma forma y duran el tiempo necesario para terminar una tarea y comenzar la siguiente. </p>
                                                    <p>
                                                        El análisis de los ciclos de trabajo nos ayuda a comprender si las tareas ejecutadas tienen características relacionadas con el movimiento repetitivo; sólo se considera trabajo repetitivo cuando los ciclos de trabajo son cortos; es decir ciclo menor a 30 segundos o un minuto, o alta concentración de movimientos (mayor del 50%), que utilizan pocos músculos (Silverstein y Col, 1987). </p>
                                                    <p>
                                                        Para la presente evaluación de factores de riesgo ergonómico y de acuerdo con lo analizado en visita de campo, los ciclos de trabajo de las categorías evaluadas están conformadas de la siguiente manera:</p>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover stylish-table" width="100%" id="TablaActividadesFre">
                                            <thead>
                                                <tr>
                                                    <th>Categoría</th>
                                                    <th>Turno de trabajo</th>
                                                    <th>Actividad realizada</th>
                                                    <th>Tareas a realizar</th>
                                                    <th>Tiempo que le toma llevar las tareas a cabo</th>
                                                    <th>Frecuencia</th>
                                                    <th>No. veces</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    <h4 class="card-title mt-2" id="6">6.- Evaluación</h4>
                                    <h4 class="card-title" id="6_1">6.1.- Condiciones de operación durante la evaluación </h4>
                                    <div class="row">
                                        <div class="col-12">
                                            {!! csrf_field() !!}
                                            <div class="form-group">
                                                <p>
                                                    En el momento de la valoración de los Factores de Riesgo Ergonómicos, se encontraba en condiciones normales de Operación, donde los trabajadores estaban llevando a cabo sus tareas dentro del ciclo de trabajo normal propios de la instalación, lo cual permitió la ejecución de las valoraciones. </p>
                                            </div>
                                            <table class="table-hover tabla_info_centrado" width="100%" id="tabla_reporte_area">
                                                <thead>
                                                    <tr>
                                                        <th width="130">Área</th>
                                                        <th width="">Categoría</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <br>
                                    <h4 class="card-title" id="6_2">6.2.- Variables antropométricas (peso y talla) </h4>
                                    <div class="row">
                                        <div class="col-12">
                                            {!! csrf_field() !!}
                                            <div class="form-group">
                                                <p>
                                                    El propósito de medir el peso y la talla del trabajador es establecer como se encuentra su índice de masa corporal (IMC), para determinar las categorías de peso que pueden provocar problemas en la salud, y en consecuencia en la ejecución de sus labores. </p>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover stylish-table" width="100%" id="TablaImcFre">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Categoría</th>
                                                            <th>Área</th>
                                                            <th>Estatura (cm)</th>
                                                            <th>Peso (kg)</th>
                                                            <th>IMC</th>
                                                            <th>Interpretación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <div class="text-center mt-3">
                                                <img src="{{ asset('assets/images/ergo/IMC.png') }}"
                                                    style="max-width: 50%; height: auto;">
                                            </div>
                                            <form method="post" enctype="multipart/form-data" name="form_informe_antropometricas" id="form_informe_antropometricas">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            {!! csrf_field() !!}
                                                            <label>Análisis </label>
                                                            <textarea class="form-control" style="margin-bottom: 0px;" rows="8" id="INFORME_ANTROPOMETRICAS" name="INFORME_ANTROPOMETRICAS" required>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12" style="text-align: right;">
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_antropometricas">Guardar antropométricas <i class="fa fa-save"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br>
                                    <h4 class="card-title" id="6_3">
                                        6.3.- Registro de trastornos músculo esqueléticos
                                    </h4>


                                    <form method="post" enctype="multipart/form-data" name="form_informe_esqueletico" id="form_informe_esqueletico">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                                <p>
                                                    Se aplicó el instrumento validado internacionalmente y sugerido por la NOM-036-1-STPS-2018, cuestionario Nórdiko Kuorinka para la detección temprana de síntomas músculo esqueléticos ya que se le pregunta al trabajador si durante los últimos 12 meses ha presentado alguna molestia.
                                                </p>
                                                <p>
                                                    A continuación, se presentan los resultados de acuerdo con las categorías y áreas.
                                                </p>
                                                <p><strong>a).</strong> Parte del cuerpo</p>
                                                <p><strong>b).</strong> Tiempo</p>
                                                <p><strong>c).</strong> Tratamiento</p>
                                                <p><strong>d).</strong> Factores atribuibles</p>

                                            </div>
                                        </div>

                                        <style>
                                            #form_informe_esqueletico .fila-grafica-esqueletica {
                                                display: flex;
                                                flex-wrap: wrap;
                                                justify-content: center;
                                                align-items: flex-start;
                                                gap: 14px;
                                                margin: 6px 0 10px 0;
                                                padding-bottom: 10px;
                                            }

                                            #form_informe_esqueletico .contenedor-grafica-esqueletica {
                                                flex: 0 0 auto;
                                                width: 592px;
                                                max-width: 100%;
                                                overflow-x: auto;
                                                padding: 2px;
                                            }

                                            #form_informe_esqueletico .card-grafica-esqueletica {
                                                box-sizing: border-box;
                                                width: 588px;
                                                min-width: 588px;
                                                max-width: 588px;
                                                margin: 0;
                                                height: auto;
                                                border: 1px solid #d8dee4;
                                                border-radius: 6px;
                                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                                            }

                                            #form_informe_esqueletico .card-grafica-esqueletica .card-body {
                                                box-sizing: border-box;
                                                padding: 8px 14px 6px 14px;
                                            }

                                            #form_informe_esqueletico .titulo-grafica-esqueletica {
                                                position: relative;
                                                z-index: 5;
                                                width: 100%;
                                                font-size: 12px;
                                                line-height: 1.3;
                                                margin: 0 0 4px 0;
                                                text-align: center;
                                                white-space: normal;
                                                overflow-wrap: break-word;
                                            }

                                            #form_informe_esqueletico .mapa-grafica-esqueletica,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica2,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica3,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica4,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica5,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica6 {
                                                position: relative;
                                                box-sizing: border-box;
                                                width: 558px;
                                                min-width: 558px;
                                                max-width: 558px;
                                                margin: 0 auto;
                                            }

                                            #form_informe_esqueletico .mapa-grafica-esqueletica,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica2,
                                            #form_informe_esqueletico .mapa-grafica-esqueletica3 {
                                                min-height: 640px;
                                            }

                                            #form_informe_esqueletico .imagen-grafica-esqueletica {
                                                display: block;
                                                width: 373px;
                                                min-width: 373px;
                                                max-width: none;
                                                height: auto;
                                                margin: 0 0 0 80px;
                                            }

                                            #form_informe_esqueletico .imagen-recorte-esqueletica {
                                                margin-top: -50px;
                                            }

                                            #form_informe_esqueletico .porcentaje-grafica-esqueletica {
                                                position: absolute;
                                                z-index: 6;
                                                font-size: 12px;
                                                font-weight: bold;
                                                color: #ffffff;
                                                background: #FF585D;
                                                padding: 2px 6px;
                                                border: 2px solid #000;
                                                border-radius: 25px;
                                                width: 70px;
                                                text-align: center;
                                                box-sizing: border-box;
                                            }

                                            #form_informe_esqueletico .cuello-grafica-p1,
                                            #form_informe_esqueletico .cuello-grafica-p2,
                                            #form_informe_esqueletico .cuello-grafica-p3 {
                                                top: 131px;
                                                left: 415px;
                                            }

                                            #form_informe_esqueletico .dorsal-grafica-p1,
                                            #form_informe_esqueletico .dorsal-grafica-p2,
                                            #form_informe_esqueletico .dorsal-grafica-p3 {
                                                top: 230px;
                                                left: 442px;
                                            }

                                            #form_informe_esqueletico .mano-grafica-p1,
                                            #form_informe_esqueletico .mano-grafica-p2,
                                            #form_informe_esqueletico .mano-grafica-p3 {
                                                top: 337px;
                                                left: 460px;
                                            }

                                            #form_informe_esqueletico .cadera-grafica-p1,
                                            #form_informe_esqueletico .cadera-grafica-p2,
                                            #form_informe_esqueletico .cadera-grafica-p3 {
                                                top: 432px;
                                                left: 455px;
                                            }

                                            #form_informe_esqueletico .tobillo-grafica-p1,
                                            #form_informe_esqueletico .tobillo-grafica-p2,
                                            #form_informe_esqueletico .tobillo-grafica-p3 {
                                                top: 612px;
                                                left: 438px;
                                            }

                                            #form_informe_esqueletico .hombro-grafica-p1,
                                            #form_informe_esqueletico .hombro-grafica-p2,
                                            #form_informe_esqueletico .hombro-grafica-p3 {
                                                top: 183px;
                                                left: 30px;
                                            }

                                            #form_informe_esqueletico .codo-grafica-p1,
                                            #form_informe_esqueletico .codo-grafica-p2,
                                            #form_informe_esqueletico .codo-grafica-p3 {
                                                top: 284px;
                                                left: 24px;
                                            }

                                            #form_informe_esqueletico .lumbar-grafica-p1,
                                            #form_informe_esqueletico .lumbar-grafica-p2,
                                            #form_informe_esqueletico .lumbar-grafica-p3 {
                                                top: 352px;
                                                left: 11px;
                                            }

                                            #form_informe_esqueletico .rodilla-grafica-p1,
                                            #form_informe_esqueletico .rodilla-grafica-p2,
                                            #form_informe_esqueletico .rodilla-grafica-p3 {
                                                top: 485px;
                                                left: 38px;
                                            }

                                            #form_informe_esqueletico .lumbar-grafica-p4 {
                                                top: 324px;
                                                left: 20px;
                                            }

                                            #form_informe_esqueletico .cuello-grafica-p5 {
                                                top: 104px;
                                                left: 412px;
                                            }

                                            #form_informe_esqueletico .hombro-grafica-p6 {
                                                top: 143px;
                                                left: 30px;
                                            }

                                            #form_informe_esqueletico .card-grafica-esqueletica hr {
                                                margin: 6px 0;
                                            }

                                            #form_informe_esqueletico #tablaPregunta1,
                                            #form_informe_esqueletico #tablaPregunta2,
                                            #form_informe_esqueletico #tablaPregunta3,
                                            #form_informe_esqueletico #tablaPregunta4,
                                            #form_informe_esqueletico #tablaPregunta5,
                                            #form_informe_esqueletico #tablaPregunta6 {
                                                width: 100%;
                                                overflow-x: auto;
                                            }

                                            #form_informe_esqueletico .bloque-observaciones-esqueletico {
                                                flex: 0 0 auto;
                                                width: 675px;
                                                max-width: 100%;
                                            }

                                            #form_informe_esqueletico .titulo-observaciones-esqueleticas {
                                                display: block;
                                                font-weight: 600;
                                                margin: 0 0 6px 0;
                                            }

                                            #form_informe_esqueletico .observaciones-grafica-esqueletica {
                                                width: 100%;
                                                min-height: 260px;
                                                resize: vertical;
                                            }
                                        </style>




                                        <div class="fila-grafica-esqueletica">

                                            <div class="contenedor-grafica-esqueletica">

                                                <!-- <button type="button"
                                                    class="btn btn-danger waves-effect waves-light mb-1"
                                                    onclick="descargarCard('cardPregunta1','Pregunta 1')">
                                                    Descargar <i class="fa fa-save"></i>
                                                </button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta1">
                                                    <div class="card-body">

                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            1.- ¿En algún momento durante los últimos 12 meses,
                                                            ha tenido problemas (dolor, molestias, disconfort)?
                                                        </h6>

                                                        <div class="mapa-grafica-esqueletica">
                                                            <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="imagen-grafica-esqueletica imagen-recorte-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica cuello-grafica-p1" id="CUELLOP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica hombro-grafica-p1" id="HOMBREOP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica dorsal-grafica-p1" id="DORSALP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica codo-grafica-p1" id="CODOP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica mano-grafica-p1" id="MANOP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica lumbar-grafica-p1" id="LUMBARP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica cadera-grafica-p1" id="CADERAP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica rodilla-grafica-p1" id="RODILLAP1"></span>
                                                            <span class="porcentaje-grafica-esqueletica tobillo-grafica-p1" id="TOBILLOP1"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta1"></div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas">
                                                    Observaciones de la pregunta 1
                                                </label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS1" name="OBSERVACIONES_ESQUELETICAS1" rows="8"></textarea>
                                            </div>
                                        </div>


                                        <div class="fila-grafica-esqueletica">
                                            <div class="contenedor-grafica-esqueletica">
                                                <!-- <button type="button" class="btn btn-danger waves-effect waves-light mb-1" onclick="descargarCard('cardPregunta2','Pregunta 2')">Descargar <i class="fa fa-save"></i>
                                                </button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta2">
                                                    <div class="card-body">
                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            2.- ¿En algún momento, durante los últimos 12 meses,
                                                            ha tenido algún impedimento para hacer su trabajo
                                                            normal (en casa o fuera de casa) debido a sus molestias?
                                                        </h6>

                                                        <div class="mapa-grafica-esqueletica2">
                                                            <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="imagen-grafica-esqueletica imagen-recorte-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica cuello-grafica-p2" id="CUELLOP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica hombro-grafica-p2" id="HOMBREOP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica dorsal-grafica-p2" id="DORSALP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica codo-grafica-p2" id="CODOP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica mano-grafica-p2" id="MANOP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica lumbar-grafica-p2" id="LUMBARP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica cadera-grafica-p2" id="CADERAP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica rodilla-grafica-p2" id="RODILLAP2"></span>
                                                            <span class="porcentaje-grafica-esqueletica tobillo-grafica-p2" id="TOBILLOP2"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta2"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas"> Observaciones de la pregunta 2</label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS2" name="OBSERVACIONES_ESQUELETICAS2" rows="8"></textarea>
                                            </div>
                                        </div>

                                        <div class="fila-grafica-esqueletica">
                                            <div class="contenedor-grafica-esqueletica">

                                                <!-- <button type="button" class="btn btn-danger waves-effect waves-light mb-1" onclick="descargarCard('cardPregunta3','Pregunta 3')">
                                                    Descargar <i class="fa fa-save"></i></button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta3">
                                                    <div class="card-body">
                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            3.- ¿En algún momento, durante los últimos 7 días,
                                                            ha tenido algún impedimento para hacer su trabajo
                                                            normal debido a sus molestias?
                                                        </h6>
                                                        <div class="mapa-grafica-esqueletica3">
                                                            <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}" class="imagen-grafica-esqueletica imagen-recorte-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica cuello-grafica-p3" id="CUELLOP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica hombro-grafica-p3" id="HOMBREOP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica dorsal-grafica-p3" id="DORSALP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica codo-grafica-p3" id="CODOP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica mano-grafica-p3" id="MANOP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica lumbar-grafica-p3" id="LUMBARP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica cadera-grafica-p3" id="CADERAP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica rodilla-grafica-p3" id="RODILLAP3"></span>
                                                            <span class="porcentaje-grafica-esqueletica tobillo-grafica-p3" id="TOBILLOP3"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas"> Observaciones de la pregunta 3 </label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS3" name="OBSERVACIONES_ESQUELETICAS3" rows="8"></textarea>
                                            </div>

                                        </div>

                                        <div class="fila-grafica-esqueletica">
                                            <div class="contenedor-grafica-esqueletica">

                                                <!-- <button type="button" class="btn btn-danger waves-effect waves-light mb-1" onclick="descargarCard('cardPregunta4','Pregunta 4')">
                                                    Descargar <i class="fa fa-save"></i>
                                                </button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta4">
                                                    <div class="card-body">
                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            4.- COLUMNA LUMBAR (Espalda baja)
                                                        </h6>
                                                        <div class="mapa-grafica-esqueletica4">
                                                            <img src="{{ asset('assets/images/ergo/COLUMNA LUMBAR.png') }}" class="imagen-grafica-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica lumbar-grafica-p4" id="LUMBARP4"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta4"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas"> Observaciones de la pregunta 4 </label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS4" name="OBSERVACIONES_ESQUELETICAS4" rows="8"></textarea>
                                            </div>
                                        </div>

                                        <div class="fila-grafica-esqueletica">
                                            <div class="contenedor-grafica-esqueletica">
                                                <!-- <button type="button" class="btn btn-danger waves-effect waves-light mb-1" onclick="descargarCard('cardPregunta5','Pregunta 5')">
                                                    Descargar <i class="fa fa-save"></i>
                                                </button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta5">
                                                    <div class="card-body">
                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            5.- CUELLO
                                                        </h6>
                                                        <div class="mapa-grafica-esqueletica5">
                                                            <img src="{{ asset('assets/images/ergo/CUELLO.png') }}" class="imagen-grafica-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica cuello-grafica-p5" id="CUELLOP5"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta5"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas"> Observaciones de la pregunta 5 </label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS5" name="OBSERVACIONES_ESQUELETICAS5" rows="8"></textarea>
                                            </div>
                                        </div>


                                        <div class="fila-grafica-esqueletica">
                                            <div class="contenedor-grafica-esqueletica">
                                                <!-- <button type="button" class="btn btn-danger waves-effect waves-light mb-1" onclick="descargarCard('cardPregunta6','Pregunta 6')">
                                                    Descargar <i class="fa fa-save"></i>
                                                </button> -->

                                                <div class="card card-grafica-esqueletica" id="cardPregunta6">
                                                    <div class="card-body">
                                                        <h6 class="titulo-grafica-esqueletica font-weight-bold">
                                                            6.- HOMBROS
                                                        </h6>
                                                        <div class="mapa-grafica-esqueletica6">
                                                            <img src="{{ asset('assets/images/ergo/HOMBRO.png') }}" class="imagen-grafica-esqueletica">
                                                            <span class="porcentaje-grafica-esqueletica hombro-grafica-p6" id="HOMBROP6"></span>
                                                        </div>
                                                        <hr>
                                                        <div id="tablaPregunta6"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="bloque-observaciones-esqueletico">
                                                <label class="titulo-observaciones-esqueleticas"> Observaciones de la pregunta 6 </label>
                                                <textarea class="form-control observaciones-grafica-esqueletica" id="OBSERVACIONES_ESQUELETICAS6" name="OBSERVACIONES_ESQUELETICAS6" rows="8"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12" style="text-align: right;">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_esqueletico">Guardar músculo esqueléticos <i class="fa fa-save"></i></button>
                                        </div>
                                    </form>
                                    <h4 class="card-title mt-5" id="7">7.- Categorías evaluadas </h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_catevaluadas" id="form_informe_catevaluadas">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <p>
                                                        Se relacionan a continuación las categorías objeto evaluadas en el presente estudio de factores de riesgo ergonómico:</p>
                                                </div>
                                                <table class="table-hover tabla_info_centrado" width="100%" id="tabla_reporte_trabajadores_ergo">
                                                    <thead>
                                                        <tr>
                                                            <th width="130">Área</th>
                                                            <th>Categoría</th>
                                                            <th>No. de trabajadores evaluados</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title mt-5" id="7_1">7.1.- Método de ergonomía aplicado</h4>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                {!! csrf_field() !!}
                                                <p>
                                                    A continuación se presenta una breve descripción de las diferentes metodologías validadas por la normatividad mexicana e internacionalmente, para la evaluación del factor de riesgo ergonómico en el centro de trabajo, las cuales son utilizadas en el presente informe.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="card-title mt-5" id="7_2">7.2.- Resultados de la aplicación del método</h4>


                                    <h4 class="card-title mt-5" id="8">8.- Conclusiones</h4>
                                    <form method="post" enctype="multipart/form-data" name="form_informe_conclusiones" id="form_informe_conclusiones">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! csrf_field() !!}

                                                    <div class="form-group">
                                                        <label>Seleccionar conclusión </label>
                                                        <select class="custom-select form-control"
                                                            id="SELECT_CONCLUSION"
                                                            name="SELECT_CONCLUSION">
                                                            <option value=""></option>
                                                            @foreach($catconclusion as $dato)
                                                            <option
                                                                value="{{$dato->ID_CONCLUSION}}"
                                                                data-conclusion="{{ htmlspecialchars($dato->NOMBRE_CONCLUSION) }}">
                                                                {{$dato->QUIEN_CONCLUSION}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <textarea class="form-control" style="margin-bottom: 0px;" rows="20" id="INFORME_CONCLUSION" name="INFORME_CONCLUSION" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_conclusion">Guardar conclusión <i class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title" id="9">9.- Recomendaciones de control </h4>


                                    <h4 class="card-title" id="10">10.- Responsables del informe</h4>
                                    <form enctype="multipart/form-data" method="post" name="form_informe_responsablesinforme" id="form_informe_responsablesinforme">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Nombre del responsable técnico</label>
                                                            <input type="text" class="form-control" id="INFORME_RESPONSABLE1" name="INFORME_RESPONSABLE1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Cargo del responsable técnico</label>
                                                            <input type="text" class="form-control" id="INFORME_RESPONSABLE1CARGO" name="INFORME_RESPONSABLE1CARGO" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Foto documento del responsable técnico</label>
                                                            <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: 6px; margin-left: 8px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF, -1px 0px 0 #FFFFFF, 0px -1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar foto documento" id="boton_descargarresponsabledoc1"></i>
                                                            <input type="file" accept="image/jpeg,image/x-png" id="INFORME_RESPONSABLE1DOCUMENTO" name="INFORME_RESPONSABLE1DOCUMENTO" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Nombre del administrativo prestador de servicio</label>
                                                            <input type="text" class="form-control" id="INFORME_RESPONSABLE2" name="INFORME_RESPONSABLE2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Cargo del administrativo prestador de servicio</label>
                                                            <input type="text" class="form-control" id="INFORME_RESPONSABLE2CARGO" name="INFORME_RESPONSABLE2CARGO" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Foto documento del prestador de servicio</label>
                                                            <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: 6px; margin-left: 8px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF, -1px 0px 0 #FFFFFF, 0px -1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar foto documento" id="boton_descargarresponsabledoc2"></i>
                                                            <input type="file" accept="image/jpeg,image/x-png" id="INFORME_RESPONSABLE2DOCUMENTO" name="INFORME_RESPONSABLE2DOCUMENTO" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12" style="text-align: right;">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light botoninforme" id="botonguardar_reporte_responsablesinforme">Guardar responsables del informe <i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h4 class="card-title mt-2" id="11">11.- Anexos </h4>
                                    <h4 class="card-title" id="11_1">11.1.- Anexo 1 Equipo utilizado en la medición </h4>
                                    <div class="row mb-5">
                                        <div class="col-12">
                                        </div>
                                    </div>

                                    <h4 class="card-title" id="12">Generar informe .docx</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <ol class="breadcrumb" style="padding: 6px; margin: 10px 0px;">
                                                <button type="button" class="btn btn-default waves-effect" data-toggle="tooltip" title="Nueva revisión" id="boton_reporte_nuevarevision">
                                                    <span class="btn-label"><i class="fa fa-plus"></i></span>Crear nueva revisión
                                                </button>
                                            </ol>

                                            <table class="table-hover tabla_info_centrado" width="100%" id="tabla_reporte_revisiones">
                                                <thead>
                                                    <tr>
                                                        <th width="40">Revisión</th>
                                                        <th width="60">Concluido</th>
                                                        <th width="180">Concluido por:</th>
                                                        <th width="60">Cancelado</th>
                                                        <th width="180">Cancelado por:</th>
                                                        <th>Estado</th>
                                                        <th width="60">Descargar</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div> <!-- /FIN TAB 3 -->


        </div>
    </div>
</div>






<!-- ============================================================== -->
<!-- MODALES FICHAS TECNICAS  -->
<!-- ============================================================== -->

<div id="modal_fichas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 90%!important;">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" name="form_fichas" id="form_fichas">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nueva fichas</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">


                        <input type="hidden" name="JSON_ACTIVIDADES" id="JSON_ACTIVIDADES">
                        <input type="hidden" name="JSON_FICHAS" id="JSON_FICHAS">

                        <div class="col-3">
                            <div class="form-group">
                                <label>N° PE *</label>
                                <input type="text" class="form-control" name="PE_EVALUADAS" id="PE_EVALUADAS" required readonly>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Categoría *</label>
                                <select class="form-control" id="CATEGORIA_ID_FICHA" name="CATEGORIA_ID_FICHA" required>
                                    <option value="">Selecciona un tipo de valor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label> Departamento *</label>
                                <select class="custom-select form-control" id="CAT_DEPARTAMENTO_FICHA" name="CAT_DEPARTAMENTO_FICHA" required style="pointer-events:none; background-color:#e9ecef;">
                                    <option value=""></option>
                                    @foreach($catdepartamento as $dato)
                                    <option value="{{$dato->id}}">{{$dato->catdepartamento_nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Áreas *</label>
                                <select class="custom-select form-control" id="CAT_AREAS_FICHA" name="CAT_AREAS_FICHA[]" multiple>
                                </select>
                            </div>
                        </div>


                        <!-- NOMBRE -->
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nombre del empleado *</label>
                                <input type="text" class="form-control" name="NOMBRE_EMPLEADO_FICHA" id="NOMBRE_EMPLEADO_FICHA" required>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Ficha / No empleado </label>
                                <input type="text" class="form-control" name="NO_EMPLEADO_FICHA" id="NO_EMPLEADO_FICHA">
                            </div>
                        </div>
                        <!-- SEXO -->
                        <div class="col-4">
                            <div class="form-group">
                                <label>Sexo *</label>
                                <select class="form-control" name="SEXO_EMPLEADO_FICHA" id="SEXO_EMPLEADO_FICHA" required>
                                    <option value="">Seleccionar</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <!-- FECHA NACIMIENTO -->
                        <div class="col-4">
                            <div class="form-group">
                                <label>Fecha de nacimiento </label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO">
                                    <span class="input-group-addon"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Edad </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="EDAD_EMPLEADO_FICHA" id="EDAD_EMPLEADO_FICHA" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- PESO -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Peso (kg) </label>
                                <input type="number" class="form-control" name="PESO_FICHA" id="PESO_FICHA" step="0.1">
                            </div>
                        </div>

                        <!-- TALLA -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Talla (cm) </label>
                                <input type="number" class="form-control" name="TALLA_FICHA" id="TALLA_FICHA">
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label>Régimen Contractual </label>

                                <select class="custom-select form-control" id="REGIMEN_CONTRACTUAL_FICHA" name="REGIMEN_CONTRACTUAL_FICHA">
                                    <option value=""></option>
                                    @foreach($catregimen as $dato)
                                    <option value="{{$dato->ID_REGIMEN_CONTRACTUAL}}">{{$dato->NOMBRE_REGIMEN_CONTRACTUAL}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Jornada </label>
                                <select class="custom-select form-control" id="JORNADA_EMPLEADO_FICHA" name="JORNADA_EMPLEADO_FICHA">
                                    <option value=""></option>
                                    @foreach($catjornada as $dato)
                                    <option value="{{$dato->ID_JORNADA}}">{{$dato->NOMBRE_JORNADA}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Turno </label>

                                <select class="custom-select form-control" id="TURNO_EMPLEADO_FICHA" name="TURNO_EMPLEADO_FICHA[]" multiple>
                                    <option value=""></option>
                                    @foreach($caturno as $dato)
                                    <option value="{{$dato->ID_TURNO}}">{{$dato->NOMBRE_TURNO}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>¿Cuánto tiempo lleva en la empresa?</label>
                                <input type="text" class="form-control" name="TIEMPO_EMPRESA_FICHA" id="TIEMPO_EMPRESA_FICHA">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Antigüedad en la categoría</label>
                                <input type="text" class="form-control" name="ANTIGUEDAD_CATEOGORIA_FICHA" id="ANTIGUEDAD_CATEOGORIA_FICHA">
                            </div>
                        </div>





                        <br><br>
                        <div class="col-12 mt-2 text-center">
                            Actividades
                        </div>

                        <div id="contenedorActividades" class="mt-2"></div>




                        <br><br>

                        <style>
                            /* ACTIVIDADES */

                            #contenedorActividades {
                                width: 100%;
                            }

                            .actividad-card {
                                width: 100%;
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                padding: 15px;
                                margin-bottom: 10px;
                                background: #fff;
                            }

                            .actividad-row {
                                display: flex;
                                gap: 15px;
                                align-items: flex-start;
                            }

                            .actividad-left {
                                width: 30%;
                            }

                            .actividad-right {
                                width: 70%;
                            }

                            .btn-agregar-tarea {
                                width: 20%;
                                background: linear-gradient(90deg, #6dd6e4, #6dd6e4);
                                color: white;
                                border: none;
                            }

                            .tarea-item {
                                border: 1px solid #e5e7eb;
                                border-radius: 8px;
                                padding: 10px;
                                margin-top: 8px;
                                background: #f9fafb;
                            }



                            /* FICHAS */
                            .custom-container-left {
                                width: 100%;
                                max-width: 100%;
                                /* evita límite */
                                padding-left: !important;
                                padding-right: !important;
                            }

                            .no-padding {
                                padding-left: !important;
                                padding-right: !important;
                            }



                            .custom-card-header {
                                width: 100%;
                                text-align: left;
                            }

                            .custom-card-nom .card-body {
                                padding: 20px;
                            }

                            .custom-card-nom .row {
                                justify-content: flex-start;
                            }
                        </style>

                        <div class="container-fluid custom-container-left no-padding">
                            <div class="card mb-3">


                                <div class="card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido1')">
                                    <div class="text-left w-100">
                                        <b>1.NOM-036-1-STPS-2018 (A continuación responda las tres preguntas que permiten identificar, analizar, prevenir y controlar los factores de riesgo ergonómico en el trabajo derivados del manejo manual de cargas, según corresponda con un sí o no, si la respuesta es no en la primera no tendrá que responder los criterios de levantamientos, transporte y empuje y tracción. )</b><br>
                                    </div>
                                </div>



                                <div id="contenido1" style="display:block;">

                                    <div class="row m-2">


                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>
                                                    1. Durante su jornada laboral, ¿levanta, baja, manipula objetos o materiales con un peso mayor a 3 Kg?
                                                </label>
                                                <select class="form-control" name="P1_CARGA_MAYOR_3KG" id="P1_CARGA_MAYOR_3KG" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="SI">Sí</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>
                                                    2. ¿Con qué frecuencia realiza actividades que involucren el manejo manual de cargas (más de una vez al día)?
                                                </label>
                                                <select class="form-control" name="P2_FRECUENCIA_CARGA" id="P2_FRECUENCIA_CARGA" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="SI">Sí</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>
                                                    3. ¿Tiene que levantar, bajar, transportar, empujar, jalar y/o estibar objetos o materiales como parte de su trabajo?
                                                </label>
                                                <select class="form-control" name="P3_MANIPULACION_CARGA" id="P3_MANIPULACION_CARGA" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="SI">Sí</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card mt-2" id="TEXTO_MANIPULACION" style="display: block;">
                                    <div class="card-header header-verde-res d-flex align-items-center">
                                        <i class="fa fa-info mr-2" aria-hidden="true"></i>
                                        <div class="text-center w-100">
                                            <b>Manipulación manual de cargas</b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        Cualquier operación de transporte o sujeción de una carga mayor a 3 kg por parte de uno o varios trabajadores, como el levantamiento, la colocación, el empuje, la tracción o el desplazamiento, que por sus características ergonómicas inadecuadas entrañe riesgo, en particular dorsolumbares, para los trabajadores.
                                    </div>
                                </div>

                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido2')" id="LEVANTAMIENTO_CARGA" style="display:block !important;">
                                    <div class="text-center">
                                        <b>2.Levantamiento de cargas</b><br>
                                    </div>
                                </div>

                                <div id="contenido2" style="display:none;">
                                    <div class="card-body">

                                        <div class="container-fluid">
                                            <div id="ficha_1_1"></div>
                                            <div id="ficha_1_4"></div>
                                            <div id="ficha_1_3"></div>
                                        </div>

                                        <br><br>
                                    </div>
                                </div>


                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido3')" id="TRANSPORTE_CARGAS" style="display:block !important;">
                                    <div class="text-center">
                                        <b>3.Transporte de cargas</b><br>
                                    </div>
                                </div>


                                <div id="contenido3" style="display:none;">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div id="ficha_1_2"></div>
                                            <div id="ficha_1_5"></div>
                                        </div>

                                        <br><br>
                                    </div>
                                </div>


                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido4')" id="EMPUJE_TRACCION" style="display:block !important;">
                                    <div class="text-center">
                                        <b>4.Empuje y tracción de cargas</b><br>
                                    </div>
                                </div>


                                <div id="contenido4" style="display:none;">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div id="ficha_2_1"></div>
                                            <div id="ficha_2_3"></div>
                                            <div id="ficha_2_2"></div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>

                                <div class="card mt-5">
                                    <div class="card-header header-verde-res d-flex align-items-center">
                                        <i class="fa fa-info mr-2" aria-hidden="true"></i>
                                        <div class="text-center w-100">
                                            <b>Movimiento repetitivo</b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        Tarea caracterizada por tener un ciclo de trabajo que se repite. Está caracterizada por la presencia de ciclos con acciones técnicas que deben ser realizadas por las extremidades superiores.
                                    </div>
                                </div>

                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido5')" style="display:block !important;">
                                    <div class="text-center">
                                        <b>5.Movimientos repetitivos de la extremidad superior</b><br>
                                    </div>
                                </div>


                                <div id="contenido5" style="display:none;">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div id="ficha_3_1"></div>
                                            <div id="ficha_3_2"></div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>

                                <div class="card mt-5">
                                    <div class="card-header header-verde-res d-flex align-items-center">
                                        <i class="fa fa-info mr-2" aria-hidden="true"></i>
                                        <div class="text-center w-100">
                                            <b>Postura estática</b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        Posición que se realiza con una contracción muscular prolongada sin producir movimiento durante por lo menos 4 segundos de manera consecutiva.
                                    </div>
                                </div>

                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido6')" style="display:block !important;">
                                    <div class="text-center">
                                        <b>6.Posturas estáticas forzadas</b><br>
                                    </div>
                                </div>


                                <div id="contenido6" style="display:none;">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div id="ficha_4_1"></div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>

                                <div class="card mt-5">
                                    <div class="card-header header-verde-res d-flex align-items-center">
                                        <i class="fa fa-info mr-2" aria-hidden="true"></i>
                                        <div class="text-center w-100">
                                            <b>Postura dinámica</b>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        Posición corporal que se realiza con una contracción de diferentes grupos musculares y con cambios en los movimientos de las articulaciones.
                                    </div>
                                </div>

                                <div class="mt-2 card-header header-res d-flex justify-content-between align-items-center cursor-pointer"
                                    onclick="toggleSeccion('contenido7')" style="display:block !important;">
                                    <div class="text-center">
                                        <b>7.Posturas dinámicas forzadas</b><br>
                                    </div>
                                </div>


                                <div id="contenido7" style="display:none;">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div id="ficha_4_2"></div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>

                            </div>
                        </div>






                        <style>
                            #ficha_1_1,
                            #ficha_1_2,
                            #ficha_1_3,
                            #ficha_2_1,
                            #ficha_2_2,
                            #ficha_3_1,
                            #ficha_4_1,
                            #ficha_4_2 {
                                width: 100%;
                            }

                            /* .card {
                                width: 100%;
                            } */

                            .table td.texto-pregunta {
                                font-size: 17px !important;
                                font-weight: 500;
                                line-height: 1.5;
                            }

                            .ficha {
                                border: 1px solid #000;
                                font-family: Arial, sans-serif;
                            }

                            .ficha-header {
                                background: #a8d5a2;
                                padding: 10px;
                                font-weight: bold;
                                color: #000;
                                /* negro */
                            }


                            .ficha table {
                                width: 100%;
                                border-collapse: collapse;
                            }

                            .ficha td {
                                border: 1px solid #000;
                                padding: 10px;
                                color: #000;
                            }

                            .col-letra {
                                width: 40px;
                                text-align: center;
                                font-weight: bold;
                            }

                            .col-radio {
                                width: 80px;
                                text-align: center;
                            }


                            .header-verde {
                                background-color: #a8d5a2 !important;
                                color: #000 !important;
                            }

                            .header-res {
                                background-color: #007DBA !important;
                                color: #000 !important;
                            }

                            .header-verde-res {
                                background-color: #A4D65E !important;
                                color: #000 !important;

                            }

                            .header-azul {
                                background-color: #b7c7d6 !important;
                                color: #000 !important;
                            }

                            /* Rojo (Zona roja) */
                            .header-rojo {
                                background-color: #f28b82 !important;
                                color: #000 !important;
                            }

                            /* .card {
                                border-radius: 6px;
                            }

                            .card-header {
                                font-weight: bold;
                            } */

                            /* .card-body {
                                padding: 0;
                            } */

                            .table td {
                                vertical-align: middle;
                            }

                            /* .card {
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                            } */
                        </style>



                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODALES EVALUACION FRE  -->
<!-- ============================================================== -->

<div id="modal_evalfre" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 90%!important;">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="post" name="form_evalfre" id="form_evalfre">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Evaluación FRE </h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <input type="hidden" name="ID_EVALUACION_FRE" id="ID_EVALUACION_FRE">
                        <input type="hidden" name="JSON_ACTIVIDADES_FRE" id="JSON_ACTIVIDADES_FRE">
                        <input type="hidden" name="JSON_EQUIPOS_TRABAJO" id="JSON_EQUIPOS_TRABAJO">
                        <input type="hidden" name="JSON_FUENTES_TERMICAS" id="JSON_FUENTES_TERMICAS">
                        <input type="hidden" name="JSON_FUENTES_RUIDO" id="JSON_FUENTES_RUIDO">
                        <input type="hidden" name="JSON_FUENTES_VIBRACION" id="JSON_FUENTES_VIBRACION">
                        <input type="hidden" name="JSON_EPP" id="JSON_EPP">



                        <div class="col-4">
                            <div class="form-group">
                                <label>Fecha de evaluación *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EVALUACION_FRE" name="FECHA_EVALUACION_FRE">
                                    <span class="input-group-addon"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Instalación *</label>
                                <input type="text" class="form-control" name="INSTALACION_FRE" id="INSTALACION_FRE">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Áreas *</label>
                                <select class="custom-select form-control" id="CAT_AREAS_FRE" name="CAT_AREAS_FRE[]" multiple>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Categoría *</label>
                                <select class="form-control" id="CATEGORIA_ID_FRE" name="CATEGORIA_ID_FRE" required>
                                    <option value="">Selecciona un tipo de valor</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label> Departamento *</label>
                                <select class="custom-select form-control" id="CAT_DEPARTAMENTO_FRE" name="CAT_DEPARTAMENTO_FRE" required style="pointer-events:none; background-color:#e9ecef;">
                                    <option value=""></option>
                                    @foreach($catdepartamento as $dato)
                                    <option value="{{$dato->id}}">{{$dato->catdepartamento_nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-2 p-2 d-flex justify-content-start  clienteblock">
                            <h3 class="clienteblock">¿La evaluación es para el mismo trabajador ?</h3>
                            <div class="form-check mx-4 clienteblock">
                                <input class="form-check-input" type="radio" name="EVALUACION_TRABAJADOR" id="informe_del_trabajador_si" value="1" checked>
                                <label class="form-check-label" for="informe_del_trabajador_si">
                                    Si
                                </label>
                            </div>
                            <div class="form-check mx-4 clienteblock">
                                <input class="form-check-input" type="radio" name="EVALUACION_TRABAJADOR" id="informe_del_trabajador_no" value="0">
                                <label class="form-check-label" for="informe_del_trabajador_no">
                                    No
                                </label>
                            </div>
                        </div>

                        <!-- NOMBRE -->
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nombre del empleado *</label>
                                <input type="text" class="form-control" name="NOMBRE_EMPLEADO_FRE" id="NOMBRE_EMPLEADO_FRE" required>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Ficha / No empleado </label>
                                <input type="text" class="form-control" name="NO_EMPLEADO_FRE" id="NO_EMPLEADO_FRE">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Último grado de estudio </label>
                                <input type="text" class="form-control" name="ULTIMO_GRADO_FRE" id="ULTIMO_GRADO_FRE">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Indique la ubicación de sus principales actividades o puesto de trabajo </label>
                                <select class="form-control" name="INDIQUE_UBICACION_FRE" id="INDIQUE_UBICACION_FRE">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Campo</option>
                                    <option value="2">Instalación</option>
                                    <option value="3">Oficina </option>
                                </select>
                            </div>
                        </div>
                        <!-- SEXO -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Sexo *</label>
                                <select class="form-control" name="SEXO_EMPLEADO_FRE" id="SEXO_EMPLEADO_FRE" required>
                                    <option value="">Seleccionar</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Edad </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="EDAD_EMPLEADO_FRE" id="EDAD_EMPLEADO_FRE">
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Régimen Contractual </label>

                                <select class="custom-select form-control" id="REGIMEN_CONTRACTUAL_FRE" name="REGIMEN_CONTRACTUAL_FRE">
                                    <option value=""></option>
                                    @foreach($catregimen as $dato)
                                    <option value="{{$dato->ID_REGIMEN_CONTRACTUAL}}">{{$dato->NOMBRE_REGIMEN_CONTRACTUAL}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Jornada </label>
                                <select class="custom-select form-control" id="JORNADA_EMPLEADO_FRE" name="JORNADA_EMPLEADO_FRE">
                                    <option value=""></option>
                                    @foreach($catjornada as $dato)
                                    <option value="{{$dato->ID_JORNADA}}">{{$dato->NOMBRE_JORNADA}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>¿Cuánto tiempo lleva en la empresa?</label>
                                <input type="text" class="form-control" name="TIEMPO_EMPRESA_FRE" id="TIEMPO_EMPRESA_FRE">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Antigüedad en la categoría</label>
                                <input type="text" class="form-control" name="ANTIGUEDAD_CATEOGORIA_FRE" id="ANTIGUEDAD_CATEOGORIA_FRE">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Pausas de descanso que toma durante la
                                    jornada de trabajo (Mencione cuantas y
                                    duración en minutos)</label>
                                <input type="text" class="form-control" name="PAUSAS_DESCANSO" id="PAUSAS_DESCANSO">
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="form-group">
                                <label>
                                    ¿HA SUFRIDO ALGUNA LESIÓN O ACCIDENTES LABORAL DURANTE LA JORNADA LABORAL?
                                </label>

                                <select class="form-control" id="SUFRIDO_LESION_ACCIDENTE" name="SUFRIDO_LESION_ACCIDENTE">
                                    <option value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12" id="datosLesion" style="display:none;">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>¿Cuándo?</label>
                                        <input type="text" class="form-control" id="CUANDO_LESION_ACCIDENTE" name="CUANDO_LESION_ACCIDENTE">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>¿Cuál?</label>
                                        <input type="text" class="form-control" id="CUAL_LESION_ACCIDENTE" name="CUAL_LESION_ACCIDENTE">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="col-12 mt-2">
                            <button type="button" class="btn btn-danger" onclick="agregarActividadFRE()">
                                + Agregar Actividad
                            </button>
                        </div>

                        <div class="col-12 mt-2">
                            <div id="contenedorActividadesfre" class="mt-2"></div>
                        </div>

                        <br><br>

                        <style>
                            /* ACTIVIDADES */

                            #contenedorActividadesfre {
                                width: 100%;
                            }

                            .actividad-card {
                                width: 100%;
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                padding: 15px;
                                margin-bottom: 10px;
                                background: #fff;
                            }

                            .actividad-row {
                                display: flex;
                                gap: 15px;
                                align-items: flex-start;
                            }

                            .actividad-left {
                                width: 30%;
                            }

                            .actividad-right {
                                width: 70%;
                            }

                            .btn-agregar-tarea {
                                width: 20%;
                                background: linear-gradient(90deg, #6dd6e4, #6dd6e4);
                                color: white;
                                border: none;
                            }

                            .tarea-item {
                                border: 1px solid #e5e7eb;
                                border-radius: 8px;
                                padding: 10px;
                                margin-top: 8px;
                                background: #f9fafb;
                            }



                            /* FICHAS */
                            .custom-container-left {
                                width: 100%;
                                max-width: 100%;
                                /* evita límite */
                                padding-left: !important;
                                padding-right: !important;
                            }

                            .no-padding {
                                padding-left: !important;
                                padding-right: !important;
                            }



                            .custom-card-header {
                                width: 100%;
                                text-align: left;
                            }

                            .custom-card-nom .card-body {
                                padding: 20px;
                            }

                            .custom-card-nom .row {
                                justify-content: flex-start;
                            }
                        </style>


                        <div class="col-12 mt-5">
                            <div class="form-group">
                                <label>
                                    1. ¿SU MÉDICO LE HA DIAGNOSTICADO ALGUNA ENFERMEDAD MUSCULO-ESQUELÉTICA?
                                </label>

                                <select class="form-control" id="ENFERMEDAD_MUSCULOESQUELETICA" name="ENFERMEDAD_MUSCULOESQUELETICA">
                                    <option value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12" id="datosEnfermedadMusculo" style="display:none;">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>¿Cuál?</label>
                                        <input type="text" class="form-control" id="ENFERMEDAD_MUSCULOESQUELETICA_CUAL" name="ENFERMEDAD_MUSCULOESQUELETICA_CUAL">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>¿Hace cuánto tiempo?</label>
                                        <input type="text" class="form-control" id="ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO" name="ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    2. ¿HA ESTADO INCAPACITADO (A) A CAUSA DEL DOLOR MUSCULO ESQUELÉTICO EN EL ÚLTIMO AÑO?
                                </label>

                                <select class="form-control" id="INCAPACITADO_DOLOR_MUSCULO" name="INCAPACITADO_DOLOR_MUSCULO">
                                    <option value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <h4><b>Equipo de Protección Personal (EPP)</b></h4>
                        </div>

                        <div class="col-12 mb-3">
                            <button type="button"
                                class="btn btn-danger "
                                id="agregarEPP">
                                <i class="fa fa-plus"></i>
                                Agregar EPP
                            </button>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered table-hover" id="tablaEPP">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="25%">Región Anatómica</th>
                                        <th width="35%">Clave y EPP</th>
                                        <th width="30%">Tipo de Riesgo</th>
                                        <th width="10%" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <h5 class="text-center mb-3"><strong>Máquinas, herramientas y utensilios</strong></h5>
                                <button type="button" class="btn btn-danger mb-2" id="agregarFilaEquipo">
                                    Agregar fila
                                </button>
                                <table class="table table-bordered align-middle" id="tablaEquiposTrabajo">
                                    <thead>
                                        <tr>
                                            <th width="15%">Tipo</th>
                                            <th width="20%">Nombre</th>
                                            <th width="25%">Características</th>
                                            <th width="20%">Peso</th>
                                            <th width="15%">Método (agarres, técnicas, ayudas)</th>
                                            <th width="5%">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <h4>
                                <b> Descripción de las condiciones ambientales (apercepción del trabajador) </b>
                            </h4>

                        </div>

                        <div class="col-12">
                            <h4 style="color: #95C12D; font-weight: bold;">
                                Iluminación (Del área de trabajo)
                            </h4>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Fuente</label>
                                <select class="form-control" name="FUENTE_ILUMINACION" id="FUENTE_ILUMINACION">
                                    <option value="">Seleccione</option>
                                    <option value="1">Natural</option>
                                    <option value="2">Artificial</option>
                                    <option value="3">Mixta</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Intensidad</label>
                                <select class="form-control" name="INTENSIDAD_ILUMINACION" id="INTENSIDAD_ILUMINACION">
                                    <option value="">Seleccione</option>
                                    <option value="1">Normal</option>
                                    <option value="2">Deficiente</option>
                                    <option value="3">Excesiva</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="OBSERVACION_ILUMINACION" id="OBSERVACION_ILUMINACION" rows="3"></textarea>
                                    <button type="button" class="btn btn-info btnMicrofono" data-target="OBSERVACION_ILUMINACION">
                                        <i class="fa fa-microphone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <h4 style="color: #95C12D; font-weight: bold;">
                                Condiciones térmicas (Percepción de frío o calor)
                            </h4>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Percepción</label>
                                <select class="form-control" name="PERCEPCION_TERMICA" id="PERCEPCION_TERMICA">
                                    <option value="">Seleccione</option>
                                    <option value="1">Calor</option>
                                    <option value="2">Frío</option>
                                    <option value="3">Otros</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Intensidad</label>
                                <select class="form-control" name="INTENSIDAD_TERMICA" id="INTENSIDAD_TERMICA">
                                    <option value="">Seleccione</option>
                                    <option value="1">Leve</option>
                                    <option value="2">Moderada</option>
                                    <option value="3">Severa</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12" id="CONDICION_TERMINCA_CUAL" style="display: none;">
                            <div class="form-group">
                                <label>Cuál ? *</label>
                                <input type="text" class="form-control" name="CUAL_PERCEPCION" id="CUAL_PERCEPCION" required>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label>Fuentes</label>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaFuentesTermicas">
                                    <thead>
                                        <tr>
                                            <th>Fuente</th>
                                            <th width="80">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button"
                                class="btn btn-danger"
                                id="agregarFuenteTermica">
                                Agregar fuente
                            </button>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>Observaciones</label>

                                <div class="input-group">
                                    <textarea class="form-control"
                                        name="OBSERVACIONES_TERMICAS"
                                        id="OBSERVACIONES_TERMICAS"
                                        rows="3"></textarea>

                                    <button type="button"
                                        class="btn btn-info btnMicrofono"
                                        data-target="OBSERVACIONES_TERMICAS">
                                        <i class="fa fa-microphone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <h4 style="color: #95C12D; font-weight: bold;">
                                Ambiente sonoro (Ruido ambiental)
                            </h4>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Intensidad</label>
                                <select class="form-control" name="INTENSIDAD_RUIDO" id="INTENSIDAD_RUIDO">
                                    <option value="">Seleccione</option>
                                    <option value="1">Leve</option>
                                    <option value="2">Moderada</option>
                                    <option value="3">Severa</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Continuidad</label>
                                <select class="form-control" name="CONTINUIDAD_RUIDO" id="CONTINUIDAD_RUIDO">
                                    <option value="">Seleccione</option>
                                    <option value="1">Continuo</option>
                                    <option value="2">Intermitente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label>Fuentes</label>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaFuentesRuido">
                                    <thead>
                                        <tr>
                                            <th>Fuente</th>
                                            <th width="80">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button"
                                class="btn btn-danger"
                                id="agregarFuenteRuido">
                                Agregar fuente
                            </button>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>Observaciones</label>

                                <div class="input-group">

                                    <textarea class="form-control"
                                        name="OBSERVACIONES_RUIDO"
                                        id="OBSERVACIONES_RUIDO"
                                        rows="3"></textarea>

                                    <button type="button"
                                        class="btn btn-info btnMicrofono"
                                        data-target="OBSERVACIONES_RUIDO">
                                        <i class="fa fa-microphone"></i>
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <h4 style="color: #95C12D; font-weight: bold;">
                                Vibración (Generada por máquinas) si usa herramientas que vibren especifique cuál y su uso (diario, mensual, etc.)
                            </h4>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Intensidad</label>
                                <select class="form-control" name="INTENSIDAD_VIBRACION" id="INTENSIDAD_VIBRACION">
                                    <option value="">Seleccione</option>
                                    <option value="1">Leve</option>
                                    <option value="2">Moderada</option>
                                    <option value="3">Severa</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Segmentos corporales</label>
                                <select class="form-control" name="SEGMENTO_VIBRACION" id="SEGMENTO_VIBRACION">
                                    <option value="">Seleccione</option>
                                    <option value="1">Mano brazo</option>
                                    <option value="2">Cuerpo entero</option>
                                    <option value="3">Columna y miembros inferiores</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label>Fuentes</label>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaFuentesVibracion">
                                    <thead>
                                        <tr>
                                            <th>Fuente</th>
                                            <th width="80">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button"
                                class="btn btn-danger"
                                id="agregarFuenteVibracion">
                                Agregar fuente
                            </button>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>Observaciones</label>

                                <div class="input-group">

                                    <textarea class="form-control"
                                        name="OBSERVACIONES_VIBRACION"
                                        id="OBSERVACIONES_VIBRACION"
                                        rows="3"></textarea>

                                    <button type="button"
                                        class="btn btn-info btnMicrofono"
                                        data-target="OBSERVACIONES_VIBRACION">
                                        <i class="fa fa-microphone"></i>
                                    </button>

                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4>
                                <b>Cuestionario Nórdico:</b> Traducido directamente de la publicación original “Standardised Nordic questionnaires for the
                                of músculoskeletal symptoms” de Kuoirinka et col, por Jaime Ibacache Araya Profesional Ergónomo del Instituto de
                                Salud Pública de Chile.
                            </h4>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Peso (kg) </label>
                                <input type="number" class="form-control" name="PESO_FRE" id="PESO_FRE">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Talla (cm) </label>
                                <input type="number" class="form-control" name="TALLA_FRE" id="TALLA_FRE">
                            </div>
                        </div>

                        <!-- CUESTIONARIO NORDICO  -->

                        <div class="col-12">
                            <table width="100%">
                                <tr>
                                    <td width="75%" valign="top">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="45%">Problemas en el aparato locomotor</th>
                                                    <th width="15%" class="text-center">No</th>
                                                    <th width="15%" class="text-center">Sí</th>
                                                    <th width="12%" class="text-center">Izq.</th>
                                                    <th width="13%" class="text-center">Der.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5">
                                                        <strong>Para ser respondido por todos</strong><br>
                                                        ¿En algún momento durante los últimos 12 meses, ha tenido problemas
                                                        (dolor, molestias, disconfort) en:
                                                    </td>
                                                </tr>
                                                <!-- CUELLO -->
                                                <tr>
                                                    <td>Cuello</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CUELLO" id="CUELLO_NO" value="0">
                                                            <label class="form-check-label" for="CUELLO_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CUELLO" id="CUELLO_SI" value="1">
                                                            <label class="form-check-label" for="CUELLO_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- HOMBRO -->
                                                <tr>
                                                    <td>Hombro</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="HOMBRO" id="HOMBRO_NO" value="0">
                                                            <label class="form-check-label" for="HOMBRO_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="HOMBRO" id="HOMBRO_SI" value="1">
                                                            <label class="form-check-label" for="HOMBRO_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="HOMBRO_IZQ" id="HOMBRO_IZQ" disabled>
                                                            <label class="form-check-label" for="HOMBRO_IZQ">Izq.</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="HOMBRO_DER" id="HOMBRO_DER" disabled>
                                                            <label class="form-check-label" for="HOMBRO_DER">Der.</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- CODO -->
                                                <tr>
                                                    <td>Codo</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CODO" id="CODO_NO" value="0">
                                                            <label class="form-check-label" for="CODO_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CODO" id="CODO_SI" value="1">
                                                            <label class="form-check-label" for="CODO_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="CODO_IZQ" id="CODO_IZQ" disabled>
                                                            <label class="form-check-label" for="CODO_IZQ">Izq.</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="CODO_DER" id="CODO_DER" disabled>
                                                            <label class="form-check-label" for="CODO_DER">Der.</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- MUÑECA -->
                                                <tr>
                                                    <td>Muñeca</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="MUNECA" id="MUNECA_NO" value="0">
                                                            <label class="form-check-label" for="MUNECA_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="MUNECA" id="MUNECA_SI" value="1">
                                                            <label class="form-check-label" for="MUNECA_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="MUNECA_IZQ" id="MUNECA_IZQ" disabled>
                                                            <label class="form-check-label" for="MUNECA_IZQ">Izq</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="checkbox" name="MUNECA_DER" id="MUNECA_DER" disabled>
                                                            <label class="form-check-label" for="MUNECA_DER">Der</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- ESPALDA ALTA (REGIÓN DORSAL) -->
                                                <tr>
                                                    <td>Espalda alta (región dorsal)</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="ESPALDA_ALTA" id="ESPALDA_ALTA_NO" value="0">
                                                            <label class="form-check-label" for="ESPALDA_ALTA_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="ESPALDA_ALTA" id="ESPALDA_ALTA_SI" value="1">
                                                            <label class="form-check-label" for="ESPALDA_ALTA_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- ESPALDA BAJA (REGIÓN LUMBAR) -->
                                                <tr>
                                                    <td>Espalda baja (región lumbar)</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="ESPALDA_BAJA" id="ESPALDA_BAJA_NO" value="0">
                                                            <label class="form-check-label" for="ESPALDA_BAJA_NO">
                                                                No
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="ESPALDA_BAJA" id="ESPALDA_BAJA_SI" value="1">
                                                            <label class="form-check-label" for="ESPALDA_BAJA_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- CADERAS / PIERNAS -->
                                                <tr>
                                                    <td>Una o ambas caderas / piernas</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CADERAS_PIERNAS" id="CADERAS_PIERNAS_NO" value="0">
                                                            <label class="form-check-label" for="CADERAS_PIERNAS_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="CADERAS_PIERNAS" id="CADERAS_PIERNAS_SI" value="1">
                                                            <label class="form-check-label" for="CADERAS_PIERNAS_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- RODILLAS -->
                                                <tr>
                                                    <td>Una o ambas rodillas</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="RODILLAS" id="RODILLAS_NO" value="0">
                                                            <label class="form-check-label" for="RODILLAS_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="RODILLAS" id="RODILLAS_SI" value="1">
                                                            <label class="form-check-label" for="RODILLAS_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- TOBILLOS / PIES -->
                                                <tr>
                                                    <td>Uno o ambos tobillos / pies</td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="TOBILLOS_PIES" id="TOBILLOS_PIES_NO" value="0">
                                                            <label class="form-check-label" for="TOBILLOS_PIES_NO">No</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check mx-4 clienteblock">
                                                            <input class="form-check-input" type="radio" name="TOBILLOS_PIES" id="TOBILLOS_PIES_SI" value="1">
                                                            <label class="form-check-label" for="TOBILLOS_PIES_SI">Sí</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </td>

                                    <td width="25%" class="text-center" valign="top">

                                        <img src="{{ asset('assets/images/ergo/imagencuerpo.png') }}"
                                            class="img-fluid"
                                            style="max-width: 337px;">

                                    </td>

                                </tr>
                            </table>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            PROBLEMAS EN EL APARATO LOCOMOTOR
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <strong>
                                                Para ser respondido solo por aquellos que han presentado problemas en el aparato locomotor durante los últimos 12 meses
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="32%">
                                            <strong>Segmento</strong>
                                        </td>
                                        <td width="34%" class="text-center">
                                            ¿En algún momento, durante los últimos 12 meses, ha tenido algún impedimento para hacer su trabajo normal (en casa o fuera de casa) debido a sus molestias?
                                        </td>
                                        <td width="34%" class="text-center">
                                            ¿En algún momento, durante los últimos 7 días, ha tenido algún impedimento para hacer su trabajo normal debido a sus molestias?
                                        </td>
                                    </tr>

                                    <!-- CUELLO -->
                                    <tr>
                                        <td>
                                            Cuello
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CUELLO_12_MESES" id="CUELLO_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="CUELLO_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CUELLO_12_MESES" id="CUELLO_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="CUELLO_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CUELLO_7_DIAS" id="CUELLO_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="CUELLO_7_DIAS_NO"> No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CUELLO_7_DIAS" id="CUELLO_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="CUELLO_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- HOMBRO -->

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span>Hombro</span>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="HOMBRO_IZQ_2" name="HOMBRO_IZQ_2">
                                                    <label class="form-check-label" for="HOMBRO_IZQ_2">Izq.</label>
                                                </div>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="HOMBRO_DER_2" name="HOMBRO_DER_2">
                                                    <label class="form-check-label" for="HOMBRO_DER_2">Der,</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="HOMBRO_12_MESES" id="HOMBRO_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="HOMBRO_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="HOMBRO_12_MESES" id="HOMBRO_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="HOMBRO_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="HOMBRO_7_DIAS" id="HOMBRO_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="HOMBRO_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="HOMBRO_7_DIAS" id="HOMBRO_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="HOMBRO_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span>Codo</span>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="CODO_IZQ_2" name="CODO_IZQ_2">
                                                    <label class="form-check-label" for="CODO_IZQ_2">Izq.</label>
                                                </div>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="CODO_DER_2" name="CODO_DER_2">
                                                    <label class="form-check-label" for="CODO_DER_2">Der.</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CODO_12_MESES" id="CODO_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="CODO_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CODO_12_MESES" id="CODO_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="CODO_12_MESES_SI">Sí </label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CODO_7_DIAS" id="CODO_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="CODO_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CODO_7_DIAS" id="CODO_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="CODO_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span>Muñeca</span>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="MUNECA_IZQ_2" name="MUNECA_IZQ_2">
                                                    <label class="form-check-label" for="MUNECA_IZQ_2">Izq.</label>
                                                </div>
                                                <div class="form-check mx-3 clienteblock">
                                                    <input class="form-check-input" type="checkbox" id="MUNECA_DER_2" name="MUNECA_DER_2">
                                                    <label class="form-check-label" for="MUNECA_DER_2">Der.</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="MUNECA_12_MESES" id="MUNECA_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="MUNECA_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="MUNECA_12_MESES" id="MUNECA_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="MUNECA_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="MUNECA_7_DIAS" id="MUNECA_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="MUNECA_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="MUNECA_7_DIAS" id="MUNECA_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="MUNECA_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>



                                    <tr>
                                        <td>
                                            Espalda alta (región dorsal)
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_ALTA_12_MESES" id="ESPALDA_ALTA_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="ESPALDA_ALTA_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_ALTA_12_MESES" id="ESPALDA_ALTA_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="ESPALDA_ALTA_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_ALTA_7_DIAS" id="ESPALDA_ALTA_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="ESPALDA_ALTA_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_ALTA_7_DIAS" id="ESPALDA_ALTA_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="ESPALDA_ALTA_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Espalda baja (región lumbar)
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_BAJA_12_MESES" id="ESPALDA_BAJA_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="ESPALDA_BAJA_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_BAJA_12_MESES" id="ESPALDA_BAJA_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="ESPALDA_BAJA_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_BAJA_7_DIAS" id="ESPALDA_BAJA_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="ESPALDA_BAJA_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="ESPALDA_BAJA_7_DIAS" id="ESPALDA_BAJA_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="ESPALDA_BAJA_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Una o ambas caderas / piernas
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CADERAS_PIERNAS_12_MESES" id="CADERAS_PIERNAS_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="CADERAS_PIERNAS_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CADERAS_PIERNAS_12_MESES" id="CADERAS_PIERNAS_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="CADERAS_PIERNAS_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CADERAS_PIERNAS_7_DIAS" id="CADERAS_PIERNAS_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="CADERAS_PIERNAS_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="CADERAS_PIERNAS_7_DIAS" id="CADERAS_PIERNAS_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="CADERAS_PIERNAS_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Una o ambas rodillas
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="RODILLAS_12_MESES" id="RODILLAS_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="RODILLAS_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="RODILLAS_12_MESES" id="RODILLAS_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="RODILLAS_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="RODILLAS_7_DIAS" id="RODILLAS_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="RODILLAS_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="RODILLAS_7_DIAS" id="RODILLAS_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="RODILLAS_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Uno o ambos tobillos / pies
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="TOBILLOS_PIES_12_MESES" id="TOBILLOS_PIES_12_MESES_NO" value="0">
                                                    <label class="form-check-label" for="TOBILLOS_PIES_12_MESES_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="TOBILLOS_PIES_12_MESES" id="TOBILLOS_PIES_12_MESES_SI" value="1">
                                                    <label class="form-check-label" for="TOBILLOS_PIES_12_MESES_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="TOBILLOS_PIES_7_DIAS" id="TOBILLOS_PIES_7_DIAS_NO" value="0">
                                                    <label class="form-check-label" for="TOBILLOS_PIES_7_DIAS_NO">No</label>
                                                </div>
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="TOBILLOS_PIES_7_DIAS" id="TOBILLOS_PIES_7_DIAS_SI" value="1">
                                                    <label class="form-check-label" for="TOBILLOS_PIES_7_DIAS_SI">Sí</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th colspan="2" class="text-center">
                                            COLUMNA LUMBAR (Espalda baja)
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <!-- PREGUNTA 1 -->
                                    <tr>
                                        <td width="70%">
                                            <strong>1.</strong>
                                            ¿Alguna vez ha tenido problemas en la parte baja de la espalda
                                            (molestias, dolor o disconfort)?
                                        </td>
                                        <td width="30%">
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check mx-4 clienteblock">
                                                    <input class="form-check-input" type="radio" name="COLUMNA_LUMBAR_P1" id="COLUMNA_LUMBAR_P1_NO" value="0">
                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P1_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P1"
                                                        id="COLUMNA_LUMBAR_P1_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P1_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MENSAJE -->
                                    <tr>

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si respondió "<b> NO </b>" a la pregunta 1,
                                                entonces <b>NO </b> responda las preguntas 2 a la 8.
                                            </strong>

                                        </td>

                                    </tr>


                                    <!-- PREGUNTA 2 -->
                                    <tr class="bloque-lumbar-p2">

                                        <td>

                                            <strong>2.</strong>
                                            ¿Ha sido hospitalizado por problemas
                                            en la parte baja de la espalda?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P2"
                                                        id="COLUMNA_LUMBAR_P2_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P2_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P2"
                                                        id="COLUMNA_LUMBAR_P2_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P2_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 3 -->
                                    <tr class="bloque-lumbar-p3">

                                        <td>

                                            <strong>3.</strong>

                                            ¿Alguna vez ha tenido que cambiar de trabajo
                                            o deberes debido a problemas en la espalda baja?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P3"
                                                        id="COLUMNA_LUMBAR_P3_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P3_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P3"
                                                        id="COLUMNA_LUMBAR_P3_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P3_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>


                                    <!-- PREGUNTA 4 -->
                                    <tr class="bloque-lumbar-p4">

                                        <td>

                                            <strong>4.</strong>
                                            ¿Cuántos días aproximadamente le ha impedido realizar
                                            su trabajo (en casa o fuera de casa) durante los últimos
                                            12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P4"
                                                    id="COLUMNA_LUMBAR_P4_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P4_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P4"
                                                    id="COLUMNA_LUMBAR_P4_1_7"
                                                    value="1">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P4_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P4"
                                                    id="COLUMNA_LUMBAR_P4_8_30"
                                                    value="2">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P4_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P4"
                                                    id="COLUMNA_LUMBAR_P4_MAS30"
                                                    value="3">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P4_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P4"
                                                    id="COLUMNA_LUMBAR_P4_TODOS"
                                                    value="4">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P4_TODOS">
                                                    Todos los días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>


                                    <tr>

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si usted respondió <b>"0 días"</b> en la pregunta 4,
                                                entonces <b>NO</b> responda las preguntas 5 a la 8.
                                            </strong>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 5 -->

                                    <tr class="bloque-lumbar-p5">

                                        <td>

                                            <strong>5.</strong>
                                            ¿Los problemas de la parte baja de la espalda le han hecho reducir
                                            su actividad durante los últimos 12 meses?

                                            <br><br>

                                            <strong>a)</strong>
                                            ¿Actividad laboral (en casa o fuera de casa)?

                                            <br><br>

                                            <strong>b)</strong>
                                            ¿Actividad de ocio?

                                        </td>

                                        <td>

                                            <!-- ACTIVIDAD LABORAL -->
                                            <div class="d-flex justify-content-center mb-3">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL"
                                                        id="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL"
                                                        id="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                            <!-- ACTIVIDAD DE OCIO -->
                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO"
                                                        id="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO"
                                                        id="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 6 -->
                                    <tr class="bloque-lumbar-p6">

                                        <td>

                                            <strong>6.</strong>
                                            ¿Durante cuántos días aproximadamente ha tenido
                                            problemas en la parte baja de la espalda durante
                                            los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P6"
                                                    id="COLUMNA_LUMBAR_P6_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P6_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P6"
                                                    id="COLUMNA_LUMBAR_P6_1_7"
                                                    value="1">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P6_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P6"
                                                    id="COLUMNA_LUMBAR_P6_8_30"
                                                    value="2">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P6_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="COLUMNA_LUMBAR_P6"
                                                    id="COLUMNA_LUMBAR_P6_MAS30"
                                                    value="3">

                                                <label class="form-check-label"
                                                    for="COLUMNA_LUMBAR_P6_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>


                                    <!-- PREGUNTA 7 -->
                                    <tr class="bloque-lumbar-p7">

                                        <td>

                                            <strong>7.</strong>
                                            ¿Ha sido visto por un médico, fisioterapeuta,
                                            quiropráctico u otro profesional de la salud debido
                                            a problemas en la parte baja de la espalda durante
                                            los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P7"
                                                        id="COLUMNA_LUMBAR_P7_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P7_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P7"
                                                        id="COLUMNA_LUMBAR_P7_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P7_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 8 -->
                                    <tr class="bloque-lumbar-p8">

                                        <td>

                                            <strong>8.</strong>
                                            ¿Ha tenido problemas en la parte baja de la espalda
                                            en algún momento durante los últimos 7 días?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P8"
                                                        id="COLUMNA_LUMBAR_P8_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P8_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="COLUMNA_LUMBAR_P8"
                                                        id="COLUMNA_LUMBAR_P8_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="COLUMNA_LUMBAR_P8_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>
                                </tbody>

                            </table>


                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th colspan="2" class="text-center">
                                            CUELLO
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <!-- PREGUNTA 1 -->
                                    <tr>

                                        <td width="70%">

                                            <strong>1.</strong>
                                            ¿Alguna vez ha tenido problemas en el cuello
                                            (molestias, dolor o disconfort)?

                                        </td>

                                        <td width="30%">

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P1"
                                                        id="CUELLO_P1_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P1_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P1"
                                                        id="CUELLO_P1_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P1_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MENSAJE -->
                                    <tr>

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si respondió <b>"NO"</b> a la pregunta 1,
                                                entonces <b>NO</b> responda las preguntas 2 a la 8.
                                            </strong>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 2 -->
                                    <tr class="bloque-cuello-p2">

                                        <td>

                                            <strong>2.</strong>

                                            ¿Alguna vez se lastimó el cuello
                                            en un accidente?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P2"
                                                        id="CUELLO_P2_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P2_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P2"
                                                        id="CUELLO_P2_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P2_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 3 -->
                                    <tr class="bloque-cuello-p3">

                                        <td>

                                            <strong>3.</strong>

                                            ¿Alguna vez ha tenido que cambiar
                                            de trabajo o deberes debido
                                            a problemas en el cuello?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P3"
                                                        id="CUELLO_P3_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P3_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P3"
                                                        id="CUELLO_P3_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P3_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>
                                    <!-- PREGUNTA 4 -->
                                    <tr class="bloque-cuello-p4">

                                        <td>

                                            <strong>4.</strong>
                                            ¿Cuál es el tiempo total que ha tenido problemas en el cuello
                                            durante los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P4"
                                                    id="CUELLO_P4_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label"
                                                    for="CUELLO_P4_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P4"
                                                    id="CUELLO_P4_1_7"
                                                    value="1">

                                                <label class="form-check-label"
                                                    for="CUELLO_P4_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P4"
                                                    id="CUELLO_P4_8_30"
                                                    value="2">

                                                <label class="form-check-label"
                                                    for="CUELLO_P4_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P4"
                                                    id="CUELLO_P4_MAS30"
                                                    value="3">

                                                <label class="form-check-label"
                                                    for="CUELLO_P4_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P4"
                                                    id="CUELLO_P4_TODOS"
                                                    value="4">

                                                <label class="form-check-label"
                                                    for="CUELLO_P4_TODOS">
                                                    Todos los días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MENSAJE -->
                                    <tr class="bloque-cuello-p5">

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si usted respondió <b>"0 días"</b> en la pregunta 4,
                                                entonces <b>NO</b> responda las preguntas 5 a la 8.
                                            </strong>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 5 -->
                                    <tr class="bloque-cuello-p5">

                                        <td>

                                            <strong>5.</strong>

                                            ¿Los problemas del cuello le han hecho reducir
                                            su actividad durante los últimos 12 meses?

                                            <br><br>

                                            <strong>a)</strong>
                                            ¿Actividad laboral (en casa o fuera de casa)?

                                            <br><br>

                                            <strong>b)</strong>
                                            ¿Actividad de ocio?

                                        </td>

                                        <td>

                                            <!-- ACTIVIDAD LABORAL -->
                                            <div class="d-flex justify-content-center mb-3">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P5_ACTIVIDAD_LABORAL"
                                                        id="CUELLO_P5_ACTIVIDAD_LABORAL_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P5_ACTIVIDAD_LABORAL_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P5_ACTIVIDAD_LABORAL"
                                                        id="CUELLO_P5_ACTIVIDAD_LABORAL_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P5_ACTIVIDAD_LABORAL_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                            <!-- ACTIVIDAD DE OCIO -->
                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P5_ACTIVIDAD_OCIO"
                                                        id="CUELLO_P5_ACTIVIDAD_OCIO_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P5_ACTIVIDAD_OCIO_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P5_ACTIVIDAD_OCIO"
                                                        id="CUELLO_P5_ACTIVIDAD_OCIO_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P5_ACTIVIDAD_OCIO_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 6 -->
                                    <tr class="bloque-cuello-p6">

                                        <td>

                                            <strong>6.</strong>
                                            ¿Durante cuántos días aproximadamente ha tenido
                                            problemas en el cuello durante los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P6"
                                                    id="CUELLO_P6_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label"
                                                    for="CUELLO_P6_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P6"
                                                    id="CUELLO_P6_1_7"
                                                    value="1">

                                                <label class="form-check-label"
                                                    for="CUELLO_P6_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P6"
                                                    id="CUELLO_P6_8_30"
                                                    value="2">

                                                <label class="form-check-label"
                                                    for="CUELLO_P6_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="CUELLO_P6"
                                                    id="CUELLO_P6_MAS30"
                                                    value="3">

                                                <label class="form-check-label"
                                                    for="CUELLO_P6_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 7 -->
                                    <tr class="bloque-cuello-p7">

                                        <td>

                                            <strong>7.</strong>
                                            ¿Ha sido visto por un médico, fisioterapeuta,
                                            quiropráctico u otro profesional de la salud
                                            debido a problemas en el cuello durante los
                                            últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P7"
                                                        id="CUELLO_P7_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P7_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P7"
                                                        id="CUELLO_P7_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P7_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 8 -->
                                    <tr class="bloque-cuello-p8">

                                        <td>

                                            <strong>8.</strong>
                                            ¿Ha tenido problemas en el cuello
                                            durante los últimos 7 días?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P8"
                                                        id="CUELLO_P8_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P8_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="CUELLO_P8"
                                                        id="CUELLO_P8_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="CUELLO_P8_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>



                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th colspan="2" class="text-center">
                                            HOMBROS
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <!-- PREGUNTA 1 -->
                                    <tr>

                                        <td width="70%">

                                            <strong>1.</strong>
                                            ¿Alguna vez ha tenido problemas en el hombro
                                            (molestias, dolor o disconfort)?

                                        </td>

                                        <td width="30%">

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P1"
                                                        id="HOMBRO_P1_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P1_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P1"
                                                        id="HOMBRO_P1_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P1_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MENSAJE -->
                                    <tr>

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si respondió <b>"NO"</b> a la pregunta 1,
                                                entonces <b>NO</b> responda las preguntas 2 a la 8.
                                            </strong>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 2 -->
                                    <tr class="bloque-hombro-p2">

                                        <td>

                                            <strong>2.</strong>
                                            ¿Alguna vez se lastimó el hombro en un accidente?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P2"
                                                        id="HOMBRO_P2_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P2_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P2"
                                                        id="HOMBRO_P2_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P2_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 3 -->
                                    <tr class="bloque-hombro-p3">

                                        <td>

                                            <strong>3.</strong>
                                            ¿Alguna vez ha tenido que cambiar de trabajo
                                            o deberes debido a problemas en el hombro?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P3"
                                                        id="HOMBRO_P3_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P3_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P3"
                                                        id="HOMBRO_P3_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P3_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 4 -->
                                    <tr class="bloque-hombro-p4">

                                        <td>

                                            <strong>4.</strong>
                                            ¿Cuál es el tiempo total que ha tenido problemas en el hombro durante los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P4"
                                                    id="HOMBRO_P4_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label"
                                                    for="HOMBRO_P4_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P4"
                                                    id="HOMBRO_P4_1_7"
                                                    value="1">

                                                <label class="form-check-label"
                                                    for="HOMBRO_P4_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P4"
                                                    id="HOMBRO_P4_8_30"
                                                    value="2">

                                                <label class="form-check-label"
                                                    for="HOMBRO_P4_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P4"
                                                    id="HOMBRO_P4_MAS30"
                                                    value="3">

                                                <label class="form-check-label"
                                                    for="HOMBRO_P4_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P4"
                                                    id="HOMBRO_P4_TODOS"
                                                    value="4">

                                                <label class="form-check-label"
                                                    for="HOMBRO_P4_TODOS">
                                                    Todos los días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MENSAJE -->
                                    <tr class="bloque-hombro-p5">

                                        <td colspan="2" style="background:#efefef;">

                                            <strong>
                                                Si usted respondió <b>"0 días"</b> en la pregunta 4,
                                                entonces <b>NO</b> responda las preguntas 5 a la 8.
                                            </strong>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 5 -->
                                    <tr class="bloque-hombro-p5">

                                        <td>

                                            <strong>5.</strong>

                                            ¿Los problemas de hombro le han hecho reducir
                                            su actividad durante los últimos 12 meses?

                                            <br><br>

                                            <strong>a)</strong>
                                            ¿Actividad laboral (en casa o fuera de casa)?

                                            <br><br>

                                            <strong>b)</strong>
                                            ¿Actividad de ocio?

                                        </td>

                                        <td>

                                            <!-- ACTIVIDAD LABORAL -->
                                            <div class="d-flex justify-content-center mb-3">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P5_ACTIVIDAD_LABORAL"
                                                        id="HOMBRO_P5_ACTIVIDAD_LABORAL_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P5_ACTIVIDAD_LABORAL_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P5_ACTIVIDAD_LABORAL"
                                                        id="HOMBRO_P5_ACTIVIDAD_LABORAL_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P5_ACTIVIDAD_LABORAL_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                            <!-- ACTIVIDAD DE OCIO -->
                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P5_ACTIVIDAD_OCIO"
                                                        id="HOMBRO_P5_ACTIVIDAD_OCIO_NO"
                                                        value="0">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P5_ACTIVIDAD_OCIO_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P5_ACTIVIDAD_OCIO"
                                                        id="HOMBRO_P5_ACTIVIDAD_OCIO_SI"
                                                        value="1">

                                                    <label class="form-check-label"
                                                        for="HOMBRO_P5_ACTIVIDAD_OCIO_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>


                                    <!-- PREGUNTA 6 -->
                                    <tr class="bloque-hombro-p6">

                                        <td>

                                            <strong>6.</strong>
                                            ¿Cuál es el tiempo total que los problemas de hombro
                                            le han impedido hacer su trabajo normal
                                            (en casa o fuera de casa) durante los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P6"
                                                    id="HOMBRO_P6_0_DIAS"
                                                    value="0">

                                                <label class="form-check-label" for="HOMBRO_P6_0_DIAS">
                                                    0 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P6"
                                                    id="HOMBRO_P6_1_7"
                                                    value="1">

                                                <label class="form-check-label" for="HOMBRO_P6_1_7">
                                                    1 - 7 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P6"
                                                    id="HOMBRO_P6_8_30"
                                                    value="2">

                                                <label class="form-check-label" for="HOMBRO_P6_8_30">
                                                    8 - 30 días
                                                </label>

                                            </div>

                                            <div class="form-check clienteblock">

                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="HOMBRO_P6"
                                                    id="HOMBRO_P6_MAS30"
                                                    value="3">

                                                <label class="form-check-label" for="HOMBRO_P6_MAS30">
                                                    Más de 30 días
                                                </label>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 7 -->
                                    <tr class="bloque-hombro-p7">

                                        <td>

                                            <strong>7.</strong>
                                            ¿Ha sido atendido por un médico, kinesiólogo,
                                            quiropráctico u otra persona por problemas
                                            en el hombro durante los últimos 12 meses?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P7"
                                                        id="HOMBRO_P7_NO"
                                                        value="0">

                                                    <label class="form-check-label" for="HOMBRO_P7_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P7"
                                                        id="HOMBRO_P7_SI"
                                                        value="1">

                                                    <label class="form-check-label" for="HOMBRO_P7_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- PREGUNTA 8 -->
                                    <tr class="bloque-hombro-p8">

                                        <td>

                                            <strong>8.</strong>
                                            ¿Ha tenido problemas de hombro
                                            en algún momento durante los últimos 7 días?

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center">

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P8"
                                                        id="HOMBRO_P8_NO"
                                                        value="0">

                                                    <label class="form-check-label" for="HOMBRO_P8_NO">
                                                        No
                                                    </label>

                                                </div>

                                                <div class="form-check mx-4 clienteblock">

                                                    <input class="form-check-input"
                                                        type="radio"
                                                        name="HOMBRO_P8"
                                                        id="HOMBRO_P8_SI"
                                                        value="1">

                                                    <label class="form-check-label" for="HOMBRO_P8_SI">
                                                        Sí
                                                    </label>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>


                        <div class="col-12">
                            <h4>
                                Fuerza manual:
                            </h4>
                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label>Mano derecha *</label>
                                <input type="text" class="form-control" id="FUERZA_MANO_DERECHA" name="FUERZA_MANO_DERECHA" placeholder="Valor">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Mano izquierda *</label>
                                <input type="text" class="form-control" id="FUERZA_MANO_IZQUIERDA" name="FUERZA_MANO_IZQUIERDA" placeholder="Valor">
                            </div>
                        </div>



                        <div class="col-6">
                            <div class="form-group">
                                <label>Indique si su tarea requiere uso de fuerza manual: </label>
                                <select class="form-control" name="REQUIERE_FUERZA_MANUAL" id="REQUIERE_FUERZA_MANUAL">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Tipo de Dominancia: </label>
                                <select class="form-control" name="TIPO_DOMINANCIA" id="TIPO_DOMINANCIA">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Derecha</option>
                                    <option value="2">Izquierda</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <h4>
                                LEY SILLA: DOF 19/12/24.
                            </h4>
                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label><br> A) Realiza sus tareas laborales de pie por más de tres horas continuas durante su jornada laboral:</label>
                                <select class="form-control" name="REALIZA_TAREAS_PIE" id="REALIZA_TAREAS_PIE">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label>B) Bipedestación estática. La postura de las personas trabajadoras que realizan sus tareas de pie y prácticamente sin moverse o
                                    con desplazamientos mínimos:</label>
                                <select class="form-control" name="BIPEDESTACION_ESTATICA" id="BIPEDESTACION_ESTATICA">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>C) Bipedestación dinámica. La postura de las personas trabajadoras que tienen la posibilidad de realizar desplazamientos más
                                    amplios que en la bipedestación estática:</label>
                                <select class="form-control" name="BIPEDESTACION_DINAMICA" id="BIPEDESTACION_DINAMICA">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>Observaciones Generales: Llenar solo si aplica.</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="OBSERVACIONES_GENERALES" id="OBSERVACIONES_GENERALES" rows="4"></textarea>
                                </div>
                            </div>
                        </div>





                    </div>


                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Coordinador FRE','Especialista FRE']))
                        <button type="submit" class="btn btn-danger waves-effect waves-light botonguardar_modulorecsensorial" id="boton_guardar_fre">
                            Guardar <i class="fa fa-save"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- VISOR-MODAL -->
<!-- ============================================================== -->
<style type="text/css" media="screen">
    #modal_visor>.modal-dialog {
        min-width: 900px !important;
    }

    #visor_menu_bloqueado {
        width: 851px;
        height: 52px;
        background: #555555;
        position: absolute;
        z-index: 500;
        border: 0px #F00 solid;
    }

    #visor_contenido_bloqueado {
        width: 852px;
        height: 600px;
        /*background: #555555;*/
        position: absolute;
        z-index: 600;
        border: 0px #FFF solid;
    }

    iframe {
        width: 100%;
        height: 600px;
        border: 0px #fff solid;
    }
</style>
<div id="modal_visor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="nombre_documento_visor"></h4>
            </div>
            <div class="modal-body" style="background: #555555;">
                <div class="row">
                    <div class="col-12">
                        {{-- <div id="visor_menu_bloqueado"></div> --}}
                        {{-- <div id="visor_contenido_bloqueado"></div> --}}
                        <iframe src="/assets/images/cargando.gif" name="visor_documento" id="visor_documento" style=""></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" id="modalvisor_boton_cerrar">Cerrar</button>
                {{-- <button type="button" class="btn btn-danger waves-effect waves-light">Guardar</button> --}}
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- VISOR-MODAL -->
<!-- ============================================================== -->

{{-- ========================================================================= --}}




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


<script>
    $(document).ready(function() {

        $('#INFORME_INTRODUCCION').summernote({
            height: 400
        });

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

{{-- Amcharts --}}
<link href="/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
<script src="/assets/plugins/amChart/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/serial.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/plugins/responsive/responsive.min.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/plugins/export/export.js" type="text/javascript"></script>
<link href="/assets/plugins/amChart/amcharts/plugins/export/export.css" type="text/css" media="all" rel="stylesheet" />
<script src="/assets/plugins/amChart/amcharts/pie.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/themes/light.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/themes/black.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/themes/dark.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="/assets/plugins/amChart/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="/js_sitio/html2canvas.js"></script>


<script>
    window.catRegionAnatomica = @json($catregionanatomica);
    window.catClaveEPP = @json($catclaveyepp);
</script>





@endsection
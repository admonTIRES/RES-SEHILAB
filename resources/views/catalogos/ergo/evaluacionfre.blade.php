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
        background-color: #ffe5e5 !important
        ;
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
                        <span class="hidden-xs-down">Lista de reconocimientos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link_menuprincipal" data-toggle="tab" href="#tab_2" id="tab_menu2" role="tab">
                        <span class="hidden-sm-up"><i class="ti-pencil-alt"></i></span>
                        <span class="hidden-xs-down">Datos del reconocimiento</span>
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

                                                                            <!-- Datos de Informe obtenido por el cliente -->
                                                                            <!-- <div class="col-12 mt-5">
                                                                                <div id="accordion">
                                                                                    <div class="card">
                                                                                        <div class="card-header" id="headingOne">
                                                                                            <h5 class="mb-0">
                                                                                                <button class="btn btn-link" id="accordionButton" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" disabled>
                                                                                                    Informe del reconocimiento proporcionado por el cliente
                                                                                                </button>
                                                                                            </h5>
                                                                                        </div>
                                                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                                            <div class="card-body">
                                                                                                <div class="row">
                                                                                                    <div class="col-6">
                                                                                                        <div class="form-group">
                                                                                                            <label>Fecha de elaboración*</label>
                                                                                                            <div class="input-group">
                                                                                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="recsensorial_fechaelaboracion" name="recsensorial_fechaelaboracion" required>
                                                                                                                <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-6">
                                                                                                        <div class="form-group">
                                                                                                            <label>Persona o entidad que lo elaboró*</label>
                                                                                                            <input type="text" class="form-control" id="recsensorial_personaelaboro" name="recsensorial_personaelaboro" required>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-12">
                                                                                                        <div class="form-group">
                                                                                                            <label>Informe de reconocimiento *</label>
                                                                                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                                                                <div class="form-control" data-trigger="fileinput" id="documentoclienteDiv">
                                                                                                                    <i class="fa fa-file fileinput-exists"></i>
                                                                                                                    <span class="fileinput-filename"></span>
                                                                                                                </div>
                                                                                                                <span class="input-group-addon btn btn-secondary btn-file">
                                                                                                                    <span class="fileinput-new">Seleccione</span>
                                                                                                                    <span class="fileinput-exists">Cambiar</span>
                                                                                                                    <input type="file" accept="application/pdf" name="documentocliente" id="documentocliente" required>
                                                                                                                </span>
                                                                                                                <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">
                                                                                                                    Quitar
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div class="col-6">
                                                                                                        <div class="form-group">
                                                                                                            <label>Fecha de validacion*</label>
                                                                                                            <div class="input-group">
                                                                                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="recsensorial_fechavalidacion" name="recsensorial_fechavalidacion" required>
                                                                                                                <span class="input-group-addon"><i class="icon-calender"></i></span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-6">
                                                                                                        <div class="form-group">
                                                                                                            <label>Entidad que valido*</label>
                                                                                                            <input type="text" class="form-control" id="recsensorial_personavalido" name="recsensorial_personavalido" required>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-12">
                                                                                                        <div class="form-group">
                                                                                                            <label>Documento de Validación *</label>
                                                                                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                                                                <div class="form-control" data-trigger="fileinput" id="documentoclientevalidacionDiv">
                                                                                                                    <i class="fa fa-file fileinput-exists"></i>
                                                                                                                    <span class="fileinput-filename"></span>
                                                                                                                </div>
                                                                                                                <span class="input-group-addon btn btn-secondary btn-file">
                                                                                                                    <span class="fileinput-new">Seleccione</span>
                                                                                                                    <span class="fileinput-exists">Cambiar</span>
                                                                                                                    <input type="file" accept="application/pdf" name="documentoclientevalidacion" id="documentoclientevalidacion" required>
                                                                                                                </span>
                                                                                                                <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">
                                                                                                                    Quitar
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> -->

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
                                                                    <div class="col-12 clienteblock" id="seccion_foto_mapaderiesgo">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <i class="fa fa-download fa-2x text-success" style="position: absolute; margin-top: -4px; margin-left: 160px; z-index: 50; text-shadow: 1px 1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px 0px 0 #FFFFFF, 0px 1px 0 #FFFFFF; cursor: pointer; display: none;" data-toggle="tooltip" title="Descargar mapa de riesgo" id="boton_descargarmapaderiesgo"></i>
                                                                                <h4 class="card-title">Mapa de peligro <br> y riesgo ergonómico </h4>
                                                                                <div class="row">
                                                                                    <div class="col-12 clienteblock">
                                                                                        <div class="form-group">
                                                                                            <style type="text/css" media="screen">
                                                                                                .dropify-wrapper {
                                                                                                    height: 300px !important;
                                                                                                    /*tamaño estatico del campo foto*/
                                                                                                }
                                                                                            </style>
                                                                                            <input type="file" accept="image/jpeg,image/x-png,image/gif" id="inputfotomapaderiesgo" name="inputfotomapaderiesgo" data-allowed-file-extensions="jpg png JPG PNG" data-height="300" data-default-file="" />
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
                                                                @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Ergónomo']))
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
                                                            @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Ergónomo']))

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
                                                                            <th>Categoría</th>
                                                                            <th>Nombre del empleado </th>
                                                                            <th>Ficha / No empleado</th>
                                                                            <th style="width: 80px!important;">Visualizar</th>
                                                                            <th style="width: 80px!important;">Iniciar FRE</th>

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============= /STEPS ============= -->
                    </div>
                </div> <!-- /FIN TAB 2 -->

              
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

                        <input type="hidden" name="ID_FICHAS_TECNICAS" id="ID_FICHAS_TECNICAS">

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
                        <div class="col-12 mt-2">
                            <button type="button" class="btn btn-danger" onclick="agregarActividad()">
                                + Agregar Actividad
                            </button>
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

                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <div>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                         @if(auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador','Ergónomo']))
                        <button type="submit" class="btn btn-danger waves-effect waves-light botonguardar_modulorecsensorial" id="boton_guardar_fichastecnicas">
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

@endsection
<style type="text/css">
    .reporte_estructura {
        font-size: 14px !important;
        line-height: 14px !important;
    }

    #tabla_matrizlab select {
        min-width: 100px;
        padding: 4px 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: white;
        appearance: auto;
    }

    #DEPARTAMENTO_MEL {
        text-align-last: center;
        /* centra el texto dentro del select */
    }

    /* Responsivo */
    @media (max-width: 768px) {
        #DEPARTAMENTO_MEL {
            width: 90% !important;
        }
    }

    #tabla_mel_draft thead th {
        color: #000;
        font-weight: bold;
        vertical-align: middle !important;
        text-align: center;
        border: 1px solid #000 !important;
        white-space: normal;
    }

    #tabla_mel_draft .encabezado-generales {
        background-color: #C5D9F1 !important;
    }

    #tabla_mel_draft .encabezado-quimicos {
        background-color: #E4DFEC !important;
    }

    #tabla_mel_draft .encabezado-iluminacion {
        background-color: #F2DCDB !important;
    }

    #tabla_mel_draft .encabezado-temperatura {
        background-color: #EBF1DE !important;
    }

    #tabla_mel_draft .encabezado-ruido {
        background-color: #DDD9C4 !important;
    }

    #tabla_mel_draft .encabezado-vibraciones {
        background-color: #DAEEF3 !important;
    }

    #tabla_mel_draft .encabezado-aire {
        background-color: #FDE9D9 !important;
    }
</style>



<div class="row reporte_estructura">
    <div class="col-12">
        <div class="row">

            <div class="col-12">
                <ol class="breadcrumb mb-4 d-flex justify-content-center"
                    style="padding: 6px; margin: 0px 0px 10px 0px; background: #94B732!important">
                    <h3 class="text-light m-0" style="font-weight: bold;">Matriz de Exposición Laboral</h3>
                </ol>
            </div>
            <form method="post" enctype="multipart/form-data"
                name="form_reporte_portada" id="form_reporte_portada"
                class="col-12 text-center">
                {!! csrf_field() !!}

                <div class="mb-4">
                    <label class="form-label fw-bold mb-2 d-block">
                        Seleccione el departamento
                    </label>
                    <select class="custom-select form-control mx-auto text-center"
                        id="DEPARTAMENTO_MEL" name="DEPARTAMENTO_MEL"
                        style="width: 40%; min-width: 280px; max-width: 500px;">
                    </select>
                </div>

                <div class="text-center mt-3">
                    <button type="submit"
                        class="btn btn-danger waves-effect waves-light botoninforme"
                        id="botonguardar_reporte_matriz">
                        Guardar <i class="fa fa-save"></i>
                    </button>

                    <button type="button"
                        class="btn btn-default waves-effect"
                        style="margin-left: 15px;"
                        data-toggle="tooltip" title="Generar matriz"
                        id="btnExportarExcel">
                        <span class="btn-label"><i class="fa fa-file-excel-o"></i></span>
                        Generar matriz
                    </button>
                </div>
            </form>
            <div class="col-12 mt-3">
                <div style="overflow-x: auto; width: 100%;">
                    <table id="tabla_mel_draft"
                        class="table table-bordered text-center align-middle"
                        style="font-size: 13px; table-layout: fixed; min-width: 9000px;">

                        <thead>
                            <tr>
                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Contador
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Departamento
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Instalación
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Área de referencia<br>
                                    en atlas de riesgo
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Nombre
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Ficha
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Categoría
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Edad (años)
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Antigüedad General (años)
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Antigüedad en la categoría (años)
                                </th>

                                <th rowspan="3"
                                    class="encabezado-generales">
                                    Horario de trabajo
                                </th>

                                <th colspan="4"
                                    class="encabezado-quimicos">
                                    Agentes químicos
                                </th>

                                <th colspan="3"
                                    class="encabezado-iluminacion">
                                    Iluminación (Lux E2 / NMI)
                                </th>

                                <th colspan="3"
                                    class="encabezado-temperatura">
                                    Temperatura (TGBH medido / LMPE)
                                </th>

                                <th colspan="3"
                                    class="encabezado-ruido">
                                    Ruido (dB (A) medido / LMPE)
                                </th>

                                <th colspan="3"
                                    class="encabezado-vibraciones">
                                    Vibraciones (Frecuencia / Medición de aceleración longitudinal / LMPE)
                                </th>

                                <th colspan="18"
                                    class="encabezado-aire">
                                    Ventilación y calidad del aire
                                </th>
                            </tr>

                            <tr>
                                <th rowspan="2"
                                    class="encabezado-quimicos">
                                    Tipo
                                </th>

                                <th rowspan="2"
                                    class="encabezado-quimicos">
                                    Referencia<br>
                                    (VLE)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-quimicos">
                                    Resultado<br>
                                    (Concentración medida del ambiente)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-quimicos">
                                    Cumplimiento normativo
                                </th>

                                <th rowspan="2"
                                    class="encabezado-iluminacion">
                                    Referencia<br>
                                    (LMPE)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-iluminacion">
                                    Resultado<br>
                                    (Nivel)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-iluminacion">
                                    Cumplimiento normativo
                                </th>

                                <th rowspan="2"
                                    class="encabezado-temperatura">
                                    Referencia<br>
                                    (LMPE)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-temperatura">
                                    Resultado<br>
                                    (TGBH medido)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-temperatura">
                                    Cumplimiento normativo
                                </th>

                                <th rowspan="2"
                                    class="encabezado-ruido">
                                    Referencia<br>
                                    (LMPE)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-ruido">
                                    Resultado<br>
                                    (dB medido)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-ruido">
                                    Cumplimiento normativo
                                </th>

                                <th rowspan="2"
                                    class="encabezado-vibraciones">
                                    Referencia<br>
                                    (LMPE)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-vibraciones">
                                    Resultado<br>
                                    (Frecuencia / Medición de aceleración longitudinal)
                                </th>

                                <th rowspan="2"
                                    class="encabezado-vibraciones">
                                    Cumplimiento normativo
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Temperatura (°C)
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Velocidad del aire (m/s)
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Humedad relativa (%)
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Monóxido de carbono CO (ppm)
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Dióxido de carbono CO₂ (ppm)
                                </th>

                                <th colspan="3"
                                    class="encabezado-aire">
                                    Bioaerosoles y otros
                                </th>
                            </tr>

                            <tr>
                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (°C)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (°C)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>

                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (m/s)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (m/s medido)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>

                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (%)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (% medido)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>

                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (VLE ppm)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (Concentración medida del ambiente)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>

                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (VLE ppm)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (Concentración medida del ambiente)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>

                                <th class="encabezado-aire">
                                    Referencia<br>
                                    (UFC / mtra)
                                </th>

                                <th class="encabezado-aire">
                                    Resultado<br>
                                    (Concentración medida del ambiente)
                                </th>

                                <th class="encabezado-aire">
                                    Cumplimiento normativo
                                </th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">
    var proyecto = <?php echo json_encode($proyecto); ?>;
    var estatus = <?php echo json_encode($estatus); ?>;
    var recsensorial = <?php echo json_encode($recsensorial); ?>;
</script>
<script src="/js_sitio/reportes/reportemeldraft.js?v=2"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
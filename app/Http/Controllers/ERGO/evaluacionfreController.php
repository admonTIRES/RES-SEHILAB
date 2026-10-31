<?php

namespace App\Http\Controllers\ERGO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;


use DB;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Shared\Html;

// Plugins
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Chart;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;
use ZipArchive;


// plugins PDF
use PDFMerger;



//MODELOS
use App\modelos\proyecto\proyectoModel;
use App\modelos\reconocimientoergo\reconocimientoergoModel;
use App\modelos\recsensorial\catdepartamentoModel;
use App\modelos\recsensorial\catmovilfijoModel;
use App\modelos\reconocimientoergo\catergo_regimencontractualModel;
use App\modelos\reconocimientoergo\catergo_jornada;
use App\modelos\reconocimientoergo\catergo_turnoModel;
use App\modelos\reconocimientoergo\catergo_definicionesModel;
use App\modelos\reconocimientoergo\recursosPortadaRecoErgoModel;
use App\modelos\reconocimientoergo\catergo_introduccionModel;
use App\modelos\reconocimientoergo\recoergocategoriasModel;
use App\modelos\reconocimientoergo\recoergoareasModel;
use App\modelos\reconocimientoergo\definicionesinformeergoModel;
use App\modelos\reconocimientoergo\catergo_conclusionModel;
use App\modelos\reconocimientoergo\catergo_recomendacionesModel;
use App\modelos\reconocimientoergo\recomendacionesinformeergoModel;
use App\modelos\reconocimientoergo\versionesrecoergoModel;
use App\modelos\clientes\clientecontratoModel;
use App\modelos\reconocimientoergo\datosgeneralesinformeRecoModel;
use App\modelos\reconocimientoergo\recoergofichastecnicasModel;
use App\modelos\evaluacionfre\evaluacionfreModel;

use App\modelos\evaluacionfre\recursosPortadaFreErgoModel;
use App\modelos\evaluacionfre\datosgeneralesinformeFreModel;
use App\modelos\evaluacionfre\definicionesinformeFreModel;
use App\modelos\evaluacionfre\recomendacionesinformefreModel;

use App\modelos\evaluacionfre\angulosfreModel;
use App\modelos\evaluacionfre\versionesfrergoModel;


use App\modelos\clientes\clientepartidasModel;
use App\modelos\clientes\clienteModel;
///// CAT EPP

use App\modelos\eppcatalogo\catregionanatomicaModel;
use App\modelos\eppcatalogo\catclaveyeppModel;


class evaluacionfreController extends Controller
{
       public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('Superusuario,Administrador,Proveedor,Reconocimiento,Proyecto,Compras,Staff,Psicólogo,Ergónomo,CoordinadorPsicosocial,CoordinadorErgonómico,CoordinadorRN,CoordinadorRS,CoordinadorRM,CoordinadorHI,Reportes,ApoyoTecnico,Financiero,Cadista,Externo');
        // $this->middleware('roles:Superusuario,Administrador,Proyecto,Compras,Staff,Psicólogo,Ergónomo,CoordinadorPsicosocial,CoordinadorErgonómico,CoordinadorRN,CoordinadorRS,CoordinadorRM,CoordinadorHI,ApoyoTecnico,Reportes');

        // $this->middleware('asignacionUser')->only('store');
    }



    public function index()
    { //vista RECONOCIMIENTO SENSORIAL

        $catdepartamento = catdepartamentoModel::where('catdepartamento_activo', 1)->orderBy('catdepartamento_nombre', 'ASC')->get();
        $catmovilfijo = catmovilfijoModel::where('catmovilfijo_activo', 1)->get();
        $catregimen = catergo_regimencontractualModel::where('ACTIVO', 1)->get();
        $catjornada = catergo_jornada::where('ACTIVO', 1)->get();
        $caturno = catergo_turnoModel::where('ACTIVO', 1)->get();
        $catdefiniciones = catergo_definicionesModel::whereIn('USO_DEFINICIONES', ['Informe', 'Ambos'])
            ->orderBy('CONCEPTO_DEFINICION', 'ASC')
            ->get();

        $catintroduccion = catergo_introduccionModel::where('ACTIVO', 1)->get();
        $catconclusion = catergo_conclusionModel::where('ACTIVO', 1)->get();
        $catrecomendaciones = catergo_recomendacionesModel::whereIn('USO_RECOMENDACIONES', ['Informe'])->get();

        //// CAT EPP
        $catregionanatomica = catregionanatomicaModel::where('ACTIVO', 1)->get();
        $catclaveyepp = catclaveyeppModel::where('ACTIVO', 1)->get();

        return view('catalogos.ergo.evaluacionfre', compact('catdepartamento', 'catmovilfijo', 'catregimen', 'catjornada', 'caturno', 'catdefiniciones', 'catintroduccion', 'catconclusion', 'catrecomendaciones', 'catregionanatomica', 'catclaveyepp'));
    }


    public function Tablafichasevaluacionfre(Request $request)
    {
        try {

            $ergo = $request->get('ergoid');

            $areas = recoergoareasModel::pluck(
                'NOMBRE_AREA_ERGO',
                'ID_AREA_ERGO'
            )->toArray();

            $tabla = recoergofichastecnicasModel::select(
                'recoergo_fichastecnicas.*',
                'recoergocategorias.NOMBRE_CATEGORIA_ERGO as NOMBRE_CATEGORIA',
                'evaluacion_fre_ergo.ID_EVALUACION_FRE'
            )
                ->leftJoin(
                    'recoergocategorias',
                    'recoergo_fichastecnicas.CATEGORIA_ID_FICHA',
                    '=',
                    'recoergocategorias.ID_CATEGORIA_ERGO'
                )
                ->leftJoin(
                    'evaluacion_fre_ergo',
                    'evaluacion_fre_ergo.FICHA_ID',
                    '=',
                    'recoergo_fichastecnicas.ID_FICHAS_TECNICAS'
                )
                ->where('recoergo_fichastecnicas.RECO_ID', $ergo)
                ->orderBy('recoergo_fichastecnicas.ID_FICHAS_TECNICAS', 'asc')
                ->get();

            foreach ($tabla as $value) {

             
                $idsAreas = $value->CAT_AREAS_FICHA ?? [];

                if (is_string($idsAreas)) {
                    $idsAreas = json_decode($idsAreas, true) ?? [];
                }

                if (!is_array($idsAreas)) {
                    $idsAreas = [];
                }

                $listaAreas = [];

                foreach ($idsAreas as $idArea) {

                    if (isset($areas[$idArea])) {
                        $listaAreas[] = '<li>' . e($areas[$idArea]) . '</li>';
                    }
                }

                $value->NOMBRE_AREA = count($listaAreas)
                    ? '<ul class="mb-0 ps-3">' . implode('', $listaAreas) . '</ul>'
                    : '';

            
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '
                    <button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                        <i class="bi bi-eye"></i>
                    </button>';

                    $value->BTN_VISUALIZAR = '
                    <button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>';

                    $value->BTN_FICHA = '';
                } else {

                    $value->BTN_EDITAR = '
                    <button type="button" class="btn btn-warning btn-circle editar">
                        <i class="fa fa-eye"></i>
                    </button>';

                    $value->BTN_VISUALIZAR = '';

                    $value->BTN_FICHA = '
                    <button type="button" class="btn btn-info btn-circle iniciarfre">
                        <i class="fa fa-check-circle"></i>
                    </button>';
                }

                if ($value->ID_EVALUACION_FRE) {

                    $value->ESTATUS_FRE = '
                    <div class="text-center">
                        <span class="badge badge-pill badge-success" style="font-size:12px">
                            Iniciado
                        </span>
                    </div>';
                } else {

                    $value->ESTATUS_FRE = '
                    <div class="text-center">
                        <span class="badge badge-pill badge-danger" style="font-size:12px">
                            Sin iniciar
                        </span>
                    </div>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }
    public function obtenerEvaluacionFre(Request $request)
    {
        $evaluacion = evaluacionfreModel::where('FICHA_ID', $request->FICHA_ID)
            ->where('ACTIVO', 1)
            ->first();

        return response()->json($evaluacion);
    }



  


   public function cargarGraficaPregunta1(Request $request)
   {   
        try {

            $reco_id = $request->recsensorial;

            $registros = evaluacionfreModel::select(
                'CUELLO',
                'HOMBRO',
                'CODO',
                'MUNECA',
                'ESPALDA_ALTA',
                'ESPALDA_BAJA',
                'CADERAS_PIERNAS',
                'RODILLAS',
                'TOBILLOS_PIES',
                'CATEGORIA_ID_FRE'
            )
            ->where('RECO_ID', $reco_id)
            ->get();

            $total = $registros->count();

            if ($total == 0) {

                return response()->json([
                    'code' => 200,
                    'total' => 0,
                    'porcentajes' => [],
                    'tabla' => []
                ]);

            }

            $nombreAreas = [

                'CUELLO' => 'Cuello',
                'HOMBRO' => 'Hombro',
                'CODO' => 'Codo',
                'MUNECA' => 'Muñeca',
                'ESPALDA_ALTA' => 'Espalda alta (región dorsal)',
                'ESPALDA_BAJA' => 'Espalda baja (región lumbar)',
                'CADERAS_PIERNAS' => 'Una o ambas caderas / piernas',
                'RODILLAS' => 'Una o ambas rodillas',
                'TOBILLOS_PIES' => 'Uno o ambos tobillos / pies'

            ];

            $segmentos = [

                'CUELLO',
                'HOMBRO',
                'CODO',
                'MUNECA',
                'ESPALDA_ALTA',
                'ESPALDA_BAJA',
                'CADERAS_PIERNAS',
                'RODILLAS',
                'TOBILLOS_PIES'

            ];

            $contador = [];

            foreach ($segmentos as $segmento) {
                $contador[$segmento] = 0;
            }

            $categorias = [];

            foreach ($registros as $registro) {
                foreach ($segmentos as $segmento) {
                    if ($registro->$segmento == 1) {
                        $contador[$segmento]++;
                        if (!isset($categorias[$segmento])) {
                            $categorias[$segmento] = [];
                        }
                        $categorias[$segmento][] = $registro->CATEGORIA_ID_FRE;

                    }

                }

            }


            $porcentajes = [];

            foreach ($contador as $segmento => $cantidad) {
                $porcentajes[$segmento] = round(
                    ($cantidad / $total) * 100,
                    2
                );

            }

                $tabla = [];

                foreach ($categorias as $segmento => $listaCategorias) {

                    $conteoCategorias = array_count_values($listaCategorias);
                    foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {
                        $categoria = recoergocategoriasModel::find($categoria_id);
                        $tabla[] = [
                            'AREA' => $nombreAreas[$segmento],
                            'CATEGORIA' => $categoria
                                ? $categoria->NOMBRE_CATEGORIA_ERGO
                                : 'SIN CATEGORÍA',
                            'PORCENTAJE' => round(
                                ($cantidadCategoria / $total) * 100,
                                2
                            )
                        ];
                    }
                }

                return response()->json([

                    'code' => 200,
                    'total' => $total,
                    'porcentajes' => $porcentajes,
                    'tabla' => $tabla

                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine()

                ]);
            }
   }




    public function cargarGraficaPregunta2(Request $request)
    {
        try {

            $reco_id = $request->recsensorial;

            $registros = evaluacionfreModel::select(
                'CUELLO_12_MESES',
                'HOMBRO_12_MESES',
                'CODO_12_MESES',
                'MUNECA_12_MESES',
                'ESPALDA_ALTA_12_MESES',
                'ESPALDA_BAJA_12_MESES',
                'CADERAS_PIERNAS_12_MESES',
                'RODILLAS_12_MESES',
                'TOBILLOS_PIES_12_MESES',
                'CATEGORIA_ID_FRE'
            )
            ->where('RECO_ID', $reco_id)
            ->get();

            $total = $registros->count();

            if ($total == 0) {

                return response()->json([
                    'code' => 200,
                    'total' => 0,
                    'porcentajes' => [],
                    'tabla' => []
                ]);

            }

            $nombreAreas = [

                'CUELLO_12_MESES' => 'Cuello',
                'HOMBRO_12_MESES' => 'Hombro',
                'CODO_12_MESES' => 'Codo',
                'MUNECA_12_MESES' => 'Muñeca',
                'ESPALDA_ALTA_12_MESES' => 'Espalda alta (región dorsal)',
                'ESPALDA_BAJA_12_MESES' => 'Espalda baja (región lumbar)',
                'CADERAS_PIERNAS_12_MESES' => 'Una o ambas caderas / piernas',
                'RODILLAS_12_MESES' => 'Una o ambas rodillas',
                'TOBILLOS_PIES_12_MESES' => 'Uno o ambos tobillos / pies'

            ];

            $segmentos = [

                'CUELLO_12_MESES',
                'HOMBRO_12_MESES',
                'CODO_12_MESES',
                'MUNECA_12_MESES',
                'ESPALDA_ALTA_12_MESES',
                'ESPALDA_BAJA_12_MESES',
                'CADERAS_PIERNAS_12_MESES',
                'RODILLAS_12_MESES',
                'TOBILLOS_PIES_12_MESES'

            ];

            $contador = [];

            foreach ($segmentos as $segmento) {
                $contador[$segmento] = 0;
            }

            $categorias = [];

            foreach ($registros as $registro) {

                foreach ($segmentos as $segmento) {

                    if ($registro->$segmento == 1) {

                        $contador[$segmento]++;

                        if (!isset($categorias[$segmento])) {
                            $categorias[$segmento] = [];
                        }

                        $categorias[$segmento][] = $registro->CATEGORIA_ID_FRE;

                    }

                }

            }

            $porcentajes = [];

            foreach ($contador as $segmento => $cantidad) {

                $porcentajes[$segmento] = round(
                    ($cantidad / $total) * 100,
                    2
                );

            }

                $tabla = [];

                foreach ($categorias as $segmento => $listaCategorias) {

                    $conteoCategorias = array_count_values($listaCategorias);

                    foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {

                        $categoria = recoergocategoriasModel::find($categoria_id);

                        $tabla[] = [

                            'AREA' => $nombreAreas[$segmento],

                            'CATEGORIA' => $categoria
                                ? $categoria->NOMBRE_CATEGORIA_ERGO
                                : 'SIN CATEGORÍA',
                            'PORCENTAJE' => round(
                                ($cantidadCategoria / $total) * 100,
                                2
                            )

                        ];
                    }
                }

                return response()->json([
                    'code' => 200,
                    'total' => $total,
                    'porcentajes' => $porcentajes,
                    'tabla' => $tabla
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
    }



    public function cargarGraficaPregunta3(Request $request)
    {
        try {

            $reco_id = $request->recsensorial;

            $registros = evaluacionfreModel::select(
                'CUELLO_7_DIAS',
                'HOMBRO_7_DIAS',
                'CODO_7_DIAS',
                'MUNECA_7_DIAS',
                'ESPALDA_ALTA_7_DIAS',
                'ESPALDA_BAJA_7_DIAS',
                'CADERAS_PIERNAS_7_DIAS',
                'RODILLAS_7_DIAS',
                'TOBILLOS_PIES_7_DIAS',
                'CATEGORIA_ID_FRE'
            )
            ->where('RECO_ID', $reco_id)
            ->get();

            $total = $registros->count();

            if ($total == 0) {

                return response()->json([
                    'code' => 200,
                    'total' => 0,
                    'porcentajes' => [],
                    'tabla' => []
                ]);

            }

            $nombreAreas = [

                'CUELLO_7_DIAS' => 'Cuello',
                'HOMBRO_7_DIAS' => 'Hombro',
                'CODO_7_DIAS' => 'Codo',
                'MUNECA_7_DIAS' => 'Muñeca',
                'ESPALDA_ALTA_7_DIAS' => 'Espalda alta (región dorsal)',
                'ESPALDA_BAJA_7_DIAS' => 'Espalda baja (región lumbar)',
                'CADERAS_PIERNAS_7_DIAS' => 'Una o ambas caderas / piernas',
                'RODILLAS_7_DIAS' => 'Una o ambas rodillas',
                'TOBILLOS_PIES_7_DIAS' => 'Uno o ambos tobillos / pies'

            ];

            $segmentos = [

                'CUELLO_7_DIAS',
                'HOMBRO_7_DIAS',
                'CODO_7_DIAS',
                'MUNECA_7_DIAS',
                'ESPALDA_ALTA_7_DIAS',
                'ESPALDA_BAJA_7_DIAS',
                'CADERAS_PIERNAS_7_DIAS',
                'RODILLAS_7_DIAS',
                'TOBILLOS_PIES_7_DIAS'

            ];

            $contador = [];

            foreach ($segmentos as $segmento) {
                $contador[$segmento] = 0;
            }

            $categorias = [];

            foreach ($registros as $registro) {
                foreach ($segmentos as $segmento) {
                    if ($registro->$segmento == 1) {
                        $contador[$segmento]++;
                        if (!isset($categorias[$segmento])) {
                            $categorias[$segmento] = [];
                        }
                        $categorias[$segmento][] = $registro->CATEGORIA_ID_FRE;
                    }
                }
            }


            $porcentajes = [];
            foreach ($contador as $segmento => $cantidad) {
                $porcentajes[$segmento] = round(
                    ($cantidad / $total) * 100,
                    2
                );
            }

                $tabla = [];

                foreach ($categorias as $segmento => $listaCategorias) {

                    $conteoCategorias = array_count_values($listaCategorias);

                    foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {

                        $categoria = recoergocategoriasModel::find($categoria_id);

                        $tabla[] = [

                            'AREA' => $nombreAreas[$segmento],

                            'CATEGORIA' => $categoria
                                ? $categoria->NOMBRE_CATEGORIA_ERGO
                                : 'SIN CATEGORÍA',

                            'PORCENTAJE' => round(
                                ($cantidadCategoria / $total) * 100,
                                2
                            )

                        ];
                    }
                }

                return response()->json([

                    'code' => 200,
                    'total' => $total,
                    'porcentajes' => $porcentajes,
                    'tabla' => $tabla
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
    }



    public function cargarGraficaPregunta4(Request $request)
    {
        try {

            $reco_id = $request->recsensorial;

            $registros = evaluacionfreModel::select(

                'COLUMNA_LUMBAR_P1',
                'COLUMNA_LUMBAR_P2',
                'COLUMNA_LUMBAR_P3',
                'COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL',
                'COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO',
                'COLUMNA_LUMBAR_P7',
                'COLUMNA_LUMBAR_P8',
                'CATEGORIA_ID_FRE'

            )
            ->where('RECO_ID',$reco_id)
            ->get();

            $total = $registros->count();

            if($total==0){

                return response()->json([
                    'code'=>200,
                    'porcentaje'=>0,
                    'tabla'=>[]
                ]);

            }

            $contador = 0;

            $categorias = [];

            foreach($registros as $registro){

                $tieneDolor = (

                    $registro->COLUMNA_LUMBAR_P1 == 1 ||
                    $registro->COLUMNA_LUMBAR_P2 == 1 ||
                    $registro->COLUMNA_LUMBAR_P3 == 1 ||
                    $registro->COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL == 1 ||
                    $registro->COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO == 1 ||
                    $registro->COLUMNA_LUMBAR_P7 == 1 ||
                    $registro->COLUMNA_LUMBAR_P8 == 1

                );

                if($tieneDolor){

                    $contador++;

                    $categorias[] = $registro->CATEGORIA_ID_FRE;

                }

            }

        
            $porcentaje = round(
                ($contador/$total)*100,
                2
            );



                $tabla = [];

                $conteoCategorias = array_count_values($categorias);
                foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {
                    $categoria = recoergocategoriasModel::find($categoria_id);
                    $tabla[] = [
                        'CATEGORIA' => $categoria
                            ? $categoria->NOMBRE_CATEGORIA_ERGO
                            : 'SIN CATEGORÍA',
                        'PORCENTAJE' => round(
                            ($cantidadCategoria / $total) * 100,
                            2
                        )
                    ];
                }

                return response()->json([

                    'code' => 200,
                    'total' => $total,
                    'porcentaje' => $porcentaje,
                    'tabla' => $tabla
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
    }


    public function cargarGraficaPregunta5(Request $request)
    {
     try {

            $reco_id = $request->recsensorial;

            $registros = evaluacionfreModel::select(

                'CUELLO_P1',
                'CUELLO_P2',
                'CUELLO_P3',
                'CUELLO_P5_ACTIVIDAD_LABORAL',
                'CUELLO_P5_ACTIVIDAD_OCIO',
                'CUELLO_P7',
                'CUELLO_P8',
                'CATEGORIA_ID_FRE'

            )
            ->where('RECO_ID',$reco_id)
            ->get();

            $total = $registros->count();

            if($total==0){

                return response()->json([
                    'code'=>200,
                    'total'=>0,
                    'porcentaje'=>0,
                    'tabla'=>[]
                ]);

            }

            $contador = 0;

            $categorias = [];

            foreach($registros as $registro){

                $tieneProblema = (

                    $registro->CUELLO_P1 == 1 ||
                    $registro->CUELLO_P2 == 1 ||
                    $registro->CUELLO_P3 == 1 ||
                    $registro->CUELLO_P5_ACTIVIDAD_LABORAL == 1 ||
                    $registro->CUELLO_P5_ACTIVIDAD_OCIO == 1 ||
                    $registro->CUELLO_P7 == 1 ||
                    $registro->CUELLO_P8 == 1

                );

                if($tieneProblema){
                    $contador++;
                    $categorias[] = $registro->CATEGORIA_ID_FRE;

                }

            }

            $porcentaje = round(
                ($contador / $total) * 100,
                2
            );
        
                $tabla = [];
                $conteoCategorias = array_count_values($categorias);
                foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {
                    $categoria = recoergocategoriasModel::find($categoria_id);
                    $tabla[] = [
                        'CATEGORIA' => $categoria
                            ? $categoria->NOMBRE_CATEGORIA_ERGO
                            : 'SIN CATEGORÍA',
                        'PORCENTAJE' => round(
                            ($cantidadCategoria / $total) * 100,
                            2
                        )
                    ];
                }

                return response()->json([

                    'code' => 200,
                    'total' => $total,
                    'porcentaje' => $porcentaje,
                    'tabla' => $tabla
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine()
                ]);
            }
    }


    public function cargarGraficaPregunta6(Request $request)
    {
        try {

        $reco_id = $request->recsensorial;

        $registros = evaluacionfreModel::select(

            'HOMBRO_P1',
            'HOMBRO_P2',
            'HOMBRO_P3',
            'HOMBRO_P5_ACTIVIDAD_LABORAL',
            'HOMBRO_P5_ACTIVIDAD_OCIO',
            'HOMBRO_P7',
            'HOMBRO_P8',
            'CATEGORIA_ID_FRE'

        )
        ->where('RECO_ID',$reco_id)
        ->get();

        $total = $registros->count();

        if($total==0){

            return response()->json([
                'code'=>200,
                'total'=>0,
                'porcentaje'=>0,
                'tabla'=>[]
            ]);

        }

        $contador = 0;

        $categorias = [];

        foreach($registros as $registro){

            $tieneProblema = (

                $registro->HOMBRO_P1 == 1 ||
                $registro->HOMBRO_P2 == 1 ||
                $registro->HOMBRO_P3 == 1 ||
                $registro->HOMBRO_P5_ACTIVIDAD_LABORAL == 1 ||
                $registro->HOMBRO_P5_ACTIVIDAD_OCIO == 1 ||
                $registro->HOMBRO_P7 == 1 ||
                $registro->HOMBRO_P8 == 1

            );

            if($tieneProblema){

                $contador++;

                $categorias[] = $registro->CATEGORIA_ID_FRE;

            }

        }

        $porcentaje = round(
            ($contador / $total) * 100,
            2
        );

            $tabla = [];

            $conteoCategorias = array_count_values($categorias);
            foreach ($conteoCategorias as $categoria_id => $cantidadCategoria) {
                $categoria = recoergocategoriasModel::find($categoria_id);
                $tabla[] = [
                    'CATEGORIA' => $categoria
                        ? $categoria->NOMBRE_CATEGORIA_ERGO
                        : 'SIN CATEGORÍA',
                    'PORCENTAJE' => round(
                        ($cantidadCategoria / $total) * 100,
                        2
                    )

                ];
            }

            return response()->json([
                'code' => 200,
                'total' => $total,
                'porcentaje' => $porcentaje,
                'tabla' => $tabla

            ]);
        } catch (\Exception $e) {

            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'line' => $e->getLine()

            ]);
        }
    }




    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:


                    $camposArray = [
                        'CAT_METODOS_FRE',
                    ];

                    foreach ($camposArray as $campo) {
                        if (!isset($request[$campo]) || empty($request[$campo])) {
                            $request[$campo] = null;
                        }
                    }

                    if ($request->ID_EVALUACION_FRE == 0) {
                        DB::statement('ALTER TABLE evaluacion_fre_ergo AUTO_INCREMENT=1;');
                        $fre = evaluacionfreModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $fre = evaluacionfreModel::where('ID_EVALUACION_FRE', $request['ID_EVALUACION_FRE'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['fre'] = 'Desactivada';
                            } else {
                                $fre = evaluacionfreModel::where('ID_EVALUACION_FRE', $request['ID_EVALUACION_FRE'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['fre'] = 'Activada';
                            }
                        } else {
                            $fre = evaluacionfreModel::find($request->ID_EVALUACION_FRE);
                            $fre->update($request->all());
                            $response['code'] = 1;
                            $response['fre'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['fre']  = $fre;
                    return response()->json($response);
                    break;


                case 2:

                    if ($request->ID_ANGULOS_FRE == 0) {

                        DB::statement('ALTER TABLE angulos_fre_ergo AUTO_INCREMENT=1;');
                        $angulos = angulosfreModel::create($request->all());

                        $freid = $angulos->FRE_ID;
                        $registroId = $angulos->ID_ANGULOS_FRE;

                        // ================= FOTO =================


                    if ($request->hasFile('FOTO_ANGULO')) {

                        $foto = $request->file('FOTO_ANGULO');
                        $extension = strtolower($foto->getClientOriginalExtension());
                        $nombreArchivo = 'angulo_' . $registroId . '_' . time() . '.' . $extension;
                        $rutaFoto = "evaluacionfre_ergo/{$freid}/Ángulos/{$registroId}";
                        $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                        $angulos->FOTO_ANGULO = $rutaFotoCompleta;
                    }

                       

                        $angulos->save();
                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {
                                angulosfreModel::where('ID_ANGULOS_FRE', $request['ID_ANGULOS_FRE'])
                                    ->update(['ACTIVO' => 0]);

                                $response['code'] = 1;
                                $response['angulos'] = 'Desactivada';
                            } else {

                                angulosfreModel::where('ID_ANGULOS_FRE', $request['ID_ANGULOS_FRE'])
                                    ->update(['ACTIVO' => 1]);

                                $response['code'] = 1;
                                $response['angulos'] = 'Activada';
                            }
                        } else {

                            $angulos = angulosfreModel::find($request->ID_ANGULOS_FRE);
                            $angulos->update($request->all());

                            $freid = $angulos->FRE_ID;
                            $registroId = $angulos->ID_ANGULOS_FRE;



                            // ================= FOTO =================
                            if ($request->hasFile('FOTO_ANGULO')) {

                                $foto = $request->file('FOTO_ANGULO');
                                $extension = strtolower($foto->getClientOriginalExtension());
                                $nombreArchivo = 'angulo_' . $registroId . '_' . time() . '.' . $extension;
                                $rutaFoto = "evaluacionfre_ergo/{$freid}/Ángulos/{$registroId}";
                                $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                                $angulos->FOTO_ANGULO = $rutaFotoCompleta;
                            }


                            $angulos->save();

                            $response['code'] = 1;
                            $response['angulos'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code'] = 1;
                    $response['angulos'] = $angulos;
                    return response()->json($response);

                    break;




                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }



    // public function store(Request $request)
    // {
    //     try {
    //         switch (intval($request->api)) {
    //             case 1:
    //                 if ($request->ID_EVALUACION_FRE == 0) {
    //                     DB::statement('ALTER TABLE evaluacion_fre_ergo AUTO_INCREMENT=1;');
    //                     $fre = evaluacionfreModel::create($request->all());
    //                 } else {

    //                     if (isset($request->ELIMINAR)) {
    //                         if ($request->ELIMINAR == 1) {
    //                             $fre = evaluacionfreModel::where('ID_EVALUACION_FRE', $request['ID_EVALUACION_FRE'])->update(['ACTIVO' => 0]);
    //                             $response['code'] = 1;
    //                             $response['fre'] = 'Desactivada';
    //                         } else {
    //                             $fre = evaluacionfreModel::where('ID_EVALUACION_FRE', $request['ID_EVALUACION_FRE'])->update(['ACTIVO' => 1]);
    //                             $response['code'] = 1;
    //                             $response['fre'] = 'Activada';
    //                         }
    //                     } else {
    //                         $fre = evaluacionfreModel::find($request->ID_EVALUACION_FRE);
    //                         $fre->update($request->all());
    //                         $response['code'] = 1;
    //                         $response['fre'] = 'Actualizada';
    //                     }
    //                     return response()->json($response);
    //                 }
    //                 $response['code']  = 1;
    //                 $response['fre']  = $fre;
    //                 return response()->json($response);
    //                 break;
    //             default:
    //                 $response['code']  = 1;
    //                 $response['msj']  = 'Api no encontrada';
    //                 return response()->json($response);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json('Error al guardar ');
    //     }
    // }


    ////  ANGULOS

    public function tablangulosfre($fre_id)
    {
        try {

            $documentos = angulosfreModel::where('FRE_ID', $fre_id)
                ->where('ACTIVO', 1)
                ->get();

            $numero_registro = 0;

            foreach ($documentos  as $key => $value) {
                $numero_registro += 1;
                $value->numero_registro = $numero_registro;


                $value->FOTO_TABLA_DOCUMENTO = '<img src="/verfotoangulofre/' . $value->ID_ANGULOS_FRE . '" alt="" class="img-fluid" width="50" height="60">';


                // Botones
                if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador', 'Coordinador FRE'])) {
                    $value->accion_activa = 1;
                    $value->boton_editar = '<button type="button" class="btn btn-warning btn-circle"><i class="fa fa-pencil"></i></button>';
                    $value->boton_eliminar = '<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></button>';
                } else {
                    $value->accion_activa = 1;
                    $value->boton_editar = '<button type="button" class="btn btn-success btn-circle"><i class="fa fa-eye"></i></button>';
                    $value->boton_eliminar = '<button type="button" class="btn btn-secondary btn-circle"><i class="fa fa-ban"></i></button>';
                }
            }

            $listado['data'] = $documentos;
            return response()->json($listado);
        } catch (exception $e) {
            $listado['data'] = 0;
            return response()->json($listado);
        }
    }


    public function verfotoangulofre($fre_id)
    {
        $foto = angulosfreModel::findOrFail($fre_id);
        return Storage::response($foto->FOTO_ANGULO);
    }


    ///// INFORME



    public function obtenerDatosInformesFreErgo($ID)
    {
        try {

            $opciones_select = '<option value="">&nbsp;</option>';
            $html  = '<option value="">&nbsp;</option>';

            $info = DB::select('SELECT 
                                ID_FRE_INFORME,
                                RECO_ID,
                                AGENTE_ID,
                                NORMA_ID,
                                RUTA_IMAGEN_PORTADA,
                                OPCION_PORTADA1,
                                OPCION_PORTADA2,
                                OPCION_PORTADA3,
                                OPCION_PORTADA4,
                                OPCION_PORTADA5,
                                OPCION_PORTADA6,                                        
                                NIVEL1,
                                NIVEL2,
                                NIVEL3,
                                NIVEL4,
                                NIVEL5,
                                INFORME_MES,
                                INFORME_ANIO
                            FROM recursosPortadasFreErgo
                            WHERE RECO_ID = ?', [$ID]);


            $niveles = DB::select('

                SELECT 
                    "Instalación" AS ETIQUETA,
                    p.proyecto_clienteinstalacion AS OPCION,
                    0 NIVEL

                FROM reconocimientoergo re

                LEFT JOIN proyecto p 
                    ON p.proyecto_folio COLLATE utf8mb3_general_ci =
                    re.proyecto_folio COLLATE utf8mb3_general_ci

                WHERE re.id = ?

                UNION

                SELECT

                    IFNULL(ce.NOMBRE_ETIQUETA, "NO") AS ETIQUETA,

                    IFNULL(co.NOMBRE_OPCIONES, "NO") AS OPCION,

                    IFNULL(ep.NIVEL, 0) NIVEL

                FROM reconocimientoergo re

                LEFT JOIN proyecto p 
                    ON p.proyecto_folio COLLATE utf8mb3_general_ci =
                    re.proyecto_folio COLLATE utf8mb3_general_ci

                LEFT JOIN estructuraProyectos ep 
                    ON p.id = ep.PROYECTO_ID

                LEFT JOIN cat_etiquetas ce 
                    ON ep.ETIQUETA_ID = ce.ID_ETIQUETA

                LEFT JOIN catetiquetas_opciones co 
                    ON ep.OPCION_ID = co.ID_OPCIONES_ETIQUETAS

                WHERE re.id = ?

                UNION

                SELECT 
                    "Folio" AS ETIQUETA,

                    p.proyecto_folio AS OPCION,

                    0 NIVEL

                FROM reconocimientoergo re

                LEFT JOIN proyecto p 
                    ON p.proyecto_folio COLLATE utf8mb3_general_ci =
                    re.proyecto_folio COLLATE utf8mb3_general_ci

                WHERE re.id = ?

                UNION

                SELECT

                    "Razón social" AS ETIQUETA,

                    p.proyecto_clienterazonsocial AS OPCION,

                    0 NIVEL

                FROM reconocimientoergo re

                LEFT JOIN proyecto p 
                    ON p.proyecto_folio COLLATE utf8mb3_general_ci =
                    re.proyecto_folio COLLATE utf8mb3_general_ci

                WHERE re.id = ?

                UNION

                SELECT 

                    "Nombre comercial" AS ETIQUETA,

                    c.cliente_NombreComercial AS OPCION,

                    0 NIVEL

                FROM reconocimientoergo re

                LEFT JOIN proyecto p 
                    ON p.proyecto_folio COLLATE utf8mb3_general_ci =
                    re.proyecto_folio COLLATE utf8mb3_general_ci

                LEFT JOIN cliente c 
                    ON p.cliente_id = c.id

                WHERE re.id = ?

                ORDER BY NIVEL

            ', [$ID, $ID, $ID, $ID, $ID]);


            foreach ($niveles as $key => $value) {

                if ($value->ETIQUETA == 'NO') {

                    $opciones_select .= '<option value="" disabled>
                                        Proyecto vinculado sin Estructura organizacional para mostrar
                                     </option>';
                } else {

                    if ($value->NIVEL == 0) {

                        $opciones_select .= '<option value="' . $value->OPCION . '"  >
                                            ' . $value->ETIQUETA . ' : ' . $value->OPCION  . '
                                         </option>';
                    } else {

                        $opciones_select .= '<option value="' . $value->OPCION . '"  >
                                            ' . $value->ETIQUETA . ' : ' . $value->OPCION . '
                                            [ Nivel ' . $value->NIVEL . ']
                                         </option>';
                    }
                }
            }



            foreach ($niveles as $key => $value) {

                if ($value->ETIQUETA == 'Instalación' || $value->NIVEL != 0) {

                    $html .= '<option value="' . $value->OPCION . '">'
                        . $value->ETIQUETA . ' : ' . $value->OPCION;

                    if ($value->NIVEL != 0) {

                        $html .= ' [ Nivel ' . $value->NIVEL . ']';
                    }

                    $html .= '</option>';
                }
            }


            $dato["opciones"] = $opciones_select;
            $dato["checks"] = $html;


            if ($info) {

                $dato["data"] = $info;
                return response()->json($dato);
            } else {

                $dato["data"] = 'No se encontraron datos';
                return response()->json($dato);
            }
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500);
        }
    }



    public function guardarPortadaFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();


            $recurso = recursosPortadaFreErgoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$recurso) {
                $recurso = new recursosPortadaFreErgoModel();
                $recurso->RECO_ID = $request->RECO_ID;
                $recurso->save();
            }

            $recurso->NIVEL1 = $request->NIVEL1;
            $recurso->NIVEL2 = $request->NIVEL2;
            $recurso->NIVEL3 = $request->NIVEL3;
            $recurso->NIVEL4 = $request->NIVEL4;
            $recurso->NIVEL5 = $request->NIVEL5;

            $recurso->OPCION_PORTADA1 = $request->OPCION_PORTADA1;
            $recurso->OPCION_PORTADA2 = $request->OPCION_PORTADA2;
            $recurso->OPCION_PORTADA3 = $request->OPCION_PORTADA3;
            $recurso->OPCION_PORTADA4 = $request->OPCION_PORTADA4;
            $recurso->OPCION_PORTADA5 = $request->OPCION_PORTADA5;
            $recurso->OPCION_PORTADA6 = $request->OPCION_PORTADA6;

            $recurso->INFORME_MES = $request->INFORME_MES;
            $recurso->INFORME_ANIO = $request->INFORME_ANIO;


            if ($request->file('RUTA_IMAGEN_PORTADA')) {

                $extension = $request->file('RUTA_IMAGEN_PORTADA')->getClientOriginalExtension();


                $ruta = $request->file('RUTA_IMAGEN_PORTADA')->storeAs(
                    'evaluacionfre_ergo/' . $request->RECO_ID . '/foto_portada',
                    $request->RECO_ID . '.' . $extension
                );

                $recurso->RUTA_IMAGEN_PORTADA = $ruta;
            }

            $recurso->save();

            DB::commit();


            return response()->json([
                'msj' => 'Información guardada correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function mostrarportadafreergo($archivo_opcion, $reco_id,  $extension)
    {
        $recurso = recursosPortadaFreErgoModel::where(
            'RECO_ID',
            $reco_id
        )->firstOrFail();

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->RUTA_IMAGEN_PORTADA);
        } else {
            return Storage::download($recurso->RUTA_IMAGEN_PORTADA);
        }
    }

    //// DATOS GENERALES 


    public function obtenerDatosGeneralesInformeFre($RECO_ID)
    {
        try {

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $RECO_ID
            )->first();

            if ($dato) {
                return response()->json($dato);
            } else {
                return response()->json([
                    'msj' => 'No se encontraron datos'
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function guardarIntroduccionFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where('RECO_ID',$request->RECO_ID)->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INFORME_INTRODUCCION = $request->INFORME_INTRODUCCION;

            $dato->save();

            DB::commit();

            return response()->json([
                'msj' => 'Introducción guardada correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }



    public function guardarDefinicionesFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();


            definicionesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->delete();

            if ($request->DEFINICONES_INFORME) {

                foreach ($request->DEFINICONES_INFORME as $definicion) {
                    $dato = new definicionesinformeFreModel();
                    $dato->RECO_ID = $request->RECO_ID;
                    $dato->CATALOGO_DEFINICIONES_ID = $definicion;
                    $dato->save();
                }
            }
            DB::commit();


            return response()->json([
                'msj' => 'Definiciones guardadas correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerDefinicionesFreErgo($RECO_ID)
    {
        $datos = definicionesinformeFreModel::where(
            'RECO_ID',
            $RECO_ID
        )->get();
        return response()->json($datos);
    }

    public function guardarObjetivoGeneralFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INFORME_OBJETIVOGENERALES = $request->INFORME_OBJETIVOGENERALES;
            $dato->save();
            DB::commit();


            return response()->json([
                'msj' => 'Objetivo general guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarObjetivoEspecificoFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();


            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INFORME_OBJETIVOSESPECIFICOS = $request->INFORME_OBJETIVOSESPECIFICOS;
            $dato->save();

            DB::commit();

            return response()->json([
                'msj' => 'Objetivos específicos guardados correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarReconocimientoFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INFORME_RECONOCIMIENTO = $request->INFORME_RECONOCIMIENTO;
            $dato->save();
            DB::commit();


            return response()->json([
                'msj' => 'Objetivo general guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarProcesoInstalacionFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
                $dato->save();
            }

            $dato->INFORME_PROCESOINSTALACION = $request->INFORME_PROCESOINSTALACION;
            $dato->INFORME_ACTIVIDADPRINCIPAL = $request->INFORME_ACTIVIDADPRINCIPAL;
            $dato->save();

            DB::commit();

            return response()->json([
                'msj' => 'Proceso de instalación guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarCicloFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
                $dato->save();
            }

            $dato->INFORME_CICLOS = $request->INFORME_CICLOS;
            $dato->save();

            DB::commit();

            return response()->json([
                'msj' => 'Proceso de instalación guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function TablaActividadesFre(Request $request)
    {
        $this->validate($request, [
            'ergoid' => 'required|integer|min:1',
        ]);

        try {
            $evaluaciones = DB::table('evaluacion_fre_ergo as evaluacion')
                ->leftJoin(
                    'recoergocategorias as categoria',
                    'categoria.ID_CATEGORIA_ERGO',
                    '=',
                    'evaluacion.CATEGORIA_ID_FRE'
                )
                ->leftJoin(
                    'recoergo_fichastecnicas as ficha',
                    'ficha.ID_FICHAS_TECNICAS',
                    '=',
                    'evaluacion.FICHA_ID'
                )
                ->where('evaluacion.RECO_ID', $request->input('ergoid'))
                ->select(
                    'evaluacion.ID_EVALUACION_FRE',
                    'evaluacion.JSON_ACTIVIDADES_FRE',
                    'categoria.NOMBRE_CATEGORIA_ERGO',
                    'ficha.TURNO_EMPLEADO_FICHA'
                )
                ->orderBy('evaluacion.ID_EVALUACION_FRE', 'asc')
                ->get();

            $catalogoTurnos = DB::table('catergo_turno')
                ->pluck('NOMBRE_TURNO', 'ID_TURNO')
                ->all();

            $datos = [];

            foreach ($evaluaciones as $evaluacion) {

                $idsTurnos = json_decode(
                    $evaluacion->TURNO_EMPLEADO_FICHA ?: '[]',
                    true
                );

                if (!is_array($idsTurnos)) {
                    $idsTurnos = [];
                }

                $nombresTurnos = [];

                foreach ($idsTurnos as $idTurno) {
                    if (is_scalar($idTurno) && isset($catalogoTurnos[$idTurno])) 
                    {
                        $nombresTurnos[] = $catalogoTurnos[$idTurno];
                    }
                }

                $turnos = !empty($nombresTurnos) ? implode(', ', array_unique($nombresTurnos)): '-';
                $actividades = json_decode($evaluacion->JSON_ACTIVIDADES_FRE ?: '[]',true);

                if (!is_array($actividades) || empty($actividades)) {
                    $actividades = [
                        [
                            'nombre' => '-',
                            'tareas' => [],
                        ],
                    ];
                }

                foreach ($actividades as $actividad) {
                    if (!is_array($actividad)) {
                        continue;
                    }

                    $tareas = isset($actividad['tareas']) && is_array($actividad['tareas']) ? $actividad['tareas'] : [];

                    if (empty($tareas)) {
                        $tareas = [[]];
                    }

                    foreach ($tareas as $tarea) {
                        if (!is_array($tarea)) {
                            continue;
                        }

                        $datos[] = [
                            'ID_EVALUACION_FRE' => $evaluacion->ID_EVALUACION_FRE,
                            'CATEGORIA' => $evaluacion->NOMBRE_CATEGORIA_ERGO ?: '-',
                            'TURNO' => $turnos,
                            'ACTIVIDAD' => $actividad['nombre'] ?? '-',
                            'TAREA' => $tarea['nombre'] ?? '-',
                            'DURACION' => $tarea['duracion'] ?? '-',
                            'FRECUENCIA' => $tarea['frecuencia'] ?? '-',
                            'NUMERO_VECES' => $tarea['numero_veces'] ?? '-',
                        ];
                    }
                }
            }

            return response()->json([
                'data' => $datos,
            ]);
        } catch (\Exception $e) {

            \Log::error('Error al consultar las actividades FRE', [
                'RECO_ID' => $request->input('ergoid'),
                'exception' => $e,
            ]);

            return response()->json([
                'data' => [],
                'msj' => 'No fue posible consultar las actividades FRE.',
            ], 500);
        }
    }

    public function TablaImcFre(Request $request)
    {
        $this->validate($request, [
            'ergoid' => 'required|integer|min:1',
        ]);

        try {
            $evaluaciones = DB::table('evaluacion_fre_ergo as evaluacion')
                ->leftJoin(
                    'recoergo_fichastecnicas as ficha',
                    'ficha.ID_FICHAS_TECNICAS',
                    '=',
                    'evaluacion.FICHA_ID'
                )
                ->leftJoin(
                    'recoergocategorias as categoria',
                    'categoria.ID_CATEGORIA_ERGO',
                    '=',
                    'ficha.CATEGORIA_ID_FICHA'
                )
                ->where('evaluacion.RECO_ID', $request->input('ergoid'))
                ->select(
                    'evaluacion.ID_EVALUACION_FRE',
                    'evaluacion.FICHA_ID',
                    'evaluacion.NOMBRE_EMPLEADO_FRE',
                    'evaluacion.PESO_FRE',
                    'evaluacion.TALLA_FRE',
                    'ficha.CAT_AREAS_FICHA',
                    'categoria.NOMBRE_CATEGORIA_ERGO'
                )
                ->orderBy('evaluacion.ID_EVALUACION_FRE', 'asc')
                ->get();

            $catalogoAreas = DB::table('recoergoareas')
                ->pluck('NOMBRE_AREA_ERGO', 'ID_AREA_ERGO')
                ->all();

            $datos = [];

            foreach ($evaluaciones as $indice => $evaluacion) {

                $idsAreas = json_decode(
                    $evaluacion->CAT_AREAS_FICHA ?: '[]',
                    true
                );

                if (!is_array($idsAreas)) {
                    $idsAreas = [];
                }

                $nombresAreas = [];

                foreach ($idsAreas as $idArea) {
                    if (
                        is_scalar($idArea) &&
                        isset($catalogoAreas[$idArea])
                    ) {
                        $nombresAreas[] = $catalogoAreas[$idArea];
                    }
                }

                $areas = !empty($nombresAreas)
                    ? implode(', ', array_unique($nombresAreas))
                    : '-';

                $peso = is_numeric($evaluacion->PESO_FRE)
                    ? (float) $evaluacion->PESO_FRE
                    : null;

                $estaturaCm = is_numeric($evaluacion->TALLA_FRE)
                    ? (float) $evaluacion->TALLA_FRE
                    : null;

                $imc = null;
                $interpretacion = 'Sin datos válidos';

                if (
                    $peso !== null &&
                    $estaturaCm !== null &&
                    $peso > 0 &&
                    $estaturaCm > 0
                ) {
                    $estaturaMetros = $estaturaCm / 100;

                    $imc = $peso / ($estaturaMetros * $estaturaMetros);

                    if ($imc < 18.5) {
                        $interpretacion = 'Peso bajo';
                    } elseif ($imc < 25) {
                        $interpretacion = 'Ideal';
                    } elseif ($imc < 30) {
                        $interpretacion = 'Sobrepeso';
                    } elseif ($imc < 35) {
                        $interpretacion = 'Obesidad';
                    } elseif ($imc < 40) {
                        $interpretacion = 'Obesidad severa';
                    } else {
                        $interpretacion = 'Obesidad mórbida';
                    }
                }

                $datos[] = [
                    'NUMERO' => $indice + 1,
                    'ID_EVALUACION_FRE' => $evaluacion->ID_EVALUACION_FRE,
                    'FICHA_ID' => $evaluacion->FICHA_ID,
                    'CATEGORIA' => $evaluacion->NOMBRE_CATEGORIA_ERGO ?: '-',

                    // NUEVO CAMPO: NOMBRE DEL EMPLEADO
                    'EMPLEADO' => $evaluacion->NOMBRE_EMPLEADO_FRE ?: '-',

                    'AREA' => $areas,
                    'ESTATURA' => $estaturaCm ?? '-',
                    'PESO' => $peso ?? '-',
                    'IMC' => $imc !== null
                        ? number_format($imc, 2, '.', '')
                        : '-',
                    'INTERPRETACION' => $interpretacion,
                ];
            }

            return response()->json([
                'data' => $datos,
            ]);

        } catch (\Exception $e) {

            \Log::error('Error al consultar la tabla de IMC FRE', [
                'RECO_ID' => $request->input('ergoid'),
                'exception' => $e,
            ]);

            return response()->json([
                'data' => [],
                'msj' => 'No fue posible consultar la tabla de IMC FRE.',
            ], 500);
        }
    }

    public function guardarAntopometricasFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INFORME_ANTROPOMETRICAS = $request->INFORME_ANTROPOMETRICAS;
            $dato->save();
            DB::commit();


            return response()->json([
                'msj' => 'Objetivo general guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function guardarMusculoFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->OBSERVACIONES_ESQUELETICAS1 = $request->OBSERVACIONES_ESQUELETICAS1;
            $dato->OBSERVACIONES_ESQUELETICAS2 = $request->OBSERVACIONES_ESQUELETICAS2;
            $dato->OBSERVACIONES_ESQUELETICAS3 = $request->OBSERVACIONES_ESQUELETICAS3;
            $dato->OBSERVACIONES_ESQUELETICAS4 = $request->OBSERVACIONES_ESQUELETICAS4;
            $dato->OBSERVACIONES_ESQUELETICAS5 = $request->OBSERVACIONES_ESQUELETICAS5;
            $dato->OBSERVACIONES_ESQUELETICAS6 = $request->OBSERVACIONES_ESQUELETICAS6;


            $dato->save();
            DB::commit();


            return response()->json([
                'msj' => 'Objetivo general guardado correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function tablaReporteTrabajadoresErgo(Request $request)
    {
        $recoId = $request->ergoid;

        $categorias = recoergocategoriasModel::where('RECO_ID', $recoId)
            ->where('ACTIVO', 1)
            ->get();

        $fichas = recoergofichastecnicasModel::where('RECO_ID', $recoId)
            ->get();

        $areasAgrupadas = [];

        foreach ($categorias as $categoria) {

            if (
                empty($categoria->CATEGORIA_AREAS_ID) ||
                !is_array($categoria->CATEGORIA_AREAS_ID)
            ) {
                continue;
            }

            foreach ($categoria->CATEGORIA_AREAS_ID as $areaId) {

                $area = recoergoareasModel::find($areaId);

                if (!$area) {
                    continue;
                }

                if (!isset($areasAgrupadas[$areaId])) {
                    $areasAgrupadas[$areaId] = [
                        'AREA' => trim($area->NOMBRE_AREA_ERGO),
                        'CATEGORIAS' => [],
                        'PUESTOS_AREA' => []
                    ];
                }

                $categoriaId = $categoria->ID_CATEGORIA_ERGO;

                $areasAgrupadas[$areaId]['CATEGORIAS'][$categoriaId] = [
                    'NOMBRE' => $categoria->NOMBRE_CATEGORIA_ERGO,
                    'PUESTOS' => []
                ];

                foreach ($fichas as $ficha) {

                    if ((string) $ficha->CATEGORIA_ID_FICHA !== (string) $categoriaId || !is_array($ficha->CAT_AREAS_FICHA) || !in_array((string) $areaId, array_map('strval', $ficha->CAT_AREAS_FICHA)))
                    {
                        continue;
                    }

                    $puestos = $ficha->PE_EVALUADAS;

                    if (is_string($puestos)) {
                        $puestos = [$puestos];
                    }

                    if (!is_array($puestos)) {
                        continue;
                    }

                    foreach ($puestos as $puesto) {

                        $puesto = trim((string) $puesto);

                        if ($puesto === '') {
                            continue;
                        }

                        $areasAgrupadas[$areaId]['CATEGORIAS'][$categoriaId]['PUESTOS'][] = $puesto;

                        $areasAgrupadas[$areaId]['PUESTOS_AREA'][] = $puesto;
                    }
                }
            }
        }

        $data = [];
        $numero = 1;

        foreach ($areasAgrupadas as $area) {

            ksort($area['CATEGORIAS']);

            $puestosUnicosArea = array_values(array_unique($area['PUESTOS_AREA']));
            $totalTrabajadoresArea = count($puestosUnicosArea);
            $primeraCategoria = true;

            foreach ($area['CATEGORIAS'] as $categoria) {

                $obj = new \stdClass();

                $obj->NUMERO = $numero++;
                $obj->AREA = $area['AREA'];
                $obj->CATEGORIA = $categoria['NOMBRE'];

                $puestosCategoria = array_values(
                    array_unique($categoria['PUESTOS'])
                );

                sort($puestosCategoria);

                $obj->PUESTOS_EVALUADOS = count($puestosCategoria) ? '<ul class="mb-0 ps-3"><li>' .implode('</li><li>', $puestosCategoria) .'</li></ul>': '-';


                $obj->TRABAJADORES_EVALUADOS = $primeraCategoria ? $totalTrabajadoresArea : '';

                $primeraCategoria = false;

                $data[] = $obj;
            }
        }

        usort($data, function ($a, $b) {

            if ($a->AREA === $b->AREA) {
                return strcmp($a->CATEGORIA, $b->CATEGORIA);
            }

            return strcmp($a->AREA, $b->AREA);
        });

        return response()->json([
            'data' => $data
        ]);
    }



    public function guardarConclusionFreErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
                $dato->save();
            }

            $dato->SELECT_CONCLUSION = $request->SELECT_CONCLUSION;
            $dato->INFORME_CONCLUSION = $request->INFORME_CONCLUSION;
            $dato->save();
            DB::commit();
            return response()->json([
                'msj' => 'Conclusión guardada correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function guardarRecomendacionesInformeFreErgo(Request $request)
     {

        try {

            DB::beginTransaction();

            recomendacionesinformefreModel::where('RECO_ID',$request->RECO_ID)->delete();

            if ($request->DESCRIPCION_RECOMENDACIONES) {

                foreach ($request->DESCRIPCION_RECOMENDACIONES as $recomendacion) 
                {
                    $dato = new recomendacionesinformefreModel();
                    $dato->RECO_ID = $request->RECO_ID;
                    $dato->CATALOGO_RECOMENDACIONES_ID = $recomendacion;
                    $dato->save();
                }
            }

            DB::commit();

            return response()->json([
                'msj' =>
                'Recomendaciones guardadas correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' =>
                'Error: ' . $e->getMessage()
            ], 500);
        }
    }



    public function obtenerRecomendacionesInformeFreErgo($RECO_ID)
    {
        $datos = recomendacionesinformefreModel::where('RECO_ID',$RECO_ID)->get();
        return response()->json($datos);
    }




    public function guardarResponsablesInformeRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeFreModel::where('RECO_ID',$request->RECO_ID)->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeFreModel();
                $dato->RECO_ID = $request->RECO_ID;
                $dato->save();
            }

            $dato->INFORME_RESPONSABLE1 = $request->INFORME_RESPONSABLE1;
            $dato->INFORME_RESPONSABLE1CARGO = $request->INFORME_RESPONSABLE1CARGO;
            $dato->INFORME_RESPONSABLE2 = $request->INFORME_RESPONSABLE2;
            $dato->INFORME_RESPONSABLE2CARGO = $request->INFORME_RESPONSABLE2CARGO;

            if ($request->file('INFORME_RESPONSABLE1DOCUMENTO')) {

                $extension = $request->file('INFORME_RESPONSABLE1DOCUMENTO')->getClientOriginalExtension();
                $ruta = $request->file(
                    'INFORME_RESPONSABLE1DOCUMENTO'
                )->storeAs(
                    'evaluacionfre_ergo/' . $request->RECO_ID . '/responsables_informe',
                    'responsable1.' . $extension

                );

                $dato->INFORME_RESPONSABLE1DOCUMENTO = $ruta;
            }

            if ($request->file('INFORME_RESPONSABLE2DOCUMENTO')) {

                $extension = $request->file('INFORME_RESPONSABLE2DOCUMENTO')->getClientOriginalExtension();
                $ruta = $request->file(
                    'INFORME_RESPONSABLE2DOCUMENTO'
                )->storeAs(
                    'evaluacionfre_ergo/' . $request->RECO_ID . '/responsables_informe',
                    'responsable2.' . $extension
                );
                $dato->INFORME_RESPONSABLE2DOCUMENTO = $ruta;
            }

            $dato->save();
            DB::commit();

            return response()->json([
                'msj' =>
                'Responsables guardados correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' =>
                'Error: ' . $e->getMessage()
            ], 500);
        }
    }



    public function mostrarresponsable1freergo($archivo_opcion, $reco_id, $extension)
    {

        $recurso = datosgeneralesinformeFreModel::where('RECO_ID',$reco_id)->firstOrFail();

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->INFORME_RESPONSABLE1DOCUMENTO);
        } else {
            return Storage::download($recurso->INFORME_RESPONSABLE1DOCUMENTO);
        }
    }



    public function mostrarresponsable2freergo($archivo_opcion, $reco_id, $extension)
    {

        $recurso = datosgeneralesinformeFreModel::where('RECO_ID',$reco_id)->firstOrFail();
        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->INFORME_RESPONSABLE2DOCUMENTO);
        } else {
            return Storage::download($recurso->INFORME_RESPONSABLE2DOCUMENTO);
        }
    }

    /// METODOS 


    public function ObtenerMetodosFre(Request $request)
    {
        $this->validate($request, [
            'ergoid' => 'required|integer|min:1',
        ]);

        try {

            $evaluaciones = DB::table('evaluacion_fre_ergo')
                ->where('RECO_ID', $request->input('ergoid'))
                ->select('CAT_METODOS_FRE')
                ->get();

            $catalogoMetodos = [

                '1' => [
                    'NOMBRE' => 'Método OWAS',
                    'NOMBRE_INGLES' => '(Ovako Working Posture Analysing System)',
                    'NOMBRE_ESPANOL' => 'Sistema de análisis de posturas de trabajo Ovako',
                    'DESCRIPCION' => 'Osmos Karhu y Björn Trappe, quienes trabajaron en la industria siderúrgica durante la década de los 70, desarrollaron un método para evaluar la postura durante el trabajo. El método se denomina OWAS (”Ovako Working Posture Analysing System”).

El método OWAS permite valorar las posturas a nivel de espalda, brazos y piernas de un trabajador y la carga que este manipula durante la postura analizada. A cada postura se le asigna un código el cual conlleva a una valoración del riesgo postural, dando consigo una categoría del riesgo de dicha postura adoptada (en este sentido se tienen cuatro niveles de riesgo para cada postura). Luego se valora el riesgo para cada parte del cuerpo al que se refiere el método (espalda, brazos y piernas), examinando las posturas tomadas, la categoría del riesgo de cada parte del cuerpo dentro de una frecuencia de realización de las mismas. Para finalmente emitir una calificación de la postura más crítica durante un periodo observacional de 20 a 40 minutos de observación con sus respectivas frecuencias para finalmente establecer acciones correctivas del puesto de trabajo analizado.'
                ],

                '2' => [
                    'NOMBRE' => 'Método ROSA',
                    'NOMBRE_INGLES' => '(Rapid Office Strain Assessment)',
                    'NOMBRE_ESPANOL' => 'Evaluación rápida del esfuerzo en oficinas',
                    'DESCRIPCION' => 'El método ROSA permite valorar de forma rápida el nivel de riesgo de puestos de trabajo con un componente administrativo, donde la persona interactúa con 5 elementos propios de su labor, tales como: silla, pantalla, ratón, teclado y teléfono. La base principal del método es la observación de la postura del trabajador frente a su computadora, donde el profesional que aplica el método asigna una valoración numérica a través de un conjunto de tablas y de puntuaciones parciales con el objetivo de indicar el nivel de riesgo y de intervención, la cual indica la necesidad de realizar cambios en el puesto de trabajo priorizando la intervención puntual en algún aspecto ergonómico en aquellos donde exista una calificación de 5 o superior.'
                ],

                '3' => [
                    'NOMBRE' => 'Método RULA',
                    'NOMBRE_INGLES' => '(Rapid Upper Limb Assessment)',
                    'NOMBRE_ESPANOL' => 'Evaluación rápida de las extremidades superiores',
                    'DESCRIPCION' => 'El método RULA tiene como objetivo evaluar la exposición de los trabajadores a factores de riesgo que pueden causar trastornos músculo esqueléticos en las extremidades superiores, derivado de las posturas adoptadas, la repetitividad de los movimientos, la fuerza aplicada o si la actividad es de naturaleza estática.

Para la correcta aplicación del método se debe realizar la observación directa de la actividad del trabajador durante varios ciclos de trabajo, posteriormente se seleccionan las tareas y posturas más significativas, ya sea por su duración o por presentar una mayor carga postural. El método debe ser aplicado al lado derecho y al lado izquierdo del cuerpo por separado, ya que tiene en cuenta las posturas adoptadas por las extremidades superiores, cuello, espalda y piernas. Al final, determina 4 niveles de acción relacionados con los valores que se van obteniendo de la calificación de cada aspecto evaluado.

Nota: el profesional que evalúa elige el lado del cuerpo que está sometido a mayor carga postural.'
                ],

            ];

            // Recopilar los métodos de todos los registros
            $metodosEncontrados = [];

            foreach ($evaluaciones as $evaluacion) {

                if (empty($evaluacion->CAT_METODOS_FRE)) {
                    continue;
                }

                $metodos = json_decode(
                    $evaluacion->CAT_METODOS_FRE,
                    true
                );

                if (!is_array($metodos)) {
                    continue;
                }

                foreach ($metodos as $metodoId) {

                    $metodoId = (string) $metodoId;

                    if (
                        isset($catalogoMetodos[$metodoId]) &&
                        !isset($metodosEncontrados[$metodoId])
                    ) {
                        $metodosEncontrados[$metodoId] =
                            $catalogoMetodos[$metodoId];

                        $metodosEncontrados[$metodoId]['ID'] = $metodoId;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => array_values($metodosEncontrados),
            ]);
        } catch (\Exception $e) {

            \Log::error('Error al consultar las metodologías FRE', [
                'RECO_ID' => $request->input('ergoid'),
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'data' => [],
                'msj' => 'No fue posible consultar las metodologías FRE.',
            ], 500);
        }
    }

    /// DESCARGAR FREE




    public function validarEdicionFreErgo($reco_id)
    {

        $revision =
            versionesfrergoModel::where(
                'RECO_ID',
                $reco_id
            )
            ->orderByDesc('NUMERO_REVISION')
            ->first();


        if (!$revision) {

            return response()->json([
                'permite_guardar' => 1,
                'finalizado' => 0,
                'cancelado' => 0
            ]);
        }

        if (
            $revision->FINALIZADO == 1 &&
            $revision->CANCELADO == 0
        ) {
            return response()->json([
                'permite_guardar' => 0,
                'finalizado' => 1,
                'cancelado' => 0
            ]);
        }


        if ($revision->CANCELADO == 1) {
            return response()->json([
                'permite_guardar' => 1,
                'finalizado' => 0,
                'cancelado' => 1
            ]);
        }

        return response()->json([
            'permite_guardar' => 1,
            'finalizado' => 0,
            'cancelado' => 0
        ]);
    }

    public function crearRevisionFreErgo(Request $request)
    {

        try {

            DB::beginTransaction();


            $ultima =
                versionesfrergoModel::where(
                    'RECO_ID',
                    $request->RECO_ID
                )
                ->orderByDesc('NUMERO_REVISION')
                ->first();

            if (
                $ultima &&
                $ultima->FINALIZADO == 1 &&
                $ultima->CANCELADO == 0
            ) {

                return response()->json([

                    'msj' =>
                    'La revisión ya fue finalizada'

                ], 500);
            }

            $numero = $ultima ? $ultima->NUMERO_REVISION + 1 : 0;
            $rutaDocumento = 'pendiente.docx';
            $revision = new versionesfrergoModel();
            $revision->RECO_ID = $request->RECO_ID;
            $revision->NUMERO_REVISION = $numero;
            $revision->FINALIZADO = 1;
            $revision->FINALIZADO_POR = Auth::user()->id;
            $revision->FECHA_FINALIZADO = now();
            $revision->RUTA_DOCUMENTO = $rutaDocumento;
            $revision->save();
            DB::commit();

            return response()->json([

                'msj' =>
                'Revisión generada correctamente'

            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([

                'msj' =>
                'Error: ' . $e->getMessage()

            ], 500);
        }
    }

    public function cancelarRevisionFreErgo(Request $request)
    {

        try {

            DB::beginTransaction();

            $revision = versionesfrergoModel::findOrFail($request->ID_VERSION_RECO_ERGO);
            $revision->CANCELADO = 1;
            $revision->CANCELADO_POR = Auth::user()->id;
            $revision->FECHA_CANCELADO = now();
            $revision->MOTIVO_CANCELACION = $request->MOTIVO_CANCELACION;
            $revision->save();
            DB::commit();

            return response()->json([
                'msj' =>
                'Revisión cancelada correctamente'

            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([

                'msj' =>
                'Error: ' . $e->getMessage()

            ], 500);
        }
    }


    public function tablaVersionesFreErgo($reco_id)
    {

        $datos = DB::select("

            SELECT
            vr.*,
            CONCAT(
                ef.empleado_nombre,
                ' ',
                ef.empleado_apellidopaterno
            ) AS FINALIZADO_NOMBRE,
            CONCAT(
                ec.empleado_nombre,
                ' ',
                ec.empleado_apellidopaterno
            ) AS CANCELADO_NOMBRE
                FROM versionesfreergo vr
                LEFT JOIN usuario uf
                    ON uf.id = vr.FINALIZADO_POR
                LEFT JOIN empleado ef
                    ON ef.id = uf.empleado_id
                LEFT JOIN usuario uc
                    ON uc.id = vr.CANCELADO_POR
                LEFT JOIN empleado ec
                    ON ec.id = uc.empleado_id
                WHERE vr.RECO_ID = ?
                ORDER BY vr.NUMERO_REVISION DESC

            ", [$reco_id]);



        foreach ($datos as $key => $value) {

            if ($value->CANCELADO == 1) {
                $value->ESTADO =
                    '<span class="badge badge-danger">Cancelado</span>';
            } else {
                $value->ESTADO =
                    '<span class="badge badge-success">Finalizado</span>';
            }


            $checked =
                ($value->CANCELADO == 1)
                ? 'checked'
                : '';

            $value->CHECKBOX_CANCELADO = '
                    <div class="switch">
                        <label>
                            <input type="checkbox" class="checkbox_cancelado_revision" ' . $checked . ' onchange="cancelarRevisionRecoErgo(' . $value->ID_VERSION_RECO_ERGO . ',this)">
                            <span class="lever switch-col-red"></span>
                        </label>
                    </div>';

            $value->BOTON_DESCARGAR = '
                    <button type="button" class="btn btn-success btn-circle" data-toggle="tooltip" title="Descargar informe" onclick="descargarRevisionFreErgo(' . $value->RECO_ID . ')">
                    <i class="fa fa-download"></i></button>';
        }

        return response()->json([
            'data' => $datos
        ]);
    }




    public function descargarRevisionFreErgo(Request $request, $RECO_ID)
    {


        try {

            $reco = reconocimientoergoModel::findOrFail($RECO_ID);
            $proyecto = proyectoModel::where('reconocimiento_ergo_id', $RECO_ID)->first();
            $contrato = clientecontratoModel::find($proyecto->contrato_id);

            $cliente = clienteModel::findOrFail($reco->cliente_id);

            $recursos = recursosPortadaRecoErgoModel::where('RECO_ID', $RECO_ID)->get();
            $rutaPlantilla = storage_path('app/plantillas_reportes/plantilla_ergo/Plantilla_informe_ergonomia_fre.docx');
            $plantillaword = new TemplateProcessor($rutaPlantilla);


            $numeroContrato = $contrato->NUMERO_CONTRATO ?? 'No cargado';
            // $plantillaword->setValue('proyecto_portada', 'Evaluación del Factor de Riesgo Ergonómico ' . $numeroContrato);
            $plantillaword->setValue('folio_portada', $reco->proyecto_folio ?? 'No cargado');
            $plantillaword->setValue('razon_social_portada', $proyecto->proyecto_clienterazonsocial ?? 'No cargado');


            $mes = $recursos[0]->INFORME_MES ?? 'No cargado';
            $anio = $recursos[0]->INFORME_ANIO ?? 'No cargado';
            $direccion = $reco->direccion ?? 'No cargado';
            $plantillaword->setValue('lugar_fecha_portada', $direccion . ', ' . $mes . ' del ' . $anio);


            if (isset($recursos[0]) && $recursos[0]->RUTA_IMAGEN_PORTADA) {
                if (
                    file_exists(
                        storage_path('app/' . $recursos[0]->RUTA_IMAGEN_PORTADA)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'foto_portada',
                        array(
                            'path' => storage_path('app/' . $recursos[0]->RUTA_IMAGEN_PORTADA),
                            'width' => 969,
                            'height' => 689,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )

                    );
                } else {
                    $plantillaword->setValue('foto_portada', 'LA IMAGEN NO HA SIDO ENCONTRADA');
                }
            } else {
                $plantillaword->setValue('foto_portada', 'LA IMAGEN DE LA PORTADA NO HA SIDO CARGADA');
            }


            if ($contrato && $contrato->CONTRATO_PLANTILLA_LOGOIZQUIERDO) {
                if (
                    file_exists(
                        storage_path('app/' . $contrato->CONTRATO_PLANTILLA_LOGOIZQUIERDO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'LOGO_IZQUIERDO',
                        array(
                            'path' => storage_path('app/' . $contrato->CONTRATO_PLANTILLA_LOGOIZQUIERDO),
                            'width' => 120,
                            'height' => 150,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )
                    );
                } else {
                    $plantillaword->setValue('LOGO_IZQUIERDO', 'IMAGEN NO ENCONTRADA');
                }
            } else {
                $plantillaword->setValue('LOGO_IZQUIERDO', 'SIN FOTO');
            }


            if ($contrato && $contrato->CONTRATO_PLANTILLA_LOGODERECHO) {
                if (
                    file_exists(
                        storage_path('app/' . $contrato->CONTRATO_PLANTILLA_LOGODERECHO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'LOGO_DERECHO',
                        array(
                            'path' => storage_path('app/' . $contrato->CONTRATO_PLANTILLA_LOGODERECHO),
                            'width' => 120,
                            'height' => 150,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )

                    );
                } else {
                    $plantillaword->setValue('LOGO_DERECHO', 'IMAGEN NO ENCONTRADA');
                }
            } else {
                $plantillaword->setValue('LOGO_DERECHO', 'SIN FOTO');
            }

            $plantillaword->setValue('PIE_PAGINA', $contrato->CONTRATO_PLANTILLA_PIEPAGINA ?? 'SIN PIE DE PAGINA');


            ################ PORTADA EXTERNA ####################


            if ($proyecto->requiereContrato == 1) {

                $contratoId = $proyecto->contrato_id;

                $clienteInfo = DB::table('contratos_clientes as cc')
                    ->leftJoin('cliente as c', 'c.id', '=', 'cc.CLIENTE_ID')
                    ->where('cc.ID_CONTRATO', $contratoId)
                    ->select(
                        'cc.NUMERO_CONTRATO',
                        'cc.DESCRIPCION_CONTRATO',
                        'cc.CONTRATO_PLANTILLA_LOGODERECHO',
                        'cc.CONTRATO_PLANTILLA_LOGOIZQUIERDO',
                        'cc.CONTRATO_PLANTILLA_PIEPAGINA',
                        'c.cliente_RazonSocial'
                    )
                    ->get();
            } else {
                $clienteInfo = clienteModel::where('id', $proyecto->cliente_id)->get();
            }


            $titulo_partida = clientepartidasModel::where('CONTRATO_ID', $proyecto->contrato_id)
                ->where('clientepartidas_tipo', 2) // Informe de resultados
                ->where('catprueba_id', 26) // Iluminacion
                ->orderBy('updated_at', 'DESC')
                ->get();

            if (count($titulo_partida) > 0) {

                //Para el valor que lleva proyecto se utilizo: descripcion de la partida, Numero del contrato y la descripcion del contrato
                $plantillaword->setValue('proyecto_portada', str_replace("\n", "<w:br/>", $titulo_partida[0]->clientepartidas_descripcion) . ' - Contrato: ' . $clienteInfo[0]->NUMERO_CONTRATO);

                $plantillaword->setValue('PARTIDA', str_replace("\n", "<w:br/>", $titulo_partida[0]->clientepartidas_descripcion));
            } else {

                $plantillaword->setValue('PARTIDA', "");
                $plantillaword->setValue('proyecto_portada', 'El proyecto no esta vinculado a ningun contrato.');
            }

            $plantillaword->setValue('folio_portada', $proyecto->proyecto_folio);
            $plantillaword->setValue('razon_social_portada', $cliente->cliente_RazonSocial);

            // PARTE INTALACION PORTADA
            $OPCION_PORTADA1 = is_null($recursos[0]->OPCION_PORTADA1) ? "" : $recursos[0]->OPCION_PORTADA1 . " | ";
            $OPCION_PORTADA2 = is_null($recursos[0]->OPCION_PORTADA2) ? "" : $recursos[0]->OPCION_PORTADA2 . " | ";
            $OPCION_PORTADA3 = is_null($recursos[0]->OPCION_PORTADA3) ? "" : $recursos[0]->OPCION_PORTADA3 . " | ";
            $OPCION_PORTADA4 = is_null($recursos[0]->OPCION_PORTADA4) ? "" : $recursos[0]->OPCION_PORTADA4 . " | ";
            $OPCION_PORTADA5 = is_null($recursos[0]->OPCION_PORTADA5) ? "" : $recursos[0]->OPCION_PORTADA5 . " | ";
            $OPCION_PORTADA6 = is_null($recursos[0]->OPCION_PORTADA6) ? "" : $recursos[0]->OPCION_PORTADA6;

            $plantillaword->setValue('instalación_portada', $OPCION_PORTADA1 . $OPCION_PORTADA2 . $OPCION_PORTADA3 . $OPCION_PORTADA4 . $OPCION_PORTADA5 . $OPCION_PORTADA6);

            $niveles = [];
            if (isset($recursos[0])) {
                if (!empty($recursos[0]->NIVEL1)) {
                    $niveles[] = $recursos[0]->NIVEL1;
                }
                if (!empty($recursos[0]->NIVEL2)) {
                    $niveles[] = $recursos[0]->NIVEL2;
                }
                if (!empty($recursos[0]->NIVEL3)) {
                    $niveles[] = $recursos[0]->NIVEL3;
                }
                if (!empty($recursos[0]->NIVEL4)) {
                    $niveles[] = $recursos[0]->NIVEL4;
                }
                if (!empty($recursos[0]->NIVEL5)) {
                    $niveles[] = $recursos[0]->NIVEL5;
                }
            }


            $textoInstalacion = count($niveles)
                ? implode(
                    '</w:t><w:br/><w:t>',
                    $niveles
                )
                : 'No cargado';
            $plantillaword->setValue(
                'INSTALACION_NOMBRE',
                $textoInstalacion

            );

            $datosGenerales = datosgeneralesinformeRecoModel::where('RECO_ID',$RECO_ID)->first();


            $datosGenerales2 = datosgeneralesinformeFreModel::where('RECO_ID', $RECO_ID)->first();

            //// INTRODUCCION

            $introduccion = $datosGenerales2->INFORME_INTRODUCCION;
            $introduccion = preg_replace('/<\/p>/i', "¶", $introduccion);
            $introduccion = strip_tags($introduccion);
            $introduccion = html_entity_decode($introduccion);
            $introduccion = str_replace('¶', "\n\n", $introduccion);

            $plantillaword->setValue('INTRODUCCION', $introduccion);

            //// DEFINICIONES
            $definiciones = DB::table('definicionesinformefre as di')
                ->join(
                    'catergo_definiciones as cd',
                    'cd.ID_DEFINICIONES',
                    '=',
                    'di.CATALOGO_DEFINICIONES_ID'
                )
                ->where(
                    'di.RECO_ID',
                    $RECO_ID
                )
                ->orderBy(
                    'cd.CONCEPTO_DEFINICION',
                    'ASC'
                )
                ->select(
                    'cd.CONCEPTO_DEFINICION',
                    'cd.DESCRIPCION_DEFINICION',
                    'cd.FUENTE_DEFINICION'
                )
                ->get();

            $textoDefiniciones = '';

            $fuentes = [];


            foreach ($definiciones as $key => $value) {

                $textoDefiniciones .=
                    '<w:p>
                        <w:r>
                            <w:rPr>
                                <w:b/>
                            </w:rPr>
                            <w:t>' .
                    htmlspecialchars($value->CONCEPTO_DEFINICION) .
                    ':</w:t>
                        </w:r>
                        <w:r>
                            <w:t xml:space="preserve">
                                ' . htmlspecialchars($value->DESCRIPCION_DEFINICION) . '
                            </w:t>
                        </w:r>
                    </w:p>';


                if (
                    $value->FUENTE_DEFINICION
                    &&
                    !in_array(
                        $value->FUENTE_DEFINICION,
                        $fuentes
                    )
                ) {
                    $fuentes[] = $value->FUENTE_DEFINICION;
                }
            }


            if ($textoDefiniciones == '') {
                $textoDefiniciones = 'No cargado';
            }

            $textoFuentes = count($fuentes)
                ? implode(
                    '</w:t><w:br/><w:t>',
                    $fuentes
                )
                : 'No cargado';


            $plantillaword->setValue('DEFINICIONES', $textoDefiniciones);


            $plantillaword->setValue('DEFINICIONES_FUENTES', $textoFuentes);


            //// OBEJTIVO GENERAL
            $plantillaword->setValue('OBJETIVO_GENERAL', $datosGenerales2->INFORME_OBJETIVOGENERALES ?? 'No cargado');

            //// OBEJTIVO ESPECIFICOS
            $textoObjetivos = '';

            if (!empty($datosGenerales2->INFORME_OBJETIVOSESPECIFICOS)) {
                $objetivos = preg_split(
                    "/\r\n|\n|\r/",
                    $datosGenerales2->INFORME_OBJETIVOSESPECIFICOS
                );
                foreach ($objetivos as $objetivo) {
                    $objetivo = trim($objetivo);
                    $objetivo = ltrim($objetivo, '•- ');

                    if ($objetivo != '') {
                        $textoObjetivos .= '• ' . $objetivo . '</w:t><w:br/><w:t>';
                    }
                }
            } else {
                $textoObjetivos = 'No cargado';
            }


            $plantillaword->setValue('OBJETIVOS_ESPECIFICOS', $textoObjetivos);

            // RECONOCIMIENTO
            
            $plantillaword->setValue('TEXTO_RECONOCIMIENTO', $datosGenerales2->INFORME_RECONOCIMIENTO ?? 'No cargado');


                        
                $criteriosMapa = [
                    '1.1' => 'Levantamiento de cargas',
                    '1.2' => 'Transporte de cargas',
                    '2.1' => 'Empuje y tracción de cargas',
                    '3.1' => 'Movimientos repetitivos',
                    '4.1' => 'Posturas estáticas forzadas',
                    '4.2' => 'Posturas dinámicas forzadas'
                ];

                $fichas = recoergofichastecnicasModel::where('RECO_ID', $RECO_ID)
                    ->where('ACTIVO', 1)
                    ->whereNotNull('PE_EVALUADAS')
                    ->where('PE_EVALUADAS', '!=', '')
                    ->orderBy('ID_FICHAS_TECNICAS')
                    ->get();

                $fuente = 'Poppins';

                $textoTitulo = [
                    'name' => $fuente,
                    'size' => 13,
                    'bold' => true,
                    'color' => '000000'
                ];

                $textoHeader = [
                    'name' => $fuente,
                    'size' => 9,
                    'bold' => true,
                    'color' => '000000'
                ];

                $texto = [
                    'name' => $fuente,
                    'size' => 8,
                    'color' => '000000'
                ];

                $centrado = [
                    'alignment' => 'center',
                    'valign' => 'center'
                ];

                $izquierda = [
                    'alignment' => 'left',
                    'valign' => 'center'
                ];

                $totalAnchoTabla = 14000;
                $anchoTitulo = 4200;
                $anchoDisponible = $totalAnchoTabla - $anchoTitulo;
                $maxPersonasPorBloque = 10;

                $anchoPE = (int) floor(
                    $anchoDisponible / $maxPersonasPorBloque
                );

                $ultimoAnchoPE = $anchoDisponible - (
                    $anchoPE * ($maxPersonasPorBloque - 1)
                );

                $tableReconocimiento = new \PhpOffice\PhpWord\Element\Table([
                    'borderSize' => 12,
                    'borderColor' => '0B2C6B',
                    'cellMargin' => 20,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START,
                    'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
                ]);

                $bloquesFichas = $fichas->chunk($maxPersonasPorBloque);

                foreach ($bloquesFichas as $bloqueFichas) {

                    $cantidadPE = $bloqueFichas->count();

                    $tableReconocimiento->addRow(450);

                    $tableReconocimiento->addCell(
                        $totalAnchoTabla,
                        [
                            'gridSpan' => $maxPersonasPorBloque + 1,
                            'bgColor' => 'FFFFFF',
                            'valign' => 'center'
                        ]
                    )->addTextRun($centrado)
                        ->addText('MAPA DE PELIGROS', $textoTitulo);

                    $tableReconocimiento->addRow(400);

                    $tableReconocimiento->addCell(
                        $anchoTitulo,
                        [
                            'vMerge' => 'restart',
                            'valign' => 'center',
                            'bgColor' => 'FFFFFF'
                        ]
                    )->addTextRun($centrado)
                        ->addText('Criterios de carga física', $textoHeader);

                    $tableReconocimiento->addCell(
                        $anchoDisponible,
                        [
                            'gridSpan' => $maxPersonasPorBloque,
                            'valign' => 'center',
                            'bgColor' => 'FFFFFF'
                        ]
                    )->addTextRun($centrado)
                        ->addText('Personas evaluadas', $textoHeader);

                    $tableReconocimiento->addRow(350);

                    $tableReconocimiento->addCell(
                        $anchoTitulo,
                        [
                            'vMerge' => 'continue',
                            'valign' => 'center'
                        ]
                    );

                    foreach ($bloqueFichas as $ficha) {

                        $anchoActual = (
                            $ficha === $bloqueFichas->last()
                        )
                            ? $ultimoAnchoPE
                            : $anchoPE;

                        $tableReconocimiento->addCell(
                            $anchoActual,
                            [
                                'valign' => 'center',
                                'bgColor' => 'FFFFFF'
                            ]
                        )->addTextRun($centrado)
                            ->addText($ficha->PE_EVALUADAS, $textoHeader);
                    }

                    for ($i = $cantidadPE; $i < $maxPersonasPorBloque; $i++) {

                        $anchoActual = (
                            $i === $maxPersonasPorBloque - 1
                        )
                            ? $ultimoAnchoPE
                            : $anchoPE;

                        $tableReconocimiento->addCell(
                            $anchoActual,
                            [
                                'valign' => 'center',
                                'bgColor' => 'FFFFFF'
                            ]
                        );
                    }

                    foreach ($criteriosMapa as $codigo => $titulo) {

                        $tableReconocimiento->addRow(300);

                        $tableReconocimiento->addCell(
                            $anchoTitulo,
                            [
                                'valign' => 'center',
                                'bgColor' => 'FFFFFF'
                            ]
                        )->addTextRun($izquierda)
                            ->addText($titulo, $texto);

                        foreach ($bloqueFichas as $fichaDB) {

                            $resultadoFinal = 'VERDE';

                            $json = json_decode(
                                $fichaDB->JSON_FICHAS,
                                true
                            );

                            if (is_array($json)) {

                                foreach ($json as $bloque) {

                                    if (
                                        isset($bloque['ficha']) &&
                                        (string) $bloque['ficha'] === (string) $codigo
                                    ) {

                                        if (
                                            isset($bloque['resultado']) &&
                                            strtoupper(
                                                trim((string) $bloque['resultado'])
                                            ) === 'ROJO'
                                        ) {
                                            $resultadoFinal = 'ROJO';
                                            break;
                                        }
                                    }
                                }
                            }

                            $colorCelda = (
                                $resultadoFinal === 'ROJO'
                            )
                                ? 'DC3545'
                                : '28A745';

                            $anchoActual = (
                                $fichaDB === $bloqueFichas->last()
                            )
                                ? $ultimoAnchoPE
                                : $anchoPE;

                            $tableReconocimiento->addCell(
                                $anchoActual,
                                [
                                    'bgColor' => $colorCelda,
                                    'valign' => 'center'
                                ]
                            )->addTextRun($centrado)
                                ->addText('');
                        }

                        for (
                            $i = $cantidadPE;
                            $i < $maxPersonasPorBloque;
                            $i++
                        ) {

                            $anchoActual = (
                                $i === $maxPersonasPorBloque - 1
                            )
                                ? $ultimoAnchoPE
                                : $anchoPE;

                            $tableReconocimiento->addCell(
                                $anchoActual,
                                [
                                    'bgColor' => 'FFFFFF',
                                    'valign' => 'center'
                                ]
                            )->addText('');
                        }
                    }
                }

                $plantillaword->setComplexBlock('TABLA_RECONOCIMIENTO',$tableReconocimiento);


            //// UBICACION INSTALACION
            $plantillaword->setValue('UBICACION_TEXTO', $datosGenerales->INFORME_UBICACIONINSTALACION ?? 'No cargado');

            //// UBICACION INSTALACION FOTO 
            if ($datosGenerales->RUTA_IMAGEN_UBICACION) {
                if (
                    file_exists(storage_path('app/' . $datosGenerales->RUTA_IMAGEN_UBICACION))
                ) {
                    $plantillaword->setImageValue(
                        'UBICACION_FOTO',
                        array(
                            'path' => storage_path('app/' . $datosGenerales->RUTA_IMAGEN_UBICACION),
                            'width' => 580,
                            'height' => 400,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )
                    );
                } else {
                    $plantillaword->setValue('UBICACION_FOTO', 'FALTA CARGAR IMAGEN DESDE EL SISTEMA.');
                }
            } else {
                $plantillaword->setValue('UBICACION_FOTO', 'FALTA CARGAR IMAGEN DESDE EL SISTEMA.');
            }


            //// PROCESO DE LA INSTALACION
            $plantillaword->setValue('PROCESO_INSTALACION', $datosGenerales2->INFORME_PROCESOINSTALACION ?? 'No cargado');


            //// ACTIVIDAD PRINCIPAL DE LA INSTALACION 
            $plantillaword->setValue('ACTIVIDAD_INSTALACION', $datosGenerales2->INFORME_ACTIVIDADPRINCIPAL ?? 'No cargado');


            ////  CICLOS DE TRABAJO DE LAS CATEGORIAS 

            $evaluacionesFre = DB::table('evaluacion_fre_ergo as evaluacion')
                ->leftJoin(
                    'recoergocategorias as categoria',
                    'categoria.ID_CATEGORIA_ERGO',
                    '=',
                    'evaluacion.CATEGORIA_ID_FRE'
                )
                ->leftJoin(
                    'recoergo_fichastecnicas as ficha',
                    'ficha.ID_FICHAS_TECNICAS',
                    '=',
                    'evaluacion.FICHA_ID'
                )
                ->where('evaluacion.RECO_ID', $RECO_ID)
                ->select(
                    'evaluacion.ID_EVALUACION_FRE',
                    'evaluacion.JSON_ACTIVIDADES_FRE',
                    'categoria.NOMBRE_CATEGORIA_ERGO',
                    'ficha.TURNO_EMPLEADO_FICHA'
                )
                ->orderBy('evaluacion.ID_EVALUACION_FRE', 'asc')
                ->get();

            $catalogoTurnos = DB::table('catergo_turno')
                ->pluck('NOMBRE_TURNO', 'ID_TURNO')
                ->all();

            $datosActividadesFre = [];

            foreach ($evaluacionesFre as $evaluacion) {

                $idsTurnos = json_decode(
                    $evaluacion->TURNO_EMPLEADO_FICHA ?: '[]',
                    true
                );

                if (!is_array($idsTurnos)) {
                    $idsTurnos = [];
                }

                $nombresTurnos = [];

                foreach ($idsTurnos as $idTurno) {

                    if (
                        is_scalar($idTurno) &&
                        isset($catalogoTurnos[$idTurno])
                    ) {
                        $nombresTurnos[] = $catalogoTurnos[$idTurno];
                    }
                }

                $turnos = !empty($nombresTurnos)
                    ? implode(', ', array_unique($nombresTurnos))
                    : '-';

                $actividades = json_decode(
                    $evaluacion->JSON_ACTIVIDADES_FRE ?: '[]',
                    true
                );

                if (!is_array($actividades) || empty($actividades)) {
                    $actividades = [
                        [
                            'nombre' => '-',
                            'tareas' => [],
                        ],
                    ];
                }

                foreach ($actividades as $actividad) {

                    if (!is_array($actividad)) {
                        continue;
                    }

                    $tareas = isset($actividad['tareas']) &&
                        is_array($actividad['tareas'])
                        ? $actividad['tareas']
                        : [];

                    if (empty($tareas)) {
                        $tareas = [[]];
                    }

                    foreach ($tareas as $tarea) {

                        if (!is_array($tarea)) {
                            continue;
                        }

                        $datosActividadesFre[] = [
                            'CATEGORIA' => $evaluacion->NOMBRE_CATEGORIA_ERGO ?: '-',
                            'TURNO' => $turnos,
                            'ACTIVIDAD' => $actividad['nombre'] ?? '-',
                            'TAREA' => $tarea['nombre'] ?? '-',
                            'DURACION' => $tarea['duracion'] ?? '-',
                            'FRECUENCIA' => $tarea['frecuencia'] ?? '-',
                            'NUMERO_VECES' => $tarea['numero_veces'] ?? '-',
                        ];
                    }
                }
            }

            $fuenteFre = 'Poppins';

            $encabezadoTextoFre = [
                'name' => $fuenteFre,
                'size' => 9,
                'bold' => true,
                'color' => 'FFFFFF',
            ];

            $textoFre = [
                'name' => $fuenteFre,
                'size' => 8,
                'color' => '000000',
            ];

            $centradoFre = [
                'alignment' => 'center',
                'valign' => 'center',
            ];

            $izquierdaFre = [
                'alignment' => 'left',
                'valign' => 'center',
            ];

            $encabezadoCeldaFre = [
                'bgColor' => '0F3D63',
                'valign' => 'center',
            ];

            $celdaFre = [
                'valign' => 'center',
            ];

            $columnasFre = [
                'CATEGORIA' => 'Categoría',
                'TURNO' => 'Turno de trabajo',
                'ACTIVIDAD' => 'Actividad realizada',
                'TAREA' => 'Tareas a realizar',
                'DURACION' => 'Tiempo que le toma llevar las tareas a cabo',
                'FRECUENCIA' => 'Frecuencia',
                'NUMERO_VECES' => 'No. veces',
            ];

            $anchosFre = [
                'CATEGORIA' => 1800,
                'TURNO' => 1600,
                'ACTIVIDAD' => 2200,
                'TAREA' => 3200,
                'DURACION' => 2000,
                'FRECUENCIA' => 1900,
                'NUMERO_VECES' => 1300,
            ];

            $totalAnchoFre = array_sum($anchosFre);

            $tablaCondiciones = new \PhpOffice\PhpWord\Element\Table([
                'name' => $fuenteFre,
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP,
            ]);

            $tablaCondiciones->addRow(600);

            foreach ($columnasFre as $campo => $titulo) {

                $tablaCondiciones->addCell(
                    $anchosFre[$campo],
                    $encabezadoCeldaFre
                )
                    ->addTextRun($centradoFre)
                    ->addText($titulo, $encabezadoTextoFre);
            }

            $columnasAgrupadasFre = [
                'CATEGORIA',
                'TURNO',
                'ACTIVIDAD',
                'DURACION',
                'FRECUENCIA',
                'NUMERO_VECES',
            ];

            $totalFilasFre = count($datosActividadesFre);

            for ($i = 0; $i < $totalFilasFre; $i++) {

                $filaActual = $datosActividadesFre[$i];

                $tablaCondiciones->addRow(350);

                foreach ($columnasFre as $campo => $titulo) {

                    $valorActual = trim(
                        (string) ($filaActual[$campo] ?? '-')
                    );

                    $esAgrupada = in_array(
                        $campo,
                        $columnasAgrupadasFre,
                        true
                    );

                    $inicioGrupo = $i;
                    $finGrupo = $i;

                    if ($esAgrupada) {

                        while (
                            $inicioGrupo > 0 &&
                            trim(
                                (string) (
                                    $datosActividadesFre[$inicioGrupo - 1][$campo] ?? '-'
                                )
                            ) === $valorActual
                        ) {
                            $inicioGrupo--;
                        }

                        while (
                            $finGrupo < $totalFilasFre - 1 &&
                            trim(
                                (string) (
                                    $datosActividadesFre[$finGrupo + 1][$campo] ?? '-'
                                )
                            ) === $valorActual
                        ) {
                            $finGrupo++;
                        }
                    }

                    if ($esAgrupada && $inicioGrupo < $finGrupo) {

                        if ($i > $inicioGrupo) {

                            $tablaCondiciones->addCell(
                                $anchosFre[$campo],
                                [
                                    'vMerge' => 'continue',
                                    'valign' => 'center',
                                    'borderSize' => 1,
                                    'borderColor' => '000000',
                                ]
                            );

                            continue;
                        }

                        $tablaCondiciones->addCell(
                            $anchosFre[$campo],
                            [
                                'vMerge' => 'restart',
                                'valign' => 'center',
                                'borderSize' => 1,
                                'borderColor' => '000000',
                            ]
                        )->addText(
                            $valorActual,
                            $textoFre,
                            in_array(
                                $campo,
                                [
                                    'CATEGORIA',
                                    'TURNO',
                                    'DURACION',
                                    'FRECUENCIA',
                                    'NUMERO_VECES',
                                ],
                                true
                            )
                                ? $centradoFre
                                : $izquierdaFre
                        );

                        continue;
                    }

                    $tablaCondiciones->addCell(
                        $anchosFre[$campo],
                        $celdaFre
                    )->addText(
                        $valorActual,
                        $textoFre,
                        in_array(
                            $campo,
                            [
                                'CATEGORIA',
                                'TURNO',
                                'DURACION',
                                'FRECUENCIA',
                                'NUMERO_VECES',
                            ],
                            true
                        )
                            ? $centradoFre
                            : $izquierdaFre
                    );
                }
            }

            if ($totalFilasFre === 0) {

                $tablaCondiciones->addRow(400);

                $tablaCondiciones->addCell(
                    $totalAnchoFre,
                    [
                        'gridSpan' => count($columnasFre),
                        'valign' => 'center',
                        'borderSize' => 1,
                        'borderColor' => '000000',
                    ]
                )->addText(
                    'No hay actividades FRE registradas.',
                    $textoFre,
                    $centradoFre
                );
            }

            $plantillaword->setComplexBlock('TABLA_CICLO', $tablaCondiciones);



            //// CONDICIONES DE OPERACIONES DURANTE LA EVALUACION 


            $categorias = recoergocategoriasModel::where('RECO_ID', $RECO_ID)
                ->where('ACTIVO', 1)
                ->get();

            $fichas = recoergofichastecnicasModel::where('RECO_ID', $RECO_ID)
                ->get();

            $areasAgrupadas = [];

            foreach ($categorias as $categoria) {

                if (
                    !$categoria->CATEGORIA_AREAS_ID ||
                    !is_array($categoria->CATEGORIA_AREAS_ID)
                ) {
                    continue;
                }

                foreach ($categoria->CATEGORIA_AREAS_ID as $area_id) {

                    $area = recoergoareasModel::find($area_id);

                    if (!$area) {
                        continue;
                    }

                    if (!isset($areasAgrupadas[$area_id])) {

                        $areasAgrupadas[$area_id] = [
                            'AREA' => trim($area->NOMBRE_AREA_ERGO),
                            'CATEGORIAS' => []
                        ];
                    }

                    if (!isset($areasAgrupadas[$area_id]['CATEGORIAS'][$categoria->ID_CATEGORIA_ERGO])) {

                        $areasAgrupadas[$area_id]['CATEGORIAS'][$categoria->ID_CATEGORIA_ERGO] = [
                            'NOMBRE' => $categoria->NOMBRE_CATEGORIA_ERGO,
                            'PUESTOS' => []
                        ];
                    }

                    foreach ($fichas as $ficha) {

                        if (
                            $ficha->CATEGORIA_ID_FICHA == $categoria->ID_CATEGORIA_ERGO &&
                            is_array($ficha->CAT_AREAS_FICHA) &&
                            in_array($area_id, $ficha->CAT_AREAS_FICHA)
                        ) {

                            if (!empty($ficha->PE_EVALUADAS)) {

                                $areasAgrupadas[$area_id]['CATEGORIAS'][$categoria->ID_CATEGORIA_ERGO]['PUESTOS'][] =
                                    trim($ficha->PE_EVALUADAS);
                            }
                        }
                    }
                }
            }

            $fuente = 'Poppins';

            $encabezado_texto = [
                'name' => $fuente,
                'size' => 11,
                'bold' => true,
                'color' => 'FFFFFF'
            ];

            $texto = [
                'name' => $fuente,
                'size' => 10,
                'color' => '000000'
            ];

            $centrado = [
                'alignment' => 'center',
                'valign' => 'center'
            ];

            $encabezado_celda = [
                'bgColor' => '0F3D63',
                'valign' => 'center'
            ];

            $celda = [
                'valign' => 'center'
            ];

            $ancho_area = 4800;
            $ancho_categoria = 4800;

            $table = new Table([
                'name' => $fuente,
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'unit' => TblWidth::TWIP
            ]);

            $table->addRow(500);

            $table->addCell($ancho_area, $encabezado_celda)
                ->addTextRun($centrado)
                ->addText('Área', $encabezado_texto);

            $table->addCell($ancho_categoria, $encabezado_celda)
                ->addTextRun($centrado)
                ->addText('Categoría', $encabezado_texto);

            if (count($areasAgrupadas) > 0) {

                uasort($areasAgrupadas, function ($a, $b) {
                    return strcmp($a['AREA'], $b['AREA']);
                });

                foreach ($areasAgrupadas as $area) {

                    ksort($area['CATEGORIAS']);

                    $primeraCategoria = true;

                    foreach ($area['CATEGORIAS'] as $categoria) {

                        $table->addRow();

                        if ($primeraCategoria) {

                            $table->addCell(
                                $ancho_area,
                                [
                                    'vMerge' => 'restart',
                                    'valign' => 'center'
                                ]
                            )->addTextRun($centrado)->addText(
                                $area['AREA'],
                                $texto
                            );

                            $primeraCategoria = false;
                        } else {

                            $table->addCell(
                                $ancho_area,
                                [
                                    'vMerge' => 'continue',
                                    'valign' => 'center'
                                ]
                            );
                        }

                        $table->addCell(
                            $ancho_categoria,
                            $celda
                        )->addTextRun($centrado)->addText(
                            $categoria['NOMBRE'],
                            $texto
                        );
                    }
                }
            } else {

                $table->addRow();

                $table->addCell(
                    null,
                    [
                        'gridSpan' => 2,
                        'valign' => 'center'
                    ]
                )->addTextRun($centrado)->addText(
                    'No hay áreas registradas',
                    $texto
                );
            }

            $plantillaword->setComplexBlock('TABLA_CONDICIONES', $table);

            /// Variables antropométricas (peso y talla)

            $evaluaciones = DB::table('evaluacion_fre_ergo as evaluacion')
                ->leftJoin(
                    'recoergo_fichastecnicas as ficha',
                    'ficha.ID_FICHAS_TECNICAS',
                    '=',
                    'evaluacion.FICHA_ID'
                )
                ->leftJoin(
                    'recoergocategorias as categoria',
                    'categoria.ID_CATEGORIA_ERGO',
                    '=',
                    'ficha.CATEGORIA_ID_FICHA'
                )
                ->where('evaluacion.RECO_ID', $RECO_ID)
                ->select(
                    'evaluacion.ID_EVALUACION_FRE',
                    'evaluacion.NOMBRE_EMPLEADO_FRE',
                    'evaluacion.PESO_FRE',
                    'evaluacion.TALLA_FRE',
                    'ficha.CAT_AREAS_FICHA',
                    'categoria.NOMBRE_CATEGORIA_ERGO'
                )
                ->orderBy('evaluacion.ID_EVALUACION_FRE', 'asc')
                ->get();

            $catalogoAreas = DB::table('recoergoareas')
                ->pluck('NOMBRE_AREA_ERGO', 'ID_AREA_ERGO')
                ->all();

            $fuente = 'Poppins';

            $encabezadoTexto = [
                'name' => $fuente,
                'size' => 9,
                'bold' => true,
                'color' => 'FFFFFF'
            ];

            $texto = [
                'name' => $fuente,
                'size' => 8,
                'color' => '000000'
            ];

            $centrado = [
                'alignment' => 'center',
                'valign' => 'center'
            ];

            $encabezadoCelda = [
                'bgColor' => '0F3D63',
                'valign' => 'center'
            ];

            $celda = [
                'valign' => 'center'
            ];

            $anchos = [
                'numero' => 500,
                'empleado' => 2400,
                'categoria' => 1800,
                'area' => 1800,
                'estatura' => 900,
                'peso' => 800,
                'imc' => 800,
                'interpretacion' => 1600
            ];

            $table = new Table([
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 60,
                'unit' => TblWidth::TWIP
            ]);

            $table->addRow(500);

            $table->addCell($anchos['numero'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('N.º', $encabezadoTexto);

            $table->addCell($anchos['empleado'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Empleado', $encabezadoTexto);

            $table->addCell($anchos['categoria'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Categoría', $encabezadoTexto);

            $table->addCell($anchos['area'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Área', $encabezadoTexto);

            $table->addCell($anchos['estatura'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Estatura (cm)', $encabezadoTexto);

            $table->addCell($anchos['peso'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Peso (kg)', $encabezadoTexto);

            $table->addCell($anchos['imc'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('IMC', $encabezadoTexto);

            $table->addCell($anchos['interpretacion'], $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Interpretación', $encabezadoTexto);

            if ($evaluaciones->count() > 0) {

                foreach ($evaluaciones as $indice => $evaluacion) {

                    $idsAreas = json_decode(
                        $evaluacion->CAT_AREAS_FICHA ?: '[]',
                        true
                    );

                    if (!is_array($idsAreas)) {
                        $idsAreas = [];
                    }

                    $nombresAreas = [];

                    foreach ($idsAreas as $idArea) {

                        if (
                            is_scalar($idArea) &&
                            isset($catalogoAreas[$idArea])
                        ) {
                            $nombresAreas[] = $catalogoAreas[$idArea];
                        }
                    }

                    $areas = !empty($nombresAreas)
                        ? implode(', ', array_unique($nombresAreas))
                        : '-';

                    $peso = is_numeric($evaluacion->PESO_FRE)
                        ? (float) $evaluacion->PESO_FRE
                        : null;

                    $estaturaCm = is_numeric($evaluacion->TALLA_FRE)
                        ? (float) $evaluacion->TALLA_FRE
                        : null;

                    $imc = null;
                    $interpretacion = 'Sin datos válidos';

                    if (
                        $peso !== null &&
                        $estaturaCm !== null &&
                        $peso > 0 &&
                        $estaturaCm > 0
                    ) {

                        $estaturaMetros = $estaturaCm / 100;

                        $imc = $peso / ($estaturaMetros * $estaturaMetros);

                        if ($imc < 18.5) {
                            $interpretacion = 'Peso bajo';
                        } elseif ($imc < 25) {
                            $interpretacion = 'Ideal';
                        } elseif ($imc < 30) {
                            $interpretacion = 'Sobrepeso';
                        } elseif ($imc < 35) {
                            $interpretacion = 'Obesidad';
                        } elseif ($imc < 40) {
                            $interpretacion = 'Obesidad severa';
                        } else {
                            $interpretacion = 'Obesidad mórbida';
                        }
                    }

                    $table->addRow();

                    $table->addCell($anchos['numero'], $celda)
                        ->addTextRun($centrado)
                        ->addText((string) ($indice + 1), $texto);

                    $table->addCell($anchos['empleado'], $celda)
                        ->addText(
                            $evaluacion->NOMBRE_EMPLEADO_FRE ?: '-',
                            $texto
                        );

                    $table->addCell($anchos['categoria'], $celda)
                        ->addText(
                            $evaluacion->NOMBRE_CATEGORIA_ERGO ?: '-',
                            $texto
                        );

                    $table->addCell($anchos['area'], $celda)
                        ->addText($areas, $texto);

                    $table->addCell($anchos['estatura'], $celda)
                        ->addTextRun($centrado)
                        ->addText(
                            $estaturaCm !== null ? (string) $estaturaCm : '-',
                            $texto
                        );

                    $table->addCell($anchos['peso'], $celda)
                        ->addTextRun($centrado)
                        ->addText(
                            $peso !== null ? (string) $peso : '-',
                            $texto
                        );

                    $table->addCell($anchos['imc'], $celda)
                        ->addTextRun($centrado)
                        ->addText(
                            $imc !== null
                                ? number_format($imc, 2, '.', '')
                                : '-',
                            $texto
                        );

                    $table->addCell($anchos['interpretacion'], $celda)
                        ->addText(
                            $interpretacion,
                            $texto
                        );
                }
            } else {

                $table->addRow();

                $table->addCell(
                    null,
                    [
                        'gridSpan' => 8,
                        'valign' => 'center'
                    ]
                )->addTextRun($centrado)->addText(
                    'No hay evaluaciones antropométricas registradas',
                    $texto
                );
            }

            $plantillaword->setComplexBlock('TABLA_ANTOPOMETRICAS', $table);

            $plantillaword->setValue('ANALISIS_ANTOPOMETRICAS', $datosGenerales2->INFORME_ANTROPOMETRICAS ?? 'No cargado');


            /// GRAFICAS





            /// 1 


            $imagen1 = $request->input('GRAFICA_1');

            if (!empty($imagen1)) {

                if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen1, $coincidencias)) {

                    $contenidoImagen1 = base64_decode($coincidencias[1], true);

                    if ($contenidoImagen1 !== false) {

                        $rutaImagen1 = tempnam(sys_get_temp_dir(), 'fre_grafica1_') . '.png';

                        if (file_put_contents($rutaImagen1, $contenidoImagen1) !== false) {

                            $plantillaword->setImageValue('GRAFICA_1', [
                                'path'   => $rutaImagen1,
                                'width'  => 600,
                                'height' => 450,
                                'ratio'  => true
                            ]);
                        }
                    }
                }
            }

            $plantillaword->setValue('OBSERVACION_GRAFICA1', $datosGenerales2->OBSERVACIONES_ESQUELETICAS1 ?? 'No cargado');

            // 2
            $imagen2 = $request->input('GRAFICA_2');

            if (!empty($imagen2)) {

                if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen2, $coincidencias)) {

                    $contenidoImagen2 = base64_decode($coincidencias[1], true);

                    if ($contenidoImagen2 !== false) {

                        $rutaImagen2 = tempnam(sys_get_temp_dir(), 'fre_grafica2_') . '.png';

                        if (file_put_contents($rutaImagen2, $contenidoImagen2) !== false) {

                            $plantillaword->setImageValue('GRAFICA_2', [
                                'path'   => $rutaImagen2,
                                'width'  => 600,
                                'height' => 450,
                                'ratio'  => true
                            ]);
                        }
                    }
                }
            }

            $plantillaword->setValue('OBSERVACION_GRAFICA2', $datosGenerales2->OBSERVACIONES_ESQUELETICAS2 ?? 'No cargado');

            //3



            $imagen3 = $request->input('GRAFICA_3');

            if (!empty($imagen3)) {

                if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen3, $coincidencias)) {

                    $contenidoImagen3 = base64_decode($coincidencias[1], true);

                    if ($contenidoImagen3 !== false) {

                        $rutaImagen3 = tempnam(sys_get_temp_dir(), 'fre_grafica3_') . '.png';

                        if (file_put_contents($rutaImagen3, $contenidoImagen3) !== false) {

                            $plantillaword->setImageValue('GRAFICA_3', [
                                'path'   => $rutaImagen3,
                                'width'  => 600,
                                'height' => 450,
                                'ratio'  => true
                            ]);
                        }
                    }
                }
            }


            $plantillaword->setValue('OBSERVACION_GRAFICA3', $datosGenerales2->OBSERVACIONES_ESQUELETICAS3 ?? 'No cargado');

            //4


            $imagen4 = $request->input('GRAFICA_4');

                if (!empty($imagen4)) {

                    if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen4, $coincidencias)) {

                        $contenidoImagen4 = base64_decode($coincidencias[1], true);

                        if ($contenidoImagen4 !== false) {

                            $rutaImagen4 = tempnam(sys_get_temp_dir(), 'fre_grafica4_') . '.png';

                            if (file_put_contents($rutaImagen4, $contenidoImagen4) !== false) {

                                $plantillaword->setImageValue('GRAFICA_4', [
                                    'path'   => $rutaImagen4,
                                    'width'  => 600,
                                    'height' => 450,
                                    'ratio'  => true
                                ]);
                            }
                        }
                    }
                }

            $plantillaword->setValue('OBSERVACION_GRAFICA4', $datosGenerales2->OBSERVACIONES_ESQUELETICAS4 ?? 'No cargado');

            //5

            $imagen5 = $request->input('GRAFICA_5');

            if (!empty($imagen5)) {

                if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen5, $coincidencias)) {

                    $contenidoImagen5 = base64_decode($coincidencias[1], true);

                    if ($contenidoImagen5 !== false) {

                        $rutaImagen5 = tempnam(sys_get_temp_dir(), 'fre_grafica5_') . '.png';

                        if (file_put_contents($rutaImagen5, $contenidoImagen5) !== false) {

                            $plantillaword->setImageValue('GRAFICA_5', [
                                'path'   => $rutaImagen5,
                                'width'  => 600,
                                'height' => 450,
                                'ratio'  => true
                            ]);
                        }
                    }
                }
            }
            $plantillaword->setValue('OBSERVACION_GRAFICA5', $datosGenerales2->OBSERVACIONES_ESQUELETICAS5 ?? 'No cargado');

            //6


            $imagen6 = $request->input('GRAFICA_6');

            if (!empty($imagen6)) {

                if (preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=\r\n]+)$/', $imagen6, $coincidencias)) {

                    $contenidoImagen6 = base64_decode($coincidencias[1], true);

                    if ($contenidoImagen6 !== false) {

                        $rutaImagen6 = tempnam(sys_get_temp_dir(), 'fre_grafica6_') . '.png';

                        if (file_put_contents($rutaImagen6, $contenidoImagen6) !== false) {

                            $plantillaword->setImageValue('GRAFICA_6', [
                                'path'   => $rutaImagen6,
                                'width'  => 600,
                                'height' => 450,
                                'ratio'  => true
                            ]);
                        }
                    }
                }
            }
            
            $plantillaword->setValue('OBSERVACION_GRAFICA6', $datosGenerales2->OBSERVACIONES_ESQUELETICAS6 ?? 'No cargado');

            /// CATEGORIAS EVALUADAS


            $recoId = $RECO_ID;

            $categorias = recoergocategoriasModel::where('RECO_ID', $recoId)
                ->where('ACTIVO', 1)
                ->get();

            $fichas = recoergofichastecnicasModel::where('RECO_ID', $recoId)
                ->get();

            $areasAgrupadas = [];

            foreach ($categorias as $categoria) {

                if (
                    empty($categoria->CATEGORIA_AREAS_ID) ||
                    !is_array($categoria->CATEGORIA_AREAS_ID)
                ) {
                    continue;
                }

                foreach ($categoria->CATEGORIA_AREAS_ID as $areaId) {

                    $area = recoergoareasModel::find($areaId);

                    if (!$area) {
                        continue;
                    }

                    if (!isset($areasAgrupadas[$areaId])) {

                        $areasAgrupadas[$areaId] = [
                            'AREA' => trim($area->NOMBRE_AREA_ERGO),
                            'CATEGORIAS' => [],
                            'PUESTOS_AREA' => []
                        ];
                    }

                    $categoriaId = $categoria->ID_CATEGORIA_ERGO;

                    if (!isset($areasAgrupadas[$areaId]['CATEGORIAS'][$categoriaId])) {

                        $areasAgrupadas[$areaId]['CATEGORIAS'][$categoriaId] = [
                            'NOMBRE' => $categoria->NOMBRE_CATEGORIA_ERGO,
                            'PUESTOS' => []
                        ];
                    }

                    foreach ($fichas as $ficha) {

                        if (
                            (string) $ficha->CATEGORIA_ID_FICHA !== (string) $categoriaId ||
                            !is_array($ficha->CAT_AREAS_FICHA) ||
                            !in_array(
                                (string) $areaId,
                                array_map('strval', $ficha->CAT_AREAS_FICHA),
                                true
                            )
                        ) {
                            continue;
                        }

                        $puestos = $ficha->PE_EVALUADAS;

                        if (is_string($puestos)) {
                            $puestos = [$puestos];
                        }

                        if (!is_array($puestos)) {
                            continue;
                        }

                        foreach ($puestos as $puesto) {

                            $puesto = trim((string) $puesto);

                            if ($puesto === '') {
                                continue;
                            }

                            $areasAgrupadas[$areaId]['CATEGORIAS'][$categoriaId]['PUESTOS'][] = $puesto;

                            $areasAgrupadas[$areaId]['PUESTOS_AREA'][] = $puesto;
                        }
                    }
                }
            }

            $fuente = 'Poppins';

            $encabezadoTexto = [
                'name' => $fuente,
                'size' => 10,
                'bold' => true,
                'color' => 'FFFFFF'
            ];

            $texto = [
                'name' => $fuente,
                'size' => 9,
                'color' => '000000'
            ];

            $centrado = [
                'alignment' => 'center',
                'valign' => 'center'
            ];

            $encabezadoCelda = [
                'bgColor' => '0F3D63',
                'valign' => 'center'
            ];

            $celda = [
                'valign' => 'center'
            ];

            $anchoArea = 3500;
            $anchoCategoria = 3500;
            $anchoTrabajadores = 2500;

            $table = new Table([
                'name' => $fuente,
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'unit' => TblWidth::TWIP
            ]);

            $table->addRow(500);

            $table->addCell($anchoArea, $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Área', $encabezadoTexto);

            $table->addCell($anchoCategoria, $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('Categoría', $encabezadoTexto);

            $table->addCell($anchoTrabajadores, $encabezadoCelda)
                ->addTextRun($centrado)
                ->addText('No. de trabajadores evaluados', $encabezadoTexto);

            if (count($areasAgrupadas) > 0) {

                uasort($areasAgrupadas, function ($a, $b) {
                    return strcmp($a['AREA'], $b['AREA']);
                });

                foreach ($areasAgrupadas as $area) {

                    ksort($area['CATEGORIAS']);

                    $puestosUnicosArea = array_values(
                        array_unique($area['PUESTOS_AREA'])
                    );

                    $totalTrabajadoresArea = count($puestosUnicosArea);

                    $primeraCategoria = true;

                    foreach ($area['CATEGORIAS'] as $categoria) {

                        $puestosCategoria = array_values(
                            array_unique($categoria['PUESTOS'])
                        );

                        sort($puestosCategoria);

                        $table->addRow();

                        if ($primeraCategoria) {

                            $table->addCell(
                                $anchoArea,
                                [
                                    'vMerge' => 'restart',
                                    'valign' => 'center'
                                ]
                            )->addTextRun($centrado)->addText(
                                $area['AREA'],
                                $texto
                            );

                            $table->addCell(
                                $anchoCategoria,
                                $celda
                            )->addTextRun($centrado)->addText(
                                $categoria['NOMBRE'],
                                $texto
                            );

                            $table->addCell(
                                $anchoTrabajadores,
                                [
                                    'vMerge' => 'restart',
                                    'valign' => 'center'
                                ]
                            )->addTextRun($centrado)->addText(
                                (string) $totalTrabajadoresArea,
                                $texto
                            );

                            $primeraCategoria = false;
                        } else {

                            $table->addCell(
                                $anchoArea,
                                [
                                    'vMerge' => 'continue',
                                    'valign' => 'center'
                                ]
                            );

                            $table->addCell(
                                $anchoCategoria,
                                $celda
                            )->addTextRun($centrado)->addText(
                                $categoria['NOMBRE'],
                                $texto
                            );

                            $table->addCell(
                                $anchoTrabajadores,
                                [
                                    'vMerge' => 'continue',
                                    'valign' => 'center'
                                ]
                            );
                        }
                    }
                }
            } else {

                $table->addRow();

                $table->addCell(
                    null,
                    [
                        'gridSpan' => 3,
                        'valign' => 'center'
                    ]
                )->addTextRun($centrado)->addText(
                    'No hay trabajadores evaluados registrados',
                    $texto
                );
            }

            $plantillaword->setComplexBlock('TABLA_CATEGORIASEVALUADAS', $table);

            ///METODOS 


            $evaluaciones = DB::table('evaluacion_fre_ergo')
                ->where('RECO_ID', $RECO_ID)
                ->select('CAT_METODOS_FRE')
                ->get();

            $catalogoMetodos = [

                '1' => [
                    'NOMBRE' => 'Método OWAS',
                    'NOMBRE_INGLES' => 'Ovako Working Posture Analysing System',
                    'NOMBRE_ESPANOL' => 'Sistema de análisis de posturas de trabajo Ovako',

                    'DESCRIPCION' => 'Osmos Karhu y Björn Trappe, quienes trabajaron en la industria siderúrgica durante la década de los 70, desarrollaron un método para evaluar la postura durante el trabajo. El método se denomina OWAS (Ovako Working Posture Analysing System).

El método OWAS permite valorar las posturas a nivel de espalda, brazos y piernas de un trabajador y la carga que este manipula durante la postura analizada. A cada postura se le asigna un código que conlleva una valoración del riesgo postural, dando consigo una categoría del riesgo de dicha postura adoptada. Existen cuatro niveles de riesgo para cada postura. Luego se valora el riesgo para cada parte del cuerpo al que se refiere el método (espalda, brazos y piernas), examinando las posturas tomadas y la categoría del riesgo de cada parte del cuerpo dentro de una frecuencia de realización de las mismas. Finalmente, se determina la postura más crítica durante un periodo observacional de 20 a 40 minutos, con sus respectivas frecuencias, para establecer acciones correctivas del puesto de trabajo analizado.'
                ],

                '2' => [
                    'NOMBRE' => 'Método ROSA',
                    'NOMBRE_INGLES' => 'Rapid Office Strain Assessment',
                    'NOMBRE_ESPANOL' => 'Evaluación rápida del esfuerzo en oficinas',

                    'DESCRIPCION' => 'El método ROSA permite valorar de forma rápida el nivel de riesgo de puestos de trabajo con un componente administrativo, donde la persona interactúa con cinco elementos propios de su labor: silla, pantalla, ratón, teclado y teléfono. La base principal del método es la observación de la postura del trabajador frente a su computadora. El profesional que aplica el método asigna una valoración numérica a través de un conjunto de tablas y puntuaciones parciales con el objetivo de indicar el nivel de riesgo y de intervención, priorizando los cambios en los aspectos ergonómicos que requieran atención.'
                ],

                '3' => [
                    'NOMBRE' => 'Método RULA',
                    'NOMBRE_INGLES' => 'Rapid Upper Limb Assessment',
                    'NOMBRE_ESPANOL' => 'Evaluación rápida de las extremidades superiores',

                    'DESCRIPCION' => 'El método RULA tiene como objetivo evaluar la exposición de los trabajadores a factores de riesgo que pueden causar trastornos musculoesqueléticos en las extremidades superiores, derivados de las posturas adoptadas, la repetitividad de los movimientos, la fuerza aplicada o si la actividad es de naturaleza estática.

Para la correcta aplicación del método, se debe realizar la observación directa de la actividad del trabajador durante varios ciclos de trabajo. Posteriormente, se seleccionan las tareas y posturas más significativas, ya sea por su duración o por presentar una mayor carga postural. El método se aplica al lado derecho y al lado izquierdo del cuerpo por separado, ya que tiene en cuenta las posturas adoptadas por las extremidades superiores, cuello, espalda y piernas. Al final, determina cuatro niveles de acción relacionados con los valores obtenidos en la evaluación.

Nota: el profesional que evalúa elige el lado del cuerpo que está sometido a mayor carga postural.'
                ],

            ];

           

            $metodosEncontrados = [];

            foreach ($evaluaciones as $evaluacion) {

                if (empty($evaluacion->CAT_METODOS_FRE)) {
                    continue;
                }

                $metodos = json_decode(
                    $evaluacion->CAT_METODOS_FRE,
                    true
                );

                if (!is_array($metodos)) {
                    continue;
                }

                foreach ($metodos as $metodoId) {

                    $metodoId = (string) $metodoId;

                    if (
                        isset($catalogoMetodos[$metodoId]) &&
                        !isset($metodosEncontrados[$metodoId])
                    ) {
                        $metodosEncontrados[$metodoId] =
                            $catalogoMetodos[$metodoId];
                    }
                }
            }


            if (count($metodosEncontrados) > 0) {

                $contenidoMetodos = new \PhpOffice\PhpWord\Element\TextRun();

                foreach ($metodosEncontrados as $metodo) {

                    $contenidoMetodos->addText(
                        $metodo['NOMBRE'] .
                            ' (' . $metodo['NOMBRE_INGLES'] . ') - ' .
                            $metodo['NOMBRE_ESPANOL'],
                        [
                            'name' => 'Poppins',
                            'size' => 12,
                            'bold' => true,
                        ]
                    );

                    $contenidoMetodos->addTextBreak(1);

                    $parrafos = preg_split(
                        '/\R/',
                        $metodo['DESCRIPCION']
                    );

                    foreach ($parrafos as $parrafo) {

                        $parrafo = trim($parrafo);

                        if ($parrafo === '') {
                            continue;
                        }

                        $contenidoMetodos->addText(
                            $parrafo,
                            [
                                'name' => 'Poppins',
                                'size' => 12,
                                'bold' => false,
                            ],
                            [
                                'alignment' =>
                                \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                                'spaceAfter' => 120,
                            ]
                        );

                        $contenidoMetodos->addTextBreak(1);
                    }

                    $contenidoMetodos->addTextBreak(1);
                }

                $plantillaword->setComplexBlock('METODOS_EVALUADOS',$contenidoMetodos
                );
            } else {

                $plantillaword->setValue('METODOS_EVALUADOS','No se encontraron metodologías evaluadas.');
            }

            //// CONCLUSION
            $plantillaword->setValue('CONCLUSION', $datosGenerales->INFORME_CONCLUSION ? htmlspecialchars($datosGenerales2->INFORME_CONCLUSION) : 'No cargado');

            //// RECOMENDACIONES 

            $recomendaciones = DB::table('recomendacionesinformeFre as rif')
                ->join(
                    'catergo_recomendaciones as cr',
                    'cr.ID_RECOMENDACIONES',
                    '=',
                    'rif.CATALOGO_RECOMENDACIONES_ID'
                )
                ->where('rif.RECO_ID', $RECO_ID)
                ->select(
                    'cr.DESCRIPCION_RECOMENDACIONES'
                )
                ->orderBy('cr.ID_RECOMENDACIONES', 'ASC')
                ->get();

            $textoRecomendaciones = '';

            foreach ($recomendaciones as $recomendacion) {

                if (empty(trim($recomendacion->DESCRIPCION_RECOMENDACIONES ?? ''))) {
                    continue;
                }

                $descripcion = htmlspecialchars(
                    trim($recomendacion->DESCRIPCION_RECOMENDACIONES),
                    ENT_XML1 | ENT_COMPAT,
                    'UTF-8'
                );

                $textoRecomendaciones .=
                    '<w:p>
            <w:pPr>
                <w:pStyle w:val="Normal"/>
                <w:ind w:left="360"/>
            </w:pPr>
            <w:r>
                <w:rPr>
                    <w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t xml:space="preserve">• </w:t>
            </w:r>
            <w:r>
                <w:rPr>
                    <w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/>
                    <w:sz w:val="24"/>
                </w:rPr>
                <w:t xml:space="preserve">' . $descripcion . '</w:t>
            </w:r>
        </w:p>';
            }

            if ($textoRecomendaciones === '') {
                $textoRecomendaciones = 'No cargado';
            }

            $plantillaword->setValue('RECOMENDACIONES', $textoRecomendaciones);


            //// RESPONSABLE 1
            if ($datosGenerales2->INFORME_RESPONSABLE1DOCUMENTO) {
                if (
                    file_exists(
                        storage_path('app/' . $datosGenerales2->INFORME_RESPONSABLE1DOCUMENTO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'REPONSABLE1_DOCUMENTO',
                        array(
                            'path' => storage_path('app/' . $datosGenerales2->INFORME_RESPONSABLE1DOCUMENTO),
                            'height' => 300,
                            'width' => 580,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )
                    );
                } else {
                    $plantillaword->setValue('REPONSABLE1_DOCUMENTO', 'FALTA CARGAR IMAGEN DESDE EL SISTEMA.');
                }
            } else {
                $plantillaword->setValue('REPONSABLE1_DOCUMENTO', 'FALTA CARGAR IMAGEN DESDE EL SISTEMA.');
            }


            $plantillaword->setValue(
                'REPONSABLE1',
                htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE1 ? $datosGenerales2->INFORME_RESPONSABLE1 : 'No cargado'))
                    .
                    '</w:t><w:br/><w:t>'
                    .
                    htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE1CARGO ? $datosGenerales2->INFORME_RESPONSABLE1CARGO : 'No cargado'))
            );


            //// RESPONSABLE 2
            if ($datosGenerales2->INFORME_RESPONSABLE2DOCUMENTO) {
                if (
                    file_exists(
                        storage_path('app/' . $datosGenerales2->INFORME_RESPONSABLE2DOCUMENTO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'REPONSABLE2_DOCUMENTO',
                        array(
                            'path' => storage_path('app/' . $datosGenerales2->INFORME_RESPONSABLE2DOCUMENTO),
                            'height' => 300,
                            'width' => 580,
                            'ratio' => true,
                            'borderColor' => '000000'
                        )
                    );
                } else {
                    $plantillaword->setValue('REPONSABLE2_DOCUMENTO', 'FALTA CARGAR IMAGEN DESDE EL SISTEMA.');
                }
            } else {
                $plantillaword->setValue(
                    'REPONSABLE2_DOCUMENTO',
                    'FALTA CARGAR IMAGEN DESDE EL SISTEMA.'
                );
            }

            $plantillaword->setValue(
                'REPONSABLE2',
                htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE2 ? $datosGenerales2->INFORME_RESPONSABLE2 : 'No cargado'))
                    .
                    '</w:t><w:br/><w:t>'
                    .
                    htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE2CARGO ? $datosGenerales2->INFORME_RESPONSABLE2CARGO : 'No cargado'))
            );






            ///  RESULTADOS DE LA APLICACION 



            $evaluacionesFre_7_2 = DB::table('evaluacion_fre_ergo as evaluacion')

                ->leftJoin(

                    'recoergocategorias as categoria',

                    'categoria.ID_CATEGORIA_ERGO',

                    '=',

                    'evaluacion.CATEGORIA_ID_FRE'

                )

                ->where('evaluacion.RECO_ID', $RECO_ID)

                ->select(

                    'evaluacion.*',

                    'categoria.NOMBRE_CATEGORIA_ERGO'

                )

                ->orderBy('evaluacion.ID_EVALUACION_FRE', 'ASC')

                ->get();







            $categoriasFre_7_2 = DB::table('recoergocategorias')

                ->pluck('NOMBRE_CATEGORIA_ERGO', 'ID_CATEGORIA_ERGO')

                ->toArray();





            $areasFre_7_2 = DB::table('recoergoareas')

                ->pluck('NOMBRE_AREA_ERGO', 'ID_AREA_ERGO')

                ->toArray();





            $turnosFre_7_2 = DB::table('catergo_turno')

                ->pluck('NOMBRE_TURNO', 'ID_TURNO')

                ->toArray();





            $catalogoEppFre_7_2 = DB::table('cat_claveyepp')

                ->pluck('EPP', 'ID_CLAVE_EPP')

                ->toArray();







            $idsFichasFre_7_2 = $evaluacionesFre_7_2

                ->pluck('FICHA_ID')

                ->filter()

                ->unique()

                ->values()

                ->all();





            $fichasFre_7_2 = collect();





            if (!empty($idsFichasFre_7_2)) {



                $fichasFre_7_2 = DB::table('recoergo_fichastecnicas')

                    ->whereIn(

                        'ID_FICHAS_TECNICAS',

                        $idsFichasFre_7_2

                    )

                    ->get()

                    ->keyBy('ID_FICHAS_TECNICAS');
            }









            $estiloEtiquetaFre_7_2 = [

                'name' => 'Poppins',

                'size' => 10,

                'bold' => true,

                'color' => 'FFFFFF',

            ];





            $estiloValorFre_7_2 = [

                'name' => 'Poppins',

                'size' => 10,

                'color' => '000000',

            ];





            $estiloCeldaEtiquetaFre_7_2 = [

                'bgColor' => '12466A',

                'valign' => 'center',

                'borderSize' => 6,

                'borderColor' => '000000',

            ];





            $estiloCeldaValorFre_7_2 = [

                'valign' => 'center',

                'borderSize' => 6,

                'borderColor' => '000000',

            ];





            $estiloTituloAngulosFre_7_2 = [

                'name' => 'Poppins',

                'size' => 10,

                'bold' => true,

                'color' => 'FFFFFF',

            ];





            $estiloTextoAngulosFre_7_2 = [

                'name' => 'Poppins',

                'size' => 9,

                'color' => '000000',

            ];





            $estiloCeldaTituloAngulosFre_7_2 = [

                'bgColor' => '12466A',

                'valign' => 'center',

                'borderSize' => 6,

                'borderColor' => '000000',

            ];





            $estiloCeldaAngulosFre_7_2 = [

                'valign' => 'center',

                'borderSize' => 6,

                'borderColor' => '000000',

            ];









            $agregarFilaResultadoFre_7_2 = function (

                $tablaFre_7_2,

                $etiquetaFre_7_2,

                $valorFre_7_2

            ) use (

                $estiloEtiquetaFre_7_2,

                $estiloValorFre_7_2,

                $estiloCeldaEtiquetaFre_7_2,

                $estiloCeldaValorFre_7_2

            ) {



                $tablaFre_7_2->addRow();



                $tablaFre_7_2->addCell(

                    3400,

                    $estiloCeldaEtiquetaFre_7_2

                )->addText(

                    (string) $etiquetaFre_7_2,

                    $estiloEtiquetaFre_7_2

                );





                $valorFre_7_2 = is_scalar($valorFre_7_2)

                    ? trim((string) $valorFre_7_2)

                    : '';





                $tablaFre_7_2->addCell(

                    7900,

                    $estiloCeldaValorFre_7_2

                )->addText(

                    $valorFre_7_2 !== '' ? $valorFre_7_2 : ' ',

                    $estiloValorFre_7_2

                );
            };









            $tablasDatosFre_7_2 = [];
            $tablasAngulosFre_7_2 = [];
            $tablasMetodosFre_7_2 = [];
            $bloquesMetodosXmlFre_7_2 = [];
            $imagenesAngulosFre_7_2 = [];



            $imagenesAngulosFre_7_2 = [];





            foreach (

                $evaluacionesFre_7_2 as $indiceFre_7_2 => $evaluacionFre_7_2

            ) {





                $tablaDatosFre_7_2 = new \PhpOffice\PhpWord\Element\Table([

                    'borderSize' => 6,

                    'borderColor' => '000000',

                    'cellMargin' => 80,

                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,

                ]);



                $categoriaFre_7_2 = isset(

                    $categoriasFre_7_2[$evaluacionFre_7_2->CATEGORIA_ID_FRE]

                )

                    ? $categoriasFre_7_2[$evaluacionFre_7_2->CATEGORIA_ID_FRE]

                    : '';





                $fichaFre_7_2 = $fichasFre_7_2->get(

                    $evaluacionFre_7_2->FICHA_ID

                );







                $nombresAreasFre_7_2 = [];





                if (

                    $fichaFre_7_2 &&

                    !empty($fichaFre_7_2->CAT_AREAS_FICHA)

                ) {



                    $idsAreasFre_7_2 = json_decode(

                        $fichaFre_7_2->CAT_AREAS_FICHA,

                        true

                    );





                    if (is_array($idsAreasFre_7_2)) {



                        foreach (

                            $idsAreasFre_7_2 as $idAreaFre_7_2

                        ) {



                            $idAreaFre_7_2 = (string) $idAreaFre_7_2;





                            if (

                                isset(

                                    $areasFre_7_2[$idAreaFre_7_2]

                                )

                            ) {



                                $nombresAreasFre_7_2[] =

                                    $areasFre_7_2[$idAreaFre_7_2];
                            }
                        }
                    }
                }





                $nombreAreaFre_7_2 = implode(

                    ', ',

                    array_unique($nombresAreasFre_7_2)

                );







                $nombresTurnosFre_7_2 = [];





                if (

                    $fichaFre_7_2 &&

                    !empty($fichaFre_7_2->TURNO_EMPLEADO_FICHA)

                ) {



                    $idsTurnosFre_7_2 = json_decode(

                        $fichaFre_7_2->TURNO_EMPLEADO_FICHA,

                        true

                    );





                    if (is_array($idsTurnosFre_7_2)) {



                        foreach (

                            $idsTurnosFre_7_2 as $idTurnoFre_7_2

                        ) {



                            $idTurnoFre_7_2 = (string) $idTurnoFre_7_2;





                            if (

                                isset(

                                    $turnosFre_7_2[$idTurnoFre_7_2]

                                )

                            ) {



                                $nombresTurnosFre_7_2[] =

                                    $turnosFre_7_2[$idTurnoFre_7_2];
                            }
                        }
                    }
                }





                $nombreTurnoFre_7_2 = implode(

                    ', ',

                    array_unique($nombresTurnosFre_7_2)

                );





                $dominanciaFre_7_2 = '';





                if (

                    (string) $evaluacionFre_7_2->TIPO_DOMINANCIA === '1'

                ) {



                    $dominanciaFre_7_2 = 'Derecha';
                } elseif (

                    (string) $evaluacionFre_7_2->TIPO_DOMINANCIA === '2'

                ) {



                    $dominanciaFre_7_2 = 'Izquierda';
                }





                $eppEncontradoFre_7_2 = [];





                $jsonEppFre_7_2 = isset(

                    $evaluacionFre_7_2->JSON_EPP

                )

                    ? trim((string) $evaluacionFre_7_2->JSON_EPP)

                    : '';





                if ($jsonEppFre_7_2 !== '') {



                    $datosEppFre_7_2 = json_decode(

                        $jsonEppFre_7_2,

                        true

                    );





                    if (is_array($datosEppFre_7_2)) {



                        foreach (

                            $datosEppFre_7_2 as $elementoEppFre_7_2

                        ) {



                            if (

                                !is_array($elementoEppFre_7_2) ||

                                !isset($elementoEppFre_7_2['clave'])

                            ) {



                                continue;
                            }





                            $claveEppFre_7_2 =

                                (string) $elementoEppFre_7_2['clave'];





                            if (

                                isset(

                                    $catalogoEppFre_7_2[$claveEppFre_7_2]

                                ) &&

                                trim(

                                    (string) $catalogoEppFre_7_2[$claveEppFre_7_2]

                                ) !== ''

                            ) {



                                $eppEncontradoFre_7_2[] = trim(

                                    (string) $catalogoEppFre_7_2[$claveEppFre_7_2]

                                );
                            }
                        }
                    }
                }





                $eppEncontradoFre_7_2 = array_values(

                    array_unique($eppEncontradoFre_7_2)

                );





                $hayEppFre_7_2 = !empty($eppEncontradoFre_7_2);





                $nombreEppFre_7_2 = implode(

                    ', ',

                    $eppEncontradoFre_7_2

                );





                $recomendacionEppFre_7_2 = isset(

                    $evaluacionFre_7_2->RECOMENDACIONES_EPP

                )

                    ? trim(

                        (string) $evaluacionFre_7_2->RECOMENDACIONES_EPP

                    )

                    : '';





                $recomendacionNormalizadaFre_7_2 = mb_strtoupper(

                    $recomendacionEppFre_7_2,

                    'UTF-8'

                );





                $mostrarRecomendacionEppFre_7_2 =

                    $hayEppFre_7_2 &&

                    $recomendacionEppFre_7_2 !== '' &&

                    !in_array(

                        $recomendacionNormalizadaFre_7_2,

                        ['NA', 'N.A', 'N/A'],

                        true

                    );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Nombre del empleado',

                    isset(

                        $evaluacionFre_7_2->NOMBRE_EMPLEADO_FRE

                    )

                        ? $evaluacionFre_7_2->NOMBRE_EMPLEADO_FRE

                        : ''

                );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Categoría',

                    $categoriaFre_7_2

                );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Área',

                    $nombreAreaFre_7_2

                );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Turno',

                    $nombreTurnoFre_7_2

                );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Pausas de descanso que toma durante la jornada de trabajo (Mencione cuántas y duración en minutos)',

                    isset(

                        $evaluacionFre_7_2->PAUSAS_DESCANSO

                    )

                        ? $evaluacionFre_7_2->PAUSAS_DESCANSO

                        : ''

                );





                $agregarFilaResultadoFre_7_2(

                    $tablaDatosFre_7_2,

                    'Dominancia Manual',

                    $dominanciaFre_7_2

                );



                if ($hayEppFre_7_2) {



                    $agregarFilaResultadoFre_7_2(

                        $tablaDatosFre_7_2,

                        'EPP',

                        $nombreEppFre_7_2

                    );





                    if ($mostrarRecomendacionEppFre_7_2) {



                        $agregarFilaResultadoFre_7_2(

                            $tablaDatosFre_7_2,

                            'Recomendación EPP',

                            $recomendacionEppFre_7_2

                        );
                    }
                }








                $tablasDatosFre_7_2[$indiceFre_7_2] =

                    $tablaDatosFre_7_2;

                $metodosSeleccionadosFre_7_2 = [];
                $jsonMetodosFre_7_2 = isset($evaluacionFre_7_2->CAT_METODOS_FRE)
                    ? $evaluacionFre_7_2->CAT_METODOS_FRE
                    : '';

                if (is_array($jsonMetodosFre_7_2)) {
                    $metodosSeleccionadosFre_7_2 = $jsonMetodosFre_7_2;
                } elseif (is_string($jsonMetodosFre_7_2) && trim($jsonMetodosFre_7_2) !== '') {
                    $metodosSeleccionadosFre_7_2 = json_decode($jsonMetodosFre_7_2, true);
                    if (!is_array($metodosSeleccionadosFre_7_2)) {
                        $metodosSeleccionadosFre_7_2 = array_filter(array_map('trim', explode(',', $jsonMetodosFre_7_2)));
                    }
                }

                $metodosNormalizadosFre_7_2 = [];
                foreach ($metodosSeleccionadosFre_7_2 as $metodoFre_7_2) {
                    if (is_array($metodoFre_7_2)) {
                        $metodoFre_7_2 = isset($metodoFre_7_2['id']) ? $metodoFre_7_2['id'] : (isset($metodoFre_7_2['value']) ? $metodoFre_7_2['value'] : '');
                    }
                    if (!is_scalar($metodoFre_7_2)) {
                        continue;
                    }
                    $metodoFre_7_2 = trim((string) $metodoFre_7_2);
                    if (in_array($metodoFre_7_2, ['1', '2', '3'], true)) {
                        $metodosNormalizadosFre_7_2[] = $metodoFre_7_2;
                    } else {
                        $metodoMayusculaFre_7_2 = mb_strtoupper($metodoFre_7_2, 'UTF-8');
                        if (strpos($metodoMayusculaFre_7_2, 'OWAS') !== false) {
                            $metodosNormalizadosFre_7_2[] = '1';
                        } elseif (strpos($metodoMayusculaFre_7_2, 'ROSA') !== false) {
                            $metodosNormalizadosFre_7_2[] = '2';
                        } elseif (strpos($metodoMayusculaFre_7_2, 'RULA') !== false) {
                            $metodosNormalizadosFre_7_2[] = '3';
                        }
                    }
                }
                $metodosNormalizadosFre_7_2 = array_values(array_unique($metodosNormalizadosFre_7_2));

                $escaparXmlFre_7_2 = function ($valorFre_7_2) {
                    if (!is_scalar($valorFre_7_2) && $valorFre_7_2 !== null) {
                        $valorFre_7_2 = '';
                    }
                    return htmlspecialchars((string) $valorFre_7_2, ENT_QUOTES | ENT_XML1, 'UTF-8');
                };

                $parrafoXmlFre_7_2 = function ($textoFre_7_2, $negritaFre_7_2 = false, $tamanoFre_7_2 = 20, $antesFre_7_2 = 80, $despuesFre_7_2 = 60) use ($escaparXmlFre_7_2) {
                    $boldFre_7_2 = $negritaFre_7_2 ? '<w:b/><w:bCs/>' : '';
                    return '<w:p><w:pPr><w:spacing w:before="' . (int) $antesFre_7_2 . '" w:after="' . (int) $despuesFre_7_2 . '"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="' . (int) $tamanoFre_7_2 . '"/><w:szCs w:val="' . (int) $tamanoFre_7_2 . '"/>' . $boldFre_7_2 . '</w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($textoFre_7_2) . '</w:t></w:r></w:p>';
                };

                $tablaXmlFre_7_2 = function ($tituloFre_7_2, $encabezadosFre_7_2, $filasFre_7_2, $anchosFre_7_2, $columnaColorFre_7_2, $filaSeleccionadaFre_7_2) use ($escaparXmlFre_7_2) {
                    $factorAnchoFre_7_2 = 1.0;
                    $anchosFre_7_2 = array_map(function ($a) {
                        return (int) round($a * 1.0);
                    }, $anchosFre_7_2);
                    $anchoTotalFre_7_2 = array_sum($anchosFre_7_2);
                    $xmlFre_7_2 = '<w:tbl><w:tblPr><w:tblW w:w="' . $anchoTotalFre_7_2 . '" w:type="dxa"/><w:jc w:val="center"/><w:tblBorders><w:top w:val="single" w:sz="6" w:color="000000"/><w:left w:val="single" w:sz="6" w:color="000000"/><w:bottom w:val="single" w:sz="6" w:color="000000"/><w:right w:val="single" w:sz="6" w:color="000000"/><w:insideH w:val="single" w:sz="6" w:color="000000"/><w:insideV w:val="single" w:sz="6" w:color="000000"/></w:tblBorders><w:tblLayout w:type="fixed"/><w:tblCellMar><w:top w:w="65" w:type="dxa"/><w:left w:w="70" w:type="dxa"/><w:bottom w:w="65" w:type="dxa"/><w:right w:w="70" w:type="dxa"/></w:tblCellMar></w:tblPr><w:tblGrid>';
                    foreach ($anchosFre_7_2 as $anchoFre_7_2) {
                        $xmlFre_7_2 .= '<w:gridCol w:w="' . (int) $anchoFre_7_2 . '"/>';
                    }
                    $xmlFre_7_2 .= '</w:tblGrid><w:tr><w:trPr><w:cantSplit/></w:trPr><w:tc><w:tcPr><w:tcW w:w="' . $anchoTotalFre_7_2 . '" w:type="dxa"/><w:gridSpan w:val="' . count($anchosFre_7_2) . '"/><w:shd w:val="clear" w:fill="A6D96A"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:bCs/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>' . $escaparXmlFre_7_2($tituloFre_7_2) . '</w:t></w:r></w:p></w:tc></w:tr>';
                    $filasCompletoFre_7_2 = [$encabezadosFre_7_2];
                    foreach ($filasFre_7_2 as $filaFre_7_2) {
                        $filasCompletoFre_7_2[] = $filaFre_7_2;
                    }
                    foreach ($filasCompletoFre_7_2 as $iFre_7_2 => $filaFre_7_2) {
                        $esEncabezadoFre_7_2 = $iFre_7_2 === 0;
                        $indiceDatoFre_7_2 = $iFre_7_2 - 1;
                        $xmlFre_7_2 .= '<w:tr><w:trPr><w:cantSplit/></w:trPr>';
                        foreach ($anchosFre_7_2 as $jFre_7_2 => $anchoFre_7_2) {
                            $textoFre_7_2 = isset($filaFre_7_2[$jFre_7_2]) ? $filaFre_7_2[$jFre_7_2] : '';
                            $fondoFre_7_2 = $esEncabezadoFre_7_2 ? '287DB5' : 'FFFFFF';
                            $colorTextoFre_7_2 = $esEncabezadoFre_7_2 ? 'FFFFFF' : '000000';
                            $negritaFre_7_2 = $esEncabezadoFre_7_2;
                            if (!$esEncabezadoFre_7_2 && isset($filaFre_7_2['_color'])) {
                                $columnaFondoFre_7_2 = isset($filaFre_7_2['_color_col']) ? (int) $filaFre_7_2['_color_col'] : (int) $columnaColorFre_7_2;
                                if ($jFre_7_2 === $columnaFondoFre_7_2) {
                                    $fondoFre_7_2 = strtoupper((string) $filaFre_7_2['_color']);
                                    $colorTextoFre_7_2 = in_array($fondoFre_7_2, ['009944', 'FF0000', 'FF4D00'], true) ? 'FFFFFF' : '000000';
                                }
                            }
                            $celdaResultadoMarcadaFre_7_2 = (!$esEncabezadoFre_7_2 && $filaSeleccionadaFre_7_2 !== null && $indiceDatoFre_7_2 === $filaSeleccionadaFre_7_2 && $jFre_7_2 === $columnaColorFre_7_2);
                            $bordeResultadoFre_7_2 = $celdaResultadoMarcadaFre_7_2 ? '<w:tcBorders><w:top w:val="single" w:sz="24" w:color="FF0000"/><w:left w:val="single" w:sz="24" w:color="FF0000"/><w:bottom w:val="single" w:sz="24" w:color="FF0000"/><w:right w:val="single" w:sz="24" w:color="FF0000"/></w:tcBorders>' : '';
                            if ($celdaResultadoMarcadaFre_7_2) {
                                $negritaFre_7_2 = true;
                            }
                            $boldFre_7_2 = $negritaFre_7_2 ? '<w:b/><w:bCs/>' : '';
                            $alineacionFre_7_2 = $esEncabezadoFre_7_2 || $jFre_7_2 === 0 ? 'center' : 'left';
                            $xmlFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . (int) $anchoFre_7_2 . '" w:type="dxa"/>' . $bordeResultadoFre_7_2 . '<w:shd w:val="clear" w:fill="' . $fondoFre_7_2 . '"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="' . $alineacionFre_7_2 . '"/><w:spacing w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="20"/><w:szCs w:val="20"/><w:color w:val="' . $colorTextoFre_7_2 . '"/>' . $boldFre_7_2 . '</w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($textoFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                        }
                        $xmlFre_7_2 .= '</w:tr>';
                    }
                    return $xmlFre_7_2 . '</w:tbl><w:p><w:pPr><w:spacing w:after="0"/></w:pPr><w:r><w:t xml:space="preserve"> </w:t></w:r></w:p>';
                };

                $matrizOwasFre_7_2 = [
                    1 => [1 => [1 => [1, 1, 1], 2 => [1, 1, 1], 3 => [1, 1, 1], 4 => [2, 2, 2], 5 => [2, 2, 2], 6 => [1, 1, 1], 7 => [1, 1, 1]], 2 => [1 => [1, 1, 1], 2 => [1, 1, 1], 3 => [1, 1, 1], 4 => [2, 2, 2], 5 => [2, 2, 2], 6 => [1, 1, 1], 7 => [1, 1, 1]], 3 => [1 => [1, 1, 1], 2 => [1, 1, 1], 3 => [1, 1, 1], 4 => [2, 2, 3], 5 => [2, 2, 3], 6 => [1, 1, 1], 7 => [1, 1, 2]]],
                    2 => [1 => [1 => [2, 2, 3], 2 => [2, 2, 3], 3 => [2, 2, 3], 4 => [3, 3, 3], 5 => [3, 3, 3], 6 => [2, 2, 2], 7 => [3, 3, 3]], 2 => [1 => [2, 2, 3], 2 => [2, 2, 3], 3 => [2, 3, 3], 4 => [3, 4, 4], 5 => [3, 4, 3], 6 => [3, 3, 4], 7 => [2, 3, 4]], 3 => [1 => [3, 3, 4], 2 => [2, 2, 3], 3 => [3, 3, 3], 4 => [3, 4, 4], 5 => [4, 4, 4], 6 => [4, 4, 4], 7 => [2, 3, 4]]],
                    3 => [1 => [1 => [1, 1, 1], 2 => [1, 1, 1], 3 => [1, 1, 2], 4 => [3, 3, 3], 5 => [4, 4, 4], 6 => [1, 1, 1], 7 => [1, 1, 1]], 2 => [1 => [2, 2, 3], 2 => [1, 1, 1], 3 => [1, 1, 2], 4 => [4, 4, 4], 5 => [4, 4, 4], 6 => [3, 3, 3], 7 => [1, 1, 1]], 3 => [1 => [2, 2, 3], 2 => [1, 1, 1], 3 => [2, 3, 3], 4 => [4, 4, 4], 5 => [4, 4, 4], 6 => [4, 4, 4], 7 => [1, 1, 1]]],
                    4 => [1 => [1 => [2, 3, 3], 2 => [2, 2, 3], 3 => [2, 2, 3], 4 => [4, 4, 4], 5 => [4, 4, 4], 6 => [4, 4, 4], 7 => [2, 3, 4]], 2 => [1 => [3, 3, 4], 2 => [2, 3, 4], 3 => [3, 3, 4], 4 => [4, 4, 4], 5 => [4, 4, 4], 6 => [4, 4, 4], 7 => [2, 3, 4]], 3 => [1 => [4, 4, 4], 2 => [2, 3, 4], 3 => [3, 3, 4], 4 => [4, 4, 4], 5 => [4, 4, 4], 6 => [4, 4, 4], 7 => [2, 3, 4]]]
                ];

                $categoriaOwasFre_7_2 = null;
                $espaldaOwasFre_7_2 = isset($evaluacionFre_7_2->OWAS_ESPALDA) ? (int) $evaluacionFre_7_2->OWAS_ESPALDA : 0;
                $brazosOwasFre_7_2 = isset($evaluacionFre_7_2->OWAS_BRAZOS) ? (int) $evaluacionFre_7_2->OWAS_BRAZOS : 0;
                $piernasOwasFre_7_2 = isset($evaluacionFre_7_2->OWAS_PIERNAS) ? (int) $evaluacionFre_7_2->OWAS_PIERNAS : 0;
                $cargaOwasFre_7_2 = isset($evaluacionFre_7_2->OWAS_CARGA) ? (int) $evaluacionFre_7_2->OWAS_CARGA : 0;
                if (isset($matrizOwasFre_7_2[$espaldaOwasFre_7_2][$brazosOwasFre_7_2][$piernasOwasFre_7_2][$cargaOwasFre_7_2 - 1])) {
                    $categoriaOwasFre_7_2 = $matrizOwasFre_7_2[$espaldaOwasFre_7_2][$brazosOwasFre_7_2][$piernasOwasFre_7_2][$cargaOwasFre_7_2 - 1];
                }

                $datosRosaFre_7_2 = [];
                $jsonRosaFre_7_2 = isset($evaluacionFre_7_2->ROSA_DATOS_JSON) ? $evaluacionFre_7_2->ROSA_DATOS_JSON : '';
                if (is_array($jsonRosaFre_7_2)) {
                    $datosRosaFre_7_2 = $jsonRosaFre_7_2;
                } elseif (is_string($jsonRosaFre_7_2) && trim($jsonRosaFre_7_2) !== '') {
                    $datosRosaFre_7_2 = json_decode($jsonRosaFre_7_2, true);
                }
                $buscarPuntuacionRosaFre_7_2 = function ($datos) use (&$buscarPuntuacionRosaFre_7_2) {
                    if (!is_array($datos)) return null;
                    foreach (['puntuacion_final', 'puntuacionFinal', 'resultadoE', 'resultado_final', 'resultadoFinal', 'resultado'] as $k) {
                        if (isset($datos[$k]) && is_numeric($datos[$k])) return (int) $datos[$k];
                    }
                    foreach ($datos as $v) {
                        if (is_array($v)) {
                            $encontrado = $buscarPuntuacionRosaFre_7_2($v);
                            if ($encontrado !== null) return $encontrado;
                        }
                    }
                    return null;
                };
                $resultadoRosaFre_7_2 = $buscarPuntuacionRosaFre_7_2($datosRosaFre_7_2);

                // Si ROSA_DATOS_JSON solo contiene {"extras":[]} o no tiene resultado,
                // calcular ROSA desde los campos guardados, usando las mismas matrices del JS.
                if ($resultadoRosaFre_7_2 === null) {
                    $matricesRosaFre_7_2 = [
                        'A' => [
                            [2, 2, 3, 4, 5, 6, 7, 8],
                            [2, 2, 3, 4, 5, 6, 7, 8],
                            [3, 3, 3, 4, 5, 6, 7, 8],
                            [4, 4, 4, 4, 5, 6, 7, 8],
                            [5, 5, 5, 5, 6, 7, 8, 9],
                            [6, 6, 6, 6, 7, 8, 8, 9],
                            [7, 7, 7, 7, 8, 9, 9, 9]
                        ],
                        'B' => [
                            [1, 1, 1, 2, 3, 4, 5, 6, 6],
                            [1, 1, 2, 2, 3, 4, 5, 6, 6],
                            [1, 2, 2, 3, 3, 4, 6, 7, 7],
                            [2, 2, 3, 3, 4, 5, 6, 8, 8],
                            [3, 3, 4, 4, 5, 6, 7, 8, 8],
                            [4, 4, 5, 5, 6, 7, 8, 9, 9],
                            [5, 5, 6, 7, 8, 8, 9, 9, 9]
                        ],
                        'C' => [
                            [1, 1, 1, 2, 3, 4, 5],
                            [1, 1, 2, 3, 4, 5, 6],
                            [2, 3, 3, 3, 5, 6, 7],
                            [3, 4, 4, 5, 5, 6, 7],
                            [4, 5, 5, 6, 6, 7, 8],
                            [5, 6, 6, 7, 7, 8, 8],
                            [6, 7, 7, 8, 8, 9, 9],
                            [7, 8, 8, 9, 9, 9, 9]
                        ],
                        'D' => [
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
                        'E' => [
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
                    ];
                    $valorRosaFre_7_2 = function ($campo) use ($evaluacionFre_7_2) {
                        if (!isset($evaluacionFre_7_2->{$campo}) || $evaluacionFre_7_2->{$campo} === '' || !is_numeric($evaluacionFre_7_2->{$campo})) return null;
                        return (int)$evaluacionFre_7_2->{$campo};
                    };
                    $extraRosaFre_7_2 = [];
                    if (isset($datosRosaFre_7_2['extras']) && is_array($datosRosaFre_7_2['extras'])) {
                        foreach ($datosRosaFre_7_2['extras'] as $extra) {
                            if (!is_array($extra)) continue;
                            $apartado = isset($extra['apartado']) ? (string)$extra['apartado'] : '';
                            $valorExtra = isset($extra['valor']) && is_numeric($extra['valor']) ? (int)$extra['valor'] : 0;
                            if ($apartado !== '') $extraRosaFre_7_2[$apartado] = ($extraRosaFre_7_2[$apartado] ?? 0) + $valorExtra;
                        }
                    }
                    $sumarExtraRosaFre_7_2 = function ($apartado) use (&$extraRosaFre_7_2) {
                        return (int)($extraRosaFre_7_2[$apartado] ?? 0);
                    };
                    $tiempoRosaFre_7_2 = function ($campo) use ($valorRosaFre_7_2) {
                        $v = $valorRosaFre_7_2($campo);
                        return $v === null ? 0 : $v;
                    };
                    $limitarRosaFre_7_2 = function ($v, $min, $max) {
                        return max($min, min($max, $v));
                    };
                    $buscarMatrizRosaFre_7_2 = function ($matriz, $fila, $columna, $inicioFila, $inicioColumna) {
                        $f = $fila - $inicioFila;
                        $c = $columna - $inicioColumna;
                        return isset($matriz[$f][$c]) ? $matriz[$f][$c] : null;
                    };

                    $a1 = $valorRosaFre_7_2('ROSA_ALTURA_ASIENTO');
                    $a2 = $valorRosaFre_7_2('ROSA_PROFUNDIDAD_ASIENTO');
                    $a3 = $valorRosaFre_7_2('ROSA_REPOSABRAZOS');
                    $a4 = $valorRosaFre_7_2('ROSA_RESPALDO');
                    $b1 = $valorRosaFre_7_2('ROSA_TELEFONO');
                    $b2 = $valorRosaFre_7_2('ROSA_PANTALLA');
                    $c1 = $valorRosaFre_7_2('ROSA_RATON');
                    $c2 = $valorRosaFre_7_2('ROSA_TECLADO');

                    if (
                        $a1 !== null && $a2 !== null && $a3 !== null && $a4 !== null &&
                        $b1 !== null && $b2 !== null && $c1 !== null && $c2 !== null
                    ) {
                        $asiento = $limitarRosaFre_7_2($a1 + $a2, 2, 8);
                        $reposabrazosRespaldo = $limitarRosaFre_7_2($a3 + $a4, 2, 9);
                        $resultadoA = $buscarMatrizRosaFre_7_2($matricesRosaFre_7_2['A'], $asiento, $reposabrazosRespaldo, 2, 2);
                        if ($resultadoA !== null) $resultadoA = $limitarRosaFre_7_2($resultadoA + $tiempoRosaFre_7_2('ROSA_TIEMPO_A'), 1, 10);

                        $telefono = $limitarRosaFre_7_2($b1 + $sumarExtraRosaFre_7_2('B1') + $tiempoRosaFre_7_2('ROSA_TIEMPO_B1'), 0, 8);
                        $pantalla = $limitarRosaFre_7_2($b2 + $sumarExtraRosaFre_7_2('B2') + $tiempoRosaFre_7_2('ROSA_TIEMPO_B2'), 0, 8);
                        $resultadoB = $buscarMatrizRosaFre_7_2($matricesRosaFre_7_2['B'], $telefono, $pantalla, 0, 0);

                        $raton = $limitarRosaFre_7_2($c1 + $sumarExtraRosaFre_7_2('C1') + $tiempoRosaFre_7_2('ROSA_TIEMPO_C1'), 0, 6);
                        $teclado = $limitarRosaFre_7_2($c2 + $sumarExtraRosaFre_7_2('C2') + $tiempoRosaFre_7_2('ROSA_TIEMPO_C2'), 0, 6);
                        $resultadoC = $buscarMatrizRosaFre_7_2($matricesRosaFre_7_2['C'], $raton, $teclado, 0, 0);

                        $resultadoD = ($resultadoB !== null && $resultadoC !== null)
                            ? $buscarMatrizRosaFre_7_2($matricesRosaFre_7_2['D'], $resultadoB, $resultadoC, 1, 1) : null;
                        $resultadoE = ($resultadoA !== null && $resultadoD !== null)
                            ? $buscarMatrizRosaFre_7_2($matricesRosaFre_7_2['E'], $resultadoA, $resultadoD, 1, 1) : null;
                        if ($resultadoE !== null) $resultadoRosaFre_7_2 = (int)$resultadoE;
                    }
                }


                // Recalcular RULA con los mismos campos y matrices que usa calcularRULA() en JavaScript.
                $resultadoRulaFre_7_2 = null;
                $camposRulaBaseFre_7_2 = ['RULA_BRAZO', 'RULA_ANTEBRAZO', 'RULA_MUNECA', 'RULA_GIRO_MUNECA', 'RULA_CUELLO', 'RULA_TRONCO', 'RULA_PIERNAS'];
                $valoresRulaFre_7_2 = [];
                foreach ($camposRulaBaseFre_7_2 as $campo) {
                    $v = isset($evaluacionFre_7_2->{$campo}) && $evaluacionFre_7_2->{$campo} !== '' ? (int)$evaluacionFre_7_2->{$campo} : null;
                    $valoresRulaFre_7_2[$campo] = $v;
                }
                if (!in_array(null, $valoresRulaFre_7_2, true)) {
                    $extraRulaFre_7_2 = function ($campo) use ($evaluacionFre_7_2) {
                        return isset($evaluacionFre_7_2->{$campo}) && is_numeric($evaluacionFre_7_2->{$campo}) ? (int)$evaluacionFre_7_2->{$campo} : 0;
                    };
                    $limitarRulaFre_7_2 = function ($v, $min, $max) {
                        return max($min, min($max, $v));
                    };
                    $brazoR = $limitarRulaFre_7_2($valoresRulaFre_7_2['RULA_BRAZO'] + $extraRulaFre_7_2('RULA_BRAZO_ABDUCIDO') + $extraRulaFre_7_2('RULA_HOMBRO_ELEVADO') + $extraRulaFre_7_2('RULA_BRAZO_APOYADO'), 1, 6);
                    $antebrazoR = $limitarRulaFre_7_2($valoresRulaFre_7_2['RULA_ANTEBRAZO'] + $extraRulaFre_7_2('RULA_ANTEBRAZO_PROYECCION') + $extraRulaFre_7_2('RULA_ANTEBRAZO_CRUZA'), 1, 3);
                    $munecaR = $limitarRulaFre_7_2($valoresRulaFre_7_2['RULA_MUNECA'] + $extraRulaFre_7_2('RULA_MUNECA_DESVIACION'), 1, 4);
                    $indiceAR = (($munecaR - 1) * 2) + ($valoresRulaFre_7_2['RULA_GIRO_MUNECA'] - 1);
                    $tablaAR = ['1-1' => [1, 2, 2, 2, 2, 3, 3, 3], '1-2' => [2, 2, 2, 2, 3, 3, 3, 3], '1-3' => [2, 3, 3, 3, 3, 3, 4, 4], '2-1' => [2, 3, 3, 3, 3, 4, 4, 4], '2-2' => [3, 3, 3, 3, 3, 4, 4, 4], '2-3' => [3, 4, 4, 4, 4, 4, 5, 5], '3-1' => [3, 3, 4, 4, 4, 4, 5, 5], '3-2' => [3, 4, 4, 4, 4, 4, 5, 5], '3-3' => [4, 4, 4, 4, 4, 5, 5, 5], '4-1' => [4, 4, 4, 4, 4, 5, 5, 5], '4-2' => [4, 4, 4, 4, 4, 5, 5, 5], '4-3' => [4, 4, 4, 5, 5, 5, 6, 6], '5-1' => [5, 5, 5, 5, 5, 6, 6, 7], '5-2' => [5, 6, 6, 6, 6, 7, 7, 7], '5-3' => [6, 6, 6, 7, 7, 7, 7, 8], '6-1' => [7, 7, 7, 7, 7, 8, 8, 9], '6-2' => [8, 8, 8, 8, 8, 9, 9, 9], '6-3' => [9, 9, 9, 9, 9, 9, 9, 9]];
                    $cuelloR = $limitarRulaFre_7_2($valoresRulaFre_7_2['RULA_CUELLO'] + $extraRulaFre_7_2('RULA_CUELLO_ROTADO') + $extraRulaFre_7_2('RULA_CUELLO_LATERAL'), 1, 6);
                    $troncoR = $limitarRulaFre_7_2($valoresRulaFre_7_2['RULA_TRONCO'] + $extraRulaFre_7_2('RULA_TRONCO_TORSION') + $extraRulaFre_7_2('RULA_TRONCO_LATERAL'), 1, 6);
                    $piernasR = $valoresRulaFre_7_2['RULA_PIERNAS'];
                    $tablaBR = [1 => [1 => [1, 3], 2 => [2, 3], 3 => [3, 4], 4 => [5, 5], 5 => [6, 6], 6 => [7, 7]], 2 => [1 => [2, 3], 2 => [2, 3], 3 => [4, 5], 4 => [5, 5], 5 => [6, 7], 6 => [7, 7]], 3 => [1 => [3, 3], 2 => [3, 4], 3 => [4, 5], 4 => [5, 6], 5 => [6, 7], 6 => [7, 7]], 4 => [1 => [5, 5], 2 => [5, 6], 3 => [6, 7], 4 => [7, 7], 5 => [7, 7], 6 => [8, 8]], 5 => [1 => [7, 7], 2 => [7, 7], 3 => [7, 8], 4 => [8, 8], 5 => [8, 8], 6 => [8, 8]], 6 => [1 => [8, 8], 2 => [8, 8], 3 => [8, 8], 4 => [8, 9], 5 => [9, 9], 6 => [9, 9]]];
                    $tablaFinalR = [[1, 2, 3, 3, 4, 5, 5], [2, 2, 3, 4, 4, 5, 5], [2, 3, 3, 4, 4, 5, 6], [3, 3, 3, 4, 5, 6, 6], [4, 4, 4, 5, 6, 7, 7], [4, 4, 5, 6, 6, 7, 7], [5, 5, 5, 6, 7, 7, 7], [5, 6, 6, 7, 7, 7, 7]];
                    if (isset($tablaAR[$brazoR . '-' . $antebrazoR][$indiceAR], $tablaBR[$cuelloR][$troncoR][$piernasR - 1])) {
                        $actividadR = $extraRulaFre_7_2('RULA_ACTIVIDAD');
                        $cargaR = $extraRulaFre_7_2('RULA_CARGA');
                        $puntuacionAR = $limitarRulaFre_7_2($tablaAR[$brazoR . '-' . $antebrazoR][$indiceAR] + $actividadR + $cargaR, 1, 8);
                        $puntuacionBR = $limitarRulaFre_7_2($tablaBR[$cuelloR][$troncoR][$piernasR - 1] + $actividadR + $cargaR, 1, 8);
                        $resultadoRulaFre_7_2 = $tablaFinalR[$puntuacionBR - 1][$limitarRulaFre_7_2($puntuacionAR, 1, 7) - 1] ?? null;
                    }
                }

                $configuracionMetodosFre_7_2 = [
                    '1' => [
                        'nombre' => 'OWAS',
                        'encabezados' => ['Categoría de Riesgo', 'Efecto de la postura', 'Acción requerida'],
                        'filas' => [
                            ['1', 'Postura normal y natural sin efectos dañinos en el sistema músculo-esquelético.', 'No requiere acción.', '_color' => '9CCC7A'],
                            ['2', 'Postura con posibilidad de causar daño al sistema músculo-esquelético.', 'Se requieren acciones correctivas en un futuro cercano.', '_color' => 'FFF000'],
                            ['3', 'Postura con efectos dañinos sobre el sistema músculo-esquelético.', 'Se requieren acciones correctivas lo antes posible.', '_color' => 'F9A12A'],
                            ['4', 'La carga causada por esta postura tiene efectos sumamente dañinos sobre el sistema músculo-esquelético.', 'Se requieren tomar acciones correctivas inmediatamente.', '_color' => 'EF3340']
                        ],
                        'anchos' => [2200, 5200, 3900],
                        'colorColumna' => 0,
                        'resultado' => $categoriaOwasFre_7_2,
                        'analisis' => isset($evaluacionFre_7_2->ANALISIS_METODO_OWAS) ? $evaluacionFre_7_2->ANALISIS_METODO_OWAS : ''
                    ],
                    '2' => [
                        'nombre' => 'ROSA',
                        'encabezados' => ['Puntuación', 'Riesgo', 'Nivel', 'Actuación'],
                        'filas' => [
                            ['1', 'Inapreciable', '0', 'No es necesaria actuación.', '_color' => 'A6D96A'],
                            ['2-3-4', 'Mejorable', '1', 'Pueden mejorarse algunos elementos del puesto.', '_color' => '00B878'],
                            ['5', 'Alto', '2', 'Es necesaria la actuación.', '_color' => 'FFF000'],
                            ['6-7-8', 'Muy Alto', '3', 'Es necesaria la actuación cuanto antes.', '_color' => 'F9A12A'],
                            ['9-10', 'Extremo', '4', 'Es necesaria la actuación urgentemente.', '_color' => 'E93645']
                        ],
                        'anchos' => [1600, 2300, 1300, 6100],
                        'colorColumna' => 2,
                        'resultado' => $resultadoRosaFre_7_2,
                        'analisis' => isset($evaluacionFre_7_2->ANALISIS_METODO_ROSA) ? $evaluacionFre_7_2->ANALISIS_METODO_ROSA : ''
                    ],
                    '3' => [
                        'nombre' => 'RULA',
                        'encabezados' => ['Puntuación', 'Nivel', 'Actuación'],
                        'filas' => [
                            ['1 o 2', '1', 'Riesgo aceptable.', '_color' => '00B878'],
                            ['3 o 4', '2', 'Pueden requerirse cambios en la tarea; es conveniente profundizar en el estudio.', '_color' => 'FFF000'],
                            ['5 o 6', '3', 'Se requiere el rediseño de la tarea.', '_color' => 'F9A12A'],
                            ['7', '4', 'Se requieren cambios urgentes en la tarea.', '_color' => 'E93645']
                        ],
                        'anchos' => [2300, 1800, 7200],
                        'colorColumna' => 1,
                        'resultado' => $resultadoRulaFre_7_2,
                        'analisis' => isset($evaluacionFre_7_2->ANALISIS_METODO_RULA) ? $evaluacionFre_7_2->ANALISIS_METODO_RULA : ''
                    ]
                ];

                // Crear una tabla y un análisis independiente para cada método.
                $xmlMetodosIndividualesFre_7_2 = [
                    '1' => '',
                    '2' => '',
                    '3' => ''
                ];
                $xmlAnalisisIndividualesFre_7_2 = [
                    '1' => '',
                    '2' => '',
                    '3' => ''
                ];

                foreach ($metodosNormalizadosFre_7_2 as $metodoFre_7_2) {
                    if (!isset($configuracionMetodosFre_7_2[$metodoFre_7_2])) {
                        continue;
                    }

                    $configuracionMetodoFre_7_2 = $configuracionMetodosFre_7_2[$metodoFre_7_2];
                    $indiceFilaResultadoFre_7_2 = null;
                    $resultadoMetodoFre_7_2 = $configuracionMetodoFre_7_2['resultado'];

                    if ($resultadoMetodoFre_7_2 !== null && is_numeric($resultadoMetodoFre_7_2)) {
                        $resultadoMetodoFre_7_2 = (int) $resultadoMetodoFre_7_2;
                        if ($metodoFre_7_2 === '1' && $resultadoMetodoFre_7_2 >= 1 && $resultadoMetodoFre_7_2 <= 4) {
                            $indiceFilaResultadoFre_7_2 = $resultadoMetodoFre_7_2 - 1;
                        } elseif ($metodoFre_7_2 === '2') {
                            if ($resultadoMetodoFre_7_2 === 1) $indiceFilaResultadoFre_7_2 = 0;
                            elseif ($resultadoMetodoFre_7_2 >= 2 && $resultadoMetodoFre_7_2 <= 4) $indiceFilaResultadoFre_7_2 = 1;
                            elseif ($resultadoMetodoFre_7_2 === 5) $indiceFilaResultadoFre_7_2 = 2;
                            elseif ($resultadoMetodoFre_7_2 >= 6 && $resultadoMetodoFre_7_2 <= 8) $indiceFilaResultadoFre_7_2 = 3;
                            elseif ($resultadoMetodoFre_7_2 >= 9 && $resultadoMetodoFre_7_2 <= 10) $indiceFilaResultadoFre_7_2 = 4;
                        } elseif ($metodoFre_7_2 === '3') {
                            if ($resultadoMetodoFre_7_2 >= 1 && $resultadoMetodoFre_7_2 <= 2) $indiceFilaResultadoFre_7_2 = 0;
                            elseif ($resultadoMetodoFre_7_2 >= 3 && $resultadoMetodoFre_7_2 <= 4) $indiceFilaResultadoFre_7_2 = 1;
                            elseif ($resultadoMetodoFre_7_2 >= 5 && $resultadoMetodoFre_7_2 <= 6) $indiceFilaResultadoFre_7_2 = 2;
                            elseif ($resultadoMetodoFre_7_2 === 7) $indiceFilaResultadoFre_7_2 = 3;
                        }
                    }

                    $nombreMetodoFre_7_2 = $configuracionMetodoFre_7_2['nombre'];
                    $xmlMetodosIndividualesFre_7_2[$metodoFre_7_2] =
                        $parrafoXmlFre_7_2('Método: ' . $nombreMetodoFre_7_2, true, 20, 100, 40) .
                        $tablaXmlFre_7_2(
                            $nombreMetodoFre_7_2,
                            $configuracionMetodoFre_7_2['encabezados'],
                            $configuracionMetodoFre_7_2['filas'],
                            $configuracionMetodoFre_7_2['anchos'],
                            $configuracionMetodoFre_7_2['colorColumna'],
                            $indiceFilaResultadoFre_7_2
                        );

                    $resultadoVisibleFre_7_2 = ($resultadoMetodoFre_7_2 !== null && is_numeric($resultadoMetodoFre_7_2))
                        ? (string) $resultadoMetodoFre_7_2
                        : 'Sin resultado calculado';
                    $xmlAnalisisIndividualesFre_7_2[$metodoFre_7_2] =
                        '';

                    $analisisMetodoFre_7_2 = is_scalar($configuracionMetodoFre_7_2['analisis'])
                        ? trim((string) $configuracionMetodoFre_7_2['analisis']) : '';
                    if ($analisisMetodoFre_7_2 !== '') {
                        $xmlAnalisisIndividualesFre_7_2[$metodoFre_7_2] .=
                            '<w:p><w:pPr><w:spacing w:before="20" w:after="100"/></w:pPr>' .
                            '<w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="24"/><w:szCs w:val="24"/><w:b/><w:bCs/></w:rPr><w:t xml:space="preserve">Análisis: </w:t></w:r>' .
                            '<w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($analisisMetodoFre_7_2) . '</w:t></w:r></w:p>';
                    }
                }


                // TABLA ESCALA DE BORG: resultado tomado de ESCALA_BORG.
                $borgValorFre_7_2 = null;
                if (isset($evaluacionFre_7_2->ESCALA_BORG) && $evaluacionFre_7_2->ESCALA_BORG !== '' && is_numeric($evaluacionFre_7_2->ESCALA_BORG)) {
                    $borgValorFre_7_2 = (float) $evaluacionFre_7_2->ESCALA_BORG;
                }
                $borgNivelesFre_7_2 = [
                    ['0', 'Nada en absoluto', '0%'],
                    ['0.5', 'Muy, muy débil (casi ausente)', ''],
                    ['1', 'Muy débil', '10%'],
                    ['2', 'Débil', '20%'],
                    ['3', 'Moderado', '30%'],
                    ['4', 'Moderado +', '40%'],
                    ['5', 'Fuerte', '50%'],
                    ['6', 'Fuerte +', '60%'],
                    ['7', 'Muy fuerte', '70%'],
                    ['8', 'Muy, muy fuerte', '80%'],
                    ['9', 'Extremadamente fuerte', '90%'],
                    ['10', 'Máximo', '100%']
                ];
                $borgColoresFre_7_2 = [
                    '009944',
                    '009944',
                    '009944',
                    '009944',
                    '8FD14F',
                    'D6E600',
                    'FFEB00',
                    'FFC000',
                    'FF8000',
                    'FF4D00',
                    'FF0000',
                    'FF0000'
                ];
                $filasBorgFre_7_2 = [];
                $indiceBorgSeleccionadoFre_7_2 = null;
                foreach ($borgNivelesFre_7_2 as $iBorgFre_7_2 => $nivelBorgFre_7_2) {
                    $valorBorgFilaFre_7_2 = (float) $nivelBorgFre_7_2[0];
                    $colorBorgFre_7_2 = $borgColoresFre_7_2[$iBorgFre_7_2];
                    $filasBorgFre_7_2[] = [
                        0 => '',
                        1 => $nivelBorgFre_7_2[0],
                        2 => $nivelBorgFre_7_2[1],
                        3 => $nivelBorgFre_7_2[2],
                        '_color' => $colorBorgFre_7_2,
                        '_color_col' => 0
                    ];
                    if ($borgValorFre_7_2 !== null && abs($borgValorFre_7_2 - $valorBorgFilaFre_7_2) < 0.001) {
                        $indiceBorgSeleccionadoFre_7_2 = $iBorgFre_7_2;
                    }
                }
                $xmlResultadoBorgFre_7_2 = '';
                if ($borgValorFre_7_2 !== null) {
                    // Colocar la marca roja en la celda del valor seleccionado.
                    $filasBorgFre_7_2[$indiceBorgSeleccionadoFre_7_2][1] = (string) $borgValorFre_7_2;
                    $xmlResultadoBorgFre_7_2 = $tablaXmlFre_7_2(
                        'ESCALA DE BORG (CR-10) PARA LA PERCEPCIÓN DE ESFUERZO',
                        ['Nivel indicador', 'Valor', 'Denominación', '% contracción voluntaria máxima'],
                        $filasBorgFre_7_2,
                        [1800, 1100, 5100, 3000],
                        1,
                        $indiceBorgSeleccionadoFre_7_2
                    );
                }
                $analisisBorgFre_7_2 = isset($evaluacionFre_7_2->INTERPRETACION_ESCALA_BORG)
                    ? trim((string) $evaluacionFre_7_2->INTERPRETACION_ESCALA_BORG) : '';
                $xmlAnalisisBorgFre_7_2 = $analisisBorgFre_7_2 !== ''
                    ? '<w:p><w:pPr><w:spacing w:before="20" w:after="60"/></w:pPr>' .
                    '<w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="24"/><w:szCs w:val="24"/><w:b/><w:bCs/></w:rPr><w:t xml:space="preserve">Interpretación: </w:t></w:r>' .
                    '<w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($analisisBorgFre_7_2) . '</w:t></w:r></w:p>' : '';

                $idEvaluacionTokenFre_7_2 = isset($evaluacionFre_7_2->ID_EVALUACION_FRE)
                    ? preg_replace('/[^A-Za-z0-9]/', '', (string) $evaluacionFre_7_2->ID_EVALUACION_FRE)
                    : (string) ($indiceFre_7_2 + 1);

                // ASPECTOS AMBIENTALES: texto introductorio y tabla con las opciones registradas.
                $valorAmbientalFre_7_2 = function ($campoAmbientalFre_7_2) use ($evaluacionFre_7_2) {
                    if (!isset($evaluacionFre_7_2->{$campoAmbientalFre_7_2}) || !is_scalar($evaluacionFre_7_2->{$campoAmbientalFre_7_2})) {
                        return '';
                    }
                    return trim((string) $evaluacionFre_7_2->{$campoAmbientalFre_7_2});
                };
                $etiquetaAmbientalFre_7_2 = function ($valorAmbientalFre_7_2, $opcionesAmbientalesFre_7_2) {
                    return isset($opcionesAmbientalesFre_7_2[$valorAmbientalFre_7_2]) ? $opcionesAmbientalesFre_7_2[$valorAmbientalFre_7_2] : '';
                };
                $filasAmbientalesFre_7_2 = [
                    ['Iluminación', 'Fuente', ['Natural', 'Artificial', 'Mixta'], $valorAmbientalFre_7_2('FUENTE_ILUMINACION'), ['1' => 'Natural', '2' => 'Artificial', '3' => 'Mixta', '4' => 'N/A']],
                    ['Iluminación', 'Intensidad', ['Normal', 'Deficiente', 'Excesiva'], $valorAmbientalFre_7_2('INTENSIDAD_ILUMINACION'), ['1' => 'Normal', '2' => 'Deficiente', '3' => 'Excesiva', '4' => 'N/A']],
                    ['Iluminación', 'Observaciones', [], $valorAmbientalFre_7_2('OBSERVACION_ILUMINACION'), []],
                    ['Ambiente térmico', 'Percepción', ['Calor', 'Frío', 'Otros (Por ejemplo, humedad)'], $valorAmbientalFre_7_2('PERCEPCION_TERMICA'), ['1' => 'Calor', '2' => 'Frío', '3' => 'Otros (Por ejemplo, humedad)', '4' => 'N/A']],
                    ['Ambiente térmico', 'Intensidad', ['Leve', 'Moderada', 'Severa'], $valorAmbientalFre_7_2('INTENSIDAD_TERMICA'), ['1' => 'Leve', '2' => 'Moderada', '3' => 'Severa', '4' => 'N/A']],
                    ['Ambiente térmico', 'Observaciones', [], $valorAmbientalFre_7_2('OBSERVACIONES_TERMICAS'), []],
                    ['Ambiente sonoro', 'Intensidad', ['Leve', 'Moderada', 'Severa'], $valorAmbientalFre_7_2('INTENSIDAD_RUIDO'), ['1' => 'Leve', '2' => 'Moderada', '3' => 'Severa', '4' => 'N/A']],
                    ['Ambiente sonoro', 'Continuidad', ['Continuo', 'Intermitente', ''], $valorAmbientalFre_7_2('CONTINUIDAD_RUIDO'), ['1' => 'Continuo', '2' => 'Intermitente', '4' => 'N/A']],
                    ['Ambiente sonoro', 'Observaciones', [], $valorAmbientalFre_7_2('OBSERVACIONES_RUIDO'), []],
                    ['Vibración', 'Intensidad', ['Leve', 'Moderada', 'Severa'], $valorAmbientalFre_7_2('INTENSIDAD_VIBRACION'), ['1' => 'Leve', '2' => 'Moderada', '3' => 'Severa', '4' => 'N/A']],
                    ['Vibración', 'Segmentos corporales', ['Mano brazo', 'Cuerpo entero', 'Columna y miembros inferiores'], $valorAmbientalFre_7_2('SEGMENTO_VIBRACION'), ['1' => 'Mano brazo', '2' => 'Cuerpo entero', '3' => 'Columna y miembros inferiores', '4' => 'N/A']],
                    ['Vibración', 'Observaciones', [], $valorAmbientalFre_7_2('OBSERVACIONES_VIBRACION'), []],
                ];
                $anchoColumnasAmbientalesFre_7_2 = [1750, 1800, 1500, 260, 1500, 260, 2100, 260];
                $anchoTotalAmbientalesFre_7_2 = array_sum($anchoColumnasAmbientalesFre_7_2);
                $xmlAspectosAmbientalesFre_7_2 = $parrafoXmlFre_7_2('Aspectos ambientales del lugar de trabajo', true, 24, 100, 60);
                $xmlAspectosAmbientalesFre_7_2 .= $parrafoXmlFre_7_2(
                    'En este apartado se valoran de forma subjetiva los aspectos de ergonomía ambiental, subrayando que en el ambiente térmico las condiciones están influenciadas por la temperatura reinante en la zona donde se ubica el centro de trabajo, que según la temporada del año puede estar en un promedio de 32° a 34° la mayor parte del año y en verano la temperatura alcanza registro superiores a 37 y 40°. Cabe resaltar que al respecto de las condiciones valoradas, se registra la percepción de los trabajadores y el punto de vista observacional del evaluador.',
                    false,
                    24,
                    0,
                    100
                );
                $xmlAspectosAmbientalesFre_7_2 .= '<w:tbl><w:tblPr><w:tblW w:w="' . $anchoTotalAmbientalesFre_7_2 . '" w:type="dxa"/><w:jc w:val="center"/><w:tblBorders><w:top w:val="single" w:sz="6" w:color="000000"/><w:left w:val="single" w:sz="6" w:color="000000"/><w:bottom w:val="single" w:sz="6" w:color="000000"/><w:right w:val="single" w:sz="6" w:color="000000"/><w:insideH w:val="single" w:sz="5" w:color="000000"/><w:insideV w:val="single" w:sz="5" w:color="000000"/></w:tblBorders><w:tblLayout w:type="fixed"/><w:tblCellMar><w:top w:w="35" w:type="dxa"/><w:left w:w="45" w:type="dxa"/><w:bottom w:w="35" w:type="dxa"/><w:right w:w="45" w:type="dxa"/></w:tblCellMar></w:tblPr><w:tblGrid>';
                foreach ($anchoColumnasAmbientalesFre_7_2 as $anchoAmbientalFre_7_2) {
                    $xmlAspectosAmbientalesFre_7_2 .= '<w:gridCol w:w="' . $anchoAmbientalFre_7_2 . '"/>';
                }
                $xmlAspectosAmbientalesFre_7_2 .= '</w:tblGrid>';
                $filasConEncabezadoAmbientalFre_7_2 = array_merge([['__HEADER__', 'Aspecto', 'Descripción']], $filasAmbientalesFre_7_2);
                foreach ($filasConEncabezadoAmbientalFre_7_2 as $indiceFilaAmbientalFre_7_2 => $filaAmbientalFre_7_2) {
                    $xmlAspectosAmbientalesFre_7_2 .= '<w:tr><w:trPr><w:cantSplit/></w:trPr>';
                    if ($indiceFilaAmbientalFre_7_2 === 0) {
                        $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="3550" w:type="dxa"/><w:gridSpan w:val="2"/><w:shd w:fill="123F60"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:color w:val="FFFFFF"/><w:sz w:val="18"/></w:rPr><w:t>Aspecto</w:t></w:r></w:p></w:tc>';
                        $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . ($anchoTotalAmbientalesFre_7_2 - 3550) . '" w:type="dxa"/><w:gridSpan w:val="6"/><w:shd w:fill="123F60"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:color w:val="FFFFFF"/><w:sz w:val="18"/></w:rPr><w:t>Descripción</w:t></w:r></w:p></w:tc>';
                    } else {
                        $aspectoAmbientalFre_7_2 = $filaAmbientalFre_7_2[0];
                        $subaspectoAmbientalFre_7_2 = $filaAmbientalFre_7_2[1];
                        $opcionesAmbientalesFre_7_2 = $filaAmbientalFre_7_2[2];
                        $seleccionAmbientalFre_7_2 = $filaAmbientalFre_7_2[3];
                        $mapaAmbientalFre_7_2 = $filaAmbientalFre_7_2[4];
                        $esObservacionAmbientalFre_7_2 = $subaspectoAmbientalFre_7_2 === 'Observaciones';
                        $fondoAmbientalFre_7_2 = '123F60';
                        $colorAmbientalFre_7_2 = 'FFFFFF';
                        // Combinar verticalmente la celda Aspecto para que cada grupo aparezca una sola vez.
                        $aspectoAnteriorAmbientalFre_7_2 = ($indiceFilaAmbientalFre_7_2 > 1)
                            ? $filasAmbientalesFre_7_2[$indiceFilaAmbientalFre_7_2 - 2][0]
                            : null;
                        $continuarFusionAmbientalFre_7_2 = ($aspectoAnteriorAmbientalFre_7_2 === $aspectoAmbientalFre_7_2);
                        $propiedadFusionAmbientalFre_7_2 = $continuarFusionAmbientalFre_7_2
                            ? '<w:vMerge w:val="continue"/>'
                            : '<w:vMerge w:val="restart"/>';
                        // Word exige que cada celda contenga al menos un párrafo,
                        // incluso cuando es una continuación de combinación vertical.
                        $textoAspectoAmbientalFre_7_2 = $continuarFusionAmbientalFre_7_2
                            ? '<w:p/>'
                            : '<w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:color w:val="' . $colorAmbientalFre_7_2 . '"/><w:sz w:val="16"/></w:rPr><w:t>' . $escaparXmlFre_7_2($aspectoAmbientalFre_7_2) . '</w:t></w:r></w:p>';
                        $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="1750" w:type="dxa"/><w:shd w:fill="' . $fondoAmbientalFre_7_2 . '"/><w:vAlign w:val="center"/>' . $propiedadFusionAmbientalFre_7_2 . '</w:tcPr>' . $textoAspectoAmbientalFre_7_2 . '</w:tc>';
                        $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="1800" w:type="dxa"/><w:shd w:fill="123F60"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:color w:val="FFFFFF"/><w:sz w:val="16"/></w:rPr><w:t>' . $escaparXmlFre_7_2($subaspectoAmbientalFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                        if ($esObservacionAmbientalFre_7_2) {
                            $textoObservacionAmbientalFre_7_2 = trim((string) $seleccionAmbientalFre_7_2);
                            if ($textoObservacionAmbientalFre_7_2 === '') $textoObservacionAmbientalFre_7_2 = 'N/A';
                            $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . ($anchoTotalAmbientalesFre_7_2 - 3550) . '" w:type="dxa"/><w:gridSpan w:val="6"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="16"/></w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($textoObservacionAmbientalFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                        } else {
                            if ($seleccionAmbientalFre_7_2 === '4') {
                                $opcionesAmbientalesFre_7_2[2] = 'N/A';
                            }
                            for ($iAmbientalFre_7_2 = 0; $iAmbientalFre_7_2 < 3; $iAmbientalFre_7_2++) {
                                $etiquetaOpcionAmbientalFre_7_2 = isset($opcionesAmbientalesFre_7_2[$iAmbientalFre_7_2]) ? $opcionesAmbientalesFre_7_2[$iAmbientalFre_7_2] : '';
                                $valorOpcionAmbientalFre_7_2 = $iAmbientalFre_7_2 + 1;
                                if ($subaspectoAmbientalFre_7_2 === 'Continuidad') $valorOpcionAmbientalFre_7_2 = $iAmbientalFre_7_2 + 1;
                                $marcaAmbientalFre_7_2 = ((string)$seleccionAmbientalFre_7_2 === (string)$valorOpcionAmbientalFre_7_2 || ($seleccionAmbientalFre_7_2 === '4' && $iAmbientalFre_7_2 === 2)) ? '✓' : '';
                                $anchoOpcionAmbientalFre_7_2 = $anchoColumnasAmbientalesFre_7_2[2 + ($iAmbientalFre_7_2 * 2)];
                                $anchoMarcaAmbientalFre_7_2 = $anchoColumnasAmbientalesFre_7_2[3 + ($iAmbientalFre_7_2 * 2)];
                                $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoOpcionAmbientalFre_7_2 . '" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="15"/></w:rPr><w:t>' . $escaparXmlFre_7_2($etiquetaOpcionAmbientalFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                                $xmlAspectosAmbientalesFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoMarcaAmbientalFre_7_2 . '" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:b/><w:color w:val="92B83E"/><w:sz w:val="18"/></w:rPr><w:t>' . $marcaAmbientalFre_7_2 . '</w:t></w:r></w:p></w:tc>';
                            }
                        }
                    }
                    $xmlAspectosAmbientalesFre_7_2 .= '</w:tr>';
                }
                $xmlAspectosAmbientalesFre_7_2 .= '</w:tbl><w:p><w:pPr><w:spacing w:after="0"/></w:pPr><w:r><w:t xml:space="preserve"> </w:t></w:r></w:p>';
                $tokenAspectosAmbientalesFre_7_2 = 'ASPECTOSAMBIENTALESFRE' . $idEvaluacionTokenFre_7_2 . 'X';
                $tablasMetodosFre_7_2[$indiceFre_7_2]['ASPECTOS_AMBIENTALES'] = $tokenAspectosAmbientalesFre_7_2;
                $bloquesMetodosXmlFre_7_2[$tokenAspectosAmbientalesFre_7_2] = $xmlAspectosAmbientalesFre_7_2;

                $tokenResultadoBorgFre_7_2 = 'RESULTADOBORGFRE' . $idEvaluacionTokenFre_7_2 . 'X';
                $tokenAnalisisBorgFre_7_2 = 'ANALISISBORGFRE' . $idEvaluacionTokenFre_7_2 . 'X';
                if (!isset($tablasMetodosFre_7_2[$indiceFre_7_2]) || !is_array($tablasMetodosFre_7_2[$indiceFre_7_2])) {
                    $tablasMetodosFre_7_2[$indiceFre_7_2] = [];
                }
                $tablasMetodosFre_7_2[$indiceFre_7_2]['RESULTADO_BORG'] = $tokenResultadoBorgFre_7_2;
                $tablasMetodosFre_7_2[$indiceFre_7_2]['ANALISIS_BORG'] = $tokenAnalisisBorgFre_7_2;
                $bloquesMetodosXmlFre_7_2[$tokenResultadoBorgFre_7_2] = $xmlResultadoBorgFre_7_2;
                $bloquesMetodosXmlFre_7_2[$tokenAnalisisBorgFre_7_2] = $xmlAnalisisBorgFre_7_2;


                // DINAMOMETRÍA MANUAL: solo se muestra cuando REQUIERE_FUERZA_MANUAL = 1.
                // La observación se muestra siempre, independientemente de si se requiere la prueba.
                $requiereFuerzaManualFre_7_2 = isset($evaluacionFre_7_2->REQUIERE_FUERZA_MANUAL)
                    ? trim((string) $evaluacionFre_7_2->REQUIERE_FUERZA_MANUAL) : '';

                $xmlDinamometriaFre_7_2 = '';
                if ($requiereFuerzaManualFre_7_2 === '1') {
                    $sexoDinamometriaFre_7_2 = isset($evaluacionFre_7_2->SEXO_EMPLEADO_FRE)
                        ? strtoupper(trim((string) $evaluacionFre_7_2->SEXO_EMPLEADO_FRE)) : '';
                    if ($sexoDinamometriaFre_7_2 === 'M') {
                        $sexoDinamometriaFre_7_2 = 'Masculino';
                    } elseif ($sexoDinamometriaFre_7_2 === 'F') {
                        $sexoDinamometriaFre_7_2 = 'Femenino';
                    }

                    $manoDerechaFre_7_2 = isset($evaluacionFre_7_2->FUERZA_MANO_DERECHA)
                        && is_scalar($evaluacionFre_7_2->FUERZA_MANO_DERECHA)
                        ? trim((string) $evaluacionFre_7_2->FUERZA_MANO_DERECHA) : '';
                    $manoIzquierdaFre_7_2 = isset($evaluacionFre_7_2->FUERZA_MANO_IZQUIERDA)
                        && is_scalar($evaluacionFre_7_2->FUERZA_MANO_IZQUIERDA)
                        ? trim((string) $evaluacionFre_7_2->FUERZA_MANO_IZQUIERDA) : '';

                    // Un solo título, en negritas y tamaño 12.
                    $xmlDinamometriaFre_7_2 .= $parrafoXmlFre_7_2('Dinamometría Manual Digital:', true, 24, 80, 60);
                    $xmlDinamometriaFre_7_2 .= $parrafoXmlFre_7_2(
                        'Evalúa la fuerza de prensión estática (agarre) de forma rápida y exacta. Es un indicador directo del estado muscular, nutricional y funcional del cuerpo y para medir la fuerza de agarre o prensión de la mano de forma precisa, rápida y objetiva. Existen diversos estudios que han propuesto valores de referencia para la FE. El más utilizado es el propuesto por Schlüssel et al., realizado en una población de 3050 adultos mayores de 20 años en Brasil. Referencia: https://www.sciencedirect.com/science/article/pii/S2095254624001741',
                        false,
                        24,
                        40,
                        100
                    );

                    // Tabla de valores de referencia por edad, sexo y mano (Schlüssel et al.).
                    // Se inserta inmediatamente después del enlace de referencia y antes de los resultados del trabajador.
                    $filasReferenciaFuerzaFre_7_2 = [
                        ['Edad', 'Mano derecha', '', '', '', '', 'Mano izquierda', '', '', '', ''],
                        ['', 'P10', 'P30', 'P50', 'P70', 'P90', 'P10', 'P30', 'P50', 'P70', 'P90'],
                        ['Hombres', '', '', '', '', '', '', '', '', '', ''],
                        ['20-29', '33.9', '41.3', '45.1', '50.6', '56.3', '34.0', '39.4', '43.6', '47.8', '53.7'],
                        ['30-39', '36.6', '42.2', '45.8', '50.0', '56.9', '34.7', '40.4', '44.1', '48.3', '53.5'],
                        ['40-49', '34.3', '37.5', '42.5', '46.7', '53.6', '32.4', '37.1', '40.9', '45.3', '50.9'],
                        ['50-59', '30.2', '36.2', '41.4', '44.3', '50.1', '29.6', '35.0', '38.9', '42.8', '48.3'],
                        ['60-69', '26.5', '32.9', '37.0', '40.8', '45.5', '26.4', '30.8', '34.4', '37.5', '41.9'],
                        ['≥70', '22.8', '27.7', '32.1', '35.7', '40.6', '21.0', '26.6', '28.9', '31.3', '36.6'],
                        ['Mujeres', '', '', '', '', '', '', '', '', '', ''],
                        ['20-29', '19.5', '23.8', '27.4', '30.0', '34.0', '18.6', '22.3', '25.8', '28.4', '31.8'],
                        ['30-39', '20.7', '25.0', '27.6', '30.7', '35.0', '20.1', '23.5', '26.4', '29.3', '32.9'],
                        ['40-49', '19.8', '24.4', '26.9', '29.4', '33.6', '18.4', '22.9', '25.7', '28.1', '31.7'],
                        ['50-59', '16.6', '21.1', '24.3', '26.4', '30.9', '15.4', '19.9', '23.0', '25.3', '29.8'],
                        ['60-69', '16.6', '19.6', '21.7', '24.6', '27.5', '15.0', '18.2', '20.5', '22.8', '27.1'],
                        ['≥70', '9.9', '13.7', '16.8', '20.0', '23.8', '9.0', '13.0', '16.0', '19.2', '22.6']
                    ];
                    $anchosReferenciaFuerzaFre_7_2 = [1100, 760, 760, 760, 760, 760, 760, 760, 760, 760, 760];
                    $anchoTotalReferenciaFuerzaFre_7_2 = array_sum($anchosReferenciaFuerzaFre_7_2);
                    $xmlTablaReferenciaFuerzaFre_7_2 = '<w:tbl><w:tblPr><w:tblW w:w="' . $anchoTotalReferenciaFuerzaFre_7_2 . '" w:type="dxa"/><w:jc w:val="center"/><w:tblBorders><w:top w:val="single" w:sz="5" w:color="7B8C8C"/><w:left w:val="single" w:sz="5" w:color="7B8C8C"/><w:bottom w:val="single" w:sz="5" w:color="7B8C8C"/><w:right w:val="single" w:sz="5" w:color="7B8C8C"/><w:insideH w:val="single" w:sz="4" w:color="7B8C8C"/><w:insideV w:val="single" w:sz="4" w:color="7B8C8C"/></w:tblBorders><w:tblLayout w:type="fixed"/><w:tblCellMar><w:top w:w="20" w:type="dxa"/><w:left w:w="20" w:type="dxa"/><w:bottom w:w="20" w:type="dxa"/><w:right w:w="20" w:type="dxa"/></w:tblCellMar></w:tblPr><w:tblGrid>';
                    foreach ($anchosReferenciaFuerzaFre_7_2 as $anchoReferenciaFuerzaFre_7_2) {
                        $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:gridCol w:w="' . $anchoReferenciaFuerzaFre_7_2 . '"/>';
                    }
                    $xmlTablaReferenciaFuerzaFre_7_2 .= '</w:tblGrid>';
                    foreach ($filasReferenciaFuerzaFre_7_2 as $indiceFilaReferenciaFuerzaFre_7_2 => $filaReferenciaFuerzaFre_7_2) {
                        $esFilaGrupoReferenciaFuerzaFre_7_2 = in_array($indiceFilaReferenciaFuerzaFre_7_2, [2, 9], true);
                        $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tr><w:trPr><w:cantSplit/></w:trPr>';
                        if ($indiceFilaReferenciaFuerzaFre_7_2 === 0) {
                            // Cabeceras superiores combinadas: Edad, Mano derecha y Mano izquierda.
                            foreach ($filaReferenciaFuerzaFre_7_2 as $indiceColReferenciaFuerzaFre_7_2 => $textoReferenciaFuerzaFre_7_2) {
                                if ($indiceColReferenciaFuerzaFre_7_2 === 0) {
                                    $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="1100" w:type="dxa"/><w:vMerge w:val="restart"/><w:shd w:fill="C6E4E3"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="14"/><w:b/><w:color w:val="222222"/></w:rPr><w:t>Edad</w:t></w:r></w:p></w:tc>';
                                } elseif ($indiceColReferenciaFuerzaFre_7_2 === 1 || $indiceColReferenciaFuerzaFre_7_2 === 6) {
                                    $anchoGrupoReferenciaFuerzaFre_7_2 = array_sum(array_slice($anchosReferenciaFuerzaFre_7_2, $indiceColReferenciaFuerzaFre_7_2, 5));
                                    $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoGrupoReferenciaFuerzaFre_7_2 . '" w:type="dxa"/><w:gridSpan w:val="5"/><w:shd w:fill="C6E4E3"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="14"/><w:b/><w:color w:val="222222"/></w:rPr><w:t>' . $escaparXmlFre_7_2($textoReferenciaFuerzaFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                                }
                            }
                        } elseif ($indiceFilaReferenciaFuerzaFre_7_2 === 1) {
                            // Continuación de la celda Edad y encabezados de percentiles.
                            $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="1100" w:type="dxa"/><w:vMerge/><w:shd w:fill="C6E4E3"/></w:tcPr><w:p/></w:tc>';
                            for ($jReferenciaFuerzaFre_7_2 = 1; $jReferenciaFuerzaFre_7_2 < 11; $jReferenciaFuerzaFre_7_2++) {
                                $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchosReferenciaFuerzaFre_7_2[$jReferenciaFuerzaFre_7_2] . '" w:type="dxa"/><w:shd w:fill="C6E4E3"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="13"/><w:b/><w:color w:val="222222"/></w:rPr><w:t>' . $escaparXmlFre_7_2($filaReferenciaFuerzaFre_7_2[$jReferenciaFuerzaFre_7_2]) . '</w:t></w:r></w:p></w:tc>';
                            }
                        } elseif ($esFilaGrupoReferenciaFuerzaFre_7_2) {
                            $textoGrupoReferenciaFuerzaFre_7_2 = $filaReferenciaFuerzaFre_7_2[0];
                            $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoTotalReferenciaFuerzaFre_7_2 . '" w:type="dxa"/><w:gridSpan w:val="11"/><w:shd w:fill="D9E6E6"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="14"/><w:b/><w:color w:val="222222"/></w:rPr><w:t>' . $escaparXmlFre_7_2($textoGrupoReferenciaFuerzaFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                        } else {
                            foreach ($anchosReferenciaFuerzaFre_7_2 as $indiceColReferenciaFuerzaFre_7_2 => $anchoReferenciaFuerzaFre_7_2) {
                                $textoReferenciaFuerzaFre_7_2 = $filaReferenciaFuerzaFre_7_2[$indiceColReferenciaFuerzaFre_7_2];
                                $fondoReferenciaFuerzaFre_7_2 = $indiceColReferenciaFuerzaFre_7_2 === 0 ? 'F5F5F5' : 'D9EEEE';
                                $xmlTablaReferenciaFuerzaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoReferenciaFuerzaFre_7_2 . '" w:type="dxa"/><w:shd w:fill="' . $fondoReferenciaFuerzaFre_7_2 . '"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="12"/><w:color w:val="222222"/></w:rPr><w:t>' . $escaparXmlFre_7_2($textoReferenciaFuerzaFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                            }
                        }
                        $xmlTablaReferenciaFuerzaFre_7_2 .= '</w:tr>';
                    }
                    $xmlDinamometriaFre_7_2 .= $xmlTablaReferenciaFuerzaFre_7_2 . '</w:tbl><w:p><w:pPr><w:spacing w:before="0" w:after="80"/></w:pPr><w:r><w:t xml:space="preserve"> </w:t></w:r></w:p>';

                    // Tabla compacta de resultados de la persona, sin título interno.
                    $filasDinamometriaFre_7_2 = [[
                        $sexoDinamometriaFre_7_2,
                        $manoDerechaFre_7_2,
                        $manoIzquierdaFre_7_2
                    ]];
                    $anchosDinamometriaFre_7_2 = [1900, 2750, 2750];
                    $anchoTotalDinamometriaFre_7_2 = array_sum($anchosDinamometriaFre_7_2);
                    $xmlTablaDinamometriaFre_7_2 = '<w:tbl><w:tblPr><w:tblW w:w="' . $anchoTotalDinamometriaFre_7_2 . '" w:type="dxa"/><w:jc w:val="center"/><w:tblBorders><w:top w:val="single" w:sz="5" w:color="808080"/><w:left w:val="single" w:sz="5" w:color="808080"/><w:bottom w:val="single" w:sz="5" w:color="808080"/><w:right w:val="single" w:sz="5" w:color="808080"/><w:insideH w:val="single" w:sz="5" w:color="808080"/><w:insideV w:val="single" w:sz="5" w:color="808080"/></w:tblBorders><w:tblLayout w:type="fixed"/><w:tblCellMar><w:top w:w="35" w:type="dxa"/><w:left w:w="55" w:type="dxa"/><w:bottom w:w="35" w:type="dxa"/><w:right w:w="55" w:type="dxa"/></w:tblCellMar></w:tblPr><w:tblGrid>';
                    foreach ($anchosDinamometriaFre_7_2 as $anchoDinamometriaFre_7_2) {
                        $xmlTablaDinamometriaFre_7_2 .= '<w:gridCol w:w="' . $anchoDinamometriaFre_7_2 . '"/>';
                    }
                    $xmlTablaDinamometriaFre_7_2 .= '</w:tblGrid>';
                    $filasTablaDinamometriaFre_7_2 = [
                        ['Género', 'Resultado mano derecha', 'Resultado mano izquierda'],
                        $filasDinamometriaFre_7_2[0]
                    ];
                    foreach ($filasTablaDinamometriaFre_7_2 as $indiceFilaDinamometriaFre_7_2 => $filaTablaDinamometriaFre_7_2) {
                        $esEncabezadoDinamometriaFre_7_2 = $indiceFilaDinamometriaFre_7_2 === 0;
                        $xmlTablaDinamometriaFre_7_2 .= '<w:tr><w:trPr><w:cantSplit/></w:trPr>';
                        foreach ($anchosDinamometriaFre_7_2 as $indiceColDinamometriaFre_7_2 => $anchoDinamometriaFre_7_2) {
                            $textoCeldaDinamometriaFre_7_2 = isset($filaTablaDinamometriaFre_7_2[$indiceColDinamometriaFre_7_2]) ? $filaTablaDinamometriaFre_7_2[$indiceColDinamometriaFre_7_2] : '';
                            $fondoCeldaDinamometriaFre_7_2 = $esEncabezadoDinamometriaFre_7_2 ? '0F3D63' : 'FFFFFF';
                            $colorCeldaDinamometriaFre_7_2 = '000000';
                            $negritaCeldaDinamometriaFre_7_2 = $esEncabezadoDinamometriaFre_7_2 ? '<w:b/><w:bCs/>' : '';
                            $colorCeldaDinamometriaFre_7_2 = $esEncabezadoDinamometriaFre_7_2 ? 'FFFFFF' : '000000';
                            $alineacionCeldaDinamometriaFre_7_2 = $esEncabezadoDinamometriaFre_7_2 ? 'center' : ($indiceColDinamometriaFre_7_2 === 0 ? 'left' : 'center');
                            $xmlTablaDinamometriaFre_7_2 .= '<w:tc><w:tcPr><w:tcW w:w="' . $anchoDinamometriaFre_7_2 . '" w:type="dxa"/><w:shd w:val="clear" w:fill="' . $fondoCeldaDinamometriaFre_7_2 . '"/><w:vAlign w:val="center"/></w:tcPr><w:p><w:pPr><w:jc w:val="' . $alineacionCeldaDinamometriaFre_7_2 . '"/><w:spacing w:before="0" w:after="0"/></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Poppins" w:hAnsi="Poppins"/><w:sz w:val="16"/><w:szCs w:val="16"/>' . $negritaCeldaDinamometriaFre_7_2 . '<w:color w:val="' . $colorCeldaDinamometriaFre_7_2 . '"/></w:rPr><w:t xml:space="preserve">' . $escaparXmlFre_7_2($textoCeldaDinamometriaFre_7_2) . '</w:t></w:r></w:p></w:tc>';
                        }
                        $xmlTablaDinamometriaFre_7_2 .= '</w:tr>';
                    }
                    $xmlDinamometriaFre_7_2 .= $xmlTablaDinamometriaFre_7_2 . '</w:tbl><w:p><w:pPr><w:spacing w:after="0"/></w:pPr><w:r><w:t xml:space="preserve"> </w:t></w:r></w:p>';
                }

                $observacionFuerzaManualFre_7_2 = isset($evaluacionFre_7_2->OBSERVACIONES_FUERZAMANUAL)
                    && is_scalar($evaluacionFre_7_2->OBSERVACIONES_FUERZAMANUAL)
                    ? trim((string) $evaluacionFre_7_2->OBSERVACIONES_FUERZAMANUAL) : '';
                $xmlObservacionFuerzaManualFre_7_2 = $parrafoXmlFre_7_2('Observación:', true, 24, 100, 30);
                $xmlObservacionFuerzaManualFre_7_2 .= $parrafoXmlFre_7_2(
                    $observacionFuerzaManualFre_7_2,
                    false,
                    24,
                    0,
                    100
                );

                $tokenDinamometriaFre_7_2 = 'DINAMOMETRIAMARCADOR' . $idEvaluacionTokenFre_7_2 . 'X';
                $tokenObservacionFuerzaManualFre_7_2 = 'OBSERVACIONFUERZAMANUAL' . $idEvaluacionTokenFre_7_2 . 'X';
                $tablasMetodosFre_7_2[$indiceFre_7_2]['DINAMOMETRIA_MARCADOR'] = $tokenDinamometriaFre_7_2;
                $tablasMetodosFre_7_2[$indiceFre_7_2]['OBSERVACION_FUERZAMANUAL'] = $tokenObservacionFuerzaManualFre_7_2;
                $bloquesMetodosXmlFre_7_2[$tokenDinamometriaFre_7_2] = $xmlDinamometriaFre_7_2;
                $bloquesMetodosXmlFre_7_2[$tokenObservacionFuerzaManualFre_7_2] = $xmlObservacionFuerzaManualFre_7_2;

                $nombresMarcadoresFre_7_2 = [
                    '1' => ['METODO_OWAS_FRE', 'ANALISIS_OWAS_FRE'],
                    '2' => ['METODO_ROSA_FRE', 'ANALISIS_ROSA_FRE'],
                    '3' => ['METODO_RULA_FRE', 'ANALISIS_RULA_FRE']
                ];
                foreach ($nombresMarcadoresFre_7_2 as $idMetodoFre_7_2 => $marcadoresFre_7_2) {
                    $tokenTablaFre_7_2 = 'METODOTABLA' . $idMetodoFre_7_2 . 'FRE' . $idEvaluacionTokenFre_7_2 . 'X';
                    $tokenAnalisisFre_7_2 = 'METODOANALISIS' . $idMetodoFre_7_2 . 'FRE' . $idEvaluacionTokenFre_7_2 . 'X';
                    if (!isset($tablasMetodosFre_7_2[$indiceFre_7_2]) || !is_array($tablasMetodosFre_7_2[$indiceFre_7_2])) {
                        $tablasMetodosFre_7_2[$indiceFre_7_2] = [];
                    }
                    $tablasMetodosFre_7_2[$indiceFre_7_2][$marcadoresFre_7_2[0]] = $tokenTablaFre_7_2;
                    $tablasMetodosFre_7_2[$indiceFre_7_2][$marcadoresFre_7_2[1]] = $tokenAnalisisFre_7_2;
                    $bloquesMetodosXmlFre_7_2[$tokenTablaFre_7_2] = $xmlMetodosIndividualesFre_7_2[$idMetodoFre_7_2];
                    $bloquesMetodosXmlFre_7_2[$tokenAnalisisFre_7_2] = $xmlAnalisisIndividualesFre_7_2[$idMetodoFre_7_2];
                }








                $tablaAngulosFre_7_2 = new \PhpOffice\PhpWord\Element\Table([

                    'borderSize' => 6,

                    'borderColor' => '000000',

                    'cellMargin' => 80,

                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,

                ]);









                $angulosFre_7_2 = DB::table('angulos_fre_ergo')

                    ->where(

                        'FRE_ID',

                        $evaluacionFre_7_2->ID_EVALUACION_FRE

                    )

                    ->where('ACTIVO', 1)

                    ->orderBy('ID_ANGULOS_FRE', 'ASC')

                    ->get();







                $tablaAngulosFre_7_2->addRow();





                $tablaAngulosFre_7_2->addCell(

                    4200,

                    $estiloCeldaTituloAngulosFre_7_2

                )->addText(

                    'EVIDENCIA FOTOGRÁFICA',

                    $estiloTituloAngulosFre_7_2,

                    [

                        'alignment' => 'center',

                    ]

                );





                $tablaAngulosFre_7_2->addCell(

                    7100,

                    $estiloCeldaTituloAngulosFre_7_2

                )->addText(

                    'FACTORES ERGONÓMICOS',

                    $estiloTituloAngulosFre_7_2,

                    [

                        'alignment' => 'center',

                    ]

                );







                if ($angulosFre_7_2->isEmpty()) {



                    $tablaAngulosFre_7_2->addRow();





                    $tablaAngulosFre_7_2->addCell(

                        4200,

                        $estiloCeldaAngulosFre_7_2

                    )->addText(

                        'Sin evidencia fotográfica registrada.',

                        $estiloTextoAngulosFre_7_2

                    );





                    $tablaAngulosFre_7_2->addCell(

                        7100,

                        $estiloCeldaAngulosFre_7_2

                    )->addText(

                        'No hay ángulos registrados para esta evaluación.',

                        $estiloTextoAngulosFre_7_2

                    );
                } else {









                    foreach (

                        $angulosFre_7_2 as $anguloFre_7_2

                    ) {





                        $claveImagenFre_7_2 =

                            'FREIMG72\_' .

                            $evaluacionFre_7_2->ID_EVALUACION_FRE .

                            '\_' .

                            $anguloFre_7_2->ID_ANGULOS_FRE;



                        $rutaFotoFre_7_2 = null;





                        if (

                            isset($anguloFre_7_2->FOTO_ANGULO) &&

                            trim(

                                (string) $anguloFre_7_2->FOTO_ANGULO

                            ) !== ''

                        ) {



                            $rutaFotoFre_7_2 = storage_path(

                                'app/' . ltrim(

                                    str_replace(

                                        '\\\\',

                                        '/',

                                        (string) $anguloFre_7_2->FOTO_ANGULO

                                    ),

                                    '/'

                                )

                            );
                        }







                        $factoresFre_7_2 = [



                            [

                                'titulo' => 'Postura:',

                                'descripcion' => isset(

                                    $anguloFre_7_2->DESCRIPCION_POSTURA

                                )

                                    ? trim(

                                        (string) $anguloFre_7_2->DESCRIPCION_POSTURA

                                    )

                                    : '',

                            ],



                            [

                                'titulo' => 'Movimiento:',

                                'descripcion' => isset(

                                    $anguloFre_7_2->DESCRIPCION_MOVIMIENTO

                                )

                                    ? trim(

                                        (string) $anguloFre_7_2->DESCRIPCION_MOVIMIENTO

                                    )

                                    : '',

                            ],



                            [

                                'titulo' => 'Fuerza:',

                                'descripcion' => isset(

                                    $anguloFre_7_2->DESCRIPCION_FUERZA

                                )

                                    ? trim(

                                        (string) $anguloFre_7_2->DESCRIPCION_FUERZA

                                    )

                                    : '',

                            ],



                        ];





                        foreach (

                            $factoresFre_7_2 as $indiceFactorFre_7_2 => $factorFre_7_2

                        ) {





                            $tablaAngulosFre_7_2->addRow();





                            if ($indiceFactorFre_7_2 === 0) {







                                $celdaFotoFre_7_2 =

                                    $tablaAngulosFre_7_2->addCell(

                                        4200,

                                        [

                                            'valign' => 'center',

                                            'vMerge' => 'restart',

                                            'borderSize' => 6,

                                            'borderColor' => '000000',

                                            'marginTop' => 100,

                                            'marginBottom' => 100,

                                            'marginLeft' => 100,

                                            'marginRight' => 100,

                                        ]

                                    );







                                if (

                                    $rutaFotoFre_7_2 !== null &&

                                    is_file($rutaFotoFre_7_2) &&

                                    is_readable($rutaFotoFre_7_2)

                                ) {



                                    $celdaFotoFre_7_2->addText(

                                        '${' . $claveImagenFre_7_2 . '}',

                                        $estiloTextoAngulosFre_7_2,

                                        [

                                            'alignment' => 'center',

                                            'spaceAfter' => 0,

                                        ]

                                    );





                                    $imagenesAngulosFre_7_2[$claveImagenFre_7_2] = $rutaFotoFre_7_2;
                                } else {



                                    $celdaFotoFre_7_2->addText(

                                        'FALTA CARGAR IMAGEN DESDE EL SISTEMA.',

                                        $estiloTextoAngulosFre_7_2,

                                        [

                                            'alignment' => 'center',

                                        ]

                                    );
                                }
                            } else {







                                $tablaAngulosFre_7_2->addCell(

                                    4200,

                                    [

                                        'vMerge' => 'continue',

                                        'borderSize' => 6,

                                        'borderColor' => '000000',

                                    ]

                                );
                            }









                            $celdaFactorFre_7_2 =

                                $tablaAngulosFre_7_2->addCell(

                                    7100,

                                    [

                                        'valign' => 'center',

                                        'borderSize' => 6,

                                        'borderColor' => '000000',

                                        'marginTop' => 100,

                                        'marginBottom' => 100,

                                        'marginLeft' => 120,

                                        'marginRight' => 120,

                                    ]

                                );









                            $celdaFactorFre_7_2->addText(

                                $factorFre_7_2['titulo'],

                                [

                                    'name' => 'Poppins',

                                    'size' => 9,

                                    'bold' => true,

                                    'color' => '000000',

                                ],

                                [

                                    'alignment' => 'left',

                                    'spaceAfter' => 40,

                                    'spaceBefore' => 0,

                                ]

                            );









                            $descripcionFactorFre_7_2 =

                                $factorFre_7_2['descripcion'];





                            if (

                                $descripcionFactorFre_7_2 === ''

                            ) {



                                $descripcionFactorFre_7_2 =

                                    'Sin descripción';
                            }





                            $celdaFactorFre_7_2->addText(

                                $descripcionFactorFre_7_2,

                                $estiloTextoAngulosFre_7_2,

                                [

                                    'alignment' => 'both',

                                    'spaceAfter' => 0,

                                    'spaceBefore' => 0,

                                ]

                            );
                        }
                    }
                }









                $tablasAngulosFre_7_2[$indiceFre_7_2] =

                    $tablaAngulosFre_7_2;
            }









            if ($evaluacionesFre_7_2->isNotEmpty()) {









                $plantillaword->cloneBlock(

                    'BLOQUE_FRE',

                    $evaluacionesFre_7_2->count(),

                    true,

                    true

                );









                foreach (

                    $evaluacionesFre_7_2 as $indiceFre_7_2 => $evaluacionFre_7_2

                ) {



                    $numeroBloqueFre_7_2 =

                        $indiceFre_7_2 + 1;







                    $plantillaword->setComplexBlock(

                        'TABLA_DATOS_FRE#' . $numeroBloqueFre_7_2,

                        $tablasDatosFre_7_2[$indiceFre_7_2]

                    );





                    $plantillaword->setComplexBlock(

                        'TABLA_ANGULOS_FRE#' . $numeroBloqueFre_7_2,

                        $tablasAngulosFre_7_2[$indiceFre_7_2]

                    );

                    foreach (
                        [
                            'METODO_OWAS_FRE',
                            'ANALISIS_OWAS_FRE',
                            'METODO_ROSA_FRE',
                            'ANALISIS_ROSA_FRE',
                            'METODO_RULA_FRE',
                            'ANALISIS_RULA_FRE',
                            'RESULTADO_BORG',
                            'ANALISIS_BORG',
                            'DINAMOMETRIA_MARCADOR',
                            'OBSERVACION_FUERZAMANUAL',
                            'ASPECTOS_AMBIENTALES'
                        ] as $marcadorMetodoFre_7_2
                    ) {
                        $plantillaword->setValue(
                            $marcadorMetodoFre_7_2 . '#' . $numeroBloqueFre_7_2,
                            isset($tablasMetodosFre_7_2[$indiceFre_7_2][$marcadorMetodoFre_7_2])
                                ? $tablasMetodosFre_7_2[$indiceFre_7_2][$marcadorMetodoFre_7_2]
                                : ''
                        );
                    }
                }









                $propiedadXmlFre_7_2 = new \ReflectionProperty($plantillaword, 'tempDocumentMainPart');
                $propiedadXmlFre_7_2->setAccessible(true);
                $xmlDocumentoFre_7_2 = $propiedadXmlFre_7_2->getValue($plantillaword);
                foreach ($bloquesMetodosXmlFre_7_2 as $tokenFre_7_2 => $contenidoXmlFre_7_2) {
                    $patronTokenFre_7_2 = '~<w:p\b[^>]*>(?:(?!</w:p>).)*' . preg_quote($tokenFre_7_2, '~') . '.*?</w:p>~s';
                    $xmlDocumentoFre_7_2 = preg_replace_callback(
                        $patronTokenFre_7_2,
                        function () use ($contenidoXmlFre_7_2) {
                            return $contenidoXmlFre_7_2;
                        },
                        $xmlDocumentoFre_7_2,
                        1,
                        $reemplazosFre_7_2
                    );
                    if (empty($reemplazosFre_7_2)) {
                        $xmlDocumentoFre_7_2 = str_replace($tokenFre_7_2, $contenidoXmlFre_7_2, $xmlDocumentoFre_7_2);
                    }
                }
                $propiedadXmlFre_7_2->setValue($plantillaword, $xmlDocumentoFre_7_2);

                foreach (

                    $imagenesAngulosFre_7_2 as $claveImagenFre_7_2 => $rutaImagenFre_7_2

                ) {



                    if (

                        is_string($rutaImagenFre_7_2) &&

                        is_file($rutaImagenFre_7_2) &&

                        is_readable($rutaImagenFre_7_2)

                    ) {



                        $plantillaword->setImageValue(

                            $claveImagenFre_7_2,

                            [

                                'path' => $rutaImagenFre_7_2,

                                'width' => 380,

                                'height' => 280,

                                'ratio' => true,

                            ]

                        );
                    }
                }
            } else {









                $plantillaword->cloneBlock(

                    'BLOQUE_FRE',

                    1,

                    true,

                    true

                );





                $plantillaword->setValue(

                    'TABLA_DATOS_FRE#1',

                    'No hay registros de evaluación para este reconocimiento.'

                );





                $plantillaword->setValue(

                    'TABLA_ANGULOS_FRE#1',

                    'No hay ángulos registrados.'

                );

                foreach (
                    [
                        'METODO_OWAS_FRE',
                        'ANALISIS_OWAS_FRE',
                        'METODO_ROSA_FRE',
                        'ANALISIS_ROSA_FRE',
                        'METODO_RULA_FRE',
                        'ANALISIS_RULA_FRE',
                        'RESULTADO_BORG',
                        'ANALISIS_BORG',
                        'DINAMOMETRIA_MARCADOR',
                        'OBSERVACION_FUERZAMANUAL'
                    ] as $marcadorMetodoFre_7_2
                ) {
                    $plantillaword->setValue($marcadorMetodoFre_7_2 . '#1', '');
                }
            }





            //// DESCARGAR INFORME 





            $nombreWord = 'Informe de FRE2 ' . $proyecto->proyecto_folio . '-' . $proyecto->proyecto_clienteinstalacion . '.docx';

            $nombreWord = preg_replace('/[<>:"\/\\\\|?*]/', '', $nombreWord);

            $rutaWord = storage_path('app/temp/' . $nombreWord);

            $plantillaword->saveAs($rutaWord);




            return response()->download(
                $rutaWord
            )->deleteFileAfterSend(true);
        } catch (Exception $e) {

            return response()->json([

                'msj' =>
                'Error: ' .
                    $e->getMessage()

            ], 500);
        }
    }




}

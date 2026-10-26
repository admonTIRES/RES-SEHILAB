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
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
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
}

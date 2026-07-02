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
        $catdefiniciones = catergo_definicionesModel::whereIn('USO_DEFINICIONES', ['Reconocimiento', 'Ambos'])
            ->orderBy('CONCEPTO_DEFINICION', 'ASC')
            ->get();

        $catintroduccion = catergo_introduccionModel::where('ACTIVO', 1)->get();
        $catconclusion = catergo_conclusionModel::where('ACTIVO', 1)->get();
        $catrecomendaciones = catergo_recomendacionesModel::whereIn('USO_RECOMENDACIONES', ['Reconocimiento', 'Ambos'])->get();

        //// CAT EPP
        $catregionanatomica = catregionanatomicaModel::where('ACTIVO', 1)->get();
        $catclaveyepp = catclaveyeppModel::where('ACTIVO', 1)->get();



        return view('catalogos.ergo.evaluacionfre', compact('catdepartamento', 'catmovilfijo', 'catregimen', 'catjornada', 'caturno', 'catdefiniciones', 'catintroduccion', 'catconclusion', 'catrecomendaciones', 'catregionanatomica', 'catclaveyepp'));
    }



     public function Tablafichasevaluacionfre(Request $request)
    {
        try {

            $ergo = $request->get('ergoid');

            // $tabla = recoergofichastecnicasModel::select(
            //     'recoergo_fichastecnicas.*',
            //     'recoergocategorias.NOMBRE_CATEGORIA_ERGO as NOMBRE_CATEGORIA'
            // )
            //     ->leftJoin(
            //         'recoergocategorias',
            //         'recoergo_fichastecnicas.CATEGORIA_ID_FICHA',
            //         '=',
            //         'recoergocategorias.ID_CATEGORIA_ERGO'
            //     )
            //     ->where('recoergo_fichastecnicas.RECO_ID', $ergo)
            //     ->get();

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
                ->get();


            foreach ($tabla as $value) {

                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '
                    <button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                        <i class="bi bi-eye"></i>
                    </button>';

                    $value->BTN_VISUALIZAR = '
                    <button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>';
                } else {

                    $value->BTN_EDITAR = '
                    <button type="button" class="btn btn-warning btn-circle editar">
                        <i class="fa fa-eye"></i>
                    </button>';


                     $value->BTN_FICHA = '
                    <button type="button" class="btn btn-info  btn-circle iniciarfre">
                        <i class="fa fa-check-circle"></i>
                    </button>';


                }


                if ($value->ID_EVALUACION_FRE) {

                    $value->ESTATUS_FRE =
                        '<div class="text-center">
                            <span class="badge badge-pill badge-success" style="font-size:12px">
                                Iniciado
                            </span>
                        </div>';
                
                } else {

                    $value->ESTATUS_FRE =
                        '<div class="text-center">
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
        } catch (Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
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




}

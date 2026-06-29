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

        return view('catalogos.ergo.evaluacionfre', compact('catdepartamento', 'catmovilfijo', 'catregimen', 'catjornada', 'caturno', 'catdefiniciones', 'catintroduccion', 'catconclusion', 'catrecomendaciones'));
    }



     public function Tablafichasevaluacionfre(Request $request)
    {
        try {

            $ergo = $request->get('ergoid');

            $tabla = recoergofichastecnicasModel::select(
                'recoergo_fichastecnicas.*',
                'recoergocategorias.NOMBRE_CATEGORIA_ERGO as NOMBRE_CATEGORIA'
            )
                ->leftJoin(
                    'recoergocategorias',
                    'recoergo_fichastecnicas.CATEGORIA_ID_FICHA',
                    '=',
                    'recoergocategorias.ID_CATEGORIA_ERGO'
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

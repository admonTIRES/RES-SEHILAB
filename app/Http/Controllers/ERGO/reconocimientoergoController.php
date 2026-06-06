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



class reconocimientoergoController extends Controller
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

        return view('catalogos.ergo.reconocimiento_ergo', compact('catdepartamento', 'catmovilfijo', 'catregimen', 'catjornada', 'caturno', 'catdefiniciones', 'catintroduccion', 'catconclusion', 'catrecomendaciones'));
    }


    public function folioproyectoergp($proyecto_folio)
    {
        try {
            $opciones_select = '<option value="">&nbsp;</option>';

            $proyectos = DB::select(" SELECT 
                                    p.id, 
                                    p.proyecto_folio,
                                    p.proyecto_clienteinstalacion,
                                    p.proyecto_clientedireccionservicio,
                                    p.recsensorial_id
                                FROM 
                                    proyecto p
                                LEFT JOIN 
                                    serviciosProyecto sp ON p.id = sp.PROYECTO_ID
                                WHERE 
                                    sp.ERGO = 1
                                    AND sp.ERGO_RECONOCIMIENTO = 1
                                    AND (p.reconocimiento_ergo_id IS NULL OR p.proyecto_folio = ?) ", [$proyecto_folio]);

            foreach ($proyectos as $key => $value) {
                $displayText = '[' . htmlspecialchars($value->proyecto_folio) . '] ' . htmlspecialchars($value->proyecto_clienteinstalacion);

                if ($value->proyecto_folio == $proyecto_folio) {
                    $opciones_select .= '<option value="' . htmlspecialchars($value->proyecto_folio) . '" selected>' . $displayText . '</option>';
                } else {
                    $opciones_select .= '<option value="' . htmlspecialchars($value->proyecto_folio) . '">' . $displayText . '</option>';
                }
            }

            // // respuesta
            $dato['opciones'] = $opciones_select;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['opciones'] = $opciones_select;
            return response()->json($dato);
        }
    }


    public function estructuraproyectosergo($FOLIO)
    {
        try {

            $estructura = DB::select("SELECT p.proyecto_folio,
                                        p.id,
                                        ce.NOMBRE_ETIQUETA,
                                        ce.ID_ETIQUETA,
                                        co.NOMBRE_OPCIONES,
                                        ep.OPCION_ID, 
                                        ep.NIVEL
                                FROM  proyecto p
                                LEFT JOIN estructuraProyectos as ep ON p.id = ep.PROYECTO_ID
                                LEFT JOIN cat_etiquetas as ce ON ep.ETIQUETA_ID = ce.ID_ETIQUETA
                                LEFT JOIN catetiquetas_opciones as co ON ep.OPCION_ID = co.ID_OPCIONES_ETIQUETAS
                                WHERE p.proyecto_folio = ? ", [$FOLIO]);


            $infoProyecto = DB::select('SELECT p.proyecto_clienteinstalacion AS INSTALACION,
            p.proyecto_clientedireccionservicio AS DIRRECCION,
            p.proyecto_clientepersonacontacto AS REPRESENTANTE,
            p.proyecto_clienterfc AS RFC,
            p.proyecto_clienterazonsocial AS RAZON_SOCIAL,
            IFNULL(p.cliente_id, (SELECT CLIENTE_ID FROM contratos_clientes WHERE ID_CONTRATO = p.contrato_id)) AS CLIENTE_ID,
            IFNULL(p.contrato_id, 0) AS CONTRATO_ID,
            IF(p.requiereContrato = 0, "No aplica", 
                CASE p.tipoServicioCliente
                    WHEN 1 THEN "Contrato"
                    WHEN 2 THEN "O.S / O.C"
                    ELSE "Cotización aceptada"
                END) AS TIPO_SERVICIO,
            IF(p.contrato_id IS NULL, 
                "El proyecto seleccionado no tiene un contrato.", 
                (SELECT CONCAT(IF(NUMERO_CONTRATO IS NULL, "", CONCAT("[ ", NUMERO_CONTRATO, " ] ")), DESCRIPCION_CONTRATO)
                    FROM contratos_clientes 
                    WHERE ID_CONTRATO = p.contrato_id)) AS NOMBRE_CONTRATO,
            -- Campos adicionales si HI_RECONOCIMIENTO es 1
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.id, NULL) AS ID,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_representantelegal, NULL) AS REPRESENTANTE_LEGAL,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_coordenadas, NULL) AS COORDENADAS,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_ordenservicio, NULL) AS ORDENSERVICIO,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_codigopostal, NULL) AS CODIGOPOSTAL,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_actividadprincipal, NULL) AS ACTIVIDADPRINCIPAL,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_descripcionproceso, NULL) AS DESCRIPCIONPROCESO,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_obscategorias, NULL) AS OBSERVACION,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_fechainicio, NULL) AS FECHAINICIO,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_fechafin, NULL) AS FECHAFIN,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_fotoplano, NULL) AS FOTOPLANO,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_fotoubicacion, NULL) AS FOTOUBICACION,
                    IF(sp.HI_RECONOCIMIENTO = 1, rec.recsensorial_fotoinstalacion, NULL) AS FOTOINSTALACION
            FROM proyecto p
            LEFT JOIN cliente c ON c.id = p.cliente_id
            LEFT JOIN contratos_clientes cc ON cc.ID_CONTRATO = p.CONTRATO_ID
            LEFT JOIN serviciosProyecto sp ON sp.PROYECTO_ID = p.id
            LEFT JOIN recsensorial rec ON rec.id = p.recsensorial_id -- Aquí se asume que recsensorial tiene un campo proyecto_id
            WHERE p.proyecto_folio = ?', [$FOLIO]);

            $higiene = DB::select("SELECT sp.HI_RECONOCIMIENTO 
                                    FROM proyecto p LEFT JOIN serviciosProyecto sp ON sp.PROYECTO_ID = p.id 
                                    WHERE p.proyecto_folio = ?", [$FOLIO]);

            $dato['HIGIENE'] = $higiene;
            $dato['data'] = $estructura;
            $dato['info'] = $infoProyecto;
            $dato["msj"] = 'Informacion consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }


    public function tablareconocimientoergo()
    {
        try {
            $recsensorial = reconocimientoergoModel::all();

            // Formatear las filas
            $numero_registro = 0;
            foreach ($recsensorial as $key => $value) {
                $numero_registro += 1;
                $value->numero_registro = $numero_registro;
                $value->boton_mostrar = '<button type="button" class="btn btn-info btn-circle" style="padding: 0px;"><i class="fa fa-eye fa-2x"></i></button>';
            }

            // BOTON MOSTRAR [reconocimiento Bloqueado]


            // Respuesta en JSON
            $dato['data'] = $recsensorial;
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostrarmapaubicacionergo($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = reconocimientoergoModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->fotoubicacion);
        } else {
            return Storage::download($recsensorial->fotoubicacion);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostraplanoergo($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = reconocimientoergoModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->fotoplano);
        } else {
            return Storage::download($recsensorial->fotoplano);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostrafotoinstalacionergo($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = reconocimientoergoModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->fotoinstalacion);
        } else {
            return Storage::download($recsensorial->fotoinstalacion);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostrarmapariesgoergo($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = reconocimientoergoModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->fotomapariesgo);
        } else {
            return Storage::download($recsensorial->fotomapariesgo);
        }
    }




    // public function sincronizarHigieneErgo(Request $request)
    // {
    //     try {

    //         $reconocimientoergo = reconocimientoergoModel::findOrFail(
    //             $request->RECO_ID
    //         );

    //         $proyecto = proyectoModel::where(
    //             'proyecto_folio',
    //             $reconocimientoergo->proyecto_folio
    //         )->first();

    //         if (
    //             !$proyecto ||
    //             is_null($proyecto->recsensorial_id)
    //         ) {

    //             return response()->json([
    //                 'code' => 0,
    //                 'msj' => 'Este proyecto no cuenta con un reconocimiento en Higiene Industrial para poder sincronizar categorías y áreas.'
    //             ]);
    //         }

    //         $recsensorial_id = $proyecto->recsensorial_id;

    //         $categorias = DB::table('recsensorialcategoria')
    //             ->where('recsensorial_id', $recsensorial_id)
    //             ->get();

    //         foreach ($categorias as $categoria) {

    //             $categoriaErgo = recoergocategoriasModel::where(
    //                 'RECO_ID',
    //                 $reconocimientoergo->id
    //             )
    //                 ->where(
    //                     'CATEGORIAS_ID_HI',
    //                     $categoria->id
    //                 )
    //                 ->first();

    //             if ($categoriaErgo) {
    //                 $categoriaErgo->update([
    //                     'NOMBRE_CATEGORIA_ERGO' => $categoria->recsensorialcategoria_nombrecategoria,
    //                     'CAT_DEPARTAMENTO' => $categoria->catdepartamento_id,
    //                     'CAT_TIPOPUESTO' => $categoria->catmovilfijo_id,
    //                     'JSON_TURNOS' => $categoria->JSON_TURNOS
    //                 ]);
    //             } else {

    //                 recoergocategoriasModel::create([
    //                     'RECO_ID' => $reconocimientoergo->id,
    //                     'CATEGORIAS_ID_HI' => $categoria->id,
    //                     'NOMBRE_CATEGORIA_ERGO' => $categoria->recsensorialcategoria_nombrecategoria,
    //                     'CAT_DEPARTAMENTO' => $categoria->catdepartamento_id,
    //                     'CAT_TIPOPUESTO' => $categoria->catmovilfijo_id,
    //                     'JSON_TURNOS' => $categoria->JSON_TURNOS,
    //                     'ACTIVO' => 1
    //                 ]);
    //             }
    //         }

    //         $areas = DB::table('recsensorialarea')
    //             ->where('recsensorial_id', $recsensorial_id)
    //             ->get();

    //         foreach ($areas as $area) {


    //             $areaErgo = recoergoareasModel::where(
    //                 'RECO_ID',
    //                 $reconocimientoergo->id
    //             )
    //                 ->where(
    //                     'AREA_ID_HI',
    //                     $area->id
    //                 )
    //                 ->first();
    //             if ($areaErgo) {
    //                 $areaErgo->update([

    //                     'NOMBRE_AREA_ERGO' => $area->recsensorialarea_nombre,
    //                     'DESCRIPCION_AREA_ERGO' => $area->RECSENSORIALAREA_PROCESO
    //                 ]);
    //             } else {
    //                 recoergoareasModel::create([
    //                     'RECO_ID' => $reconocimientoergo->id,
    //                     'AREA_ID_HI' => $area->id,
    //                     'NOMBRE_AREA_ERGO' => $area->recsensorialarea_nombre,
    //                     'DESCRIPCION_AREA_ERGO' => $area->RECSENSORIALAREA_PROCESO,
    //                     'ACTIVO' => 1
    //                 ]);
    //             }
    //         }

    //         return response()->json([
    //             'code' => 1,
    //             'msj' => 'Categorías y áreas sincronizadas correctamente desde Higiene Industrial.'
    //         ]);
    //     } catch (Exception $e) {

    //         return response()->json([
    //             'code' => 0,
    //             'msj' => $e->getMessage()
    //         ]);
    //     }
    // }



    public function sincronizarHigieneErgo(Request $request)
    {
        try {

            if (($request->RECO_ID + 0) == 0) {

                return response()->json([
                    'code' => 2,
                    'msj' => 'Primero debe guardar el reconocimiento ergonómico antes de sincronizar.'
                ]);
            }

            $reconocimientoergo = reconocimientoergoModel::find($request->RECO_ID);

            if (!$reconocimientoergo) {

                return response()->json([
                    'code' => 2,
                    'msj' => 'Primero debe guardar el reconocimiento ergonómico antes de sincronizar.'
                ]);
            }

            $proyecto = proyectoModel::where(
                'proyecto_folio',
                $reconocimientoergo->proyecto_folio
            )->first();

            if (
                !$proyecto ||
                is_null($proyecto->recsensorial_id)
            ) {

                return response()->json([
                    'code' => 0,
                    'msj' => 'Este proyecto no cuenta con un reconocimiento en Higiene Industrial para poder sincronizar categorías y áreas.'
                ]);
            }

            $recsensorial_id = $proyecto->recsensorial_id;

            $categorias = DB::table('recsensorialcategoria')
                ->where('recsensorial_id', $recsensorial_id)
                ->get();

            foreach ($categorias as $categoria) {

                $categoriaErgo = recoergocategoriasModel::where(
                    'RECO_ID',
                    $reconocimientoergo->id
                )
                    ->where(
                        'CATEGORIAS_ID_HI',
                        $categoria->id
                    )
                    ->first();

                if ($categoriaErgo) {

                    $categoriaErgo->update([
                        'NOMBRE_CATEGORIA_ERGO' => $categoria->recsensorialcategoria_nombrecategoria,
                        'CAT_DEPARTAMENTO' => $categoria->catdepartamento_id,
                        'CAT_TIPOPUESTO' => $categoria->catmovilfijo_id,
                        'JSON_TURNOS' => $categoria->JSON_TURNOS
                    ]);
                } else {

                    recoergocategoriasModel::create([
                        'RECO_ID' => $reconocimientoergo->id,
                        'CATEGORIAS_ID_HI' => $categoria->id,
                        'NOMBRE_CATEGORIA_ERGO' => $categoria->recsensorialcategoria_nombrecategoria,
                        'CAT_DEPARTAMENTO' => $categoria->catdepartamento_id,
                        'CAT_TIPOPUESTO' => $categoria->catmovilfijo_id,
                        'JSON_TURNOS' => $categoria->JSON_TURNOS,
                        'ACTIVO' => 1
                    ]);
                }
            }

            $areas = DB::table('recsensorialarea')
                ->where('recsensorial_id', $recsensorial_id)
                ->get();

            foreach ($areas as $area) {

                $areaErgo = recoergoareasModel::where(
                    'RECO_ID',
                    $reconocimientoergo->id
                )
                    ->where(
                        'AREA_ID_HI',
                        $area->id
                    )
                    ->first();

                if ($areaErgo) {

                    $areaErgo->update([
                        'NOMBRE_AREA_ERGO' => $area->recsensorialarea_nombre,
                        'DESCRIPCION_AREA_ERGO' => $area->RECSENSORIALAREA_PROCESO
                    ]);
                } else {

                    recoergoareasModel::create([
                        'RECO_ID' => $reconocimientoergo->id,
                        'AREA_ID_HI' => $area->id,
                        'NOMBRE_AREA_ERGO' => $area->recsensorialarea_nombre,
                        'DESCRIPCION_AREA_ERGO' => $area->RECSENSORIALAREA_PROCESO,
                        'ACTIVO' => 1
                    ]);
                }
            }

            return response()->json([
                'code' => 1,
                'msj' => 'Categorías y áreas sincronizadas correctamente desde Higiene Industrial.'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'code' => 0,
                'msj' => $e->getMessage()
            ]);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());


            if (($request->opcion + 0) == 1) // DATOS DEL RECONOCIMIENTO
            {
                $ano = (date('y')) + 0;
                $recsensorial_activo = 0;

                if (($request->recsensorial_id + 0) == 0) //nuevo
                {

                    DB::statement('ALTER TABLE reconocimientoergo AUTO_INCREMENT=1');

                    //Verificamos si el reconocimiento requiere contrato de no requerir autorizado lo ponemos como 0 para que deba ser autorizado
                    if (intval($request->requiere_contrato) == 1) {
                        $request['autorizado'] = 1;
                        $request['recsensorial_bloqueado'] = 0;
                    } else {
                        $request['recsensorial_bloqueado'] = 1;
                        $request['autorizado'] = 0;
                        $request['contrato_id'] = 0;
                    }

                    $reconocimientoergo = reconocimientoergoModel::create($request->all());
                    // $recsensorial->recsensorialpruebas()->sync($request->parametro); // SE COMENTO PORQUE YA SON DOS ARREGLOS DE PRUEBAS ENTONCES SI HIZO APARTE

                    //UNA VEZ GUARDADO TODO LO DE RECONOCIMIENTO PROCEDEMOS A VINCULAR EL  ID DEL RECONOCIMIENTO CON EL PROYECTO
                    $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                    $proyecto->reconocimiento_ergo_id = $reconocimientoergo->id;
                    $proyecto->save();


                    // mensaje
                    $dato["msj"] = 'Información guardada correctamente y vinculado con el proyecto: ' . $request["proyecto_folio"];
                    $recsensorial_activo = 1;



                    if ($request->file('inputfotomapa')) {

                        $extension = $request->file('inputfotomapa')->getClientOriginalExtension();

                        $request['fotoubicacion'] = $request->file('inputfotomapa')
                            ->storeAs(
                            'reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa',
                                $reconocimientoergo->id . '.' . $extension
                            );

                        $reconocimientoergo->update($request->all());
                    } else {

                        if (!empty($request['hidden_fotomapa_ruta'])) {

                            $rutaOriginal = $request['hidden_fotomapa_ruta'];

                            if (Storage::exists($rutaOriginal)) {

                                $extension = pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                                $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa/' . $reconocimientoergo->id . '.' . $extension;

                                Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa');

                                Storage::copy($rutaOriginal, $nuevaRuta);

                                $reconocimientoergo->fotoubicacion = $nuevaRuta;
                                $reconocimientoergo->save();
                            }
                        }
                    }





                    // if ($request->file('inputfotomapa')) {

                    //     $extension = $request->file('inputfotomapa')->getClientOriginalExtension();

                    //     $request['fotoubicacion'] = $request->file('inputfotomapa')
                    //         ->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa', $reconocimientoergo->id . '.' . $extension);

                    //     $reconocimientoergo->update($request->all());
                    // } else {

                    //     if (!empty($request['hidden_fotomapa']) && !empty($request['hidden_fotomapa_extension'])) {

                    //         $recsensorial_id = $request['hidden_fotomapa'];
                    //         $recsensorial_extension = $request['hidden_fotomapa_extension'];

                    //         $rutaOriginal = 'recsensorial/' . $recsensorial_id . '/mapa/' . $recsensorial_id . $recsensorial_extension;

                    //         if (Storage::exists($rutaOriginal)) {

                    //             $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa/' . $reconocimientoergo->id . '.' . pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                    //             Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa');
                    //             Storage::copy($rutaOriginal, $nuevaRuta);

                    //             $reconocimientoergo->fotoubicacion = $nuevaRuta;
                    //             $reconocimientoergo->save();
                    //         }
                    //     }
                    // }


                    // if ($request->file('inputfotoplano')) {

                    //     $extension = $request->file('inputfotoplano')->getClientOriginalExtension();

                    //     $request['fotoplano'] = $request->file('inputfotoplano')
                    //         ->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/plano', $reconocimientoergo->id . '.' . $extension);

                    //     $reconocimientoergo->update($request->all());
                    // } else {

                    //     if (!empty($request['hidden_fotoplano']) && !empty($request['hidden_fotoplano_extension'])) {

                    //         $recsensorial_id = $request['hidden_fotoplano'];
                    //         $recsensorial_extension = $request['hidden_fotoplano_extension'];

                    //         $rutaOriginal = 'recsensorial/' . $recsensorial_id . '/plano/' . $recsensorial_id . $recsensorial_extension;

                    //         if (Storage::exists($rutaOriginal)) {

                    //             $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/plano/' . $reconocimientoergo->id . '.' . pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                    //             Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/plano');
                    //             Storage::copy($rutaOriginal, $nuevaRuta);

                    //             $reconocimientoergo->fotoplano = $nuevaRuta;
                    //             $reconocimientoergo->save();
                    //         }
                    //     }
                    // }



                    if ($request->file('inputfotoplano')) {

                        $extension = $request->file('inputfotoplano')->getClientOriginalExtension();

                        $request['fotoplano'] = $request->file('inputfotoplano')
                            ->storeAs(
                            'reconocimiento_ergo/' . $reconocimientoergo->id . '/plano',
                                $reconocimientoergo->id . '.' . $extension
                            );

                        $reconocimientoergo->update($request->all());
                    } else {

                        if (!empty($request['hidden_fotoplano_ruta'])) {

                            $rutaOriginal = $request['hidden_fotoplano_ruta'];

                            if (Storage::exists($rutaOriginal)) {

                                $extension = pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                                $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/plano/' . $reconocimientoergo->id . '.' . $extension;

                                Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/plano');

                                Storage::copy($rutaOriginal, $nuevaRuta);

                                $reconocimientoergo->fotoplano = $nuevaRuta;
                                $reconocimientoergo->save();
                            }
                        }
                    }



                    // si envia archivo FOTO instalacion


                    // if ($request->file('inputfotoinstalacion')) {

                    //     $extension = $request->file('inputfotoinstalacion')->getClientOriginalExtension();

                    //     $request['fotoinstalacion'] = $request->file('inputfotoinstalacion')
                    //         ->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion', $reconocimientoergo->id . '.' . $extension);

                    //     $reconocimientoergo->update($request->all());
                    // } else {

                    //     if (!empty($request['hidden_fotoinstalacion']) && !empty($request['hidden_fotoinstalacion_extension'])) {

                    //         $recsensorial_id = $request['hidden_fotoinstalacion'];
                    //         $recsensorial_extension = $request['hidden_fotoinstalacion_extension'];

                    //         $rutaOriginal = 'recsensorial/' . $recsensorial_id . '/instalacion/' . $recsensorial_id . $recsensorial_extension;

                    //         if (Storage::exists($rutaOriginal)) {

                    //             $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion/' . $reconocimientoergo->id . '.' . pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                    //             Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion');
                    //             Storage::copy($rutaOriginal, $nuevaRuta);

                    //             $reconocimientoergo->fotoinstalacion = $nuevaRuta;
                    //             $reconocimientoergo->save();
                    //         }
                    //     }
                    // }


                    if ($request->file('inputfotoinstalacion')) {

                        $extension = $request->file('inputfotoinstalacion')->getClientOriginalExtension();

                        $request['fotoinstalacion'] = $request->file('inputfotoinstalacion')
                            ->storeAs(
                            'reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion',
                                $reconocimientoergo->id . '.' . $extension
                            );

                        $reconocimientoergo->update($request->all());
                    } else {

                        if (!empty($request['hidden_fotoinstalacion_ruta'])) {

                            $rutaOriginal = $request['hidden_fotoinstalacion_ruta'];

                            if (Storage::exists($rutaOriginal)) {

                                $extension = pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                                $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion/' . $reconocimientoergo->id . '.' . $extension;

                                Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/instalacion');

                                Storage::copy($rutaOriginal, $nuevaRuta);

                                $reconocimientoergo->fotoinstalacion = $nuevaRuta;
                                $reconocimientoergo->save();
                            }
                        }
                    }


                    
                    // // si envia archivo MAPA DE RIESGO


                    if ($request->file('inputfotomapaderiesgo')) {

                        $extension = $request->file('inputfotomapaderiesgo')->getClientOriginalExtension();

                        $request['fotomapariesgo'] = $request->file('inputfotomapaderiesgo')
                            ->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa de riesgo', $reconocimientoergo->id . '.' . $extension);

                        $reconocimientoergo->update($request->all());
                    } else {

                        if (!empty($request['hidden_fotomapariesgo']) && !empty($request['hidden_fotomapariesgo_extension'])) {

                            $recsensorial_id = $request['hidden_fotomapariesgo'];
                            $recsensorial_extension = $request['hidden_fotomapariesgo_extension'];

                            $rutaOriginal = 'recsensorial/' . $recsensorial_id . '/mapa de riesgo/' . $recsensorial_id . $recsensorial_extension;

                            if (Storage::exists($rutaOriginal)) {

                                $nuevaRuta = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa de riesgo/' . $reconocimientoergo->id . '.' . pathinfo($rutaOriginal, PATHINFO_EXTENSION);

                                Storage::makeDirectory('reconocimiento_ergo/' . $reconocimientoergo->id . '/mapa de riesgo');
                                Storage::copy($rutaOriginal, $nuevaRuta);

                                $reconocimientoergo->fotomapariesgo = $nuevaRuta;
                                $reconocimientoergo->save();
                            }
                        }
                    }
                } else { //EDITAR 

                    // Obtener registro
                    $reconocimientoergo = reconocimientoergoModel::findOrFail($request->recsensorial_id);

                    // consultar ID ultimo registro de la tabla
                    $reconocimientoergo_idmax = DB::select('SELECT
                                                            MAX( reconocimientoergo.id ) AS reconocimientoergo_idmax
                                                        FROM
                                                            reconocimientoergo');

                    // Validar que sea el ultimo ID, y permita editar folios

                    $reconocimientoergo->update($request->all());
                    // $recsensorial->recsensorialpruebas()->sync($request->parametro);

                    ///VERIFICAMOS QUE EL FOLIO DEL PROYECTO QUE ENVIA SEA EL MISMO
                    if ($reconocimientoergo->proyecto_folio == $request['proyecto_folio']) {

                        $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                        $proyecto->reconocimiento_ergo_id = $reconocimientoergo->id;
                        $proyecto->save();
                    } else {


                        $proyecto = proyectoModel::where('proyecto_folio', $reconocimientoergo->proyecto_folio)->first();
                        $proyecto->reconocimiento_ergo_id = null;
                        $proyecto->save();


                        $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                        $proyecto->reconocimiento_ergo_id = $reconocimientoergo->id;
                        $proyecto->save();
                    }





                    function eliminarArchivoAntiguo($id, $folder)
                    {
                        // Definir la ruta del directorio
                        $directory = 'reconocimiento_ergo/' . $id . '/' . $folder;

                        // Buscar y eliminar cualquier archivo con el mismo nombre, pero con diferente extensión
                        $files = Storage::files($directory);
                        foreach ($files as $file) {
                            // Verificar si el archivo coincide con el nombre, independientemente de la extensión
                            if (pathinfo($file, PATHINFO_FILENAME) == $id) {
                                Storage::delete($file);
                            }
                        }
                    }

                    if ($request->file('inputfotomapa')) {
                        $extension = $request->file('inputfotomapa')->getClientOriginalExtension();
                        $folder = 'mapa';
                        $path = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder . '/' . $reconocimientoergo->id . '.' . $extension;

                        // Eliminar cualquier archivo antiguo, sin importar la extensión
                        eliminarArchivoAntiguo($reconocimientoergo->id, $folder);

                        // Guardar la nueva foto
                        $request['fotoubicacion'] = $request->file('inputfotomapa')->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder, $reconocimientoergo->id . '.' . $extension);
                        $reconocimientoergo->update($request->all());
                    }

                    // Para el archivo FOTO plano
                    if ($request->file('inputfotoplano')) {
                        $extension = $request->file('inputfotoplano')->getClientOriginalExtension();
                        $folder = 'plano';
                        $path = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder . '/' . $reconocimientoergo->id . '.' . $extension;

                        eliminarArchivoAntiguo($reconocimientoergo->id, $folder);

                        $request['fotoplano'] = $request->file('inputfotoplano')->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder, $reconocimientoergo->id . '.' . $extension);
                        $reconocimientoergo->update($request->all());
                    }

                    // Para el archivo FOTO instalación
                    if ($request->file('inputfotoinstalacion')) {
                        $extension = $request->file('inputfotoinstalacion')->getClientOriginalExtension();
                        $folder = 'instalacion';
                        $path = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder . '/' . $reconocimientoergo->id . '.' . $extension;

                        eliminarArchivoAntiguo($reconocimientoergo->id, $folder);

                        $request['fotoinstalacion'] = $request->file('inputfotoinstalacion')->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder, $reconocimientoergo->id . '.' . $extension);
                        $reconocimientoergo->update($request->all());
                    }

                    // // Para el archivo FOTO instalación
                    if ($request->file('inputfotomapaderiesgo')) {
                        $extension = $request->file('inputfotomapaderiesgo')->getClientOriginalExtension();
                        $folder = 'mapa de riesgo';
                        $path = 'reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder . '/' . $reconocimientoergo->id . '.' . $extension;

                        eliminarArchivoAntiguo($reconocimientoergo->id, $folder);

                        $request['fotomapariesgo'] = $request->file('inputfotomapaderiesgo')->storeAs('reconocimiento_ergo/' . $reconocimientoergo->id . '/' . $folder, $reconocimientoergo->id . '.' . $extension);
                        $reconocimientoergo->update($request->all());
                    }

                    // mensaje
                    $dato["msj"] = 'Información modificada correctamente';
                }


                // respuesta
                $dato['recsensorial_activo'] = $recsensorial_activo;
                $dato['recsensorial'] = $reconocimientoergo;
            }



            if (($request->opcion + 0) == 3) // RESPONSABLES DEL RECONOCIMIENTO
            {

                $reconocimientoergo = reconocimientoergoModel::findOrFail($request->recsensorial_id);

                // dd($recsensorial->all());

                if ($request->NOMBRE_TECNICO) // RESPONSABLES DEL RECONOCIMIENTO
                {
                    if ($request->file('TECNICO_DOC_IMG')) {
                        $extension = $request->file('TECNICO_DOC_IMG')->getClientOriginalExtension();
                        $request['TECNICO_DOC'] = $request->file('TECNICO_DOC_IMG')->storeAs('reconocimiento_ergo/' . $request->recsensorial_id . '/responsables', 'rep_tecnico.' . $extension);
                    }

                    if ($request->file('CONTRATO_DOC_IMG')) {
                        $extension = $request->file('CONTRATO_DOC_IMG')->getClientOriginalExtension();
                        $request['CONTRATO_DOC'] = $request->file('CONTRATO_DOC_IMG')->storeAs('reconocimiento_ergo/' . $request->recsensorial_id . '/responsables', 'rep_admin.' . $extension);
                    }
                } else {
                    // Eliminar carpeta si acaso existio
                    Storage::deleteDirectory('reconocimiento_ergo/' . $request->recsensorial_id . '/responsables');

                    $request['NOMBRE_TECNICO'] = NULL;
                    $request['NOMBRE_CONTRATO'] = NULL;
                    $request['CARGO_TECNICO'] = NULL;
                    $request['CARGO_CONTRATO'] = NULL;
                    $request['TECNICO_DOC'] = NULL;
                    $request['CONTRATO_DOC'] = NULL;
                }

                $reconocimientoergo->update($request->all());

                // respuesta
                $dato["msj"] = 'Datos de los responsables guardado correctamente';
                $dato['recsensorial'] = $reconocimientoergo;
            }
            if (($request->opcion + 0) == 5) // PREGUNTAS DE GUIA 5
            {
                $dato['code'] = 200;
                $dato["msj"] = 'Información modificada correctamente';
            }

            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['recsensorial'] = 0;
            $dato["recsensorial_bloqueado"] = 0;
            return response()->json($dato);
        }
    }


    /////// INFORME ERGO /////////



    // public function getGraficaErgo($reco_id)
    // {
    //     $datos = DB::table('recoergo_fichastecnicas as f')

    //         ->join(
    //             'recoergocategorias as c',
    //             'f.CATEGORIA_ID_FICHA',
    //             '=',
    //             'c.ID_CATEGORIA_ERGO'
    //         )

    //         ->select(

    //             'f.CATEGORIA_ID_FICHA',

    //             'c.NOMBRE_CATEGORIA_ERGO',

    //             DB::raw("
    //             CASE 
    //                 WHEN SUM(
    //                     CASE 
    //                         WHEN f.P1_CARGA_MAYOR_3KG = 'SI' 
    //                         THEN 1 
    //                         ELSE 0 
    //                     END
    //                 ) > 0 
    //                 THEN 'SI' 
    //                 ELSE 'NO' 
    //             END as P1_RESULTADO
    //         "),

    //             DB::raw("
    //             CASE 
    //                 WHEN SUM(
    //                     CASE 
    //                         WHEN f.P2_FRECUENCIA_CARGA = 'SI' 
    //                         THEN 1 
    //                         ELSE 0 
    //                     END
    //                 ) > 0 
    //                 THEN 'SI' 
    //                 ELSE 'NO' 
    //             END as P2_RESULTADO
    //         "),

    //             DB::raw("
    //             CASE 
    //                 WHEN SUM(
    //                     CASE 
    //                         WHEN f.P3_MANIPULACION_CARGA = 'SI' 
    //                         THEN 1 
    //                         ELSE 0 
    //                     END
    //                 ) > 0 
    //                 THEN 'SI' 
    //                 ELSE 'NO' 
    //             END as P3_RESULTADO
    //         ")

    //         )

    //         ->where('f.RECO_ID', $reco_id)

    //         ->where('f.ACTIVO', 1)

    //         ->groupBy(
    //             'f.CATEGORIA_ID_FICHA',
    //             'c.NOMBRE_CATEGORIA_ERGO'
    //         )

    //         ->orderBy('c.PT_CATEGORIA', 'ASC')

    //         ->get();

    //     return response()->json($datos);
    // }



    public function getGraficaErgo($reco_id)
    {
        $datos = DB::table('recoergo_fichastecnicas as f')

            ->join(
                'recoergocategorias as c',
                'f.CATEGORIA_ID_FICHA',
                '=',
                'c.ID_CATEGORIA_ERGO'
            )

            ->select(

                'f.CATEGORIA_ID_FICHA',

                'c.NOMBRE_CATEGORIA_ERGO',

                DB::raw('COUNT(*) as TOTAL_REGISTROS'),

                DB::raw("
                CASE
                    WHEN SUM(
                        CASE
                            WHEN f.P1_CARGA_MAYOR_3KG = 'SI'
                            THEN 1
                            ELSE 0
                        END
                    ) > 0
                    THEN 'SI'
                    ELSE 'NO'
                END as P1_RESULTADO
            "),

                DB::raw("
                CASE
                    WHEN SUM(
                        CASE
                            WHEN f.P2_FRECUENCIA_CARGA = 'SI'
                            THEN 1
                            ELSE 0
                        END
                    ) > 0
                    THEN 'SI'
                    ELSE 'NO'
                END as P2_RESULTADO
            "),

                DB::raw("
                CASE
                    WHEN SUM(
                        CASE
                            WHEN f.P3_MANIPULACION_CARGA = 'SI'
                            THEN 1
                            ELSE 0
                        END
                    ) > 0
                    THEN 'SI'
                    ELSE 'NO'
                END as P3_RESULTADO
            ")

            )

            ->where('f.RECO_ID', $reco_id)

            ->where('f.ACTIVO', 1)

            ->groupBy(
                'f.CATEGORIA_ID_FICHA',
                'c.NOMBRE_CATEGORIA_ERGO'
            )

            ->orderBy('c.PT_CATEGORIA', 'ASC')

            ->get();

        return response()->json($datos);
    }

    
    ///// GRAFICA FICHAS




    public function getGraficasFichas($reco_id)
    {
        $fichas = DB::table('recoergo_fichastecnicas')
            ->where('RECO_ID', $reco_id)
            ->where('ACTIVO', 1)
            ->get();

        $resultado = [];

        foreach ($fichas as $ficha) {

            $json = json_decode($ficha->JSON_FICHAS, true);

            if (!$json) {
                continue;
            }

            foreach ($json as $bloque) {

                $nombreFicha = $bloque['ficha'];

                $fichasPermitidas = [
                    '1.1',
                    '1.2',
                    '2.1',
                    '3.1',
                    '4.1',
                    '4.2'
                ];

                if (!in_array($nombreFicha, $fichasPermitidas)) {
                    continue;
                }

                $titulos = [

                    '1.1' => 'Levantamiento de cargas',
                    '1.2' => 'Transporte de cargas',
                    '2.1' => 'Empuje y tracción de cargas',
                    '3.1' => 'Movimientos repetitivos',
                    '4.1' => 'Posturas estáticas forzadas',
                    '4.2' => 'Posturas dinámicas forzadas'
                ];

                if (!isset($resultado[$nombreFicha])) {

                    $resultado[$nombreFicha] = [

                        'ficha' => $nombreFicha,

                        'titulo' => $titulos[$nombreFicha],

                        'preguntas' => []
                    ];
                }


                foreach ($bloque['preguntas'] as $pregunta) {

                    $letra = $pregunta['name'];

                    if (!isset($resultado[$nombreFicha]['preguntas'][$letra])) {

                        $resultado[$nombreFicha]['preguntas'][$letra] = [

                            'texto' => $pregunta['texto'],

                            'SI' => 0,

                            'NO' => 0
                        ];
                    }

                    if (trim($pregunta['respuesta']) == 'SI') {

                        $resultado[$nombreFicha]['preguntas'][$letra]['SI']++;
                    } else {

                        $resultado[$nombreFicha]['preguntas'][$letra]['NO']++;
                    }
                }
            }
        }

        return response()->json(array_values($resultado));
    }


    //// TABLA MAPA DE RIESGO 
    public function getMapaPeligros($reco_id)
    {
        $criterios = [
            '1.1' => 'Levantamiento de cargas',
            '1.2' => 'Transporte de cargas',
            '2.1' => 'Empuje y tracción de cargas',
            '3.1' => 'Movimientos repetitivos',
            '4.1' => 'Posturas estáticas forzadas',
            '4.2' => 'Posturas dinámicas forzadas'
        ];

        $fichas = recoergofichastecnicasModel::where(
            'RECO_ID',
            $reco_id
        )
            ->where('ACTIVO', 1)
            ->whereNotNull('PE_EVALUADAS')
            ->where('PE_EVALUADAS', '!=', '')
            ->orderBy('ID_FICHAS_TECNICAS')
            ->get();

        $respuesta = [];

        foreach ($criterios as $codigo => $titulo) {

            $fila = [];
            $fila['codigo'] = $codigo;
            $fila['titulo'] = $titulo;
            $fila['resultados'] = [];

            foreach ($fichas as $ficha) {

                $resultadoFinal = 'VERDE';

                $json = json_decode(
                    $ficha->JSON_FICHAS,
                    true
                );

                if ($json) {

                    foreach ($json as $bloque) {

                        if (
                            isset($bloque['ficha']) &&
                            $bloque['ficha'] == $codigo
                        ) {

                            if (
                                isset($bloque['resultado']) &&
                                strtoupper($bloque['resultado']) == 'ROJO'
                            ) {

                                $resultadoFinal = 'ROJO';
                                break;
                            }
                        }
                    }
                }

                $fila['resultados'][$ficha->ID_FICHAS_TECNICAS] = $resultadoFinal;
            }

            $respuesta[] = $fila;
        }

        return response()->json([
            'fichas' => $fichas,
            'criterios' => $respuesta
        ]);
    }


    public function obtenerDatosInformesRecoergo($ID)
    {
        try {

            $opciones_select = '<option value="">&nbsp;</option>';
            $html  = '<option value="">&nbsp;</option>';

            $info = DB::select('SELECT 
                                ID_RECURSO_INFORME,
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
                            FROM recursosPortadasRecoErgo
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





    public function guardarPortadaRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();


            $recurso = recursosPortadaRecoErgoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$recurso) {
                $recurso = new recursosPortadaRecoErgoModel();
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
                    'reconocimiento_ergo/' . $request->RECO_ID . '/foto_portada',
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

    public function mostrarportadarecoergo($archivo_opcion, $reco_id)
    {
        $recurso = recursosPortadaRecoErgoModel::where(
            'RECO_ID',
            $reco_id
        )->firstOrFail();

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->RUTA_IMAGEN_PORTADA);
        } else {
            return Storage::download($recurso->RUTA_IMAGEN_PORTADA);
        }
    }

    public function obtenerDatosGeneralesInformeReco($RECO_ID)
    {
        try {

            $dato = datosgeneralesinformeRecoModel::where(
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

    public function guardarIntroduccionRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();
            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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

    public function guardarDefinicionesInformeErgo(Request $request)
    {
        try {

            DB::beginTransaction();


            definicionesinformeergoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->delete();

            if ($request->DEFINICONES_INFORME) {

                foreach ($request->DEFINICONES_INFORME as $definicion) {
                    $dato = new definicionesinformeergoModel();
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

    public function obtenerDefinicionesInformeErgo($RECO_ID)
    {
        $datos = definicionesinformeergoModel::where(
            'RECO_ID',
            $RECO_ID
        )->get();
        return response()->json($datos);
    }

    public function guardarObjetivoGeneralRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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

    public function guardarObjetivoEspecificoRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();


            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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

    public function guardarUbicacionRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();


            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
                $dato->RECO_ID = $request->RECO_ID;
                $dato->save();
            }

            $dato->INFORME_UBICACIONINSTALACION = $request->INFORME_UBICACIONINSTALACION;


            if ($request->file('RUTA_IMAGEN_UBICACION')) {

                $extension = $request->file('RUTA_IMAGEN_UBICACION')->getClientOriginalExtension();
                $ruta = $request->file('RUTA_IMAGEN_UBICACION')->storeAs(
                    'reconocimiento_ergo/' . $request->RECO_ID . '/foto_ubicacion',
                    $request->RECO_ID . '.' . $extension

                );

                $dato->RUTA_IMAGEN_UBICACION = $ruta;
            }


            $dato->save();
            DB::commit();


            return response()->json([
                'msj' => 'Ubicación guardada correctamente'
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'msj' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }




    public function mostrarubicacionrecoergo($archivo_opcion, $reco_id, $extension)
    {

        $recurso = datosgeneralesinformeRecoModel::where(
            'RECO_ID',
            $reco_id
        )->firstOrFail();

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->RUTA_IMAGEN_UBICACION);
        } else {
            return Storage::download($recurso->RUTA_IMAGEN_UBICACION);
        }
    }

    public function guardarProcesoInstalacionRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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



    public function tablaReporteCategoriasErgo(Request $request)
    {
        $categorias = recoergocategoriasModel::select(
            'recoergocategorias.ID_CATEGORIA_ERGO',
            'recoergocategorias.PT_CATEGORIA',
            'recoergocategorias.NOMBRE_CATEGORIA_ERGO',
            DB::raw('COUNT(recoergo_fichastecnicas.ID_FICHAS_TECNICAS) AS TOTAL_EVALUADOS')
        )
            ->leftJoin(
                'recoergo_fichastecnicas',
                'recoergo_fichastecnicas.CATEGORIA_ID_FICHA',
                '=',
                'recoergocategorias.ID_CATEGORIA_ERGO'
            )
            ->where('recoergocategorias.RECO_ID', $request->ergoid)
            ->where('recoergocategorias.ACTIVO', 1)
            ->groupBy(
                'recoergocategorias.ID_CATEGORIA_ERGO',
                'recoergocategorias.PT_CATEGORIA',
                'recoergocategorias.NOMBRE_CATEGORIA_ERGO'
            )
            ->orderBy('recoergocategorias.ID_CATEGORIA_ERGO', 'ASC')
            ->get();

        $numero = 1;

        foreach ($categorias as $categoria) {

            $categoria->NUMERO = $numero;
            $numero++;
        }

        return response()->json([
            'data' => $categorias
        ]);
    }

    public function tablaReporteAreasErgo(Request $request)
    {
        $categorias = recoergocategoriasModel::where(
            'RECO_ID',
            $request->ergoid
        )
            ->where('ACTIVO', 1)
            ->get();

        $data = [];

        $numero = 1;

        foreach ($categorias as $categoria) {
            if ($categoria->CATEGORIA_AREAS_ID) {
                foreach ($categoria->CATEGORIA_AREAS_ID as $area_id) {
                    $area = recoergoareasModel::find($area_id);
                    if ($area) {
                        $obj = new \stdClass();
                        $obj->NUMERO = $numero;
                        $obj->AREA = trim($area->NOMBRE_AREA_ERGO);
                        $obj->CATEGORIA =$categoria->NOMBRE_CATEGORIA_ERGO;
                        $data[] = $obj;
                        $numero++;
                    }
                }
            }
        }

        usort($data, function ($a, $b) {

            return strcmp($a->AREA, $b->AREA);
        });

        return response()->json([
            'data' => $data
        ]);
    }




    public function guardarConclusionRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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



    public function guardarRecomendacionesInformeErgo(
        Request $request
    ) {

        try {

            DB::beginTransaction();

            recomendacionesinformeergoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->delete();

            if ($request->DESCRIPCION_RECOMENDACIONES) {

                foreach (
                    $request->DESCRIPCION_RECOMENDACIONES as $recomendacion
                ) {
                    $dato = new recomendacionesinformeergoModel();
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



    public function obtenerRecomendacionesInformeErgo($RECO_ID)
    {
        $datos =
            recomendacionesinformeergoModel::where(
                'RECO_ID',
                $RECO_ID
            )->get();
        return response()->json($datos);
    }





    public function guardarResponsablesInformeRecoErgo(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
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
                    'reconocimiento_ergo/' . $request->RECO_ID . '/responsables_informe',
                    'responsable1.' . $extension

                );

                $dato->INFORME_RESPONSABLE1DOCUMENTO = $ruta;
            }

            if ($request->file('INFORME_RESPONSABLE2DOCUMENTO')) {

                $extension = $request->file('INFORME_RESPONSABLE2DOCUMENTO')->getClientOriginalExtension();
                $ruta = $request->file(
                    'INFORME_RESPONSABLE2DOCUMENTO'
                )->storeAs(
                    'reconocimiento_ergo/' . $request->RECO_ID . '/responsables_informe',
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



    public function mostrarresponsable1recoergo($archivo_opcion, $reco_id, $extension)
    {

        $recurso =
            datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $reco_id
            )->firstOrFail();

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->INFORME_RESPONSABLE1DOCUMENTO);
        } else {
            return Storage::download($recurso->INFORME_RESPONSABLE1DOCUMENTO);
        }
    }



    public function mostrarresponsable2recoergo($archivo_opcion, $reco_id, $extension)
    {

        $recurso =
            datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $reco_id
            )->firstOrFail();
        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recurso->INFORME_RESPONSABLE2DOCUMENTO);
        } else {
            return Storage::download($recurso->INFORME_RESPONSABLE2DOCUMENTO);
        }
    }


    //// 6.1


    public function guardarIntroduccionGraficasNom036(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $request->RECO_ID
            )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INTRODUCCION_GRAFICASNOM036 = $request->INTRODUCCION_GRAFICASNOM036;
            $dato->save();
            DB::commit();

            return response()->json([
                'msj' =>
                'Información guardada correctamente'

            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([

                'msj' =>
                'Error: ' .
                    $e->getMessage()

            ], 500);
        }
    }




    public function guardarConclusionGraficasNom036(Request $request)
    {
        try {

            DB::beginTransaction();

            $dato =
                datosgeneralesinformeRecoModel::where(
                    'RECO_ID',
                    $request->RECO_ID
                )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->CONCLUSION_GRAFICASNOM036 = $request->CONCLUSION_GRAFICASNOM036;
            $dato->save();
            DB::commit();

            return response()->json([
                'msj' =>
                'Información guardada correctamente'

            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([

                'msj' =>
                'Error: ' .
                    $e->getMessage()

            ], 500);
        }
    }


    public function guardarIntroduccionGraficasISO12995(Request $request)
    {

        try {

            DB::beginTransaction();

            $dato =
                datosgeneralesinformeRecoModel::where(
                    'RECO_ID',
                    $request->RECO_ID
                )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
                $dato->RECO_ID = $request->RECO_ID;
            }

            $dato->INTRODUCCION_GRAFICASISO12995 = $request->INTRODUCCION_GRAFICASISO12995;
            $dato->save();

            DB::commit();

            return response()->json([

                'msj' =>
                'Información guardada correctamente'

            ]);
        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([

                'msj' =>
                'Error: ' .
                    $e->getMessage()

            ], 500);
        }
    }



    public function guardarConclusionGraficasISO12995(Request $request)
    {
        try {

            DB::beginTransaction();
            $dato =
                datosgeneralesinformeRecoModel::where(
                    'RECO_ID',
                    $request->RECO_ID
                )->first();

            if (!$dato) {
                $dato = new datosgeneralesinformeRecoModel();
                $dato->RECO_ID = $request->RECO_ID;
            }
            $dato->CONCLUSION_GRAFICASISO12995 = $request->CONCLUSION_GRAFICASISO12995;
            $dato->save();
            DB::commit();

            return response()->json([

                'msj' =>
                'Análisis estadístico guardado correctamente'

            ]);
        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([

                'msj' =>
                'Error: ' .
                    $e->getMessage()

            ], 500);
        }
    }




    public function validarEdicionRecoErgo($reco_id)
    {

        $revision =
            versionesrecoergoModel::where(
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

    public function crearRevisionRecoErgo(Request $request)
    {

        try {

            DB::beginTransaction();


            $ultima =
                versionesrecoergoModel::where(
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
            $revision = new versionesrecoergoModel();
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




    public function cancelarRevisionRecoErgo(Request $request)
    {

        try {

            DB::beginTransaction();

            $revision = versionesrecoergoModel::findOrFail($request->ID_VERSION_RECO_ERGO);
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



    public function tablaVersionesRecoErgo($reco_id)
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
                FROM versionesrecoergo vr
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
                    <button type="button" class="btn btn-success btn-circle" data-toggle="tooltip" title="Descargar informe" onclick="descargarRevisionRecoErgo(' . $value->RECO_ID . ')">
                    <i class="fa fa-download"></i></button>';
        }

        return response()->json([
            'data' => $datos
        ]);
    }



    public function obtenerDatosPlantilla(Request $request)
    {
        $reco = reconocimientoergoModel::find($request->id);

        if (!$reco) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'INSTALACION' => $reco->instalacion,
                'DIRECCION' => $reco->direccion,
                'COORDENADAS' => $reco->coordenadas,
                'DESCRIPCIONPROCESO' => $reco->descripcionproceso,
                'DESCRIPCIONACTIVIDAD' => $reco->actividadprincipal,

            ]
        ]);
    }

    public function descargarRevisionRecoErgo(Request $request, $RECO_ID)
    {


        try {

            $reco = reconocimientoergoModel::findOrFail($RECO_ID);
            $proyecto = proyectoModel::where('reconocimiento_ergo_id', $RECO_ID)->first();
            $contrato = clientecontratoModel::find($proyecto->contrato_id);


            $recursos = recursosPortadaRecoErgoModel::where('RECO_ID', $RECO_ID)->get();
            $rutaPlantilla = storage_path('app/plantillas_reportes/plantilla_ergo/Plantilla_informe_ergonomia.docx');
            $plantillaword = new TemplateProcessor($rutaPlantilla);


            $numeroContrato = $contrato->NUMERO_CONTRATO ?? 'No cargado';
            $plantillaword->setValue('proyecto_portada', 'Evaluación del Factor de Riesgo Ergonómico ' . $numeroContrato);
            $plantillaword->setValue('folio_portada', $reco->proyecto_folio ?? 'No cargado');
            $plantillaword->setValue('razon_social_portada', $proyecto->proyecto_clienterazonsocial ?? 'No cargado');
            $plantillaword->setValue('instalación_portada', $reco->instalacion ?? 'No cargado');


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

            $datosGenerales = datosgeneralesinformeRecoModel::where(
                'RECO_ID',
                $RECO_ID
            )
                ->first();

            //// INTRODUCCION

            $introduccion = $datosGenerales->INFORME_INTRODUCCION;
            $introduccion = preg_replace('/<\/p>/i', "¶", $introduccion);
            $introduccion = strip_tags($introduccion);
            $introduccion = html_entity_decode($introduccion);
            $introduccion = str_replace('¶', "\n\n", $introduccion);

            $plantillaword->setValue('INTRODUCCION',$introduccion);

            //// DEFINICIONES
            $definiciones = DB::table('definicionesinformeergo as di')
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
            $plantillaword->setValue('OBJETIVO_GENERAL', $datosGenerales->INFORME_OBJETIVOGENERALES ?? 'No cargado');

            //// OBEJTIVO ESPECIFICOS
            $textoObjetivos = '';

            if (!empty($datosGenerales->INFORME_OBJETIVOSESPECIFICOS)) {
                $objetivos = preg_split(
                    "/\r\n|\n|\r/",
                    $datosGenerales->INFORME_OBJETIVOSESPECIFICOS
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
            $plantillaword->setValue('PROCESO_INSTALACION', $datosGenerales->INFORME_PROCESOINSTALACION ?? 'No cargado');


            //// ACTIVIDAD PRINCIPAL DE LA INSTALACION 
            $plantillaword->setValue('ACTIVIDAD_INSTALACION', $datosGenerales->INFORME_ACTIVIDADPRINCIPAL ?? 'No cargado');


            //// TABLA DE LAS CATEGORIAS

            $categorias = recoergocategoriasModel::select(
                'recoergocategorias.ID_CATEGORIA_ERGO',
                'recoergocategorias.PT_CATEGORIA',
                'recoergocategorias.NOMBRE_CATEGORIA_ERGO',
                DB::raw('COUNT(recoergo_fichastecnicas.ID_FICHAS_TECNICAS) AS TOTAL_EVALUADOS')
            )
                ->leftJoin(
                    'recoergo_fichastecnicas',
                    'recoergo_fichastecnicas.CATEGORIA_ID_FICHA',
                    '=',
                    'recoergocategorias.ID_CATEGORIA_ERGO'
                )
                ->where('recoergocategorias.RECO_ID', $RECO_ID)
                ->where('recoergocategorias.ACTIVO', 1)
                ->groupBy(
                    'recoergocategorias.ID_CATEGORIA_ERGO',
                    'recoergocategorias.PT_CATEGORIA',
                    'recoergocategorias.NOMBRE_CATEGORIA_ERGO'
                )
                ->orderBy('recoergocategorias.ID_CATEGORIA_ERGO', 'ASC')
                ->get();

            $fuente = 'Poppins';

            $encabezado_texto = array(
                'name' => $fuente,
                'size' => 11,
                'bold' => true,
                'color' => 'FFFFFF'
            );

            $texto = array(
                'name' => $fuente,
                'size' => 10,
                'color' => '000000'
            );

            $texto_negrita = array(
                'name' => $fuente,
                'size' => 10,
                'bold' => true,
                'color' => '000000'
            );

            $centrado = array(
                'alignment' => 'center',
                'valign' => 'center'
            );

            $derecha = array(
                'alignment' => 'right',
                'valign' => 'center'
            );

            $encabezado_celda = array(
                'bgColor' => '0F3D63',
                'valign' => 'center'
            );

            $celda = array(
                'valign' => 'center'
            );

            $ancho_col_1 = 2000;
            $ancho_col_2 = 6000;
            $ancho_col_3 = 2500;

            $table = new Table(array(
                'name' => $fuente,
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'unit' => TblWidth::TWIP
            ));

            $table->addRow(500);

            $table->addCell(
                $ancho_col_1,
                $encabezado_celda
            )->addTextRun($centrado)->addText(
                'PT',
                $encabezado_texto
            );

            $table->addCell(
                $ancho_col_2,
                $encabezado_celda
            )->addTextRun($centrado)->addText(
                'Categoría',
                $encabezado_texto
            );

            $table->addCell(
                $ancho_col_3,
                $encabezado_celda
            )->addTextRun($centrado)->addText(
                'Número de evaluados',
                $encabezado_texto
            );

            $totalPersonas = 0;

            if (count($categorias) > 0) {

                foreach ($categorias as $categoria) {

                    $totalPersonas += $categoria->TOTAL_EVALUADOS;

                    $table->addRow();

                    $table->addCell(
                        $ancho_col_1,
                        $celda
                    )->addTextRun($centrado)->addText(
                        $categoria->PT_CATEGORIA,
                        $texto
                    );

                    $table->addCell(
                        $ancho_col_2,
                        $celda
                    )->addTextRun($centrado)->addText(
                        $categoria->NOMBRE_CATEGORIA_ERGO,
                        $texto
                    );

                    $table->addCell(
                        $ancho_col_3,
                        $celda
                    )->addTextRun($centrado)->addText(
                        $categoria->TOTAL_EVALUADOS,
                        $texto
                    );
                }


                $table->addRow();

                $table->addCell(
                    $ancho_col_1 + $ancho_col_2,
                    array_merge($celda, [
                        'gridSpan' => 2
                    ])
                )->addTextRun($derecha)->addText(
                    'TOTAL EVALUADOS',
                    $texto_negrita
                );

                $table->addCell(
                    $ancho_col_3,
                    $celda
                )->addTextRun($centrado)->addText(
                    $totalPersonas,
                    $texto_negrita
                );
            } else {

                $table->addRow();

                $table->addCell(
                    $ancho_col_1 + $ancho_col_2 + $ancho_col_3,
                    $celda
                )->addTextRun($centrado)->addText(
                    'No hay categorías registradas',
                    $texto
                );
            }

            $plantillaword->setComplexBlock('TABLA_5_3',$table);

            //// AREAS - CATEGORIAS


            $categorias = recoergocategoriasModel::where('RECO_ID', $RECO_ID)
                ->where('ACTIVO', 1)
                ->get();

            $data = [];

            foreach ($categorias as $categoria) {


                if ($categoria->CATEGORIA_AREAS_ID && is_array($categoria->CATEGORIA_AREAS_ID)) {
                    foreach (
                        $categoria->CATEGORIA_AREAS_ID as $area_id
                    ) {
                        $area = recoergoareasModel::find($area_id);
                        if ($area) {
                            $obj = new \stdClass();
                            $obj->AREA = $area->NOMBRE_AREA_ERGO;
                            $obj->CATEGORIA = $categoria->NOMBRE_CATEGORIA_ERGO;
                            $data[] = $obj;
                        }
                    }
                }
            }


            usort($data, function ($a, $b) {
                return strcmp(
                    $a->AREA,
                    $b->AREA
                );
            });

            $fuente = 'Poppins';
            $encabezado_texto = array(
                'name' => $fuente,
                'size' => 11,
                'bold' => true,
                'color' => 'FFFFFF'
            );

            $texto = array(
                'name' => $fuente,
                'size' => 10,
                'color' => '000000'
            );
            $centrado = array('alignment' => 'center', 'valign' => 'center');
            $encabezado_celda = array('bgColor' => '0F3D63', 'valign' => 'center');
            $celda = array('valign' => 'center');


            $ancho_area = 4500;
            $ancho_categoria = 4700;

            $table = new Table(array(
                'name' => $fuente,
                'borderSize' => 1,
                'borderColor' => '000000',
                'cellMargin' => 80,
                'unit' => TblWidth::TWIP
            ));

            $table->addRow(500);
            $table->addCell($ancho_area, $encabezado_celda)->addTextRun($centrado)->addText('Área', $encabezado_texto);
            $table->addCell($ancho_categoria, $encabezado_celda)->addTextRun($centrado)->addText('Categoría', $encabezado_texto);


            $areasAgrupadas = [];


            foreach ($data as $fila) {
                if (!isset($areasAgrupadas[$fila->AREA])) {
                    $areasAgrupadas[$fila->AREA] = [];
                }
                $areasAgrupadas[$fila->AREA][] = $fila->CATEGORIA;
            }


            if (count($areasAgrupadas) > 0) {
                foreach ($areasAgrupadas as $area => $categoriasArea) {
                    foreach ($categoriasArea as $index => $categoria) {
                        $table->addRow();

                        if ($index == 0) {
                            $table->addCell($ancho_area, array('vMerge' => 'restart', 'valign' => 'center'))->addTextRun($centrado)->addText($area, $texto);
                        } else {

                            $table->addCell(
                                $ancho_area,
                                array(
                                    'vMerge' => 'continue',
                                    'valign' => 'center'
                                )
                            );
                        }
                        $table->addCell($ancho_categoria, $celda)->addTextRun($centrado)->addText($categoria, $texto);
                    }
                }
            } else {

                $table->addRow();
                $table->addCell(
                    null,
                    array(
                        'gridSpan' => 2,
                        'valign' => 'center'
                    )
                )->addTextRun($centrado)->addText('No hay áreas registradas', $texto);
            }


            $plantillaword->setComplexBlock('TABLA_5_3_1', $table);



            //// CONCLUSION
            $plantillaword->setValue('CONCLUSION', $datosGenerales->INFORME_CONCLUSION ? htmlspecialchars($datosGenerales->INFORME_CONCLUSION) : 'No cargado');


            //// RESPONSABLE 1
            if ($datosGenerales->INFORME_RESPONSABLE1DOCUMENTO) {
                if (
                    file_exists(
                        storage_path('app/' . $datosGenerales->INFORME_RESPONSABLE1DOCUMENTO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'REPONSABLE1_DOCUMENTO',
                        array(
                            'path' => storage_path('app/' . $datosGenerales->INFORME_RESPONSABLE1DOCUMENTO),
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
                htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE1 ? $datosGenerales->INFORME_RESPONSABLE1 : 'No cargado'))
                    .
                    '</w:t><w:br/><w:t>'
                    .
                    htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE1CARGO ? $datosGenerales->INFORME_RESPONSABLE1CARGO : 'No cargado'))
            );


            //// RESPONSABLE 2
            if ($datosGenerales->INFORME_RESPONSABLE2DOCUMENTO) {
                if (
                    file_exists(
                        storage_path('app/' . $datosGenerales->INFORME_RESPONSABLE2DOCUMENTO)
                    )
                ) {
                    $plantillaword->setImageValue(
                        'REPONSABLE2_DOCUMENTO',
                        array(
                            'path' => storage_path('app/' . $datosGenerales->INFORME_RESPONSABLE2DOCUMENTO),
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
                htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE2 ? $datosGenerales->INFORME_RESPONSABLE2 : 'No cargado'))
                    .
                    '</w:t><w:br/><w:t>'
                    .
                    htmlspecialchars(($datosGenerales->INFORME_RESPONSABLE2CARGO ? $datosGenerales->INFORME_RESPONSABLE2CARGO : 'No cargado'))
            );

            //// INTRODUCCION GRAFICAS 6.1
            $plantillaword->setValue('INTRODUCCION_6_1', $datosGenerales->INTRODUCCION_GRAFICASNOM036 ?? 'No cargado');

            //// CONCLUSION GRAFICAS 6.1
            $plantillaword->setValue('CONCLUSION_6_1', $datosGenerales->CONCLUSION_GRAFICASNOM036 ?? 'No cargado');

            //// INTRODUCCION GRAFICAS 7.1
            $plantillaword->setValue('INTRODUCCION_7_1', $datosGenerales->INTRODUCCION_GRAFICASISO12995 ?? 'No cargado');

            //// CONCLUSION GRAFICAS 7.1
            $plantillaword->setValue('CONCLUSION_7_1', $datosGenerales->CONCLUSION_GRAFICASISO12995 ?? 'No cargado');

            ////  GRAFICAS 6.1
            if ($request->has('GRAFICAS')) {
                $graficas = json_decode($request->GRAFICAS, true);
                if ($graficas && count($graficas) > 0) {
                    $imagenesFinales = [];
                    $categorias = array_chunk($graficas, 3);
                    $plantillaword->cloneRow(
                        'GRAFICA',
                        count($categorias)
                    );

                    foreach ($categorias as $index => $grupo) {
                        $numero = $index + 1;
                        $anchoFinal = 1900;
                        $altoFinal  = 650;
                        $imagenFinal = imagecreatetruecolor(
                            $anchoFinal,
                            $altoFinal
                        );
                        $blanco = imagecolorallocate(
                            $imagenFinal,
                            255,
                            255,
                            255
                        );
                        imagefill(
                            $imagenFinal,
                            0,
                            0,
                            $blanco
                        );
                        $x = 0;

                        foreach ($grupo as $grafica) {
                            if (!isset($grafica['imagen'])) {
                                continue;
                            }
                            $base64 = preg_replace(
                                '#^data:image/\w+;base64,#i',
                                '',
                                $grafica['imagen']
                            );
                            $base64 = str_replace(
                                ' ',
                                '+',
                                $base64
                            );

                            $imageData = base64_decode($base64);
                            $rutaTemp = storage_path(
                                'app/temp_' . uniqid() . '.png'
                            );
                            file_put_contents(
                                $rutaTemp,
                                $imageData
                            );
                            $img = imagecreatefrompng($rutaTemp);
                            imagecopyresampled(
                                $imagenFinal, 
                                $img, 
                                $x, 
                                20, 
                                0, 
                                0, 
                                580, 
                                560, 
                                imagesx($img),
                                imagesy($img)
                            );

                            $x += 620;

                            imagedestroy($img);
                            unlink($rutaTemp);
                        }

                        $rutaFinal = storage_path(
                            'app/grafica_final_' . uniqid() . '.png'
                        );

                        imagepng(
                            $imagenFinal,
                            $rutaFinal
                        );

                        imagedestroy($imagenFinal);

                        $imagenesFinales[] = $rutaFinal;

                        $plantillaword->setImageValue(

                            'GRAFICA#' . $numero,

                            [
                                'path' => $rutaFinal,
                                'width'  => 900,
                                'height' => 320,
                                'ratio'  => true
                            ]
                        );
                    }
                    register_shutdown_function(function () use ($imagenesFinales) {
                        foreach ($imagenesFinales as $imagen) {
                            if (file_exists($imagen)) {
                                unlink($imagen);
                            }
                        }
                    });
                } else {
                    $plantillaword->setValue(
                        'GRAFICA',
                        'NO HAY GRAFICAS'
                    );
                }
            }

            //// GRAFICA 7.1 
            if ($request->filled('GRAFICAS_FICHAS')) {

                $graficasFichas = json_decode(
                    $request->GRAFICAS_FICHAS,
                    true
                );

                if (
                    is_array($graficasFichas) &&
                    count($graficasFichas) > 0
                ) {

                    $imagenesFinales = [];

                    $marcadores = [

                        'GRAFICA_7',
                        'GRAFICA_8',
                        'GRAFICA_9',
                        'GRAFICA_10',
                        'GRAFICA_11',
                        'GRAFICA_12'

                    ];

                    foreach ($graficasFichas as $index => $grafica) {

                        if (
                            !isset($grafica['imagen']) ||
                            empty($grafica['imagen'])
                        ) {
                            continue;
                        }

                        if (!isset($marcadores[$index])) {
                            continue;
                        }

                        $base64 = preg_replace(
                            '#^data:image/\w+;base64,#i',
                            '',
                            $grafica['imagen']
                        );

                        $base64 = str_replace(
                            ' ',
                            '+',
                            $base64
                        );

                        $imageData =
                            base64_decode($base64);

                        $rutaFinal = storage_path(
                            'app/grafica_ficha_' .
                                uniqid() .
                                '.png'
                        );

                        file_put_contents(
                            $rutaFinal,
                            $imageData
                        );

                        $imagenesFinales[] =
                            $rutaFinal;

                        $plantillaword->setImageValue(

                            $marcadores[$index],

                            [

                                'path' => $rutaFinal,
                                'width' => 650,
                                'height' => 720,

                                'ratio' => true

                            ]

                        );
                    }

                    register_shutdown_function(function () use ($imagenesFinales) {

                        foreach ($imagenesFinales as $imagen) {

                            if (file_exists($imagen)) {

                                unlink($imagen);
                            }
                        }
                    });
                }
            }


            ////// TABLA 7.2


            $criteriosMapa = [

                '1.1' => 'Levantamiento de cargas',
                '1.2' => 'Transporte de cargas',
                '2.1' => 'Empuje y tracción de cargas',
                '3.1' => 'Movimientos repetitivos',
                '4.1' => 'Posturas estáticas forzadas',
                '4.2' => 'Posturas dinámicas forzadas'

            ];

            $fichas = recoergofichastecnicasModel::where(
                'RECO_ID',
                $RECO_ID
            )
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

            $cantidadPE = max(count($fichas), 1);



            if ($cantidadPE >= 10) {

                $textoHeader['size'] = 8;
                $texto['size'] = 7;
            }

            if ($cantidadPE >= 15) {

                $textoHeader['size'] = 7;
                $texto['size'] = 6;
            }


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

            $anchoDisponible =
                $totalAnchoTabla -
                $anchoTitulo;

            $anchoPE = floor(
                $anchoDisponible /
                    $cantidadPE
            );

            $ultimoAnchoPE =
                $anchoDisponible -
                ($anchoPE * ($cantidadPE - 1));


            $table = new Table([

                'borderSize' => 12,
                'borderColor' => '0B2C6B',
                'cellMargin' => 20,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START

            ]);



            $table->addRow(450);

            $table->addCell(
                $totalAnchoTabla,
                [
                    'gridSpan' => $cantidadPE + 1,
                    'bgColor' => 'FFFFFF',
                    'valign' => 'center'
                ]
            )->addTextRun($centrado)->addText(
                'MAPA DE PELIGROS',
                $textoTitulo
            );


            $table->addRow(400);

            $table->addCell(
                $anchoTitulo,
                [
                    'vMerge' => 'restart',
                    'valign' => 'center',
                    'bgColor' => 'FFFFFF'
                ]
            )->addTextRun($centrado)->addText(
                'Criterios de carga física',
                $textoHeader
            );

            $table->addCell(
                $anchoDisponible,
                [
                    'gridSpan' => $cantidadPE,
                    'valign' => 'center',
                    'bgColor' => 'FFFFFF'
                ]
            )->addTextRun($centrado)->addText(
                'Personas evaluadas',
                $textoHeader
            );



            $table->addRow(350);

            $table->addCell(
                $anchoTitulo,
                [
                    'vMerge' => 'continue'
                ]
            );

            $indice = 0;

            foreach ($fichas as $ficha) {

                $indice++;

                $anchoActual =
                    ($indice == $cantidadPE)
                    ? $ultimoAnchoPE
                    : $anchoPE;

                $table->addCell(
                    $anchoActual,
                    [
                        'valign' => 'center',
                        'bgColor' => 'FFFFFF'
                    ]
                )->addTextRun($centrado)->addText(
                    $ficha->PE_EVALUADAS,
                    $textoHeader
                );
            }


            foreach ($criteriosMapa as $codigo => $titulo) {

                $table->addRow(300);

                $table->addCell(
                    $anchoTitulo,
                    [
                        'valign' => 'center'
                    ]
                )->addTextRun($izquierda)->addText(
                    $titulo,
                    $texto
                );

                $indice = 0;

                foreach ($fichas as $fichaDB) {

                    $indice++;

                    $anchoActual =
                        ($indice == $cantidadPE)
                        ? $ultimoAnchoPE
                        : $anchoPE;

                    $resultadoFinal = 'VERDE';

                    $json = json_decode(
                        $fichaDB->JSON_FICHAS,
                        true
                    );

                    if ($json) {

                        foreach ($json as $bloque) {

                            if (
                                isset($bloque['ficha']) &&
                                $bloque['ficha'] == $codigo
                            ) {

                                if (
                                    isset($bloque['resultado']) &&
                                    strtoupper($bloque['resultado']) == 'ROJO'
                                ) {

                                    $resultadoFinal = 'ROJO';
                                    break;
                                }
                            }
                        }
                    }

                    $colorCelda = '28A745';

                    if ($resultadoFinal == 'ROJO') {

                        $colorCelda = 'DC3545';
                    }

                    $table->addCell(
                        $anchoActual,
                        [
                            'bgColor' => $colorCelda,
                            'valign' => 'center'
                        ]
                    )->addTextRun($centrado)->addText('');
                }
            }

            $plantillaword->setComplexBlock('TABLA_7_2',$table);



            //// DESCARGAR INFORME 

            $nombreWord = 'Informe_Ergonomia_' . $RECO_ID . '.docx';
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

<?php

namespace App\Http\Controllers\recsensorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;
use Carbon\Carbon;
use DateTime;
use DB;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use ZipArchive;


use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;


use App\Http\Controllers\recsensorialreportes\recsensorialquimicosreportewordController;


// Modelos
use App\modelos\recsensorial\recsensorialModel;
use App\modelos\clientes\clienteModel;
use App\modelos\catalogos\ProveedorModel;
use App\modelos\recsensorial\catcontratoModel;
use App\modelos\recsensorial\catregionModel;
use App\modelos\recsensorial\catsubdireccionModel;
use App\modelos\recsensorial\catgerenciaModel;
use App\modelos\recsensorial\catactivoModel;
use App\modelos\catalogos\Cat_pruebaModel;
use App\modelos\recsensorial\recsensorialpruebasModel;
use App\modelos\recsensorial\catdepartamentoModel;
use App\modelos\recsensorial\catmovilfijoModel;
use App\modelos\recsensorial\catpartecuerpoModel;
use App\modelos\recsensorial\recsensorialevidenciasModel;
use App\modelos\recsensorial\recsensorialSustanciasModel;
use App\modelos\clientes\contratoAnexosModel;

//selects
use App\modelos\recsensorial\recsensorialareaModel;
use App\modelos\recsensorial\recsensorialcategoriaModel;
use App\modelos\recsensorial\recsensorialareacategoriasModel;
// quimicos catalogos
use App\modelos\recsensorialquimicos\catcategoriapeligrosaludModel;
use App\modelos\recsensorialquimicos\catgradoriesgosaludModel;
use App\modelos\recsensorialquimicos\catunidadmedidasustaciaModel;
use App\modelos\recsensorialquimicos\catestadofisicosustanciaModel;
use App\modelos\recsensorialquimicos\catviaingresoorganismoModel;
use App\modelos\recsensorialquimicos\catvolatilidadModel;
use App\modelos\recsensorialquimicos\catSustanciasQuimicasModel;
use App\modelos\recsensorial\catCargosInformeModel;
use App\modelos\recsensorial\recsensorialRecursosInformesModel;
use App\modelos\recsensorial\recsensorialTablasInformesModel;
use App\modelos\recsensorial\recsensorialTablaClienteInformeModel;
use App\modelos\recsensorial\catConclusionesModel;
use App\modelos\recsensorial\controlCambiosModel;
use App\modelos\recsensorial\recsensorialTablaClienteProporcionadoModel;
use App\modelos\recsensorial\cat_descripcionarea;
use App\modelos\recsensorialquimicos\catsustanciaModel;
use App\modelos\recsensorialquimicos\gruposDeExposicionModel;
use App\modelos\recsensorialquimicos\catRecomendacionesModel;
use App\modelos\recsensorial\recsensorialRecomendacionesModel;


use App\modelos\proyecto\proyectoModel;




//Configuracion Zona horaria
date_default_timezone_set('America/Mexico_City');


class recsensorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('Superusuario,Administrador,Proveedor,Reconocimiento,Proyecto,Compras,Staff,Psicólogo,Ergónomo,CoordinadorPsicosocial,CoordinadorErgonómico,CoordinadorRN,CoordinadorRS,CoordinadorRM,CoordinadorHI,ApoyoTecnico,Reportes,Externo');
        $this->middleware('roles:Superusuario,Administrador,Coordinador,Operativo HI,Almacén,Compras,Psicólogo,Ergónomo');

        // $this->middleware('asignacionUser:RECSENSORIAL')->only('store');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // AUTO_INCREMENT TABLA GALERIA SOLO AL ENTRAR AL MDULO PARA EVITAR PROBLEMAS CON EL RESPONSE DE LAS IMAGENES DE LAS EVIDNCIAS
        DB::statement('ALTER TABLE recsensorialevidencias AUTO_INCREMENT = 1;');


        //CATALOGOS
        // $catcontrato = catcontratoModel::all();
        // $catcontrato = catcontratoModel::where('catcontrato_activo', 1)->orderBy('catcontrato_numero', 'ASC')->get();
        $cliente = clienteModel::where('cliente_Eliminado', 0)->orderBy('cliente_RazonSocial', 'ASC')->get();
        $catregion = catregionModel::where('catregion_activo', 1)->get();
        $catsubdireccion = catsubdireccionModel::where('catsubdireccion_activo', 1)->orderBy('catsubdireccion_nombre', 'ASC')->get();
        $catgerencia = catgerenciaModel::where('catgerencia_activo', 1)->orderBy('catgerencia_nombre', 'ASC')->get();
        $catactivo = catactivoModel::where('catactivo_activo', 1)->orderBy('catactivo_nombre', 'ASC')->get();
        $catprueba = Cat_pruebaModel::where('catPrueba_Activo', 1)->whereNotIn('id', [15])->get();
        $catdepartamento = catdepartamentoModel::where('catdepartamento_activo', 1)->orderBy('catdepartamento_nombre', 'ASC')->get();
        $catmovilfijo = catmovilfijoModel::where('catmovilfijo_activo', 1)->get();
        $catpartecuerpo = catpartecuerpoModel::where('catpartecuerpo_activo', 1)->get();
        // catalogos quimicos
        $catcategoriapeligrosalud = catcategoriapeligrosaludModel::where('catcategoriapeligrosalud_activo', 1)->get();
        $catgradoriesgosalud = catgradoriesgosaludModel::where('catgradoriesgosalud_activo', 1)->get();
        $catunidadmedidasustacia = catunidadmedidasustaciaModel::where('catunidadmedidasustacia_activo', 1)->get();
        $catestadofisicosustancia = catestadofisicosustanciaModel::where('catestadofisicosustancia_activo', 1)->get();
        $catviaingresoorganismo = catviaingresoorganismoModel::where('catviaingresoorganismo_activo', 1)->get();
        $catvolatilidad = catvolatilidadModel::where('catvolatilidad_activo', 1)->get();
        $catSustanciasQuimicas = catSustanciasQuimicasModel::where('ACTIVO', 1)->get();
        $catConclusiones = catConclusionesModel::where('ACTIVO', 1)->get();
        $hojasSeguridad = catsustanciaModel::where('catsustancia_activo', 1)->get();

        $descripciones = cat_descripcionarea::where('ACTIVO', 1)->get();
        $recomendaciones = catRecomendacionesModel::where('ACTIVO', 1)->get();



        $cargos = catCargosInformeModel::where('ACTIVO', 1)->get();
        $proveedor = ProveedorModel::where('proveedor_Eliminado', 0)->orderBy('proveedor_RazonSocial', 'ASC')->get();
        $tipopruebas = Cat_pruebaModel::select('catPrueba_Tipo')->where('catPrueba_Activo', 1)->groupBy('catPrueba_Tipo')->get();




        //vista RECONOCIMIENTO SENSORIAL
        return view('catalogos.recsensorial.reconocimiento_sensorial', compact('cliente', 'catregion', 'catsubdireccion', 'catgerencia', 'catactivo', 'catprueba', 'catdepartamento', 'catmovilfijo', 'catpartecuerpo', 'catcategoriapeligrosalud', 'catgradoriesgosalud', 'catunidadmedidasustacia', 'catvolatilidad', 'catestadofisicosustancia', 'catviaingresoorganismo', 'proveedor', 'catSustanciasQuimicas', 'tipopruebas', 'cargos', 'catConclusiones', 'descripciones', 'hojasSeguridad', 'recomendaciones'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tablarecsensorial()
    {
        try {
            // TIPO DE USUARIO
            if (auth()->user()->hasRoles(['CoordinadorRN', 'CoordinadorRS', 'CoordinadorRM'])) {
                $region = '';

                if (auth()->user()->hasRoles(['CoordinadorRN'])) {
                    $region = 'NORTE';
                } else if (auth()->user()->hasRoles(['CoordinadorRS'])) {
                    $region = 'SUR';
                } else {
                    $region = 'MARINA';
                }

                // Reconocimientos segun la region
                $recsensorial_region = collect(DB::select('SELECT
                                                                recsensorial.id,
                                                                catregion.catregion_nombre,
                                                                recsensorial.recsensorial_instalacion
                                                            FROM
                                                                recsensorial
                                                                LEFT JOIN catregion ON recsensorial.catregion_id = catregion.id
                                                            WHERE
                                                                catregion.catregion_nombre LIKE "%' . $region . '%"'));

                $lista_recsensorial = array(0);
                foreach ($recsensorial_region as $key => $value) {
                    $lista_recsensorial[] = $value->id;
                }

                $recsensorial = recsensorialModel::with(['cliente', 'catregion', 'catsubdireccion', 'catgerencia', 'catactivo', 'recsensorialpruebas'])
                    ->whereIn('id', $lista_recsensorial) // ->whereIn('id', [1, 2, 3, 8, 22])
                    ->orderBy('id', 'ASC') //DATO TEMPORAL
                    ->get();
            } else {
                $recsensorial = recsensorialModel::with(['cliente', 'catregion', 'catsubdireccion', 'catgerencia', 'catactivo', 'recsensorialpruebas'])
                    // ->whereIn('id', [1, 6])
                    ->orderBy('id', 'ASC') //DATO TEMPORAL
                    ->get();
            }


            // formatear FILAS
            $numero_registro = 0;
            foreach ($recsensorial as $key => $value) {
                $numero_registro += 1;
                $value->numero_registro = $numero_registro;

                // Formatear fechas
                // $value->recsensorial_fechainicio = Carbon::createFromFormat('Y-m-d', $value->recsensorial_fechainicio)->format('d-m-Y');
                // $value->recsensorial_fechafin = Carbon::createFromFormat('Y-m-d', $value->recsensorial_fechafin)->format('d-m-Y');

                // fecha validacion quimicos
                // if ($value->recsensorial_quimicofechavalidacion)
                // {
                //     $value->recsensorial_quimicofechavalidacion = Carbon::createFromFormat('Y-m-d', $value->recsensorial_quimicofechavalidacion)->format('d-m-Y');
                // }


                $catgerencia_nombre = 'No encontrado';
                if (isset($value->catgerencia->catgerencia_nombre)) {
                    $catgerencia_nombre = $value->catgerencia->catgerencia_nombre;
                }


                $catactivo_nombre = 'No encontrado';
                if (isset($value->catactivo->catactivo_nombre)) {
                    $catactivo_nombre = $value->catactivo->catactivo_nombre;
                }


                $value->gerencia_y_activo = '<span style="color: #999;">' . $catgerencia_nombre . '</span><br>' . $catactivo_nombre;


                // Texto alcance del Reconocimiento
                if (($value->recsensorial_alcancefisico + 0) > 0 && ($value->recsensorial_alcancequimico + 0) > 0) {
                    $value->folios = $value->recsensorial_foliofisico . "<br>" . $value->recsensorial_folioquimico;
                    $value->alcance = "Físicos y Químicos";
                } else if (($value->recsensorial_alcancefisico + 0) > 0) {
                    $value->folios = $value->recsensorial_foliofisico;
                    $value->alcance = "Físicos";
                } else {
                    $value->folios = $value->recsensorial_folioquimico;
                    $value->alcance = "Químicos";
                }

                $value->cliente_contrato = $value->cliente->cliente_RazonSocial . "<br>" . $value->cliente->cliente_numerocontrato;

                //Activar que solo el ultimo registro agregado pueda ser editado
                if ($numero_registro == count($recsensorial)) //ultimo registro agregado
                {
                    $value->recsensorial_activo = 1;
                } else {
                    $value->recsensorial_activo = 0;
                }

                // Valida perfil
                if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Coordinador', 'Operativo HI'])) {
                    $value->perfil = 1;
                } else {
                    $value->perfil = 0;
                }

                // BOTON MOSTRAR [reconocimiento Bloqueado]
                if (($value->recsensorial_bloqueado + 0) == 0) //Desbloqueado
                {
                    $value->boton_mostrar = '<button type="button" class="btn btn-info btn-circle" style="padding: 0px;"><i class="fa fa-eye fa-2x"></i></button>';
                } else {
                    $value->boton_mostrar = '<button type="button" class="btn btn-secondary btn-circle" style="padding: 0px; border: 1px #999999 solid!important;" data-toggle="tooltip" title="Solo lectura"><i class="fa fa-eye-slash fa-2x"></i></button>';
                }
            }

            // respuesta
            $dato['data'] = $recsensorial;
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }


    public function validacionAsignacionUser($folio)
    {
        try {

            if (auth()->user()->hasRoles(['Administrador', 'Superusuario'])) {

                $next = 1;
            } else {

                $user = auth()->user()->id;

                $permiso = DB::select("SELECT COUNT(u.ID_PROYECTO_USUARIO) AS PERMISO
                                        FROM proyectoUsuarios u
                                        LEFT JOIN proyecto p ON p.id = u.PROYECTO_ID
                                        WHERE u.SERVICIO_HI = 1 
                                        AND u.ACTIVO = 1
                                        AND p.proyecto_folio = ?
                                        AND u.USUARIO_ID = ?", [$folio, $user]);

                $next = $permiso[0]->PERMISO;
            }


            $dato['permisos'] = $next;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['opciones'] = "No encontradas";
            return response()->json($dato);
        }
    }


    public function pruebasrecsensorial($id)
    {
        try {


            $opciones = recsensorialpruebasModel::where('recsensorial_id', $id)->get();

            // // respuesta
            $dato['opciones'] = $opciones;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['opciones'] = "No encontradas";
            return response()->json($dato);
        }
    }


    public function sustanciasrecsensorial($id)
    {
        try {


            $opciones = DB::select(' SELECT rs.SUSTANCIA_QUIMICA_ID, rs.CANTIDAD, cq.SUSTANCIA_QUIMICA
                        FROM recsensorial_sustancias rs
                        LEFT JOIN catsustancias_quimicas cq ON rs.SUSTANCIA_QUIMICA_ID = cq.ID_SUSTANCIA_QUIMICA 
                        WHERE rs.RECSENSORIAL_ID = ?', [$id]);

            // // respuesta
            $dato['opciones'] = $opciones;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['opciones'] = "No encontradas";
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
    public function mostrarmapa($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->recsensorial_fotoubicacion);
        } else {
            return Storage::download($recsensorial->recsensorial_fotoubicacion);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostrarplano($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {

            return Storage::response($recsensorial->recsensorial_fotoplano);
        } else {

            return Storage::download($recsensorial->recsensorial_fotoplano);
        }
    }


    public function mostrarMapaFuentesGeneradoras($recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);
        $filePath = $recsensorial->recsensorial_fotoplano;

        // Generar la URL completa del archivo almacenado
        $fileUrl = Storage::url($filePath);

        return response()->json(['imageUrl' => $fileUrl]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $archivo_opcion
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function mostrarfotoinstalacion($archivo_opcion, $recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        if (($archivo_opcion + 0) == 0) {
            return Storage::response($recsensorial->recsensorial_fotoinstalacion);
        } else {
            return Storage::download($recsensorial->recsensorial_fotoinstalacion);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @param  int  $seleccionado_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialconsultaselectareas($recsensorial_id, $seleccionado_id)
    {
        try {
            $opciones = '<option value=""></option>';
            $tabla = recsensorialareaModel::where('recsensorial_id', $recsensorial_id)->get();

            // colocar numero de registro
            foreach ($tabla  as $key => $value) {
                if ($seleccionado_id == $value['id']) {
                    $opciones .= '<option value="' . $value['id'] . '" selected>' . $value['recsensorialarea_nombre'] . '</option>';
                } else {
                    $opciones .= '<option value="' . $value['id'] . '">' . $value['recsensorialarea_nombre'] . '</option>';
                }
            }

            // respuesta
            $dato['opciones'] = $opciones;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opciones'] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @param  int  $seleccionado_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialconsultaselectcategorias($recsensorial_id, $seleccionado_id)
    {
        try {
            $opciones = '<option value=""></option>';
            $categorias = DB::select('SELECT
                                            recsensorialcategoria.recsensorial_id,
                                            recsensorialcategoria.id,
                                            CONCAT(recsensorialcategoria.recsensorialcategoria_nombrecategoria) AS recsensorialcategoria_nombrecategoria
                                        FROM
                                            recsensorialcategoria
                                        WHERE
                                            recsensorialcategoria.recsensorial_id = ' . $recsensorial_id . '
                                        ORDER BY
                                            recsensorialcategoria.recsensorialcategoria_nombrecategoria ASC');

            foreach ($categorias as $key => $value) {
                if ($seleccionado_id == $value->id) {
                    $opciones .= '<option value="' . $value->id . '" selected>' . $value->recsensorialcategoria_nombrecategoria . '</option>';
                } else {
                    $opciones .= '<option value="' . $value->id . '">' . $value->recsensorialcategoria_nombrecategoria . '</option>';
                }
            }

            // respuesta
            $dato['opciones'] = $opciones;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opciones'] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorialarea_id
     * @param  int  $recsensorialcategoria_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialselectcategoriasxarea($recsensorialarea_id, $recsensorialcategoria_id)
    {
        try {
            $opciones = '<option value=""></option>';
            $categorias = recsensorialareacategoriasModel::with(['categorias'])
                ->where('recsensorialarea_id', $recsensorialarea_id)
                ->get();

            // opciones
            foreach ($categorias as $key => $value) {
                if ($recsensorialcategoria_id == $value->recsensorialcategoria_id) {
                    $opciones .= '<option value="' . $value->recsensorialcategoria_id . '" selected>' . $value->recsensorialareacategorias_geh . '.- ' . $value->categorias->recsensorialcategoria_nombrecategoria . '</option>';
                } else {
                    $opciones .= '<option value="' . $value->recsensorialcategoria_id . '">' . $value->recsensorialareacategorias_geh . '.- ' . $value->categorias->recsensorialcategoria_nombrecategoria . '</option>';
                }
            }

            // respuesta
            $dato['opciones'] = $opciones;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opciones'] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }

    public function getContratosClientes($cliente_id, $id_contrato)
    {
        try {

            $opciones_select = '<option value="">&nbsp;</option>';
            $contratos = DB::select('SELECT cc.DESCRIPCION_CONTRATO, cc.NUMERO_CONTRATO, cc.ID_CONTRATO, cc.CLIENTE_ID,
                                            IF(cc.FECHA_FIN < DATE(NOW()), "VENCIDO", "ACTIVO") AS STATUS_CONTRATO,
                                            IF(con.id IS NULL,"SIN_CONVENIO" ,IF(con.clienteconvenio_vigencia < DATE(NOW()), "CON_CONVENIO_VENCIDO", "CON_CONVENIO_ACTIVO")) AS STATUS_CONVENIO
                                        FROM contratos_clientes as cc 
                                        LEFT JOIN contratos_convenios as con ON con.CONTRATO_ID = cc.ID_CONTRATO
                                        WHERE cc.CLIENTE_ID = ' . $cliente_id . ' 
                                        AND ACTIVO = 1
                                        AND CONCLUIDO = 0
                                        ');

            foreach ($contratos as $key => $value) {
                if ($value->ID_CONTRATO == $id_contrato) {

                    $opciones_select .= '<option value="' . $value->ID_CONTRATO . '"  selected>' . $value->DESCRIPCION_CONTRATO . ' [' . $value->NUMERO_CONTRATO . ']' . '</option>';
                } else if ($value->STATUS_CONTRATO == 'VENCIDO' && $value->STATUS_CONVENIO == 'SIN_CONVENIO') {

                    $opciones_select .= '<option value="' . $value->ID_CONTRATO . '" disabled>' . $value->DESCRIPCION_CONTRATO . ' [' . $value->NUMERO_CONTRATO . ']' . ' (Vencido y sin convenio)</option>';
                } else if ($value->STATUS_CONTRATO == 'VENCIDO' && $value->STATUS_CONVENIO != 'SIN_CONVENIO') {

                    if ($value->STATUS_CONVENIO == 'CON_CONVENIO_VENCIDO') {

                        $opciones_select .= '<option value="' . $value->ID_CONTRATO . '" disabled>' . $value->DESCRIPCION_CONTRATO . ' [' . $value->NUMERO_CONTRATO . ']' . ' (Vencido con convenio expirado)</option>';
                    } else {
                        $opciones_select .= '<option value="' . $value->ID_CONTRATO . '" >' . $value->DESCRIPCION_CONTRATO . ' [' . $value->NUMERO_CONTRATO . ']' . ' (Vencido con convenio activo)</option>';
                    }
                } else {

                    $opciones_select .= '<option value="' . $value->ID_CONTRATO . '"  >' . $value->DESCRIPCION_CONTRATO . ' [' . $value->STATUS_CONTRATO . ']' . ' (Activo)</option>';
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

    public function autorizarReconocimiento($id_reconocimiento)
    {
        try {

            $reconocimiento = recsensorialModel::findOrFail($id_reconocimiento);
            $reconocimiento->autorizado = 1;
            $reconocimiento->recsensorial_bloqueado = 0;
            $dato["msj"] = 'Reconocimiento autorizado correctamente';

            $reconocimiento->save();

            // Respuesta
            $dato["reconocimiento"] = $reconocimiento;
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["reconocimiento"] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }

    public function getContratosAnexos($id_contrato)
    {
        try {
            if ($id_contrato == 0) {
                $opciones_select = '<option disabled>No hay anexos requeridos, ya que no existe un contrato vinculado.</option>';
            } else {

                $opciones_select = '<option value="">&nbsp;</option>';
                $anexos = contratoAnexosModel::where('CONTRATO_ID', $id_contrato)->get();

                foreach ($anexos as $key => $value) {
                    $opciones_select .= '<option value="' . $value->ID_CONTRATO_ANEXO . '"  data-tipo="' . $value->TIPO . '" >' . $value->NOMBRE_ANEXO . ' [' . $value->TIPO . ']' . '</option>';
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


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function pdfvalidaquimicos($recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        // Valida si existe documento
        if (Storage::exists($recsensorial->recsensorial_pdfvalidaquimicos)) {
            // return Storage::download($recsensorial->recsensorial_fotoubicacion);
            return Storage::response($recsensorial->recsensorial_pdfvalidaquimicos);
        } else {
            return 'Archivo PDF no encontrado';
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @param  int  $recsensorial_estado
     * @return \Illuminate\Http\Response
     */
    public function recsensorialbloqueo($recsensorial_id, $recsensorial_estado)
    {
        try {
            // Reconocimiento
            $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

            // Valida estado
            if (($recsensorial_estado + 0) == 0) {
                $recsensorial->recsensorial_bloqueado = 1;
                $recsensorial->recsensorial_fisicosimprimirbloqueado = 1;
                $recsensorial->recsensorial_quimicosimprimirbloqueado = 1;
                $dato["msj"] = 'Reconocimiento bloqueado correctamente';
            } else {
                $recsensorial->recsensorial_bloqueado = 0;
                $recsensorial->recsensorial_fisicosimprimirbloqueado = 0;
                $recsensorial->recsensorial_quimicosimprimirbloqueado = 0;
                $dato["msj"] = 'Reconocimiento desbloqueado correctamente';
            }

            // Guardar cambios
            $recsensorial->save();

            // Respuesta
            $dato["recsensorial"] = $recsensorial;
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["recsensorial"] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @param  int  $recsensorial_tipo
     * @return \Illuminate\Http\Response
     */
    public function recsensorialpdfautorizado($recsensorial_id, $recsensorial_tipo)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        if (($recsensorial_tipo + 0) == 1) {
            return Storage::download($recsensorial->recsensorial_reconocimientofisicospdf);
        } else {
            return Storage::download($recsensorial->recsensorial_reconocimientoquimicospdf);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $tipo_documento
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialresponsablefoto($tipo_documento, $recsensorial_id)
    {
        $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

        switch (($tipo_documento + 0)) {
            case 1:
                return Storage::response($recsensorial->recsensorial_repfisicos1doc);
                break;
            case 2:
                return Storage::response($recsensorial->recsensorial_repfisicos2doc);
                break;
            case 3:
                return Storage::response($recsensorial->recsensorial_repquimicos1doc);
                break;
            default:
                return Storage::response($recsensorial->recsensorial_repquimicos2doc);
                break;
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @param  int  $recsensorial_id
     * @param  int  $parametro_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialevidenciagaleria($recsensorial_id, $parametro_id)
    {
        try {
            $recsensorial = recsensorialModel::findOrFail($recsensorial_id);

            $activo = 0;
            if (auth()->user()->hasRoles(['Superusuario', 'Administrador', 'Operativo HI', 'Coordinador']) && ($recsensorial->recsensorial_bloqueado + 0) == 0) {
                $activo = 1;
            }

            // $fotos = recsensorialevidenciasModel::where('recsensorial_id', $recsensorial_id)
            //                                     ->where('cat_prueba_id', $parametro_id)
            //                                     ->orderBy('recsensorialevidencias_tipo', 'ASC')
            //                                     ->orderBy('id', 'ASC')
            //                                     ->get();

            $sql = DB::select('SELECT
                                    recsensorialevidencias.recsensorial_id,
                                    recsensorialevidencias.id,
                                    recsensorialevidencias.cat_prueba_id,
                                    cat_prueba.catPrueba_Nombre,
                                    recsensorialevidencias.recsensorialarea_id,
                                    recsensorialarea.recsensorialarea_nombre,
                                    recsensorialevidencias.recsensorialevidencias_tipo,
                                    (IF(recsensorialevidencias.recsensorialevidencias_tipo = 1, "Foto", "Plano")) AS recsensorialevidencias_tiponombre,
                                    recsensorialevidencias.recsensorialevidencias_descripcion,
                                    recsensorialevidencias.recsensorialevidencias_foto 
                                FROM
                                    recsensorialevidencias
                                    LEFT JOIN cat_prueba ON recsensorialevidencias.cat_prueba_id = cat_prueba.id
                                    LEFT JOIN recsensorialarea ON recsensorialevidencias.recsensorialarea_id = recsensorialarea.id
                                WHERE
                                    recsensorialevidencias.recsensorial_id = ' . $recsensorial_id . ' 
                                    AND recsensorialevidencias.cat_prueba_id = ' . $parametro_id . ' 
                                ORDER BY
                                    recsensorialevidencias.recsensorialevidencias_tipo ASC,
                                    recsensorialevidencias.id ASC');


            $galeria = null;
            $titulo = '';
            foreach ($sql as $key => $value) {
                if (($value->recsensorialevidencias_tipo + 0) == 1) {
                    if (strlen($value->recsensorialarea_nombre) > 20) {
                        $titulo = substr($value->recsensorialarea_nombre, 0, 20) . '...';
                    } else {
                        $titulo = $value->recsensorialarea_nombre;
                    }
                } else {
                    if (strlen($value->recsensorialevidencias_descripcion) > 20) {
                        $titulo = substr($value->recsensorialevidencias_descripcion, 0, 20) . '...';
                    } else {
                        $titulo = $value->recsensorialevidencias_descripcion;
                    }
                }


                $col = 'col-xl-2 col-lg-3 col-md-4 col-sm-6';
                $font_size = '13px';

                if (($value->cat_prueba_id + 0) == 15) // Químicos
                {
                    $col = 'col-lg-1 col-md-2 col-sm-2';
                    $font_size = '12px';
                }


                $galeria .= '
                <div class="' . $col . ' foto_galeria">
                    <span style="font-size: ' . $font_size . '; color: #FFFFFF; text-shadow: 0 0 3px #000000, 0 0 3px #000000; position: absolute; left: 15px;">' . $titulo . '</span>
                    <i class="fa fa-download text-success" style="font-size: 26px; text-shadow: 2px 2px 4px #000000; opacity: 0; position: absolute; top: 24px;" data-toggle="tooltip" title="Descargar" onclick="foto_descargar(' . $value->id . ');"></i>';

                if ($activo == 1) // Muestra Eliminar
                {
                    if (($parametro_id + 0) != 15) {
                        $galeria .= '<i class="fa fa-trash text-danger" style="font-size: 26px; text-shadow: 2px 2px 4px #000000; opacity: 0; position: absolute; top: 24px; left: 50px;" data-toggle="tooltip" title="Eliminar" onclick="foto_eliminar(' . $value->id . ', \'' . $value->recsensorialevidencias_tiponombre . '\');"></i>';
                    } else {
                        $galeria .= '<i class="fa fa-trash text-danger" style="font-size: 26px; text-shadow: 2px 2px 4px #000000; opacity: 0; position: absolute; top: 24px; left: 50px;" data-toggle="tooltip" title="Eliminar" onclick="fotoquimicos_eliminar(' . $value->id . ', \'' . $value->recsensorialevidencias_tiponombre . '\');"></i>';
                    }
                }

                $galeria .= '
                    <a href="/recsensorialevidenciafotomostrar/' . $value->id . '/0" data-effect="mfp-zoom-in" title="' . $value->recsensorialevidencias_descripcion . '">
                        <img class="d-block img-fluid" src="/recsensorialevidenciafotomostrar/' . $value->id . '/0" style="margin:0px;" data-toggle="tooltip" title="Click para mostrar ' . $value->recsensorialevidencias_tiponombre . '"/>
                    </a>
                </div>';
            }

            $dato['galeria'] = $galeria;
            $dato["msj"] = 'Galería consultada correctamente';


            // Borarr cache // use Artisan;
            // Artisan::call('route:cache');
            // Artisan::call('optimize:clear');
            // Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            Artisan::call('view:clear');


            return response()->json($dato);
        } catch (Exception $e) {
            $dato['galeria'] = null;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $foto_id
     * @param  int  $accion
     * @return \Illuminate\Http\Response
     */
    public function recsensorialevidenciafotomostrar($foto_id, $accion)
    {
        // $foto = recsensorialevidenciasModel::findOrFail($foto_id);
        // return Storage::download($foto->recsensorialevidencias_foto);
        // return Storage::response($foto->recsensorialevidencias_foto);

        $foto = recsensorialevidenciasModel::findOrFail($foto_id);

        if (($accion + 0) == 0) // 0 = mostrar
        {
            return Storage::response($foto->recsensorialevidencias_foto);
        } else {
            return Storage::download($foto->recsensorialevidencias_foto);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $foto_id
     * @return \Illuminate\Http\Response
     */
    public function recsensorialevidenciafotoeliminar($foto_id)
    {
        try {
            // Buscar registro
            $foto = recsensorialevidenciasModel::findOrFail($foto_id);

            // Eliminar foto
            if (Storage::exists($foto->recsensorialevidencias_foto)) {
                Storage::delete($foto->recsensorialevidencias_foto);
            }

            // Eliminar registro
            $foto = recsensorialevidenciasModel::where('id', $foto_id)->delete();

            // respuesta
            $dato["msj"] = 'Foto eliminada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }

    /// OBTENEMOS LOS DATOS DEL INFORME
    public function obtenerDatosInformes($ID)
    {
        try {
            $opciones_select = '<option value="">&nbsp;</option>';
            $html  = '<option value="">&nbsp;</option>';
            $info = DB::select('SELECT ID_RECURSO_INFORME,
                                        RECSENSORIAL_ID,
                                        INTRODUCCION,
                                        METODOLOGIA,
                                        CONCLUSION,
                                        IMAGEN_PORTADA,
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
                                        PETICION_CLIENTE,
                                        AGREGAR_RECOMENDACION,
                                        REQUIERE_CONCLUSION,
                                        ID_CATCONCLUSION
                                FROM recsensorial_recursos_informes
                                WHERE RECSENSORIAL_ID = ?', [$ID]);


            $niveles = DB::select('  SELECT 
                                        "Instalación" ETIQUETA,
                                        recsensorial_instalacion OPCION,
                                        0 NIVEL
                                    FROM recsensorial
                                    WHERE id = ?
                                    UNION
                                    SELECT
                                        IFNULL(ce.NOMBRE_ETIQUETA, "NO") AS ETIQUETA,
		                                IFNULL(co.NOMBRE_OPCIONES , "NO") AS OPCION, 
                                        IFNULL(ep.NIVEL, 0) NIVEL
                                    FROM recsensorial rs
                                    LEFT JOIN proyecto p ON rs.proyecto_folio = p.proyecto_folio
                                    LEFT JOIN estructuraProyectos ep ON p.id = ep.PROYECTO_ID
                                    LEFT JOIN cat_etiquetas ce ON ep.ETIQUETA_ID = ce.ID_ETIQUETA
                                    LEFT JOIN catetiquetas_opciones co ON ep.OPCION_ID = co.ID_OPCIONES_ETIQUETAS
                                    WHERE rs.id = ?
                                    UNION
                                    SELECT 
                                        "Folio" ETIQUETA,
                                        recsensorial_folioquimico OPCION,
                                        0 NIVEL
                                    FROM recsensorial
                                    WHERE id = ?
                                    UNION
                                    SELECT
                                        "Razón social" ETIQUETA,
                                        recsensorial_empresa OPCION,
                                        0 NIVEL
                                    FROM recsensorial
                                    WHERE id = ?
                                    UNION
                                    SELECT 
                                        "Nombre comercial" ETIQUETA,
                                        c.cliente_NombreComercial OPCION,
                                        0 NIVEL
                                    FROM cliente c
                                    LEFT JOIN recsensorial r ON r.cliente_id = c.id
                                    WHERE r.id = ?
                                    ORDER BY NIVEL', [$ID, $ID, $ID, $ID, $ID]);



            foreach ($niveles as $key => $value) {

                if ($value->ETIQUETA == 'NO') {

                    $opciones_select .= '<option value="" disabled> Proyecto vinculado sin Estructura organizacional para mostrar</option>';
                } else {

                    if ($value->NIVEL == 0) {

                        $opciones_select .= '<option value="' . $value->OPCION . '"  >' . $value->ETIQUETA . ' : ' . $value->OPCION  . ' </option>';
                    } else {

                        $opciones_select .= '<option value="' . $value->OPCION . '"  >' . $value->ETIQUETA . ' : ' . $value->OPCION . ' [ Nivel' . $value->NIVEL . ']' . ' </option>';
                    }
                }
            }


            foreach ($niveles as $key => $value) {
                if ($value->ETIQUETA == 'Instalación' || $value->NIVEL != 0) {

                    $html .= '<option value="' . $value->OPCION . '">' . $value->ETIQUETA . " : " . $value->OPCION;
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
            return response()->json($dato, 500); // Se puede usar el código de estado 500 para indicar un error del servidor
        }
    }


    // OBTEMOS LOS DATOS DE LA TABLA QUE SE RELLENA DE FORMA MANUAL PARA EL INFORME
    public function obtenerTablaInforme($ID)
    {
        try {

            $datos = DB::select('CALL sp_obtener_tabla_informe_final_b(?)', [$ID]);


            $dato["data"] = $datos;
            $dato["nuevo"] = 1;
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500);
        }
    }


    // OBTEMOS LAS RECOMENDACIONES SELECCIONADAS PARA EL INFORME
    public function consultarRecomendaciones($ID)
    {
        try {

            $datos = DB::select('SELECT RECOMENDACION_ID FROM recsensorialRecomendaciones WHERE RECSENSORIAL_ID', [$ID]);

            $dato["data"] = $datos;
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500);
        }
    }



    //FUNCION PARA OBTENER LOS PUNTOS DE MUESTREO Y POE DEL CLIENTE
    public function obtenerTablaClienteInforme($ID)
    {
        try {

            $info = DB::select(' SELECT *, IF(PPT IS NULL,0,1) TIENE_PPT, IF(CT IS NULL,0,1) TIENE_CT
                                FROM recsensorial_tablaClientes_informes cliente
                                WHERE cliente.RECONOCIMIENTO_ID = ?', [$ID]);

            //SI NO ESTA VACIA LA CONSULTA
            if (!empty($info)) {

                $dato["data"] = $info;
                $dato["nuevo"] = 0;
                return response()->json($dato);
            } else {

                $dato["data"] = "Vacia";
                $dato["nuevo"] = 1;
                return response()->json($dato);
            }
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500); // Se puede usar el código de estado 500 para indicar un error del servidor
        }
    }




    public function obtenerTablaClienteProporcionado($ID)
    {
        try {

            $info = DB::select(' SELECT *
                                FROM recsensorial_tablaClientes_proporcionado
                                WHERE RECONOCIMIENTO_ID = ?', [$ID]);

            //SI NO ESTA VACIA LA CONSULTA
            if (!empty($info)) {

                $dato["data"] = $info;
                $dato["nuevo"] = 0;
                return response()->json($dato);
            } else {

                $dato["data"] = "proporcionado";
                $dato["nuevo"] = 1;
                return response()->json($dato);
            }
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500); // Se puede usar el código de estado 500 para indicar un error del servidor
        }
    }




    //FUNCION PARA CONSULTAR SI UN COMPONENTE TIENE PPT Y CT
    public function consultarPPTyCT($id)
    {
        try {


            $info = DB::select(' SELECT IF(entidad.VLE_PPT IS NULL,0, 1) TIENE_PPT,
                                        IF(entidad.VLE_CT_P IS NULL,0,1) TIENE_CT
                                FROM catsustancias_quimicas sus
                                LEFT JOIN sustanciaQuimicaEntidad entidad ON entidad.SUSTANCIA_QUIMICA_ID = sus.ID_SUSTANCIA_QUIMICA
                                WHERE sus.ID_SUSTANCIA_QUIMICA = ?', [$id]);


            if (($info[0]->TIENE_PPT == 0 && $info[0]->TIENE_CT == 0) || (empty($info[0]->TIENE_PPT) && empty($info[0]->TIENE_CT == 0))) {
                $dato['PPT'] = 0;
                $dato['CT'] = 0;
                $dato["code"] = 0;
            } else {

                $dato['PPT'] = $info[0]->TIENE_PPT;
                $dato['CT'] = $info[0]->TIENE_CT;
                $dato["code"] = 1;
            }

            return response()->json($dato);
        } catch (Exception $e) {
            $dato['PPT'] = -1;
            $dato['CT'] = -1;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }




    //FUNCION PARA OBTENER LAS CATEGORIAS DE UN RECONOCIMIENTO
    public function obtenerCategorias($recsensorial_id, $area_id)
    {
        try {
            $opciones1 = '<option value=""></option><option value="0">Ambiente laboral</option>';



            $grupos = DB::select(' SELECT
                                        cat.recsensorialcategoria_nombrecategoria AS CATEGORIA,
                                        area.recsensorialcategoria_id AS CATEGORIA_ID
                                    FROM
                                        recsensorialareacategorias area
                                    LEFT JOIN recsensorialcategoria cat ON cat.id = area.recsensorialcategoria_id  
                                    WHERE
                                        area.recsensorialarea_id = ?', [$area_id]);



            //CREAMOS LAS OPCIONES PARA LAS AREAS
            foreach ($grupos as $value) {
                $opciones1 .= '<option value="' . $value->CATEGORIA_ID . '" >' . $value->CATEGORIA . '</option>';
            }


            // respuesta
            $dato['opcionesaCategorias'] = $opciones1;
            $dato["msj"] = 'Informacion consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opciones'] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }



    //FUNCION PARA OBTENER LOS GRUPOS DE EXPOSICION Y COMPONENTE-PRODUCTO
    public function obtenerGruposComponetes($recsensorial_id)
    {
        try {
            $opciones1 = '<option value=""></option>';
            $opciones2 = '<option value=""></option>';


            // $grupos = DB::select(' SELECT 
            //         categoria.recsensorialcategoria_nombrecategoria AS CATEGORIA,
            //         categoria.id AS CATEGORIA_ID,
            //         (IFNULL(inventario.recsensorialcategoria_tiempoexpo, 0) * IFNULL(inventario.recsensorialcategoria_frecuenciaexpo, 0)) AS TOTAL_EXPO
            // FROM recsensorialquimicosinventario inventario
            // LEFT JOIN recsensorialareacategorias areaCategoria ON inventario.recsensorialarea_id = areaCategoria.recsensorialarea_id 
            // LEFT JOIN recsensorialcategoria categoria ON areaCategoria.recsensorialcategoria_id = categoria.id
            // WHERE inventario.recsensorial_id = ?', [$recsensorial_id]);

            $componentes = DB::select("SELECT CONCAT('[',NUM_CAS,'] ', SUSTANCIA_QUIMICA) AS COMPONENTE,
                                        ID_SUSTANCIA_QUIMICA
                                        FROM catsustancias_quimicas");


            $areas = DB::select("SELECT a.recsensorialarea_nombre, a.id 
                                    FROM recsensorialareacategorias ac
                                    LEFT JOIN recsensorialarea a ON a.id = ac.recsensorialarea_id
                                    LEFT JOIN recsensorialcategoria c ON c.id = ac.recsensorialcategoria_id
                                    WHERE a.recsensorial_id = ?
                                    GROUP BY a.id, a.recsensorialarea_nombre", [$recsensorial_id]);

            $puntos = DB::select("SELECT COUNT(*) AS PUNTOS
                                    FROM recsensorial_tabla_informes
                                    WHERE RECONOCIMIENTO_ID = ?", [$recsensorial_id]);


            //CREAMOS LAS OPCIONES PARA LAS AREAS
            foreach ($areas as $value) {
                $opciones1 .= '<option value="' . $value->id . '" >' . $value->recsensorialarea_nombre . '</option>';
            }

            //CREAMOS LAS OPCIONES PARA EL SELECT DE LOS COMPONENTES Y PRODUCTOS
            foreach ($componentes as $value) {
                $opciones2 .= '<option value="' . $value->ID_SUSTANCIA_QUIMICA . '" >' . $value->COMPONENTE . '</option>';
            }


            // respuesta
            $dato['puntos'] = $puntos[0]->PUNTOS;
            $dato['opcionesaAreas'] = $opciones1;
            $dato['opcionesComponentes'] = $opciones2;
            $dato["msj"] = 'Informacion consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opciones'] = 0;
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato);
        }
    }


    // Obtener las sustancias quimicas que proporcione el cliente 
    public function obtenerComponentes()
    {
        try {
            // Ejecutar la consulta para obtener los componentes
            $componentes = DB::select("SELECT CONCAT('[', NUM_CAS, '] ', SUSTANCIA_QUIMICA) AS COMPONENTE, ID_SUSTANCIA_QUIMICA FROM catsustancias_quimicas");

            // Crear las opciones para el select
            $opciones = '<option value=""></option>';
            foreach ($componentes as $value) {
                $opciones .= '<option value="' . $value->ID_SUSTANCIA_QUIMICA . '">' . $value->COMPONENTE . '</option>';
            }

            // Respuesta
            $dato['opcionesComponentes'] = $opciones;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato['opcionesComponentes'] = '<option value=""></option>';
            $dato["msj"] = 'Error ' . $e->getMessage();
            return response()->json($dato, 500);
        }
    }


    public function informePortada($ID)
    {

        $img = recsensorialRecursosInformesModel::findOrFail($ID);
        return Storage::response($img->IMAGEN_PORTADA);
    }



    // DESCARGAR ZIP

    public function verZIP($opcion, $ID)
    {
        $documento = controlCambiosModel::findOrFail($ID);
        $filePath = storage_path('app/' . $documento->RUTA_ZIP);

        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }

        if ($opcion == 0) {
            return response()->file($filePath);
        } else {
            $fileName = basename($documento->RUTA_ZIP);

            return response()->download($filePath, $fileName, [
                'Content-Disposition' => "attachment; filename*=UTF-8''" . rawurlencode($fileName)
            ]);
        }
    }





    public function verificarRevision($id)
    {
        $registro = DB::select("
            SELECT CANCELADO
            FROM controlCambios
            WHERE RECONOCIMIENTO_ID = ? 
            ORDER BY NUMERO_VERSIONES DESC
            LIMIT 1
        ", [$id]);

        if ($registro) {
            $permitido = $registro[0]->CANCELADO == 1;
            return response()->json([
                'permitido' => $permitido,
                'mensaje' => $permitido
                    ? 'Se puede generar una nueva revisión.'
                    : 'No disponible: Para generar una nueva revisión, debe cancelar la revisión más reciente.'
            ]);
        } else {
            return response()->json([
                'permitido' => true,
                'mensaje' => 'No hay revisiones previas. Puede crear una nueva revisión.'
            ]);
        }
    }







    //  VERIFICAR QUE ESTE BLOQUEADO 

    public function verificarBloqueado($id)
    {
        $registro = DB::select("
                SELECT BLOQUEADO
                FROM controlCambios
                WHERE RECONOCIMIENTO_ID = ? 
                ORDER BY NUMERO_VERSIONES DESC
                LIMIT 1
            ", [$id]);

        if ($registro) {
            return response()->json(['BLOQUEADO' => $registro[0]->BLOQUEADO]);
        } else {
            return response()->json(['BLOQUEADO' => 0]);
        }
    }



    public function actualizarEstadoCancelado(Request $request)
    {
        try {
            $id = $request->input('id');
            $cancelado = $request->input('cancelado');
            $bloqueado = $request->input('bloqueado');

            if ($cancelado == 1){
                $userId = Auth::user()->id;

            }else{
                $userId = null;

            }

            DB::table('controlCambios')
                ->where('ID_CONTROL_CAMBIO', $id)
                ->update([
                    'CANCELADO' => $cancelado,
                    'BLOQUEADO' => $bloqueado,
                    'CANCELADO_POR' => $userId,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }







    //TABLA DE CONTROL DE CAMBIOS
    public function TablaControlCambios($recsensorial_id)
    {
        try {
            // Obtener la última versión
            $ultimaVersion = DB::table('controlCambios')
                ->where('RECONOCIMIENTO_ID', $recsensorial_id)
                ->max('NUMERO_VERSIONES');

            // Cambios
            $cambios = DB::select("SELECT c.ID_CONTROL_CAMBIO, 
                                    CONCAT(er.empleado_nombre, ' ', er.empleado_apellidopaterno, ' ', er.empleado_apellidomaterno) AS REALIZADO_POR,
                                    c.created_at AS FECHA_REALIZADO,
                                    IFNULL(CONCAT(ea.empleado_nombre, ' ', ea.empleado_apellidopaterno, ' ', ea.empleado_apellidomaterno), '--') AS CANCELADO_POR,
                                    IF(c.AUTORIZADO = 0, '--', DATE_FORMAT(c.updated_at, '%Y-%m-%d %H:%i:%s')) AS FECHA_AUTORIZADO,
                                    c.AUTORIZADO,
                                    c.CANCELADO,
                                    c.NUMERO_VERSIONES,
                                    c.CANCELADO_COMENTARIO
                    FROM controlCambios c
                    LEFT JOIN usuario ur ON ur.id = c.REALIZADO_ID
                    LEFT JOIN usuario ua ON ua.id = c.CANCELADO_POR
                    LEFT JOIN empleado er ON er.id = ur.empleado_id
                    LEFT JOIN empleado ea ON ea.id = ua.empleado_id
                    WHERE c.RECONOCIMIENTO_ID = ?", [$recsensorial_id]);

            $COUNT = 0;
            foreach ($cambios as $key => $value) {
                $value->COUNT = $COUNT++;

                // Botón de descarga
                if ($value->NUMERO_VERSIONES == $ultimaVersion) {

                    $value->boton_descargar = '<button type="button" class="btn btn-success btn-circle" onclick="reporte(form_recsensorial.recsensorial_id.value, 2, this, 3, ' . $value->NUMERO_VERSIONES . ');"><i class="fa fa-download"></i></button>';
                } else {
                    $value->boton_descargar = '<button type="button" class="btn btn-success btn-circle descargar"><i class="fa fa-download"></i></button>';
                }

                // Estado del checkbox
                $checked = $value->CANCELADO == 1 ? 'checked' : '';
                $disabled = ($value->NUMERO_VERSIONES == $ultimaVersion) ? '' : 'disabled';

                if (auth()->user()->hasRoles(['Superusuario', 'Administrador'])) {
                    $value->checkbox_cancelado = '<div class="switch" data-toggle="tooltip" title="Solo Administradores y Coordinadores">
                                                    <label>
                                                        <input type="checkbox" class="checkbox_cancelado" ' . $checked . ' ' . $disabled . ' onchange="cancelarrevision(' . $value->ID_CONTROL_CAMBIO . ', this)">
                                                        <span class="lever switch-col-red"></span>
                                                    </label>
                                                 </div>';
                } else {
                    $value->checkbox_cancelado = '<div class="switch" data-toggle="tooltip" title="Solo Administradores y Coordinadores">
                                                    <label>
                                                        <input type="checkbox" class="checkbox_cancelado" ' . $checked . ' disabled>
                                                        <span class="lever switch-col-red"></span>
                                                    </label>
                                                  </div>';
                }
            }

            // Respuesta
            $dato['data'] = $cambios;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }





    public function estructuraproyectos($FOLIO)
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


            $infoProyecto = DB::select('SELECT p.proyecto_clienteinstalacion INSTALACION,
                                                p.proyecto_clientedireccionservicio DIRRECCION,
                                                p.proyecto_clientepersonacontacto REPRESENTANTE,
                                                p.proyecto_clienterfc RFC,
                                                p.proyecto_clienterazonsocial RAZON_SOCIAL,
                                                p.proyecto_representantelegal REPRESENTANTE_LEGAL,
                                                IFNULL(p.cliente_id, (SELECT CLIENTE_ID FROM contratos_clientes WHERE ID_CONTRATO = p.contrato_id)) CLIENTE_ID,
                                                IFNULL(p.contrato_id, 0) CONTRATO_ID,
                                                IF(p.requiereContrato = 0, "No aplica", 
                                                CASE p.tipoServicioCliente
                                                    WHEN 1 THEN "Contrato"
                                                    WHEN 2 THEN "O.S / O.C"
                                                    ELSE "Cotización aceptada"
                                                END) AS TIPO_SERVICIO,
                                                            
                                            IF(p.contrato_id IS NULL, 
                                                "El proyecto seleccionado no tiene un contrato.", 
                                                (SELECT CONCAT(IF(NUMERO_CONTRATO IS NULL, "" ,CONCAT("[ ",NUMERO_CONTRATO," ] ")), DESCRIPCION_CONTRATO)
                                                FROM contratos_clientes 
                                                WHERE ID_CONTRATO = p.contrato_id)) AS NOMBRE_CONTRATO
                                        FROM proyecto p
                                        LEFT JOIN cliente c ON c.id = p.cliente_id
                                        LEFT JOIN contratos_clientes cc ON cc.ID_CONTRATO = p.CONTRATO_ID
                                        WHERE p.proyecto_folio = ?', [$FOLIO]);


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



    public function folioproyecto($proyecto_folio)
    {
        try {
            $opciones_select = '<option value="">&nbsp;</option>';

            $proyectos = DB::select(" SELECT 
                                    p.id, 
                                    p.proyecto_folio,
                                    p.proyecto_clienteinstalacion,
                                    proyecto_clientedireccionservicio
                                FROM 
                                    proyecto p
                                LEFT JOIN 
                                    serviciosProyecto sp ON p.id = sp.PROYECTO_ID
                                WHERE 
                                    sp.HI = 1
                                    AND sp.HI_RECONOCIMIENTO = 1
                                    AND (p.recsensorial_id IS NULL OR p.proyecto_folio = ?) ", [$proyecto_folio]);

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


    //// DESCARGA EXCEL DE VALIDACION 



    public function descargarExcelRecoQuimico($id)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(300);

        $recsensorial = recsensorialModel::find($id);

        if (!$recsensorial) {
            abort(404, 'Registro no encontrado');
        }

        $rutaPlantilla = storage_path('app/plantillas_excel/plantilla validacion reco quimico.xlsx');

        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($rutaPlantilla);


        /*
        |--------------------------------------------------------------------------
        | HOJA "1 "
        |--------------------------------------------------------------------------
        */
        $sheet = $spreadsheet->getSheetByName('1 ');

        if (!$sheet) {
            abort(500, 'No se encontró la hoja 1');
        }


        $proyecto = DB::table('proyecto')
            ->where('proyecto_folio', $recsensorial->proyecto_folio)
            ->first();

        $actividadPrincipal = '';

        if ($proyecto) {
            $actividadPrincipal = $proyecto->proyecto_clientegiroempresa;
        }

        $sheet->setCellValue('F15', $actividadPrincipal);



        $sheet->setCellValue('F7',  $recsensorial->recsensorial_empresa);
        $sheet->setCellValue('F9',  $recsensorial->recsensorial_rfc);
        $sheet->setCellValue('F11', $recsensorial->recsensorial_direccion);
        $sheet->setCellValue('F13', $recsensorial->recsensorial_instalacion);

        $instalacion = str_replace(
            ['\\', '/', ':', '*', '?', '"', '<', '>', '|'],
            '',
            $recsensorial->recsensorial_instalacion
        );



        $fila = 24;


        $sql1 = DB::select(
            "CALL sp_obtener_caracteristicas_sustancia_informe_b(?)",
            [$id]
        );

        $sqlComplemento = DB::select("
            SELECT
                hoja.catsustancia_nombre,
                sus.SUSTANCIA_QUIMICA,
                ingreso.catviaingresoorganismo_viaingreso AS VIA_INGRESO,
                sus.CLASIFICACION_RIESGO,
                IFNULL(MAX(entidad.VLE_PPT),'ND') AS PPT,
                IFNULL(MAX(entidad.VLE_CT_P),'ND') AS CT
            FROM recsensorialquimicosinventario inventario
            LEFT JOIN catHojasSeguridad_SustanciasQuimicas relacion
                ON relacion.HOJA_SEGURIDAD_ID = inventario.catsustancia_id
            LEFT JOIN catsustancia hoja
                ON hoja.id = relacion.HOJA_SEGURIDAD_ID
            LEFT JOIN catsustancias_quimicas sus
                ON sus.ID_SUSTANCIA_QUIMICA = relacion.SUSTANCIA_QUIMICA_ID
            LEFT JOIN sustanciaQuimicaEntidad entidad
                ON entidad.SUSTANCIA_QUIMICA_ID = sus.ID_SUSTANCIA_QUIMICA
            LEFT JOIN catviaingresoorganismo ingreso
                ON ingreso.id = sus.VIA_INGRESO
            WHERE inventario.recsensorial_id = ?
            GROUP BY
                hoja.catsustancia_nombre,
                sus.SUSTANCIA_QUIMICA,
                ingreso.catviaingresoorganismo_viaingreso,
                sus.CLASIFICACION_RIESGO
            ORDER BY hoja.id, sus.SUSTANCIA_QUIMICA
            ", [$id]);

        $sql3 = DB::select("
            SELECT
                sus.catsustancia_nombre AS agente,
                IFNULL(recsensorialarea.recsensorialarea_nombre,'Sin dato') AS recsensorialarea_nombre,
                recsensorialmaquinaria.recsensorialmaquinaria_descripcionfuente AS recsensorialmaquinaria_nombre
            FROM recsensorialmaquinaria
            LEFT JOIN recsensorialarea
                ON recsensorialmaquinaria.recsensorialarea_id = recsensorialarea.id
            LEFT JOIN catsustancia sus
                ON sus.id = recsensorialmaquinaria.recsensorialmaquinaria_quimica
            WHERE recsensorialmaquinaria.recsensorial_id = ?
            AND (
                recsensorialmaquinaria.recsensorialmaquinaria_afecta = 2
                OR recsensorialmaquinaria.recsensorialmaquinaria_afecta = 3
            )
            ORDER BY recsensorialarea.id ASC,
                    recsensorialmaquinaria.recsensorialmaquinaria_nombre ASC
        ", [$id]);

        $datos3 = [];

        foreach ($sql3 as $item3) {
            $agente = trim($item3->agente);

            if (!isset($datos3[$agente])) {
                $datos3[$agente] = [
                    'AREA' => [],
                    'FUENTE' => []
                ];
            }

            $datos3[$agente]['AREA'][] = $item3->recsensorialarea_nombre;
            $datos3[$agente]['FUENTE'][] = $item3->recsensorialmaquinaria_nombre;
        }


        $datosComplementarios = [];

        foreach ($sqlComplemento as $item) {
            $clave = trim($item->catsustancia_nombre) . '|' . trim($item->SUSTANCIA_QUIMICA);

            $datosComplementarios[$clave] = [
                'VIA_INGRESO' => $item->VIA_INGRESO,
                'CLASIFICACION_RIESGO' => $item->CLASIFICACION_RIESGO,
                'PPT' => $item->PPT,
                'CT' => $item->CT
            ];
        }


        $fila = 24;
        $sustanciaAnterior = '';

        foreach ($sql1 as $item1) {
            $sustancia = trim($item1->catsustancia_nombre);

            $AREA = '';
            $FUENTE = '';

            if (isset($datos3[$sustancia])) {
                $AREA = implode("\n", array_unique($datos3[$sustancia]['AREA']));
                $FUENTE = implode("\n", array_unique($datos3[$sustancia]['FUENTE']));
            }

            $clave = $sustancia . '|' . trim($item1->SUSTANCIA_QUIMICA);

            $VIA_INGRESO = '';
            $CLASIFICACION_RIESGO = '';
            $PPT = 'ND';
            $CT = 'ND';

            if (isset($datosComplementarios[$clave])) {
                $VIA_INGRESO = $datosComplementarios[$clave]['VIA_INGRESO'];
                $CLASIFICACION_RIESGO = $datosComplementarios[$clave]['CLASIFICACION_RIESGO'];
                $PPT = $datosComplementarios[$clave]['PPT'];
                $CT = $datosComplementarios[$clave]['CT'];
            }

            if ($sustanciaAnterior != $sustancia) {
                $sheet->setCellValue('D' . $fila, $AREA);
                $sheet->setCellValue('E' . $fila, $sustancia);
                $sheet->setCellValue('P' . $fila, $FUENTE);
            }

            $sheet->setCellValue('F' . $fila, $item1->SUSTANCIA_QUIMICA);
            $sheet->setCellValue('G' . $fila, $item1->NUM_CAS);
            $sheet->setCellValue('H' . $fila, $item1->TEM_EBULLICION);
            $sheet->setCellValue('I' . $fila, $item1->PM);
            $sheet->setCellValue('J' . $fila, $item1->catestadofisicosustancia_estado);
            $sheet->setCellValue('K' . $fila, $item1->catvolatilidad_tipo);

            $sheet->setCellValue('L' . $fila, $VIA_INGRESO);
            $sheet->setCellValue('M' . $fila, $CLASIFICACION_RIESGO);
            $sheet->setCellValue('N' . $fila, $PPT);
            $sheet->setCellValue('O' . $fila, $CT);

            $sustanciaAnterior = $sustancia;

            $fila++;
        }


        /*
        |--------------------------------------------------------------------------
        | HOJA "2"
        |--------------------------------------------------------------------------
        */

        $sheet2 = $spreadsheet->getSheetByName('2');

        if (!$sheet2) {
            abort(500, 'No se encontró la hoja 2');
        }



        $sql4 = DB::select("
        SELECT
            SUMAS.AREA,
            SUMAS.AREA_ID,
            SUMAS.PRODUCTO,
            SUMAS.COMPONENTE,
            SUMAS.ENTIDAD_ID,
            SUMAS.PONDERACION_CANTIDAD,
            SUMAS.PORCENTAJE,
            SUMAS.PONDERACION_CLASIFICACION,
            SUMAS.PONDERACION_VOLATILIDAD,
            SUMAS.SUMA_PONDERACIONES,
            SUMAS.hoja_id,

            (
                CASE
                    WHEN SUMAS.SUMA_PONDERACIONES BETWEEN 1 AND 4 THEN 'Muy Baja'
                    WHEN SUMAS.SUMA_PONDERACIONES >= 5 AND SUMAS.SUMA_PONDERACIONES <= 7 THEN 'Baja'
                    WHEN SUMAS.SUMA_PONDERACIONES = 8 OR SUMAS.SUMA_PONDERACIONES = 9 THEN 'Moderada'
                    WHEN SUMAS.SUMA_PONDERACIONES = 10 OR SUMAS.SUMA_PONDERACIONES = 11 THEN 'Alta'
                    WHEN SUMAS.SUMA_PONDERACIONES >= 12 THEN 'Muy Alta'
                    ELSE 'Desconocida'
                END
            ) AS PRIORIDAD,

            (
                CASE
                    WHEN SUMAS.SUMA_PONDERACIONES BETWEEN 1 AND 4 THEN '#FDFEFE'
                    WHEN SUMAS.SUMA_PONDERACIONES >= 5 AND SUMAS.SUMA_PONDERACIONES <= 7 THEN '#2ECC71'
                    WHEN SUMAS.SUMA_PONDERACIONES = 8 OR SUMAS.SUMA_PONDERACIONES = 9 THEN '#F1C40F'
                    WHEN SUMAS.SUMA_PONDERACIONES = 10 OR SUMAS.SUMA_PONDERACIONES = 11 THEN '#E74C3C'
                    WHEN SUMAS.SUMA_PONDERACIONES >= 12 THEN '#8E44AD'
                    ELSE '#000000'
                END
            ) AS COLOR

        FROM
        (
            SELECT
                PONDERACIONES.AREA,
                PONDERACIONES.AREA_ID,
                PONDERACIONES.PRODUCTO,
                PONDERACIONES.hoja_id,
                PONDERACIONES.COMPONENTE,
                PONDERACIONES.ENTIDAD_ID,
                PONDERACIONES.PONDERACION_CANTIDAD,
                PONDERACIONES.PORCENTAJE,
                PONDERACIONES.PONDERACION_CLASIFICACION,
                PONDERACIONES.PONDERACION_VOLATILIDAD,
                (
                    PONDERACION_CANTIDAD +
                    PONDERACION_CLASIFICACION +
                    PONDERACION_VOLATILIDAD
                ) AS SUMA_PONDERACIONES

            FROM
            (
                SELECT
                    IFNULL(area.recsensorialarea_nombre,'Sin dato') AREA,
                    area.id AREA_ID,
                    hoja.catsustancia_nombre PRODUCTO,
                    hoja.id hoja_id,
                    sus.SUSTANCIA_QUIMICA COMPONENTE,
                    entidad.ENTIDAD_ID,

                    IF(
                        (
                            JSON_CONTAINS(entidad.CONNOTACION,'\"1\"')
                            OR JSON_CONTAINS(entidad.CONNOTACION,'\"2\"')
                        ),
                        5,
                        f_ponderacion_cantidad(
                            ?, inventario.recsensorialcategoria_id,
                            inventario.recsensorialarea_id,
                            inventario.catsustancia_id,
                            sus.ID_SUSTANCIA_QUIMICA
                        )
                    ) AS PONDERACION_CANTIDAD,

                    ((inventario.recsensorialquimicosinventario_cantidad * relacion.PORCENTAJE)/100) AS PORCENTAJE,

                    (
                        CASE
                            WHEN sus.CLASIFICACION_RIESGO = 0 THEN 1
                            WHEN sus.CLASIFICACION_RIESGO = 1 THEN 2
                            WHEN sus.CLASIFICACION_RIESGO = 2 THEN 3
                            WHEN sus.CLASIFICACION_RIESGO = 3 THEN 4
                            WHEN sus.CLASIFICACION_RIESGO = 4 THEN 5
                            ELSE 0
                        END
                    ) AS PONDERACION_CLASIFICACION,

                    vol.catvolatilidad_ponderacion PONDERACION_VOLATILIDAD

                FROM recsensorialquimicosinventario inventario

                LEFT JOIN catHojasSeguridad_SustanciasQuimicas relacion
                    ON relacion.HOJA_SEGURIDAD_ID = inventario.catsustancia_id

                LEFT JOIN catsustancia hoja
                    ON hoja.id = relacion.HOJA_SEGURIDAD_ID

                LEFT JOIN catsustancias_quimicas sus
                    ON sus.ID_SUSTANCIA_QUIMICA = relacion.SUSTANCIA_QUIMICA_ID

                LEFT JOIN sustanciaQuimicaEntidad entidad
                    ON entidad.SUSTANCIA_QUIMICA_ID = sus.ID_SUSTANCIA_QUIMICA

                LEFT JOIN recsensorialarea area
                    ON inventario.recsensorialarea_id = area.id

                LEFT JOIN catvolatilidad vol
                    ON vol.id = relacion.VOLATILIDAD

                WHERE inventario.recsensorial_id = ?
                    AND (entidad.ENTIDAD_ID = 1)
                    AND (
                        relacion.PORCENTAJE > 1.00
                        OR JSON_CONTAINS(entidad.CONNOTACION,'\"1\"')
                        OR JSON_CONTAINS(entidad.CONNOTACION,'\"2\"')
                    )

            ) PONDERACIONES

        ) SUMAS

        ORDER BY
        SUMAS.hoja_id,
        SUMAS.AREA_ID,
        SUMAS.PRODUCTO
        ", [$id, $id]);


        $sql5 = DB::select("
            SELECT
                IFNULL(catsustancia.catsustancia_nombre,'Sin dato') PRODUCTO,
                recsensorialquimicosinventario.recsensorialquimicosinventario_cantidad CANTIDAD,
                catunidadmedidasustacia.catunidadmedidasustacia_abreviacion UNIDAD
            FROM recsensorialquimicosinventario
            LEFT JOIN catsustancia
                ON recsensorialquimicosinventario.catsustancia_id = catsustancia.id
            LEFT JOIN catunidadmedidasustacia
                ON recsensorialquimicosinventario.catunidadmedidasustacia_id = catunidadmedidasustacia.id
            WHERE recsensorialquimicosinventario.recsensorial_id = ?
            GROUP BY
                catsustancia.id,
                catsustancia.catsustancia_nombre,
                recsensorialquimicosinventario.recsensorialquimicosinventario_cantidad,
                catunidadmedidasustacia.catunidadmedidasustacia_abreviacion
            ORDER BY catsustancia.id
            ", [$id]);



        $sql6 = DB::select("
            SELECT
                hoja.catsustancia_nombre,
                sus.SUSTANCIA_QUIMICA,
                IFNULL(
                    IF(
                        ROUND(relacion.PORCENTAJE,2)=ROUND(relacion.PORCENTAJE),
                        ROUND(relacion.PORCENTAJE),
                        relacion.PORCENTAJE
                    ),
                    'ND'
                ) AS PORCENTAJE,
                IF(relacion.OPERADOR='*','',relacion.OPERADOR) OPERADOR
            FROM recsensorialquimicosinventario inventario
            LEFT JOIN catHojasSeguridad_SustanciasQuimicas relacion
                ON relacion.HOJA_SEGURIDAD_ID=inventario.catsustancia_id
            LEFT JOIN catsustancia hoja
                ON hoja.id=relacion.HOJA_SEGURIDAD_ID
            LEFT JOIN catsustancias_quimicas sus
                ON sus.ID_SUSTANCIA_QUIMICA=relacion.SUSTANCIA_QUIMICA_ID
            WHERE inventario.recsensorial_id=?
            GROUP BY
                relacion.HOJA_SEGURIDAD_ID,
                relacion.SUSTANCIA_QUIMICA_ID,
                hoja.catsustancia_nombre,
                sus.SUSTANCIA_QUIMICA,
                PORCENTAJE,
                OPERADOR
            ORDER BY hoja.id,sus.SUSTANCIA_QUIMICA
            ", [$id]);



        $sql7 = DB::select("
            SELECT DISTINCT
                hoja.catsustancia_nombre PRODUCTO,
                sus.SUSTANCIA_QUIMICA COMPONENTE,
                area.recsensorialarea_nombre AREA,
                cat.recsensorialcategoria_nombrecategoria CATEGORIA,
                relacion.recsensorialareacategorias_actividad ACTIVIDAD,
                grupos.POE,
                relacion.frecuenciaexpo_quimico FRECUENCIA,
                cat.sumaHorasJornada JORNADA
            FROM grupos_de_exposicion grupos
            LEFT JOIN recsensorialareacategorias relacion
                ON relacion.id = grupos.RELACION_AREA_CAT_ID
            LEFT JOIN recsensorialarea area
                ON area.id = relacion.recsensorialarea_id
            LEFT JOIN recsensorialcategoria cat
                ON cat.id = relacion.recsensorialcategoria_id
            LEFT JOIN catHojasSeguridad_SustanciasQuimicas relacionSus
                ON relacionSus.ID_HOJA_SUSTANCIA = grupos.RELACION_HOJA_SUS_ID
            LEFT JOIN catsustancia hoja
                ON hoja.id = relacionSus.HOJA_SEGURIDAD_ID
            LEFT JOIN catsustancias_quimicas sus
                ON sus.ID_SUSTANCIA_QUIMICA = relacionSus.SUSTANCIA_QUIMICA_ID
            WHERE grupos.RECSENSORIAL_ID = ?
            ORDER BY hoja.id,sus.SUSTANCIA_QUIMICA
            ", [$id]);



        $datos4 = [];

        foreach ($sql4 as $item4) {
            $clave = trim($item4->PRODUCTO) . '|' . trim($item4->COMPONENTE);

            $datos4[$clave] = [
                'PONDERACION_CANTIDAD' => $item4->PONDERACION_CANTIDAD,
                'PONDERACION_CLASIFICACION' => $item4->PONDERACION_CLASIFICACION,
                'PONDERACION_VOLATILIDAD' => $item4->PONDERACION_VOLATILIDAD,
                'SUMA_PONDERACIONES' => $item4->SUMA_PONDERACIONES,
                'PRIORIDAD' => $item4->PRIORIDAD,
                'COLOR' => $item4->COLOR
            ];
        }

        $datos5 = [];

        foreach ($sql5 as $item5) {
            $datos5[trim($item5->PRODUCTO)] = [
                'CANTIDAD' => $item5->CANTIDAD,
                'UNIDAD' => $item5->UNIDAD
            ];
        }

        $datos6 = [];

        foreach ($sql6 as $item6) {
            $clave = trim($item6->catsustancia_nombre) . '|' . trim($item6->SUSTANCIA_QUIMICA);

            $datos6[$clave] = [
                'OPERADOR' => $item6->OPERADOR,
                'PORCENTAJE' => $item6->PORCENTAJE
            ];
        }


        $datos7 = [];

        foreach ($sql7 as $item7) {

            $clave = trim($item7->PRODUCTO) . '|' . trim($item7->COMPONENTE);

            $datos7[$clave][] = [
                'CATEGORIA'  => $item7->CATEGORIA,
                'ACTIVIDAD'  => $item7->ACTIVIDAD,
                'POE'        => $item7->POE,
                'FRECUENCIA' => $item7->FRECUENCIA,
                'JORNADA'    => $item7->JORNADA
            ];
        }


        $datosArea2 = [];

        foreach ($sql3 as $item3) {

            $productoArea = trim($item3->agente);

            if (!isset($datosArea2[$productoArea])) {

                $datosArea2[$productoArea] = [
                    'AREA' => [],
                    'FUENTE' => []
                ];
            }

            $datosArea2[$productoArea]['AREA'][] = $item3->recsensorialarea_nombre;
            $datosArea2[$productoArea]['FUENTE'][] = $item3->recsensorialmaquinaria_nombre;
        }


        $fila2 = 8;

        $productoAnterior = '';
        $componenteAnterior = '';
        $areaAnterior = '';


        foreach ($sql1 as $item1) {

            $producto = trim($item1->catsustancia_nombre);
            $componente = trim($item1->SUSTANCIA_QUIMICA);

            $clave = $producto . '|' . $componente;

            $area = '';

            if (isset($datosArea2[$producto])) {

                $area = implode(
                    "\n",
                    array_unique($datosArea2[$producto]['AREA'])
                );
            }


            $ponderacionCantidad = '';
            $ponderacionClasificacion = '';
            $ponderacionVolatilidad = '';
            $sumaPonderaciones = '';
            $prioridad = '';
            $color = 'FFFFFF';

            if (isset($datos4[$clave])) {

                $ponderacionCantidad = $datos4[$clave]['PONDERACION_CANTIDAD'];
                $ponderacionClasificacion = $datos4[$clave]['PONDERACION_CLASIFICACION'];
                $ponderacionVolatilidad = $datos4[$clave]['PONDERACION_VOLATILIDAD'];
                $sumaPonderaciones = $datos4[$clave]['SUMA_PONDERACIONES'];
                $prioridad = $datos4[$clave]['PRIORIDAD'];
                $color = str_replace('#', '', $datos4[$clave]['COLOR']);
            }

            $cantidad = '';
            $unidad = '';

            if (isset($datos5[$producto])) {

                $cantidad = $datos5[$producto]['CANTIDAD'];
                $unidad = $datos5[$producto]['UNIDAD'];
            }


            $operador = '';
            $porcentaje = '';

            if (isset($datos6[$clave])) {

                $operador = $datos6[$clave]['OPERADOR'];
                $porcentaje = $datos6[$clave]['PORCENTAJE'];
            }


            if (isset($datos7[$clave])) {

                foreach ($datos7[$clave] as $grupo) {

                    if ($areaAnterior != $area) {

                        $sheet2->setCellValue('D' . $fila2, $area);
                    } else {

                        $sheet2->setCellValue('D' . $fila2, '');
                    }


                    if ($productoAnterior != $producto) {

                        $sheet2->setCellValue('E' . $fila2, $producto);

                        $sheet2->setCellValue('G' . $fila2, $cantidad);
                        $sheet2->setCellValue('H' . $fila2, $unidad);
                        $sheet2->setCellValue('J' . $fila2, $cantidad . ' ' . $unidad);
                    } else {

                        $sheet2->setCellValue('E' . $fila2, '');
                        $sheet2->setCellValue('G' . $fila2, '');
                        $sheet2->setCellValue('H' . $fila2, '');
                        $sheet2->setCellValue('J' . $fila2, '');
                    }


                    if ($componenteAnterior != $componente) {

                        $sheet2->setCellValue('F' . $fila2, $componente);

                        $sheet2->setCellValue('I' . $fila2, $operador . $porcentaje);

                        $sheet2->setCellValue('K' . $fila2, $ponderacionCantidad);
                        $sheet2->setCellValue('L' . $fila2, $ponderacionClasificacion);
                        $sheet2->setCellValue('M' . $fila2, $ponderacionVolatilidad);
                        $sheet2->setCellValue('N' . $fila2, $sumaPonderaciones);

                        $sheet2->setCellValue('O' . $fila2, $prioridad);

                        $sheet2->getStyle('O' . $fila2)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

                        $sheet2->getStyle('O' . $fila2)
                            ->getFill()
                            ->getStartColor()
                            ->setARGB($color);
                    } else {

                        $sheet2->setCellValue('F' . $fila2, '');
                        $sheet2->setCellValue('I' . $fila2, '');

                        $sheet2->setCellValue('K' . $fila2, '');
                        $sheet2->setCellValue('L' . $fila2, '');
                        $sheet2->setCellValue('M' . $fila2, '');
                        $sheet2->setCellValue('N' . $fila2, '');

                        $sheet2->setCellValue('O' . $fila2, '');
                    }


                    $sheet2->setCellValue('P' . $fila2, $grupo['CATEGORIA']);
                    $sheet2->setCellValue('Q' . $fila2, $grupo['ACTIVIDAD']);
                    $sheet2->setCellValue('R' . $fila2, $grupo['POE']);
                    $sheet2->setCellValue('T' . $fila2, $grupo['FRECUENCIA']);
                    $sheet2->setCellValue('U' . $fila2, $grupo['JORNADA']);


                    $areaAnterior = $area;
                    $productoAnterior = $producto;
                    $componenteAnterior = $componente;

                    $fila2++;
                }
            } else {

                if ($areaAnterior != $area) {

                    $sheet2->setCellValue('D' . $fila2, $area);
                }

                if ($productoAnterior != $producto) {

                    $sheet2->setCellValue('E' . $fila2, $producto);

                    $sheet2->setCellValue('G' . $fila2, $cantidad);
                    $sheet2->setCellValue('H' . $fila2, $unidad);
                    $sheet2->setCellValue('J' . $fila2, $cantidad . ' ' . $unidad);
                }

                if ($componenteAnterior != $componente) {

                    $sheet2->setCellValue('F' . $fila2, $componente);

                    $sheet2->setCellValue('I' . $fila2, $operador . $porcentaje);

                    $sheet2->setCellValue('K' . $fila2, $ponderacionCantidad);
                    $sheet2->setCellValue('L' . $fila2, $ponderacionClasificacion);
                    $sheet2->setCellValue('M' . $fila2, $ponderacionVolatilidad);
                    $sheet2->setCellValue('N' . $fila2, $sumaPonderaciones);

                    $sheet2->setCellValue('O' . $fila2, $prioridad);

                    $sheet2->getStyle('O' . $fila2)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

                    $sheet2->getStyle('O' . $fila2)
                        ->getFill()
                        ->getStartColor()
                        ->setARGB($color);
                }

                $areaAnterior = $area;
                $productoAnterior = $producto;
                $componenteAnterior = $componente;

                $fila2++;
            }
        }








        /*
        |--------------------------------------------------------------------------
        | HOJA "3.1"
        |--------------------------------------------------------------------------
        */

        $sheet31 = $spreadsheet->getSheetByName('3.1');

        if (!$sheet31) {
            abort(500, 'No se encontró la hoja 3.1');
        }

        $fila31 = 4;



        $sql31 = DB::select("
                    SELECT SUMAS_PONDERACIONES.*,
                    (
                    CASE
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES >= 13 THEN 'Muy alta'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES BETWEEN 9 AND 12 THEN 'Alta'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES BETWEEN 4 AND 8 THEN 'Moderada'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES <= 3 THEN 'Baja'
                        ELSE 'ND'
                    END
                    ) AS PRIORIDAD,

                    (
                    CASE
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES >= 13 THEN '#8E44AD'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES BETWEEN 9 AND 12 THEN '#E74C3C'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES BETWEEN 4 AND 8 THEN '#F1C40F'
                        WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES <= 3 THEN '#2ECC71'
                        ELSE '#000000'
                    END
                    ) AS COLOR,

                    (
                    CASE
                    WHEN SUMAS_PONDERACIONES.SUMA_PONDERACIONES >= 13 THEN
                    CASE
                        WHEN POE > 100 THEN 20
                        WHEN POE >= 51 THEN 15
                        WHEN POE >= 26 THEN 8
                        WHEN POE >= 16 THEN 5
                        WHEN POE >= 9 THEN 3
                        WHEN POE >= 3 THEN 2
                        ELSE 1
                    END
                    ELSE
                    CASE
                        WHEN POE > 100 THEN 10
                        WHEN POE >= 51 THEN 7
                        WHEN POE >= 31 THEN 5
                        WHEN POE >= 21 THEN 4
                        WHEN POE >= 11 THEN 3
                        WHEN POE >= 6 THEN 2
                        ELSE 1
                    END
                    END
                    ) AS NUM_POE

                    FROM
                    (
                        SELECT PONDERACIONES.*,
                        (
                            PONDERACION_INGRESO +
                            PONDERACION_POE +
                            PONDERACION_EXPOSICION
                        ) AS SUMA_PONDERACIONES

                        FROM
                        (
                            SELECT
                                grupos.CLASIFICACION,
                                hoja.catsustancia_nombre,
                                sus.SUSTANCIA_QUIMICA,
                                area.recsensorialarea_nombre AREA,
                                cat.recsensorialcategoria_nombrecategoria CATEGORIA,
                                grupos.POE,

                                IFNULL(
                                    ingreso.catviaingresoorganismo_ponderacion,
                                    0
                                ) AS PONDERACION_INGRESO,

                                (
                                CASE
                                    WHEN grupos.POE > 100 THEN 8
                                    WHEN grupos.POE BETWEEN 25 AND 100 THEN 4
                                    WHEN grupos.POE BETWEEN 5 AND 24 THEN 2
                                    WHEN grupos.POE < 5 THEN 1
                                    ELSE 0
                                END
                                ) AS PONDERACION_POE,

                                (
                                CASE
                                    WHEN ((IFNULL(relacion.tiempoexpo_quimico,0)
                                    *
                                    IFNULL(relacion.frecuenciaexpo_quimico,0))/60) >= 7 THEN 8

                                    WHEN ((IFNULL(relacion.tiempoexpo_quimico,0)
                                    *
                                    IFNULL(relacion.frecuenciaexpo_quimico,0))/60) >= 3 THEN 4

                                    WHEN ((IFNULL(relacion.tiempoexpo_quimico,0)
                                    *
                                    IFNULL(relacion.frecuenciaexpo_quimico,0))/60) >= 1 THEN 2

                                    ELSE 1
                                END
                                ) AS PONDERACION_EXPOSICION

                            FROM grupos_de_exposicion grupos

                            LEFT JOIN recsensorialareacategorias relacion
                                ON relacion.id = grupos.RELACION_AREA_CAT_ID

                            LEFT JOIN recsensorialarea area
                                ON area.id = relacion.recsensorialarea_id

                            LEFT JOIN recsensorialcategoria cat
                                ON cat.id = relacion.recsensorialcategoria_id

                            LEFT JOIN catHojasSeguridad_SustanciasQuimicas relacionSus
                                ON relacionSus.ID_HOJA_SUSTANCIA = grupos.RELACION_HOJA_SUS_ID

                            LEFT JOIN catsustancia hoja
                                ON hoja.id = relacionSus.HOJA_SEGURIDAD_ID

                            LEFT JOIN catsustancias_quimicas sus
                                ON sus.ID_SUSTANCIA_QUIMICA = relacionSus.SUSTANCIA_QUIMICA_ID

                            LEFT JOIN catviaingresoorganismo ingreso
                                ON ingreso.id = sus.VIA_INGRESO

                            WHERE grupos.RECSENSORIAL_ID = ?

                            ORDER BY grupos.CLASIFICACION

                        ) PONDERACIONES

                    ) SUMAS_PONDERACIONES
                    ", [$id]);



        $datos31 = [];

        foreach ($sql31 as $item31) {

            $clave = trim($item31->catsustancia_nombre) . '|' . trim($item31->SUSTANCIA_QUIMICA);

            $datos31[$clave][] = [
                'CATEGORIA' => $item31->CATEGORIA,
                'PONDERACION_INGRESO' => $item31->PONDERACION_INGRESO,
                'PONDERACION_POE' => $item31->PONDERACION_POE,
                'PONDERACION_EXPOSICION' => $item31->PONDERACION_EXPOSICION,
                'SUMA_PONDERACIONES' => $item31->SUMA_PONDERACIONES,
                'PRIORIDAD' => $item31->PRIORIDAD,
                'NUM_POE' => $item31->NUM_POE,
                'COLOR' => $item31->COLOR
            ];
        }




        $productoAnterior31 = '';
        $componenteAnterior31 = '';
        $areaAnterior31 = '';

        foreach ($sql1 as $item1) {

            $producto = trim($item1->catsustancia_nombre);
            $componente = trim($item1->SUSTANCIA_QUIMICA);

            $clave = $producto . '|' . $componente;

            $area = '';

            if (isset($datosArea2[$producto])) {

                $area = implode(
                    "\n",
                    array_unique($datosArea2[$producto]['AREA'])
                );
            }


            if (!isset($datos31[$clave])) {

                $datos31[$clave][] = [
                    'CATEGORIA' => '',
                    'PONDERACION_INGRESO' => '',
                    'PONDERACION_POE' => '',
                    'PONDERACION_EXPOSICION' => '',
                    'SUMA_PONDERACIONES' => '',
                    'PRIORIDAD' => '',
                    'NUM_POE' => '',
                    'COLOR' => 'FFFFFF'
                ];
            }

            foreach ($datos31[$clave] as $grupo) {

                if ($areaAnterior31 != $area) {

                    $sheet31->setCellValue('D' . $fila31, $area);
                } else {

                    $sheet31->setCellValue('D' . $fila31, '');
                }


                if ($productoAnterior31 != $producto) {

                    $sheet31->setCellValue('E' . $fila31, $producto);
                } else {

                    $sheet31->setCellValue('E' . $fila31, '');
                }


                if ($componenteAnterior31 != $componente) {

                    $sheet31->setCellValue('F' . $fila31, $componente);

                    $sheet31->setCellValue('G' . $fila31, $grupo['PONDERACION_INGRESO']);
                    $sheet31->setCellValue('H' . $fila31, $grupo['PONDERACION_POE']);
                    $sheet31->setCellValue('I' . $fila31, $grupo['PONDERACION_EXPOSICION']);
                    $sheet31->setCellValue('J' . $fila31, $grupo['SUMA_PONDERACIONES']);
                    $sheet31->setCellValue('K' . $fila31, $grupo['PRIORIDAD']);

                    if ($grupo['COLOR'] != '') {

                        $sheet31->getStyle('K' . $fila31)
                            ->getFill()
                            ->setFillType(
                                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                            );

                        $sheet31->getStyle('K' . $fila31)
                            ->getFill()
                            ->getStartColor()
                            ->setARGB(
                                str_replace('#', '', $grupo['COLOR'])
                            );
                    }
                } else {

                    $sheet31->setCellValue('F' . $fila31, '');
                    $sheet31->setCellValue('G' . $fila31, '');
                    $sheet31->setCellValue('H' . $fila31, '');
                    $sheet31->setCellValue('I' . $fila31, '');
                    $sheet31->setCellValue('J' . $fila31, '');
                    $sheet31->setCellValue('K' . $fila31, '');
                }


                $sheet31->setCellValue('L' . $fila31, $grupo['CATEGORIA']);
                $sheet31->setCellValue('M' . $fila31, $grupo['NUM_POE']);

                $areaAnterior31 = $area;
                $productoAnterior31 = $producto;
                $componenteAnterior31 = $componente;

                $fila31++;
            }
        }



        /*
        |--------------------------------------------------------------------------
        | HOJA "4"
        |--------------------------------------------------------------------------
        */

        $sheet4 = $spreadsheet->getSheetByName('4');

        if (!$sheet4) {
            abort(500, 'No se encontró la hoja 4');
        }


        $fila4 = 8;

        $sql41 = DB::table('recsensorialarea as area')
            ->join(
                'recsensorialmaquinaria as maq',
                'maq.recsensorialarea_id',
                '=',
                'area.id'
            )
            ->where('maq.recsensorial_id', $id)
            ->select('area.*')
            ->distinct()
            ->orderBy('area.id', 'asc')
            ->get();



        $columna = 'E';

        foreach ($sql41 as $area) {
            $sheet4->setCellValue(
                $columna . $fila4,
                $area->recsensorialarea_nombre
            );

            $columna++;
        }


        $columna = 'E';

        foreach ($sql41 as $area) {
            if ($area->recsensorialarea_condicion == 'Cerrado') {
                $sheet4->setCellValue($columna . '9', 'X');
            } elseif ($area->recsensorialarea_condicion == 'Abierto') {
                $sheet4->setCellValue($columna . '11', 'X');
            }

            $columna++;
        }


        $columna = 'E';

        foreach ($sql41 as $area)
        {
            if (
                $area->recsensorialarea_extraccionaire == 'General'
                || $area->recsensorialarea_extraccionaire == 'Localizado'
            )
            {
                $sheet4->setCellValue($columna.'13', 'X');
            }
            elseif ($area->recsensorialarea_extraccionaire == 'Ninguno')
            {
                $sheet4->setCellValue($columna.'14', 'X');
            }

            $columna++;
        }


        $columna = 'E';

        foreach ($sql41 as $area) {
            if (
                $area->recsensorialarea_inyeccionaire == 'General'
                || $area->recsensorialarea_inyeccionaire == 'Localizado'
            ) {
                $sheet4->setCellValue($columna . '15', 'X');
            } elseif ($area->recsensorialarea_inyeccionaire == 'Ninguno') {
                $sheet4->setCellValue($columna . '16', 'X');
            }

            $columna++;
        }



        $columna = 'E';

        foreach ($sql41 as $area) {
            if ($area->recsensorialarea_caracteristica == 'Continuo') {
                $sheet4->setCellValue($columna . '17', 'X');
            } elseif ($area->recsensorialarea_caracteristica == 'Intermitente') {
                $sheet4->setCellValue($columna . '19', 'X');
            }

            $columna++;
        }



        $columna = 'E';

        foreach ($sql41 as $area) {

            $generacion = explode(',', $area->recsensorialarea_generacioncontaminante);

            if (in_array('Combustión', $generacion)) {
                $sheet4->setCellValue($columna . '21', 'X');
            }

            if (in_array('Aumento de temperatura', $generacion)) {
                $sheet4->setCellValue($columna . '23', 'X');
            }

            if (in_array('Disminución de temperatura', $generacion)) {
                $sheet4->setCellValue($columna . '25', 'X');
            }

            if (in_array('Aumento de presión', $generacion)) {
                $sheet4->setCellValue($columna . '27', 'X');
            }

            if (in_array('Disminución de presión', $generacion)) {
                $sheet4->setCellValue($columna . '29', 'X');
            }

            if (in_array('Generación de humedad', $generacion)) {
                $sheet4->setCellValue($columna . '31', 'X');
            }

            if (
                in_array('N/A', $generacion)
                || in_array('Otro', $generacion)
            ) {

                $sheet4->setCellValue($columna . '22', 'X');
                $sheet4->setCellValue($columna . '24', 'X');
                $sheet4->setCellValue($columna . '26', 'X');
                $sheet4->setCellValue($columna . '28', 'X');
                $sheet4->setCellValue($columna . '30', 'X');
                $sheet4->setCellValue($columna . '32', 'X');
            }

            $columna++;
        }


        $columna = 'E';

        foreach ($sql41 as $area) {
            $sheet4->setCellValue($columna . '34', 'X');
            $sheet4->setCellValue($columna . '36', 'X');
            $sheet4->setCellValue($columna . '38', 'X');
            $sheet4->setCellValue($columna . '40', 'X');
            $sheet4->setCellValue($columna . '42', 'X');
            $sheet4->setCellValue($columna . '44', 'X');
            $sheet4->setCellValue($columna . '46', 'X');
            $sheet4->setCellValue($columna . '47', 'X');
            $sheet4->setCellValue($columna . '50', 'X');
            $sheet4->setCellValue($columna . '52', 'X');
            $sheet4->setCellValue($columna . '54', 'X');

            $columna++;
        }



        $sql42 = [];

        foreach ($sql41 as $area) {
            $categorias = DB::table('recsensorialareacategorias')
                ->where('recsensorialarea_id', $area->id)
                ->pluck('recsensorialcategoria_id');

            if ($categorias->count() == 0) {
                $epp = DB::table('recsensorialequipopp')
                    ->where('recsensorial_id', $id)
                    ->where('recsensorialcategoria_id', 0)
                    ->pluck('catpartecuerpo_id');
            } else {
                $epp = DB::table('recsensorialequipopp')
                    ->where('recsensorial_id', $id)
                    ->whereIn('recsensorialcategoria_id', $categorias)
                    ->pluck('catpartecuerpo_id');

                if ($epp->count() == 0) {
                    $epp = DB::table('recsensorialequipopp')
                        ->where('recsensorial_id', $id)
                        ->where('recsensorialcategoria_id', 0)
                        ->pluck('catpartecuerpo_id');
                }
            }

            $sql42[$area->id] = $epp->unique()->toArray();
        }



        $columna = 'E';

        foreach ($sql41 as $area) {
            if (isset($sql42[$area->id])) {
                $partes = $sql42[$area->id];

                $otros = false;

                foreach ($partes as $parte) {
                    switch ($parte) {
                        case 7:
                            $sheet4->setCellValue($columna . '55', 'X');
                            break;

                        case 1:
                            $sheet4->setCellValue($columna . '57', 'X');
                            break;

                        case 2:
                            $sheet4->setCellValue($columna . '59', 'X');
                            break;

                        case 5:
                            $sheet4->setCellValue($columna . '61', 'X');
                            break;

                        case 6:
                            $sheet4->setCellValue($columna . '63', 'X');
                            break;

                        case 4:
                            $sheet4->setCellValue($columna . '65', 'X');
                            break;

                        // Otros
                        case 8:
                            $sheet4->setCellValue($columna . '56', 'X');
                            $sheet4->setCellValue($columna . '58', 'X');
                            $sheet4->setCellValue($columna . '60', 'X');
                            $sheet4->setCellValue($columna . '62', 'X');
                            $sheet4->setCellValue($columna . '64', 'X');
                            $sheet4->setCellValue($columna . '66', 'X');
                            break;
                    }
                }
                if ($otros) {
                    $sheet4->setCellValue($columna . '56', 'X');
                    $sheet4->setCellValue($columna . '58', 'X');
                    $sheet4->setCellValue($columna . '60', 'X');
                    $sheet4->setCellValue($columna . '62', 'X');
                    $sheet4->setCellValue($columna . '64', 'X');
                    $sheet4->setCellValue($columna . '66', 'X');
                }
            }

            $columna++;
        }



        $nombreArchivo = 'Validación reconocimiento - ' . $instalacion . '.xlsx';

        $rutaTemp = storage_path('app/temp');

        if (!file_exists($rutaTemp)) {
            mkdir($rutaTemp, 0777, true);
        }

        $archivoTemporal = $rutaTemp . '/' . $nombreArchivo;

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($archivoTemporal);

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return response()->download($archivoTemporal)->deleteFileAfterSend(true);
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


                if (($request->recsensorial_alcancefisico + 0) == 0) {
                   
                }

                if (($request->recsensorial_alcancequimico + 0) == 0) {
                }


                if (($request->recsensorial_id + 0) == 0) //nuevo
                {

                    // print_r($request->all());
                    // exit();
                    $recquimico = 0;


                    // AUTO_INCREMENT
                    DB::statement('ALTER TABLE recsensorial AUTO_INCREMENT=1');

                    // Folios siguientes
                    $folio = DB::select('SELECT
                                            (COUNT(IF(recsensorial.recsensorial_alcancefisico = 1, 1, NULL)) + 1) AS folio_fisicocompleto,
                                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 1, 1, NULL)) + 1) AS folio_quimicocompleto,
                                            (COUNT(IF(recsensorial.recsensorial_alcancefisico = 2, 1, NULL)) + 1) AS folio_fisicoincompleto,
                                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 2, 1, NULL)) + 1) AS folio_quimicoincompleto,
                                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 3, 1, NULL)) + 1) AS folio_quimicotercero

                                        FROM
                                            recsensorial
                                        WHERE
                                            DATE_FORMAT(recsensorial.created_at, "%Y") = DATE_FORMAT(CURDATE(), "%Y") AND recsensorial.recsensorial_eliminado = 0');

                    // Validar si envía Reconocimiento de fisicos
                    $foliofisico = "";
                    if (($request['recsensorial_alcancefisico'] + 0) > 0) {
                        if (($request['recsensorial_alcancefisico'] + 0) == 1) //reconocimiento de fisicos COMPLETO
                        {
                            switch ($folio[0]->folio_fisicocompleto) {
                                case ($folio[0]->folio_fisicocompleto < 10):
                                    $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicocompleto;
                                    break;
                                case ($folio[0]->folio_fisicocompleto < 100):
                                    $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicocompleto;
                                    break;
                                default:
                                    $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicocompleto;
                                    break;
                            }
                        } else //reconocimiento de fisicos INCOMPLETO
                        {
                            switch ($folio[0]->folio_fisicoincompleto) {
                                case ($folio[0]->folio_fisicoincompleto < 10):
                                    $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicoincompleto;
                                    break;
                                case ($folio[0]->folio_fisicoincompleto < 100):
                                    $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicoincompleto;
                                    break;
                                default:
                                    $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicoincompleto;
                                    break;
                            }
                        }

                        // Asignar folio
                        $request['recsensorial_foliofisico'] = $foliofisico;
                    }

                    // Validar si envía Reconocimiento de Quimicos
                    $folioquimico = "";
                    if (($request['recsensorial_alcancequimico'] + 0) > 0) {
                        if (($request['recsensorial_alcancequimico'] + 0) == 1) //reconocimiento de Quimicos COMPLETO
                        {
                            switch ($folio[0]->folio_quimicocompleto) {
                                case ($folio[0]->folio_quimicocompleto < 10):
                                    $folioquimico = "RES-RQ-" . $ano . "-00" . $folio[0]->folio_quimicocompleto;
                                    break;
                                case ($folio[0]->folio_quimicocompleto < 100):
                                    $folioquimico = "RES-RQ-" . $ano . "-0" . $folio[0]->folio_quimicocompleto;
                                    break;
                                default:
                                    $folioquimico = "RES-RQ-" . $ano . "-" . $folio[0]->folio_quimicocompleto;
                                    break;
                            }
                        } else if (($request['recsensorial_alcancequimico'] + 0) == 2) { //Reconocimiento puntos proporcionado por el cliente
                            switch ($folio[0]->folio_quimicoincompleto) {
                                case ($folio[0]->folio_quimicoincompleto < 10):
                                    $folioquimico = "RES-RQI-" . $ano . "-00" . $folio[0]->folio_quimicoincompleto;
                                    break;
                                case ($folio[0]->folio_quimicoincompleto < 100):
                                    $folioquimico = "RES-RQI-" . $ano . "-0" . $folio[0]->folio_quimicoincompleto;
                                    break;
                                default:
                                    $folioquimico = "RES-RQI-" . $ano . "-" . $folio[0]->folio_quimicoincompleto;
                                    break;
                            }
                        } else { // Reconocimiento quimico proporcionado por un tercero 
                            switch ($folio[0]->folio_quimicotercero) {
                                case ($folio[0]->folio_quimicotercero < 10):
                                    $folioquimico = "RES-RQT-" . $ano . "-00" . $folio[0]->folio_quimicotercero;
                                    break;
                                case ($folio[0]->folio_quimicotercero < 100):
                                    $folioquimico = "RES-RQT-" . $ano . "-0" . $folio[0]->folio_quimicotercero;
                                    break;
                                default:
                                    $folioquimico = "RES-RQT-" . $ano . "-" . $folio[0]->folio_quimicotercero;
                                    break;
                            }
                        }

                        // Asignar folio
                        $request['recsensorial_folioquimico'] = $folioquimico;
                    }

                    $recquimico = $request['recsensorial_alcancequimico'] == 0 ? 0 : 1;


                    // checkbox validacion químicos
                    if ($request->recsensorial_quimicovalidado != null) {
                        $request['recsensorial_quimicovalidado'] = 1;

                        // formatear fecha
                        // $request->recsensorial_quimicofechavalidacion = Carbon::createFromFormat('d-m-Y', $request->recsensorial_quimicofechavalidacion)->format('Y-m-d');
                    } else {
                        $request['recsensorial_quimicovalidado'] = 0;
                        $request['recsensorial_quimicofechavalidacion'] = null;
                        $request['recsensorial_quimicopersonavalida'] = null;
                        $request['recsensorial_pdfvalidaquimicos'] = null;
                    }

                    //Verificamos si el reconocimiento requiere contrato de no requerir autorizado lo ponemos como 0 para que deba ser autorizado
                    if (intval($request->requiere_contrato) == 1) {
                        $request['autorizado'] = 1;
                        $request['recsensorial_bloqueado'] = 0;
                    } else {
                        $request['recsensorial_bloqueado'] = 1;
                        $request['autorizado'] = 0;
                        $request['contrato_id'] = 0;
                    }

                    $request['recsensorial_fisicosimprimirbloqueado'] = 0;
                    $request['recsensorial_quimicosimprimirbloqueado'] = 0;
                    $request['recsensorial_bloqueado'] = 0;

                    $request['recsensorial_eliminado'] = 0;
                    $request['json_personas_elaboran'] = $request->JSON_PERSONAS_ELABORAN;
                    $recsensorial = recsensorialModel::create($request->all());
                    // $recsensorial->recsensorialpruebas()->sync($request->parametro); // SE COMENTO PORQUE YA SON DOS ARREGLOS DE PRUEBAS ENTONCES SI HIZO APARTE


                    //Guardamos la prueba de quimico si es que se necesita un reconocimiento en quimico
                    if ($recquimico == 1) {
                        $guardar_pruebas = recsensorialpruebasModel::create([
                            'recsensorial_id' => $recsensorial->id,
                            'catprueba_id' => 15,
                            'cantidad' => 0,
                        ]);
                    }

                    //Guardamos las pruebas del reconocimiento sensorial
                    if ($request->JSON_PRUEBAS && !empty($request->JSON_PRUEBAS)) {
                        $pruebas = json_decode($request->JSON_PRUEBAS, true);
                        foreach ($pruebas as $prueba) {

                            $guardar_pruebas = recsensorialpruebasModel::create([
                                'recsensorial_id' => $recsensorial->id,
                                'catprueba_id' => $prueba['catprueba_id'],
                                'cantidad' => $prueba['cantidad'],
                            ]);
                        }
                    }

                    //Guardamos las sustancias quimicas
                    if ($request->JSON_SUSTANCIAS && !empty($request->JSON_SUSTANCIAS)) {
                        $sustancias = json_decode($request->JSON_SUSTANCIAS, true);
                        foreach ($sustancias as $sustancia) {

                            $guardar_sustancias = recsensorialSustanciasModel::create([
                                'RECSENSORIAL_ID' => $recsensorial->id,
                                'SUSTANCIA_QUIMICA_ID' => $sustancia['SUSTANCIA_QUIMICA_ID'],
                                'CANTIDAD' => $sustancia['CANTIDAD'],
                            ]);
                        }
                    }


                    //UNA VEZ GUARDADO TODO LO DE RECONOCIMIENTO PROCEDEMOS A VINCULAR EL  ID DEL RECONOCIMIENTO CON EL PROYECTO
                    $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                    $proyecto->recsensorial_id = $recsensorial->id;
                    $proyecto->save();


                    // mensaje
                    $dato["msj"] = 'Información guardada correctamente y vinculado con el proyecto: ' . $request["proyecto_folio"];
                    $recsensorial_activo = 1;
                } else { //EDITAR 

                    // // Obtener registro
                    // $recsensorial = recsensorialModel::findOrFail($request->recsensorial_id);

                    // // consultar ID ultimo registro de la tabla
                    // $recsensorial_idmax = DB::select('SELECT
                    //                                         MAX( recsensorial.id ) AS recsensorial_idmax
                    //                                     FROM
                    //                                         recsensorial
                    //                                     WHERE
                    //                                         recsensorial.recsensorial_eliminado = 0');

                    // // Validar que sea el ultimo ID, y permita editar folios
                    // if (($recsensorial_idmax[0]->recsensorial_idmax + 0) === ($request->recsensorial_id + 0)) {
                    //     // En caso de ser el ultimo rsgistro de la base de datos, consultar modificar folios
                    //     $folio = DB::select('SELECT
                    //                             (COUNT(IF(recsensorial.recsensorial_alcancefisico = 1, 1, NULL)) + 1) AS folio_fisicocompleto,
                    //                             (COUNT(IF(recsensorial.recsensorial_alcancequimico = 1, 1, NULL)) + 1) AS folio_quimicocompleto,
                    //                             (COUNT(IF(recsensorial.recsensorial_alcancefisico = 2, 1, NULL)) + 1) AS folio_fisicoincompleto,
                    //                             (COUNT(IF(recsensorial.recsensorial_alcancequimico = 2, 1, NULL)) + 1) AS folio_quimicoincompleto
                    //                         FROM
                    //                             recsensorial
                    //                         WHERE
                    //                             DATE_FORMAT(recsensorial.created_at, "%Y") = DATE_FORMAT(CURDATE(), "%Y") 
                    //                             AND recsensorial.id != ' . ($request->recsensorial_id + 0) . '
                    //                             AND recsensorial.recsensorial_eliminado = 0');

                    //     // Validar si envía Reconocimiento de fisicos
                    //     $foliofisico = "";
                    //     if (($request['recsensorial_alcancefisico'] + 0) > 0) {
                    //         if (($request['recsensorial_alcancefisico'] + 0) == 1) //reconocimiento de fisicos COMPLETO
                    //         {
                    //             switch ($folio[0]->folio_fisicocompleto) {
                    //                 case ($folio[0]->folio_fisicocompleto < 10):
                    //                     $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicocompleto;
                    //                     break;
                    //                 case ($folio[0]->folio_fisicocompleto < 100):
                    //                     $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicocompleto;
                    //                     break;
                    //                 default:
                    //                     $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicocompleto;
                    //                     break;
                    //             }
                    //         } else //reconocimiento de fisicos INCOMPLETO
                    //         {
                    //             switch ($folio[0]->folio_fisicoincompleto) {
                    //                 case ($folio[0]->folio_fisicoincompleto < 10):
                    //                     $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicoincompleto;
                    //                     break;
                    //                 case ($folio[0]->folio_fisicoincompleto < 100):
                    //                     $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicoincompleto;
                    //                     break;
                    //                 default:
                    //                     $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicoincompleto;
                    //                     break;
                    //             }
                    //         }

                    //         // Asignar folio
                    //         $request['recsensorial_foliofisico'] = $foliofisico;
                    //     } else {
                    //         // Asignar folio
                    //         $request['recsensorial_foliofisico'] = NULL;
                    //     }

                    //     // Validar si envía Reconocimiento de Quimicos
                    //     $folioquimico = "";
                    //     if (($request['recsensorial_alcancequimico'] + 0) > 0) {
                    //         if (($request['recsensorial_alcancequimico'] + 0) == 1) //reconocimiento de Quimicos COMPLETO
                    //         {
                    //             switch ($folio[0]->folio_quimicocompleto) {
                    //                 case ($folio[0]->folio_quimicocompleto < 10):
                    //                     $folioquimico = "RES-RQ-" . $ano . "-00" . $folio[0]->folio_quimicocompleto;
                    //                     break;
                    //                 case ($folio[0]->folio_quimicocompleto < 100):
                    //                     $folioquimico = "RES-RQ-" . $ano . "-0" . $folio[0]->folio_quimicocompleto;
                    //                     break;
                    //                 default:
                    //                     $folioquimico = "RES-RQ-" . $ano . "-" . $folio[0]->folio_quimicocompleto;
                    //                     break;
                    //             }
                    //         } else //reconocimiento de Quimicos INCOMPLETO
                    //         {
                    //             switch ($folio[0]->folio_quimicoincompleto) {
                    //                 case ($folio[0]->folio_quimicoincompleto < 10):
                    //                     $folioquimico = "RES-RQ-" . $ano . "-00" . $folio[0]->folio_quimicoincompleto;
                    //                     break;
                    //                 case ($folio[0]->folio_quimicoincompleto < 100):
                    //                     $folioquimico = "RES-RQ-" . $ano . "-0" . $folio[0]->folio_quimicoincompleto;
                    //                     break;
                    //                 default:
                    //                     $folioquimico = "RES-RQ-" . $ano . "-" . $folio[0]->folio_quimicoincompleto;
                    //                     break;
                    //             }
                    //         }

                    //         // Asignar folio
                    //         $request['recsensorial_folioquimico'] = $folioquimico;
                    //     } else {
                    //         // Asignar folio
                    //         $request['recsensorial_folioquimico'] = NULL;
                    //     }
                    // } else {
                    //     $request['recsensorial_alcancefisico'] = $recsensorial->recsensorial_alcancefisico;
                    //     $request['recsensorial_alcancequimico'] = $recsensorial->recsensorial_alcancequimico;
                    // }


                    // Obtener registro
                    $recsensorial = recsensorialModel::findOrFail($request->recsensorial_id);


                    // Consultar folios existentes (excluyendo el registro actual)
                    $folio = DB::select('SELECT
                            (COUNT(IF(recsensorial.recsensorial_alcancefisico = 1, 1, NULL)) + 1) AS folio_fisicocompleto,
                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 1, 1, NULL)) + 1) AS folio_quimicocompleto,
                            (COUNT(IF(recsensorial.recsensorial_alcancefisico = 2, 1, NULL)) + 1) AS folio_fisicoincompleto,
                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 2, 1, NULL)) + 1) AS folio_quimicoincompleto,
                            (COUNT(IF(recsensorial.recsensorial_alcancequimico = 3, 1, NULL)) + 1) AS folio_quimicotercero
                    FROM
                            recsensorial
                    WHERE
                            DATE_FORMAT(recsensorial.created_at, "%Y") = DATE_FORMAT(CURDATE(), "%Y")
                            AND recsensorial.id != ' . ($request->recsensorial_id + 0) . '
                            AND recsensorial.recsensorial_eliminado = 0');


                    // ===================== FISICOS =====================
                    if (($request['recsensorial_alcancefisico'] + 0) > 0) {
                        // Si ya tiene folio se conserva
                        if ($recsensorial->recsensorial_foliofisico) {
                            $request['recsensorial_foliofisico'] = $recsensorial->recsensorial_foliofisico;
                        } else {
                            // Se genera uno nuevo
                            if (($request['recsensorial_alcancefisico'] + 0) == 1) {
                                switch ($folio[0]->folio_fisicocompleto) {
                                    case ($folio[0]->folio_fisicocompleto < 10):
                                        $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicocompleto;
                                        break;

                                    case ($folio[0]->folio_fisicocompleto < 100):
                                        $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicocompleto;
                                        break;

                                    default:
                                        $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicocompleto;
                                        break;
                                }
                            } else {
                                switch ($folio[0]->folio_fisicoincompleto) {
                                    case ($folio[0]->folio_fisicoincompleto < 10):
                                        $foliofisico = "RES-RS-" . $ano . "-00" . $folio[0]->folio_fisicoincompleto;
                                        break;

                                    case ($folio[0]->folio_fisicoincompleto < 100):
                                        $foliofisico = "RES-RS-" . $ano . "-0" . $folio[0]->folio_fisicoincompleto;
                                        break;

                                    default:
                                        $foliofisico = "RES-RS-" . $ano . "-" . $folio[0]->folio_fisicoincompleto;
                                        break;
                                }
                            }

                            $request['recsensorial_foliofisico'] = $foliofisico;
                        }
                    } else {
                        $request['recsensorial_foliofisico'] = null;
                    }


                    // ===================== QUIMICOS =====================
                    if (($request['recsensorial_alcancequimico'] + 0) > 0) {
                        // Si ya tiene folio se conserva
                        if ($recsensorial->recsensorial_folioquimico) {
                            $request['recsensorial_folioquimico'] = $recsensorial->recsensorial_folioquimico;
                        } else {
                            if (($request['recsensorial_alcancequimico'] + 0) == 1) {
                                switch ($folio[0]->folio_quimicocompleto) {
                                    case ($folio[0]->folio_quimicocompleto < 10):
                                        $folioquimico = "RES-RQ-" . $ano . "-00" . $folio[0]->folio_quimicocompleto;
                                        break;

                                    case ($folio[0]->folio_quimicocompleto < 100):
                                        $folioquimico = "RES-RQ-" . $ano . "-0" . $folio[0]->folio_quimicocompleto;
                                        break;

                                    default:
                                        $folioquimico = "RES-RQ-" . $ano . "-" . $folio[0]->folio_quimicocompleto;
                                        break;
                                }
                            }

                            $request['recsensorial_folioquimico'] = $folioquimico;
                        }
                    } else {
                        $request['recsensorial_folioquimico'] = null;
                    }
                    
                    // checkbox validacion químicos
                    if ($request->recsensorial_quimicovalidado != null) {
                        $request['recsensorial_quimicovalidado'] = 1;

                        // formatear fecha
                        // $request->recsensorial_quimicofechavalidacion = Carbon::createFromFormat('d-m-Y', $request->recsensorial_quimicofechavalidacion)->format('Y-m-d');
                    } else {
                        if ($recsensorial->recsensorial_pdfvalidaquimicos) {
                            $request['recsensorial_quimicovalidado'] = 1;
                        }
                    }



                    $request['json_personas_elaboran'] = $request->JSON_PERSONAS_ELABORAN;
                    $recsensorial->update($request->all());
                    // $recsensorial->recsensorialpruebas()->sync($request->parametro);


                    //Eliminamos las pruebas que ya tenian anteriormente
                    $eliminar_sustancias = recsensorialpruebasModel::where('recsensorial_id', $request["recsensorial_id"])->delete();

                    //Actualizamos las pruebas del reconocimiento sensorial
                    if ($request->JSON_PRUEBAS && !empty($request->JSON_PRUEBAS)) {

                        $pruebas = json_decode($request->JSON_PRUEBAS, true);
                        foreach ($pruebas as $prueba) {

                            $guardar_pruebas = recsensorialpruebasModel::create([
                                'recsensorial_id' => $recsensorial->id,
                                'catprueba_id' => $prueba['catprueba_id'],
                                'cantidad' => $prueba['cantidad'],
                            ]);
                        }
                    }


                    $recquimico = $request['recsensorial_alcancequimico'] == 0 ? 0 : 1;
                    if ($recquimico == 1) {
                        $guardar_pruebas = recsensorialpruebasModel::create([
                            'recsensorial_id' => $recsensorial->id,
                            'catprueba_id' => 15,
                            'cantidad' => 0,
                        ]);
                    }

                    //Eliminamos las sustancias que ya tenian anteriormente
                    $eliminar_sustancias = recsensorialSustanciasModel::where('RECSENSORIAL_ID', $request["recsensorial_id"])->delete();

                    //Actualizamos las sustancias quimicas
                    if ($request->JSON_SUSTANCIAS && !empty($request->JSON_SUSTANCIAS)) {

                        $sustancias = json_decode($request->JSON_SUSTANCIAS, true);
                        foreach ($sustancias as $sustancia) {

                            $guardar_sustancias = recsensorialSustanciasModel::create([
                                'RECSENSORIAL_ID' => $recsensorial->id,
                                'SUSTANCIA_QUIMICA_ID' => $sustancia['SUSTANCIA_QUIMICA_ID'],
                                'CANTIDAD' => $sustancia['CANTIDAD'],
                            ]);
                        }
                    }


                  

                    ///VERIFICAMOS QUE EL FOLIO DEL PROYECTO QUE ENVIA SEA EL MISMO
                    if ($recsensorial->proyecto_folio == $request['proyecto_folio']) {

                        $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                        $proyecto->recsensorial_id = $recsensorial->id;
                        $proyecto->save();
                    } else {


                        $proyecto = proyectoModel::where('proyecto_folio', $recsensorial->proyecto_folio)->first();
                        $proyecto->recsensorial_id = null;
                        $proyecto->save();


                        $proyecto = proyectoModel::where('proyecto_folio', $request["proyecto_folio"])->first();
                        $proyecto->recsensorial_id = $recsensorial->id;
                        $proyecto->save();
                    }






                    // mensaje
                    $dato["msj"] = 'Información modificada correctamente';
                }

                // si envia archivo FOTO ubicacion
                if ($request->file('inputfotomapa')) {
                    $extension = $request->file('inputfotomapa')->getClientOriginalExtension();
                    $request['recsensorial_fotoubicacion'] = $request->file('inputfotomapa')->storeAs('recsensorial/' . $recsensorial->id . '/mapa', $recsensorial->id . '.' . $extension);
                    $recsensorial->update($request->all());
                }

                // si envia archivo FOTO plano
                if ($request->file('inputfotoplano')) {
                    $extension = $request->file('inputfotoplano')->getClientOriginalExtension();
                    $request['recsensorial_fotoplano'] = $request->file('inputfotoplano')->storeAs('recsensorial/' . $recsensorial->id . '/plano', $recsensorial->id . '.' . $extension);
                    $recsensorial->update($request->all());
                }

                // si envia archivo FOTO instalacion
                if ($request->file('inputfotoinstalacion')) {
                    $extension = $request->file('inputfotoinstalacion')->getClientOriginalExtension();
                    $request['recsensorial_fotoinstalacion'] = $request->file('inputfotoinstalacion')->storeAs('recsensorial/' . $recsensorial->id . '/instalacion', $recsensorial->id . '.' . $extension);
                    $recsensorial->update($request->all());
                }

                // si envia archivo validacion de quimicos
                if ($request->file('pdfvalidaquimicos')) {
                    $extension = $request->file('pdfvalidaquimicos')->getClientOriginalExtension();
                    $request['recsensorial_pdfvalidaquimicos'] = $request->file('pdfvalidaquimicos')->storeAs('recsensorial/' . $recsensorial->id . '/pdfvalidaquimicos', 'validacion_quimicos.' . $extension);
                    $recsensorial->update($request->all());
                }
                // si el informe es proporcionado por el cliente
                if ($request->file('documentocliente')) {
                    $extension = $request->file('documentocliente')->getClientOriginalExtension();
                    $request['recsensorial_documentocliente'] = $request->file('documentocliente')->storeAs('recsensorial/' . $recsensorial->id . '/informecliente', 'informe_proporcionado.' . $extension);
                    $recsensorial->update($request->all());
                }

                // si el informe es proporcionado por el cliente pero es el documento de validacion


                if ($request->file('documentoclientevalidacion')) {
                    $extension = $request->file('documentoclientevalidacion')->getClientOriginalExtension();
                    $request['recsensorial_documentoclientevalidacion'] = $request->file('documentoclientevalidacion')->storeAs('recsensorial/' . $recsensorial->id . '/informecliente', 'informe_proporcionado_validacion.' . $extension);
                    $recsensorial->update($request->all());
                }

                // respuesta
                $dato['recsensorial_activo'] = $recsensorial_activo;
                $dato['recsensorial'] = $recsensorial;
            }


            if (($request->opcion + 0) == 2) // PDF AUTORIZADOS (RESULTADOS RECONOCIMIENTOS)
            {
                $recsensorial = recsensorialModel::findOrFail($request->recsensorial_id);

                if (($request->documento_pdf + 0) == 1) //FISICOS
                {
                    if ($request->file('reconocimientofisicospdf')) {
                        $extension = $request->file('reconocimientofisicospdf')->getClientOriginalExtension();
                        $recsensorial_reconocimientofisicospdf = $request->file('reconocimientofisicospdf')->storeAs('recsensorial/' . $recsensorial->id . '/reconocimientofisicospdf', 'Rec. de fisicos autorizado ' . $recsensorial->recsensorial_foliofisico . '.' . $extension);

                        $recsensorial->update([
                            'recsensorial_reconocimientofisicospdf' => $recsensorial_reconocimientofisicospdf
                        ]);
                    }
                } else {
                    if ($request->file('reconocimientoquimicospdf')) {
                        $extension = $request->file('reconocimientoquimicospdf')->getClientOriginalExtension();
                        $reconocimientoquimicospdf = $request->file('reconocimientoquimicospdf')->storeAs('recsensorial/' . $recsensorial->id . '/reconocimientoquimicospdf', 'Rec. de quimicos autorizado ' . $recsensorial->recsensorial_folioquimico . '.' . $extension);

                        $recsensorial->update([
                            'recsensorial_reconocimientoquimicospdf' => $reconocimientoquimicospdf
                        ]);
                    }
                }

                // mensaje
                $dato["recsensorial_bloqueado"] = $recsensorial->recsensorial_bloqueado;
                $dato["msj"] = 'Documento guardado correctamente';
            }


            // if (($request->opcion + 0) == 3) // RESPONSABLES DEL RECONOCIMIENTO
            // {
            //     // dd($request->all());

            //     $recsensorial = recsensorialModel::findOrFail($request->recsensorial_id);

            //     // dd($recsensorial->all());

            //     if ($request->recsensorial_repfisicos1nombre) // RESPONSABLES DEL RECONOCIMIENTO DE FISICOS
            //     {
            //         if ($request->file('fisicosresponsabletecnico')) {
            //             $extension = $request->file('fisicosresponsabletecnico')->getClientOriginalExtension();
            //             $request['recsensorial_repfisicos1doc'] = $request->file('fisicosresponsabletecnico')->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_fisicos', 'rep_tecnico.' . $extension);
            //         }

            //         if ($request->file('fisicosresponsableadministrativo')) {
            //             $extension = $request->file('fisicosresponsableadministrativo')->getClientOriginalExtension();
            //             $request['recsensorial_repfisicos2doc'] = $request->file('fisicosresponsableadministrativo')->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_fisicos', 'rep_admin.' . $extension);
            //         }
            //     } else {
            //         // Eliminar carpeta si acaso existio
            //         Storage::deleteDirectory('recsensorial/' . $request->recsensorial_id . '/responsables/rec_fisicos');

            //         $request['recsensorial_repfisicos1nombre'] = NULL;
            //         $request['recsensorial_repfisicos1cargo'] = NULL;
            //         $request['recsensorial_repfisicos1doc'] = NULL;
            //         $request['recsensorial_repfisicos2nombre'] = NULL;
            //         $request['recsensorial_repfisicos2cargo'] = NULL;
            //         $request['recsensorial_repfisicos2doc'] = NULL;
            //     }


            //     if ($request->recsensorial_repquimicos1nombre) // RESPONSABLES DEL RECONOCIMIENTO DE QUIMICOS
            //     {
            //         if ($request->file('quimicosresponsabletecnico')) {
            //             $extension = $request->file('quimicosresponsabletecnico')->getClientOriginalExtension();
            //             $request['recsensorial_repquimicos1doc'] = $request->file('quimicosresponsabletecnico')->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_quimicos', 'rep_tecnico.' . $extension);
            //         }

            //         if ($request->file('quimicosresponsableadministrativo')) {
            //             $extension = $request->file('quimicosresponsableadministrativo')->getClientOriginalExtension();
            //             $request['recsensorial_repquimicos2doc'] = $request->file('quimicosresponsableadministrativo')->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_quimicos', 'rep_admin.' . $extension);
            //         }
            //     } else {
            //         // Eliminar carpeta si acaso existio
            //         Storage::deleteDirectory('recsensorial/' . $request->recsensorial_id . '/responsables/rec_quimicos');

            //         $request['recsensorial_repquimicos1nombre'] = NULL;
            //         $request['recsensorial_repquimicos1cargo'] = NULL;
            //         $request['recsensorial_repquimicos1doc'] = NULL;
            //         $request['recsensorial_repquimicos2nombre'] = NULL;
            //         $request['recsensorial_repquimicos2cargo'] = NULL;
            //         $request['recsensorial_repquimicos2doc'] = NULL;
            //     }

            //     $recsensorial->update($request->all());

            //     // respuesta
            //     $dato["msj"] = 'Datos de los responsables guardado correctamente';
            //     $dato['recsensorial'] = $recsensorial;
            // }



            if (($request->opcion + 0) == 3) 
            {
                $recsensorial = recsensorialModel::findOrFail($request->recsensorial_id);

                // ========================== RESPONSABLES FÍSICOS ==========================
                if ($request->recsensorial_repfisicos1nombre) {
                    // Subir documento técnico
                    if ($request->file('fisicosresponsabletecnico')) {
                        $extension = $request->file('fisicosresponsabletecnico')->getClientOriginalExtension();
                        $request['recsensorial_repfisicos1doc'] =
                            $request->file('fisicosresponsabletecnico')
                            ->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_fisicos', 'rep_tecnico.' . $extension);
                    }

                    // Subir documento administrativo
                    if ($request->file('fisicosresponsableadministrativo')) {
                        $extension = $request->file('fisicosresponsableadministrativo')->getClientOriginalExtension();
                        $request['recsensorial_repfisicos2doc'] =
                            $request->file('fisicosresponsableadministrativo')
                            ->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_fisicos', 'rep_admin.' . $extension);
                    }
                } else {
                    unset(
                        $request['recsensorial_repfisicos1nombre'],
                        $request['recsensorial_repfisicos1cargo'],
                        $request['recsensorial_repfisicos1doc'],
                        $request['recsensorial_repfisicos2nombre'],
                        $request['recsensorial_repfisicos2cargo'],
                        $request['recsensorial_repfisicos2doc']
                    );
                }

                // ========================== RESPONSABLES QUÍMICOS ==========================
                if ($request->recsensorial_repquimicos1nombre) {
                    if ($request->file('quimicosresponsabletecnico')) {
                        $extension = $request->file('quimicosresponsabletecnico')->getClientOriginalExtension();
                        $request['recsensorial_repquimicos1doc'] =
                            $request->file('quimicosresponsabletecnico')
                            ->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_quimicos', 'rep_tecnico.' . $extension);
                    }

                    if ($request->file('quimicosresponsableadministrativo')) {
                        $extension = $request->file('quimicosresponsableadministrativo')->getClientOriginalExtension();
                        $request['recsensorial_repquimicos2doc'] =
                            $request->file('quimicosresponsableadministrativo')
                            ->storeAs('recsensorial/' . $request->recsensorial_id . '/responsables/rec_quimicos', 'rep_admin.' . $extension);
                    }
                } else {
                    unset(
                        $request['recsensorial_repquimicos1nombre'],
                        $request['recsensorial_repquimicos1cargo'],
                        $request['recsensorial_repquimicos1doc'],
                        $request['recsensorial_repquimicos2nombre'],
                        $request['recsensorial_repquimicos2cargo'],
                        $request['recsensorial_repquimicos2doc']
                    );
                }

                // ========================== GUARDADO FINAL ==========================
                $recsensorial->update($request->except(['_token', 'opcion']));

                $dato["msj"] = 'Datos de los responsables guardados correctamente';
                $dato['recsensorial'] = $recsensorial;
            }



            if (($request->opcion + 0) == 4) // FOTOS EVIDENCIA PARAMETROS
            {
                // dd($request->all());

                // // AUTO_INCREMENT
                // DB::statement('ALTER TABLE recsensorialevidencias AUTO_INCREMENT = 1;');


                if ($request->file('inputevidenciafoto')) {
                    $tipo = 'Foto';
                    if (($request->recsensorialevidencias_tipo + 0) == 2) // Tipo de archivo enviado
                    {
                        $tipo = 'Plano';
                    }

                    $request['cat_prueba_id'] = $request->parametro_id;

                    if (!$request->recsensorialarea_id) {
                        $request['recsensorialarea_id'] = 0; // Si es plano debe poner el Area_id = 0
                    }

                    $foto = recsensorialevidenciasModel::create($request->all());

                    // Codificar imagen recibida como tipo base64
                    $imagen_recibida = explode(',', $request->foto_base64); //Archivo foto tipo base64
                    $imagen_nueva = base64_decode($imagen_recibida[1]);

                    // // Ruta destino archivo
                    $destinoPath = 'recsensorial/' . $request->recsensorial_id . '/evidencias_campo/' . $request->parametro_nombre . '/' . $tipo . '_' . $foto->id . '.jpg';

                    // GUardar Foto
                    Storage::put($destinoPath, $imagen_nueva); // Guardar en storage
                    // file_put_contents(public_path('/imagen.jpg'), $imagen_nueva); // Guardar en public

                    // Actualizar ruta foto
                    $foto->update([
                        'recsensorialevidencias_foto' => $destinoPath
                    ]);

                    // Mensaje
                    $dato["msj"] = $tipo . ' guardado correctamente';
                } else {
                    // Mensaje
                    $dato["msj"] = 'No se realizó ninguna acción';
                }
            }


            if (($request->opcion + 0) == 5) // GUARDAR O ACTUALIZAR INFORMACION PARA EL INFORME
            {
                if (
                    $request['ID_RECURSO_INFORME'] == 0
                ) //nuevo
                {
                    // AUTO_INCREMENT
                    DB::statement('ALTER TABLE recsensorial_recursos_informes AUTO_INCREMENT=1;');
                    $documento = recsensorialRecursosInformesModel::create($request->all());
                    $idRecurso = $documento->ID_RECURSO_INFORME;

                    if ($request->file('PORTADA')) {

                        $request['IMAGEN_PORTADA'] = $request->file('PORTADA')->storeAs('recsensorial/' . $request['RECSENSORIAL_ID'] . '/recursosInforme', $request['RECSENSORIAL_ID'] . '.' . $request->file('PORTADA')->getClientOriginalExtension());


                        $documento->update($request->all());
                    }


                    return response()->json($documento);
                } else //editar
                {
                    $documento = recsensorialRecursosInformesModel::findOrFail($request['ID_RECURSO_INFORME']);


                    $request['PETICION_CLIENTE'] = isset($request['PETICION_CLIENTE']) ? $request['PETICION_CLIENTE'] : 0;
                    $request['AGREGAR_RECOMENDACION'] = isset($request['AGREGAR_RECOMENDACION']) ? $request['AGREGAR_RECOMENDACION'] : 0;
                    $request['REQUIERE_CONCLUSION'] = isset($request['REQUIERE_CONCLUSION']) ? $request['REQUIERE_CONCLUSION'] : 0;

                    //VERIFICAMOS LAS OPCIONES DE LA PORTADA
                    $request['OPCION_PORTADA1'] = isset($request['OPCION_PORTADA1']) ? $request['OPCION_PORTADA1'] : null;
                    $request['OPCION_PORTADA2'] = isset($request['OPCION_PORTADA2']) ? $request['OPCION_PORTADA2'] : null;
                    $request['OPCION_PORTADA3'] = isset($request['OPCION_PORTADA3']) ? $request['OPCION_PORTADA3'] : null;
                    $request['OPCION_PORTADA4'] = isset($request['OPCION_PORTADA4']) ? $request['OPCION_PORTADA4'] : null;
                    $request['OPCION_PORTADA5'] = isset($request['OPCION_PORTADA5']) ? $request['OPCION_PORTADA5'] : null;
                    $request['OPCION_PORTADA6'] = isset($request['OPCION_PORTADA6']) ? $request['OPCION_PORTADA6'] : null;


                    if ($request->file('PORTADA')) {

                        // Eliminar DOC anterior
                        if (Storage::exists($documento->IMAGEN_PORTADA)) {
                            Storage::delete($documento->IMAGEN_PORTADA);
                        }

                        $request['IMAGEN_PORTADA'] = $request->file('PORTADA')->storeAs('recsensorial/' . $request['RECSENSORIAL_ID'] . '/recursosInforme', $request['RECSENSORIAL_ID'] . '.' . $request->file('PORTADA')->getClientOriginalExtension());
                    }

                    $documento->update($request->all());
                    return response()->json($documento);
                }
            }

            if (($request->opcion + 0) == 6) // GUARDAR O ACTUALIZAR INFORMACION PARA EL LA TABLA DEL INFORME
            {

                if ($request->ID_GRUPO) {
                    foreach ($request->ID_GRUPO as $key => $value) {

                        $guardar_columnas = gruposDeExposicionModel::where('ID_GRUPO_EXPOSICION', $value)
                            ->update([
                                'PPT_VIEJO' => is_null($request->PPT_VIEJO[$key]) ? 0 : $request->PPT_VIEJO[$key],
                                'CT_VIEJO' => is_null($request->CT_VIEJO[$key]) ? 0 : $request->CT_VIEJO[$key],
                                'PUNTOS_VIEJO' => is_null($request->PUNTOS_VIEJO[$key]) ? 0 : $request->PUNTOS_VIEJO[$key],
                                'PUNTOS_NUEVO' => is_null($request->PUNTOS_NUEVO[$key]) ? 0 : $request->PUNTOS_NUEVO[$key],
                                'PPT_NUEVO' => is_null($request->PPT_NUEVO[$key]) ? 0 : $request->PPT_NUEVO[$key],
                                'CT_NUEVO' => is_null($request->CT_NUEVO[$key]) ? 0 : $request->CT_NUEVO[$key],
                                'JUSTIFICACION' => is_null($request->JUSTIFICACION[$key]) ? null : $request->JUSTIFICACION[$key]

                            ]);
                    }
                }

                $dato["msj"] = 'Información guardada con exito';
            }

            if (($request->opcion + 0) == 7) // GUARDAR O ACTUALIZAR INFORMACION PARA EL LA TABLA DEL INFORME DE LOS PUNTOS SOLICITADOS POR EL CLIENTE
            {
                if ($request['NUEVO'] == 1) //nuevo
                {
                    // AUTO_INCREMENT
                    DB::statement('ALTER TABLE recsensorial_tablaClientes_informes AUTO_INCREMENT=1;');


                    if ($request->CATEGORIA_ID) {
                        foreach ($request->CATEGORIA_ID as $key => $value) {

                            $guardar_columnas = recsensorialTablaClienteInformeModel::create([
                                'RECONOCIMIENTO_ID' => $request['RECONOCIMIENTO_ID'],
                                'CATEGORIA_ID' => $value,
                                'AREA_ID' => $request->AREA_ID[$key],
                                'SUSTANCIA_ID' => $request->SUSTANCIA_ID[$key],
                                'PPT' => $request->PPT[$key],
                                'CT' => $request->CT[$key],
                                'PUNTOS' => $request->PUNTOS[$key],
                            ]);
                        }
                    }

                    $dato["msj"] = 'Información guardada con exito';
                } else //editar
                {

                    $eliminar_columnas = recsensorialTablaClienteInformeModel::where('RECONOCIMIENTO_ID', $request["RECONOCIMIENTO_ID"])->delete();

                    if ($request->CATEGORIA_ID) {
                        foreach ($request->CATEGORIA_ID as $key => $value) {

                            $guardar_columnas = recsensorialTablaClienteInformeModel::create([
                                'RECONOCIMIENTO_ID' => $request['RECONOCIMIENTO_ID'],
                                'CATEGORIA_ID' => $value,
                                'AREA_ID' => $request->AREA_ID[$key],
                                'SUSTANCIA_ID' => $request->SUSTANCIA_ID[$key],
                                'PPT' => $request->PPT[$key],
                                'CT' => $request->CT[$key],
                                'PUNTOS' => $request->PUNTOS[$key],
                            ]);
                        }
                    }


                    $dato["msj"] = 'Información actualizada con exito';
                }
            }



            if (($request->opcion + 0) == 8) {
                $ultimoRegistro = controlCambiosModel::where('RECONOCIMIENTO_ID', $request['RECONOCIMIENTO_ID'])
                    ->orderByDesc('NUMERO_VERSIONES')
                    ->first();

                $numeroVersiones = $ultimoRegistro ? $ultimoRegistro->NUMERO_VERSIONES + 1 : 0;

                // Almacenar nombreInstalacion en la sesión
                session(['nombreInstalacion' => $request->input('nombreInstalacion', 'NombrePorDefecto')]);

                $data = [
                    'NUMERO_VERSIONES' => $numeroVersiones,
                    'DESCRIPCION_REALIZADO' => $ultimoRegistro ? '' : 'Documento inicial',
                    'AUTORIZADO' => 0,
                    'REALIZADO_ID' => Auth::user()->id,
                    'RECONOCIMIENTO_ID' => $request['RECONOCIMIENTO_ID'],
                    'CANCELADO_COMENTARIO' => $request['cambios_realizados']
                ];

                $zipController = new recsensorialquimicosreportewordController();
                $rutaZip = $zipController->recsensorialquimicosreporte1word($request['RECONOCIMIENTO_ID'], 2, $numeroVersiones, 0);

                $data['RUTA_ZIP'] = $rutaZip;

                $documento = controlCambiosModel::create($data);

                // Responder con éxito
                $dato["MSJ"] = 'BIEN';
                $dato["DOC"] = $documento;

                return response()->json($dato);
            }




            if (($request->opcion + 0) == 9) // GUARDAR O ACTUALIZAR INFORMACION PARA EL LA TABLA DEL INFORME DE LOS PUNTOS SOLICITADOS POR EL CLIENTE
            {
                if ($request['NUEVO'] == 1) //nuevo
                {
                    // AUTO_INCREMENT
                    DB::statement('ALTER TABLE recsensorial_tablaClientes_proporcionado AUTO_INCREMENT=1;');


                    if ($request->AREA_PROPORCIONADACLIENTE) {
                        foreach ($request->AREA_PROPORCIONADACLIENTE as $key => $value) {

                            $guardar_columnas = recsensorialTablaClienteProporcionadoModel::create([
                                'RECONOCIMIENTO_ID' => $request['RECONOCIMIENTO_ID'],
                                'AREA_PROPORCIONADACLIENTE' => $value,
                                'CATEGORIA_PROPORCIONADACLIENTE' => $request->CATEGORIA_PROPORCIONADACLIENTE[$key],
                                'PRODUCTO_PROPORCIONADACLIENTE' => $request->PRODUCTO_PROPORCIONADACLIENTE[$key],
                                'SUSTANCIA_ID' => $request->SUSTANCIA_ID[$key],
                                'PPT_PROPORCIONADACLIENTE' => $request->PPT_PROPORCIONADACLIENTE[$key],
                                'CT_PROPORCIONADACLIENTE' => $request->CT_PROPORCIONADACLIENTE[$key],
                                'PUNTOS_PROPORCIONADACLIENTE' => $request->PUNTOS_PROPORCIONADACLIENTE[$key],

                            ]);
                        }
                    }

                    $dato["msj"] = 'Información guardada con exito';
                } else //editar
                {

                    $eliminar_columnas = recsensorialTablaClienteProporcionadoModel::where('RECONOCIMIENTO_ID', $request["RECONOCIMIENTO_ID"])->delete();

                    if ($request->AREA_PROPORCIONADACLIENTE) {
                        foreach ($request->AREA_PROPORCIONADACLIENTE as $key => $value) {

                            $guardar_columnas = recsensorialTablaClienteProporcionadoModel::create([
                                'RECONOCIMIENTO_ID' => $request['RECONOCIMIENTO_ID'],
                                'AREA_PROPORCIONADACLIENTE' => $value,
                                'CATEGORIA_PROPORCIONADACLIENTE' => $request->CATEGORIA_PROPORCIONADACLIENTE[$key],
                                'PRODUCTO_PROPORCIONADACLIENTE' => $request->PRODUCTO_PROPORCIONADACLIENTE[$key],
                                'SUSTANCIA_ID' => $request->SUSTANCIA_ID[$key],
                                'PPT_PROPORCIONADACLIENTE' => $request->PPT_PROPORCIONADACLIENTE[$key],
                                'CT_PROPORCIONADACLIENTE' => $request->CT_PROPORCIONADACLIENTE[$key],
                                'PUNTOS_PROPORCIONADACLIENTE' => $request->PUNTOS_PROPORCIONADACLIENTE[$key],

                            ]);
                        }
                    }


                    $dato["msj"] = 'Información actualizada con exito';
                }
            }

            if (($request->opcion + 0) == 10) // GUARDAR RECOMENDACIONES PARA EL INFORME
            {
                $eliminar_columnas = recsensorialRecomendacionesModel::where('RECSENSORIAL_ID', $request["RECSENSORIAL_ID"])->delete();

                if ($request->RECOMENDACIONES) {
                    foreach ($request->RECOMENDACIONES as $key => $value) {

                        $guardar_columnas = recsensorialRecomendacionesModel::create([
                            'RECSENSORIAL_ID' => $request['RECSENSORIAL_ID'],
                            'RECOMENDACION_ID' => $value,
                        ]);
                    }
                }
                $dato["msj"] = 'Recomendaciones guardadas con exito';
            }
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['recsensorial'] = 0;
            $dato["recsensorial_bloqueado"] = 0;
            return response()->json($dato);
        }
    }
}

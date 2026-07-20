<?php

namespace App\Http\Controllers\PSICO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Mail\sendGuiaPsico;
use Illuminate\Support\Facades\Mail;
use Exception;

use App\modelos\reconocimientopsico\recopsicotrabajadoresModel;
use App\modelos\reconocimientopsico\recpsicofotostrabajadoresModel;
use App\modelos\proyecto\proyectoModel;

use App\modelos\reconocimientopsico\evidenciafotosModel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Crypt; // Importa el helper de encriptación
class ejecucionPsicoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalogos.psico.ejecucion_psicosocial');
    }

    public function tablaEjecucion()
    {

        $tabla = DB::select('SELECT p.id ID_PROYECTO,
                                    p.proyecto_folio FOLIO,
                                    p.proyecto_fechainicio AS FECHA_INICIO,
                                    p.proyecto_fechafin AS FECHA_FIN,
                                    IFNULL(p.reconocimiento_psico_id, 0) TIENE_RECONOCIMIENTO,
                                    p.proyecto_clienteinstalacion,
                                    p.proyecto_clientedireccionservicio
                            FROM proyecto p
                            LEFT JOIN reconocimientopsico r ON r.id = p.reconocimiento_psico_id  
                            LEFT JOIN serviciosProyecto s ON s.PROYECTO_ID = p.id
                            WHERE s.PSICO_EJECUCION = 1');


        $count = 0;
        foreach ($tabla as $key => $value) {
            $count += 1;

            $value->COUNT = $count;
            $value->instalacion_y_direccion = '<span style="color: #999999;">' . $value->proyecto_clienteinstalacion . '</span><br>' . $value->proyecto_clientedireccionservicio;

            if ($value->TIENE_RECONOCIMIENTO  != 0) {
                $value->boton_mostrar = '<button type="button" class="btn btn-info btn-circle mostrar" style="padding: 0px;"><i class="fa fa-eye fa-2x"></i></button>';
            } else {
                $value->RECONOCIMIENTO_VINCULADO = 'Sin vincular <br><i class="fa fa-ban text-danger"></i>';
                $value->boton_mostrar = '<button type="button" class="btn btn-secondary btn-circle" style="padding: 0px; border: 1px #999999 solid!important;" disabled><i class="fa fa-eye-slash fa-2x"></i></button>';
            }
        }

        $listado['data']  = $tabla;
        return response()->json($listado);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $proyecto_id
     * @return \Illuminate\Http\Response
     */



    public function trabajadoresOnlineEjecucionPsico($proyecto_id)
    {
        $tablaOnline = [];

        $existingRecords = DB::table('proyectotrabajadores')
            ->where('proyecto_id', $proyecto_id)
            ->exists();

        if ($existingRecords) {

            // TRAE LOS DATOS DE LA TABLA DE SEGUIMIENTO RELACIONADO CON LA DE PROGRAMA DE TRABAJO
            $tablaOnline = DB::select('SELECT
                                        p.TRABAJADOR_NOMBRE TRABAJADOR_NOMBRE,
                                        p.TRABAJADOR_ID TRABAJADOR_ID,
                                        p.TRABAJADOR_ESTADOCORREO ESTADOCORREO,
                                        p.TRABAJADOR_FECHAINICIO FECHAINICIO,
                                        p.TRABAJADOR_FECHAFIN FECHAFIN,
                                        p.TRABAJADOR_ESTADOCONTESTADO ESTADOCONTESTADO,
                                        r.RECPSICO_ID,
                                        r.RECPSICOTRABAJADOR_CORREO TRABAJADOR_CORREO
                                    FROM proyectotrabajadores p
                                    LEFT JOIN recopsicotrabajadores r
                                        ON p.TRABAJADOR_ID = r.ID_RECOPSICOTRABAJADOR
                                    WHERE p.TRABAJADOR_SELECCIONADO = 1
                                        AND p.TRABAJADOR_MODALIDAD = "Online"
                                        AND p.proyecto_id = ' . $proyecto_id);

            $count = 0;

            foreach ($tablaOnline as $key => $value) {

                $count += 1;

                $value->COUNT = $count;

                if ($value->ESTADOCORREO == 'Sin enviar') {
                    $value->TRABAJADOR_ESTADOCORREO =
                        '<span class="badge badge-pill badge-danger" style="font-size: 12px">'
                        . $value->ESTADOCORREO .
                        '</span>';
                } else if ($value->ESTADOCORREO == null) {
                    $value->TRABAJADOR_ESTADOCORREO =
                        '<span class="badge badge-pill badge-danger" style="font-size: 12px">Sin enviar</span>';
                } else {
                    $value->TRABAJADOR_ESTADOCORREO =
                        '<span class="badge badge-pill badge-verde" style="font-size: 12px">'
                        . $value->ESTADOCORREO .
                        '</span>';
                }

                $value->FECHAINICIO = $value->FECHAINICIO ?? '';
                $value->FECHAFIN = $value->FECHAFIN ?? '';
                $value->TRABAJADOR_ID = $value->TRABAJADOR_ID;
                $value->TRABAJADOR_NOMBRE = $value->TRABAJADOR_NOMBRE;

                if ($value->ESTADOCONTESTADO == 'Sin iniciar') {

                    $value->TRABAJADOR_ESTADOCONTESTADO =
                        '<span class="badge badge-pill badge-danger" style="font-size: 12px">'
                        . $value->ESTADOCONTESTADO .
                        '</span>';
                } else if ($value->ESTADOCONTESTADO == 'En proceso') {

                    $value->TRABAJADOR_ESTADOCONTESTADO =
                        '<span class="badge badge-pill badge-warning" style="font-size: 12px">'
                        . $value->ESTADOCONTESTADO .
                        '</span>';
                } else if ($value->ESTADOCONTESTADO == null) {

                    $value->TRABAJADOR_ESTADOCONTESTADO =
                        '<span class="badge badge-pill badge-danger" style="font-size: 12px">Sin iniciar</span>';
                } else {

                    $value->TRABAJADOR_ESTADOCONTESTADO =
                        '<span class="badge badge-pill badge-verde" style="font-size: 12px">'
                        . $value->ESTADOCONTESTADO .
                        '</span>';
                }

                $value->boton_enviarCorreo =
                    '<button type="button"
                    class="btn btn-warning btn-circle enviarcorreo"
                    id="enviarCorreoTrabajador' . $count . '"
                    name="enviarCorreoTrabajador"
                    onclick="enviarCorreo(' . $value->TRABAJADOR_ID . ', ' . $value->RECPSICO_ID . ')"
                    style="padding: 0px;">
                    <i class="fa fa-paper-plane"></i>
                </button>';

                $value->boton_guardarCambios =
                    '<button type="button"
                    class="btn btn-danger btn-circle guardarCambios"
                    id="guardarCambiosTrabajador' . $value->TRABAJADOR_ID . '"
                    name="guardarCambiosTrabajador"
                    onclick="guardarCambios(' . $value->TRABAJADOR_ID . ', ' . $value->RECPSICO_ID . ')"
                    style="padding: 0px;">
                    <i class="fa fa-save"></i>
                </button>';
            }
        }

        $online['data'] = $tablaOnline;

        return response()->json($online);
    }

         /**
     * Display the specified resource.
     *
     * @param  int  $proyecto_id
     * @return \Illuminate\Http\Response
     */
    public function trabajadoresPresencialEjecucionPsico($proyecto_id)
    {


        $tablaPresencial = DB::select('SELECT
                                        p.TRABAJADOR_NOMBRE NOMBRE,
                                        p.TRABAJADOR_ID TRABAJADOR_ID,
                                        p.TRABAJADOR_ESTADOCORREO ESTADOCORREO,
                                        p.TRABAJADOR_FECHAINICIO FECHAINICIO,
                                        p.TRABAJADOR_FECHAFIN FECHAFIN,
                                        p.TRABAJADOR_ESTADOCONTESTADO ESTADOCONTESTADO,
                                        r.RECPSICO_ID,
                                        r.RECPSICOTRABAJADOR_CORREO TRABAJADOR_CORREO
                                    FROM proyectotrabajadores p
                                    LEFT JOIN recopsicotrabajadores r
                                        ON p.TRABAJADOR_ID = r.ID_RECOPSICOTRABAJADOR
                                    WHERE p.TRABAJADOR_SELECCIONADO = 1
                                        AND p.TRABAJADOR_MODALIDAD = "Presencial"
                                        AND p.proyecto_id = ' . $proyecto_id);


        $count = 0;
        foreach ($tablaPresencial as $key => $value) {
            $count += 1;

            $value->COUNT = $count;
            $value->FECHAAPLICACION = '';
            $value->ESTADOCUESTIONARIO = 'En proceso';

            $value->BTN_EDITAR = '
                    <button type="button" class="btn btn-info btn-circle editar">
                       <i class="fa fa-check-circle"></i>
                    </button>';



        }

        $online['data']  = $tablaPresencial;
        return response()->json($online);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function trabajadoresNombres(Request $request)
     {
         $term = $request->input('term');
     
         $trabajadores = recopsicotrabajadoresModel::where('RECPSICOTRABAJADOR_NOMBRE', 'LIKE', '%' . $term . '%')
             ->where('RECPSICO_ID', 3)
             ->where('RECPSICOTRABAJADOR_MUESTRA', 1)
             ->select('ID_RECOPSICOTRABAJADOR', 'RECPSICOTRABAJADOR_NOMBRE') 
             ->get();
        
         return response()->json($trabajadores);
     }

          /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
     
    public function actualizarFechasOnline(Request $request)
    {
        try {
        $datosJson = $request->input('datos');
        $proyecto_id = $request->input('proyecto_id'); 

        $datos = json_decode($datosJson, true); 

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error al decodificar JSON: ' . json_last_error_msg()], 400);
        }
    
            $actualizarTablaOnline = DB::update('UPDATE proyectotrabajadores 
            SET TRABAJADOR_FECHAINICIO = ?, TRABAJADOR_FECHAFIN = ?
            WHERE proyecto_id = ? AND TRABAJADOR_MODALIDAD = ?', 
            [$request->fechaInicio, $request->fechaFin, $proyecto_id, 'Online']);

            $response["msj"] = 'Datos actualizados correctamente';
            return response()->json($response);
        } catch (Exception $e) {
            $response["msj"] = 'Error: ' . $e->getMessage();
            return response()->json($response);
        }

    }

             /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
     
     public function guardarCambiosTrabajador(Request $request)
     {
         try {
         $datosJson = $request->input('datos');
 
         $datos = json_decode($datosJson, true); 
 
         if (json_last_error() !== JSON_ERROR_NONE) {
             return response()->json(['error' => 'Error al decodificar JSON: ' . json_last_error_msg()], 400);
         }
     
             $actualizarFechasOnlineTrabajador = DB::update('UPDATE proyectotrabajadores 
             SET TRABAJADOR_FECHAINICIO = ?, TRABAJADOR_FECHAFIN = ?
             WHERE TRABAJADOR_ID = ?', 
             [$datos['fechaInicio'], $datos['fechaFin'], $datos['trabajadorId']]
            );

             $actualizarCorreoOnlineTrabajador = DB::update('UPDATE recopsicotrabajadores
             SET RECPSICOTRABAJADOR_CORREO = ?
             WHERE ID_RECOPSICOTRABAJADOR = ?', 
             [$datos['trabajadorCorreo'], $datos['trabajadorId']]
            );
 
            $response = ["msj" => 'Datos guardados correctamente'];
             return response()->json($response);
         } catch (Exception $e) {
            $response = ["msj" => 'Error: ' . $e->getMessage()];
            return response()->json($response);
         }
 
     }



    public function envioGuia($tipo, $idPersonal, $idRecsensorial)
    {
        try {

            //Validamos el tipo de envio
            if ($tipo == 1) { //-> Envio masivo


                // Obtener trabajadores Online del proyecto
                $trabajadores = DB::select('SELECT
                                t.ID_RECOPSICOTRABAJADOR,
                                t.RECPSICOTRABAJADOR_NOMBRE,
                                t.RECPSICOTRABAJADOR_CORREO,
                                p.TRABAJADOR_FECHAFIN,
                                p.TRABAJADOR_ESTADOCONTESTADO,
                                DATEDIFF(p.TRABAJADOR_FECHAFIN, DATE_FORMAT(NOW(),"%Y-%m-%d")) AS DIAS
                            FROM proyectotrabajadores p
                            INNER JOIN recopsicotrabajadores t
                                ON t.ID_RECOPSICOTRABAJADOR = p.TRABAJADOR_ID
                            WHERE p.proyecto_id = ?
                            AND p.TRABAJADOR_MODALIDAD = "Online"', [$idRecsensorial]);

                // Obtener información del reconocimiento asociado al proyecto
                $proyecto = DB::select('SELECT reconocimiento_psico_id
                        FROM proyecto
                        WHERE id = ?', [$idRecsensorial]);

                $reconocimiento_psico_id = $proyecto[0]->reconocimiento_psico_id;


                // Obtener guías
                $datos = DB::select('SELECT RECPSICO_GUIAI,
                            RECPSICO_GUIAII,
                            RECPSICO_GUIAIII,
                            RECPSICO_GUIAV
                    FROM recopsiconormativa
                    WHERE RECPSICO_ID = ?', [$reconocimiento_psico_id]);


                $guia1 = $datos[0]->RECPSICO_GUIAI;
                $guia2 = $datos[0]->RECPSICO_GUIAII;
                $guia3 = $datos[0]->RECPSICO_GUIAIII;
                $guia5 = $datos[0]->RECPSICO_GUIAV;


                // Obtener psicólogo asignado
                $psicoInfo = DB::select('SELECT IFNULL(s.signatario_Nombre, "NA") as info
                        FROM proyectosignatariosactual p
                        LEFT JOIN signatario s
                            ON s.id = p.signatario_id
                        WHERE p.proyecto_id = ?
                        LIMIT 1', [$idRecsensorial]);

                $psico = $psicoInfo[0]->info;

                // Recorrer trabajadores y enviar correos
                foreach ($trabajadores as $trabajador) {

                    // Encriptar datos
                    $encryptedGuia1 = Crypt::encrypt($guia1);
                    $encryptedGuia2 = Crypt::encrypt($guia2);
                    $encryptedGuia3 = Crypt::encrypt($guia3);
                    $encryptedGuia5 = Crypt::encrypt($guia5);

                    $encryptedfechalimite = Crypt::encrypt($trabajador->TRABAJADOR_FECHAFIN);
                    $encryptedstatus = Crypt::encrypt($trabajador->TRABAJADOR_ESTADOCONTESTADO);

                    $encryptedId = Crypt::encrypt($trabajador->ID_RECOPSICOTRABAJADOR);


                    // Enviar correo
                    Mail::to($trabajador->RECPSICOTRABAJADOR_CORREO)
                        ->send(
                            new sendGuiaPsico(
                                $trabajador->RECPSICOTRABAJADOR_NOMBRE,
                                $encryptedGuia1,
                                $encryptedGuia2,
                                $encryptedGuia3,
                                $encryptedGuia5,
                                $encryptedstatus,
                                $encryptedfechalimite,
                                $encryptedId,
                                $trabajador->DIAS,
                                $psico
                            )
                        );


                    // Actualizar estado del correo
                    DB::table('proyectotrabajadores')
                        ->where('TRABAJADOR_ID', $trabajador->ID_RECOPSICOTRABAJADOR)
                        ->where('proyecto_id', $idRecsensorial)
                        ->update([
                            'TRABAJADOR_ESTADOCORREO' => 'Enviado'
                        ]);
                }





            } 
            else { //-> Envio unico

                //Obtenemos los datos del trabajador segun el id
                $datos = DB::select('SELECT t.RECPSICOTRABAJADOR_NOMBRE,
                                            t.RECPSICOTRABAJADOR_CORREO,
                                            s.TRABAJADOR_FECHAFIN,
                                            s.TRABAJADOR_ESTADOCONTESTADO,
                                            DATEDIFF(s.TRABAJADOR_FECHAFIN, DATE_FORMAT(NOW(),"%Y-%m-%d")) AS DIAS
                                FROM recopsicotrabajadores t
                                LEFT JOIN proyectotrabajadores s ON s.TRABAJADOR_ID = t.ID_RECOPSICOTRABAJADOR
                                WHERE t.ID_RECOPSICOTRABAJADOR = ?', [$idPersonal]);


                $nombre = $datos[0]->RECPSICOTRABAJADOR_NOMBRE;
                $correo = $datos[0]->RECPSICOTRABAJADOR_CORREO;
                $fechalimite = $datos[0]->TRABAJADOR_FECHAFIN;
                $status = $datos[0]->TRABAJADOR_ESTADOCONTESTADO;
                $dias = $datos[0]->DIAS;



                //Obtenemos los datos del reconocimiento para las guias
                $datos = DB::select('SELECT RECPSICO_GUIAI, RECPSICO_GUIAII, RECPSICO_GUIAIII, RECPSICO_GUIAV
                                    FROM recopsiconormativa
                                    WHERE RECPSICO_ID = ?', [$idRecsensorial]);



                $guia1 = $datos[0]->RECPSICO_GUIAI;
                $guia2 = $datos[0]->RECPSICO_GUIAII;
                $guia3 = $datos[0]->RECPSICO_GUIAIII;
                $guia5 = $datos[0]->RECPSICO_GUIAV;
                // Encriptamos las guías
                $encryptedGuia1 = Crypt::encrypt($guia1);
                $encryptedGuia2 = Crypt::encrypt($guia2);
                $encryptedGuia3 = Crypt::encrypt($guia3);
                $encryptedGuia5 = Crypt::encrypt($guia5);

                $encryptedfechalimite = Crypt::encrypt($fechalimite);
                $encryptedstatus = Crypt::encrypt($status);

                $encryptedId = Crypt::encrypt($idPersonal);



                // Obtenemos la informacion de uno de los Psicologos asignado
                $proyecto = DB::select('SELECT id
                                FROM proyecto 
                                WHERE reconocimiento_psico_id = ?', [$idRecsensorial]);


                $psicoInfo = DB::select('SELECT IFNULL(s.signatario_Nombre, "NA") as info
                                FROM proyectosignatariosactual p
                                LEFT JOIN signatario s ON s.id = p.signatario_id
                                WHERE p.proyecto_id = ?
                                LIMIT 1', [$proyecto[0]->id]);
                $psico = $psicoInfo[0]->info;



                Mail::to($correo)->send(new sendGuiaPsico($nombre, $encryptedGuia1, $encryptedGuia2, $encryptedGuia3, $encryptedGuia5, $encryptedstatus, $encryptedfechalimite, $encryptedId, $dias, $psico));

                //cambiar el estado de envio de correo en el registro deltrabajador
                DB::table('proyectotrabajadores')
                    ->where('TRABAJADOR_ID', $idPersonal)
                    ->update(['TRABAJADOR_ESTADOCORREO' => 'Enviado']);
            }

            //Retornamos respuesta
            $response["msj"] = "Correo enviado correctamente";
            return response()->json($response, 200);
        } catch (Exception $e) {

            $response["msj"] = 'Error: ' . $e->getMessage();
            return response()->json($response, 500);
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @param  int  $proyecto_id
     * @param  int  $agente_id
     * @param  $agente_nombre
     * @return \Illuminate\Http\Response
     */
    public function evidenciafotosOnline($proyecto_id)
    {
        try {
            // Proyecto
            $proyecto = proyectoModel::findOrFail($proyecto_id);
            $recoid = $proyecto->reconocimiento_psico_id;

            $sql = DB::select("SELECT
                recopsicoFotosTrabajadores.ID_RECOPSICOFOTOTRABAJADOR,
                recopsicoFotosTrabajadores.RECPSICO_ID,
                recopsicoFotosTrabajadores.RECPSICO_TRABAJADOR,
                recopsicoFotosTrabajadores.RECPSICO_FOTOPREGUIA,
                recopsicoFotosTrabajadores.RECPSICO_FOTOPOSTGUIA,
                proyectotrabajadores.TRABAJADOR_NOMBRE,
                recopsicoFotosTrabajadores.created_at,
                recopsicoFotosTrabajadores.updated_at
            FROM
                recopsicoFotosTrabajadores
                LEFT JOIN proyectotrabajadores ON recopsicoFotosTrabajadores.RECPSICO_TRABAJADOR = proyectotrabajadores.TRABAJADOR_ID
            WHERE
                recopsicoFotosTrabajadores.RECPSICO_ID = ?",
            [$recoid]);

        $galeria = '';

        foreach ($sql as $key => $value) {
            // Verifica si ambos campos son NULL
            if (is_null($value->RECPSICO_FOTOPREGUIA) && is_null($value->RECPSICO_FOTOPOSTGUIA)) {
                continue; // Salta esta iteración si ambos son NULL
            }
        
            $galeria .= '<div class="col-12">
                            <ol class="breadcrumb m-b-10" style="background: none; padding: 0px;">
                                <i class="fa fa-folder-open fa-2x text-warning" style="float: left; margin-top: 8px; font-size: 20px;"></i>
                                <span class="text-warning" style="float: left; margin-top: 3px; font-size: 20px; font-family: Calibri;">&nbsp;&nbsp;' . $value->TRABAJADOR_NOMBRE . '</span>
                            </ol>
                            <hr>
                        </div>';
        
            // Validar si `RECPSICO_FOTOPREGUIA` no es NULL
            if (!is_null($value->RECPSICO_FOTOPREGUIA)) {
                $galeria .= '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 foto_galeria">
                            <i class="fa fa-download text-success" style="font-size: 26px; text-shadow: 2px 2px 4px #000000; position: absolute; opacity: 0; margin-left: 40px;" data-toggle="tooltip" title="Descargar" onclick="evidencia_foto_descargar(1, ' . $value->ID_RECOPSICOFOTOTRABAJADOR . ');"></i>
                            <a href="/psicoevidenciafotomostrar/0/0/' . $value->ID_RECOPSICOFOTOTRABAJADOR . '" data-effect="mfp-3d-unfold">
                                <img class="d-block img-fluid" src="/psicoevidenciafotomostrar/0/0/' . $value->ID_RECOPSICOFOTOTRABAJADOR . '" style="margin: 0px 0px 20px 0px;" data-toggle="tooltip" title="Click para mostrar"/>
                            </a>
                        </div>';
            }
        
            // Validar si `RECPSICO_FOTOPOSTGUIA` no es NULL
            if (!is_null($value->RECPSICO_FOTOPOSTGUIA)) {
                $galeria .= '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 foto_galeria">
                            <i class="fa fa-download text-success" style="font-size: 26px; text-shadow: 2px 2px 4px #000000; position: absolute; opacity: 0; margin-left: 40px;" data-toggle="tooltip" title="Descargar" onclick="evidencia_foto_descargar(1, ' . $value->ID_RECOPSICOFOTOTRABAJADOR . ');"></i>
                            <a href="/psicoevidenciafotomostrar/0/1/' . $value->ID_RECOPSICOFOTOTRABAJADOR . '" data-effect="mfp-3d-unfold">
                                <img class="d-block img-fluid" src="/psicoevidenciafotomostrar/0/1/' . $value->ID_RECOPSICOFOTOTRABAJADOR . '" style="margin: 0px 0px 20px 0px;" data-toggle="tooltip" title="Click para mostrar"/>
                            </a>
                        </div>';
            }
            // Cierre de la fila
            $galeria .= '</div>';
        }
        
        
            // respuesta
            $dato['fotos_total'] = count($sql);
            // $dato['fotos'] = $sql;
            $dato['fotos'] = $galeria;
            $dato["msj"] = 'Datos consultados correctamente';
            return response()->json($dato);
        } catch (Exception $e) {
            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['fotos_total'] = 0;
            $dato['fotos'] = null;
            return response()->json($dato);
        }
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $foto_opcion
     * @param  int  $foto_id
     * @param  int  $tipo_foto
     * @return \Illuminate\Http\Response
     */
    public function psicoevidenciafotomostrar($foto_opcion,$tipo_foto, $foto_id)
    {
        // $foto = proyectoevidenciafotoModel::findOrFail($foto_id);
        // return Storage::download($foto->proyectoevidenciafoto_archivo);
        // return Storage::response($foto->proyectoevidenciafoto_archivo);

        $foto = recpsicofotostrabajadoresModel::findOrFail($foto_id);

        if (($foto_opcion + 0) == 0) {
            if($tipo_foto == 0){
                return Storage::response($foto->RECPSICO_FOTOPREGUIA);
            }else{
                return Storage::response($foto->RECPSICO_FOTOPOSTGUIA);
            }
        } else {
            if($tipo_foto == 0){
                return Storage::download($foto->RECPSICO_FOTOPREGUIA);
            }else{
                return Storage::download($foto->RECPSICO_FOTOPOSTGUIA);
            }
        }
    }





    public function obtenerGuiasTrabajadorPresencial($proyecto_id, $trabajador_id)
    {
        $proyecto = DB::select('SELECT reconocimiento_psico_id
                            FROM proyecto
                            WHERE id = ?', [$proyecto_id]);

        if (count($proyecto) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el proyecto.'
            ]);
        }

        $idRecsensorial = $proyecto[0]->reconocimiento_psico_id;


        $guias = DB::select('SELECT
                            RECPSICO_GUIAI,
                            RECPSICO_GUIAII,
                            RECPSICO_GUIAIII,
                            RECPSICO_GUIAV
                         FROM recopsiconormativa
                         WHERE RECPSICO_ID = ?', [$idRecsensorial]);

        if (count($guias) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron las guías.'
            ]);
        }

        return response()->json([
            'success' => true,

            'TRABAJADOR_ID' => $trabajador_id,

            'GUIA1' => $guias[0]->RECPSICO_GUIAI,
            'GUIA2' => $guias[0]->RECPSICO_GUIAII,
            'GUIA3' => $guias[0]->RECPSICO_GUIAIII,
            'GUIA5' => $guias[0]->RECPSICO_GUIAV
        ]);
    }


    public function consultarRespuestasGuardadasPresencial(Request $request)
    {
        $idTrabajador = $request->id_trabajador;

        $trabajador = DB::select("
                    SELECT
                        RECPSICO_GUIAI_RESPUESTAS,
                        RECPSICO_GUIAII_RESPUESTAS,
                        RECPSICO_GUIAIII_RESPUESTAS
                    FROM recopsicoTrabajadoresRespuestas
                    WHERE RECPSICO_TRABAJADOR = ?
                ", [$idTrabajador]);

        if (count($trabajador) > 0) {
            return response()->json($trabajador[0]);
        }

        return response()->json(null);
    }



    public function mostrarplantillaguia1y2()
    {
        $filePath = storage_path('app/plantillas_excel/Calificación Guia 1 y 2 NOM035.xlsx');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->download($filePath);
    }



    public function mostrarplantillaguia1y3()
    {
        $filePath = storage_path('app/plantillas_excel/Calificación Guia 1 y 3 NOM035.xlsx');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->download($filePath);
    }



    public function importarRespuestasTrabajadores(Request $request)
    {
        try {

           
            $request->validate([
                'excelRespuestasTrabajador' => 'required|file|mimes:xls,xlsx',
                'tipoGuia' => 'required',
                'proyecto_id' => 'required'
            ]);

            $tipoGuia = $request->tipoGuia;
            $proyecto_id = $request->proyecto_id;


            $proyecto = DB::table('proyecto')
                ->where('id', $proyecto_id)
                ->first();

            if (!$proyecto) {

                return response()->json([
                    'mensaje' => 'Proyecto no encontrado.'
                ], 404);
            }

            $recpsico_id = $proyecto->reconocimiento_psico_id;

            $archivo = $request->file('excelRespuestasTrabajador');

            $spreadsheet = IOFactory::load($archivo->getRealPath());

            $sheet = $spreadsheet->getActiveSheet();

            $ultimaFila = $sheet->getHighestRow();

            $guardados = 0;
            $errores = [];


            for ($fila = 3; $fila <= $ultimaFila; $fila++) {

                $nombreTrabajador = trim(
                    $sheet->getCell('B' . $fila)->getCalculatedValue()
                );

                if ($nombreTrabajador == "") {
                    continue;
                }

                $trabajador = DB::table('proyectotrabajadores')
                    ->where('proyecto_id', $proyecto_id)
                    ->whereRaw('TRIM(TRABAJADOR_NOMBRE)=?', [trim($nombreTrabajador)])
                                        ->first();

                if (!$trabajador) {

                    $errores[] = "Fila {$fila}: No se encontró al trabajador {$nombreTrabajador}";

                    continue;
                }

                $trabajador_id = $trabajador->TRABAJADOR_ID;


                $guia1 = array_fill(0, 15, null);

                $indice = 0;

                foreach (range('E', 'S') as $columna) {

                    $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                    if ($valor === "" || $valor === null) {
                        $guia1[$indice] = null;
                    } else {
                        $guia1[$indice] = strval($valor);
                    }

                    $indice++;
                }

                $jsonGuia1 = json_encode($guia1, JSON_UNESCAPED_UNICODE);



                if ($tipoGuia == 12) {


                    $guia2 = array_fill(0, 48, null);

                    $indice = 0;

                    foreach (range('T', 'Z') as $columna) {

                        $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                        if ($valor !== "" && $valor !== null) {
                            $guia2[$indice] = (string)$valor;
                        }

                        $indice++;
                    }

                    foreach (range('A', 'Z') as $letra) {

                        $columna = 'A' . $letra;

                        if ($columna > 'BO') {
                            break;
                        }

                        $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                        if ($valor !== "" && $valor !== null) {
                            $guia2[$indice] = (string)$valor;
                        }

                        $indice++;

                        if ($indice >= 48) {
                            break;
                        }
                    }

                    if ($indice < 48) {

                        foreach (range('A', 'O') as $letra) {

                            $columna = 'B' . $letra;

                            $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                            if ($valor !== "" && $valor !== null) {
                                $guia2[$indice] = (string)$valor;
                            }

                            $indice++;

                            if ($indice >= 48) {
                                break;
                            }
                        }
                    }

                    $jsonGuia2 = json_encode($guia2);


                    $existe = DB::table('recopsicoTrabajadoresRespuestas')
                        ->where('RECPSICO_TRABAJADOR', $trabajador_id)
                        ->exists();

                    if ($existe) {

                        DB::table('recopsicoTrabajadoresRespuestas')
                            ->where('RECPSICO_TRABAJADOR', $trabajador_id)
                            ->update([
                                'RECPSICO_GUIAI_RESPUESTAS' => $jsonGuia1,
                                'RECPSICO_GUIAII_RESPUESTAS' => $jsonGuia2,
                                'RECPSICO_ID' => $recpsico_id,
                                'updated_at' => now()
                            ]);
                    } else {

                        DB::table('recopsicoTrabajadoresRespuestas')
                            ->insert([
                                'RECPSICO_TRABAJADOR' => $trabajador_id,
                                'RECPSICO_ID' => $recpsico_id,
                                'RECPSICO_GUIAI_RESPUESTAS' => $jsonGuia1,
                                'RECPSICO_GUIAII_RESPUESTAS' => $jsonGuia2,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                    }

                    DB::table('proyectotrabajadores')
                        ->where('TRABAJADOR_ID', $trabajador_id)
                        ->update([
                            'TRABAJADOR_ESTADOCONTESTADO' => 'Finalizado',
                            'updated_at' => now()

                        ]);

                    $guardados++;

                }

                else if ($tipoGuia == 13) {


                    $guia3 = array_fill(0, 74, null);

                    $indice = 0;

                    foreach (range('T', 'Z') as $columna) {

                        $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                        if ($valor !== "" && $valor !== null) {
                            $guia3[$indice] = (string)$valor;
                        }

                        $indice++;
                    }

                    foreach (range('A', 'Z') as $letra) {

                        $columna = 'A' . $letra;

                        $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                        if ($valor !== "" && $valor !== null) {
                            $guia3[$indice] = (string)$valor;
                        }

                        $indice++;

                        if ($indice >= 74) {
                            break;
                        }
                    }

                    if ($indice < 74) {

                        foreach (range('A', 'Z') as $letra) {

                            $columna = 'B' . $letra;

                            $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                            if ($valor !== "" && $valor !== null) {
                                $guia3[$indice] = (string)$valor;
                            }

                            $indice++;

                            if ($indice >= 74) {
                                break;
                            }
                        }
                    }

                    if ($indice < 74) {

                        foreach (range('A', 'O') as $letra) {

                            $columna = 'C' . $letra;

                            $valor = $sheet->getCell($columna . $fila)->getCalculatedValue();

                            if ($valor !== "" && $valor !== null) {
                                $guia3[$indice] = (string)$valor;
                            }

                            $indice++;

                            if ($indice >= 74) {
                                break;
                            }
                        }
                    }

                    $jsonGuia3 = json_encode($guia3);


                    $existe = DB::table('recopsicoTrabajadoresRespuestas')
                        ->where('RECPSICO_TRABAJADOR', $trabajador_id)
                        ->exists();

                    if ($existe) {

                        DB::table('recopsicoTrabajadoresRespuestas')
                            ->where('RECPSICO_TRABAJADOR', $trabajador_id)
                            ->update([

                                'RECPSICO_GUIAI_RESPUESTAS'   => $jsonGuia1,
                                'RECPSICO_GUIAIII_RESPUESTAS' => $jsonGuia3,
                                'RECPSICO_ID'                => $recpsico_id,
                                'updated_at'                 => now()

                            ]);
                    } else {

                        DB::table('recopsicoTrabajadoresRespuestas')
                            ->insert([
                                'RECPSICO_TRABAJADOR'        => $trabajador_id,
                                'RECPSICO_ID'                => $recpsico_id,
                                'RECPSICO_GUIAI_RESPUESTAS'   => $jsonGuia1,
                                'RECPSICO_GUIAIII_RESPUESTAS' => $jsonGuia3,
                                'created_at' => now(),
                                'updated_at' => now()

                            ]);
                    }


                    DB::table('proyectotrabajadores')
                        ->where('TRABAJADOR_ID', $trabajador_id)
                        ->update([

                            'TRABAJADOR_ESTADOCONTESTADO' => 'Finalizado',
                            'updated_at' => now()

                        ]);

                    $guardados++;



                }
            }

            return response()->json([
                'mensaje'    => 'Importación finalizada correctamente.',
                'guardados' => $guardados,
                'errores'   => $errores
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => 'Ocurrió un error al importar el archivo.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }





    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    if (isset($request->ELIMINAR)) {

                        $fotos = evidenciafotosModel::find($request->ID_FOTOS_EJECUCION);
                        if ($fotos) {
                            if ($fotos->INPUTEVIDENCIAFOTOS && Storage::exists($fotos->INPUTEVIDENCIAFOTOS)) {
                                Storage::delete($fotos->INPUTEVIDENCIAFOTOS);
                            }
                            $fotos->delete();
                        }

                        return response()->json([
                            'code' => 1,
                            'fotos' => 'Eliminada'
                        ]);
                    }

                    if ($request->hasFile('INPUTEVIDENCIAFOTOS')) {

                        DB::statement('ALTER TABLE evidencia_foto_psico AUTO_INCREMENT = 1;');

                        $ultimoRegistro = null;

                        foreach ($request->file('INPUTEVIDENCIAFOTOS') as $file) {
                            $fotos = evidenciafotosModel::create([
                                'PROYECTO_ID' => $request->PROYECTO_ID,
                                'ACTIVO'  => 1
                            ]);

                            $folder = "Ejecución Psico/{$fotos->PROYECTO_ID}/Evidencias fotos/{$fotos->ID_FOTOS_EJECUCION}";

                            $filename = "evidencia_fotos." . $file->getClientOriginalExtension();

                            $path = $file->storeAs($folder, $filename);

                            $fotos->INPUTEVIDENCIAFOTOS = $path;
                            $fotos->save();

                            $ultimoRegistro = $fotos;
                        }

                        return response()->json([
                            'code' => 1,
                            'fotos' => $ultimoRegistro
                        ]);
                    }

                    return response()->json([
                        'code' => 0,
                        'msj' => 'No se recibieron imágenes.'
                    ]);

                default:

                    return response()->json([
                        'code' => 0,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'code'  => 0,
                'msj'   => 'Error al guardar',
                'error' => $e->getMessage()
            ]);
        }
    }



    public function mostrarevidenciasfotospsico($archivo_opcion, $id)
    {
        $recurso = evidenciafotosModel::findOrFail($id);

        if ($archivo_opcion == 0) {
            return Storage::response($recurso->INPUTEVIDENCIAFOTOS);
        }

        return Storage::download($recurso->INPUTEVIDENCIAFOTOS);
    }



    public function evidenciafotospsico($proyecto_id)
    {
        try {

            $fotos = evidenciafotosModel::where('PROYECTO_ID', $proyecto_id)
                ->orderBy('ID_FOTOS_EJECUCION')
                ->get();

            $galeria = '';

            foreach ($fotos as $value) {

                $galeria .= '
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 plano_galeria">

                <i class="fa fa-trash text-danger"
                    style="font-size:26px;
                    text-shadow:2px 2px 4px #000;
                    position:absolute;
                    cursor:pointer;"
                    data-toggle="tooltip"
                    title="Eliminar"
                    onclick="eliminarPlano(' . $value->ID_FOTOS_EJECUCION . ')"></i>

                <a href="' . route('mostrarevidenciasfotospsico', [0, $value->ID_FOTOS_EJECUCION]) . '" data-effect="mfp-3d-unfold">

                    <img
                        class="d-block img-fluid"
                        src="' . route('mostrarevidenciasfotospsico', [0, $value->ID_FOTOS_EJECUCION]) . '"
                        style="margin-bottom:20px;"
                        data-toggle="tooltip"
                        title="Click para mostrar">

                </a>

            </div>';
            }

            return response()->json([
                'fotos_total' => count($fotos),
                'fotos' => $galeria
            ]);
        } catch (Exception $e) {

            return response()->json([
                'fotos_total' => 0,
                'fotos' => ''
            ]);
        }
    }

    public function totalfotospsico($proyecto_id)
    {
        try {

            $total = evidenciafotosModel::where('PROYECTO_ID', $proyecto_id)->count();

            return response()->json([
                'code' => 1,
                'total' => $total
            ]);
        } catch (Exception $e) {

            return response()->json([
                'code' => 0,
                'total' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }
}




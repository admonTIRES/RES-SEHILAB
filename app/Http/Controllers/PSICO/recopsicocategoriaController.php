<?php

namespace App\Http\Controllers\PSICO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\modelos\reconocimientopsico\reconocimientopsicoModel;
use App\modelos\reconocimientopsico\recopsicocategoriaModel;
use DB;

class recopsicocategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('Superusuario,Administrador,Proveedor,Reconocimiento,Proyecto,Compras,Staff,Psicólogo,Ergónomo,CoordinadorPsicosocial,CoordinadorErgonómico,CoordinadorRN,CoordinadorRS,CoordinadorRM,CoordinadorHI,Externo');
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $recsensorial_id
     * @return \Illuminate\Http\Response
     */



    public function Tablarecocategoriaspsico(Request $request)
    {
        try {
            $psico = $request->get('psicoid');

            $tabla = recopsicocategoriaModel::where('RECPSICO_ID', $psico)
                ->orderBy('ID_RECOPSICOCATEGORIA', 'ASC')
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-circle " ><i class="fa fa-ban"></i></button>';
                    $value->BTN_ELIMINAR =
                        '<div class="switch"> 
                        <label>
                            <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RECOPSICOCATEGORIA . '"><span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>';
                } else {
                    $value->BTN_ELIMINAR = '
                    <div class="switch">
                        <label>
                            <input  type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RECOPSICOCATEGORIA . '" checked ><span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-circle editar"><i class="fa fa-pencil"></i></button>';
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





     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */





    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_RECOPSICOCATEGORIA == 0) {
                        DB::statement('ALTER TABLE recopsicocategoria AUTO_INCREMENT=1;');
                        $categorias = recopsicocategoriaModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $categorias = recopsicocategoriaModel::where('ID_RECOPSICOCATEGORIA', $request['ID_RECOPSICOCATEGORIA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['categorias'] = 'Desactivada';
                            } else {
                                $categorias = recopsicocategoriaModel::where('ID_RECOPSICOCATEGORIA', $request['ID_RECOPSICOCATEGORIA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['categorias'] = 'Activada';
                            }
                        } else {
                            $categorias = recopsicocategoriaModel::find($request->ID_RECOPSICOCATEGORIA);
                            $categorias->update($request->all());
                            $response['code'] = 1;
                            $response['categorias'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['categorias']  = $categorias;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }


    }

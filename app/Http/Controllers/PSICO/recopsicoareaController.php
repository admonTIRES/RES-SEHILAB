<?php

namespace App\Http\Controllers\PSICO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\modelos\reconocimientopsico\recopsicoareaModel;
use DB;
class recopsicoareaController extends Controller
{




    public function Tablarecoareaspsico(Request $request)
    {
        try {
            $psico = $request->get('psicoid');

            $tabla = recopsicoareaModel::where('RECPSICO_ID', $psico)->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {

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
                    if ($request->ID_RECOPSICOAREA == 0) {
                        DB::statement('ALTER TABLE recopsicoarea AUTO_INCREMENT=1;');
                        $areas = recopsicoareaModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $areas = recopsicoareaModel::where('ID_RECOPSICOAREA', $request['ID_RECOPSICOAREA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['areas'] = 'Desactivada';
                            } else {
                                $areas = recopsicoareaModel::where('ID_RECOPSICOAREA', $request['ID_RECOPSICOAREA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['areas'] = 'Activada';
                            }
                        } else {
                            $areas = recopsicoareaModel::find($request->ID_RECOPSICOAREA);
                            $areas->update($request->all());
                            $response['code'] = 1;
                            $response['areas'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['areas']  = $areas;
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

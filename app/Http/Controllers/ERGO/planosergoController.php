<?php

namespace App\Http\Controllers\ERGO;

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


use App\modelos\reconocimientoergo\planosergoModel;


class planosergoController extends Controller
{




    public function evidenciaplanosergo($reco_id)
    {
        try {

            $planos = planosergoModel::where('RECO_ID', $reco_id)
                ->orderBy('ID_PLANOS_ERGO')
                ->get();

            $galeria = '';

            foreach ($planos as $value) {

                $galeria .= '
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 plano_galeria">

                <i class="fa fa-trash text-danger"
                    style="font-size:26px;
                    text-shadow:2px 2px 4px #000;
                    position:absolute;
                    cursor:pointer;"
                    data-toggle="tooltip"
                    title="Eliminar"
                    onclick="eliminarPlano(' . $value->ID_PLANOS_ERGO . ')"></i>

                <a href="' . route('mostrarplanosergo', [0, $value->ID_PLANOS_ERGO]) . '" data-effect="mfp-3d-unfold">

                    <img
                        class="d-block img-fluid"
                        src="' . route('mostrarplanosergo', [0, $value->ID_PLANOS_ERGO]) . '"
                        style="margin-bottom:20px;"
                        data-toggle="tooltip"
                        title="Click para mostrar">

                </a>

            </div>';
            }

            return response()->json([
                'planos_total' => count($planos),
                'planos' => $galeria
            ]);
        } catch (Exception $e) {

            return response()->json([
                'planos_total' => 0,
                'planos' => ''
            ]);
        }
    }




    public function totalplanosergo($reco_id)
    {
        try {

            $total = planosergoModel::where('RECO_ID', $reco_id)->count();

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



    public function mostrarplanosergo($archivo_opcion, $id)
    {
        $recurso = planosergoModel::findOrFail($id);

        if ($archivo_opcion == 0) {
            return Storage::response($recurso->INPUTEVIDENCIAPLANOS);
        }

        return Storage::download($recurso->INPUTEVIDENCIAPLANOS);
    }

    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    if (isset($request->ELIMINAR)) {

                        $planos = planosergoModel::find($request->ID_PLANOS_ERGO);
                        if ($planos) {
                            if ($planos->INPUTEVIDENCIAPLANOS && Storage::exists($planos->INPUTEVIDENCIAPLANOS)) {
                                Storage::delete($planos->INPUTEVIDENCIAPLANOS);
                            }
                            $planos->delete();
                        }

                        return response()->json([
                            'code' => 1,
                            'planos' => 'Eliminada'
                        ]);
                    }

                    if ($request->hasFile('INPUTEVIDENCIAPLANOS')) {

                        DB::statement('ALTER TABLE planos_recergo AUTO_INCREMENT = 1;');

                        $ultimoRegistro = null;

                        foreach ($request->file('INPUTEVIDENCIAPLANOS') as $file) {
                            $planos = planosergoModel::create([
                                'RECO_ID' => $request->RECO_ID,
                                'ACTIVO'  => 1
                            ]);

                            $folder = "reconocimiento_ergo/{$planos->RECO_ID}/Planos Mapas/{$planos->ID_PLANOS_ERGO}";

                            $filename = "evidencia_planos." . $file->getClientOriginalExtension();

                            $path = $file->storeAs($folder, $filename);

                            $planos->INPUTEVIDENCIAPLANOS = $path;
                            $planos->save();

                            $ultimoRegistro = $planos;
                        }

                        return response()->json([
                            'code' => 1,
                            'planos' => $ultimoRegistro
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



}

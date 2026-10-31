<?php

namespace App\modelos\evaluacionfre;

use Illuminate\Database\Eloquent\Model;

class versionesfrergoModel extends Model
{
    protected $table = 'versionesfreergo';

    protected $primaryKey =
    'ID_VERSION_RECO_ERGO';

    protected $fillable = [
        'RECO_ID',
        'NUMERO_REVISION',
        'FINALIZADO',
        'FINALIZADO_POR',
        'FECHA_FINALIZADO',
        'CANCELADO',
        'CANCELADO_POR',
        'FECHA_CANCELADO',
        'MOTIVO_CANCELACION',
        'RUTA_DOCUMENTO'
    ];
}

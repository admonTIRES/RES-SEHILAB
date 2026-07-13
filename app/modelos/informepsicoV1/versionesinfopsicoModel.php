<?php

namespace App\modelos\informepsicoV1;

use Illuminate\Database\Eloquent\Model;

class versionesinfopsicoModel extends Model
{
    protected $table = 'versionesinfopsico';

    protected $primaryKey =
    'ID_VERSION_INFO_PSICO';

    protected $fillable = [
        'PROYECTO_ID',
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

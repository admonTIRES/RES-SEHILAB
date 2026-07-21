<?php

namespace App\modelos\informepsicoV1;

use Illuminate\Database\Eloquent\Model;

class recomendacionesinformepsicoModel extends Model
{
    protected $table = 'recomendacionesinformepsico';
    protected $primaryKey = 'ID_RECOMENDACIONES_INFORME_PSICO';
    protected $fillable = [
        'PROYECTO_ID',
        'CATALOGO_RECOMENDACIONES_ID',
        'ES_PRIORITARIA'

    ];
}

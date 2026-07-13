<?php

namespace App\modelos\informepsicoV1;

use Illuminate\Database\Eloquent\Model;

class definicionesinformepsicoModel extends Model
{
    protected $table = 'definicionesinformepsico';
    protected $primaryKey = 'ID_DEFINICION_INFORME_PSICO';
    protected $fillable = [
        'PROYECTO_ID',
        'CATALOGO_DEFINICIONES_ID'
    ];
}

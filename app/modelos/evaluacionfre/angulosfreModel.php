<?php

namespace App\modelos\evaluacionfre;

use Illuminate\Database\Eloquent\Model;

class angulosfreModel extends Model
{
    protected $table = 'angulos_fre_ergo';
    protected $primaryKey = 'ID_ANGULOS_FRE';
    protected $fillable = [
        'FRE_ID',
        'FOTO_ANGULO',
        'APLICA_POSTURA',
        'APLICA_MOVIMIENTO',
        'APLICA_FUERZA',
        'DESCRIPCION_POSTURA',
        'DESCRIPCION_MOVIMIENTO',
        'DESCRIPCION_FUERZA',
        'ACTIVO'

    ];
}

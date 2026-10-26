<?php

namespace App\modelos\evaluacionfre;

use Illuminate\Database\Eloquent\Model;

class recomendacionesinformefreModel extends Model
{
    protected $table = 'recomendacionesinformeFre';
    protected $primaryKey = 'ID_RECOMENDACIONES_FRE_ERGO';
    protected $fillable = [
        'RECO_ID',
        'CATALOGO_RECOMENDACIONES_ID'

    ];
}

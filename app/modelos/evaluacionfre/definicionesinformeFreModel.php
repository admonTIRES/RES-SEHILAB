<?php

namespace App\modelos\evaluacionfre;

use Illuminate\Database\Eloquent\Model;

class definicionesinformeFreModel extends Model
{
    protected $table = 'definicionesinformefre';
    protected $primaryKey = 'ID_DEFINICION_INFORME_FRE';
    protected $fillable = [
        'RECO_ID',
        'CATALOGO_DEFINICIONES_ID'
    ];
}

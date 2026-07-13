<?php

namespace App\modelos\informepsicoV1;

use Illuminate\Database\Eloquent\Model;

class recursosPortadasInformePsicoModel extends Model
{
    protected $primaryKey = 'ID_RECURSO_INFORME';
    protected $table = 'recursosPortadasInformePsico';
    protected $fillable = [
        'PROYECTO_ID',
        'AGENTE_ID',
        'NORMA_ID',
        'RUTA_IMAGEN_PORTADA',
        'NIVEL1',
        'NIVEL2',
        'NIVEL3',
        'NIVEL4',
        'NIVEL5',
        'OPCION_PORTADA1',
        'OPCION_PORTADA2',
        'OPCION_PORTADA3',
        'OPCION_PORTADA4',
        'OPCION_PORTADA5',
        'OPCION_PORTADA6',
        'INFORME_MES',
        'INFORME_ANIO',
    ];
}

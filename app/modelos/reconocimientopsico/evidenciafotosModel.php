<?php

namespace App\modelos\reconocimientopsico;

use Illuminate\Database\Eloquent\Model;

class evidenciafotosModel extends Model
{

    protected $primaryKey = 'ID_FOTOS_EJECUCION';
    protected $table = 'evidencia_foto_psico';
    protected $fillable = [
        'PROYECTO_ID',
        'INPUTEVIDENCIAFOTOS',
        'ACTIVO'

    ];
}

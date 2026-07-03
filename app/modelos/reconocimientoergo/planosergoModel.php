<?php

namespace App\modelos\reconocimientoergo;

use Illuminate\Database\Eloquent\Model;

class planosergoModel extends Model
{
    protected $primaryKey = 'ID_PLANOS_ERGO';
    protected $table = 'planos_recergo';
    protected $fillable = [
        'RECO_ID',
        'INPUTEVIDENCIAPLANOS',
        'ACTIVO'

    ];
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAngulosFre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angulos_fre_ergo', function (Blueprint $table) {
            $table->increments('ID_ANGULOS_FRE');
            $table->text('FRE_ID')->nullable();
            $table->text('FOTO_ANGULO')->nullable();
            $table->text('APLICA_POSTURA')->nullable();
            $table->text('APLICA_MOVIMIENTO')->nullable();
            $table->text('APLICA_FUERZA')->nullable();
            $table->text('DESCRIPCION_POSTURA')->nullable();
            $table->text('DESCRIPCION_MOVIMIENTO')->nullable();
            $table->text('DESCRIPCION_FUERZA')->nullable();
            $table->boolean('ACTIVO')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

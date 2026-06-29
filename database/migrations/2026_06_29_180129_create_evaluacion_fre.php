<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluacionFre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_fre_ergo', function (Blueprint $table) {
            $table->increments('ID_EVALUACION_FRE');
            $table->text('FICHA_ID')->nullable();
            $table->text('JSON_ACTIVIDADES_FRE')->nullable();
            $table->date('FECHA_EVALUACION_FRE')->nullable();
            $table->text('CAT_DEPARTAMENTO_FRE')->nullable();
            $table->text('EVALUACION_TRABAJADOR')->nullable();
            $table->text('NOMBRE_EMPLEADO_FRE')->nullable();
            $table->text('NO_EMPLEADO_FRE')->nullable();
            $table->text('ULTIMO_GRADO_FRE')->nullable();
            $table->text('INDIQUE_UBICACION_FRE')->nullable();
            $table->text('SEXO_EMPLEADO_FRE')->nullable();
            $table->date('FECHA_NACIMIENTO_FRE')->nullable();
            $table->text('EDAD_EMPLEADO_FRE')->nullable();
            $table->text('REGIMEN_CONTRACTUAL_FRE')->nullable();
            $table->text('JORNADA_EMPLEADO_FRE')->nullable();
            $table->text('TIEMPO_EMPRESA_FRE')->nullable();
            $table->text('ANTIGUEDAD_CATEOGORIA_FRE')->nullable();
            $table->text('PAUSAS_DESCANSO')->nullable();
            $table->text('ENFERMEDAD_MUSCULOESQUELETICA')->nullable();
            $table->text('ENFERMEDAD_MUSCULOESQUELETICA_CUAL')->nullable();
            $table->text('ENFERMEDAD_MUSCULOESQUELETICA_TIEMPO')->nullable();
            $table->text('INCAPACITADO_DOLOR_MUSCULO')->nullable();
            $table->text('FUENTE_ILUMINACION')->nullable();
            $table->text('INTENSIDAD_ILUMINACION')->nullable();
            $table->text('OBSERVACION_ILUMINACION')->nullable();
            $table->text('PERCEPCION_TERMICA')->nullable();
            $table->text('INTENSIDAD_TERMICA')->nullable();
            $table->text('CUAL_PERCEPCION')->nullable();
            $table->text('OBSERVACIONES_TERMICAS')->nullable();
            $table->text('INTENSIDAD_RUIDO')->nullable();
            $table->text('CONTINUIDAD_RUIDO')->nullable();
            $table->text('OBSERVACIONES_RUIDO')->nullable();
            $table->text('INTENSIDAD_VIBRACION')->nullable();
            $table->text('SEGMENTO_VIBRACION')->nullable();
            $table->text('OBSERVACIONES_VIBRACION')->nullable();
            $table->text('PESO_FRE')->nullable();
            $table->text('TALLA_FRE')->nullable();
            $table->text('CUELLO')->nullable();
            $table->text('HOMBRO')->nullable();
            $table->text('HOMBRO_IZQ')->nullable();
            $table->text('HOMBRO_DER')->nullable();
            $table->text('CODO')->nullable();
            $table->text('CODO_IZQ')->nullable();
            $table->text('CODO_DER')->nullable();
            $table->text('MUNECA')->nullable();
            $table->text('MUNECA_IZQ')->nullable();
            $table->text('MUNECA_DER')->nullable();
            $table->text('ESPALDA_ALTA')->nullable();
            $table->text('ESPALDA_BAJA')->nullable();
            $table->text('CADERAS_PIERNAS')->nullable();
            $table->text('RODILLAS')->nullable();
            $table->text('TOBILLOS_PIES')->nullable();
            $table->text('CUELLO_12_MESES')->nullable();
            $table->text('CUELLO_7_DIAS')->nullable();
            $table->text('HOMBRO_12_MESES')->nullable();
            $table->text('HOMBRO_7_DIAS')->nullable();
            $table->text('CODO_12_MESES')->nullable();
            $table->text('CODO_7_DIAS')->nullable();
            $table->text('MUNECA_12_MESES')->nullable();
            $table->text('MUNECA_7_DIAS')->nullable();
            $table->text('ESPALDA_ALTA_12_MESES')->nullable();
            $table->text('ESPALDA_ALTA_7_DIAS')->nullable();
            $table->text('ESPALDA_BAJA_12_MESES')->nullable();
            $table->text('ESPALDA_BAJA_7_DIAS')->nullable();
            $table->text('CADERAS_PIERNAS_12_MESES')->nullable();
            $table->text('CADERAS_PIERNAS_7_DIAS')->nullable();
            $table->text('RODILLAS_12_MESES')->nullable();
            $table->text('RODILLAS_7_DIAS')->nullable();
            $table->text('TOBILLOS_PIES_12_MESES')->nullable();
            $table->text('TOBILLOS_PIES_7_DIAS')->nullable();
            $table->text('COLUMNA_LUMBAR_P1')->nullable();
            $table->text('COLUMNA_LUMBAR_P2')->nullable();
            $table->text('COLUMNA_LUMBAR_P3')->nullable();
            $table->text('COLUMNA_LUMBAR_P4')->nullable();
            $table->text('COLUMNA_LUMBAR_P5_ACTIVIDAD_LABORAL')->nullable();
            $table->text('COLUMNA_LUMBAR_P5_ACTIVIDAD_OCIO')->nullable();
            $table->text('COLUMNA_LUMBAR_P6')->nullable();
            $table->text('COLUMNA_LUMBAR_P7')->nullable();
            $table->text('COLUMNA_LUMBAR_P8')->nullable();
            $table->text('CUELLO_P1')->nullable();
            $table->text('CUELLO_P2')->nullable();
            $table->text('CUELLO_P3')->nullable();
            $table->text('CUELLO_P4')->nullable();
            $table->text('CUELLO_P5_ACTIVIDAD_LABORAL')->nullable();
            $table->text('CUELLO_P5_ACTIVIDAD_OCIO')->nullable();
            $table->text('CUELLO_P6')->nullable();
            $table->text('CUELLO_P7')->nullable();
            $table->text('CUELLO_P8')->nullable();
            $table->text('HOMBRO_P1')->nullable();
            $table->text('HOMBRO_P2')->nullable();
            $table->text('HOMBRO_P3')->nullable();
            $table->text('HOMBRO_P4')->nullable();
            $table->text('HOMBRO_P5_ACTIVIDAD_LABORAL')->nullable();
            $table->text('HOMBRO_P5_ACTIVIDAD_OCIO')->nullable();
            $table->text('HOMBRO_P6')->nullable();
            $table->text('HOMBRO_P7')->nullable();
            $table->text('HOMBRO_P8')->nullable();
            $table->text('FUERZA_MANO_DERECHA')->nullable();
            $table->text('FUERZA_MANO_IZQUIERDA')->nullable();
            $table->text('REQUIERE_FUERZA_MANUAL')->nullable();
            $table->text('TIPO_DOMINANCIA')->nullable();
            $table->text('REALIZA_TAREAS_PIE')->nullable();
            $table->text('BIPEDESTACION_ESTATICA')->nullable();
            $table->text('BIPEDESTACION_DINAMICA')->nullable();
            $table->text('OBSERVACIONES_GENERALES')->nullable();
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

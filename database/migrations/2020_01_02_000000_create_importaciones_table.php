<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importaciones', function (Blueprint $table) {
            $table->id();
            $table->char('id_provincia', 2)->nullable();
            $table->char('periodo', 7)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('original')->nullable();
            $table->string('path')->nullable();
            $table->integer('total')->nullable();
            $table->integer('facturadas')->nullable();
            $table->integer('liquidadas')->nullable();
            $table->integer('pagadas')->nullable();
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
        Schema::dropIfExists('importaciones');
    }
}

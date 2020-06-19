<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorImportacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_importacions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_importacion');
			$table->char('id_provincia', 2);
            $table->integer('id_prestacion');
            $table->string('codigo');
            $table->string('mensaje');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('error_importacions');
    }
}

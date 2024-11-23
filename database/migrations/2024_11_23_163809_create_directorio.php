<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorio', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre'); 
            $table->string('apellido'); 
            $table->string('telefono'); 
            $table->unsignedBigInteger('user_id'); 
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
        Schema::dropIfExists('directorio');
    }
}

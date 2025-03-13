<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('seccion')->nullable();
            $table->string('jornada')->default(''); // Jornada opcional
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->unique(['name', 'seccion', 'jornada']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}

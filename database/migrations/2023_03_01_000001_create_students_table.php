<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function(Blueprint $table){
            $table->id();
            $table->string('identificacion')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('representante')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

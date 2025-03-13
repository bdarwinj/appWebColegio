<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseFeesTable extends Migration
{
    public function up()
    {
        Schema::create('course_fees', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->integer('academic_year');
            $table->decimal('fee', 8, 2);
            $table->timestamps();
            $table->unique(['course_id', 'academic_year']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('course_fees');
    }
}

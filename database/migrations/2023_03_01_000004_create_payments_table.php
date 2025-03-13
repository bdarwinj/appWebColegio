<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('description')->nullable();
            $table->timestamp('payment_date')->useCurrent();
            $table->string('period')->nullable();  // Mes o periodo
            $table->string('receipt_number')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

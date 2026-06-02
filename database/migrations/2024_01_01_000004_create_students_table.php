<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('dojo_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('belt_level_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->date('join_date')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

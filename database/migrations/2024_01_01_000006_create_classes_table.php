<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Kids Karate, Adult Taekwondo, etc.
            $table->foreignId('dojo_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('instructor_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('schedule')->nullable(); // e.g. "Mon, Wed, Fri 6pm"
            $table->integer('max_students')->nullable();
            $table->string('level')->nullable(); // beginner, intermediate, advanced
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
}

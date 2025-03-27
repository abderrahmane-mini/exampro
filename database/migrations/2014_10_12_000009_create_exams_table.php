<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('academic_year'); // e.g. "2024-2025"
            $table->enum('semester', ['S1', 'S2', 'S3', 'S4']);
            $table->enum('status', ['planned', 'ongoing', 'completed', 'canceled'])->default('planned');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
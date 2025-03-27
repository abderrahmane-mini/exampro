<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pv_notes', 'releve_notes', 'attestation_reussite']);
            $table->string('file_path');
            $table->foreignId('exam_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained('users');
            $table->foreignId('generated_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
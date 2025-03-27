<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('student_id')->constrained('users');
            $table->decimal('grade', 5, 2);
            $table->boolean('is_present')->default(true);
            $table->text('comments')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
};
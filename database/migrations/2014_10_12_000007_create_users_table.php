<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->enum('user_type', [
                'directeur_pedagogique', 
                'enseignant', 
                'etudiant', 
                'administrateur'
            ])->default('etudiant');
            
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            
            $table->string('student_code')->nullable()->unique();
            $table->string('teacher_code')->nullable()->unique();
            
            $table->foreignId('program_id')->nullable()->constrained();
            $table->foreignId('group_id')->nullable()->constrained();
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
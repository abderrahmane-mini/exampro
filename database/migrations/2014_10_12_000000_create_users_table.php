<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // New fields for role-based system
            $table->enum('user_type', [
                'directeur_pedagogique', 
                'enseignant', 
                'etudiant', 
                'administrateur'
            ])->default('etudiant');
            
            // Additional profile information
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            
            // Optional fields for specific roles
            $table->string('student_code')->nullable()->unique();
            $table->string('teacher_code')->nullable()->unique();
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Add soft delete for safe user management
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
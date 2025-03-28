<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('module_teacher', function (Blueprint $table) {
            $table->foreignId('module_id')->constrained(); // Foreign key to 'modules'
            $table->foreignId('user_id')->constrained('users'); // Foreign key to 'users', renamed 'user_id' for consistency
            $table->primary(['module_id', 'user_id']); // Composite primary key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('module_teacher');
    }
};

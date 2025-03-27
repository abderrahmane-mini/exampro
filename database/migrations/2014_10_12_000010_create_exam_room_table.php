<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exam_room', function (Blueprint $table) {
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->primary(['exam_id', 'room_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_room');
    }
};
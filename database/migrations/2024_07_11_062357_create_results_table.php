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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->char('roll_no')->unique();
            $table->string('student_name');
            $table->integer('myanmar');
            $table->integer('english');
            $table->integer('mathematics');
            $table->integer('chemistry');
            $table->integer('physics');
            $table->integer('biological');
            $table->integer('region_id');
            $table->integer('township_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};

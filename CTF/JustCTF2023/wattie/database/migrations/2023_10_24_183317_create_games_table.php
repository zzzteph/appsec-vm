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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
			$table->integer('score')->default(0);
			$table->integer('temp_score')->default(0);
			$table->enum('status', ['started', 'running','done'])->default('started');
			$table->enum('difficulty', ['easy', 'hard'])->default('easy');
			$table->date('finished_at')->default(NULL);
			$table->date('started_at')->default(NULL);
			$table->integer('time_left')->default(120);
			$table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
			
			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

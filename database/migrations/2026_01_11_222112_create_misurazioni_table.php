<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('misurazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('peso', 5, 2);
            $table->date('data');
            $table->time('ora');
            $table->foreignId('strumento_id')->nullable()->constrained('strumenti')->onDelete('set null');
            $table->boolean('stomaco_vuoto')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('misurazioni');
    }
};
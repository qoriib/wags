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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->string('sample_no')->unique();
            $table->date('test_date');
            $table->string('operator');
            $table->decimal('fe2o3', 10, 4)->nullable();
            $table->decimal('cao', 10, 4)->nullable();
            $table->decimal('sio2', 10, 4)->nullable();
            $table->decimal('al2o3', 10, 4)->nullable();
            $table->decimal('caco3', 10, 4)->nullable();
            $table->decimal('loi', 10, 4)->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};

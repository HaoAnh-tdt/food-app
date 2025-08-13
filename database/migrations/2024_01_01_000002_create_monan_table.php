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
        Schema::create('monan', function (Blueprint $table) {
            $table->string('mamonan', 10)->primary();
            $table->string('tenmonan', 100);
            $table->decimal('giamonan', 10, 2);
            $table->string('maloai', 10);
            $table->text('mota')->nullable();
            $table->timestamps();
            
            $table->foreign('maloai')->references('maloai')->on('loaimonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monan');
    }
};

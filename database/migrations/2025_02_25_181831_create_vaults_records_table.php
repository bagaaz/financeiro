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
        Schema::create('vault_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vault_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('type');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaults_records');
    }
};

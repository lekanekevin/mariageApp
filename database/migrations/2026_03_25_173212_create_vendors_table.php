<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nom de l'entreprise ou du prestataire
            $table->string('category'); // Traiteur, DJ, Location, etc.
            $table->decimal('price', 15, 2)->default(0); // Prix convenu
            $table->decimal('paid_amount', 15, 2)->default(0); // Ce qui a déjà été payé (acompte)
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};

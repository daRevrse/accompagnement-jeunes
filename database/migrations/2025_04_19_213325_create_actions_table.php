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
      Schema::create('actions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('promoteur_id')->constrained()->onDelete('cascade');
    $table->date('date_action');
    $table->decimal('chiffre_affaires', 15, 2)->nullable();
    $table->decimal('charge', 15, 2)->nullable();
    $table->integer('nombre_emplois')->nullable();
    $table->boolean('entreprise_active')->default(true);
    $table->string('raison_inactivite')->nullable();
    $table->enum('arret_activite', ['provisoire', 'definitif'])->nullable();
    $table->text('investissements')->nullable();
    $table->string('situation_credit')->nullable();
    $table->text('difficultes')->nullable();
    $table->text('solutions')->nullable();
    $table->text('action_faiej')->nullable();
    $table->date('date_echeance_action')->nullable();
    $table->text('observations')->nullable();
    $table->text('perspectives')->nullable();
    $table->text('commentaire')->nullable();
    $table->text('actions_prevues')->nullable();
    $table->integer('delais')->nullable();
    $table->string('type_suivi')->nullable();
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};

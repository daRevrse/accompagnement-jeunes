<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            // $table->decimal('charge', 15, 2)->nullable();
            $table->decimal('nouveaux_investissement', 15, 2)->nullable();
            // $table->string('situation_credit')->nullable();
            // $table->text('difficultes')->nullable();
            // $table->text('action_faiej')->nullable();
            // $table->text('observations')->nullable();
            // $table->date('date_echeance_action')->nullable();
            // $table->string('type_suivi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn([
                // 'charge',
                'nouveaux_investissement',
                // 'situation_credit',
                // 'difficultes',
                // 'action_faiej',
                // 'observations',
                // 'date_echeance_action',
                // 'type_suivi',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('departement');
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('departement_id')->nullable()->after('patient_id')->constrained('departements')->onDelete('cascade');
            $table->foreignId('medecin_id')->nullable()->after('departement_id')->constrained('medecins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['departement_id']);
            $table->dropForeign(['medecin_id']);
            $table->dropColumn(['patient_id', 'departement_id', 'medecin_id']);
            $table->string('departement');
        });
    }
};
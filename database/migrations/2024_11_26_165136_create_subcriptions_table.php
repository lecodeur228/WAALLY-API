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
        Schema::create('subcriptions', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2024_11_26_165136_create_subcriptions_table.php
            $table->date('begin_date');
            $table->date('end_date');
            $table->integer('duration');
=======
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('dure');
            $table->integer('state')->default(0);
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a:database/migrations/2024_11_26_165136_create_abonnements_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcriptions');
    }
};

<?php

<<<<<<< HEAD:database/migrations/2024_11_26_162045_create_stores_table.php
use App\Models\Boutique;
=======
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a:database/migrations/2024_11_26_162045_create_magazins_table.php
use App\Models\Shop;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignIdFor(Shop::class);
<<<<<<< HEAD:database/migrations/2024_11_26_162045_create_stores_table.php
=======
            $table->integer('state')->default(0);
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a:database/migrations/2024_11_26_162045_create_magazins_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};

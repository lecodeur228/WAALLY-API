<?php

use App\Models\Article;
use App\Models\Magazin;
use App\Models\Shop;
use App\Models\Store;
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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Store::class);
            $table->foreignIdFor(Article::class);
<<<<<<< HEAD:database/migrations/2024_11_26_164508_create_inventorieses_table.php
            $table->decimal('quantity', 10, 2);
=======
            $table->decimal('quantite', 10, 2);
            $table->integer('state')->default(0);
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a:database/migrations/2024_11_26_164508_create_inventaires_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

<?php

use App\Models\Article;
<<<<<<< HEAD
use App\Models\Boutique;
=======
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a
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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class);
            $table->foreignIdFor(Shop::class);
<<<<<<< HEAD
            $table->decimal('quantity', 10, 2);
=======
            $table->decimal('quantite', 10, 2);
            $table->integer('state')->default(0);
>>>>>>> 816cc18f2be4ce8a4f11e323feee9aa61966d17a
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

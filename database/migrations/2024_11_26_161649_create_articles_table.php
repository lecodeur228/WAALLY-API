<?php

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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
<<<<<<< HEAD
            $table->decimal('sale_price', 10, 2);
            $table->decimal('buy_price', 10, 2);
            $table->foreignIdFor(Shop::class);
=======
            $table->decimal('price_vente', 10, 2);
            $table->decimal('price_achat', 10, 2);
            $table->foreignIdFor(Shop::class);
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
        Schema::dropIfExists('articles');
    }
};

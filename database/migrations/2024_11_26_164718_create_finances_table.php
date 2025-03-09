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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['Entrer', 'Sortir']);
<<<<<<< HEAD
            $table->text('reason');
            $table->foreignIdFor(Shop::class);
=======
            $table->text('motif');
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
        Schema::dropIfExists('finances');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();

            $table->enum('type', ['product', 'service'])->default('product');

            $table->decimal('price', 10, 2)->nullable(); // display-only
            $table->boolean('available')->default(true);

            $table->timestamps();

            $table->unique(['store_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

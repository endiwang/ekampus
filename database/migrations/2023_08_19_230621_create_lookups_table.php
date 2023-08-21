<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable()->comment('Lookup category');
            $table->string('name')->nullable()->comment('Lookup name');
            $table->string('description')->nullable()->comment('Lookup description');
            $table->string('key')->index()->comment('Lookup key');
            $table->string('value')->nullable()->comment('Lookup value');
            $table->json('values')->nullable()->comment('Lookup values');
            $table->boolean('is_enabled')->default(true)->comment('Lookup is enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lookups');
    }
};

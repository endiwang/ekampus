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
        Schema::create('jabatan_hafazan_tahriri', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id');
            $table->string('juzuk')->nullable();
            $table->string('ayat')->nullable();
            $table->integer('current_page')->nullable();
            $table->integer('designated_page')->nullable();
            $table->integer('balance')->nullable();
            $table->double('current_percentage', 8,2);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('jabatan_hafazan_tahriri');
    }
};

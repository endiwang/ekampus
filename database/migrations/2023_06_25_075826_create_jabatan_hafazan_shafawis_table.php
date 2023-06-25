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
        Schema::create('jabatan_hafazan_shafawi', function (Blueprint $table) {
            $table->id();
            $table->integer('pelajar_id');
            $table->string('surah')->nullable();
            $table->string('juzuk')->nullable();
            $table->string('maqra')->nullable();
            $table->integer('ayat_awal')->nullable();
            $table->integer('ayat_akhir')->nullable();
            $table->integer('current_page')->nullable();
            $table->integer('page_end')->nullable();
            $table->longText('remarks')->nullable();
            $table->integer('page_remaining')->nullable();
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
        Schema::dropIfExists('jabatan_hafazan_shafawi');
    }
};

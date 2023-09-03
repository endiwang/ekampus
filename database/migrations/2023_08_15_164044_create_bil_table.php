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
        Schema::create('bil', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no')->nullable();
            $table->integer('pelajar_id')->nullable();
            $table->integer('yuran_id')->nullable();
            $table->string('description')->nullable();
            $table->double('amaun', 10, 2)->nullable();
            $table->integer('status')->nullable()->comment('1-Unpaid; 2-Paid');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bil');
    }
};

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
        Schema::create('temuduga_markah', function (Blueprint $table) {
            $table->id();
            $table->integer('temuduga_id')->nullable();
            $table->integer('permohonan_id')->nullable();
            $table->integer('kursus_id')->nullable();
            $table->integer('pusat_temuduga_id')->nullable();
            $table->char('temuduga_type')->nullable()->default('B');
            $table->float('hafazan', 5, 2)->nullable()->default(0.00);
            $table->float('sikap', 5, 2)->nullable()->default(0.00);
            $table->float('koku', 5, 2)->nullable()->default(0.00);
            $table->float('akademik', 5, 2)->nullable()->default(0.00);
            $table->float('akhlak', 5, 2)->nullable()->default(0.00);
            $table->float('tajwid', 5, 2)->nullable()->default(0.00);
            $table->float('ba', 5, 2)->nullable()->default(0.00);
            $table->float('uia', 5, 2)->nullable()->default(0.00);
            $table->decimal('pcts', 5, 2)->nullable()->default(0.00);
            $table->decimal('suara', 4, 1)->nullable()->default(0.0);
            $table->decimal('fasolah', 4, 1)->nullable()->default(0.0);
            $table->float('jumlah', 7, 2)->nullable()->default(0.00);
            $table->text('catatan')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('temuduga_markah');
    }
};

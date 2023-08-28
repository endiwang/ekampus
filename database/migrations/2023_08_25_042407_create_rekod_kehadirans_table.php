<?php

use App\Models\PusatIslam\KelasOrangAwam;
use App\Models\PusatIslam\PesertaKelasOrangAwam;
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
        Schema::create('pi_rekod_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(KelasOrangAwam::class);
            $table->foreignIdFor(PesertaKelasOrangAwam::class);
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('pi_rekod_kehadiran');
    }
};

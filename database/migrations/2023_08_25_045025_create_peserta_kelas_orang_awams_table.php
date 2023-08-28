<?php

use App\Models\PusatIslam\KelasOrangAwam;
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
        Schema::create('pi_peserta_kelas_orang_awam', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(KelasOrangAwam::class);
            $table->string('nama');
            $table->string('email')->unique()->index();
            $table->string('no_phone')->nullable();
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
        Schema::dropIfExists('pi_peserta_kelas_orang_awam');
    }
};

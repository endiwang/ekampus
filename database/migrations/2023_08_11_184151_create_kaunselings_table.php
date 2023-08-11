<?php

use App\Enums\StatusKaunseling;
use App\Models\User;
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
        Schema::create('kaunseling', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('no_permohonan')->nullable()->index();
            $table->date('tarikh_permohonan')->nullable();
            $table->string('jenis_fasiliti')->nullable();
            $table->string('status')->nullable()->default(StatusKaunseling::belumDihantar()->value);
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
        Schema::dropIfExists('kaunseling');
    }
};

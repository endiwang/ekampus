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
        Schema::table('staff', function (Blueprint $table) {
            $table->char('is_pensyarah_jemputan')->nullable()->after('is_pensyarah')->default('N');
            $table->char('is_tutor')->nullable()->after('is_pensyarah_jemputan')->default('N');
            $table->char('is_hep')->nullable()->after('is_warden')->default('N');
            $table->char('is_guru_tasmik')->nullable()->after('is_hep')->default('N');
            $table->char('is_guru_tasmik_jemputan')->nullable()->after('is_guru_tasmik')->default('N');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            Schema::dropIfExists('is_pensyarah_jemputan');
            Schema::dropIfExists('is_tutor');
            Schema::dropIfExists('is_hep');
            Schema::dropIfExists('is_guru_tasmik');
            Schema::dropIfExists('is_guru_tasmik_jemputan');
        });
    }
};

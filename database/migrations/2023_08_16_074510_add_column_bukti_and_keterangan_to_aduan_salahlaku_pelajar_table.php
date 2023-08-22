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
        Schema::table('aduan_salahlaku_pelajar', function (Blueprint $table) {
            $table->string('bukti_2')->after('bukti')->nullable();
            $table->string('bukti_3')->after('bukti_2')->nullable();
            $table->integer('status')->after('bukti_3')->default(0)->comment('0 aduan baru, 1 sisatan, 2 aduan di tutup');
            $table->integer('pelaku_pelajar_id')->after('status')->nullable();
            $table->string('update_by')->nullable()->after('pelaku_pelajar_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aduan_salahlaku_pelajar', function (Blueprint $table) {
            $table->dropColumn('bukti_2');
            $table->dropColumn('bukti_3');
            $table->dropColumn('status');
            $table->dropColumn('pelaku_pelajar_id');
            $table->dropColumn('updated_by');
        });
    }
};

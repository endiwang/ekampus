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
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->integer('pemohon_id')->nullable()->after('pelajar_id');
            $table->string('name')->nullable()->after('pemohon_id');
            $table->string('ic_no')->nullable()->after('name');
            $table->date('dob')->nullable()->after('ic_no');
            $table->integer('age')->nullable()->after('dob');
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->integer('negeri_id')->nullable();
            $table->integer('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->integer('status_terima_sijil')->nullable()->default(0);
            $table->timestamp('tarikh_jana_sijil')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonan_sijil_tahfizs', function (Blueprint $table) {
            $table->dropColumn('pemohon_id');
            $table->dropColumn('name');
            $table->dropColumn('ic_no');
            $table->dropColumn('dob');
            $table->dropColumn('age');
            $table->dropColumn('address');
            $table->dropColumn('postcode');
            $table->dropColumn('negeri_id');
            $table->dropColumn('phone_no');
            $table->dropColumn('email');
            $table->dropColumn('status_terima_sijil');
            $table->dropColumn('tarikh_jana_sijil');
        });
    }
};

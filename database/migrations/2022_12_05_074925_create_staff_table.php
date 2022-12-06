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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('staff_id')->default(0)->comment('id dari db lama');
            $table->string('name')->nullable();
            $table->integer('pusat_pengajian_id')->nullable()->default(1);
            $table->char('jawatan')->nullable()->default('P');
            $table->string('gred')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->char('jantina')->nullable();
            $table->char('warganegara')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('alamat')->nullable();
            $table->string('no_tel')->nullable();
            $table->string('email')->nullable();
            $table->string('no_ic')->nullable();
            $table->string('img_staff')->nullable();
            $table->string('is_pensyarah')->nullable();
            $table->string('is_warden')->nullable();
            $table->integer('jabatan_id')->nullable();
            $table->string('gred_id')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('staff');
    }
};

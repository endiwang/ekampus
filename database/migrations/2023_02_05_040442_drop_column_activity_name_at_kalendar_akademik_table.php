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
        Schema::table('kalendar_akademik', function (Blueprint $table) {
            $table->dropIfExists('activity_name');
            $table->dropIfExists('start_date');
            $table->dropIfExists('end_date');
            $table->dropIfExists('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

<?php

use App\Models\Yuran;
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
        Schema::table('yuran', function (Blueprint $table) {
            $table->integer('is_fixed')->nullable()->after('status');
        });

        Yuran::where('id', '<=', 5)->update(['is_fixed' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yuran', function (Blueprint $table) {
            $table->dropColumn('is_fixed');
        });
    }
};

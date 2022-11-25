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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_staff')->after('remember_token')->default(0);
            $table->tinyInteger('is_alumni')->after('is_staff')->default(0);
            $table->tinyInteger('is_student')->after('is_alumni')->default(0);
            $table->tinyInteger('is_suspended')->after('is_student')->default(0);
            $table->string('old_student_id_number')->nullable()->comment('pelajar_id from old table _sis_tblpelajar');
            $table->string('old_staff_id_number')->nullable()->comment('staff_id from old table _sis_tblstaff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_staff');
            $table->dropColumn('is_alumni');
            $table->dropColumn('is_student');
            $table->dropColumn('is_suspended');
            $table->dropColumn('old_staff_id_number');
            $table->dropColumn('old_student_id_number');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }
};

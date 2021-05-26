<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessHoursSlaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sla_plan', 'business_hours')) {
            Schema::table(
                'sla_plan',
                function (Blueprint $table) {
                    $table->text('business_hours');
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sla_plan', 'business_hours')) {
            Schema::table(
                'sla_plan',
                function (Blueprint $table) {
                    $table->dropColumn('business_hours');
                }
            );
        }
    }
}

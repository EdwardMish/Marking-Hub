<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->renameColumn('state', 'state_id');
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->tinyInteger('audience_size_id')->after('state_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->renameColumn('state_id', 'state');
            $table->dropColumn('audience_size_id');
        });
    }
}

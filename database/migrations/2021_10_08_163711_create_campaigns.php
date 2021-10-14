<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('project_id');
            $table->longText('thumbnail_url')->nullable();
            $table->tinyInteger('state')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('campaigns_state', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('campaigns_state')->insert(
            [
                [
                    'id' => '1',
                    'name' => 'Created'
                ],
                [
                    'id' => '10',
                    'name' => 'Processing'
                ],
                [
                    'id' => '20',
                    'name' => 'Delayed'
                ],
                [
                    'id' => '30',
                    'name' => 'Complete'
                ],
            ]
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaigns_state');
    }
}

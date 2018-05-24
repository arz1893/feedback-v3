<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDataRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_data_rights', function (Blueprint $table) {
            $table->uuid('usergroupid')->primary();
            $table->boolean('create')->default(1);
            $table->boolean('edit')->default(1);
            $table->boolean('delete')->default(1);
            $table->boolean('view')->default(1);
            $table->timestamps();

            $table->foreign('usergroupid')->references('systemId')->on('user_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_data_rights');
    }
}

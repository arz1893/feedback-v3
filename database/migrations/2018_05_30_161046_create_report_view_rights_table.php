<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportViewRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_view_rights', function (Blueprint $table) {
            $table->uuid('usergroupid')->primary();
            $table->boolean('view')->default(0);
            $table->boolean('action')->default(0);
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
        Schema::dropIfExists('report_view_rights');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCrudRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_crud_rights', function (Blueprint $table) {
            $table->uuid('usergroupid')->primary();
            $table->boolean('create');
            $table->boolean('edit');
            $table->boolean('delete');
            $table->boolean('view');
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
        Schema::dropIfExists('customer_crud_rights');
    }
}

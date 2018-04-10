<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_services', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->integer('customer_rating');
            $table->text('customer_feedback');
            $table->boolean('is_need_call')->default(0);
            $table->boolean('is_urgent')->default(0);
            $table->uuid('customerId')->nullable();
            $table->uuid('serviceId');
            $table->integer('serviceCategoryId')->unsigned();
            $table->uuid('tenantId');
            $table->boolean('is_answered');
            $table->text('attachment')->nullable();
            $table->uuid('syscreator');
            $table->uuid('sysupdater')->nullable();
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('serviceId')->references('systemId')->on('services')->onDelete('cascade');
            $table->foreign('serviceCategoryId')->references('id')->on('service_categories')->onDelete('cascade');
            $table->foreign('tenantId')->references('systemId')->on('tenants')->onDelete('cascade');
            $table->foreign('syscreator')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('sysupdater')->references('systemId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_services');
    }
}

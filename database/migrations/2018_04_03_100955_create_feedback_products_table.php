<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_products', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->integer('customer_rating');
            $table->text('customer_complaint');
            $table->boolean('is_need_call')->default(0);
            $table->boolean('is_urgent')->default(0);
            $table->uuid('customerId');
            $table->uuid('productId');
            $table->integer('productCategoryId')->unsigned();
            $table->uuid('tenantId');
            $table->boolean('is_answered')->default(0);
            $table->text('attachment')->nullable();
            $table->uuid('syscreator')->nullable();
            $table->uuid('sysupdater')->nullable();
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('productId')->references('systemId')->on('products')->onDelete('cascade');
            $table->foreign('productCategoryId')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('tenantId')->references('systemId')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_products');
    }
}

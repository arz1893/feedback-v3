<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackProductRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_product_replies', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->text('reply_content');
            $table->uuid('parentId')->nullable();
            $table->uuid('customerId')->nullable();
            $table->uuid('feedbackProductId');
            $table->text('attachment')->nullable();
            $table->uuid('syscreator');
            $table->uuid('sysupdater')->nullable();
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('feedbackProductId')->references('systemId')->on('feedback_products')->onDelete('cascade');
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
        Schema::dropIfExists('feedback_product_replies');
    }
}

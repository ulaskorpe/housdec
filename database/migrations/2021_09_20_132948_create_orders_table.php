<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('provider_id');
            $table->tinyInteger('status')->default(0);
            $table->date('order_date');
            $table->integer('order_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->float('amount');
            $table->date('invoice_date')->nullable()->default(null);
            $table->integer('invoice_id')->default(0);
            $table->string('product_list')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

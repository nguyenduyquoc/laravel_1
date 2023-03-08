<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrders extends Migration
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
            $table->decimal('grand_total',12,4);
            $table->tinyInteger('status');
            $table->text('shipping_address');
            $table->string('customer_tel', 20);
            $table->string('fullname', 100);
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('postcode', 12)->nullable();
            $table->string('email');
            $table->string('note')->nullable();
            $table->boolean('payed')->default(false);
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

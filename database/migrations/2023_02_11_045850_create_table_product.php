<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("thumbnail")->nullable();
            $table->decimal("price",12,4)->default(0);
            $table->unsignedInteger("quantity")->default(0);
            $table->text("description")->nullable();
            $table->string("unit",50);
            $table->boolean("status")->default(true);
            $table->unsignedBigInteger("category_id");// kiểu dữ liệu  khớp với -> id()
            $table->foreign("category_id")->references("id")->on("categories");
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
        Schema::dropIfExists('products');
    }
}

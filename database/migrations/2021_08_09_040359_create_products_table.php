<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('code', 150)->unique();
            $table->string('unit', 50);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletesTz();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('item_sku',40)->unique();
            $table->text('item_name')->nullable();
            $table->text('standard_price')->nullable();
            $table->text('main_image_url')->nullable();
            $table->text('swatch_image_url')->nullable();
            $table->text('other_image_url1')->nullable();
            $table->text('other_image_url2')->nullable();
            $table->text('other_image_url3')->nullable();
            $table->text('other_image_url4')->nullable();
            $table->text('other_image_url5')->nullable();
            $table->text('other_image_url6')->nullable();
            $table->text('other_image_url7')->nullable();
            $table->text('other_image_url8')->nullable();
            $table->text('other_image_url9')->nullable();
            $table->text('other_image_url10')->nullable();
            $table->text('parent_child')->nullable();
            $table->text('relationship_type')->nullable();
            $table->text('parent_sku')->nullable();
            $table->text('variation_theme')->nullable();
            $table->text('product_description')->nullable();
            $table->text('bullet_point1')->nullable();
            $table->text('bullet_point2')->nullable();
            $table->text('bullet_point3')->nullable();
            $table->text('bullet_point4')->nullable();
            $table->text('bullet_point5')->nullable();
            $table->text('color_name')->nullable();
            $table->text('color_map')->nullable();
            $table->text('size_name')->nullable();
            $table->text('size_map')->nullable();
            $table->integer('keyword_id')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeecategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feecategory', function (Blueprint $table) {
            $table->id();
            $table->string('fee_category');
            $table->longText('description')->nullable();
            $table->date('date_created')->nullable();
            $table->boolean('active')->default(1);
            $table->bigInteger('br_id');
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
        Schema::dropIfExists('feecategory');
    }
}

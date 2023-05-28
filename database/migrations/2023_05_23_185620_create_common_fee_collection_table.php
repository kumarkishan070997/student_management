<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonFeeCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_fee_collection', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id')->nullable();
            $table->bigInteger('branch_id');
            $table->string('adm_no')->nullable();
            $table->string('roll_no');
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('amount_to_pay')->default(0);
            $table->string('academic_year');
            $table->string('receipt_no')->nullable();
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
        Schema::dropIfExists('common_fee_collection');
    }
}

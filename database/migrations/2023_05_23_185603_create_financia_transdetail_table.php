<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanciaTransdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financia_transdetail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('financial_trans_id');
            $table->bigInteger('module_id')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->string('crdr')->nullable();
            $table->string('trans_reference_id')->nullable();
            $table->string('old_trans_id')->nullable();
            $table->boolean('is_taxable')->default(0);
            $table->bigInteger('branch_id');
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
        Schema::dropIfExists('financia_transdetail');
    }
}

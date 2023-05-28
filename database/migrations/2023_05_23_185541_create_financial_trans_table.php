<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_trans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id')->nullable();
            $table->string('trans_id');
            $table->string('account_type')->nullable();
            $table->bigInteger('amount');
            $table->string('account_id')->nullable();
            $table->string('crdr')->nullable();
            $table->date('trans_date');
            $table->date('created_date');
            $table->string('academic_year');
            $table->boolean('is_challan')->default(0);
            $table->string('chalan_no')->nullable();
            $table->date('chalan_date')->nullable();
            $table->string('chalan_gen_by')->nullable();
            $table->string('trans_type')->nullable();
            $table->boolean('trans_on_bank')->default(0);
            $table->string('remark')->nullable();
            $table->string('member_class_id')->nullable();
            $table->string('fee_category')->nullable();
            $table->string('member_status')->nullable();
            $table->string('erp_sync')->nullable();
            $table->string('adjust_from')->nullable();
            $table->string('adjust_receipt_no')->nullable();
            $table->bigInteger('adjust_amount')->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('financial_trans');
    }
}

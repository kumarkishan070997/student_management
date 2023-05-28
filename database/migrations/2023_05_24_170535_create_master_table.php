<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('academic_year');
            $table->string('session');
            $table->string('allted_category')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('roll_no');
            $table->string('adm_no')->nullable();
            $table->string('status');
            $table->string('fee_category')->nullable();
            $table->string('faculty')->nullable();
            $table->string('program')->nullable();
            $table->string('department')->nullable();
            $table->string('batch')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('fee_head')->nullable();
            $table->bigInteger('due_amount')->default(0);
            $table->bigInteger('paid_amount')->default(0);
            $table->bigInteger('concession')->default(0);
            $table->bigInteger('scholarship')->default(0);
            $table->bigInteger('reverse_concession_amount')->default(0);
            $table->bigInteger('write_off_amount')->default(0);
            $table->bigInteger('adjusted_amount')->default(0);
            $table->bigInteger('refunded_amount')->default(0);
            $table->bigInteger('fund_transfer_amount')->default(0);
            $table->longText('remark')->nullable();
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
        Schema::dropIfExists('master');
    }
}

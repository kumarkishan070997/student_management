<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;
    protected $table = "master";
    protected $fillable = ['date','academic_year','session','allted_category','voucher_type','voucher_no','roll_no','adm_no','status','fee_category','faculty','program','department','batch','receipt_no','fee_head','due_amount','paid_amount','concession','scholarship','reverse_concession_amount','write_off_amount','adjusted_amount','refunded_amount','fund_transfer_amount','remark'];
}

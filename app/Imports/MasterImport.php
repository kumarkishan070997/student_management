<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Master;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class MasterImport implements ToModel,WithHeadingRow,WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Master([
            'date'=>Carbon::createFromFormat('d-m-Y', $row['date'])->format('Y-m-d'),
            'academic_year'=>$row['academic_year'],
            'session'=>$row['session'],
            'allted_category'=>$row['alloted_category'],
            'voucher_type'=>$row['voucher_type'],
            'voucher_no'=>$row['voucher_no'],
            'roll_no'=>$row['roll_no'],
            'adm_no'=>$row['admnouniqueid'],
            'status'=>$row['status'],
            'fee_category'=>$row['fee_category'],
            'faculty'=>$row['faculty'],
            'program'=>$row['program'],
            'department'=>$row['department'],
            'batch'=>$row['batch'],
            'receipt_no'=>$row['receipt_no'],
            'fee_head'=>$row['fee_head'],
            'due_amount'=>$row['due_amount'],
            'paid_amount'=>$row['paid_amount'],
            'concession'=>$row['concession_amount'],
            'scholarship'=>$row['scholarship_amount'],
            'reverse_concession_amount'=>$row['reverse_concession_amount'],
            'write_off_amount'=>$row['write_off_amount'],
            'adjusted_amount'=>$row['adjusted_amount'],
            'refunded_amount'=>$row['refund_amount'],
            'fund_transfer_amount'=>$row['fund_trancfer_amount'],
            'remark'=>$row['remarks'],

        ]);
    }
    public function headingRow(): int
    {
        return 5406;
    }
    public function chunkSize(): int
    {
        return 200;
    }
}

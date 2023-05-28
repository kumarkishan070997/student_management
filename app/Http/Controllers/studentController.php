<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Master;
use Illuminate\Http\Request;
use App\Imports\MasterImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class studentController extends Controller
{
    public function store(Request $request){
        try{
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', '0');

            $filename = uniqid().".csv";
            $filepath = Storage::path('files/'.$filename);

            // file is now available in out storage folder

            Excel::import(new MasterImport, $filepath);
            
            // now data is inserted in masters table in our database
            // fetching data from masters table and distributing it to other tables.
            $data = Master::get()->groupBy(['faculty','roll_no']);
            foreach($data as $key => $val){
                foreach($val as $vkey => $roll_val){
                    $adjusted_amount = 0;
                    $unique_id = uniqid();
                    $total_amount = 0;
                    $total_collection_amount = 0;
                    foreach($roll_val as $rkey => $value){
                        // inserting in branches table
                        $check_branch_exist = Db::table('branches')->where('branch_name',$value['faculty'])->first();
                        if(!$check_branch_exist || $check_branch_exist == null){
                            $branch_id = DB::table('branches')->insertGetId([
                                'branch_name'=>$value['faculty']
                            ]);
                        }
                        else{
                            $branch_id = $check_branch_exist->id;
                        }
                        // inserting in fee category table
                        $check_fee_type = DB::table('feecategory')->where('fee_category',$value['fee_category'])->where('br_id',$branch_id)->first();
                        if(!$check_fee_type || $check_fee_type == null){
                            $fee_category_id = DB::table('feecategory')->insertGetId([
                                'fee_category'=>$value['fee_category'],
                                'description'=>null,
                                'date_created'=>Carbon::now()->toDateString(),
                                'active'=>1,
                                'br_id'=>$branch_id
                            ]);
                        }else{
                            $fee_category_id = $check_fee_type->id;
                        }
                        // inserting in fee collection type
                        $check_fee_collection = DB::table('feecollectiontype')->where('collection_head',$value['fee_head'])
                                                ->where('br_id',$branch_id)->first();
                        if(!$check_fee_collection || $check_fee_collection == null){
                            $fee_collection_id = DB::table('feecollectiontype')->insertGetId([
                                'collection_head'=>$value['fee_head'],
                                'collection_description'=>null,
                                'br_id'=>$branch_id
                            ]);
                        }else{
                            $fee_collection_id = $check_fee_collection->id;
                        }
                        // inserting in financial_trans detail
                        DB::table('financia_transdetail')->insert([
                            'financial_trans_id'=>$unique_id,
                            'module_id'=>1,
                            'amount'=>$value['paid_amount'] ?? 0,
                            'crdr'=>'C',
                            'trans_reference_id'=>$unique_id,
                            'old_trans_id'=>$unique_id,
                            'is_taxable'=>1,
                            'branch_id'=>$branch_id
                        ]);
                        DB::table('common_fee_collection_headwise')->insert([
                            'module_id'=>1,
                            'receipt_no'=>$value['receipt_no'],
                            'br_id'=>$branch_id,
                            'head_id'=>$fee_category_id,
                            'head_type'=>$value['fee_category'],
                            'head_name'=>$value['fee_category'],
                            'amount'=>$value['paid_amount'] ?? 0
                        ]);
                        $total_amount+=$value['paid_amount'] ?? 0;
                        $academic_year = $value['academic_year'];
                        $adjusted_amount += $value['adjusted_amount'];
                        $status = $value['status'];
                        $admission_no = $value['adm_no'];
                        $date = $value['date'];
                        $roll_no = $value['roll_no'];
                        $receipt_no = $value['receipt_no'];
                        $total_collection_amount += $value['paid_amount'];

                    }
                    // inserting into financial trans table
                    DB::table('financial_trans')->insert([
                        'module_id'=>1,
                        'trans_id'=>'voucher_no',
                        'amount'=>$total_amount,
                        'account_type'=>null,
                        'account_id'=>null,
                        'crdr'=>'cr',
                        'trans_date'=>$value['date'],
                        'created_date'=>Carbon::now()->toDateString(),
                        'academic_year'=>$academic_year,
                        'is_challan'=>0,
                        'chalan_no'=>null,
                        'chalan_date'=>null,
                        'chalan_gen_by'=>null,
                        'trans_type'=>null,
                        'trans_on_bank'=>1,
                        'remark'=>null,
                        'member_class_id'=>null,
                        'fee_category'=>null,
                        'member_status'=>null,
                        'erp_sync'=>0,
                        'adjust_from'=>0,
                        'adjust_receipt_no'=>0,
                        'adjust_amount'=>$adjusted_amount,
                        'status'=>$status,
                        'branch_id'=>$branch_id,
                    ]);

                    DB::table('common_fee_collection')->insert([
                        'module_id'=>1,
                        'branch_id'=>$branch_id,
                        'adm_no'=>$admission_no,
                        'roll_no'=>$roll_no,
                        'amount'=>$total_collection_amount,
                        'amount_to_pay'=>$total_collection_amount,
                        'academic_year'=>$academic_year,
                        'receipt_no'=>$receipt_no,

                    ]);
                }
            }
            return response()->json(['response' => ['code' => '200', 'message' => 'Data uploaded successfully.']]);

        }catch(\Exception $e){
            return response()->json(['response' => ['code' => '500', 'message' => 'Unable to upload data.']]);
        }
    }
}

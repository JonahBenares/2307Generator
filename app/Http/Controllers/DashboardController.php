<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payees;
use App\Models\atc;
use App\Models\generations;
use App\Models\GenerationHead;
use App\Models\accountant;
use App\Models\GenerationAmount;
use App\Http\Requests\GenerationRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function get_dropdown(){
      
        $payees = Payees::orderBy('payee_name','ASC')->get();
        $atc = atc::orderBy('atc_code','ASC')->get();
       
        return response()->json([
           'payees'=>$payees,
           'atc'=>$atc
        ]);

      
    }

    public function get_drafts($id){
        $user_id = Auth::id();
      
        $exist_head = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->exists();

        if($exist_head){
            $head_id = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->value('id');
            $head = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->get();
            $details = generations::where('generation_head_id','=',$head_id)->get();
            
        } else {
            $head_id = $this->add_head();
            $head=[];
            $details=[];
        }
        

        return response()->json([
            'head_id'=>$head_id,
            'head'=>$head,
            'details'=>$details
         ]);

    }

    public function get_atc_details($id){
        $atc = atc::where('id','=', $id)->get();
        return response()->json($atc);

    }

    public function get_payee_details($id){
        $payee = Payees::where('id','=', $id)->get();
        return response()->json($payee);

    }

    public function get_amount($id){
        $amount = GenerationAmount::where('generation_head_id','=', $id)->get();
        return response()->json($amount);

    }

    public function get_accountant_details(){
        // $signature = $request->input('include_sign');
        $acc = accountant::where('active','=','1')->get();
        return response()->json($acc);

        // $acc_id = $acc[0]->id;
        // $acc_name = $acc[0]->accountant_name;
        // $acc_position = $acc[0]->position;

        // if($signature==1){
        //     $acc_sign = $acc[0]->signature;
        // } else {
        //     $acc_sign='';
        // }
    }


    public function add_generation(GenerationRequest $request){

     //
        //if($id == 'new'){

            $head_id = $request->input('generation_head_id');
           
            $rows = $request->input('amount');
            generations::create([
                'generation_head_id'=>$request->input('generation_head_id'),
                'date_from'=>$request->input('date_from'),
                'date_to'=>$request->input('date_to'),
                'payee_id'=>$request->input('payee_id'),
                'payee_name'=>$request->input('payee_name'),
                'registered_address'=>$request->input('registered_address'),
                'tin'=>$request->input('tin'),
                'zip_code'=>$request->input('zip_code'),
                'atc_id'=>$request->input('atc_id'),
                'atc_code'=>$request->input('atc_code'),
                'atc_remarks'=>$request->input('atc_remarks'),
                'atc_percentage'=>$request->input('atc_percentage'),
                // 'amount'=>$request->input('amount'),
                'include_sign'=>$request->input('include_sign'),
                'reference_number'=>$request->input('reference_number'),
                'accountant_id'=>$request->input('accountant_id'),
                'accountant_name'=>$request->input('accountant_name'),
                'accountant_position'=>$request->input('accountant_position'),
                'accountant_tin'=>$request->input('accountant_tin'),
                'accountant_sign'=>$request->input('accountant_sign'),
            ]);

            foreach(json_decode($rows) AS $r){
                GenerationAmount::create([
                    'generation_head_id'=>$head_id,
                    'amount'=>$r->amount
                ]);
            }
            
            return $head_id;
     
        
    }

    public function add_head(){
        $user_id = Auth::id();
        $now = date("Y-m-d H:i:s");
        if(GenerationHead::exists()) {
            $group_id = GenerationHead::max('group_id') + 1;
        } else {
            $group_id = '1';
        }

        $head_id = GenerationHead::insertGetId([
            'date_encoded' => $now,
            'group_id'=>$group_id,
            'user_id'=>$user_id,
            
        ]);

        return $head_id;
    }


    public function get_print_details($id){
        $details = generations::where('id','=',$id)->get();
        $amounts = GenerationAmount::where('generation_head_id','=',$id)->get();
        foreach($details AS $d){

            $month= date("n",strtotime($d->date_to));
            $yearQuarter = ceil($month / 3);
            $first = array(1,4,7,10);
            $second = array(2,5,8,11);
            $third = array(3,6,9,12);


            if(in_array($month, $first)){
                foreach($amounts AS $a){
                    $firstmonth[] = $a->amount;
                }
                $total_first = array_sum($firstmonth);
            } else{
                $firstmonth=[];
                $total_first="";
            }

            if(in_array($month, $second)){
                foreach($amounts AS $a){
                    $secondmonth[] = $a->amount;
                }
                $total_second = array_sum($secondmonth);
            } else{
                $secondmonth=[];
                $total_second="";
            }

            if(in_array($month, $third)){
                foreach($amounts AS $a){
                    $thirdmonth[] = $a->amount;
                }
                $total_third = array_sum($thirdmonth);
            } else{
                $thirdmonth=[];
                $total_third="";
            }
            foreach($amounts AS $a){
                $tax[] = ($a->amount * $d->atc_percentage);
            }
            $total_tax = array_sum($tax);

            if(!empty($firstmonth)){
                foreach($firstmonth AS $f){
                    $subtotal[]=$f;
                }
            }
            if(!empty($secondmonth)){
                foreach($secondmonth AS $s){
                    $subtotal[]=$s;
                }
            }
            if(!empty($thirdmonth)){
                foreach($thirdmonth AS $t){
                    $subtotal[]=$t;
                }
            }
             
            $grandtotal = array_sum($subtotal);

            if($d->include_sign == 1){
                $sign = $d->accountant_sign;
            } else {
                $sign = "";
            }

            $data[] = [
                'generation_head_id'=>$d->generation_head,
                'date_from'=>$d->date_from,
                'date_to'=>$d->date_to,
                'payee_name'=>$d->payee_name,
                'registered_address'=>$d->registered_address,
                'tin'=>$d->tin,
                'zip_code'=>$d->zip_code,
                'atc_code'=>$d->atc_code,
                'atc_remarks'=>$d->atc_remarks,
                'firstmonth'=>$firstmonth,
                'secondmonth'=>$secondmonth,
                'thirdmonth'=>$thirdmonth,
                'subtotal'=>$subtotal,
                'grandtotal'=>$grandtotal,
                'totalfirst'=>$total_first,
                'totalsecond'=>$total_second,
                'totalthird'=> $total_third,
                'tax'=>$tax,
                'totaltax'=>$total_tax,
                'accountant_name'=>$d->accountant_name,
                'accountant_tin'=>$d->accountant_tin,
                'accountant_position'=>$d->accountant_position,
                'accountant_signature'=>$sign,
                'reference_number'=>$d->reference_number
            ];
        }
        return response()->json($data);
    }

    public function save_set($id){
        $head = GenerationHead::find($id);
        $head->update([
            'status'=>'1'
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payees;
use App\Models\atc;
use App\Models\generations;
use App\Models\GenerationHead;
use App\Models\accountant;
use App\Models\GenerationAmount;
use App\Models\AmountUpdateLogs;
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

    public function dashboard(){
        if(Auth::check()){
            $credentials=[
                'name' => Auth::user()?->name,
                'temp_password' => Auth::user()?->temp_password,
            ];
        }else{
            $credentials=[
                'name' => '',
                'temp_password' => '',
            ];
        }
        return response()->json($credentials);
   }

    public function get_drafts($id, $detail_id){
        $user_id = Auth::id();
      
        $exist_head = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->exists();

        if($exist_head){
            $head_id = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->value('id');
            $head = GenerationHead::where('user_id','=', $user_id)->where('status','=','0')->get();
            $details = generations::where('generation_head_id','=',$head_id)->where('cancelled','=','0')->get();
            
        } else {
            $head_id = $this->add_head();
            $head=[];
            $details=[];
        }
        

        if($detail_id != 0){
            foreach(generations::where('generation_head_id','=',$head_id)->where('id','=',$detail_id)->where('cancelled','=','0')->get() AS $g){
                $edit_details = [
                    'detail_id'=>$g->id,
                    'generation_head_id'=>$g->generation_head_id,
                    'date_from'=>$g->date_from,
                    'date_to'=>$g->date_to,
                    'payee_id'=>$g->payee_id,
                    'payee_name'=>$g->payee_name,
                    'registered_address'=>$g->registered_address,
                    'tin'=>$g->tin,
                    'zip_code'=>$g->zip_code,
                    'tax_type'=>$g->tax_type,
                    'atc_id'=>$g->atc_id,
                    'atc_code'=>$g->atc_code,
                    'atc_remarks'=>$g->atc_remarks,
                    'atc_percentage'=>$g->atc_percentage,
                    'include_sign'=>$g->include_sign,
                    'reference_number'=>$g->reference_number,
                    'accountant_id'=>$g->accountant_id,
                    'accountant_name'=>$g->accountant_name,
                    'accountant_position'=>$g->accountant_position,
                    'accountant_tin'=>$g->accountant_tin,
                    'accountant_sign'=>$g->accountant_sign,
                ];
            }

         // $rows =  GenerationAmount::where('generation_id','=',$detail_id);
        } else {
            $edit_details = array();
            // $rows=[];
        }


        return response()->json([
            'head_id'=>$head_id,
            'head'=>$head,
            'details'=>$details,
            'edit_details'=>$edit_details,
           // 'rows'=>$rows
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

    public function get_amount($detail_id){
        $user_id = Auth::id();
        $genarray=array();
        $amount = GenerationAmount::where('generation_id','=', $detail_id)->where('user_id','=',$user_id)->get();
        foreach($amount AS $a){
            $genarray[]=[
                'id'=>$a->id,
                'quarter_month'=>$a->quarter_month,
                'amount'=>$a->amount,
                'old_amount'=>$a->amount,
            ];
        }
        return response()->json($genarray);

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
            $user_id = Auth::id();
            $rows = $request->input('amount');
            $gen_id = generations::insertGetId([
                'generation_head_id'=>$request->input('generation_head_id'),
                'date_from'=>$request->input('date_from'),
                'date_to'=>$request->input('date_to'),
                'payee_id'=>$request->input('payee_id'),
                'payee_name'=>$request->input('payee_name'),
                'registered_address'=>$request->input('registered_address'),
                'tin'=>$request->input('tin'),
                'zip_code'=>$request->input('zip_code'),
                'tax_type'=>$request->input('tax_type'),
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
                'user_id'=>$user_id,
            ]);

            foreach(json_decode($rows) AS $r){
                GenerationAmount::create([
                    'generation_head_id'=>$head_id,
                    'generation_id'=>$gen_id,
                    'quarter_month'=>$r->quarter_month,
                    'amount'=>$r->amount,
                    'user_id'=>$user_id
                ]);
            }
            
            return $head_id;
     
        
    }

    public function edit_generation(GenerationRequest $request){

        //
           //if($id == 'new'){
                $detail_id = $request->input('detail_id');
               $head_id = $request->input('generation_head_id');
               $user_id = Auth::id();
               $rows = $request->input('amount');

               $update_gen = generations::find($detail_id);

               $update_gen->update([
                    'date_from'=>$request->input('date_from'),
                    'date_to'=>$request->input('date_to'),
                    'payee_id'=>$request->input('payee_id'),
                    'payee_name'=>$request->input('payee_name'),
                    'registered_address'=>$request->input('registered_address'),
                    'tin'=>$request->input('tin'),
                    'zip_code'=>$request->input('zip_code'),
                    'tax_type'=>$request->input('tax_type'),
                    'atc_id'=>$request->input('atc_id'),
                    'atc_code'=>$request->input('atc_code'),
                    'atc_remarks'=>$request->input('atc_remarks'),
                    'atc_percentage'=>$request->input('atc_percentage'),
                    'include_sign'=>$request->input('include_sign'),
                    'reference_number'=>$request->input('reference_number'),
                    'accountant_id'=>$request->input('accountant_id'),
                    'accountant_name'=>$request->input('accountant_name'),
                    'accountant_position'=>$request->input('accountant_position'),
                    'accountant_tin'=>$request->input('accountant_tin'),
                    'accountant_sign'=>$request->input('accountant_sign'),
                ]);

                $amount = GenerationAmount::where('generation_id', '=', $detail_id);
                $amount->delete();


               foreach(json_decode($rows) AS $r){
                   GenerationAmount::create([
                       'generation_head_id'=>$head_id,
                       'generation_id'=>$detail_id,
                       'quarter_month'=>$r->quarter_month,
                       'amount'=>$r->amount,
                       'user_id'=>$user_id
                   ]);

                   if($r->amount != $r->old_amount){
                        AmountUpdateLogs::create([
                            'date_updated'=>date("Y-m-d H:i:s"),
                            'generation_head_id'=>$head_id,
                            'generation_id'=>$detail_id,
                            'quarter_month'=>$r->quarter_month,
                            'old_amount'=>$r->old_amount,
                            'new_amount'=>$r->amount,
                            'user_id'=>$user_id
                        ]);
                   }
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
        $tax_type = generations::where('id','=',$id)->value('tax_type');
        $firstmonth = GenerationAmount::where('generation_id','=',$id)->where('quarter_month','=','1')->get();
        $secondmonth = GenerationAmount::where('generation_id','=',$id)->where('quarter_month','=','2')->get();
        $thirdmonth = GenerationAmount::where('generation_id','=',$id)->where('quarter_month','=','3')->get();

        $subtotal_first=array();
        $subtotal_second=array();
        $subtotal_third=array();
      
        $flength=0;
        $slength=0;
        $tlength=0;
        if(!empty($firstmonth)){
            foreach($firstmonth AS $f){
                if($tax_type == 'Vat'){
                    $subtotal_first[]=$f->amount / 1.12;
                }else{
                    $subtotal_first[]=$f->amount;
                }
                $flength++;
            }
        }
        if(!empty($secondmonth)){
            foreach($secondmonth AS $s){
                if($tax_type == 'Vat'){
                    $subtotal_second[]=$s->amount / 1.12;
                }else{
                    $subtotal_second[]=$s->amount;
                }
                $slength++;
            }
        }
        if(!empty($thirdmonth)){
            foreach($thirdmonth AS $t){
                if($tax_type == 'Vat'){
                    $subtotal_third[]=$t->amount / 1.12;
                }else{
                    $subtotal_third[]=$t->amount;
                }
                $tlength++;
            }
        }

        $length = array($flength, $slength, $tlength);
        $max = max($length);
       
        $grandtotal = array_sum($subtotal_first) + array_sum($subtotal_second) + array_sum($subtotal_third);
      
        
        foreach($details AS $d){
          
            if($d->include_sign == 1){
                $sign = $d->accountant_sign;
            } else {
                $sign = "";
            }
            //$tax=0;
            $tax=array();
            $subtotal=array();
            for($x=0;$x<=10;$x++){
                if(!empty($subtotal_first[$x])) $subtotal_f =$subtotal_first[$x];
                else  $subtotal_f = 0;

                if(!empty($subtotal_second[$x])) $subtotal_s =$subtotal_second[$x];
                else  $subtotal_s = 0;

                if(!empty($subtotal_third[$x])) $subtotal_t =$subtotal_third[$x];
                else  $subtotal_t = 0;
               
                $tax[] = ($subtotal_f + $subtotal_s + $subtotal_t) * $d->atc_percentage;
                $subtotal[] = $subtotal_f + $subtotal_s + $subtotal_t;
            }      

            $total_tax = array_sum($tax);
            $data[] = [
                'generation_head_id'=>$d->generation_head,
                'date_from'=>$d->date_from,
                'date_to'=>$d->date_to,
                'payee_name'=>$d->payee_name,
                'registered_address'=>$d->registered_address,
                'tin'=>$d->tin,
                'loop'=>$max,
                'zip_code'=>$d->zip_code,
                'tax_type'=>$d->tax_type,
                'atc_code'=>$d->atc_code,
                'atc_remarks'=>$d->atc_remarks,
                'firstmonth'=>$firstmonth,
                'secondmonth'=>$secondmonth,
                'thirdmonth'=>$thirdmonth,
                'subtotal_first'=>array_sum($subtotal_first),
                'subtotal_second'=>array_sum($subtotal_second),
                'subtotal_third'=>array_sum($subtotal_third),
                'subtotal'=>$subtotal,
                'grandtotal'=>$grandtotal,
                'tax'=>$tax,
                'totaltax'=>$total_tax,
                'accountant_name'=>$d->accountant_name,
                'accountant_tin'=>$d->accountant_tin,
                'accountant_position'=>$d->accountant_position,
                'accountant_signature'=>$sign,
                'reference_number'=>$d->reference_number,
                'company_name'=>COMPANY_NAME,
                'company_address'=>COMPANY_ADDRESS,
                'company_tin'=>COMPANY_TIN,
                'company_zip'=>COMPANY_ZIP,
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


    public function get_print_all($id){
        $details = generations::where('generation_head_id','=',$id)->get();
        
        foreach($details AS $d){

            $firstmonth = GenerationAmount::where('generation_id','=',$d->id)->where('quarter_month','=','1')->get();
            $secondmonth = GenerationAmount::where('generation_id','=',$d->id)->where('quarter_month','=','2')->get();
            $thirdmonth = GenerationAmount::where('generation_id','=',$d->id)->where('quarter_month','=','3')->get();
    
            $subtotal_first=array();
            $subtotal_second=array();
            $subtotal_third=array();
            $flength=0;
            $slength=0;
            $tlength=0;
             
            if(!empty($firstmonth)){
                foreach($firstmonth AS $f){
                    if($d->tax_type == 'Vat'){
                        $subtotal_first[]=$f->amount / 1.12;
                    }else{
                        $subtotal_first[]=$f->amount;
                    }
                    $flength++;
                }
            }
            if(!empty($secondmonth)){
                foreach($secondmonth AS $s){
                    if($d->tax_type == 'Vat'){
                        $subtotal_second[]=$s->amount / 1.12;
                    }else{
                        $subtotal_second[]=$s->amount;
                    }
                    $slength++;
                }
            }
            if(!empty($thirdmonth)){
                foreach($thirdmonth AS $t){
                    if($d->tax_type == 'Vat'){
                        $subtotal_third[]=$t->amount / 1.12;
                    }else{
                        $subtotal_third[]=$t->amount;
                    }
                    $tlength++;
                }
            }
            $length = array($flength, $slength, $tlength);
            $max = max($length);

            $grandtotal = array_sum($subtotal_first) + array_sum($subtotal_second) + array_sum($subtotal_third);

            if($d->include_sign == 1){
                $sign = $d->accountant_sign;
            } else {
                $sign = "";
            }
            //$tax=0;
            $tax=array();
            $subtotal=array();
            for($x=0;$x<=10;$x++){
                if(!empty($subtotal_first[$x])) $subtotal_f =$subtotal_first[$x];
                else  $subtotal_f = 0;

                if(!empty($subtotal_second[$x])) $subtotal_s =$subtotal_second[$x];
                else  $subtotal_s = 0;

                if(!empty($subtotal_third[$x])) $subtotal_t =$subtotal_third[$x];
                else  $subtotal_t = 0;
               
                $tax[] = ($subtotal_f + $subtotal_s + $subtotal_t) * $d->atc_percentage;
                $subtotal[] = $subtotal_f + $subtotal_s + $subtotal_t;
            }      

            $total_tax = array_sum($tax);
            $data[] = [
                'generation_head_id'=>$d->generation_head,
                'date_from'=>$d->date_from,
                'date_to'=>$d->date_to,
                'payee_name'=>$d->payee_name,
                'registered_address'=>$d->registered_address,
                'tin'=>$d->tin,
                'loop'=>$max,
                'zip_code'=>$d->zip_code,
                'tax_type'=>$d->tax_type,
                'atc_code'=>$d->atc_code,
                'atc_remarks'=>$d->atc_remarks,
                'firstmonth'=>$firstmonth,
                'secondmonth'=>$secondmonth,
                'thirdmonth'=>$thirdmonth,
                'subtotal_first'=>array_sum($subtotal_first),
                'subtotal_second'=>array_sum($subtotal_second),
                'subtotal_third'=>array_sum($subtotal_third),
                'subtotal'=>$subtotal,
                'grandtotal'=>$grandtotal,
                'tax'=>$tax,
                'totaltax'=>$total_tax,
                'accountant_name'=>$d->accountant_name,
                'accountant_tin'=>$d->accountant_tin,
                'accountant_position'=>$d->accountant_position,
                'accountant_signature'=>$sign,
                'reference_number'=>$d->reference_number,
                'company_name'=>COMPANY_NAME,
                'company_address'=>COMPANY_ADDRESS,
                'company_tin'=>COMPANY_TIN,
                'company_zip'=>COMPANY_ZIP,
            ];
          
        }
        return response()->json($data);
    }

    public function cancel_generation($id){
        $cancel_head=generations::where('id',$id)->first();
        $cancel_data = [
            'cancelled'=>'1'
        ];
        $cancel_head->update($cancel_data);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\generations;
use App\Models\GenerationHead;
use App\Models\GenerationAmount;
use App\Models\Payees;
use App\Models\AmountUpdateLogs;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function get_payees(){
      
        $payees = Payees::orderBy('payee_name','ASC')->get();
        return response()->json($payees);
      
    }

    public function search_generation(Request $request){
       //return $request->get('date_encoded');
        $genarray=array();
        $query = generations::with(['generation_head'])->where('cancelled', '0');
        $query->whereHas('generation_head', function ($query) {
            $query->where('status', '1');
        });

            if ($request->get('date_encoded')) {
                $date_encoded=$request->get('date_encoded');
            
                $query->whereHas('generation_head', function ($query) use ($date_encoded) {
                    $query->where('date_encoded','LIKE', '%' . $date_encoded . '%');
                });
            }

            if ($request->get('date_from') && $request->get('date_to')) {
                $date_from=$request->get('date_from');
                $date_to=$request->get('date_to');
            
                $query->where('date_from','=', $date_from)->where('date_to','=', $date_to);
            }
    
            if ($request->get('payee')) {
                $payee = $request->get('payee');
                $query->where('payee_id', $payee);
            }
    
            $gen_list=$query->get();
          
            foreach($gen_list AS $gl){
                $amount_list = GenerationAmount::where('generation_id',$gl->id)->groupBy('generation_id','quarter_month')->get();

                foreach($amount_list AS $al){
                    $total_amount = GenerationAmount::where('generation_id','=',$gl->id)->where('quarter_month','=',$al->quarter_month)->sum('amount');
                    if($gl->tax_type == 'Vat'){
                        $total_tax_base = $total_amount / 1.12;
                    }else{
                        $total_tax_base = $total_amount;
                    }

                    $ewt = $total_tax_base * $gl->atc_percentage;

                    $date_updated_list = AmountUpdateLogs::where('generation_head_id','=',$al->generation_head_id)->where('generation_id','=',$al->generation_id)->where('quarter_month','=',$al->quarter_month)->get();
                    $count_date_update=$date_updated_list->count();

                    if($count_date_update == 0){
                        $date_encoded = $gl->generation_head->date_encoded;
                    }else{
                        $date_encoded = AmountUpdateLogs::where('generation_head_id','=',$al->generation_head_id)
                        ->where('generation_id','=',$al->generation_id)
                        ->where('quarter_month','=',$al->quarter_month)
                        ->orderBy('date_updated', 'DESC')->limit(1)->value('date_updated');
                    }
                    
                    $genarray[]=[
                        'generation_head_id'=>$gl->generation_head_id,
                        'id'=>$gl->id,
                        'payee_name'=>$gl->payee_name,
                        'date_encoded'=>$date_encoded,
                        'date_period'=>$gl->date_from . " to " . $gl->date_to,
                        'tin'=>$gl->tin,
                        'tax_type'=>$gl->tax_type,
                        'atc_code'=>$gl->atc_code,
                        'tax_base'=>$total_tax_base,
                        'ewt'=>$ewt,
                    ];
                }
            }
            
             return response()->json($genarray);
      
    }

    public function edit_generation($head_id, $detail_id){
       $update= GenerationHead::find($head_id);
        
        $update->update([
            'status'=>'0'
        ]);
    }
}

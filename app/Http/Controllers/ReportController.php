<?php

namespace App\Http\Controllers;
use App\Models\generations;
use App\Models\GenerationHead;
use App\Models\GenerationAmount;
use App\Models\Payees;
use App\Models\AmountUpdateLogs;
use App\Models\GenerationTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function get_payees(){
      
        $payees = Payees::orderBy('payee_name','ASC')->get();
        return response()->json($payees);
      
    }

   public function GetMonths($sStartDate, $sEndDate){  
        // Firstly, format the provided dates.  
        // This function works best with YYYY-MM-DD  
        // but other date formats will work thanks  
        // to strtotime().  
        $sStartDate = date("Y-m-d", strtotime($sStartDate));  
        $sEndDate = date("Y-m-d", strtotime($sEndDate));  
  
        // Start the variable off with the start date  
       $aDays[] = $sStartDate;  
  
       // Set a 'temp' variable, sCurrentDate, with  
       // the start date - before beginning the loop  
       $sCurrentDate = $sStartDate;  
  
       // While the current date is less than the end date  
       while($sCurrentDate < $sEndDate){  
         // Add a day to the current date  
         $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
  
         // Add this new day to the aDays array  
         $aDays[] = date('m',strtotime($sCurrentDate));  
       }  
  
       // Once the loop has finished, return the  
       // array of days.  
       return $aDays;  
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
    
            $gen_list=$query->orderBy('atc_code','ASC')->orderBy('payee_name','ASC')->orderBy('date_from','ASC')->get();
            $quarter=array();
            foreach($gen_list AS $gl){
                $amount_list = GenerationAmount::where('generation_id',$gl->id)->groupBy('generation_id','quarter_month')->get();

                foreach($amount_list AS $al){
                    $total_amount = GenerationAmount::where('generation_id','=',$gl->id)->where('quarter_month','=',$al->quarter_month)->where('cancelled','=','0')->sum('tax_base_amount');
                    // if($gl->tax_type == 'Vat'){
                    //     $total_tax_base = $total_amount / 1.12;
                    // }else{
                    //     $total_tax_base = $total_amount;
                    // }

                    $ewt = $total_amount * $gl->atc_percentage;

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

                    $first_quarter = array('01','02','03');
                    $second_quarter = array('04','05','06');
                    $third_quarter = array('07','08','09');
                    $fourth_quarter = array('10','11','12');
                    $quarter = $this->GetMonths($gl->date_from, $gl->date_to);
                        if(array_intersect($quarter, $first_quarter)){
                            $first_month = "January ".date('Y',strtotime($gl->date_to));
                            $second_month = "February ".date('Y',strtotime($gl->date_to));
                            $third_month = "March ".date('Y',strtotime($gl->date_to));
                        }else if(array_intersect($quarter, $second_quarter)){
                            $first_month = "April ".date('Y',strtotime($gl->date_to));
                            $second_month = "May ".date('Y',strtotime($gl->date_to));
                            $third_month = "June ".date('Y',strtotime($gl->date_to));
                        } else if(array_intersect($quarter, $third_quarter)){
                            $first_month = "July ".date('Y',strtotime($gl->date_to));
                            $second_month = "August ".date('Y',strtotime($gl->date_to));
                            $third_month = "September ".date('Y',strtotime($gl->date_to));
                        } else if(array_intersect($quarter, $fourth_quarter)){
                            $first_month = "October ".date('Y',strtotime($gl->date_to));
                            $second_month = "November ".date('Y',strtotime($gl->date_to));
                            $third_month = "December ".date('Y',strtotime($gl->date_to));
                        }

                    if($al->quarter_month == 1){
                        $quarter_month = $first_month;
                    }else if($al->quarter_month == 2){
                        $quarter_month = $second_month;
                    }else{
                        $quarter_month = $third_month;
                    }

                    
                    $genarray[]=[
                        'generation_head_id'=>$gl->generation_head_id,
                        'id'=>$gl->id,
                        'reference_number'=>$gl->reference_number,
                        'payee_name'=>$gl->payee_name,
                        'date_encoded'=>$date_encoded,
                        'quarter_month'=>$quarter_month,
                        'date_period'=>$gl->date_from . " to " . $gl->date_to,
                        'tin'=>$gl->tin,
                        'tax_type'=>$gl->tax_type,
                        'atc_code'=>$gl->atc_code,
                        'tax_base'=>number_format($total_amount,2),
                        'ewt'=>number_format($ewt,2),
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

    public function update_generation_total(Request $request){
        $user_id = Auth::id();
        $id = $request->input('generations_id');
        $generation_head_id = generations::where('id','=',$id)->value('generation_head_id');

        $update_gen_total = generations::find($id);

            if($request->input('first_month_total') != $request->input('original_first_month_total')){
                $update_gen_total->update([
                    'first_month_total'=>$request->input('first_month_total'),
                ]);
            }

            if($request->input('second_month_total') != $request->input('original_second_month_total')){
                $update_gen_total->update([
                    'second_month_total'=>$request->input('second_month_total'),
                ]);
            }

            if($request->input('third_month_total') != $request->input('original_third_month_total')){
                $update_gen_total->update([
                    'third_month_total'=>$request->input('third_month_total'),
                ]);
            }

            if($request->input('overall_total_amount') != $request->input('original_overall_total_amount')){
                $update_gen_total->update([
                    'overall_total_amount'=>$request->input('overall_total_amount'),
                ]);
            }

            if($request->input('overall_ewt') != $request->input('original_overall_ewt')){
                $update_gen_total->update([
                    'overall_ewt'=>$request->input('overall_ewt'),
                ]);
            }

        $gen_totals = $request->input('sub_total_ewt');
            foreach(json_decode($gen_totals) as $gt){
                if(GenerationTotal::where('generation_id','=',$id)->where('generation_head_id', '=', $generation_head_id)->where('row','=',$gt->row)->exists()){
                    $gentotal = GenerationTotal::where('generation_id','=',$id)->where('generation_head_id', '=', $generation_head_id)->where('row','=',$gt->row)->value('id');
                    $update_gentotal = GenerationTotal::find($gentotal);
                    $update_gentotal->update([
                        'sub_total'=>$gt->subtotal_amount,
                        'ewt_total'=>$gt->ewt_amount,
                    ]);
                } else {
                    $gentotal['generation_id']=$id;
                    $gentotal['generation_head_id']=$generation_head_id;
                    $gentotal['row']=$gt->row;
                    $gentotal['sub_total']=$gt->subtotal_amount;
                    $gentotal['ewt_total']=$gt->ewt_amount;
                    $gentotal['user_id']=$user_id;
                    GenerationTotal::create($gentotal);
                }
            }
    }
}
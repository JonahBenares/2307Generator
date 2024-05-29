<?php

namespace App\Http\Controllers;
use App\Models\generations;
use App\Models\Payees;
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
        $query = generations::with(['generation_head']);
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
                $genarray[]=[
                    'id'=>$gl->id,
                    'payee_name'=>$gl->payee_name,
                    'date_encoded'=>$gl->generation_head->date_encoded,
                    'date_period'=>$gl->date_from . " to " . $gl->date_to
                ];
            }
            
             return response()->json($genarray);
      
    }
}

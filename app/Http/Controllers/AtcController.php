<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\atc;
use Illuminate\Validation\Rule;

class AtcController extends Controller
{
    public function add_atc(Request $request){

        $validated=$this->validate($request,[
            'atc_code'=>['unique:atcs','required','string'],
            'remarks'=>['string'],
            'percentage'=>['required'],
        ]);
        atc::create($validated);
    }

    public function all_atc(Request $request){
        $filter=$request->get('filter');
        if($filter!=null){
            $atcs=atc::where('atc_code','LIKE',"%$filter%")
                    ->orWhere('remarks','LIKE',"%$filter%")
                    ->orWhere('percentage','LIKE',"%$filter%")
                    ->orderBy('atc_code','ASC')->paginate(10);
            
        }else{
            $atcs = atc::orderBy('atc_code','ASC')->paginate(10);
          
        }
        return response()->json($atcs);
    }

    public function search_atc(Request $request){
        $filter=$request->get('filter');
       
        if($filter!=null){
            $atcs=atc::where('atc_code','LIKE',"%$filter%")
            ->orWhere('remarks','LIKE',"%$filter%")
            ->orWhere('percentage','LIKE',"%$filter%")
            ->orderBy('atc_code','ASC')->paginate(10);
           
        }else{
            $atcs = atc::orderBy('atc_code','ASC')->paginate(10);
        }

        return response()->json($atcs);
    }

    public function edit_atc($id){
        $atcs = atc::find($id);
        return response()->json([
            'atcs'=>$atcs
        ],200);
    }

    public function update_atc(Request $request, $id){
        $atcs=atc::where('id',$id)->first();
        $validated=$this->validate($request,[
            'atc_code'=>['required', 'string',
            Rule::unique('atcs', 'atc_code')
            ->ignore($id)],
            'remarks'=>['string'],
            'percentage'=>['required'],
        ]);

        $atcs->update($validated);
    }
}

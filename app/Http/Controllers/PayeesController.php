<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payees;
use Illuminate\Validation\Rule;

class PayeesController extends Controller
{
    public function add_payee(Request $request){

        $validated=$this->validate($request,[
            'payee_name'=>['unique:payees','required','string'],
            'registered_address'=>['string'],
            'tin'=>['required'],
            'zip_code'=>['string'],
            'tax_type'=>['required'],
        ]);
        Payees::create($validated);
    }

    public function all_payee(Request $request){
        $filter=$request->get('filter');
        if($filter!=null){
            $payees=Payees::where('payee_name','LIKE',"%$filter%")
                    ->orWhere('tin','LIKE',"%$filter%")
                    ->orWhere('registered_address','LIKE',"%$filter%")
                    ->orWhere('zip_code','LIKE',"%$filter%")
                    ->orWhere('tax_type','LIKE',"%$filter%")
                    ->orderBy('payee_name','ASC')->paginate(10);
            
        }else{
            $payees = Payees::orderBy('payee_name','ASC')->paginate(10);
          
        }
        return response()->json($payees);
    }

    public function search_payee(Request $request){
        $filter=$request->get('filter');
       
        if($filter!=null){
            $payees=Payees::where('payee_name','LIKE',"%$filter%")
            ->orWhere('tin','LIKE',"%$filter%")
            ->orWhere('registered_address','LIKE',"%$filter%")
            ->orWhere('zip_code','LIKE',"%$filter%")
            ->orWhere('tax_type','LIKE',"%$filter%")
            ->orderBy('payee_name','ASC')->paginate(10);
           
        }else{
            $payees = Payees::orderBy('payee_name','ASC')->paginate(10);
        }

        return response()->json($payees);
    }

    public function edit_payee($id){
        $payees = Payees::find($id);
        return response()->json([
            'payees'=>$payees
        ],200);
    }

    public function update_payee(Request $request, $id){
        $payees=Payees::where('id',$id)->first();
        $validated=$this->validate($request,[
            'payee_name'=>['required', 'string',
            Rule::unique('payees', 'payee_name')
            ->ignore($id)],
            'registered_address'=>['string'],
            'tin'=>['required'],
            'zip_code'=>['string'],
            'tax_type'=>['string']
        ]);

        $payees->update($validated);
    }

  

}

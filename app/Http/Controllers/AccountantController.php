<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountant;
use Illuminate\Validation\Rule;

class AccountantController extends Controller
{
    public function add_accountant(Request $request){

    

        $validated=$this->validate($request,[
            'accountant_name'=>['unique:accountants','required','string'],
            'position'=>['string'],
            'tin'=>['required'],
            'active'=>['string'],
            'signature'=>['required']
        ]);

        if($request->file('signature')){
            $imagename=time().'_'.$request->file('signature')->getClientOriginalName();
            $request->file('signature')->storeAs('images',$imagename);
            //$validated['photo']=$imagename;
        } else {
            $imagename='';
        }


       // $validated['photo']=$imagename;
        Accountant::create([
            'accountant_name'=>$request->input('accountant_name'),
            'position'=>$request->input('position'),
            'tin'=>$request->input('tin'),
            'active'=>$request->input('active'),
            'signature'=>$imagename
        ]);
    }

    public function all_accountant(Request $request){
        $filter=$request->get('filter');
        if($filter!=null){
            $accountants=Accountant::where('accountant_name','LIKE',"%$filter%")
                    ->orWhere('tin','LIKE',"%$filter%")
                    ->orWhere('position','LIKE',"%$filter%")->paginate(10);
            
        }else{
            $accountants = Accountant::orderBy('active','DESC')->paginate(10);
          
        }
        return response()->json($accountants);
    }

    public function search_accountant(Request $request){
        $filter=$request->get('filter');
       
        if($filter!=null){
            $accountants=Accountant::where('accountant_name','LIKE',"%$filter%")
            ->orWhere('tin','LIKE',"%$filter%")
            ->orWhere('position','LIKE',"%$filter%")->paginate(10);
           
        }else{
            $accountants = Accountant::orderBy('active','DESC')->paginate(10);
        }

        return response()->json($accountants);
    }

    public function edit_accountant($id){
        $accountants = Accountant::find($id);
        return response()->json([
            'accountants'=>$accountants
        ],200);
    }

    public function update_accountant(Request $request, $id){
        $accountants=Accountant::where('id',$id)->first();
        $validated=$this->validate($request,[
            'accountant_name'=>['required', 'string',
            Rule::unique('accountants', 'accountant_name')
            ->ignore($id)],
            'position'=>['string'],
            'tin'=>['required'],
            'active'=>['integer']
        ]);

        $accountants->update($validated);
    }
}

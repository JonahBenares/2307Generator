<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessUnits;
use Illuminate\Validation\Rule;

class PayeesController extends Controller
{
    public function add_business(Request $request){

        $validated=$this->validate($request,[
            'payee_name'=>['unique:payees','required','string'],
            'registered_address'=>['string'],
            'tin'=>['required'],
            'zip_code'=>['string'],
        ]);
        BusinessUnits::create($validated);
    }

}

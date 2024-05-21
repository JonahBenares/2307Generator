<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BackorderHead;
use App\Models\BackorderDetails;
use App\Models\BackorderItems;
use App\Models\ReceiveHead;
use App\Models\ReceiveDetails;
use App\Models\ReceiveItems;
use App\Models\Reminders;
use App\Http\Requests\ReminderRequest;

class AuthController extends Controller
{
   public function login_form(){
        $formData = [
            'email'=>null,
            'password'=> null,
        ];

        return response()->json($formData);
   }

   public function login_process(Request $request){
       
    
   
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

         if (Auth::attempt($credentials)) {
            //$user = User::where('email', $request->email)->first();
            $user = $request->user();
           $success['token'] = $user->createToken('MyApp')->plainTextToken;
           $success['name'] = $user->name;

           $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully'
           ];

           return response()->json($response, 200);
         } else {

            $response = [
                'success' => false,
                'message' => 'Unauthorized'
           ];
           
           return response()->json($response,200);     
        }

      

   
    }

   public function change_password(){
        $credentials=[
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
        ];
        return response()->json($credentials);
    }

    public function create_credential(Request $request){
        $formData=[
            'new_password'=>'',
            'confirm_password'=>'',
        ];
        return response()->json($formData);
    }

    public function edit_password(Request $request){
        $employees=User::where('id',$request->user_id)->where('change_password','=',0)->first();
        $validated=[
            'password' => $request->password,
            'temp_password'=>null,
            'change_password'=>1
        ];
     
        $employees->update($validated);
    }

    

}

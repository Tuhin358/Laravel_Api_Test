<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserApiController extends Controller
{
    public function showUser($id=null){
        if($id==''){
            $users=User::get();
            return response()->json(['users'=>$users],200);
        }else{
            $users=User::find($id);
            return response()->json(['users'=>$users],200);

        }

    }

    public function add(Request $request){
        if($request->isMethod('post'));
        $data=$request->all();

        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',

        ];

        $customMessage=[
            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'email.email'=>'Email must be valid',
            'password.required'=>'password is required',

        ];

        $validator=Validator::make($data,$rules,$customMessage);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user=new User();
        $user->name=$data['name'];
        $user->email=$data['email'];
        $user->password=bcrypt($data['password']);
        $user->save();
        $message="User added successfully";
        return response()->json(['message'=>$message]);
    }


    public function addmul(Request $request){
        if($request->isMethod('post'));
        $data=$request->all();

        $rules=[
            'users.*.name'=>'required',
            'users.*.email'=>'required|email|unique:users',
            'users.*.password'=>'required',

        ];

        $customMessage=[
            'users.*.name.required'=>'name is required',
            'users.*.email.required'=>'Email is required',
            'users.*.email.email'=>'Email must be valide',
            'users.*.password.required'=>'password is required',

        ];
        $validetor=Validator::make($data,$rules,$customMessage);
        if($validetor->fails()){
            return response()->json($validetor->errors(),422);
        }
        foreach($data['users'] as $adduser){
            $user = new User();
            $user->name=$adduser['name'];
            $user->email=$adduser['email'];
            $user->password=bcrypt($adduser['password']);
            $user->save();

            $message='User Add OK';

        }
        return response()->json(['message'=>$message]);

    }



    public function update(Request $request,$id){

        if($request->isMethod('put'));
            $data=$request->all();

            $rules=[
                'name'=>'required',
                'password'=>'required',
            ];

            $customMessage=[
                'name.required'=>'Name is Required',
                'password.required'=>'Password is Required',
            ];


            $validetor=Validator::make($data,$rules,$customMessage);
            if($validetor->fails()){
                return response()->json([$validetor->errors()],422);

            }


            $user=User::find($id);
            $user->name=$data['name'];
            $user->password=bcrypt($data['password']);
            $user->save();
            $message='Updet OK';
            return response()->json(['message'=>$message],202);

    }


    public function delete($ids){
        $ids=explode(',',$ids);
        User::whereIn('id',$ids)->delete();
        $message='Delete Done';
        return response()->json(['message'=>$message],200);
    }



    public function deletemul(Request $request){
        if($request->isMethod('delete')){
            $data=$request->all();
            User::whereIn('id',$data['ids'])->delete();

            $message="Delete Done";
            return response()->json(['message'=>$message],200);
        }
    }



    public function registration(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();

            $rules=[
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required',

            ];

            $customMessge=[
             'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'email.email'=>'Email must be valid',
            'password.required'=>'password is required',

            ];

            $validetor=Validator::make($data,$rules,$customMessge);
            if($validetor->fails()){
                return response()->json([$validetor->errors()],422);
            }
            $user=new User();
            $user->name=$data['name'];
            $user->email=$data['email'];
            $user->password=bcrypt($data['password']);
            $user->save();

            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $user=User::where('email',$data['email'])->first();
                $access_token=$user->createToken($data['email'])->accessToken;
                User::where('email',$data['email'])->update(['access_token'=>$access_token]);
                $message='User Token Create Ok';
                return response()->json(['message'=>$message,'access_token'=>$access_token],201);
            }else{
                $message='Error it is';
                 return response()->json(['message'=>$message],422);
            }

        }

    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();

            $rules=[
                'email'=>'required|email|exists:users',
                'password'=>'required',

            ];

            $customMessge=[
            'email.required'=>'Email is required',
            'email.email'=>'Email must be valid',
            'email.exists'=>'Email does not exists',
            'password.required'=>'password is required',

            ];

            $validetor=Validator::make($data,$rules,$customMessge);
            if($validetor->fails()){
                return response()->json([$validetor->errors()],422);
            }


            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $user=User::where('email',$data['email'])->first();
                $access_token=$user->createToken($data['email'])->accessToken;
                User::where('email',$data['email'])->update(['access_token'=>$access_token]);
                $message='User successfully Login';
                return response()->json(['message'=>$message,'access_token'=>$access_token],201);
            }else{
                $message='Email or password invalid';
                 return response()->json(['message'=>$message],422);
            }

        }

    }








}

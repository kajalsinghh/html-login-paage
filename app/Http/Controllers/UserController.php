<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\singlemodel;



class UserController extends Controller
{
    public function index()
    {
        return view('exam.login');
    }

    public function register()
    {
        if(session()->has('loggedInUser')){
            return redirect('/profile');
        } else{
        return view('exam.register');
    }
}

    public function forgot()
    {
        return view('exam.forgot');
    }

    public function reset()
    {
        return view('exam.reset');
    }

    public function saveUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required|max:50',
            'email'              => 'required|email|unique:users|max:100',
            'password'           => 'required|min:6|max:50',
            'cpassword'          => 'required|min:6|same:password',
        ], [
            'cpassword.same'     => 'Password did not match!',
            'cpassword.required' => 'Confirm password is required!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => $validator->getMessageBag(),
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status'  => 200,
                'message' => 'Registered Successfully'
            ]);
        }
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:100',
            'password' => 'required|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => $validator->getMessageBag()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->put('loggedInUser', $user->id);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Success'
                    ]);
                } else {
                    return response()->json([
                        'status'  => 401,
                        'message' => 'E-mail or password is incorrect!'
                    ]);
                }
            } else {
                return response()->json([
                    'status'  => 401,
                    'message' => 'User not Found!'
                ]);
            }

        }
    }

    public function profile(){
        $data = ['userInfo' => DB::table('users')->where('id', session('loggedInUser'))->first()];
        return view('profile', $data);
    }

    public function logout(){
        if(session()->has('loggedInUser')){
            session()->pull('loggedInUser');
            return redirect('/');
        }
    }
    function profileImageUpdate(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
    
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/images/', $fileName);
    
            if ($user->picture) {
                Storage::delete('public/images/'.$user->picture);
            }
    
            $user->picture = $fileName;
            $user->save();
    
            return response()->json([
                'status'  => 200,
                'message' => 'Profile image updated successfully'
            ]);
        }
    
        return response()->json([
            'status'  => 400,
            'message' => 'No picture file provided'
        ]);
    }
    public function profileUpdate(Request $request){
        User::where('id', $request->id)->update([
            'name'     => $request->name,
            'examname' => $request->examname,
            'email'    => $request->email,
            'gender'   => $request->gender,
            'dob'      => $request->dob,
            'bio'      => $request->bio
        ]);
        return response()->json([
            'status'  => 200,
            'message' => 'Profile updated Successfully!'
        ]);
    }
}    
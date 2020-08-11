<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use Validator;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
     use AuthenticatesUsers;
     protected $username='username';
     protected $redirectTo = '/dashboard';
     protected $guard='web';

     public function getlogin()
     {
     	if(Auth::guard('web')->check()){
     		return redirect()->route('dashboard');
     	}
     	return view('login');
     }

     public function postlogin(Request $request)
     {
     	$auth=Auth::guard('web')->attempt(['username'=>$request->username,'password'=>$request->password,'active'=>1]);
     	if($auth){
     		return redirect()->route('dashboard');
     	}
     	return redirect()->route('/');
     }
     public function getlogout()
     {
     	Auth::guard('web')->logout();
     	return redirect()->route('/');
     }

      public function create()
    {
          $users=User::orderBy('id')->get();
          $roles=DB::table('roles')->orderBy('id')->get();
        return view('logins.createuser',compact('users','roles'));
    }
    public function refreshuser()
    {
         
         $users=User::orderBy('id')->get();
         return view('logins.tbl_user',compact('users'));

    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
        'name' => 'required',
        'username' =>'required | unique:users',
        'email' => 'required | email | unique:users',
        'password' => 'required| min:6 | confirmed',
        'password_confirmation' => 'required| min:6'
        ]);

        if ($validator->passes()) {
          $user=new User;
          $user->name=$request->name;
          $user->username=$request->username;
          $user->role_id=$request->role;
          $user->email=$request->email;
          $user->password=bcrypt($request->password);
          $user->active=$request->active;
          $user->remember_token=str_random(10);
          $user->save();
          return response()->json(['sms'=>'Create User Completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
 
     public function update(Request $request)
    {
        $user=User::findOrFail($request->userid);

        $validator = Validator::make($request->all(), [
        'name' => 'required',
        'username' =>'required | unique:users,username,'.$user->id.',id',
        'email' => 'required | email | unique:users,email,'.$user->id.',id',
        
        ]);

        if ($validator->passes()) {
          
          $user->name=$request->name;
          $user->username=$request->username;
          $user->role_id=$request->role;
          $user->email=$request->email;
          $user->active=$request->active;
          $user->save();
          return response()->json(['sms'=>'Update User Completed.']);
        }
        return response()->json(['sms'=>$validator->errors()->all()]);
    }
    public function resetpassword(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'newpassword' => ['required','min:6'],
            'newpassword-confirm' => ['same:newpassword'],
        ]);
   
   
        if ($validator->passes()) {
          User::find($request->user_id)->update(['password'=> Hash::make($request->newpassword)]);
          return response()->json(['sms'=>'Update User Password Completed.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function destroy(Request $request)
    {
        $user=User::findOrFail($request->userid);
        $user->delete();
    }
    public function indexpwd()
    {
        return view('logins.changepassword');
    } 
    public function storepwd(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required','min:6'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        Auth::guard('web')->logout();
        return redirect()->route('/');
    }
}

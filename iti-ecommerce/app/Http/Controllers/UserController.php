<?php


namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Orders; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); 
            Session::put('user_id', $user->id); 
            Session::put('user_name', $user->name); 
            Session::put('role', $user->role); 
            if($user->role == "user"){
            return redirect()->route('home');
        }
        else{
            return redirect()->route('admin');
        }
        } else {
            return redirect()->route('login')->with('error', 'Invalid Email Or Password');
        }
    }

    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)){
            Session::put('error', ' Invalid Email Format.');
            return redirect()->route('register');
            }
        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            Session::put('error', 'Email already exists. Please choose a different email.');
            return redirect()->route('register');
        }
        if ($request->input('password')) {
            if(strlen($request['password'])>=8){
            if($request['password']==$request['password_confirmation']){
                $user = new User();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role = "user";
                $user->password = bcrypt($request->input('password')); 
                $user->save();
                Auth::login($user);
                Session::put('role', $user->role); 
                Session::put('user_id', $user->id);
                Session::put('user_name', $user->name);
                return redirect()->route('home')->with('success', 'Registration Successful');
        }
            else{
                Session::put('error2', 'Password Missmatch.');
                return redirect()->route('register');
            }}
            else{
                Session::put('error2', 'Password has to be 8 or more characters.');
                return redirect()->route('register');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function show($id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }  
        $orders = Orders::where('user_id',$id)->orderBy('id', 'DESC')->get();
        $user = User::find($id);
        return view('User/profile', ['user' => $user,'orders'=>$orders ]);
    }

    public function update(Request $request)
    {
        $userid = session('user_id');
        $user = User::where('id', $userid)->first(); // Use 'first()' to get a single user
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'nullable|string',
            'old_password' => 'nullable|string',
        ]);
    
        if ($request->filled('old_password') && !Hash::check($request->input('old_password'), $user->password)) {
            Session::put('error', 'Old password is incorrect.');
            return redirect()->route('profile.show', ['id' => $userid]);
        }
    
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
    
        if ($request->filled('password')) {
            if(strlen($request['password'])>=8){
            if($request['password']==$request['password_confirmation']){
            $data['password'] = bcrypt($request->input('password'));
        }
            else{
                Session::put('error', 'Password Missmatch.');
                return redirect()->route('profile.show', ['id' => $userid]);
            }}
            else{
                Session::put('error', 'Password has to be 8 or more characters.');
                return redirect()->route('profile.show', ['id' => $userid]);
            }
        }
    
        try {
            $user->update($data);
            Session::put('user_name', $user->name);
            Session::put('error', '');
            return redirect()->route('profile.show', ['id' => $userid])->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('profile.show', ['id' => $userid])->with('error', 'Error updating profile: ' . $e->getMessage());
        }
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAdminLogin()
    {
        return view('login'); 
    }
    public function adminLogin(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required',
            'password' => 'required|string',
        ]);
        $identifier = $request->identifier;

        if (preg_match('/^\d+$/', $identifier)) {
            // إذا كان رقم هاتف
            if (substr($identifier, 0, 1) === '0') {
                $formattedNumber = '+963' . substr($identifier, 1);
            } else {
                $formattedNumber = $identifier;
            }
            $user = User::where('phone_number', $formattedNumber)->first();
        } else {
            return redirect()->back()->withErrors([
                'identifier' => 'Invalid identifier format. Must be a valid email or phone number.',
            ]);
        }
        // تحقق من وجود المستخدم وكلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'identifier' => 'Invalid credentials',
            ]);
        }

        // التحقق من أن المستخدم هو مسؤول (Admin)
        if ($user->role_id !== 1) { // role_id = 1 يشير إلى مسؤول
            return redirect()->back()->withErrors([
                'identifier' => 'Access denied. You do not have admin privileges.',
            ]);
        }

        // تسجيل الدخول باستخدام Auth
        Auth::login($user);

        // إعادة التوجيه إلى لوحة التحكم
        return redirect()->route('dashmony')->with('success', 'Login successful');
    }
    public function showAdminProfile()
    {
        $admin = Auth::user();
        $localNumber = '0' . substr($admin->phone_number, 4);
        $users = User::nonUsers()->get();
        $roles = Role::where('role', '!=', 'User')->get();
        return view('profile', compact('admin','localNumber','users','roles'));
    }
    public function updateAdminProfile(Request $request)
    {
        $admin = Auth::user();
        $id=Auth::user()->id;
        $phoneNumber = $request->input('phone_number');
        if (substr($phoneNumber, 0, 1) === '0') {
            $formattedNumber = '+963' . substr($phoneNumber, 1);
        } else {
            $formattedNumber = $phoneNumber;
        }
        $request->merge(['phone_number' => $formattedNumber]);

        $request->validate([
            'name' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|unique:users,phone_number,' . $id, 
            'password' => 'nullable|string', 
        ]);

        if ($request->has('name')) {
            $admin->name = $request->input('name');
        }
        if ($request->has('password') && !empty($request->input('password'))) {
            $admin->password = Hash::make($request->input('password'));
        }
        if ($request->has('phone_number')) {
            $identifier=$request->input('phone_number');
            if (substr($identifier, 0, 1) === '0') {
                $formattedNumber = '+963' . substr($identifier, 1);
            } else {
                $formattedNumber = $identifier;
            }
            $admin->phone_number = $formattedNumber;
        }
        $admin->save();

        return back()->with('success', 'Profile updated successfully');
    }
    public function adminLogout()
    {
        Auth::logout(); // تسجيل الخروج
        return redirect()->route('loginForm')->with('success', 'Logged out successfully');
    }
    public function deleteadmin($id)
    {
        $admin = User::find($id);
        if($admin->phone_number=='+963962256897')
            return back()->with('errors', 'Cant delete the main admin');
        $admin->delete();
        return back()->with('success', 'Admin deleted successfully');
    }
    public function addadmin(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        if (substr($phoneNumber, 0, 1) === '0') {
            $formattedNumber = '+963' . substr($phoneNumber, 1);
        } else {
            $formattedNumber = $phoneNumber;
        }
        $request->merge(['phone_number' => $formattedNumber]);

        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string',
            'role_id' => 'required'
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->phone_number =$validated['phone_number'];
        $user->password = Hash::make($validated['password']);
        $user->role_id =$validated['role_id'];
        $user->save();
        return back()->with('success', 'Admin added successfully');
    }
    public function adduser(Request $request)
    {
        $role = Role::where('role', '=', 'User')->first();
        $phoneNumber = $request->input('phone_number');
        if (substr($phoneNumber, 0, 1) === '0') {
            $formattedNumber = '+963' . substr($phoneNumber, 1);
        } else {
            $formattedNumber = $phoneNumber;
        }
        $request->merge(['phone_number' => $formattedNumber]);

        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|string',
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->phone_number =$validated['phone_number'];
        $user->password = Hash::make($validated['password']);
        $user->role_id =$role->id;
        $user->save();
        return back()->with('success', 'User added successfully');
    }
}

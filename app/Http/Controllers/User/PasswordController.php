<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class PasswordController extends Controller
{
    public function edit() {
        return view('user.password');
    }

    public function update(Request $request) {
        // Validate
        $this->validate($request,[
           'current_password' => 'required',
           'password' => 'required|min:8|confirmed',
        ]);

        // Update encrypted user password in the database
        $user = User::findOrFail(auth()->id());
        if (!Hash::check($request->current_password, $user->password)) {
            session()->flash('danger', "Your current password doesn't mach the password in the database");
            return back();
        }
        $user->password = Hash::make($request->password);
        $user->save();

        // Flash
        session()->flash('success', 'Password updated successfully');

        return redirect('login')->with(Auth::logout());
    }
}

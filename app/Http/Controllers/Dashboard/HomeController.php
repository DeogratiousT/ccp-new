<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Mail\UserPasswordUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function passwordResetIndex()
    {
        $user = Auth::user();
        return view('dashboard.users.password_reset', ['user'=>$user]);
    }

    public function passwordReset(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password' => [
                            'nullable', 
                            'string',   
                            'confirmed', 
                            Password::min(8)
                        ->mixedCase()
                    ->numbers()
                ->symbols() 
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.password.reset.index')->withErrors($validator)->withInput();
        }

        $validated = $validator->safe();

        try {
            if (isset($validated['password'])) {
                $user->password = $validated['password'];
            }
            $user->save();

            if (isset($validated['password'])) {
                // Send Email
                Mail::to($user->email)->send(new UserPasswordUpdated($user));
            }

            Auth::logout();

            return redirect('/');

        } catch (\Throwable $th) {
            return redirect()->route('dashboard.users.password.reset.index')->with('error', 'Update Failed. Please try again later');
        }
    }
}

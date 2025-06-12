<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\UserAccountCreated;
use App\Mail\UserPasswordUpdated;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create', [
            'roles' => Role::whereNotIn('name', ['Super Admin'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'roles' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.create')->withErrors($validator)->withInput();
        }

        $validated = $validator->safe();

        try {
            $user = new User;
            
            $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
            $user->email = $validated['email'];
            $user->password = Hash::make('password');

            $user->save();
    
            $user->assignRole($validated['roles']);

            // Send Email
            Mail::to($user->email)->send(new UserAccountCreated($user));

            return redirect()->route('dashboard.users.index')->with('success','User Created Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.users.create')->with('error', 'Create Failed. Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        return view('dashboard.users.edit', ['user'=>$user, 'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'roles' => ['required', 'array'],
            'password' => [
                            'nullable', 
                            'string',   
                            'confirmed', 
                            Password::min(8)
                        ->mixedCase()
                    ->numbers()
                // ->symbols() 
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.edit', $user)->withErrors($validator)->withInput();
        }

        $validated = $validator->safe();

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (isset($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();
    
            $user->syncRoles($validated['roles']);

            if (isset($validated['password'])) {
                // Send Email
                Mail::to($user->email)->send(new UserPasswordUpdated($user));
            }

            return redirect()->route('dashboard.users.index')->with('success','User Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.users.edit', $user)->with('error', 'Create Failed. Please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            if ($user->active == true) {
                $user->active = false;
                $user->save();
                return redirect()->route('dashboard.users.index')->with('success','User Blocked Updated');
            }
            else {
                $user->active = true;
                $user->save();
                return redirect()->route('dashboard.users.index')->with('success','User Activated Updated');
            }
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.users.index')->with('error', 'Update Failed. Please try again later');
        }
    }
}

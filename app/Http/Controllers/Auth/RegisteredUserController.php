<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\WarehouseServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\WarehouseService\PriceTypeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, WarehouseServiceInterface $service)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = null; $superUser = User::USER_ROLE['user'];
        if (!User::exists()){
            $superUser = User::USER_ROLE['admin'];
            $superWarehouse = ['name' => 'Asosiy Ombor', 'default' => 1];
            $data = $service->createOrUpdate($superWarehouse)['data']['id'];
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $superUser,
            'active' => 1,
        ]);
        $user->warehouses()->syncWithPivotValues($data, ['default'=>true]);
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

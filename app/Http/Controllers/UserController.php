<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

//Librerias Passport Necesarias
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{
    /**
     * Registro de usuario
     */
    public function signUp(Request $request)
    {
        $data = $request->all();

        $company = Company::create([
            'company_name' => $data['company'],
            'company_active' => 1
        ]);

        $company = Company::where('company_name', $data['company'])->first();

        $user = User::create([
            'name' => $data['name'],
            'subname' => $data['subname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), 
            'user_active' => 1,
            'user_company_id' => $company['company_id'],
            'user_role_id' => 2

        ]);

        return response()->json([
            'message' => 'Usuario Creado Correctamente',
            'status' => 'OK',
            'id' => $user->id
        ]);
    }

    /**
     * Inicio de sesión
     */
    public function login(Request $request)

    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            return response()->json([
                'status' => 'OK',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ], 200);

        } else {
            return response()->json([
                'status' => 'ERROR'
            ], 401);
        }
    }

    /**
     * Cierre de sesión
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        $user = $request->user();

        error_log('aaaa');
        error_log($user);

        if ($user instanceof User) {
            $json = array_merge(
                ['status' => 'OK'],
                $user->toArray(),
            );
        } else {
            $json = [
                'status' => 'ERROR',
                'server' => $_SERVER,
                'cookies' => $_COOKIE,
                'environment' => $_ENV
            ];
        }

        return response()->json($json);
    }
}

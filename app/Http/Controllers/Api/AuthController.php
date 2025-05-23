<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre'        => 'required|string|min:2|max:50', //El nombre más corto del mundo, 2 caracteres
            'correo'        => 'required|string|email|min:6|max:100|unique:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'contraseña'    => 'required|string|min:6|max:100|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/', //Necesita minuscula, mayuscula, número y caracter especial
        ], [
            'nombre.required'       => 'El nombre es obligatorio.',
            'nombre.string'         => 'El nombre debe ser una cadena de texto.',
            'nombre.min'            => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max'            => 'El nombre no puede exceder los 50 caracteres.',
            'correo.required'       => 'El correo es obligatorio.',
            'correo.string'         => 'El correo debe ser una cadena de texto.',
            'correo.email'          => 'El correo debe ser un correo válido.',
            'correo.min'            => 'El correo debe tener al menos 6 caracteres.',
            'correo.max'            => 'El correo no puede exceder los 100 caracteres.',
            'correo.unique'         => 'El correo ya está en uso.',
            'correo.regex'          => 'El correo debe ser un correo válido.',
            'contraseña.required'   => 'La contraseña es obligatoria.',
            'contraseña.string'     => 'La contraseña debe ser una cadena de texto.',
            'contraseña.min'        => 'La contraseña debe tener al menos 6 caracteres.',
            'contraseña.max'        => 'La contraseña no puede exceder los 100 caracteres.',
            'contraseña.regex'      => 'La contraseña debe incluir al menos una letra minúscula, una mayúscula y un número y un caracter especial',
        ]);
          
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $role = Role::where('name', 'Usuario')->firstOrFail(); //Busca el rol 'Usuario' en la tabla 'roles'
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => Hash::make($request->contraseña),
            'role_id' => $role->id, // Usuario
        ]);
  
        event(new Registered($user));
  
        $token = $user->createToken('auth_token')->plainTextToken;  // Crea el token en la taula 'personal_acces_tokens'
        
        return response()->json([
          'token_acceso'    => $token,
          'tipo_token'      => 'Bearer',
          "nombre"          => $user->name,
          'correo'          => $user->email,
          "rol"             => $role->name,
          'status'          => 'Registro completado',
        ]);
    }
    public function login(Request $request) {
        $request->merge([
            'email'     => $request->correo, //Mapea el campo correo a email para que pueda ser validado
            'password'  => $request->contraseña, //Mapea el campo contrasenya a password para que pueda ser validado
        ]);
        $request->validate([
            'email'         => ['required', 'string', 'email', 'min:6', 'max:100', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/'],
            'contraseña'    => ['required', 'string', 'min:6', 'max:100', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'],
        ], [
            'email.required'        => 'El correo es obligatorio.',
            'email.string'          => 'El correo debe ser una cadena de texto.',
            'email.email'           => 'El correo debe ser un correo válido.',
            'email.min'             => 'El correo debe tener al menos 6 caracteres.',
            'email.max'             => 'El correo no puede exceder los 100 caracteres.',
            'email.regex'           => 'El correo debe ser un correo válido.',
            'contraseña.required'   => 'La contraseña es obligatoria.',
            'contraseña.string'     => 'La contraseña debe ser una cadena de texto.',
            'contraseña.min'        => 'La contraseña debe tener al menos 6 caracteres.',
            'contraseña.max'        => 'La contraseña no puede exceder los 100 caracteres.',
            'contraseña.regex'      => 'La contraseña debe incluir al menos una letra minúscula, una mayúscula y un número y un caracter especial',
        ]);
        
        if (!Auth::attempt($request->only('email', 'password'))) { //Se valida el email y la contraseña
            return response()->json(['message' => 'Credenciales de login inválidas'], 401);
        }

        $user = Auth::user();
        // Comprueba si el usuario está baneado
        if ($user->banned === 'Y') {
            Auth::logout();
            return response()->json(['message' => 'Usuario baneado. No puede iniciar sesión.'], 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token_acceso'    => $token,
            'tipo_token'      => 'Bearer',
            "nombre"          => $user->name,
            'correo'          => $user->email,
            'baneado'         => $user->banned,
            "rol"             => $user->role->name,
            'status' => 'Login completado',
        ]);
    }
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete(); //Elimina el token de /login de la tabla 'personal_access_tokens'

        return response()->json([
            "nombre"    => $request->user()->name,
            "correo"    => $request->user()->email,
            "baneado"   => $request->user()->phone,
            "rol"       => $request->user()->role->name,
            "status"    => "Logout completado",
        ]);
    }
}

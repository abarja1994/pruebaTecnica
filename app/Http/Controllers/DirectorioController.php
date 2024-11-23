<?php

namespace App\Http\Controllers;

use App\Enums\EstadoEnum;
use App\Enums\LogActionEnum;
use App\Models\Directorio;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class DirectorioController extends Controller
{

    public function index()
    {
        $usuarios = Directorio::with('user')
            ->whereHas('user', function ($query) {
                $query->where('is_deleted', EstadoEnum::Inactivo->value);
            })
            ->get();

        return view('directorio.index', compact('usuarios'));
    }

    public function getUsers()
    {
        $users = Directorio::with('user')
            ->whereHas('user', function ($query) {
                $query->where('is_deleted', EstadoEnum::Inactivo->value);
            })
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:4',
            'apellido' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'required|string|min:8',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => EstadoEnum::Activo->value,
            ]);

            $directorio = Directorio::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'user_id' => $user->id,
            ]);

            Log::create([
                'action' => LogActionEnum::Registro->value,
                'description' => "Usuario registrado id: " . $user->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado y autenticado correctamente.',
                'directorio' => $directorio,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        try {
            if (!$request->has('id') || empty($request->id)) {
                return response()->json([
                    'responseCode' => 400,
                    'message' => 'El ID del usuario es requerido.'
                ], 400);
            }

            $usuario = User::with('directorio')
                ->where('is_deleted', EstadoEnum::Inactivo->value)
                ->find($request->id);

            if (!$usuario) {
                return response()->json([
                    'responseCode' => 404,
                    'message' => 'Usuario no encontrado o inactivo.'
                ], 404);
            }

            if (!$usuario->directorio) {
                return response()->json([
                    'responseCode' => 404,
                    'message' => 'No se encontró información del directorio para este usuario.'
                ], 404);
            }

            $usuarioData = [
                'id' => $usuario->id,
                'nombre' => $usuario->directorio->nombre,
                'apellido' => $usuario->directorio->apellido,
                'email' => $usuario->email,
                'telefono' => $usuario->directorio->telefono,
                'status' => $usuario->status,
            ];

            return response()->json([
                'responseCode' => 200,
                'data' => $usuarioData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'responseCode' => 500,
                'message' => 'Error al obtener los datos: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id',
            'nombre' => 'required|string|min:4',
            'apellido' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $request->id_user, 
            'telefono' => 'required|string|min:8',
            'password' => 'nullable|string|min:8',
            'old_password' => 'nullable|string|min:8', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = User::findOrFail($request->id_user);

            if ($request->filled('password')) {
                if (!$request->filled('old_password')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Debe proporcionar su contraseña actual para cambiarla.',
                    ], 422);
                }

                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La contraseña actual es incorrecta.',
                    ], 422);
                }

                $user->password = Hash::make($request->password);
            }

            $user->update([
                'name' => $request->nombre,
                'email' => $request->email,
                'status' => $request->status
            ]);

            $directorio = Directorio::firstOrNew(['user_id' => $user->id]);
            $directorio->nombre = $request->nombre;
            $directorio->apellido = $request->apellido;
            $directorio->telefono = $request->telefono;
            
            $directorio->save();

            Log::create([
                'action' => LogActionEnum::Edicion->value,
                'description' => "Usuario actualizado id: " . $user->id,
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente.',
                'directorio' => $directorio,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario. ' . $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if (isset($user)) {
            $user->is_deleted = EstadoEnum::Activo->value;
            $user->save();
            if ($user->save()) {
                Log::create([
                    'action' => LogActionEnum::Eliminacion->value,
                    'description' => "Usuario Eliminado id: " . $user->id,
                    'user_id' => Auth::id()
                ]);
                return response()->json(['responseCode' => 200, 'message' => 'Registro eliminado con éxito', 'delete' => true]);
            }
        }
    }
}

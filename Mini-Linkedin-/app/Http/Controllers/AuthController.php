<?php

namespace App\Http\Controllers;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/register

    public function register(Request $request) {
        
        $data = $request -> validate ([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:candidat,recruteur',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return $this -> respondWithToken($token, $user, 201);

    }


    // POST /api/login

    public function login(Request $request) {
        $credentials = $request -> validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$token = auth('api') -> attempt($credentials)) {
            return response() -> json(['message' => 'Identifiants incorrects.'], 401);
        }

        return $this->respondWithToken($token, auth('api')->user(), 201);
    }


    // Post /api/logout

    public function logout()
    {
        auth('api') -> logout();
        return response() -> json(['message' => 'Déconnecté avec succès.']);
    }


    // POST /api/refresh

    public function refresh() {
        try {
            $token = JWTAuth::parseToken() -> refresh();

            return $this -> respondWithToken(
                $token,
                JWTAuth::setToken($token) -> authenticate()
            );
        } catch (TokenInvalidException $e) {
            return response() -> json(['message' => 'Token invalide.'], 401);
        }
    }


    // GET /api/me

    public function me()
    {
        return response() -> json(auth('api') -> user());
    }

    // Shared response format
    private function respondWithToken(string $token, User $user, int $status = 200)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => $user,
        ], $status);
    }
}

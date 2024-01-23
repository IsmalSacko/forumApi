<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return response()->json([
            'message' => 'Récupération des utilisateurs réussie !',
            'users' => User::all(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AuthRequest $request)
    {
        $request->validated();
        $data = $request->only(['name', 'username', 'email', 'password']); // Récupère les données de la requête
        $data['password'] = Hash::make($data['password']); // Hash le mot de passe
        $user = User::create($data); // Crée l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken; // Crée un token pour l'utilisateur
        
        return response()->json([
            'message' => 'Utilisateur créé avec succès !',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Login a user.
     */
    function login(LoginRequest $request) {
        $request->validated();
        $user = User::where('username', $request->username)->first();
        if (!$user ||  !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Connexion réussie !',
            'user' =>  $user->only(['id', 'name', 'username', 'email']),
            'token' => $token,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé !',
            ], 404);
        }
        return response()->json([
            'message' => 'Récupération de l\'utilisateur réussie !',
            'user' => $user->only(['id', 'name', 'username', 'email']),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé !',
            ], 404);
        }
        $user->update($request->only(['name', 'username', 'email']));
        return response()->json([
            'message' => 'Utilisateur modifié avec succès !',
            'user' => $user->only(['id', 'name', 'username', 'email']),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé !',
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'Utilisateur supprimé avec succès !',
        ], 200);
    }
}

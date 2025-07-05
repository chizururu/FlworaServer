<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Fetch user
        try {
            // 1. Ambil data user berdasarkan id user login
            $user = User::where('id', Auth::id())->get();

            return response()->json([
                'status' => true,
                'message' => 'Memuat user berhasil',
                'data' => $user,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan memuat user'
            ], Response::class::HTTP_OK);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created account in storage (register).
     */
    public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Create user
            $data['password'] = Hash::make($data['password']);
            // 2.1 Enkripsi password
            $user = User::create($data);
            // 2.2 Save data ke user table
            // 3. Buat token user
            $token = $user->createToken('auth_token')->plainTextToken;

            // 4. Buat sektor default
            $sector = $user->sector()
                ->create([
                    'name' => "Home",
                    'user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'message' => 'Register berhasil',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'token' => $token
                    ],
                    'sector' => [$sector]
                ]
            ], Response::class::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan dalam register'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Login to a an account after created resource in storage.
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Check user yang sudah store dalam table user
            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                if (!$user) {
                    $message = 'Email tidak ditemukan';
                    $errors = ['email' => ['Email tidak terdaftar']];
                } else {
                    $message = 'Password salah';
                    $errors = ['password' => ['Password salah']];
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal ' . $message,
                    'errors' => $errors,
                ], Response::class::HTTP_UNAUTHORIZED);
            }

            // 3. Buat token user
            $token = $user->createToken('auth_token')->plainTextToken;

            // 4. Fetch semua data session user
            $sector = $user->sector()->get();
            $device = Device::where('sector_id', $sector[0]->id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'token' => $token
                    ],
                    'sector' => $sector, // Ambil data sektor berdasarkan user_id
                    'device' => $device, // Ambil data perangkat berdasarkan user_id
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan dalam login' . $e,
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(RegisterRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Simpan data yang sudah diupdate ke table user
            $user->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Update user berhasil'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan dalam update data',
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

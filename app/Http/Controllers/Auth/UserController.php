<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register a account
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();
            // 2. Create user
            // 2.1 Encryption Password
            $data['password'] = Hash::make($data['password']);
            // 2.2 Save data to user table
            $user = User::query()->create($data);
            // 3. Create token for user
            $token = $user->createToken('auth_token')->plainTextToken;
            // 4. Create sector default with 'Home'
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
                    'sector' => $sector
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
     * Login a account
     * Login a account after created resource in storage.
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();
            // 2. Check user is stored in table user before
            $user = User::query()->where('email', $data['email'])->first();
            // 2.1 Check user is exists and password correct
            if (!$user || !Hash::check($data['password'], $user->password)) {
                if (!$user) {
                    $message = 'email tidak ditemukan';
                    $errors = ['email' => ['Email tidak terdaftar']];
                } else {
                    $message = 'password salah';
                    $errors = ['password' => ['Password salah']];
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal, ' .$message,
                    'errors' => $errors,
                ], Response::class::HTTP_UNPROCESSABLE_ENTITY);
            }

            // 3. Create token for user
            $token = $user->createToken('auth_token')->plainTextToken;

            /*
             * 4. Get all data from table sector and device with user_id */
            $sector = $user->sector()->get();
            $device = Device::query()->where('sector_id', $sector[0]->id)->get();

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
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan dalam login'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

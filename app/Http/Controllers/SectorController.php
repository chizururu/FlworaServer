<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Http\Requests\Sector\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // 1. Fetch data from table sector
            $sector = Sector::query()->where('user_id', Auth::id())->get();

            return response()->json([
                'status' => true,
                'message' => 'Ambil data sektor berhasil',
                'data' => $sector
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan ambil data sektor',
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Save data to sector table
            $sector = Sector::query()->create([
                'name' => $data['name'],
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tambah sektor berhasil',
                'data' => $sector,
            ], Response::class::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
                'message' => 'Kesalahan dalam tambah sektor',
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector): \Illuminate\Http\JsonResponse
    {
        // Terapakan try catch
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Save the updated data into table sector
            $sector->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Update sektor berhasil',
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
                'message' => 'Kesalahan dalam update sektor',
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // Move each device from delete sector into to default sector
            $default = Sector::query()->first([
                'name' => 'Home', 'user_id' => Auth::id()
            ]);

            $sector->device()->update(['sector_id' => $default->id]);

            // Remove selected field data in table sector
            $sector->delete();

            return response()->json([
                'status' => false,
                'message' => 'Hapus sektor berhasil',
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan hapus sektor',
            ], Response::class::HTTP_OK);
        }
    }
}

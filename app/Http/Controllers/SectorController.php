<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectorRequest;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Fetch data dari table sector
            $sector = Sector::where('user_id', Auth::id())->get();

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
    public function store(SectorRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Save data ke table sector
            $sector = Sector::create([
                'name' => $data['name'],
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tambah sektor berhasil',
                'data' => $sector,
            ], Response::class::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
                'message' => 'Kesalahan dalam tambah sektor'
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
    public function update(SectorRequest $request, Sector $sector): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Simpan update data ke table sektor
            $sector->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Update sektor berhasil',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan dalam update sektor'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector): \Illuminate\Http\JsonResponse
    {
        try {
            // Semua device yang didalam sektor akan dipindahkan ke default
            $defaultSector = Sector::firstOrFail(['name' => 'Home', 'user_id' => Auth::id()]);

            $sector->device()->update(['sector_id' => $defaultSector->id]);

            // Hapus sektor
            $sector->delete();

            return response()->json([
                'status' => true,
                'message' => 'Hapus sektor berhasil',
            ], Response::class::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan hapus sektor'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

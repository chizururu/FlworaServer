<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sector;
use App\Http\Requests\Device\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // 1. Fetch only the sector id in the table sector
            $sector = Sector::where('user_id', Auth::id())->pluck('id');

            // 2. Fetch device in those sector id
            $device = Device::with('sectors')->whereIn('sector_id', $sector)->get();

            return response()->json([
                'status' => true,
                'message' => 'Ambil data perangkat berhasil',
                'data' => $device,
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan ambil data perangkat',
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

            // 2. Save data to device table
            $device = Device::query()->create([
                'name' => $data['name'],
                'sector_id' => $data['sector_id']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tambah perangkat berhasil',
                'data' => $device,
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                '' => 'Kesalahan tambah perangkat'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Save the updated data into table device
            $device->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Update perangkat berhasil',
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan update perangkat'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // Remove selected field data in table devices
            $device->delete();

            return response()->json([
                'status' => true,
                'message' => 'Hapus perangkat berhasil'
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan hapus perangkat'
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

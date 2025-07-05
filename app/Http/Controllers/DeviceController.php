<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Fetch data dari table device
            $device = Device::whereHas('sector', function ($q) {
                $q->where('user_id', Auth::id());
            })->get();

            return response()->json([
                'status' => true,
                'message' => 'Ambil data perangkat berhasil',
                'data' => $device
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
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
    public function store(DeviceRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Validation
            $data = $request->validated();

            // 2. Save data to device table
            $device = Device::create([
                'id' => $data['id'],
                'name' => $data['name'],
                'sector_id' => $data['sector_id']
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tambah perangkat berhasil',
                'data' => $device,
            ], Response::class::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Kesalahan tambah perangkat'
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
    public function update(DeviceRequest $request, Device $device): \Illuminate\Http\JsonResponse
    {
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
    public function destroy(Device $device)
    {
        //
    }
}

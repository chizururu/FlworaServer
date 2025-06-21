<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SensorMeasurementData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SensorMeasurementDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            return response()->json([
                'status' => true,
                'message' => 'Ambil data sensor berhasil',
                'data' => ''
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
                'message' => 'Kesalahan ambil data sensor',
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
    public function store(Request $request, Device $device): \Illuminate\Http\JsonResponse
    {
        // Terapkan try catch
        try {
            // 1. Validation
            $data = $request->validate([
                'device_id' => 'required',
                'soil_moisture' => 'required',
                'temperature' => 'required',
                'humidity' => 'required',
            ]);

            $sensor = SensorMeasurementData::query()->create([
                'device_id' => $data['device_id'],
                'soil_moisture' => $data['soil_moisture'],
                'temperature' => $data['temperature'],
                'humidity' => $data['humidity']
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Tambah data sensor berhasil',
                'data' => $sensor
            ], Response::class::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => true,
                'message' => 'Kesalahan tambah data sensor'. $e,
            ], Response::class::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SensorMeasurementData $sensorMeasurementData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SensorMeasurementData $sensorMeasurementData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SensorMeasurementData $sensorMeasurementData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SensorMeasurementData $sensorMeasurementData)
    {
        //
    }
}

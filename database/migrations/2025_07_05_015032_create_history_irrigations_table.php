<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('history_irrigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->references('id')
                ->on('devices')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->float('soil_moisture');
            $table->float('temperature');
            $table->float('humidity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_irrigations');
    }
};

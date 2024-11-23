<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->boolean('discount')->default(false);
            $table->boolean('registered_local');
            $table->datetime('picked_date');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('service_id')->nullable()->constrained();
            $table->foreignId('package_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

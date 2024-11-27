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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained();
            $table->float('currency_api', 5, 2);
            $table->float('payed', 5, 2);
            $table->enum('type', ['FULL', 'MOBILE', 'PAYPAL']);
            $table->enum('currency', ['CASH', 'DOLLAR']);
            $table->string('ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

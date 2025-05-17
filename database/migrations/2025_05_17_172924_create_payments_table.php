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
            $table->string('student_name');
            $table->string('fee_type');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('method'); // e.g. Cash, Card, etc.
            $table->boolean('status')->default(0); // 0 = pending, 1 = confirmed
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

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // الخصائص اللي طلبتها
            $table->string('title');           // عنوان الحدث
            $table->date('start_date');            // تاريخ الحدث
            $table->date('end_date');            // تاريخ نهاية الحدث
            $table->string('city');            // المدينة
            $table->string('booth')->nullable(); // رقم الجناح (درته nullable لأنه قد لا يتوفر دائماً)
            $table->string('status')->default('قادم'); // الحالة (درت حالة افتراضية مثل "قيد الانتظار")

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

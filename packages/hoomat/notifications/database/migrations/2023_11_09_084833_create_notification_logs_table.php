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
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('notification_id')->constrained();
            $table->foreignId('receiver_id')->constrained('users');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->dropForeign(['notification_id', 'receiver_employee_id']);
        });
        Schema::dropIfExists('notification_logs');
    }
};

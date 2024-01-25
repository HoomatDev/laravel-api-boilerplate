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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->morphs('notifable');
            $table->foreignId('template_id')->nullable()->constrained('notification_templates');
            $table->text('text')->nullable();
            $table->text('details')->nullable();
            $table->text('type');
            $table->timestamp('send_at');
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('sender_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->dropForeign(['template_id', 'business_id']);
        });
        Schema::dropIfExists('notifications');
    }
};

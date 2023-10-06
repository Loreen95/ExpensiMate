<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('frequency', ['daily', 'weekly', 'bi-weekly', 'monthly'])->default('daily');
            $table->integer('advance_notice_days')->default(0);
            $table->boolean('is_active')->default(false);
            $table->time('notification_time')->default('08:00:00');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_preferences');
    }
};

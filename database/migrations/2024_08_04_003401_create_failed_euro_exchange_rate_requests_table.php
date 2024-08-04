<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('failed_euro_exchange_rate_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requested_date');
            $table->string('error_message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_euro_exchange_rate_requests');
    }
};

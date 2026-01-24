<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_testers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('tester_id');

            $table->timestamp('created_at')->nullable();

            $table->unique(['module_id', 'tester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_testers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('reported_by');
            $table->unsignedBigInteger('assigned_to')->nullable();

            $table->string('title', 255);
            $table->text('description')->nullable();

            $table->enum('severity', ['minor','major','critical','blocker'])->default('minor');
            $table->enum('status', ['open','in_progress','fixed','reopened','closed'])->default('open');

            $table->text('steps_to_reproduce')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bugs');
    }
};

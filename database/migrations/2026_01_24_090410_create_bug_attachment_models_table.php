<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bug_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bug_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->string('file_path', 500);
            $table->string('file_type', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bug_attachments');
    }
};

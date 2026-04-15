<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('title', 220);
            $table->string('slug', 255)->unique();
            $table->longText('body');
            $table->string('status', 20)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->unsignedInteger('views_count')->default(0);
            $table->string('draft_origin', 20)->default('author');
            $table->string('restore_to_status', 20)->nullable();
            $table->timestamp('restore_published_at')->nullable();
            $table->foreignId('archived_by_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('archived_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('cover_image', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
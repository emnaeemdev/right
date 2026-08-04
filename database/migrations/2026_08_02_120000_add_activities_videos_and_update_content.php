<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_activities', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->json('description')->nullable();
            $table->string('video_url');
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->json('slug')->nullable()->after('title');
            $table->json('excerpt')->nullable()->after('description');
            $table->json('content')->nullable()->after('excerpt');
            $table->string('image')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'content', 'image']);
        });

        Schema::dropIfExists('videos');
        Schema::dropIfExists('training_activities');
    }
};

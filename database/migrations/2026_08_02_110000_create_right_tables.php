<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('slug');
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('training_bags', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('slug');
            $table->string('field')->nullable();
            $table->unsignedInteger('duration_days')->nullable();
            $table->unsignedInteger('duration_hours')->nullable();
            $table->enum('type', ['ready', 'custom'])->default('ready');
            $table->unsignedInteger('slides_count')->nullable();
            $table->json('contents')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('training_bag_cycle_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_bag_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('title');
            $table->json('description')->nullable();
            $table->timestamps();
        });

        Schema::create('training_bag_samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_bag_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['video', 'activity', 'pdf']);
            $table->json('title')->nullable();
            $table->string('video_url')->nullable();
            $table->longText('activity_html')->nullable();
            $table->string('pdf_path')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('slug');
            $table->foreignId('training_bag_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('duration_days')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('title')->nullable();
            $table->json('bio')->nullable();
            $table->json('specializations')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('logo')->nullable();
            $table->enum('category', ['intl', 'gov', 'ngo'])->default('gov');
            $table->string('website')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('slug');
            $table->string('client')->nullable();
            $table->string('field')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('expert_project', function (Blueprint $table) {
            $table->foreignId('expert_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->primary(['expert_id', 'project_id']);
        });

        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('category')->nullable();
            $table->string('pdf_path')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('consultation_type');
            $table->text('description');
            $table->string('budget_range')->nullable();
            $table->enum('status', ['new', 'assigned', 'in_progress', 'closed'])->default('new');
            $table->foreignId('assigned_expert_id')->nullable()->constrained('experts')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignId('training_bag_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->enum('status', ['new', 'contacted', 'quoted', 'closed'])->default('new');
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('meta_description')->nullable();
            $table->json('content')->nullable();
            $table->json('blocks')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('consultation_requests');
        Schema::dropIfExists('publications');
        Schema::dropIfExists('expert_project');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('experts');
        Schema::dropIfExists('training_programs');
        Schema::dropIfExists('training_bag_samples');
        Schema::dropIfExists('training_bag_cycle_steps');
        Schema::dropIfExists('training_bags');
        Schema::dropIfExists('services');
    }
};

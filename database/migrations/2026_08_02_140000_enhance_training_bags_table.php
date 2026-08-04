<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->string('image')->nullable()->after('slug');
            $table->json('general_objective')->nullable()->after('contents');
            $table->json('detailed_objectives')->nullable()->after('general_objective');
            $table->json('target_audience')->nullable()->after('detailed_objectives');
            $table->json('included_files')->nullable()->after('target_audience');
        });
    }

    public function down(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'general_objective',
                'detailed_objectives',
                'target_audience',
                'included_files',
            ]);
        });
    }
};

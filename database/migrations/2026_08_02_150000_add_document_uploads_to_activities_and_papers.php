<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_activities', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('image');
            $table->string('word_path')->nullable()->after('pdf_path');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->string('word_path')->nullable()->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('training_activities', function (Blueprint $table) {
            $table->dropColumn(['pdf_path', 'word_path']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn('word_path');
        });
    }
};

<?php

use App\Models\TrainingBag;
use App\Support\TrainingBagSections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->json('content_sections')->nullable()->after('included_files');
        });

        TrainingBag::query()->each(function (TrainingBag $bag): void {
            if (! empty($bag->content_sections)) {
                return;
            }

            $sections = TrainingBagSections::migrateLegacyBag($bag);

            if ($sections !== []) {
                $bag->forceFill(['content_sections' => $sections])->saveQuietly();
            }
        });
    }

    public function down(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->dropColumn('content_sections');
        });
    }
};

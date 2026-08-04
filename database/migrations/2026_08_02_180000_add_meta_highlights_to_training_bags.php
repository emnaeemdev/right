<?php

use App\Models\TrainingBag;
use App\Support\TrainingBagMeta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->json('meta_highlights')->nullable()->after('slides_count');
        });

        TrainingBag::query()->each(function (TrainingBag $bag): void {
            if (! empty($bag->meta_highlights)) {
                return;
            }

            $highlights = TrainingBagMeta::migrateLegacy($bag);

            if ($highlights !== []) {
                $bag->forceFill(['meta_highlights' => $highlights])->saveQuietly();
            }
        });
    }

    public function down(): void
    {
        Schema::table('training_bags', function (Blueprint $table) {
            $table->dropColumn('meta_highlights');
        });
    }
};

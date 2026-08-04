<?php

namespace App\Console\Commands;

use App\Models\Publication;
use App\Models\TrainingActivity;
use App\Models\VideoItem;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillSlugs extends Command
{
    protected $signature = 'right:backfill-slugs';

    protected $description = 'Backfill missing slugs for translatable models';

    public function handle(): int
    {
        foreach ([Publication::class, TrainingActivity::class, VideoItem::class] as $modelClass) {
            $modelClass::all()->each(function ($record) {
                foreach (['ar', 'en'] as $locale) {
                    if (empty($record->getTranslation('slug', $locale, false))) {
                        $title = $record->getTranslation('title', $locale, false) ?: 'item-' . $record->id;
                        $slug = Str::slug($title) ?: 'item-' . $record->id;
                        $record->setTranslation('slug', $locale, $slug);
                    }
                }
                $record->save();
            });
        }

        $this->info('Slugs backfilled successfully.');

        return self::SUCCESS;
    }
}

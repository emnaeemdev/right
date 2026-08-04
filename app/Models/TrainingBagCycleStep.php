<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TrainingBagCycleStep extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'description'];

    protected $fillable = ['training_bag_id', 'sort_order', 'title', 'description'];

    public function trainingBag(): BelongsTo
    {
        return $this->belongsTo(TrainingBag::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name', 'organization', 'email', 'phone', 'training_bag_id', 'notes', 'status',
    ];

    public function trainingBag(): BelongsTo
    {
        return $this->belongsTo(TrainingBag::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationRequest extends Model
{
    protected $fillable = [
        'name', 'organization', 'email', 'phone', 'consultation_type',
        'description', 'budget_range', 'status', 'assigned_expert_id', 'admin_notes',
    ];

    public function assignedExpert(): BelongsTo
    {
        return $this->belongsTo(Expert::class, 'assigned_expert_id');
    }
}

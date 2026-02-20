<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'digest_frequency',
        'feedback_email',
        'reviews_enabled',
        'loyalty_enabled',
        'review_positive_message',
        'review_negative_message',
        'google_review_url',
        'google_place_id',
        'google_business_data',
    ];

    protected $casts = [
        'reviews_enabled' => 'boolean',
        'loyalty_enabled' => 'boolean',
        'google_business_data' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

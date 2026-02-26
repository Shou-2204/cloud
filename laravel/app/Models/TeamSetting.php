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
        'loyalty_program_type',
        'last_loyalty_scan_at',
        'loyalty_points_expire',
        'loyalty_points_expiration_date',
        'loyalty_points_next_expiration',
    ];

    protected $casts = [
        'reviews_enabled' => 'boolean',
        'loyalty_enabled' => 'boolean',
        'loyalty_points_expire' => 'boolean',
        'google_business_data' => 'array',
        'last_loyalty_scan_at' => 'datetime',
        'loyalty_points_next_expiration' => 'date',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

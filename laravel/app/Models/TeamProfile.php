<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'tagline',
        'bio',
        'logo_path',
        'cover_image_path',
        'website',
        'email_public',
        'phone',
        'address',
        'social_instagram',
        'social_facebook',
        'social_tiktok',
        'social_linkedin',
        'social_twitter',
        'public_views',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

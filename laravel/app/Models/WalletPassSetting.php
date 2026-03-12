<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletPassSetting extends Model
{
    protected $fillable = [
        'team_id',
        'label_primary',
        'label_secondary',
        'foreground_color',
        'background_color',
        'label_color',
        'logo_text',
        'icon_path',
        'icon_2x_path',
        'logo_image_path',
        'logo_2x_path',
        'strip_path',
        'strip_2x_path',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

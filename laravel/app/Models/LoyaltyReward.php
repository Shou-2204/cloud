<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyReward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'name',
        'points_required',
        'icon',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

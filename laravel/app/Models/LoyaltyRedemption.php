<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoyaltyRedemption extends Model
{
    use HasUuids;

    protected $fillable = [
        'type',
        'team_id',
        'crm_contact_id',
        'loyalty_reward_id',
        'reward_name',
        'points_spent',
    ];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Str::uuid7();
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function contact()
    {
        return $this->belongsTo(CrmContact::class, 'crm_contact_id');
    }

    public function reward()
    {
        return $this->belongsTo(LoyaltyReward::class, 'loyalty_reward_id');
    }
}

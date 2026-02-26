<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CrmContact extends Model
{
    use HasUuids;

    public function newUniqueId(): string
    {
        return (string) Str::orderedUuid();
    }
    protected $fillable = [
        'team_id',
        'pass_token',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'opt_in_loyalty',
        'opt_in_marketing',
        'loyalty_points',
        'last_scanned_at',
    ];

    protected $casts = [
        'opt_in_loyalty' => 'boolean',
        'opt_in_marketing' => 'boolean',
        'date_of_birth' => 'date',
        'loyalty_points' => 'integer',
        'last_scanned_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

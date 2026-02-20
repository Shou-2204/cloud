<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrmContact extends Model
{
    protected $fillable = [
        'team_id',
        'name',
        'email',
        'phone',
        'opt_in_loyalty',
        'opt_in_marketing',
    ];

    protected $casts = [
        'opt_in_loyalty' => 'boolean',
        'opt_in_marketing' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

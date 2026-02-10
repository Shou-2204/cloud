<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'follow_up_step',
        'last_contacted_at',
        'next_follow_up_at',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'newsletter_subscribed',
    ];

    protected $casts = [
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'newsletter_subscribed' => 'boolean',
    ];
}

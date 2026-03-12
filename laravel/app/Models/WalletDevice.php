<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletDevice extends Model
{
    protected $fillable = [
        'device_library_identifier',
        'push_token',
    ];

    public function registrations()
    {
        return $this->hasMany(WalletRegistration::class);
    }
}

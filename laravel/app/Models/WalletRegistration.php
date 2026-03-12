<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRegistration extends Model
{
    protected $fillable = [
        'wallet_device_id',
        'pass_type_identifier',
        'serial_number',
    ];

    public function device()
    {
        return $this->belongsTo(WalletDevice::class, 'wallet_device_id');
    }
}

<?php
/*
 * File: app/Models/Team.php
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Team as JetstreamTeam;
use Laravel\Scout\Searchable;

class Team extends JetstreamTeam
{
    use Billable;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'personal_team',
        'join_code',
        'auto_approval',
        'billing_name',
        'billing_address',
        'billing_address_line2',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'vat_id',
    ];

    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
            'auto_approval' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($team) {
            $team->join_code = strtoupper(Str::random(8));
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Jetstream::userModel(), Jetstream::membershipModel())
            ->withPivot('role', 'is_approved')
            ->withTimestamps()
            ->as('membership');
    }

    public function invoicesRel()
    {
        return $this->hasMany(TeamInvoice::class)->orderByDesc('issued_at');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_email' => $this->owner->email,
        ];
    }
}
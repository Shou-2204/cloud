<?php

/*
 * File: app/Models/Team.php
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Team as JetstreamTeam;


class Team extends JetstreamTeam
{
    use Billable;
    use HasFactory;


    protected $fillable = [
        'name',
        'personal_team',
        'join_code',
        'auto_approval',
        'public_uuid',
        'short_url',
        'qr_code_path',
        // Cashier/Stripe fields are guarded or managed by trait, but we can list them if needed.
        // Usually they are not in fillable unless we manually update them.
        // For now, keeping only what was core.
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
            $team->public_uuid = (string) Str::uuid();
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

    public function ratings()
    {
        return $this->hasMany(TeamRating::class)->orderByDesc('created_at');
    }

    // New Relationships

    public function profile(): HasOne
    {
        return $this->hasOne(TeamProfile::class)->withDefault();
    }

    public function billingDetail(): HasOne
    {
        return $this->hasOne(TeamBillingDetail::class)->withDefault();
    }

    public function settings(): HasOne
    {
        return $this->hasOne(TeamSetting::class)->withDefault();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_email' => $this->owner->email,
            'tagline' => $this->profile->tagline,
            'bio' => $this->profile->bio,
            'public_uuid' => $this->public_uuid,
            'email_public' => $this->profile->email_public,
            'website' => $this->profile->website,
        ];
    }

    /**
     * Get the name that should be synced to Stripe.
     */
    public function stripeName(): ?string
    {
        return $this->billingDetail->billing_name ?? $this->name;
    }

    /**
     * The disk used for storing QR codes.
     */
    public const QR_CODE_DISK = 'cloud_public';

    /**
     * Get the URL of the QR code.
     */
    public function getQrCodeUrlAttribute(): ?string
    {
        if (empty($this->qr_code_path)) {
            return null;
        }

        return \Illuminate\Support\Facades\Storage::disk(self::QR_CODE_DISK)->url($this->qr_code_path);
    }

    /**
     * Get the address that should be synced to Stripe.
     */
    public function stripeAddress(): array
    {
        return [
            'line1' => $this->billingDetail->billing_address,
            'line2' => $this->billingDetail->billing_address_line2,
            'city' => $this->billingDetail->billing_city,
            'state' => $this->billingDetail->billing_state,
            'postal_code' => $this->billingDetail->billing_postal_code,
            'country' => $this->billingDetail->billing_country,
        ];
    }
    /**
     * Get the CRM contacts associated with the team.
     */
    public function crmContacts()
    {
        return $this->hasMany(CrmContact::class);
    }

    /**
     * Get the loyalty rewards defined by the team.
     */
    public function loyaltyRewards()
    {
        return $this->hasMany(LoyaltyReward::class);
    }
}

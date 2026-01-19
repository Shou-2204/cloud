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
        // Public Profile
        'public_uuid',
        'tagline',
        'bio',
        'logo_path',
        'cover_image_path',
        'phone',
        'email_public',
        'website',
        'address',
        'social_instagram',
        'social_facebook',
        'social_tiktok',
        'social_linkedin',
        'social_twitter',
        'google_place_id',
        'google_business_data',
        'public_views',
        'reviews_enabled',
        'google_review_url',
        'review_positive_message',
        'review_negative_message',
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
            'google_business_data' => 'array',
            'reviews_enabled' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($team) {
            $team->join_code = strtoupper(Str::random(8));
            $team->public_uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the route key for the model.
     * Use public_uuid for explicit route binding on public pages if needed,
     * but usually we specify {team:public_uuid} in the route definition.
     */
    // public function getRouteKeyName()
    // {
    //     return 'public_uuid'; 
    // } 
    // Keeping default ID for internal routes, explicit binding for public ones.

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

    /**
     * Get the name that should be synced to Stripe.
     */
    public function stripeName(): ?string
    {
        return $this->billing_name ?? $this->name;
    }

    /**
     * Get the address that should be synced to Stripe.
     */
    public function stripeAddress(): array
    {
        return [
            'line1' => $this->billing_address,
            'line2' => $this->billing_address_line2,
            'city' => $this->billing_city,
            'state' => $this->billing_state,
            'postal_code' => $this->billing_postal_code,
            'country' => $this->billing_country,
        ];
    }
}
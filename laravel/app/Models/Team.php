<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Team as JetstreamTeam;
use Laravel\Scout\Searchable;

class Team extends JetstreamTeam
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
        'join_code', // J'ai ajouté join_code ici par sécurité pour les updates de masse
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }

    /**
     * Génération automatique du code au démarrage.
     */
    protected static function booted(): void
    {
        static::creating(function ($team) {
            $team->join_code = strtoupper(Str::random(8));
        });
    }

    /**
     * C'EST ICI QUE LA MAGIE OPÈRE.
     * On surcharge la méthode par défaut pour inclure 'is_approved'.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Jetstream::userModel(), Jetstream::membershipModel())
                    ->withPivot('role', 'is_approved') // <--- Indispensable pour ton système
                    ->withTimestamps()
                    ->as('membership');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // Tu peux ajouter d'autres champs utiles pour la recherche
            'owner_email' => $this->owner->email, 
        ];
    }
}
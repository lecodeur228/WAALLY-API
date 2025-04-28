<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'fcm_token',
        'user_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new StateScope());
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   /**
     * Relation vers la boutique à laquelle l'utilisateur est associé
     * Relation "appartient à" (belongsTo)
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Relation vers les boutiques dont l'utilisateur est propriétaire
     * Relation "possède plusieurs" (hasMany)
     */
    public function ownedShops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    /**
     * Relation vers les fournisseurs dont l'utilisateur est propriétaire
     * Relation "possède plusieurs" (hasMany)
     */
    public function ownedSuppliers()
    {
        return $this->hasMany(Supplier::class, 'owner_id');
    }

    /**
     * Relation vers les clients dont l'utilisateur est propriétaire
     * Relation "possède plusieurs" (hasMany)
     */
    public function ownedCustomers()
    {
        return $this->hasMany(Customer::class, 'owner_id');
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class)
                    ->using(ShopUser::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }
}

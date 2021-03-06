<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,\App\Models\lib\Media;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $pivotTableReletions = 'relations';

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, $this->pivotTableReletions, 'following_id', 'follower_id')
            ->as('relation')
            ->withTimestamps()
            ->withPivot('approved_at', 'id');
    }


    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, $this->pivotTableReletions, 'follower_id', 'following_id')
            ->as('relation')
            ->withTimestamps()
            ->withPivot('approved_at', 'id');
    }



    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }




    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull($this->pivotTableReletions . '.approved_at');
    }

    public function scopeNotApproved($query)
    {
        return $query->whereNull($this->pivotTableReletions . '.approved_at');
    }
}

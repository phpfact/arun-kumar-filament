<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Afsakar\FilamentOtpLogin\Models\Contracts\CanLoginDirectly;

class Customer extends Authenticatable implements HasName, CanLoginDirectly
{
    use HasFactory, Notifiable;

    public function canLoginDirectly(): bool
    {
      return ($this->email_two_factor == 0) ? true : false;
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function address()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class, 'customer_id');
    }

    public function videoSongs()
    {
        return $this->hasMany(VideoSong::class, 'customer_id');
    }

    public function artists()
    {
        return $this->hasMany(ArtistChannel::class, 'customer_id');
    }

    public function removeCopyrightRequests()
    {
        return $this->hasMany(RemoveCopyrightRequest::class, 'customer_id');
    }
}

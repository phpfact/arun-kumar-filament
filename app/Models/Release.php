<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'releases';

    protected $casts = [
        // 'track' => 'array',
        'album_artists_id' => 'array',
    ];

    public function track()
    {
        return $this->hasOne(Track::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    // public function tracks()
    // {
    //     return $this->hasMany(Track::class);
    // }

    public function artists()
    {
        return $this->belongsToMany(Artists::class, 'release_artist');
    }

}

<?php

namespace App\Models;

use App\Models\Label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Release extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'releases';

    protected $casts = [
        // 'track'                      => 'array',
        'album_artists_id'           => 'array',
        'album_featuring_artists_id' => 'array',
    ];

    public function track()
    {
        return $this->hasOne(Label::class, 'id', 'album_label_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
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

    public function release_primary_artist()
    {
        return $this->belongsToMany(Artists::class, 'release_primary_artist');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'release_artist');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    protected $casts = [
        'authors' => 'array',
        'composer' => 'array',
        'producer' => 'array',
        'artists_id' => 'array',
        'featuring_artists_id' => 'array'
    ];

    // public function release()
    // {
    //     return $this->belongsTo(Release::class);
    // }

    // public function artists()
    // {
    //     return $this->belongsToMany(Artist::class, 'track_artists');
    // }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artists extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    // public function releases()
    // {
    //     return $this->belongsToMany(Release::class, 'release_artists');
    // }

    // public function tracks()
    // {
    //     return $this->belongsToMany(Track::class, 'track_artists');
    // }

}

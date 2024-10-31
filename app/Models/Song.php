<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $table = 'songs';
    protected $guarded = ['id'];
    protected $casts = [
        'singers' => 'array',
        'lyrics' => 'array',
        'composer' => 'array',
        'languages' => 'array',
        'caller_tune_name' => 'array',
        'caller_tune_duration' => 'array',
        'artists_id' => 'array',
        'publisher' => 'array',
        'produser_name' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

    public function artists()
    {
        return $this->belongsTo(Artists::class, 'artists_id', 'id');
    }

}

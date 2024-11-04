<?php

namespace App\Models;

use App\Models\Label;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytics extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'analytics';

    // Guarded properties (mass assignment protection)
    protected $guarded = ['id'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function label() {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }

}

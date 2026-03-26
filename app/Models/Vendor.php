<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['wedding_id', 'name', 'category', 'price', 'paid_amount', 'phone'];

    public function wedding() {
        return $this->belongsTo(Wedding::class);
    }
}

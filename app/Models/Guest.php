<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['wedding_id', 'name', 'email', 'status', 'table_number'];

    public function wedding() {
        return $this->belongsTo(Wedding::class);
    }
}

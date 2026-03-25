<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $fillable = ['user_id', 'title', 'date', 'budget_total', 'location'];

    // Un mariage appartient à un utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Un mariage a plusieurs invités
    public function guests() {
        return $this->hasMany(Guest::class);
    }

    // Un mariage a plusieurs tâches
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être remplis massivement.
     *
     * @var array
     */
    protected $fillable = [
        'wedding_id',
        'title',
        'description',
        'due_date',
        'status',
    ];

    /**
     * Relation : Une tâche appartient à un mariage.
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * Scope optionnel pour récupérer facilement les tâches terminées.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'terminé');
    }

    /**
     * Scope optionnel pour récupérer les tâches à faire ou en cours.
     */
    public function scopePending($query)
    {
        return $query->where('status', '!=', 'terminé');
    }
}
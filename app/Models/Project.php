<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'deadline', 'created_by'];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }
}

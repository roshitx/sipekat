<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'status',
        'slug,'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title' // Field yang akan digunakan sebagai basis slug
            ]
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ComplaintImages::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Respon::class);
    }
}

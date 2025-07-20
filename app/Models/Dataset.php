<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Dataset extends Model
{
    /** @use HasFactory<\Database\Factories\DatasetFactory> */
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    /**
     * Generate a new UUID v.7 for the model.
     */
    public function newUniqueId()
    {
        return (string) Uuid::uuid7();
    }

    /**
     * Get the columns that should receive a unique identifier.
     */
    public function uniqueIds()
    {
        return ['id'];
    }

    /**
     * Get the user that belongs the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

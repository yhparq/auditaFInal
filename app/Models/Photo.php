<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
     use HasFactory;

    protected $fillable = [
        'filename',
        'file_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the full URL for the photo
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }


}

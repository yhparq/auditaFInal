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

        /**
     * Get the photo size if file exists
     */
    public function getFileSizeAttribute()
    {
        $fullPath = storage_path('app/public/' . $this->file_path);
        return file_exists($fullPath) ? filesize($fullPath) : 0;
    }
}

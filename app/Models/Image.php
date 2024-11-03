<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    use HasFactory;
    protected $fillable = ['path', 'type', 'filename'];

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}

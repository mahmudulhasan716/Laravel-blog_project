<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'thumbail',
        'category_id',
        'status',
        'title'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

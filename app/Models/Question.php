<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'category_id',
        'answer',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}

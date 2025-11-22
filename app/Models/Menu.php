<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish',
        'category_id',
        'price',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu';

    protected $fillable = [
        'dish',
        'category_id',
        'price',
        'description',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the menu item's initials for avatar display
     */
    public function initials(): string
    {
        return Str::upper(
            Str::of($this->dish)
                ->explode(' ')
                ->take(2)
                ->map(fn ($word) => Str::substr($word, 0, 1))
                ->implode('')
        );
    }
}

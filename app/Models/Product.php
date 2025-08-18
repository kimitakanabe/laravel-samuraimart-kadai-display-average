<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'recommend_flag',
        'carriage_flag',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // アクセサ
    public function getAverageRatingAttribute()
    {
        if ($this->reviews->count() === 0) {
            return null; // レビューなし
        }
    return round($this->reviews->avg('score'), 1); // 小数点1桁
    }

    public function favorite_users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}

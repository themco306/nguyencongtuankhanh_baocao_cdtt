<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'table_id')->where('type', '=', 'category');
    }
    public function link(): HasOne
    {
        return $this->hasOne(Link::class, 'table_id')->where('type', '=', 'category');
    }
}

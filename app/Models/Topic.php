<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Topic extends Model
{
    use HasFactory;
    protected $table = 'topic';
    public function post(): HasMany
    {
        return $this->hasMany(Post::class)->where('type', '=', 'post');
    }
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'table_id')->where('type', '=', 'topic');
    }
    public function link(): HasOne
    {
        return $this->hasOne(Link::class, 'table_id')->where('type', '=', 'topic');
    }
}

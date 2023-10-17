<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $table = 'post';
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'table_id')->where('type', '=', 'page');
    }
    public function link(): HasOne
    {
        return $this->hasOne(Link::class, 'table_id')->where('type', '=', 'page');
    }
}

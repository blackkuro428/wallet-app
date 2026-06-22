<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
    }

    // 一括保存有効化
    protected $fillable = ['user_id', 'category_id', 'type', 'date', 'amount', 'memo'];
}

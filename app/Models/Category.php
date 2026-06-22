<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    /**
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    // 共通の検索条件定義（ユーザーID=Null or ログインユーザー）
    public function scopeForCurrentUser($query) {
        return $query->whereNull('user_id')->orWhere('user_id', Auth::id());
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // 一括保存有効化
    protected $fillable = ['user_id', 'type', 'name'];
}

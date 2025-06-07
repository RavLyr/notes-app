<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Note extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_archived',
        'is_pinned',
        'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

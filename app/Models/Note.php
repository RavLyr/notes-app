<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'is_archived', 'is_pinned', 'color'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getHeaderTextColorAttribute(): string
    {
        $bgColor = $this->color ?? '#4f46e5';

        $hex = str_replace('#', '', $bgColor);

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

        return $brightness > 150 ? '#000000' : '#FFFFFF';
    }

    public function scopeNotArchived($query)
    {
        return $query->whereis_archived(false);
    }
    public function scopeArchived($query)
    {
        return $query->whereis_archived(true);
    }
}

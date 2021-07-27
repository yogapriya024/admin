<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Progress extends Model
{
    protected $casts = [
        'country_id' => 'int',
        'status' => 'int'
    ];

    protected $fillable = [
        'text',
        'next_day',
        'user_id',
        'status'
    ];

    public static function updateCreate($request)
    {
        $progress = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'text' => Arr::get($request, 'text', ''),
                'next_day' => Arr::get($request, 'next_day', ''),
                'user_id' => Arr::get($request, 'user_id', ''),
                'status' => Arr::get($request, 'status', null),
            ]
        );
        return $progress;
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

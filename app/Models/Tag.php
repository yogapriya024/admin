<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Tag
 *
 * @property int $id
 * @property string $description
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $leads
 * @property \Illuminate\Database\Eloquent\Collection $partners
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'description',
		'status'
	];

	public function leads()
	{
		return $this->hasMany(\App\Models\Lead::class);
	}

	public function partners()
	{
		return $this->hasMany(\App\Models\Partner::class);
	}

    public static function updateCreate($request)
    {
        $category = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'description' => Arr::get($request, 'description', ''),
                'status' => Arr::get($request, 'status', null),
            ]
        );
        return $category;
    }

    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }
}

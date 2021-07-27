<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Category
 *
 * @property int $id
 * @property string $category
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $partners
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'category';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'category',
		'status'
	];

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
                'category' => Arr::get($request, 'category', ''),
                'status' => Arr::get($request, 'status', null),
            ]
        );
        return $category;
    }
    public function getCategoryAttribute($value)
    {
        return ucfirst($value);
    }
}

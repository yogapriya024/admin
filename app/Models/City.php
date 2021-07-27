<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class City
 *
 * @property int $id
 * @property int $country_id
 * @property string $description
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Country $country
 * @property \Illuminate\Database\Eloquent\Collection $leads
 * @property \Illuminate\Database\Eloquent\Collection $partners
 *
 * @package App\Models
 */
class City extends Model
{
	protected $table = 'city';

	protected $casts = [
		'country_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'country_id',
		'description',
		'status'
	];

	public function country()
	{
		return $this->belongsTo(\App\Models\Country::class);
	}

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
        $city = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'description' => Arr::get($request, 'description', ''),
                'status' => Arr::get($request, 'status', null),
                'country_id' => Arr::get($request, 'country_id', null),
            ]
        );
        return $city;
    }
    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }
}

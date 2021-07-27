<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Partner
 *
 * @property int $id
 * @property int $city_id
 * @property int $country_id
 * @property int $category_id
 * @property int $tag_id
 * @property string $block
 * @property string $speciality
 * @property string $description
 * @property string $email
 * @property string $contact
 * @property int $is_regular
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Category $category
 * @property \App\Models\City $city
 * @property \App\Models\Country $country
 * @property \App\Models\Tag $tag
 *
 * @package App\Models
 */
class Partner extends Model
{
	protected $casts = [
		'city_id' => 'int',
		'country_id' => 'int',
		'category_id' => 'int',
		//'tag_id' => 'int',
		'is_regular' => 'int'
	];

	protected $fillable = [
		'city_id',
		'country_id',
		'category_id',
		//'tag_id',
		'block',
		'speciality',
		'description',
		'email',
		'contact',
        'url',
		'name',
		'is_regular',
        'percentage'
	];

    public static function updateCreate($request)
    {
        $lead = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'block' => Arr::get($request, 'block', ''),
                'name' => Arr::get($request, 'name', ''),
                'city_id' => Arr::get($request, 'city_id', null),
                'url' => Arr::get($request, 'url', ''),
                'email' => Arr::get($request, 'email', ''),
                'contact' => Arr::get($request, 'contact', ''),
                'speciality' => Arr::get($request, 'speciality', ''),
                //'tag_id' => Arr::get($request, 'tag_id', null),
                'is_regular' => Arr::get($request, 'is_regular', null),
                'category_id' => Arr::get($request, 'category_id', ''),
                'description' => Arr::get($request, 'description', ''),
                'country_id' => Arr::get($request, 'country_id', null),
                'percentage' => Arr::get($request, 'percentage', 0),
            ]
        );
        return $lead;
    }

	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class);
	}

	public function city()
	{
		return $this->belongsTo(\App\Models\City::class);
	}

	public function country()
	{
		return $this->belongsTo(\App\Models\Country::class);
	}

	public function tag()
	{
		return $this->belongsToMany(\App\Models\Tag::class, 'partner_tag', 'partner_id', 'tag_id');
	}
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}

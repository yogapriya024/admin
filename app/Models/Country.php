<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Country
 *
 * @property int $id
 * @property string $description
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $cities
 * @property \Illuminate\Database\Eloquent\Collection $leads
 * @property \Illuminate\Database\Eloquent\Collection $partners
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'country';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'description',
		'status'
	];

	public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('description', 'asc')->get();
    }

	public function cities()
	{
		return $this->hasMany(\App\Models\City::class)->orderBy('description', 'asc');
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
        $country = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'description' => Arr::get($request, 'description', ''),
                'status' => Arr::get($request, 'status', null),
            ]
        );
        //if($request->status == 2){
            \App\Models\City::where('country_id', $country->id)->update(['status' => $request->status]);
      //  }
        return $country;
    }
    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }
}

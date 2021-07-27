<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Lead
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $country_id
 * @property string $email
 * @property string $contact
 * @property string $url
 * @property int $tag_id
 * @property int $isrfp
 * @property string $rfp_email_text
 * @property string $description
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Country $country
 * @property \App\Models\City $city
 * @property \App\Models\Tag $tag
 *
 * @package App\Models
 */
class Lead extends Model
{
    protected $casts = [
        'city_id' => 'int',
        'country_id' => 'int',
        //'tag_id' => 'int',
        'isrfp' => 'int'
    ];

    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'name',
        'city_id',
        'country_id',
        'email',
        'contact',
        'url',
        //'tag_id',
        'isrfp',
        'world_wide',
        'rfp_email_text',
        'description',
        'date',
        'status',
        'requirements',
        'initial_requirements'
    ];

    public static function updateCreate($request)
    {
        $date = null;
        if ($request->has('date')) {
            $date = date('Y-m-d', strtotime($request->date));
        }
        $id = Arr::get($request, 'id', '');
        $status = Arr::get($request, 'status', 1);
        if($id !=''){
            $status = Arr::get($request, 'status', 2);
        }
        $lead = Self::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'name' => Arr::get($request, 'name', ''),
                'city_id' => Arr::get($request, 'city_id', null),
                'email' => Arr::get($request, 'email', ''),
                'contact' => Arr::get($request, 'contact', ''),
                'url' => Arr::get($request, 'url', ''),
                //'tag_id' => Arr::get($request, 'tag_id', null),
                'isrfp' => Arr::get($request, 'isrfp', null),
                'world_wide' => Arr::get($request, 'world_wide', null),
                'rfp_email_text' => Arr::get($request, 'rfp_email_text', ''),
                'description' => Arr::get($request, 'description', ''),
                'country_id' => Arr::get($request, 'country_id', null),
                'status' => $status,
                'date' => $date,
                'initial_requirements' => Arr::get($request, 'initial_requirements', ''),
                'requirements' => Arr::get($request, 'requirements', ''),
            ]
        );
        return $lead;
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function tag()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'lead_tag', 'lead_id', 'tag_id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getDateAttribute($value)
    {
        return date('m/d/Y', strtotime($value));
    }

    public function communication()
    {
        return $this->hasMany(\App\Models\LeadCommunication::class);
    }
    public function projects()
    {
        return $this->hasMany(\App\Models\Project::class);
    }

}

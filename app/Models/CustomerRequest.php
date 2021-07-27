<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;


/**
 * Class CustomerRequest
 *
 * @property int $id
 * @property string $service
 * @property string $type
 * @property string $company
 * @property string $contact_name
 * @property string $loaction
 * @property string $url
 * @property \Carbon\Carbon $last_date
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class CustomerRequest extends Model
{
    protected $casts = [
        'status' => 'int'
    ];

    protected $dates = [
        'last_date'
    ];

    protected $fillable = [
        'service',
        'type',
        'company',
        'contact_name',
        'location',
        'url',
        'last_date',
        'email',
        'status'
    ];

    public static function updateCreate($request)
    {
        $date = null;
        if ($request->has('last_date')) {
            $date = date('Y-m-d', strtotime($request->last_date));
        }
        $crequest = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'service' => Arr::get($request, 'service', ''),
                'email' => Arr::get($request, 'email', ''),
                'type' => Arr::get($request, 'type', null),
                'company' => Arr::get($request, 'company', ''),
                'contact_name' => Arr::get($request, 'contact_name', ''),
                'url' => Arr::get($request, 'url', ''),
                'location' => Arr::get($request, 'location', ''),
                'last_date' => $date
            ]
        );

        return $crequest;
    }

}

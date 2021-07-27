<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 19 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class LeadCommunication
 *
 * @property int $id
 * @property string $name
 * @property int $lead_id
 * @property int $city_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Lead $lead
 * @property \App\Models\Partner $partner

 *
 * @package App\Models
 */
class LeadCommunication extends Model
{
    protected $casts = [
        'lead_id' => 'int',
        'partner_id' => 'int',
    ];

    public $table = 'lead_partners';

    protected $fillable = [
        'lead_id',
        'partner_id',
        'status'
    ];

    public static function updateCreate($request)
    {

        $lead = Self::updateOrCreate(
            [
                'lead_id' => Arr::get($request, 'lead_id', null),
                'partner_id' => Arr::get($request, 'partner_id', null),
            ],
            [
                'lead_id' => Arr::get($request, 'lead_id', null),
                'partner_id' => Arr::get($request, 'partner_id', null),
                //'status' => Arr::get($request, 'status', 1),
            ]
        );
        return $lead;
    }

    public function lead()
    {
        return $this->belongsTo(\App\Models\Lead::class);
    }

    public function partner()
    {
        return $this->belongsTo(\App\Models\Partner::class);
    }
}

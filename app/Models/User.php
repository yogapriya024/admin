<?php

/**
 * Created by Prabakaran.
 * Date: Thu, 02 Jul 2020 15:34:58 +0000.
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;


/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $api_token
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */


class User extends Authenticatable
{
    use Notifiable;

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'api_token',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'api_token',
		'remember_token',
        'status'
	];

    public static function updateCreate($request)
    {
        $user = Self::updateOrCreate(
            [
                'id' => Arr::get($request, 'id', '')
            ],
            [
                'name' => Arr::get($request, 'name', ''),
                'email' => Arr::get($request, 'email', ''),
                'status' => Arr::get($request, 'status', null),
            ]
        );
        return $user;
    }
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}

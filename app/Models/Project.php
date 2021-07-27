<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'lead_id',
        'partner_id',
        'status'
    ];

    public function lead()
    {
        return $this->belongsTo(\App\Models\Lead::class);
    }

    public function partner()
    {
        return $this->belongsTo(\App\Models\Partner::class);
    }
}

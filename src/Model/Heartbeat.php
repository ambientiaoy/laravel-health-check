<?php

namespace Ambientia\HealthCheck\Model;

use Illuminate\Database\Eloquent\Model;

class Heartbeat extends Model
{
    const TYPE_SCHEDULE = 1;
    const TYPE_JOB = 2;

    protected $fillable = ['type'];
}

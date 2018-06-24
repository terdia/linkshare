<?php

namespace App\Models;

use Legato\Framework\Fluent;

class SubChannel extends Fluent
{
    /**
     * Database fields that can be populated with mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'channel_id'
    ];
}
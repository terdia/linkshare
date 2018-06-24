<?php

namespace App\Models;

use Legato\Framework\Fluent;

class Channel extends Fluent
{
    /**
     * Database fields that can be populated with mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];
}
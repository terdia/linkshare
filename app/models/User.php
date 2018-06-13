<?php

namespace App\Models;

use Legato\Framework\Fluent;

class User extends Fluent
{
    /**
     * Database fields that can be populated with mass assignment.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Activate the users account
     */
    public function activate()
    {
        $this->activated = 1;
        $this->activation_code = null;
        $this->save();
    }
}

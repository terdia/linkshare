<?php


namespace App\controllers\Auth;


use Legato\Framework\Security\Auth;

class Gatekeeper extends Auth
{

    protected $logoutRedirectTo = '/';

}
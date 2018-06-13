<?php


namespace App\middleware;


use Legato\Framework\Request;
use Legato\Framework\Security\Auth;

class RedirectIfAuthenticated
{

    protected $lockForAuthenticated = [
      '/login', '/register'
    ];

    public function __construct()
    {
    }

    public function handle(Request $request)
    {
        $uri = $request->uri();

        if((Auth::check() || Auth::remembered($request))
            && in_array($uri, $this->lockForAuthenticated))
        {
            redirectTo('/links');
        }
    }
}
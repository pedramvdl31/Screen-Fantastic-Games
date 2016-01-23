<?php

namespace App\Http\Middleware;
use App\Job;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
use URL;
use Laracasts\Flash\Flash;
use Auth;

class Authenticate
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {

            // Check where the user came from, if from admins then redirect accordingly
            $redirect_path = ($request->is('admins') || $request->is('admins/*')) ? '/admins/login' : '/users/login';
            // Set intended page
            Session::put('intended_url',$request->url());

            Flash::error('You must be logged in to view the page');
            return redirect($redirect_path);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->get('x-auth-token')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }else{
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_url' => env('API_URL'),
                'defaults' => [
                    'verify' => false,
                    'headers' => ['X-Auth-Token' => $token]
                ]
            ]);
            $authed = $api->get('auth/check')->json();
            if(!$authed['authorized']) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('/feed/recent');
                }
            }else{
                return $next($request);
            }
        }
    }
}

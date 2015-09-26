<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class AuthController extends Controller
{
    /**
     * Signing a user up/in with github
     *
     * @return Redirect The redirection which handles github
     */
    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Display the user authed back from github
     *
     * @return Auth The authed user.
     */
    public function accept(Request $request)
    {
        $user = Socialite::driver('github')->user();
        $githubToken = $user->token;

        $api = new \GuzzleHttp\Client(array(
            'base_uri' => env('API_URL'),
            'verify' => false
        ));

        $user = $api->post('auth/login', [
            'form_params' => [
                'service' => 'github',
                'guid' => $githubToken
            ]
        ]);

        $jsonData = json_decode($user->getBody(), true);
        $request->session()->put('x-auth-token', $jsonData['token']);
        return redirect('/feed/following');
    }

    /**
     * Display the login page to the user
     *
     * @return view returns a view to the user
     */
    public function login()
    {
        return view('auth/login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('x-auth-token');
        return redirect('/feed/recent');
    }
}

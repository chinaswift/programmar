<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collect(Request $request, $user)
    {
        if ($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $user = $api->get($user);
            return json_decode($user->getBody(), true);
        } else {
            return ['username' => ''];
        }
    }

    public function update(Request $request)
    {
        $drink_price = $request->input('drinkprice');
        $drink_currency = $request->input('drinkcurrency');
        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $post = $api->post('me/update', [
            'form_params' => [
                'drinkprice' => $drink_price,
                'drinkcurrency' => $drink_currency
            ]
        ])->getBody();

        return json_decode($post, true);
    }

    public function profile(Request $request, $username)
    {
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
        ]);

        $user = json_decode($api->get('users/' . $username)->getBody(), true);
        $user = $user[0];

        if ($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);
            $me = json_decode($api->get('me')->getBody(), true);

            if(in_array($me['id'], $user['followers'])) {
                $user['yourFollowing'] = true;
            }else{
                $user['yourFollowing'] = false;
            }
        }else{
            $user['yourFollowing'] = false;
        }


        return view('user.profile')->with('user', $user);
    }

    //function to follow user
    public function follow(Request $request)
    {
        $token = $request->session()->get('x-auth-token');
        $id = $request->input('id');

        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $follow = $api->post('followers/follow', [
            'form_params' => [
                'user' => $id
            ]
        ]);

        $status = json_decode($follow->getBody(), true);
        return $status;
    }

    //function to unfollow user
    public function unfollow(Request $request)
    {
        $token = $request->session()->get('x-auth-token');
        $id = $request->input('id');

        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $unfollow = $api->post('followers/unfollow', [
            'form_params' => [
                'user' => $id
            ]
        ]);

        $status = json_decode($unfollow->getBody(), true);
        return $status;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collectNotifications(Request $request)
    {
        if ($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $notifications = $api->get('me/notifications?read=0');
            return json_decode($notifications->getBody(), true);
        } else {
            return [];
        }
    }

    public function articles(Request $request)
    {
        $page = $request->input('page');
        $user = $request->input('user');
        try {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $articles = $api->get('users/'.$user.'/articles?limit=10&page=' . $page);
            return json_decode($articles->getBody(), true);
        } catch (RequestException $e) {
            return $e->getRequest();
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
        }
    }

    public function collectAllNotifications(Request $request)
    {
        if ($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $notifications = $api->get('me/notifications');
            return json_decode($notifications->getBody(), true);
        } else {
            return [];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function readNotifications(Request $request)
    {
        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $notifications = $api->get('me/notifications/read');
        return json_decode($notifications->getBody(), true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

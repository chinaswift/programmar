<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Contracts\Factory as Socialite;

class ConnectController extends Controller
{
    private $socialite;
    private $auth;
    private $users;

    public function __construct(Socialite $socialite) {
        $this->socialite = $socialite;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return $this->socialite->driver('stripe')->scopes(['read_write'])->redirect();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm()
    {
        $user = $this->socialite->driver('stripe')->user();
        $token = $user->token;

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $api->post('connect', [
            'form_params' => [
                'service' => 'stripe',
                'token_1' => $token,
            ]
        ])->getBody();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

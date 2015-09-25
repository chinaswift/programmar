<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Exception;

class ConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return Socialite::driver('stripe')->scopes(['read_write'])->redirect();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        $endpoint = "https://connect.stripe.com/oauth/token";
        $params = array('client_secret' => env('STRIPE_SECRET'), 'grant_type' => 'authorization_code', 'code' => $request->input('code'));
        $curl = curl_init($endpoint);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HEADER,'Content-Type: application/x-www-form-urlencoded');
        $postData = "";

        foreach($params as $k => $v)
        {
           $postData .= $k . '='.urlencode($v).'&';
        }

        $postData = rtrim($postData, '&');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // evaluate for success response
        if ($status != 200) {
          throw new Exception("Error: call to URL $endpoint failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl) . "\n");
        }
        curl_close($curl);
        $response = json_decode($json_response, true);

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $postCall = $api->post('connect', [
            'form_params' => [
                'service' => 'stripe',
                'access_token' => $response['access_token'],
                'publishable_key' => $response['stripe_publishable_key'],
                'refresh_token' => $response['refresh_token'],
            ]
        ])->getBody();

        $response = json_decode($postCall, true);
        return redirect('/settings');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $checkaccounts = $api->get('connect/check')->getBody();
        return json_decode($checkaccounts, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bill(Request $request)
    {
        //collect fields
        $cardToken = $request->input('token');
        $user_id = $request->input('to_id');

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $billAccount = $api->post('connect/bill', [
            'form_params' => [
                'user_id' => $user_id,
                'token' => $cardToken
            ]
        ])->getBody();

        return $billAccount;
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class WriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $article_id = 0)
    {
        //check if you own the article
        if($article_id > 0) {
           $token = $request->session()->get('x-auth-token');
           $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $user = json_decode($api->get('me')->getBody(), true);
            $article_data = json_decode($api->get('articles/' . $article_id)->getBody(), true);
            if($article_data['feed'][0]['owner_id'] != $user['id']) {
                return view('_errors.404');
            }
        }

        return view('write.index')->with('article_id', $article_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request)
    {
        $articleTitle = $request->input('name');
        $articleContent = $request->input('content');
        $kickback = $request->input('kickback_id');
        $tags = $request->input('tags');

        if($request->input('id') == '') {
            $article_id = '';
        }else{
            $article_id = $request->input('id');
        }

        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            if($article_id == '') {
                $article = $api->post('articles/publish', [
                    'form_params' => [
                        'name' => $articleTitle,
                        'content' => $articleContent,
                        'kickback_id' => $kickback,
                        'tags' => $tags,
                    ]
                ]);
            }else{
                $article = $api->post('articles/publish/' . $article_id, [
                    'form_params' => [
                        'name' => $articleTitle,
                        'content' => $articleContent,
                        'kickback_id' => $kickback,
                        'tags' => $tags,
                    ]
                ]);
            }

            return json_decode($article->getBody(), true);
        }else{
            return "error:Seems you've been logged out!";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articleTitle = $request->input('name');
        $articleContent = $request->input('content');
        $tags = $request->input('tags');

        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $article = $api->post('articles', [
                'form_params' => [
                    'name' => $articleTitle,
                    'content' => $articleContent,
                    'tags' => $tags,
                ]
            ]);

            return json_decode($article->getBody(), true);
        }else{
            return "error:Seems you've been logged out!";
        }
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
    public function edit(Request $request)
    {
        $articleTitle = $request->input('name');
        $articleContent = $request->input('content');
        $kickback = $request->input('kickback_id');
        $tags = $request->input('tags');
        $article_id = $request->input('id');

        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $article = $api->post('articles/' . $article_id, [
                'form_params' => [
                    'name' => $articleTitle,
                    'content' => $articleContent,
                    'kickback_id' => $kickback,
                    'tags' => $tags,
                ]
            ]);

            return json_decode($article->getBody(), true);
        }else{
            return "error:Seems you've been logged out!";
        }
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

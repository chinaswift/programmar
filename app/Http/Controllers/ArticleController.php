<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collectFollowing(Request $request)
    {
        $page = $request->input('page');
        if($request->session()->get('x-auth-token')) {
            try {
                $token = $request->session()->get('x-auth-token');
                $api = new \GuzzleHttp\Client([
                    'base_uri' => env('API_URL'),
                    'verify' => false,
                    'headers' => ['X-Auth-Token' => $token]
                ]);

                $articles = $api->get('articles/following?limit=10&page=' . $page);
                return json_decode($articles->getBody(), true);
            } catch (RequestException $e) {
                return $e->getRequest();
                if ($e->hasResponse()) {
                    return $e->getResponse();
                }
            }

        }else{
            return response()->json(['error' => 'auth'], 200);
        }
    }

    public function displayArticle(Request $request, $article_id)
    {
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false
        ]);

        $article = (array) json_decode($api->get('articles/' . $article_id)->getBody(), true);
        if(count($article['feed']) > 0) {
            return view('article.index')->with('article', $article['feed'][0]);
        }else{
            return view('_errors.404');
        }

    }

    public function collectArticle(Request $request, $article_id)
    {
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);
        }else{
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
            ]);
        }
        $article = $api->get('articles/' . $article_id);
        return json_decode($article->getBody(), true);
    }

    public function collectPopular(Request $request)
    {
        $page = $request->input('page');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);
        }else{
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
            ]);
        }

        $articles = $api->get('articles/popular?limit=10&page=' . $page);
        return json_decode($articles->getBody(), true);
    }

    public function collectRecent(Request $request)
    {
        $page = $request->input('page');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);
        }else{
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
            ]);
        }

        $articles = $api->get('articles?limit=10&page=' . $page);

        return json_decode($articles->getBody(), true);
    }

    public function collectDrafts(Request $request)
    {
        $limit = $request->input('limit');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $articles = $api->get('articles/drafts?limit=' . $limit);
            return json_decode($articles->getBody(), true);
        }else{
            return "error:Seems you've been logged out!";
        }
    }

    public function postComment(Request $request)
    {
        $article_id = $request->input('article_id');
        $comment = $request->input('comment');

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $comment = $api->post('comments', [
            'form_params' => [
                'article' => $article_id,
                'content' => $comment
            ]
        ]);
        return json_decode($comment->getBody(), true);
    }

    public function collectComments(Request $request)
    {
        $article_id = $request->input('article_id');
        $page = $request->input('page');

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_uri' => env('API_URL'),
            'verify' => false,
            'headers' => ['X-Auth-Token' => $token]
        ]);

        $comments = $api->get('comments/' . $article_id.'?limit=5&page=' . $page);
        $comments = json_decode($comments->getBody(), true);
        return $comments;
    }

    public function collectEdit(Request $request)
    {
        $article_id = $request->input('id');

        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $article = $api->get('articles/' . $article_id);
            $article = json_decode($article->getBody(), true);
            return $article;
        }else{
            return "error:Seems you've been logged out!";
        }
    }

    /**
     * Upvote an article
     */
    public function upvoteArticle(Request $request)
    {
        $article = $request->input('article');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_uri' => env('API_URL'),
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]);

            $upvote = $api->post('upvotes/' . $article);
            return json_decode($upvote->getBody(), true);
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

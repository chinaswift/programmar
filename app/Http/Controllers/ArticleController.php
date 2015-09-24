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
                    'base_url' => env('API_URL'),
                    'defaults' => [
                        'verify' => false,
                        'headers' => ['X-Auth-Token' => $token]
                    ]
                ]);

                $articles = $api->get('articles/following?limit=10&page=' . $page);
                return $articles->json();
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
            'base_url' => env('API_URL'),
            'defaults' => [
                'verify' => false
            ]
        ]);

        $article = (array) $api->get('articles/' . $article_id)->json();
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
            $options = [
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ];
        }else{
            $options = [
                'verify' => false,
            ];
        }

        $api = new \GuzzleHttp\Client([
            'base_url' => env('API_URL'),
            'defaults' => $options
        ]);

        $article = $api->get('articles/' . $article_id);
        return $article->json();
    }

    public function collectPopular(Request $request)
    {
        $page = $request->input('page');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $options = [
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ];
        }else{
            $options = [
                'verify' => false,
            ];
        }

        $api = new \GuzzleHttp\Client([
            'base_url' => env('API_URL'),
            'defaults' => $options
        ]);

        $articles = $api->get('articles/popular?limit=10&page=' . $page);
        return $articles->json();
    }

    public function collectRecent(Request $request)
    {
        $page = $request->input('page');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $options = [
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ];
        }else{
            $options = [
                'verify' => false,
            ];
        }

        $api = new \GuzzleHttp\Client([
            'base_url' => env('API_URL'),
            'defaults' => $options
        ]);

        $articles = $api->get('articles?limit=10&page=' . $page);
        return $articles->json();
    }

    public function collectDrafts(Request $request)
    {
        $limit = $request->input('limit');
        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_url' => env('API_URL'),
                'defaults' => [
                    'verify' => false,
                    'headers' => ['X-Auth-Token' => $token]
                ]
            ]);

            $articles = $api->get('articles/drafts?limit=' . $limit);
            return $articles->json();
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
            'base_url' => env('API_URL'),
            'defaults' => [
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]
        ]);

        $comment = $api->post('comments', [
            'body' => [
                'article' => $article_id,
                'content' => $comment
            ]
        ]);
        return $comment->json();
    }

    public function collectComments(Request $request)
    {
        $article_id = $request->input('article_id');
        $page = $request->input('page');

        $token = $request->session()->get('x-auth-token');
        $api = new \GuzzleHttp\Client([
            'base_url' => env('API_URL'),
            'defaults' => [
                'verify' => false,
                'headers' => ['X-Auth-Token' => $token]
            ]
        ]);

        $comments = $api->get('comments/' . $article_id.'?limit=5&page=' . $page);
        $comments = $comments->json();
        return $comments;
    }

    public function collectEdit(Request $request)
    {
        $article_id = $request->input('id');

        if($request->session()->get('x-auth-token')) {
            $token = $request->session()->get('x-auth-token');
            $api = new \GuzzleHttp\Client([
                'base_url' => env('API_URL'),
                'defaults' => [
                    'verify' => false,
                    'headers' => ['X-Auth-Token' => $token]
                ]
            ]);

            $article = $api->get('articles/' . $article_id);
            $article = $article->json();
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
                'base_url' => env('API_URL'),
                'defaults' => [
                    'verify' => false,
                    'headers' => ['X-Auth-Token' => $token]
                ]
            ]);

            $upvote = $api->post('upvotes/' . $article);
            return $upvote->json();
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

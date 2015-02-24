<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Enjoy;
use App\Follower;
use Storage;
use Auth;

class HomeController extends Controller {

	//Show all recent Articles
	public function all($page = 1)
	{
		$followerArray = array();
		if (Auth::check()) {
			$followers = Follower::where('followed_by', '=', Auth::user()->id)->get();
			if(!empty($followers)) {
				foreach($followers as $follower) {
					$following_user = User::find($follower->followed);
					$array = array(
						'user_id' => $following_user->id,
						'user_avatar' => $following_user->avatar,
						'user_slug' => $following_user->username
					);
					array_push($followerArray, $array);
				}
			}
		}

		//Setting up pagignation for the all section
		$article_count = Article::where('published', '=', '1')->orderBy('last_updated', 'desc')->count();
		$resultsPerPage = 10;
		$paginationCtrls = '';
		$last = ceil($article_count/$resultsPerPage);

		//Make sure that pages have a default
		if($last < 1){ $last = 1; }
		if ($page < 1) { $page = 1; } else if ($page > $last) { $page = $last; }

		//Check if there are pages
		if($last != 1){
			if($page > 1) {
				$previous = $page - 1;
				if($page == $last) { $class = 'brand-primary'; }else{ $class = ''; }
				$paginationCtrls .= '<a href="/all/'.$previous.'" class="f-left '.$class.'">Previous</a>';
			}
		}

		//Check if we are on the last page
		if ($page != $last) {
	        $next = $page + 1;
	        $paginationCtrls .= '<a href="/all/'.$next.'" class="f-right brand-primary">Next</a>';
	    }

	    //Collect the articles
		$articles = Article::where('published', '=', '1')->skip($page - 1)->take($resultsPerPage)->orderBy('last_updated', 'desc')->get();
		foreach ($articles as $article) {
			$user = User::where('id', '=', $article->{'user_id'})->first();
			$article->userName = $user->{'name'};
			$article->username = $user->{'username'};
			$article->avatar = $user->{'avatar'};
			$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
		}
		return view('home/all', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
	}


	/**
	 * Index
	 * This decides what to show the user, depending if authed or not.
	 * @return void
	 */
	public function popular($page = 1) {
		$followerArray = array();

		if (Auth::check()) {
			$followers = Follower::where('followed_by', '=', Auth::user()->id)->get();

			foreach($followers as $follower) {
				$following_user = User::find($follower->followed);
				$array = array(
					'user_id' => $following_user->user_id,
					'user_avatar' => $following_user->avatar,
					'user_slug' => $following_user->username
				);
				array_push($followerArray, $array);
			}
		}

		$lastDay = time() - (24*60*60);
		$nextDay = time() + (24*60*60);

		$article_count = Article::where('published', '=', '1')->where('slug', '>', $lastDay)->where('slug', '<', $nextDay)->count();
		$resultsPerPage = 10;
		$paginationCtrls = '';
		$last = ceil($article_count/$resultsPerPage);
		if($last < 1){
			$last = 1;
		}

		if ($page < 1) {
		    $page = 1;
		} else if ($page > $last) {
		    $page = $last;
		}

		if($last != 1){
			if($page > 1) {
				$previous = $page - 1;
				if($page == $last) {
					$class = 'brand-primary';
				}else{
					$class = '';
				}
				$paginationCtrls .= '<a href="/popular/'.$previous.'" class="f-left '.$class.'">Previous</a>';
			}
		}

		if ($page != $last) {
	        $next = $page + 1;
	        $paginationCtrls .= '<a href="/popular/'.$next.'" class="f-right brand-primary">Next</a>';
	    }

		$articles = Article::where('published', '=', '1')->where('slug', '>', $lastDay)->where('slug', '<', $nextDay)->skip($page - 1)->take($resultsPerPage)->get();
		foreach ($articles as $article) {
			$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
			$article->userName = $user->{'name'};
			$article->username = $user->{'username'};
			$article->avatar = $user->{'avatar'};
			$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
		}

		$articles = array_values(array_sort($articles, function($value)
		{
		    return $value['enjoys'];
		}));

		$articles = array_reverse($articles);

		return view('home/popular', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
	}

}

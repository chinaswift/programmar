<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GrahamCampbell\GitHub\GitHubManager;
use App\Article;
use App\User;
use App\Enjoy;
use App\Follower;
use Storage;
use Auth;

class UserController extends Controller {

	/**
	 * Construct
	 * This allows auth checks to be in place before any of the views are loaded.
	 * @return void
	 */

	protected $github;

	public function __construct(GitHubManager $github)
	{
		$this->middleware('auth');
		$this->github = $github;
	}

	/**
	 * Write
	 * This is the main write page for the developers.
	 * @return void
	 */
	public function write() {
		return view('user/write');
	}

	/**
	 * Followers
	 * This is how you can view your followers posts.
	 * @return void
	 */
	public function following($page = 1) {
		$followerArray = array();
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

		$article_count = Article::whereIn('user_id', $followerArray)->where('published', '=', '1')->count();
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
				$paginationCtrls .= '<a href="/following/'.$previous.'" class="f-left '.$class.'">Previous</a>';
			}
		}

		if ($page != $last) {
	        $next = $page + 1;
	        $paginationCtrls .= '<a href="/following/'.$next.'" class="f-right brand-primary">Next</a>';
	    }

		$articles = Article::whereIn('user_id', $followerArray)->where('published', '=', '1')->orderBy('last_updated', 'desc')->skip($page - 1)->take($resultsPerPage)->get();
		foreach ($articles as $article) {
			$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
			$article->userName = $user->{'name'};
			$article->username = $user->{'username'};
			$article->avatar = $user->{'avatar'};
			$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
		}
		return view('home/following', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
	}

	public function drafts($page = 1) {
		$followerArray = array();
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

		$article_count = Article::where('user_id', '=', Auth::user()->id)->where('published', '=', '0')->count();
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
				$paginationCtrls .= '<a href="/drafts/'.$previous.'" class="f-left '.$class.'">Previous</a>';
			}
		}

		if ($page != $last) {
	        $next = $page + 1;
	        $paginationCtrls .= '<a href="/drafts/'.$next.'" class="f-right brand-primary">Next</a>';
	    }

		$articles = Article::where('user_id', '=', Auth::user()->id)->where('published', '=', '0')->orderBy('last_updated', 'desc')->skip($page - 1)->take($resultsPerPage)->get();

		foreach ($articles as $article) {
			$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
			$article->userName = $user->{'name'};
			$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
			if($article->title == '') {
				$article->title = $article->slug;
			}
			$article->username = $user->{'username'};
			$article->avatar = $user->{'avatar'};
		}
		return view('home/drafts', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
	}

	public function all($page = 1) {
		if (\Auth::check())
		{
			$followerArray = array();
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


			$article_count = Article::where('published', '=', '1')->orderBy('last_updated', 'desc')->count();
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
					$paginationCtrls .= '<a href="/all/'.$previous.'" class="f-left '.$class.'">Previous</a>';
				}
			}

			if ($page != $last) {
		        $next = $page + 1;
		        $paginationCtrls .= '<a href="/all/'.$next.'" class="f-right brand-primary">Next</a>';
		    }

			$articles = Article::where('published', '=', '1')->orderBy('last_updated', 'desc')->take($resultsPerPage)->get();
			foreach ($articles as $article) {
				$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
				$article->userName = $user->{'name'};
				$article->username = $user->{'username'};
				$article->avatar = $user->{'avatar'};
				$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
			}

			return view('home/all', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
		}
		else
		{
			return view('home/landing');
		}
	}

	/**
	 * Profile
	 * This is how you can see your profile
	 * @return void
	 */
	public function profile($username) {
		$users = User::where('username', '=', $username)->count();
		if($users > 0) {
			$user = User::where('username', '=', $username)->firstOrFail();
			$articles = Article::where('user_id', $user->id)->where('published', '=', '1')->get();
			return view('user/profile', ['user' => $user, 'articles' => $articles]);
		}else{
			return redirect('/');
		}
	}

}

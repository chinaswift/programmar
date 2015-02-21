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

	public function curl_get_contents($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public function all($page = 1) {
		if (\Auth::check())
		{
			$followerArray = array();
			$followers = Follower::where('followed_by', '=', Auth::user()->id)->get();

			if(!empty($followers)) {
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

}

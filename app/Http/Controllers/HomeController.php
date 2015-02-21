<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Enjoy;
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

	/**
	 * Index
	 * This decides what to show the user, depending if authed or not.
	 * @return void
	 */
	public function index($page = 1) {
		if (\Auth::check())
		{
			$followerArray = array();
			$article_count = Article::where('published', '=', '1')->orderBy('last_updated', 'asc')->count();
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
					$paginationCtrls .= '<a href="/recent/'.$previous.'" class="f-left '.$class.'">Previous</a>';
				}
			}

			if ($page != $last) {
		        $next = $page + 1;
		        $paginationCtrls .= '<a href="/recent/'.$next.'" class="f-right brand-primary">Next</a>';
		    }

			$articles = Article::where('published', '=', '1')->orderBy('last_updated', 'desc')->skip($page - 1)->take($resultsPerPage)->get();
			foreach ($articles as $article) {
				$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
				$article->userName = $user->{'name'};
				$article->username = $user->{'username'};
				$article->avatar = $user->{'avatar'};
				$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
			}
			return view('home/user', ['articles' => $articles, 'followers' => $followerArray, 'pagination' => $paginationCtrls]);
		}
		else
		{
			return view('home/landing');
		}
	}

}

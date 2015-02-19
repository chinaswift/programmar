<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Article;
use App\User;
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
	public function index() {
		if (\Auth::check())
		{

			$followerArray = array();
			$github_data = json_decode($this->curl_get_contents('https://api.github.com/user/followers?access_token=' . Auth::user()->token), true);
			foreach ($github_data as $github_user) {
				$check = User::where('id', '=', $github_user['id'])->count();
				$array = array(
					'id' => $github_user['id'],
					'avatar' => $github_user['avatar_url'],
					'username' => $github_user['login'],
					'user' => $check
 				);
				array_push($followerArray, $array);
			}

			$articles = Article::where('published', '=', '1')->take(15)->get();

			var_dump($followerArray);
			exit();


			foreach ($articles as $article) {
				$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
				$article->userName = $user->{'name'};
				$article->username = $user->{'username'};
				$article->avatar = $user->{'avatar'};
			}
			return view('home/user', ['articles' => $articles]);
		}
		else
		{
			return view('home/landing');
		}
	}

}

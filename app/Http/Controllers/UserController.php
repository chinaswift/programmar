<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GrahamCampbell\GitHub\GitHubManager;
use App\Article;
use App\User;
use App\Enjoy;
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

	public function followUser($username) {
		$client = new \Guzzle\Service\Client('https://api.github.com/');
		$auth = new \Guzzle\Plugin\Oauth\OauthPlugin([
			'consumer_key' => env('GIT_ID', ''),
			'consumer_secret' => env('GIT_SECRET'),
			'token' => Auth::user()->token
		]);

		$client->addSubscriber($auth);
		$response = $client->put("/user/following/$username?access_token=" . Auth::user()->token)->send();
		var_dump($response->json());
	}

	public function unfollowUser($username) {
		$client = new \Guzzle\Service\Client('https://api.github.com/');
		$auth = new \Guzzle\Plugin\Oauth\OauthPlugin([
			'consumer_key' => env('GIT_ID', ''),
			'consumer_secret' => env('GIT_SECRET'),
			'token' => Auth::user()->token
		]);

		$client->addSubscriber($auth);
		$response = $client->delete("/user/following/$username?access_token=" . Auth::user()->token)->send();
		var_dump($response->json());
	}

	/**
	 * Followers
	 * This is how you can view your followers posts.
	 * @return void
	 */
	public function followers() {
		$followerArray = array();
		$github_data = json_decode($this->curl_get_contents('https://api.github.com/user/following?access_token=' . Auth::user()->token), true);
		foreach ($github_data as $github_user) {
			array_push($followerArray, $github_user['id']);
		}

		$followerArraySecond = array();
		foreach ($github_data as $github_user) {
			$check = User::where('id', '=', $github_user['id'])->count();
			$array = array(
				'id' => $github_user['id'],
				'avatar' => $github_user['avatar_url'],
				'username' => $github_user['login'],
				'user' => $check
				);
			array_push($followerArraySecond, $array);
		}

		$articles = Article::whereIn('user_id', $followerArray)->where('published', '=', '1')->orderBy('last_updated', 'asc')->take(15)->get();
		foreach ($articles as $article) {
			$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
			$article->userName = $user->{'name'};
			$article->username = $user->{'username'};
			$article->avatar = $user->{'avatar'};
			$article->enjoys = Enjoy::where('article_id', '=', $article->{'slug'})->count();
		}
		return view('home/user', ['articles' => $articles, 'followers' => $followerArraySecond]);
	}

	public function drafts() {
		$followerArray = array();
		$github_data = json_decode($this->curl_get_contents('https://api.github.com/user/following?access_token=' . Auth::user()->token), true);
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

		$articles = Article::where('user_id', '=', Auth::user()->id)->where('published', '=', '0')->orderBy('last_updated', 'asc')->take(15)->get();

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
		return view('home/user', ['articles' => $articles, 'followers' => $followerArray]);
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
			$user->followers = json_decode($this->curl_get_contents('https://api.github.com/users/'.$user->username.'/followers?access_token=' . Auth::user()->token), true);
			$user->following = json_decode($this->curl_get_contents('https://api.github.com/users/'.$user->username.'/following?access_token=' . Auth::user()->token), true);
			$user->followingUser = json_decode($this->curl_get_contents('https://api.github.com/user/following/'.$user->username.'?access_token=' . Auth::user()->token), true);

			if($user->followingUser['message'] == 'Not Found') {
				$user->followingUser = false;
			}else{
				$user->followingUser = true;
			}

			$articles = Article::where('user_id', $user->id)->where('published', '=', '1')->get();
			return view('user/profile', ['user' => $user, 'articles' => $articles]);
		}else{
			return redirect('/');
		}
	}

}

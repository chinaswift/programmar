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

class ApiController extends Controller {

	function collectAPIData($type, $url) {
		$programmarApi = new \Guzzle\Service\Client(env('API_URL'));
		$response = $programmarApi->$type($url)->send();
		return $response->json();
	}

	//Collect the users followers
	public function followers($user_id) {
		//Start the logic here
		$result = Follower::where('followed', '=', $user_id)->get();
		$resultArray = array();

		//Collect more data for each
		foreach($result as $follower) {
			$user = User::find($follower->followed_by);
			$userArray = array(
				'user_id' => $user->{'id'},
				'user_name' => $user->{'name'},
				'user_slug' => $user->{'username'},
				'user_avatar' => $user->{'avatar'}
			);
			array_push($resultArray, $userArray);
		}

		$result = $resultArray;
		return json_encode($result);
	}

	//Collect the users following
	public function following($user_id) {
		//Start the logic here
		$result = Follower::where('followed_by', '=', $user_id)->get();
		$resultArray = array();

		//Collect more data for each
		foreach($result as $follower) {
			$user = User::find($follower->followed);
			$userArray = array(
				'user_id' => $user->{'id'},
				'user_name' => $user->{'name'},
				'user_slug' => $user->{'username'},
				'user_avatar' => $user->{'avatar'}
			);
			array_push($resultArray, $userArray);
		}

		$result = $resultArray;
		return json_encode($result);
	}


	//Function for following a user
	public function follow($user_to_follow_id) {

		if(!Auth::check()) {
			return response()->json(['type' => 'error', 'message' => 'Unauthorized'], 400);
		}

		$user_to_follow = User::find($user_to_follow_id);
		$user_id = Auth::user()->id;
		if(empty($user_to_follow)) {
			return response()->json(['type' => 'error', 'message' => 'There was no user with this id'], 400);
		}

		$follow = Follower::firstOrNew(array('followed_by' => $user_id, 'followed' => $user_to_follow_id));
		$follow->followed_by = $user_id;
		$follow->followed = $user_to_follow_id;
		$follow->save();
		return response()->json(['type' => 'success', 'message' => 'Followed'], 200);
	}


	//Function for unfollowing a user
	public function unfollow($user_to_unfollow_id) {

		if(!Auth::check()) {
			return response()->json(['type' => 'error', 'message' => 'Unauthorized'], 400);
		}

		$user_to_unfollow = User::find($user_to_unfollow_id);
		$user_id = Auth::user()->id;

		if(empty($user_to_unfollow)) {
			return response()->json(['type' => 'error', 'message' => 'There was no user with this id'], 400);
		}

		$follow = Follower::where('followed_by', '=', $user_id)->where('followed', '=', $user_to_unfollow_id)->delete();
		return response()->json(['type' => 'success', 'message' => 'Unfollowed'], 200);
	}

	//Function for collecting articles
	public function articles($user_id = 'session') {
		//If session then make sure we select the session ID
		if($user_id === 'session') {
			if(!Auth::check()) {
				return response()->json(['type' => 'error', 'message' => 'Unauthorized'], 400);
			}else{
				$user_id = Auth::user()->id;
			}
		}

		$articles = Article::where('user_id','=', $user_id)->where('published', '=', 1)->get();

		foreach($articles as $article) {
			$enjoyArray = array();
			$enjoys = Enjoy::where('article_id', '=', $article->slug)->get();
			foreach($enjoys as $enjoy) {
				array_push($enjoyArray, $enjoy->user_id);
			}
			$article->enjoys = $enjoyArray;
		}

		return json_encode($articles);
	}

	//Function for collecting articles
	public function article($article_id) {
		$article = Article::where('slug','=', $article_id)->get();
		return json_encode($article);
	}

	//Function for collecting enjoys
	public function enjoys($user_id = 'session') {
		//If session then make sure we select the session ID
		if($user_id === 'session') {
			if(!Auth::check()) {
				return response()->json(['type' => 'error', 'message' => 'Unauthorized'], 400);
			}else{
				$user_id = Auth::user()->id;
			}
		}

		$enjoys = Enjoy::where('user_id','=', $user_id)->get();
		foreach($enjoys as $article) {
			$article_id = $article->article_id;
			$article->article_data = $this->collectAPIData('get', '/api/v2/article/' . $article_id);
		}
		return json_encode($enjoys);
	}

	//Function for collecting user data
	public function user($slug = 'session') {
		//If session then make sure we select the session ID
		if($slug === 'session') {
			if(!Auth::check()) {
				return response()->json(['type' => 'error', 'message' => 'Unauthorized'], 400);
			}else{
				$slug = Auth::user()->username;
			}
		}

		//Check if the user exists
		$user = User::where('username', '=', $slug)->first();
		$user_id = $user->id;

		if(empty($user)) {
			return response()->json(['type' => 'error', 'message' => 'User was not found'], 400);
		}

		$countFollow = Follower::where('followed_by', '=', Auth::user()->id)->where('followed', '=', $user_id)->count();
		if($countFollow > 0) {
			$user->your_following = true;
		}else{
			$user->your_following = false;
		}

		if($user_id === Auth::user()->id) {
			$user->self = true;
		}else{
			$user->self = false;
		}

		$user->followers = $this->collectAPIData('get', '/api/v2/followers/' . $user_id);
		$user->following = $this->collectAPIData('get', '/api/v2/following/' . $user_id);
		$user->enjoys = $this->collectAPIData('get', '/api/v2/enjoys/' . $user_id);
		return json_encode($user);
	}
}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialize;
use App\User;
use Auth;

class OAuthController extends Controller {


	/**
	 * Index
	 * This decides what to show the user, depending if authed or not.
	 * @return void
	 */
	public function access($account) {
		return \Socialize::with($account)->scopes(['user'])->redirect();
	}

	public function confirm($account) {

		if($account === 'logout') {
			Auth::logout();
			return redirect('/');
		}

		$user = Socialize::with($account)->user();

		$name = $user->getName();
		$token = $user->token;
		$email = $user->getEmail();
		$account_id = $user->getId();
		$avatar = $user->getAvatar();
		$username = $user->getNickname();

		$account = User::firstOrNew(array('id' => $account_id));
		$account->name = $name;
		$account->email = $email;
		$account->token = $token;
		$account->id = $account_id;
		$account->avatar = $avatar;
		$account->username = $username;
		$account->save();

		Auth::loginUsingId($account_id);

		$github_data = json_decode($this->curl_get_contents('https://api.github.com/user/following?per_page=100&access_token=' . Auth::user()->token), true);
		foreach ($github_data as $github_user) {
			$check = User::where('id', '=', $github_user['id'])->count();
			if($check > 0) {
				$followUser = Follow::firstOrNew(array('followed_by' => Auth::user()->id, 'followed' => $github_user['id']));
				$followUser->followed_by = Auth::user()->id;
				$followUser->followed = $github_user['id'];
				$followUser->save();
			}
		}

		return redirect('/');
	}

}

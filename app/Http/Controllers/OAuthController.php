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

		return redirect('/');
	}

}

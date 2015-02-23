<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialize;
use App\User;
use App\Follower;
use Auth;

class OAuthController extends Controller {

	//Access the site using socialize
	public function access($account)
	{
		return \Socialize::with($account)->redirect();
	}

	//Logging out the user
	public function logout()
	{
		Auth::logout();
		return redirect('/');
	}

	//Function for pulling curl data
	public function curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.github.com' . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


	//Create the user if the user does not exist in the database
	public function create($account)
	{
		$user = Socialize::with($account)->user();
		$token = $user->token;
		$account_id = $user->getId();
		$avatar = $user->getAvatar();
		$username = $user->getNickname();

		$account = User::firstOrCreate(array('id' => $account_id));
		$account->token = $token;
		$account->id = $account_id;
		$account->avatar = $avatar;
		$account->name = $username;
		$account->username = $username;
		$account->save();

		Auth::loginUsingId($account_id);

		//Collect github followers
		$github_data = json_decode($this->curl('/user/following?per_page=100&access_token=' . $token), true);
		foreach ($github_data as $github_user) {
			$check = User::where('id', '=', $github_user['id'])->count();
			if($check > 0) {
				$followUser = Follower::firstOrCreate(array(
					'followed_by' => Auth::user()->id,
					'followed' => $github_user['id']
				));
				$followUser->followed_by = $account_id;
				$followUser->followed = $github_user['id'];
				$followUser->save();
			}
		}

		//Direct the users to the homepage
		return redirect('/');
	}
}

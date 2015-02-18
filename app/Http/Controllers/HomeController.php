<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use Storage;
use Auth;

class HomeController extends Controller {


	/**
	 * Index
	 * This decides what to show the user, depending if authed or not.
	 * @return void
	 */
	public function index() {
		if (\Auth::check())
		{
			$articles = Article::where('published', '=', '1')->take(15)->get();
			foreach ($articles as $article) {
				$user = User::where('id', '=', $article->{'user_id'})->firstOrFail();
				$article->content = strip_tags(Storage::get($article->{'user_id'} . '/' . $article->slug . '.programmar-article'));
				$article->userName = $user->{'name'};
			}
			return view('home/user', ['articles' => $articles]);
		}
		else
		{
			return view('home/landing');
		}
	}

}

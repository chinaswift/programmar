<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\User;
use Storage;
use Auth;

class ArticleController extends Controller {

	/**
	 * Construct
	 * This allows auth checks to be in place before any of the views are loaded.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function write() {
		return view('article/write');
	}

	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function collect($slug) {
		if($slug != 'write') {
			$data = Article::where('slug', '=', $slug)->firstOrFail();
			$user = User::where('id', '=', $data->{'user_id'})->firstOrFail();
			$data->{'content'} = Storage::get($data->{'user_id'} . '/' . $slug . '.programmar-article');
			$data->{'userName'} = $user->{'name'};
			return $data;
		}
	}

	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function edit($slug) {
		$data = Article::where('slug', '=', $slug)->firstOrFail();
		if($data->user_id === Auth::user()->id) {
			return view('article/write', ['edit' => true, 'slug' => $slug]);
		}else{
			return redirect("/article/" . $slug);
		}
	}


	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function view($slug) {
		$data = Article::where('slug', '=', $slug)->firstOrFail();
		if($data->published != '0') {
			return view('article/view', ['data' => $data, 'slug' => $slug]);
		}else{
			if($data->user_id === Auth::user()->id) {
				return redirect('/edit/' . $slug);
			}else{
				return redirect('/');
			}
		}
	}

	/**
	 * Followers
	 * This is how you can view your followers posts.
	 * @return void
	 */
	public function followers() {
		return view('home/followers');
	}

}

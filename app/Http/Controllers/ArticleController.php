<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Enjoy;
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
			$enjoy = Enjoy::where('user_id', '=', Auth::user()->id)->where('article_id', '=', $slug)->count();
			if($enjoy > 0) {
				$data->{'user_enjoyed'} = true;
			}else{
				$data->{'user_enjoyed'} = false;
			}
			return $data;
		}
	}

	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function edit($slug) {
		$data = Article::where('slug', '=', $slug)->firstOrFail();
		if($data->user_id === Auth::user()->id  || Auth::user()->account_type === 'admin' || Auth::user()->account_type === 'supervisor') {
			return view('article/write', ['edit' => true, 'slug' => $slug]);
		}else{
			return redirect("/article/" . $slug);
		}
	}

	public function enjoy(Request $request) {
		$name = $request->input('name');
		$user_id = Auth::user()->id;
		$check = Enjoy::where('article_id', '=', $name)->where('user_id', '=', $user_id)->count();
		if($check > 0) {
			$enjoyed = Enjoy::firstOrNew(array('article_id' => $name, 'user_id' => $user_id));
			$enjoyed->delete();
		}else{
			$enjoyed = Enjoy::firstOrNew(array('article_id' => $name, 'user_id' => $user_id));
			$enjoyed->user_id = $user_id;
			$enjoyed->article_id = $name;
			$enjoyed->save();
		}

		return response()->json(['type' => 'success', 'message' => 'Enjoyed'], 200);
	}


	/**
	 * Function which shows the write controller
	 * @return void
	 */
	public function view($slug) {
		$data = Article::where('slug', '=', $slug)->firstOrFail();
		$enjoys = Enjoy::where('article_id', '=', $slug)->get();
		$enjoyArray = array();
		$user = User::where('id', '=', $data->{'user_id'})->firstOrFail();
		$data->{'userName'} = $user->{'username'};
		$data->{'enjoy_count'} = Enjoy::where('article_id', '=', $slug)->count();

		foreach($enjoys as $enjoyedUser) {
			$user = User::where('id', '=', $enjoyedUser->{'user_id'})->firstOrFail();
			$array = array(
				'user_id' => $user->{'id'},
				'user_name' => $user->{'username'},
				'user_avatar' => $user->{'avatar'}
			);
			array_push($enjoyArray, $array);
		}

		if($data->published != '0') {
			return view('article/view', ['data' => $data, 'slug' => $slug, 'enjoys' => $enjoyArray]);
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

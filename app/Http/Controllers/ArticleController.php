<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

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
	public function edit($slug) {
		return view('article/write', ['edit' => true, 'slug' => $slug]);
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

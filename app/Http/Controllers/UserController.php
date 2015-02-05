<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller {

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
	 * Write
	 * This is the main write page for the developers.
	 * @return void
	 */
	public function write() {
		return view('user/write');
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

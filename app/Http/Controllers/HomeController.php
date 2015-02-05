<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller {


	/**
	 * Index
	 * This decides what to show the user, depending if authed or not.
	 * @return void
	 */
	public function index() {
		if (\Auth::check())
		{
			return view('home/digest');
		}
		else
		{
			return view('home/landing');
		}
	}

}

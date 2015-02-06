<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;

class EditorController extends Controller {

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
	 * [save description]
	 * @return [type]
	 */
	public function save()
	{
		$title = Input::get('title');
		$content = Input::get('content');

		if(\Auth::check()) {
			if (!Storage::exists('members/' . Auth::user()->id) {
				Storage::makeDirectory('members/' . Auth::user()->id, 777);
				return response()->json(['type' => 'error', 'message' => 'Created folder'], 200);
			}

			return response()->json(['type' => 'error', 'message' => 'You need to be logged in to save.'], 200);

		}else{
			return response()->json(['type' => 'error', 'message' => 'You need to be logged in to save.'], 400);
		}

	}

}

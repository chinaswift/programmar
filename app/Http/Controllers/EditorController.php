<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Auth;
use Storage;
use App\Article;

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
	public function save(Request $request)
	{
		$title = $request->input('title');
		$content = $request->input('content');
		$name = $request->input('name', '');

		if(Auth::check()) {
			$exists = Storage::exists(Auth::user()->id);
			if(!$exists) {
				Storage::makeDirectory(Auth::user()->id);
			}

			//Check file name
			if($name == '') { $name = time(); }
			//make file name
			$file = $name . '.programmar-article';
			$directory = Auth::user()->id;
			$location = $directory . '/' . $file;

			if($content != '') {
				Storage::put($location, $content);
			}

			//save the information if we haven't already
			$article = Article::firstOrNew(array('slug' => $name, 'user_id' => Auth::user()->id));
			$article->user_id = Auth::user()->id;
			$article->title = $title;
			$article->slug = $name;
			$article->published = '0';
			$article->last_updated = $name;
			$article->save();

			//Send response back
			return response()->json(['type' => 'success', 'message' => 'Saved', 'name' => $name], 200);

		}else{
			return response()->json(['type' => 'error', 'message' => 'You need to be logged in to save.'], 400);
		}

	}


	public function publish(Request $request)
	{
		$title = $request->input('title');
		$content = $request->input('content');
		$name = $request->input('name', '');

		if(Auth::check()) {
			$exists = Storage::exists(Auth::user()->id);
			if(!$exists) {
				Storage::makeDirectory(Auth::user()->id);
			}

			//Check file name
			if($name == '') { $name = time(); }
			//make file name
			$file = $name . '.programmar-article';
			$directory = Auth::user()->id;
			$location = $directory . '/' . $file;

			if($content != '') {
				Storage::put($location, $content);
			}

			//save the information if we haven't already
			$article = Article::firstOrNew(array('slug' => $name, 'user_id' => Auth::user()->id));
			$article->user_id = Auth::user()->id;
			$article->title = $title;
			$article->slug = $name;
			$article->published = '1';
			$article->last_updated = $name;
			$article->save();

			//Send response back
			return response()->json(['type' => 'success', 'message' => 'Published', 'name' => $name], 200);

		}else{
			return response()->json(['type' => 'error', 'message' => 'You need to be logged in to save.'], 400);
		}

	}

}

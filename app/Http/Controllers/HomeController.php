<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect(Request $request)
    {
    	if ($request->session()->get('x-auth-token')) {
    		return redirect('/feed/following');
    	}else{
    		return redirect('/feed/recent');
    	}
    }

    public function feed($feed_type)
    {
        return view('home.feed')->with('type', $feed_type);
    }
}

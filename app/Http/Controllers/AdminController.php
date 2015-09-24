<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display the styleguide for the developers to work on.
     *
     * @return \Illuminate\Http\Response
     */
    public function styleguide()
    {
        return view('admin.styleguide');
    }

}

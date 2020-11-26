<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ImageController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('images');
    }
}

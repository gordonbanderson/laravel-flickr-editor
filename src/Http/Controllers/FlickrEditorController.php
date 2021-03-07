<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Http\Controllers;

use Illuminate\Routing\Controller;
use Suilven\Boris\Helper\IndexHelper;
use Suilven\Boris\Models\Quote;

/**
 * Class FlickrEditorController
 *
 * @package Suilven\FlickrEditor\Http\Controllers
 *
 * @phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
 */
class FlickrEditorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }


    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return \view('flickr-editor::editor');
    }

}

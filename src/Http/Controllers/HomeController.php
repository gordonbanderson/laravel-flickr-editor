<?php

namespace Suilven\FlickrEditor\Http\Controllers;

use _HumbugBox58fd4d9e2a25\Cassandra\Index;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Manticoresearch\Search;
use Suilven\Boris\Helper\IndexHelper;
use Suilven\Boris\Models\Quote;

class HomeController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boris::home');
    }


    public function show($slug)
    {
        $result = Quote::where('slug', $slug)->first();

        return view('boris::quotation', compact('result'));
    }


    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'required',
        ]);

        $q = $request->q;
        $page = isset($request->page) ? $request->page:0;

        $helper = new IndexHelper();
        $searchClient = $helper->getClient();

        $searcher = new Search($searchClient);
        $searcher->setIndex(IndexHelper::INDEX_NAME);
        $searcher->offset(10*($page-1));

        // @todo make ths configurable
        $searcher->limit(10);

        $searcher->highlight(
            [],
            ['pre_tags' => '<b>', 'post_tags'=>'</b>']
        );

        $searchResults = $searcher->search($q)->get();
        $results = $this->makeSearchResultsRenderable($searchResults);

        $paginator = new LengthAwarePaginator($results, $searchResults->getTotal(), 10);
        $paginator->setPath('/search/?q=' . $q);


        return view('boris::search', compact('q', 'results', 'paginator'));
    }

    /**
     * @param \Manticoresearch\ResultSet $searchResults
     * @return array
     */
    public function makeSearchResultsRenderable(\Manticoresearch\ResultSet $searchResults): array
    {
        $results = [];
        foreach ($searchResults as $doc) {
            $data = $doc->getData();
            $highlights = $doc->getHighlight();

            $result = new \stdClass();
            $result->title = $data['title'];
            $result->highlights = implode('...', $highlights['quotation']);
            $result->link = '/show/' . $data['slug'];

            $results[] = $result;
        }
        return $results;
    }
}
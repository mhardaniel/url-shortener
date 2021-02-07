<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
    {
		// return response()->json(
        //     array(
        //     'data' => Url::latest()->get(),
        //     )
		// );

		return Inertia::render('UrlShortener', array( 'data' => Url::latest()->get() ));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreUrlRequest $request)
    {

		// Validator::make(
		// 	$request->all(),
		// 	array(
		// 		'original_link' => 'bail|required|url',
		// 	)
		// )->validate();

		$url = Url::firstOrCreate(
			array(
				'original_link' => $request->original_link,
			),
			array(
				'short_link' => Str::random(6),
			)
		);

		// return redirect()->back()
		// 			->with('success', 'URL Created Successfully.');
        return redirect()->route('urls.show', [$url])->with('success', 'URL Created Successfully.');

		// return response()->json(
        //     [
        //         'success' => true,
        //         'url' => $url,
        //     ]
		// );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Url $url
	 * @return \Illuminate\Http\Response
	 */
	public function show(Url $url)
    {
        return Inertia::render('URL/Show', [
            'url' => new UrlResource($url),
        ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Models\Url          $url
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Url $url)
    {
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Url $url
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Url $url)
    {
        $url->delete();
        return redirect()->back()->with('success', 'URL Deleted Successfully.');
	}

	public function redirect($url)
    {
		$url = Url::where('short_link', $url)->first();
		if ($url) {
			return redirect()->away($url->original_link);
		}
		return redirect('/')->with('error', 'URL not found!');
	}
}

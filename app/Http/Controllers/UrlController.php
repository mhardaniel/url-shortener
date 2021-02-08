<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Resources\UrlResource;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UrlController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
    {
		try {
            //code...
            return Inertia::render('UrlShortener', array( 'data' => Url::latest()->get() ));
        } catch (\Throwable $th) {
            //throw $th;
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreUrlRequest $request)
    {
        try {
            //code...
            $url = Url::firstOrCreate(
                array(
                    'original_link' => $request->original_link,
                ),
                array(
                    'short_link' => Str::random(6),
                )
            );

            return redirect()->route('urls.show', [$url])->with('success', 'URL Created Successfully.');
        } catch (\Throwable $th) {
            //throw $th;
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Url $url
	 * @return \Illuminate\Http\Response
	 */
	public function show(Url $url)
    {
        try {
            return Inertia::render('URL/Show', [
                'url' => new UrlResource($url),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
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
        try {
            $url->delete();
            return redirect()->back()->with('success', 'URL Deleted Successfully.');
        } catch (\Throwable $th) {
            //throw $th;
        }
	}

	public function redirect($url)
    {
        try {
            $url = Url::where('short_link', $url)->first();
            if ($url) {
                return redirect()->away($url->original_link);
            }
            return redirect('/')->with('error', 'URL not found!');
        } catch (\Throwable $th) {
            //throw $th;
        }
	}
}

<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/guide'));

        $guides = $response->json('data');

        return view('guide.index', ['guides' => $guides]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get(url('/api/gameRelease'));
        $gameReleases = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/language'));
        $languages = $response->json('data');

        return view('guide.create', ['gameReleases' => $gameReleases, 'languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Guide $guide)
    {
        $token = session('api_token');

        $encryptedId = Crypt::encryptString($guide->id);
        $response = Http::withToken($token)->get(url('/api/guide/' . $encryptedId));

        $guide = $response->json('data');

        return view('guide.show', ['guide' => $guide]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

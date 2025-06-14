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
        $data = $request->all();
        $data['correo'] = auth()->user()->email;

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/guide'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear la guía']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.index');
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
    public function edit(Guide $guide)
    {
        $token = session('api_token');

        $encryptedId = Crypt::encryptString($guide->id);
        $response = Http::withToken($token)->get(url('/api/guide/' . $encryptedId));

        $guide = $response->json('data');

        $response = Http::withToken($token)->get(url('/api/gameRelease'));
        $gameReleases = $response->json('data');
        $response = Http::withToken($token)->get(url('/api/language'));
        $languages = $response->json('data');

        return view('guide.edit', ['guide' => $guide, 'gameReleases' => $gameReleases, 'languages' => $languages]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guide $guide)
    {
        $data = $request->all();
        $data['correo'] = auth()->user()->email;

        $token = session('api_token');
        $encryptedId = Crypt::encryptString($guide->id);
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/guide/' . $encryptedId), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar la guía']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        $token = session('api_token');
        $encryptedId = Crypt::encryptString($guide->id);
        $response = Http::withToken($token)->delete(url('/api/guide/' . $encryptedId));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar la guía']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }

        return redirect()->route('guide.index');
    }
}

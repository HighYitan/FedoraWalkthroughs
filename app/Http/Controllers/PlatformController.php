<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/platform'));

        $platforms = $response->json('data');

        return view('platform.index', ['platforms' => $platforms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('platform.create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post(url('/api/platform'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear la plataforma']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('platform.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/platform/' . $platform->name));

        $platform = $response->json('data');

        return view('platform.show', ['platform' => $platform]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/platform/' . $platform->name));

        $platform = $response->json('data');

        $response = Http::withToken($token)->get(url('/api/company'));
        $companies = $response->json('data');

        return view('platform.edit', ['platform' => $platform, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $data = $request->all();

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/platform/' . $platform->name), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar la plataforma']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('platform.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->delete(url('/api/platform/' . $platform->name));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar la plataforma']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }

        return redirect()->route('platform.index');
    }
}

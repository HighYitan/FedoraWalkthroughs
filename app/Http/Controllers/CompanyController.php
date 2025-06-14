<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/company'));

        $companies = $response->json('data');

        return view('company.index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = session('api_token');

        $response = Http::withToken($token)->get(url('/api/language'));
        $languages = $response->json('data');

        return view('company.create', ['languages' => $languages]);
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
        ])->post(url('/api/company'), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al crear la compañía']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/company/' . $company->name));

        $company = $response->json('data');

        return view('company.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->get(url('/api/company/' . $company->name));

        $company = $response->json('data');

        $response = Http::withToken($token)->get(url('/api/language'));
        $languages = $response->json('data');

        return view('company.edit', ['company' => $company, 'languages' => $languages]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->all();

        $token = session('api_token');
        $response = Http::withToken($token)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->put(url('/api/company/' . $company->name), $data);

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al actualizar la compañía']];
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($apiErrors);
        }

        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->delete(url('/api/company/' . $company->name));

        if ($response->failed()) {
            $apiErrors = $response->json('errors') ?? ['api' => ['Error al eliminar la compañía']];
            return redirect()
                ->back()
                ->withErrors($apiErrors);
        }

        return redirect()->route('company.index');
    }
}

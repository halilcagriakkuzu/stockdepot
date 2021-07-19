<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Depot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.edit', [
            'new' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = key_exists('is_active', $validated) ? 1 : 0;
        $validated['created_by'] = Auth::user()->id;

        $company = Company::create($validated);
        $request->session()->flash('success', 'Firma başarıyla oluşturuldu!');
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', [
            'company' => $company,
            'new' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = key_exists('is_active', $validated) ? 1 : 0;
        $validated['updated_by'] = Auth::user()->id;

        $company->update($validated);
        $request->session()->flash('success', 'Firma başarıyla düzenlendi!');
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['updated_by' => Auth::user()->id]);
        Company::destroy($id);
        Session::flash('success', 'Firma başarıyla silindi!');
        return redirect()->route('companies.index');
    }
}

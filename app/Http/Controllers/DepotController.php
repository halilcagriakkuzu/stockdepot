<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class DepotController extends Controller
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
        $depots = Depot::all();
        return view('depots.index', [
            'depots' => $depots
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('depots.edit', [
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
            'description' => 'nullable',
        ]);

        $depot = Depot::create($validated);
        $request->session()->flash('success', 'Depo başarıyla oluşturuldu!');
        return redirect()->route('depots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $depot = Depot::find($id);
        $products = Product::select('products.*', 'categories.name')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('product_statuses', 'product_statuses.id', 'products.product_status_id')
            ->where('product_statuses.name', '=', Product::STATUS_IN_DEPOT)
            ->where('categories.depot_id', '=', $id)
            ->get();

        return view('depots.show', [
            'depot' => $depot,
            'products' => $products
        ]);
    }

    public function showMaintenance()
    {
        $products = Product::select('products.*', 'categories.name')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('product_statuses', 'product_statuses.id', 'products.product_status_id')
            ->where('product_statuses.name', '=', Product::STATUS_IN_MAINTENANCE)
            ->get();

        return view('depots.show', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depot = Depot::findOrFail($id);
        return view('depots.edit', [
            'depot' => $depot,
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
        $depot = Depot::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $depot->update($validated);
        $request->session()->flash('success', 'Depo başarıyla düzenlendi!');
        return redirect()->route('depots.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Depot::destroy($id);
        Session::flash('success', 'Depo başarıyla silindi!');
        return redirect()->route('depots.index');
    }
}

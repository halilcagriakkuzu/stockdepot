<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Depot;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ProductController extends Controller
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
        $products = Product::with('productStatus')
            ->join('categories', 'categories.id', 'products.category_id')
            ->whereNull('categories.deleted_at')
            ->select('products.*')
            ->get();
        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.edit', [
            'new' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'nullable',
            'make' => 'required',
            'model' => 'required',
            'shelf_no' => 'nullable',
            'row_no' => 'nullable',
            'count' => 'nullable',
            'unavailable_count' => 'nullable',
            'description' => 'nullable',
            'buy_price' => 'nullable',
            'buy_date' => 'nullable',
            'category_id' => 'required',
        ]);

        $validated['product_status_id'] = ProductStatus::where('name', '=', Product::STATUS_IN_DEPOT)->first()->id;

        $product = Product::create($validated);
        $request->session()->flash('success', 'Malzeme başarıyla oluşturuldu!');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('productStatus')
            ->with('category')
            ->where('products.id', '=', $id)
            ->firstOrFail();
        $transactions = ProductTransaction::with('rentForm')
            ->with('createdBy')
            ->with('rentForm')
            ->where('product_id', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('products.show', [
            'product' => $product,
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', [
            'product' => $product,
            'new' => false,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required',
            'serial_number' => 'nullable',
            'make' => 'required',
            'model' => 'required',
            'shelf_no' => 'nullable',
            'row_no' => 'nullable',
            'count' => 'nullable',
            'description' => 'nullable',
            'buy_price' => 'nullable',
            'buy_date' => 'nullable',
        ]);

        if (array_key_exists('buy_date', $validated) && !empty($validated['buy_date'])) {
            $validated['buy_date'] = date_create_from_format("d/m/Y", $validated['buy_date']);
        }

        $product->update($validated);
        $request->session()->flash('success', 'Malzeme başarıyla düzenlendi!');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::destroy($id);
        Session::flash('success', 'Malzeme başarıyla silindi!');
        return redirect()->route('products.index');
    }
}

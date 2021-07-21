<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\RentForm;
use App\Models\RentFormProduct;
use App\Models\RentFormStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RentFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();

        return view('rentForms.edit', [
            'new' => true,
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'interlocutor_name' => 'required',
            'interlocutor_email' => 'required',
            'interlocutor_phone' => 'required',
            'price' => 'nullable',
            'currency' => 'nullable',
            'company_id' => 'required',
        ]);

        $validated['rent_form_status_id'] = RentFormStatus::where('name', '=', 'DRAFT')->first()->id;
        $validated['created_by'] = Auth::user()->id;

        $rentForm = RentForm::create($validated);
        $request->session()->flash('success', 'Kiralama formu başarıyla oluşturuldu! Şimdi forma malzeme ekleyebilirsiniz.');
        return redirect()->route('rentForms.edit', ['rentForm' => $rentForm]);
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

    public function removeProductFromRentForm($id, $productId)
    {
        $rentFormProduct = RentFormProduct::where('product_id', '=', $productId)
            ->where('rent_form_id', '=', $id)
            ->firstOrFail();

        $rentFormProduct->forceDelete();
        Session::flash('info', 'Malzeme formdan çıkartıldı');
        return redirect()->route('rentForms.edit', ['rentForm' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rentForm = RentForm::findOrFail($id);
        $companies = Company::all();
        $rentFormProducts = RentFormProduct::with('rentForm')
            ->with('product')
            ->where('rent_form_id', '=', $rentForm->id)
            ->get();
        $products = Product::select('products.*', 'categories.name')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('product_statuses', 'product_statuses.id', 'products.product_status_id')
            ->where('product_statuses.name', '!=', 'DISABLED')
            ->whereNotIn('products.id', $rentFormProducts->pluck('product_id'))
            ->get();
        return view('rentForms.edit', [
            'new' => false,
            'companies' => $companies,
            'products' => $products,
            'rentForm' => $rentForm,
            'rentFormProducts' => $rentFormProducts
        ]);
    }

    public function addForm($id, $productId)
    {
        $rentForm = RentForm::with('rentFormStatus')
            ->with('company')
            ->with('createdBy')
            ->where('id', '=', $id)
            ->firstOrFail();
        $product = Product::with('productStatus')
            ->with('category')
            ->where('products.id', '=', $id)
            ->firstOrFail();
        return view('rentForms.addForm', [
            'product' => $product,
            'rentForm' => $rentForm
        ]);
    }

    public function addFormStore(Request $request, $id, $productId)
    {
        $rentForm = RentForm::findOrFail($id);
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'description' => 'nullable',
            'count' => 'nullable',
        ]);

        $validated['rent_form_id'] = $rentForm->id;
        $validated['product_id'] = $product->id;
        $validated['created_by'] = Auth::user()->id;

        $rentFormProduct = RentFormProduct::create($validated);
        $request->session()->flash('success', 'Malzeme başarıyla eklendi!');
        return redirect()->route('rentForms.edit', ['rentForm' => $rentForm->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

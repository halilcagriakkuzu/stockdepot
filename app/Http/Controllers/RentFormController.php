<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\ProductTransaction;
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
        $rentForms = RentForm::with('company')
            ->with('createdBy')
            ->get();
        return view('rentForms.index', [
            'rentForms' => $rentForms
        ]);
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
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $rentForm = RentForm::with('rentFormStatus')
            ->with('company')
            ->where('rent_forms.id', '=', $id)
            ->firstOrFail();
        $rentFormProducts = RentFormProduct::with('rentForm')
            ->with('product')
            ->with('createdBy')
            ->with('updatedBy')
            ->where('rent_form_id', '=', $rentForm->id)
            ->get();
        $products = Product::select('products.*', 'categories.name')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('product_statuses', 'product_statuses.id', 'products.product_status_id')
            ->where('product_statuses.name', '!=', 'DISABLED')
            ->whereNotIn('products.id', $rentFormProducts->pluck('product_id'))
            ->get();

        return view('rentForms.show', [
            'products' => $products,
            'rentForm' => $rentForm,
            'rentFormProducts' => $rentFormProducts
        ]);
    }

    public function removeProductFromRentForm($id, $productId)
    {
        $rentFormProduct = RentFormProduct::where('product_id', '=', $productId)
            ->where('rent_form_id', '=', $id)
            ->firstOrFail();

        /*if ($rentFormProduct->count > 0) {
            $rentFormProduct->product->unavailable_count -= $rentFormProduct->count;
            $rentFormProduct->product->save();
        }*/

        $rentFormProduct->forceDelete();
        Session::flash('info', 'Malzeme formdan çıkartıldı');
        return redirect()->route('rentForms.edit', ['rentForm' => $id]);
    }

    public function removeProductFromActiveRentForm($id, $productId)
    {
        // TODO:!!!
        $rentFormProduct = RentFormProduct::where('product_id', '=', $productId)
            ->where('rent_form_id', '=', $id)
            ->firstOrFail();

        /*if ($rentFormProduct->count > 0) {
            $rentFormProduct->product->unavailable_count -= $rentFormProduct->count;
            $rentFormProduct->product->save();
        }*/

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

    public function addForm($id, $productId, $active = false)
    {
        $rentForm = RentForm::with('rentFormStatus')
            ->with('company')
            ->with('createdBy')
            ->where('id', '=', $id)
            ->firstOrFail();
        $product = Product::with('productStatus')
            ->with('category')
            ->where('products.id', '=', $productId)
            ->firstOrFail();
        return view('rentForms.addForm', [
            'product' => $product,
            'rentForm' => $rentForm,
            'active' => $active
        ]);
    }

    public function addFormStore(Request $request, $id, $productId, $active = false)
    {
        $rentForm = RentForm::findOrFail($id);
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'description' => 'nullable',
            'count' => 'nullable',
        ]);

        $validated['rent_form_id'] = $rentForm->id;
        $validated['product_id'] = $product->id;
        $validated['created_by'] = Auth::user()->id;

        if ($active && array_key_exists('count', $validated) && $validated['count'] > 0) {
            // TODO: !!!
            $product->unavailable_count += $validated['count'];
            $product->save();
        }

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
        $rentForm = RentForm::findOrFail($id);
        $validated = $request->validate([
            'interlocutor_name' => 'required',
            'interlocutor_email' => 'required',
            'interlocutor_phone' => 'required',
            'price' => 'nullable',
            'currency' => 'nullable',
            'company_id' => 'required',
        ]);

        $validated['updated_by'] = Auth::user()->id;

        $rentForm->update($validated);
        $request->session()->flash('success', 'Kiralama formu bilgileri başarıyla düzenlendi!');
        return redirect()->route('rentForms.edit', ['rentForm' => $rentForm]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $rentForm = RentForm::with('rentFormProducts')->findOrfail($id);
        foreach ($rentForm->rentFormProducts as $rentFormProduct) {
            $rentFormProduct->forceDelete();
        }
        $rentForm->forceDelete();
        Session::flash('success', 'Taslak form başarıyla silindi!');
        return redirect()->route('rentForms.index');
    }

    public function activateRentForm(Request $request, $id)
    {
        $rentForm = RentForm::with('rentFormProducts')
        ->findOrFail($id);

        foreach ($rentForm->rentFormProducts as $rentFormProduct) {
            $statusRented = ProductStatus::where('name', '=', 'RENTED')->firstOrFail();
            $actionRented = Action::where('type', '=', 'RENT_TO_COMPANY')->firstOrFail();

            $product = Product::findOrFail($rentFormProduct->product->id);
            $requestPayload = [
                'product_id' => $product->id,
                'created_by' => Auth::user()->id,
                'action_id' => $actionRented->id,
                'description' => $rentFormProduct->description
            ];
            if (!empty($rentFormProduct->count) && $rentFormProduct->count > 0) {
                $product->unavailable_count += $rentFormProduct->count;
                $requestPayload['count'] = $rentFormProduct->count;
            }
            ProductTransaction::create($requestPayload);
            $product->product_status_id = $statusRented->id;
            $product->save();
        }

        $statusActive = RentFormStatus::where('name', '=', 'ACTIVE')->first();
        $rentForm->rent_form_status_id = $statusActive->id;
        $rentForm->update();

        $request->session()->flash('success', 'Kiralama aktifleştirildi!');
        return redirect()->route('rentForms.index');
    }
}

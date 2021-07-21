<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\ProductTransaction;
use App\Models\RentFormProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendToMaintenance(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $statusMaintenance = ProductStatus::where('name', '=', 'IN_MAINTENANCE')->firstOrFail();
        $actionMaintenance = Action::where('type', '=', 'SEND_TO_MAINTENANCE_FROM_DEPOT')->firstOrFail();
        if ($product->productStatus->name == 'RENTED') {
            $rentFormProduct = RentFormProduct::where('product_id', '=', $id)
                ->orderBy('created_at', 'DESC')
                ->firstOrFail();

            $actionMaintenance = Action::where('type', '=', 'RENT_BACK_FROM_COMPANY_TO_MAINTENANCE')->firstOrFail();
            $rentFormProduct->deleted_by = Auth::user()->id;
            $rentFormProduct->save();
            $rentFormProduct->delete();
        }

        $requestPayload = [
            'product_id' => $product->id,
            'created_by' => Auth::user()->id,
            'action_id' => $actionMaintenance->id,
            'description' => $request->get('description')
        ];
        ProductTransaction::create($requestPayload);

        $product->product_status_id = $statusMaintenance->id;
        $product->save();

        Session::flash('success', "Ürün ölçü/bakım'a gönderildi!");
        return redirect()->route('products.show', ['product' => $product]);
    }

    public function markAsDisabled(Request $request, $id)
    {
        $statusDisabled = ProductStatus::where('name', '=', 'DISABLED')->firstOrFail();
        $actionDisabled = Action::where('type', '=', 'MARK_AS_DISABLED')->firstOrFail();

        $product = Product::findOrFail($id);
        $requestPayload = [
            'product_id' => $product->id,
            'created_by' => Auth::user()->id,
            'action_id' => $actionDisabled->id,
            'description' => $request->get('description')
        ];

        ProductTransaction::create($requestPayload);
        $product->product_status_id = $statusDisabled->id;
        $product->save();

        Session::flash('success', "Ürün kullanım dışı olarak işaretlendi!");
        return redirect()->route('products.show', ['product' => $product]);
    }

    public function sendToDepot(Request $request, $id)
    {
        $statusMaintenance = ProductStatus::where('name', '=', 'IN_DEPOT')->firstOrFail();
        $actionMaintenance = Action::where('type', '=', 'SEND_TO_DEPOT_FROM_MAINTENANCE')->firstOrFail();

        $product = Product::findOrFail($id);
        $requestPayload = [
            'product_id' => $product->id,
            'created_by' => Auth::user()->id,
            'action_id' => $actionMaintenance->id,
            'description' => $request->get('description')
        ];
        ProductTransaction::create($requestPayload);

        $product->product_status_id = $statusMaintenance->id;
        $product->save();

        Session::flash('success', "Ürün depoya gönderildi!");
        return redirect()->route('products.show', ['product' => $product]);
    }

    public function changeProductStatus($id, $status)
    {
        $product = Product::findOrFail($id);
        $status = ProductStatus::where('name', '=', $status)->firstOrFail();
        return view('productStatuses.changeStatus', [
            'product' => $product,
            'status' => $status
        ]);
    }
}

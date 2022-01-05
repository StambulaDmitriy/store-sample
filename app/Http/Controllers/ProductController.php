<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        $stores = Store::all();
        return view('admin.products.edit',compact('stores'));
    }

    public function store(ProductStoreRequest $request)
    {
        $validated = Arr::except($request->validated(),'store_products');

        $product = Product::create($validated);

        $store_products_stock = [];
        foreach ($request->store_products as $store_id => $store_product_stock) {
            if ($store_product_stock > 0) {
                $store_products_stock[$store_id] = [
                    'stock_quantity' => $store_product_stock
                ];
            }
        }

        $product->stores()->sync($store_products_stock);

        return redirect()->route('admin.products.index')->with('success','Продукт успешно добавлен');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $stores = Store::leftJoin('store_products', function ($join) use ($id) {
            $join->on('stores.id', '=', 'store_products.store_id')->where('store_products.product_id',$id);
        })->get();
        return view('admin.products.edit',compact('stores','product'));

    }

    public function update(ProductStoreRequest $request, $id)
    {
        $product = Product::find($id);
        if ($product != null) {

            $validated = Arr::except($request->validated(),'store_products');

            $product->fill($validated)->save();

            $store_products_stock = [];
            foreach ($request->store_products as $store_id => $store_product_stock) {
                if ($store_product_stock > 0) {
                    $store_products_stock[$store_id] = [
                        'stock_quantity' => $store_product_stock
                    ];
                }
            }

            $product->stores()->sync($store_products_stock);
        }
        return redirect()->route('admin.products.index')->with('success','Продукт успешно отредактирован');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();

        return redirect()->route('admin.products.index');
    }

    public function export() {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{

    public function index()
    {
        $stores = Store::with('products')->paginate(20);
        return view('admin.stores.index',compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.edit');
    }


    public function store(StoreStoreRequest $request)
    {
        Store::create($request->validated());

        return redirect()->route('admin.stores.index')->with('success','Магазин успешно добавлен');
    }

    public function edit($id)
    {
        $store = Store::findOrFail($id);

        return view('admin.stores.edit',compact('store'));
    }

    public function update(StoreStoreRequest $request, $id)
    {
        $store = Store::find($id);
        if ($store != null) {
            $store->fill($request->validated())->save();
        }

        return redirect()->route('admin.stores.index')->with('success','Магазин успешно отредактирован');
    }

    public function destroy($id)
    {
        Store::find($id)->delete();

        return redirect()->route('admin.stores.index');
    }
}

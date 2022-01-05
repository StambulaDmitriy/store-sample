<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use stdClass;

class IndexPageController extends Controller
{
    public function index() {
        $products = Product::withSum('stores as total_quantity','store_products.stock_quantity')->paginate(16);
        return view('index',compact('products'));
    }

    public function show_product($id) {
        $product = Product::with('stores')->findOrFail($id);

        $stores = Store::leftJoin('store_products', function ($join) use ($id) {
            $join->on('stores.id', '=', 'store_products.store_id')->where('store_products.product_id',$id);
        })->get();

        return view('show-product',compact('product','stores'));
    }

    public function api_get_product_stock_placemarks($id) {
        $placemarks = [];

        $product = Product::with('stores')->find($id);

        foreach ($product->stores as $store) {
            $placemark_object = new stdClass;

            $placemark_object->type = "Feature";
            $placemark_object->id = $store->id;

            $placemark_object->geometry = new stdClass;
            $placemark_object->geometry->type = "Point";
            $placemark_object->geometry->coordinates = [$store->coordinate_lat, $store->coordinate_long];

            $placemark_object->properties = new stdClass;
            $placemark_object->properties->balloonContentHeader = $store->name;
            $placemark_object->properties->balloonContentBody = "Адрес магазина: {$store->address}</br>В наличии: {$store->pivot->stock_quantity} шт.";

            $placemarks[] = $placemark_object;
        }

        return response()->json(['type' => 'FeatureCollection','features' => $placemarks]);

    }
}

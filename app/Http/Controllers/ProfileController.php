<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function dashboard_index() {
        $stores_count =  Store::count();
        $products_count =  Product::count();
        return view('admin.dashboard',compact('stores_count','products_count'));
    }

    public function update_settings(Request $request)
    {
        $request->validate([
            'datatables_update_rate_ms' => ['required','integer','min:1000']
        ]);

        Auth::user()->settings()->updateOrCreate([],['datatables_update_rate_ms' => $request->datatables_update_rate_ms]);

        return redirect()->route('admin.profile.show')->with('success', 'Настройки обновлены');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile.show')->with('success', 'Данные обновлены.');
    }
}

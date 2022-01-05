<?php

namespace App\Exports;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductsExport implements FromArray, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
{
    public $products;
    public $stores;

    public function __construct()
    {
        $this->products = Product::with('stores')->get();
        $this->stores = Store::all();
    }

    public function array(): array
    {

        $res = [];
        foreach ($this->products as $product) {
            $row = (new ProductResource($product))->toArray([]);

            foreach ($this->stores as $store) {
                $store_with_products_quantity = $product->stores->firstWhere('id',$store->id);
                if ($store_with_products_quantity != null) {
                    $row[] = $store_with_products_quantity->pivot->stock_quantity;
                } else {
                    $row[] = 0;
                }
            }

            $res[] = $row;
        }

        return $res;
    }

    public function headings(): array
    {
        $headings = [
            'Название',
            'Артикул',
            'Цена',
            'Создан',
            'Обновлён',
        ];
        $headings = collect($headings)->concat(array_values($this->stores->pluck('name')->all()));

        return $headings->all();
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }
}

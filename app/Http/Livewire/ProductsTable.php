<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductsTable extends DataTableComponent
{
    public $refresh = 5000;

    public array $bulkActions = [
        'delete' => 'Удалить выбранные',
    ];

    public function columns(): array
    {
        return [
            Column::make('Название', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Артикул', 'vendor_code')
                ->searchable(),
            Column::make('Статус')
                ->format(function($value, $column, $product) {
                    return view('partials.product-status',['product' => $product]);
                }),
            Column::make('Цена', 'formatted_price')
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy('price_in_pennies', $direction);
                }),
            Column::make('Создан', 'updated_at')
                ->sortable(),
            Column::make('Обновлён', 'updated_at')
                ->sortable(),

        ];
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make('Статус')
                ->multiSelect([
                    'many' => 'Много',
                    'few' => 'Мало',
                    'only_in_one_store' => 'Только в одном магазине',
                ]),
        ];
    }

    public function query(): Builder
    {
        $statuses = $this->getFilter('status');
        $status_few = in_array('few',$statuses);
        $status_many = in_array('many',$statuses);
        $status_only_one_store = in_array('only_in_one_store',$statuses);


        return Product::withCount('stores')->withSum('stores as total_quantity','store_products.stock_quantity')
            ->when($status_many, function($query) {
                $query->having('total_quantity', '>', 500);
            })
            ->when($status_few, function($query) {
                $query->having('total_quantity', '<', 5);
            })
            ->when($status_only_one_store, function($query) {
                $query->having('stores_count', '=', 1);
            });
    }

    public function getTableRowUrl($row): string
    {
        return route('admin.products.edit', $row);
    }

    public function delete() {
        $this->selectedRowsQuery->delete();
        $this->resetAll();
    }


}

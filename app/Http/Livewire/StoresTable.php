<?php

namespace App\Http\Livewire;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StoresTable extends DataTableComponent
{
    public $refresh = 5000;

    public array $bulkActions = [
        'delete' => 'Удалить выбранные',
    ];

    public function columns(): array
    {
        return [
            Column::make('Название','name')
                ->sortable()
                ->searchable(),
            Column::make('Адрес','address')
                ->searchable(),
            Column::make('Позиций','products_count'),
            Column::make('Товаров','total_quantity')
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy('total_quantity', $direction);
                }),
            Column::make('График работы','schedule'),
            Column::make('Телефон','phone'),
            Column::make('Создан', 'updated_at')
                ->sortable(),
            Column::make('Обновлён','updated_at')
                ->sortable(),

        ];
    }

    public function query(): Builder
    {
        return Store::withCount('products')->withSum('products as total_quantity','store_products.stock_quantity');
    }

    public function getTableRowUrl($row): string
    {
        return route('admin.stores.edit', $row);
    }

    public function delete() {
        $this->selectedRowsQuery->delete();
        $this->resetAll();
    }
}

<?php

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

Breadcrumbs::for('admin.dashboard', function(Trail $trail) {
    $trail->push('Панель управления', route('admin.dashboard'));
});

Breadcrumbs::for('admin.products.index', function(Trail $trail) {
    $trail->parent('admin.dashboard')->push('Товары', route('admin.products.index'));
});

Breadcrumbs::for('admin.products.create', function(Trail $trail) {
    $trail->parent('admin.products.index')->push('Добавление товара', route('admin.products.create'));
});

Breadcrumbs::for('admin.products.edit', function(Trail $trail, $id) {
    $trail->parent('admin.products.index')->push('Редактирование товара', route('admin.products.edit',$id));
});

Breadcrumbs::for('admin.stores.index', function(Trail $trail) {
    $trail->parent('admin.dashboard')->push('Магазины', route('admin.stores.index'));
});

Breadcrumbs::for('admin.stores.create', function(Trail $trail) {
    $trail->parent('admin.stores.index')->push('Добавление магазина', route('admin.stores.create'));
});

Breadcrumbs::for('admin.stores.edit', function(Trail $trail, $id) {
    $trail->parent('admin.stores.index')->push('Редактирование магазина', route('admin.stores.create', $id));
});



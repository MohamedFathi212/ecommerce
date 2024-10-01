<?php 


return [
    [
        'icon' => 'fas fa-chart-line',
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard'
    ],

    [
        'icon' => 'fas fa-list',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'active' => 'dashboard.categories.*'

    ],

    [
        'icon' => 'fas fa-box',
        'route' => 'dashboard.categories.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*'

    ],

    [
        'icon' => 'fas fa-shopping-cart',
        'route' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*'

    ]

];
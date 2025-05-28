<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Breadcrumb extends Component
{
    public array $items;
    public string $lastItem;

    /**
     * @param BreadCrumb[]|BreadCrumb $breadcrumbs
     * @param string $pageTitle
     */
    public function __construct(array|BreadCrumb $breadcrumbs = [], string $pageTitle = '')
    {
        // Asegura que sea un arreglo
        $this->items = $breadcrumbs instanceof BreadCrumb ? [$breadcrumbs] : $breadcrumbs;
        $this->lastItem = $pageTitle;
    }

    public function render()
    {
        return view('components.breadcrumb');
    }
}
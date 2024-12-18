<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppbarCardapio extends Component
{
    public function __construct(
        public $data,
    ) {}
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('cardapio.appbar');
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TittleComponent extends Component
{
    public $tittle;
    /**
     * Create a new component instance.
     */
    public function __construct($tittle)
    {
        $this->tittle = $tittle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.tittle-component');
    }
}

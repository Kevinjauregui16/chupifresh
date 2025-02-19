<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonLink extends Component
{
    public $route;
    public $icon;
    /**
     * Create a new component instance.
     */
    public function __construct($route, $icon)
    {
        $this->route = $route;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.button-link');
    }
}

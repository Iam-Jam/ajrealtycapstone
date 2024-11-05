<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PropertyCard extends Component
{
    public $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function render()
    {
        return view('components.property-card');
    }
}

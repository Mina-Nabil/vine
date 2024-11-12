<?php

namespace App\View\Components;

use App\Models\Slide;
use Illuminate\View\Component;

class DashboardSlide extends Component
{
    public $slide;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-slide');
    }
}

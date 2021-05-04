<?php

namespace App\View\Components\Layouts;

use App\Models\Navigation;
use Illuminate\View\Component;

class Nav extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $navigations = Navigation::with('children')->where('url', null)->orderBy('urut', 'asc')->get();
        return view('components.layouts.navigation', compact('navigations'));
    }
}

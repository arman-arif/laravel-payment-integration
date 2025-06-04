<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function __construct(public $page = '')
    {
    }
    public function render(): View
    {
        return view('layouts.app');
    }
}

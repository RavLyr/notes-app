<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotesCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $note;
    
    public function __construct($note)
    {
        $this->note = $note;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notes-card');
    }
}

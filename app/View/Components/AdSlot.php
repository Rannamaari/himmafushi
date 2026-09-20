<?php

namespace App\View\Components;

use App\Models\Advertisement;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdSlot extends Component
{
    public ?Advertisement $advertisement;

    public function __construct(public string $position, public bool $compact = false, public bool $head = false)
    {
        $this->advertisement = Advertisement::live()
            ->where('placement', $position)
            ->orderByDesc('priority')
            ->orderBy('id')
            ->first();
    }

    public function render(): View|Closure|string
    {
        return view('components.ad-slot');
    }
}

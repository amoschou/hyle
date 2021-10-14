<?php

namespace AMoschou\Hyle\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

abstract class HyleComponent extends Component
{
    /**
     * A unique ID.
     *
     * @var string
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $livewire
     * @return void
     */
    public function __construct(
        $id = null
    ) {
        $this->id = $id ?? Str::uuid();
    }
}

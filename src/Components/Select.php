<?php

namespace AMoschou\Hyle\Components;

class Select extends HyleComponent
{
    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @return void
     */
    public function __construct(
        $id = null,
    ) {
        parent::__construct($id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $class = 'mdc-select mdc-select--outlined';

        return view('hyle::select', [
            'mdcList' => 'mdc-deprecated-list',
            'class' => $class
        ]);
    }
}

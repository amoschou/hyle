<?php

namespace AMoschou\Hyle\Components;

class ListComponent extends HyleComponent
{
    // static, menu, option, single, multis
    public $type;
    public $role;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $type
     * @return void
     */
    public function __construct(
        $id = null,
        $type = null,
        $role = null
    ) {
        parent::__construct($id);
        $this->type = $type;
        $this->role = null;
        if ($type === 'menu') {
            $this->rule = 'menu';
        } elseif (in_array($type, ['option', 'single', 'multi'])) {
            $this->rule = 'listbox';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::list');
    }
}

<?php

namespace AMoschou\Hyle\Components;

class SwitchComponent extends HyleComponent
{
    /**
     * If true, the switch is on. If false, the switch is off.
     *
     * @var boolean
     */
    public $selected = false;

    /**
     * Indicates whether or not the switch is disabled.
     *
     * @var boolean
     */
    public $disabled = false;

    /**
     * The form name of the switch.
     *
     * @var string
     */
    public $name = '';

    /**
     * The value of the switch to submit in a form when selected.
     *
     * @var string
     */
    public $value = '';

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $selected
     * @param  boolean  $disabled
     * @param  string  $name
     * @param  string  $value
     * @return void
     */
    public function __construct(
        $id = null,
        $selected = false,
        $disabled = false,
        $name = '',
        $value = ''
    ) {
        parent::__construct($id);
        $this->selected = $selected;
        $this->disabled = $disabled;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::switch');
    }
}

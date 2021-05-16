<?php

namespace AMoschou\Hyle\Components;

class Radio extends HyleComponent
{
    /**
     * Whether this radio button is the currently-selected one in its group.
     * Maps to the native checked attribute.
     *
     * @var boolean
     */
    public $checked = false;

    /**
     * If true, this radio button cannot be selected or de-selected. Maps to
     * the native disabled attribute.
     *
     * @var boolean
     */
    public $disabled = false;

    /**
     * Name of the input for form submission, and identifier for the selection
     * group. Only one radio button can be checked for a given selection group.
     * Maps to the native name attribute.
     *
     * @var string
     */
    public $name = '';

    /**
     * Value of the input for form submission. Maps to the native value
     * attribute.
     *
     * @var string
     */
    public $value = '';

    /**
     * When true, the radio removes touch target that extends beyond visual
     * boundary of the component. Set to false by default to meet Material
     * accessibility guidelines.
     *
     * @var boolean
     */
    public $reducedTouchTarget = false;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $checked
     * @param  boolean  $disabled
     * @param  string  $name
     * @param  string  $value
     * @param  boolean  $reducedTouchTarget
     * @return void
     */
    public function __construct(
        $id = null,
        $checked = false,
        $disabled = false,
        $name = '',
        $value = '',
        $reducedTouchTarget = false
    ) {
        parent::__construct($id);
        $this->checked = $checked;
        $this->disabled = $disabled;
        $this->name = $name;
        $this->value = $value;
        $this->reducedTouchTarget = $reducedTouchTarget;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::radio');
    }
}

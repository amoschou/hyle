<?php

namespace AMoschou\Hyle\Components;

class Checkbox extends HyleComponent
{
    /**
     * Whether the checkbox is checked.
     *
     * @var boolean
     */
    public $checked;

    /**
     * When a checkbox is the parent of a set of child checkboxes, the
     * indeterminate state is used on the parent to indicate that some but not
     * all of its children are checked.
     *
     * @var boolean
     */
    public $indeterminate;

    /**
     * When true, the checkbox cannot be interacted with, and renders in muted
     * colors.
     *
     * @var boolean
     */
    public $disabled;

    /**
     * The value that will be included if the checkbox is submitted in a form.
     *
     * @var string
     */
    public $value;

    /**
     * When true, the checkbox remove padding for touchscreens and increase
     * density. Note, the checkbox will no longer meet accessibility guidelines
     * for touch.
     *
     * @var boolean
     */
    public $reducedTouchTarget;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $checked
     * @param  boolean  $indeterminate
     * @param  boolean  $disabled
     * @param  string  $value
     * @param  boolean  $reducedTouchTarget
     * @return void
     */
    public function __construct(
        $id = null,
        $checked = false,
        $indeterminate = false,
        $disabled = false,
        $value = '',
        $reducedTouchTarget = false
    ) {
        parent::__construct($id);
        $this->checked = $checked;
        $this->indeterminate = $indeterminate;
        $this->disabled = $disabled;
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
        return view('hyle::checkbox');
    }
}

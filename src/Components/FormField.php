<?php

namespace AMoschou\Hyle\Components;

class FormField extends HyleComponent
{
    /**
     * The text to display for the label and sets a11y label on input. (visually overriden by slotted label)
     *
     * @var string
     */
    public $label;

    /**
     * Align the component at the end of the label.
     *
     * @var boolean
     */
    public $alignEnd;

    /**
     * Add space between the component and the label as the formfield grows.
     *
     * @var boolean
     */
    public $spaceBetween;

    /**
     * Prevents the label from wrapping and overflow text is ellipsed.
     *
     * @var boolean
     */
    public $nowrap;

    /**
     * Create a new component instance.
     *
     * @param  string  $label
     * @param  boolean  $alignEnd
     * @param  boolean  $spaceBetween
     * @param  boolean  $nowrap
     * @return void
     */
    public function __construct(
        $id = null,
        $label = '',
        $alignEnd = false,
        $spaceBetween = false,
        $nowrap = false
    ) {
        parent::__construct($id);
        $this->label = $label;
        $this->alignEnd = $alignEnd;
        $this->spaceBetween = $spaceBetween;
        $this->nowrap = $nowrap;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::form-field');
    }
}

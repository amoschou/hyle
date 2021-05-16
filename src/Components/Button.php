<?php

namespace AMoschou\Hyle\Components;

class Button extends HyleComponent
{
    /**
     * Icon to display, and aria-label value when label is not defined.
     *
     * @var string
     */
    public $icon;

    /**
     * Label to display for the button, and aria-label.
     *
     * @var string
     */
    public $label;

    /**
     * Creates a contained button that is elevated above the surface.
     *
     * @var boolean
     */
    public $raised;

    /**
     * Creates a contained button that is flush with the surface.
     *
     * @var boolean
     */
    public $unelevated;

    /**
     * Creates an outlined button that is flush with the surface.
     *
     * @var boolean
     */
    public $outlined;

    /**
     * Disabled buttons cannot be interacted with and have no visual
     * interaction effect.
     *
     * @var boolean
     */
    public $disabled;

    /**
     * When true, icon will be displayed after label.
     *
     * @var boolean
     */
    public $trailingIcon;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $icon
     * @param  string  $label
     * @param  boolean  $raised
     * @param  boolean  $unelevated
     * @param  boolean  $outlined
     * @param  boolean  $disabled
     * @param  boolean  $trailingIcon
     * @return void
     */
    public function __construct(
        $id = null,
        $icon = '',
        $label = '',
        $raised = false,
        $unelevated = false,
        $outlined = false,
        $disabled = false,
        $trailingIcon = false
    ) {
        parent::__construct($id);
        $this->icon = $icon;
        $this->label = $label;
        $this->raised = $raised;
        $this->unelevated = $unelevated;
        $this->outlined = $outlined;
        $this->disabled = $disabled;
        $this->trailingIcon = $trailingIcon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $class = 'mdc-button';
        $class .= $this->raised ? ' mdc-button--raised' : '';
        $class .= $this->unelevated ? ' mdc-button--unelevated' : '';
        $class .= $this->outlined ? ' mdc-button--outlined' : '';

        return view('hyle::button', [
            'class' => $class
        ]);
    }
}

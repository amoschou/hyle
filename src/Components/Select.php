<?php

namespace AMoschou\Hyle\Components;

class Select extends HyleComponent
{
    public $label;
    public $name;
    public $validationMessage;
    public $required;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @return void
     */
    public function __construct(
        $id = null,
        $label = null,
        $name = null,
        $validationMessage = null,
        $required = false
    ) {
        parent::__construct($id);
        $this->label = $label;
        $this->name = $name;
        $this->validationMessage = $validationMessage;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $class = 'mdc-select mdc-select--outlined';
        $class .= $this->required ? ' mdc-select--required' : '';

        return view('hyle::select', [
            'mdcList' => 'mdc-deprecated-list',
            'class' => $class
        ]);
    }
}

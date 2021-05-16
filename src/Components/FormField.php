<?php

namespace AMoschou\Hyle\Components;

class FormField extends HyleComponent
{
    /**
     * By default, the input will be positioned before the label. You can
     * position the input after the label by adding the
     * mdc-form-field--align-end class.
     *
     * @var boolean
     */
    public $alignEnd;

    /**
     * If the label text is too long for a single line, it will wrap the text
     * by default. You can force the text to stay on a single line and ellipse
     * the overflow text by adding the mdc-form-field--nowrap class.
     *
     * @var boolean
     */
    public $wrap;

    /**
     * Create a new component instance.
     *
     * @param  boolean  $alignEnd
     * @param  boolean  $wrap
     * @return void
     */
    public function __construct(
        $id = null,
        $alignEnd = false,
        $wrap = true
    ) {
        parent::__construct($id);
        $this->alignEnd = $alignEnd;
        $this->wrap = $wrap;
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

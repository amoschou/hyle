<?php

namespace AMoschou\Hyle\Components;

use Illuminate\Support\Str;

class Dialog extends HyleComponent
{
    /**
     * Whether the dialog should open.
     *
     * @var boolean
     */
    public $open;

    /**
     * Hides the actions footer of the dialog. Needed to remove excess padding
     * when no actions are slotted in.
     *
     * @var boolean
     */
    public $hideActions;

    /**
     * Whether to stack the action buttons.
     *
     * @var boolean
     */
    public $stacked;

    /**
     * Heading text of the dialog.
     *
     * @var string
     */
    public $heading;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $open
     * @param  boolean  $hideActions
     * @param  boolean  $stacked
     * @param  string  $heading
     * @return void
     */
    public function __construct(
        $open = false,
        $hideActions = false,
        $stacked = false,
        $heading = null,
        $id = null
    ) {
        parent::__construct($id);
        $this->open = $open;
        $this->hideActions = $hideActions;
        $this->stacked = $stacked;
        $this->heading = (string) Str::of($heading)->trim(); // Need cast to string here, and use === equality on the next line.
        $this->heading = $this->heading === '' ? null : $this->heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::dialog');
    }
}

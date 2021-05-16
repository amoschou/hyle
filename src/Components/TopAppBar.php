<?php

namespace AMoschou\Hyle\Components;

use Illuminate\Support\Str;

class TopAppBar extends HyleComponent
{
    /**
     * Centers the title horizontally. Only meant to be used with 0 or 1 actionItems.
     *
     * @var boolean
     */
    public $centerTitle;

    /**
     * Makes the bar a little smaller for higher density applications.
     *
     * @var boolean
     */
    public $dense;

    /**
     * Makes the bar much taller, can be combined with dense.
     *
     * @var boolean
     */
    public $prominent;

    /**
     * Styles the bar as a fixed bar.
     *
     * @var boolean
     */
    public $fixed;

    /**
     * Styles the bar as a short bar.
     *
     * @var boolean
     */
    public $short;

    /**
     * Styles the short bar to be always closed.
     *
     * @var boolean
     */
    public $shortCollapsed;

    /**
     * Element used to listen for scroll events. The Javascript types are: HTMLElement|Window.
     *
     * @var string
     */
    public $scrollTarget; // Not used in this wrapper.

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $dense
     * @param  boolean  $prominent
     * @param  boolean  $fixed
     * @param  boolean  $short
     * @param  boolean  $shortCollapsed
     * @param  boolean  $centerTitle
     * @param  string  $scrollTarget
     * @return void
     */
    public function __construct(
        $id = null,
        $dense = false,
        $prominent = false,
        $fixed = false,
        $short = false,
        $shortCollapsed = false,
        $centerTitle = false,
        $scrollTarget = 'window'
    ) {
        parent::__construct($id);
        $this->short = (boolean) $short;
        $this->dense = $this->short ? false : (boolean) $dense;
        $this->prominent = $this->short ? false : (boolean) $prominent;
        $this->fixed = (boolean) $fixed;
        $this->shortCollapsed = $this->short ? (boolean) $shortCollapsed : false;
        $this->centerTitle = (boolean) $centerTitle;
        $this->scrollTarget = $scrollTarget;

        // If ($short), then $dense and $prominent are set to false. Valid combinations are:
        //   (none)
        //   dense
        //   prominent
        //   dense and prominent
        //   short
        //   short and always collapsed
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $class = 'mdc-top-app-bar';
        $class .= $this->dense ? ' mdc-top-app-bar--dense' : '';
        $class .= $this->prominent ? ' mdc-top-app-bar--prominent' : '';
        $class .= $this->fixed ? ' mdc-top-app-bar--fixed' : '';
        $class .= $this->short ? ' mdc-top-app-bar--short' : '';
        $class .= $this->shortCollapsed ? ' mdc-top-app-bar--short-collapsed' : '';

        return view('hyle::top-app-bar', [
            'class' => $class
        ]);
    }
}

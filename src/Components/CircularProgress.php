<?php

namespace AMoschou\Hyle\Components;

class CircularProgress extends HyleComponent
{
    /**
     * Sets the circular-progress into its indeterminate state.
     *
     * @var boolean
     */
    public $indeterminate;

    /**
     * Sets the progress bar's value. Value should be between [0, 1].
     *
     * @var float
     */
    public $progress;

    /**
     * Sets the progress indicator's sizing based on density scale. Minimum
     * value is -8. Each unit change in density scale corresponds to 4px change
     * in side dimensions. The stroke width adjusts automatically.
     *
     * @var float
     */
    public $density;

    /**
     * Creates a contained button that is flush with the surface.
     *
     * @var boolean
     */
    public $closed;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $indeterminate
     * @param  string  $progress
     * @param  string  $density
     * @param  boolean  $closed
     * @return void
     */
    public function __construct(
        $id = null,
        $indeterminate = false,
        $progress = 0,
        $density = 0,
        $closed = false
    ) {
        parent::__construct($id);
        $this->indeterminate = $indeterminate;
        $this->progress = $progress;
        $this->density = $density;
        $this->closed = $closed;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::circular-progress');
    }
}

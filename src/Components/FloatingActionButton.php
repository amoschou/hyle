<?php

namespace AMoschou\Hyle\Components;

class FloatingActionButton extends HyleComponent
{
    /**
     * Modifies the FAB to be a smaller size, for use on smaller screens.
     * Defaults to false.
     *
     * @var boolean
     */
    public $mini;

    /**
     * 
     *
     * @var boolean
     */
    public $exited;

    /**
     * 
     *
     * @var boolean
     */
    public $disabled;

    /**
     * Enable the extended layout which includes a text label. Defaults to false.
     *
     * @var boolean
     */
    public $extended;

    /**
     * When in the extended layout, position the icon after the label, instead
     * of before. Defaults to false.
     *
     * @var boolean
     */
    public $showIconAtEnd;

    /**
     * Sets the minimum touch target of the default-sized mini fab to
     * recommended 48x48px.
     *
     * @var boolean
     */
    public $reducedTouchTarget;

    /**
     * The icon to display.
     *
     * @var string
     */
    public $icon;

    /**
     * The label to display when using the extended layout, and the aria-label
     * attribute in all layouts.
     *
     * @var string
     */
    public $label;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $mini
     * @param  boolean  $exited
     * @param  boolean  $disabled
     * @param  boolean  $extended
     * @param  boolean  $showIconAtEnd
     * @param  boolean  $reducedTouchTarget
     * @param  string  $icon
     * @param  string  $label
     * @return void
     */
    public function __construct(
        $id = null,
        $mini = false,
        $exited = null,
        $disabled = null,
        $extended = false,
        $showIconAtEnd = false,
        $reducedTouchTarget = null,
        $icon = '',
        $label = ''
    ) {
        parent::__construct($id);
        $this->mini = $mini;
        $this->exited = $exited;
        $this->disabled = $disabled;
        $this->extended = $extended;
        $this->showIconAtEnd = $showIconAtEnd;
        $this->reducedTouchTarget = $reducedTouchTarget;
        $this->icon = $icon;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $hasTouchTarget = $this->mini && !$this->reducedTouchTarget;
        $ariaLabel = $this->label ? $this->label : $this->icon;
        $showLabel = ($this->label !== '') && $this->extended;

        $class = 'mdc-fab';
        $class .= $this->mini ? ' mdc-fab--mini' : '';
        $class .= $hasTouchTarget ? ' mdc-fab--touch' : '';
        $class .= $this->exited ? ' mdc-fab--exited' : '';
        $class .= $this->extended ? ' mdc-fab--extended' : '';
        $class .= $this->showIconAtEnd ? ' icon-end' : '';

        return view('hyle::fab', [
            'class' => $class,
            'hasTouchTarget' => $hasTouchTarget,
            'ariaLabel' => $ariaLabel,
            'showLabel' => $showLabel,
        ]);
    }
}

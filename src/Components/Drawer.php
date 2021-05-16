<?php

namespace AMoschou\Hyle\Components;

use Illuminate\Support\Str;

class Drawer extends HyleComponent
{
    /**
     * Whether the drawer is open.
     *
     * @var boolean
     */
    public $open;

    /**
     * When true, displays the title, subtitle, and header slots.
     *
     * @var boolean
     */
    public $hasHeader;

    /**
     * When set to 'dismissible', overlays the drawer on the content. When set
     * to 'modal', also adds a scrim when the drawer is open. When set to empty
     * string, it is inlined with the page and displaces app content.
     *
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  boolean  $open
     * @param  boolean  $hasHeader
     * @param  string  $type
     * @return void
     */
    public function __construct(
        $id = null,
        $open = false,
        $hasHeader = false,
        $type = ''
    ) {
        if(!in_array($type, ['dismissible', 'dismissible-2', 'modal', ''])) {
            throw new Exception('The type must be ‘dismissible’, ‘dismissible-2’, ‘modal’ or the empty string ‘’. Instead, ‘'.$type.'’ was supplied.');
        }

        parent::__construct($id);
        $this->open = $open;
        $this->hasHeader = $hasHeader;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $class = 'mdc-drawer';
        $class .= $this->type === 'dismissible' ? ' mdc-drawer--dismissible' : '';
        $class .= $this->type === 'modal' ? ' mdc-drawer--modal' : '';

        return view('hyle::drawer', [
            'class' => $class,
            'mdcList' => 'mdc-deprecated-list'
        ]);
    }
}

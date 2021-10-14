<?php

namespace AMoschou\Hyle\Components;

class ListItem extends HyleComponent
{
    public $controlType; // A string from one of the following:
                         //   "leading-checkbox",
                         //   "trailing-checkbox",
                         //   "leading-radio",
                         //   "trailing-radio",
                         //   "leading-switch",
                         //   "trailing-switch"
    public $leadingIcon;
    public $trailingIcon;
    public $image;
    public $thumbnail;
    public $video;
    public $avatar;
    public $meta;

    public $startType; // "control", "icon", "image", "thumbnail", "video", "avatar"
    public $endType; // "meta", "icon", "control"
    public $lines; // 1, 2, 3



    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $type
     * @return void
     */
    public function __construct(
        $id = null,
        $disabled = false,
        $control = null
    ) {
        parent::__construct($id);
        $this->disabled = $disabled;
        if($type === 'basic') {

        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('hyle::list');
    }
}

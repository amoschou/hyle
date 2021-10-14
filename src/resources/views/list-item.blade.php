<li
    class="
        mdc-list-item
        @if($disabled) mdc-list-item--disabled @endif
        @if($selected && !$hasControl)
            mdc-list-item--selected
            @if($activated) mdc-list-item--activated @endif
        @endif
        @if($nonInteractive) mdc-list-item--non-interactive @endif

        mdc-list-item--with-{{ match($lines){ 1 => 'one', 2 => 'two', 3 => 'three' } }}-lines
        @if($leading) mdc-list-item--with-leading-{{ $leading }} @endif
        @if($trailing) mdc-list-item--with-trailing-{{ $leading }} @endif
    "
    id="{{ $id }}::root"
>
    <span class="mdc-list-item__ripple"></span>
    @if($leading) <span class="mdc-list-item__start">{{ $start }}</span> @endif
    <span class="mdc-list-item__content" id="{{ $id }}::content">
        @if($overlineText) <span class="mdc-list-item__overline-text">{{ $overlineText }}</span> @endif
        <span class="mdc-list-item__primary-text">{{ $primaryText }}</span>
        <span class="mdc-list-item__secondary-text">{{ $secondaryText }}</span>
    </span>
    @if($trailing) <span class="mdc-list-item__end">{{ $end }}</span> @endif
    
</li>

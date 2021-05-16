@php
    $buttonElement = $attributes['href'] ? 'a' : 'button';
@endphp
<{{ $buttonElement }}
    id="fab::{{ $id }}::root"
    {{ $attributes->merge([
        'class' => $class
    ]) }}
    @if($disabled) disabled @endif
    aria-label="{{ $ariaLabel }}"
    data-mdc-auto-init="MDCRipple"
>
    <div class="mdc-fab__ripple"></div>
    @if($showIconAtEnd) <span class="mdc-fab__label">{{ $label }}</span> @endif
    <span class="mdc-fab__icon material-icons">{{ $icon }}</span>
    @if(!$showIconAtEnd) <span class="mdc-fab__label">{{ $label }}</span> @endif
    @if($hasTouchTarget) <div class="mdc-fab__touch"></div> @endif
</{{ $buttonElement }}>

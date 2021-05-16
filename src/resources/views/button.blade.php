@php
    $buttonElement = $attributes['href'] ? 'a' : 'button';
@endphp
<{{ $buttonElement }}
    id="button::{{ $id }}::root"
    {{ $attributes->merge([
        'class' => $class
    ]) }}
    @if($disabled) disabled @endif
    data-mdc-auto-init="MDCRipple"
>
    <div class="mdc-elevation-overlay"></div>
    <div class="mdc-button__ripple"></div>
    @if($icon === '')
        <span class="mdc-button__label">{{ $label }}</span>
    @else
        @if($trailingIcon)
            <span class="mdc-button__label">{{ $label }}</span>
            <i class="material-icons mdc-button__icon" aria-hidden="true">{{ $icon }}</i>
        @else
            <i class="material-icons mdc-button__icon" aria-hidden="true">{{ $icon }}</i>
            <span class="mdc-button__label">{{ $label }}</span>
        @endif
    @endif
</{{ $buttonElement }}>

<label
    id="text-field::{{ $id }}::root"
        {{ $attributes->merge([
            'class' => $class
        ]) }}
    data-mdc-auto-init="MDCTextField"
>
    {{-- render ripple --}}
    @if(!$outlined)
        <span class="mdc-text-field__ripple"></span>
    @endif

    {{-- render outline or label --}}
    @if($outlined)
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label" id="text-field::{{ $id }}::floating-label">{{ $label }}</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
    @else
        <span class="mdc-floating-label" id="text-field::{{ $id }}::floating-label">{{ $label }}</span>
    @endif

    {{-- render leading icon --}}
    @if($icon)
        {{-- tabindex? role? --}}
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading" tabindex="0" role="button">{{ $icon }}</i>
    @endif

    {{-- render prefix --}}
    @if($prefix)
        <span class="mdc-text-field__affix mdc-text-field__affix--prefix">{{ $prefix }}</span>
    @endif

    {{-- render input --}}
    <input
        class="mdc-text-field__input"
        type="text"
        aria-labelledby="text-field::{{ $id }}::floating-label"
        aria-controls="text-field::{{ $id }}::helper-text"
        aria-describedby="text-field::{{ $id }}::helper-text"
        @if($disabled) disabled @endif
    >

    {{-- render suffix --}}
    @if($suffix)
        <span class="mdc-text-field__affix mdc-text-field__affix--suffix">{{ $suffix }}</span>
    @endif

    {{-- render trailing icon --}}
    @if($iconTrailing)
        {{-- tabindex? role? --}}
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button">{{ $icon }}</i>
    @endif

    {{-- render line ripple --}}
    @if(!$outlined)
        <span class="mdc-line-ripple"></span>
    @endif
</label>

{{-- render help text --}}
@if($shouldRenderHelperText)
    <div class="mdc-text-field-helper-line">
        <div class="mdc-text-field-helper-text" id="text-field::{{ $id }}::helper-text" aria-hidden="true" {{-- data-mdc-auto-init="MDCTextFieldHelperText" --}}>{{ $helper }}</div>
    </div>
@endif

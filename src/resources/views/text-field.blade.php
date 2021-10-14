<label
    id="text-field::{{ $id }}::root"
        {{ $attributes->whereDoesntStartWith('hyle::')->whereDoesntStartWith('wire:')->merge([
            'class' => $class . ($prefilled ? ' mdc-text-field--label-floating' : '') . ($invalid ? ' mdc-text-field--invalid' : '')
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
                <span class="mdc-floating-label @if($prefilled) mdc-floating-label--float-above @endif" id="text-field::{{ $id }}::floating-label">{{ $label }}</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
    @else
        <span class="mdc-floating-label @if($prefilled) mdc-floating-label--float-above @endif" id="text-field::{{ $id }}::floating-label">{{ $label }}</span>
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

    {!! $renderInput($shouldRenderHelperText, $attributes->whereStartsWith('wire:')) !!}

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
{!! $renderHelperText($shouldRenderHelperText, $shouldRenderCharCounter, $attributes['hyle::hasValidationError']) !!}

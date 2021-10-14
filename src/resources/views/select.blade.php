<div
    id="select::{{ $id }}::root"
    {{ $attributes->whereDoesntStartWith('hyle:')->whereDoesntStartWith('wire:')->merge([
        'class' => $class
    ]) }}
    data-mdc-auto-init="MDCSelect"
>
    @if($name)
        <input
            id="select::{{ $id }}::input-hidden"
            type="hidden"
            name="{{ $name }}"
            {{ $attributes->whereStartsWith('wire:') }}
        >
    @endif
    <div
        class="mdc-select__anchor"
        aria-labelledby="select::{{ $id }}::floating-label"
        aria-controls="select-helper-text::{{ $id }}::root"
        aria-describedby="select-helper-text::{{ $id }}::root"
        @if($required) aria-required="true" @endif
    >
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span id="select::{{ $id }}::floating-label" class="mdc-floating-label">{{ $label }}</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <span class="mdc-select__selected-text-container">
            <span class="mdc-select__selected-text"></span>
        </span>
        <span class="mdc-select__dropdown-icon">
            <svg
                    class="mdc-select__dropdown-icon-graphic"
                    viewBox="7 10 10 5" focusable="false"
            >
                <polygon
                        class="mdc-select__dropdown-icon-inactive"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 10 12 15 17 10">
                </polygon>
                <polygon
                        class="mdc-select__dropdown-icon-active"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 15 12 10 17 15">
                </polygon>
            </svg>
        </span>
    </div>

    <!-- Other elements from the select remain. -->
    <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
        <ul class="{{ $mdcList }}" role="listbox" aria-label="{{ $label }}">
            <div class="mdc-elevation-overlay"></div>
            {{ $slot }}
            @foreach($attributes['hyle:selectList'] ?? [] as $listItem)
                @php
                    if($listItem['value'] === ($attributes['hyle::selected'] ?? null)) {
                        $listItem['selected'] = true;
                    }
                @endphp
                <li
                    class="
                        {{ $mdcList }}-item
                        @if($listItem['selected']) {{ $mdcList }}-item--selected @endif
                        @if($listItem['disabled']) {{ $mdcList }}-item--disabled @endif
                    "
                    @if($listItem['selected'])
                        aria-selected="true"
                    @else
                        aria-selected="false"
                    @endif
                    data-value="{{ $listItem['value'] }}"
                    @if($listItem['disabled']) aria-disabled="true" @endif
                    role="option"
                >
                    <span class="{{ $mdcList }}-item__ripple"></span>
                    @if($listItem['text']) <span class="{{ $mdcList }}-item__text">{{ $listItem['text'] }}</span> @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
<p
    id="select-helper-text::{{ $id }}::root"
    class="
        mdc-select-helper-text
        @if($attributes['hyle::hasValidationError'])
            mdc-select-helper-text--validation-msg
            mdc-select-helper-text--validation-msg-persistent
        @endif
    "
    aria-hidden="true"
    {{-- data-mdc-auto-init="MDCSelectHelperText" --}}
>{{ $validationMessage ?? '' }}</p>

@if($attributes['hyle:livewire'])
    @push('js')
        document.getElementById('select::{{ $id }}::root').MDCSelect.listen('MDCSelect:change', ($event) => {
            @this.{{ $name }} = $event.detail.value
            document.getElementById('select::{{ $id }}::input-hidden').dispatchEvent(new Event('change'));
        });
    @endpush
@endif

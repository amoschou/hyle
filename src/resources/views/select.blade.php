<div
    id="select::{{ $id }}::root"
    {{ $attributes->whereDoesntStartWith('hyle:')->merge([
        'class' => $class
    ]) }}
    data-mdc-auto-init="MDCSelect"
>
    <div class="mdc-select__anchor" aria-labelledby="outlined-select-label">
        <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
                <span id="outlined-select-label" class="mdc-floating-label">Pick a food group</span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
        </span>
        <span class="mdc-select__selected-text-container">
            <span id="demo-selected-text" class="mdc-select__selected-text"></span>
        </span>
        <span class="mdc-select__dropdown-icon">
            <svg
                    class="mdc-select__dropdown-icon-graphic"
                    viewBox="7 10 10 5" focusable="false">
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
      <div class="mdc-elevation-overlay"></div>
        <ul class="{{ $mdcList }}" role="listbox" aria-label="Food picker listbox">
            {{ $slot }}
            @foreach($attributes['hyle:selectList'] ?? [] as $listItem)
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

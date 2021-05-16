@if(!$reducedTouchTarget)
    <div class="mdc-touch-target-wrapper">
@endif
        <div
            id="checkbox::{{ $id }}::root"
            class="
                mdc-checkbox
                @if(!$reducedTouchTarget) mdc-checkbox--touch @endif
                @if($checked) mdc-checkbox--checked @endif
                @if($indeterminate) mdc-checkbox--indeterminate @endif
                @if($disabled) mdc-checkbox--disabled @endif
            "
            data-mdc-auto-init="MDCCheckbox"
        >
            <input
                type="checkbox"
                id="checkbox::{{ $id }}::native-control"
                class="mdc-checkbox__native-control"
                @if($checked) checked @endif
                @if($indeterminate) data-indeterminate="true" @endif
                @if($disabled) disabled @endif
                @if($value) value="{{ $value }}" @endif
            />
            <div class="mdc-checkbox__background">
                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                </svg>
                <div class="mdc-checkbox__mixedmark"></div>
            </div>
            <div class="mdc-checkbox__ripple"></div>
        </div>
@if(!$reducedTouchTarget)
    </div>
@endif


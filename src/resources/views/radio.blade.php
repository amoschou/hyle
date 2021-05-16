@if(!$reducedTouchTarget)
    <div class="mdc-touch-target-wrapper">
@endif
        <div
            id="radio::{{ $id }}::root"
            class="
                mdc-radio
                @if(!$reducedTouchTarget) mdc-radio--touch @endif
                @if($disabled) mdc-radio--disabled @endif
            "
            data-mdc-auto-init="MDCRadio"
        >
            <input
                type="radio"
                id="radio::{{ $id }}::native-control"
                class="mdc-radio__native-control"
                name="{{ $name }}"
                value="{{ $value }}"
                @if($checked) checked @endif
                @if($disabled) disabled @endif
            >
            <div class="mdc-radio__background">
                <div class="mdc-radio__outer-circle"></div>
                <div class="mdc-radio__inner-circle"></div>
            </div>
            <div class="mdc-radio__ripple"></div>
        </div>
@if(!$reducedTouchTarget)
    </div>
@endif

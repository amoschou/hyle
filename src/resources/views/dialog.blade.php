@php
    $alertContent = 'Discard draft?';
    $simpleContent = <<<'SIMPLECONTENT'
        <ul class="mdc-list mdc-list--avatar-list">
            <li class="mdc-list-item" tabindex="0" data-mdc-dialog-action="none">
                <span class="mdc-list-item__text">None</span>
            </li>

            <li class="mdc-list-item" data-mdc-dialog-action="callisto">
                <span class="mdc-list-item__text">Callisto</span>
            </li>
            <!-- ... -->
        </ul>
SIMPLECONTENT;
$confirmationContent = <<<'CONFIRMATIONCONTENT'
        <ul class="mdc-list">
            <li class="mdc-list-item" tabindex="0">
                <span class="mdc-list-item__graphic">
                    <div class="mdc-radio">
                        <input class="mdc-radio__native-control"
                            type="radio"
                            id="dialog::{{ $id }}::radio::native-control::group-1::item-1"
                            name="dialog::{{ $id }}::radio::native-control::group-1"
                            checked
                        >
                        <div class="mdc-radio__background">
                            <div class="mdc-radio__outer-circle"></div>
                            <div class="mdc-radio__inner-circle"></div>
                        </div>
                    </div>
                </span>
                <label
                    id="dialog::{{ $id }}::radio::native-control::group-1::item-1::label"
                    for="dialog::{{ $id }}::radio::native-control::group-1::item-1"
                    class="mdc-list-item__text"
                >None</label>
            </li>
            <!-- ... -->
        </ul>
CONFIRMATIONCONTENT;
@endphp
<!-- ALERT DIALOG -->
<div
    id="dialog::{{ $id }}::root"
    class="mdc-dialog"
    data-mdc-auto-init="MDCDialog"
>
    <div class="mdc-dialog__container">
        <div class="mdc-dialog__surface"
            role="alertdialog"
            aria-modal="true"
            @isset($heading) aria-labelledby="dialog::{{ $id }}::title" @endisset
            aria-describedby="dialog::{{ $id }}::content"
        >
            {{ $topSlot ?? null }}

            <!-- TITLE: Brief summary of the dialog's purpose -->
            @isset($heading)
                <!-- Title cannot contain leading whitespace due to mdc-typography-baseline-top() -->
                <!-- White space has been trimmed off by the Dialog class -->
                <h2 class="mdc-dialog__title" id="dialog::{{ $id }}::title">{{ $heading }}</h2>
            @endisset

            <!-- CONTENT: Primary content area. May contain a list, a form, or prose. -->
            @isset($slot)
                <div class="mdc-dialog__content" id="dialog::{{ $id }}::content">{{ $slot }}</div>
            @endisset

            <!-- ACTIONS: Footer area containing the dialog's action buttons -->
            @if(isset($primaryAction) || isset($secondaryAction))
                <div class="mdc-dialog__actions">{{ $primaryAction ?? '' }}{{ $secondaryAction ?? '' }}</div>
            @endif
        </div>
    </div>
    <div class="mdc-dialog__scrim"></div>
</div>
@push('js')
    
@endpush

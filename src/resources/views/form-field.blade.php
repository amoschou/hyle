<div
    id="form-field::{{ $id }}::root"
    class="
        mdc-form-field
        @if($alignEnd) mdc-form-field--align-end @endif
        @if($nowrap) mdc-form-field--nowrap @endif
    "
    data-mdc-auto-init="MDCFormField"
>
    {{ $slot }}
</div>

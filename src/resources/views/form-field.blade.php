<div
    id="form-field::{{ $id }}::root"
    class="
        mdc-form-field
        @if($alignEnd) mdc-form-field--align-end @endif
        @if(!$wrap) mdc-form-field--nowrap @endif
    "
    data-mdc-auto-init="MDCFormField"
>
    {{ $slot }}
</div>

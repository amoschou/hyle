@php
    $id = $id ?? \Illuminate\Support\Str::uuid();
    // Switch
    $selected = $selected ?? false;
    $disabled = $disabled ?? false;
    $name = $name ?? null;
    $value = $value ?? null;
    // Formfield
    $label = $label ?? null;
    $alignEnd = $alignEnd = false;
    $spaceBetween = false;
    $nowrap = false;
@endphp
<x-hyle-form-field :id="$id">
    <x-hyle-switch :id="$id" selected></x-hyle-switch>
    @if(!is_null($label))
        <label for="switch::{{ $id }}::root">{{ $label }}</label>
    @endif
</x-hyle-form-field>
@push('js')
    // document.getElementById('form-field::{{ $id }}::root').MDCFormField.input = document.getElementById('switch::{{ $id }}::root').MDCSwitch;
@endpush

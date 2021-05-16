@php
    $id = $id ?? \Illuminate\Support\Str::uuid();
    $checked = $checked ?? false;
    $disabled = $disabled ?? false;
    $name = $name ?? '';
    $value = $value ?? '';
    $reducedTouchTarget = $reducedTouchTarget ?? false;
@endphp
<x-hyle-form-field :id="$id">
    <x-hyle-radio
        :id="$id"
        :name="$name"
        :value="$value"
        :disabled="$disabled"
        :checked="$checked"
        :reduced-touch-target="$reducedTouchTarget"
    ></x-hyle-radio>
    <label for="radio::{{ $id }}::native-control">{{ $label }}</label>
</x-hyle-form-field>
@push('js')
    document.getElementById('form-field::{{ $id }}::root').MDCFormField.input = document.getElementById('radio::{{ $id }}::root').MDCRadio;
@endpush
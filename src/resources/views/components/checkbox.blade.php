@php
    $id = $id ?? \Illuminate\Support\Str::uuid();
    $checked = $checked ?? false;
    $indeterminate = $indeterminate ?? false;
    $disabled = $disabled ?? false;
    $value = $value ?? '';
    $reducedTouchTarget = $reducedTouchTarget ?? false;
    $name = $name ?? '';
@endphp
<x-hyle-form-field :id="$id">
    <x-hyle-checkbox
        :id="$id"
        :checked="$checked"
        :indeterminate="$indeterminate"
        :disabled="$disabled"
        :value="$value"
        :reduced-touch-target="$reducedTouchTarget"
        :name="$name"
    ></x-hyle-checkbox>
    <label for="checkbox::{{ $id }}::native-control">{{ $label }}</label>
</x-hyle-form-field>
@push('js')
    document.getElementById('form-field::{{ $id }}::root').MDCFormField.input = document.getElementById('checkbox::{{ $id }}::root').MDCCheckbox;
@endpush

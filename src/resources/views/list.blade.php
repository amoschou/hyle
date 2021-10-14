<div
    class="mdc-list"
    data-evolution="true"
    @if($role) role="{{ $role }}" @endif
    @if($type === 'multi') aria-multiselectable="true" @endif
>{{ $slot }}</div>

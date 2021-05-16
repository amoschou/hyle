<x-hyle-drawer
    has-header
    open="true"
    type="{{ $drawerContext['type'] }}"
    id="{{ $id }}"
    class="{{ $drawerContext['class'] }}"
    :hyle::drawerContentItems="$drawerContext['contentItems']"
>
    <x-slot name="headerTop">{{ $headerTop ?? null}}</x-slot>
    <x-slot name="title">{{ $drawerContext['title'] }}</x-slot>
    <x-slot name="subtitle">{{ $drawerContext['subtitle'] }}</x-slot>
</x-hyle-drawer>

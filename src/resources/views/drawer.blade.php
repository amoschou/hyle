<aside
    id="drawer::{{ $id }}::root"
    {{ $attributes->whereDoesntStartWith('hyle::')->merge([
        'class' => $class
    ]) }}
    @if(in_array($type, ['dismissible', 'dismissible-2', 'modal'])) data-mdc-auto-init="MDCDrawer" @endif
>
    @if($hasHeader)
        <div class="mdc-drawer__header">
            {{ $headerTop }}
            <h3 class="mdc-drawer__title">{{ $title }}</h3>
            <h6 class="mdc-drawer__subtitle">{{ $subtitle }}</h6>
        </div>
    @endif
    <div class="mdc-drawer__content">
        @foreach($attributes['hyle::drawerContentItems'] ?? [] as $item)
            @if($loop->first)
                <nav class="{{ $mdcList }}" id="list::{{ $id }}::root" @if($type === '') data-mdc-auto-init="MDCList" @endif >
            @endif
            @if(($item['role'] ?? 'item') === 'divider')
                <hr class="mdc-deprecated-list-divider">
                <h6 class="mdc-deprecated-list-group__subheader">{{ $item['group-subheader'] }}</h6>
            @elseif(!($item['hidden'] ?? false))
                <a
                    class="
                        {{ $mdcList }}-item
                        @if($item['activated']) {{ $mdcList }}-item--activated @endif
                    "
                    href="{{ route($item['route'], $item['route-parameter'] ?? null) }}"
                    @if($item['activated'])
                        aria-current="page"
                        tabindex="0"
                    @endif
                    data-mdc-auto-init="MDCRipple"
                >
                    <span class="{{ $mdcList }}-item__ripple"></span>
                    @if($item['icon'] === 'icon:svg')
                        <div class="{{ $mdcList }}-item__graphic" aria-hidden="true">
                            {!! $item['icon-svg'] !!}
                        </div>
                    @elseif($item['icon'] === 'icon:named-svg')
                        <div class="{{ $mdcList }}-item__graphic" aria-hidden="true">
                            @include($item['icon-named-svg'])
                        </div>
                    @else
                        <i class="material-icons {{ $mdcList }}-item__graphic" aria-hidden="true">{{ $item['icon'] }}</i>
                    @endif
                    <span class="{{ $mdcList }}-item__text">{{ $item['text'] }}</span>
                </a>
            @endif
            @if($loop->last)
                </nav>
            @endif
        @endforeach
    </div>
</aside>

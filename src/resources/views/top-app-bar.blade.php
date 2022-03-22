<header
    id="top-app-bar::{{ $id }}::root"
    {{ $attributes->whereDoesntStartWith('hyle::')->merge([
        'class' => $class . ($attributes['hyle::contextualTopAppBar'] ? ' hyle-contextual-top-app-bar' : '') . ($attributes['hyle::contextualTopAppBarSemantic'] ? ' hyle-contextual-top-app-bar--'.$attributes['hyle::contextualTopAppBarSemantic'] : '')
    ]) }}
    data-mdc-auto-init="MDCTopAppBar"
>
    <div class="mdc-elevation-overlay"></div>
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            @isset($navigationIcon)
                {{ $navigationIcon }}
            @else
                <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="icon-button::{{ $id }}::top-app-bar::navigation-icon" aria-label="Open navigation menu" data-mdc-auto-init="MDCRipple">menu</button>
                @push('js')
                    document.getElementById('icon-button::{{ $id }}::top-app-bar::navigation-icon').MDCRipple.unbounded = true;
                @endpush
            @endisset
            <span class="mdc-top-app-bar__title">{{ $title }}</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            @stack('actionItems')
            @foreach($attributes['hyle::actionItems'] ?? [] as $item)
                @if($item['action'] === 'menu')
                    <div class="mdc-menu-surface--anchor">
                        <button
                            class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                            id="icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}"
                            aria-label="{{ $item['label'] }}"
                            data-mdc-auto-init="MDCRipple"
                        ><div class="mdc-icon-button__ripple"></div>{{ $item['icon'] }}</button>
                        @push('js')
                            document.getElementById('icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').MDCRipple.unbounded = true;
                        @endpush
                        <div id="menu::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}" class="mdc-menu mdc-menu-surface" data-mdc-auto-init="MDCMenu">
                            <div class="mdc-elevation-overlay"></div>
                            <div class="mdc-deprecated-list-group">
                                @auth
                                    <h3 class="mdc-deprecated-list-group__subheader">{{ Auth::user()->name }}</h3>
                                @endauth
                                <ul class="mdc-deprecated-list mdc-deprecated-list--icon-list" role="menu" aria-hidden="true" aria-orientation="vertical" tabindex="-1">
                                    @foreach($item[Auth::check() ? 'menu.auth' : 'menu.guest'] ?? $item['menu'] as $menuItem)
                                        @if($menuItem['role'] ?? 'menuitem' === 'separator')
                                            <li role="separator" class="mdc-deprecated-list-divider"></li>
                                        @else
                                            @if($menuItem['method'] ?? 'get' === 'post')
                                            <form action="{{ route($menuItem['route']) }}" method="POST">
                                                @csrf
                                                <a class="mdc-deprecated-list-item" role="menuitem" data-mdc-auto-init="MDCRipple" href="{{ route($menuItem['route']) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <span class="mdc-deprecated-list-item__ripple"></span>
                                                    <span class="material-icons mdc-deprecated-list-item__graphic" aria-hidden="true">{{ $menuItem['icon'] }}</span>
                                                    <span class="mdc-deprecated-list-item__text">{{ $menuItem['text'] }}</span>
                                                </a>
                                            </form>
                                            @else
                                                <a class="mdc-deprecated-list-item" role="menuitem" data-mdc-auto-init="MDCRipple" href="{{ route($menuItem['route']) }}">
                                                    <span class="mdc-deprecated-list-item__ripple"></span>
                                                    <span class="material-icons mdc-deprecated-list-item__graphic" aria-hidden="true">{{ $menuItem['icon'] }}</span>
                                                    <span class="mdc-deprecated-list-item__text">{{ $menuItem['text'] }}</span>
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @push('js')
                            document.getElementById('icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').addEventListener('click', function () {
                                document.getElementById('menu::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').MDCMenu.open = true;
                            });

                            document.getElementById('icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').addEventListener('keydown', event => {
                                if(event.code === 'Space' || event.code === 'Enter') {
                                    document.getElementById('menu::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').MDCMenu.open = true;
                                }
                            });
                        @endpush
                    </div>
                @elseif($item['action'] === 'route')
                    <a
                        class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                        id="icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}"
                        aria-label="{{ $item['label'] }}"
                        data-mdc-auto-init="MDCRipple"
                        href="{{ route($item['route'], $item['route-parameters'] ?? []) }}"
                    >
                        <div class="mdc-icon-button__ripple"></div>
                        @if($item['icon'] === 'icon:named-svg')
                            @include($item['icon-named-svg'])
                        @else
                            {{ $item['icon'] }}
                        @endif
                    </a>
                @else
                    @php $element = ($item['href'] ?? false) ? 'a' : 'button'; @endphp
                    <{{ $element }}
                        class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                        id="icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}"
                        aria-label="{{ $item['label'] }}"
                        data-mdc-auto-init="MDCRipple"
                        @if($item['href'] ?? false) href="{{ $item['href'] }}" @endif
                    ><div class="mdc-icon-button__ripple"></div>{{
                        $item['icon']
                    }}</{{ $element }}>
                    @push('js')
                        document.getElementById('icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').MDCRipple.unbounded = true;
                    @endpush
                @endif
            @endforeach
        </section>
    </div>
</header>

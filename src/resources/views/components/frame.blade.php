@php
    $mdcList = in_array($version ?? '11.0.0', ['self', 'latest', '11.0.0', 'hyle']) ? 'mdc-deprecated-list' : 'mdc-list';
@endphp

@php
    if($topAppBarShort ?? false) {
        if(!is_null($topAppBarActionItems ?? null)) {
            $topAppBarActionItems = [end($topAppBarActionItems)];
        }
        $topAppBarDense = false;
        $topAppBarProminent = false;
    }

    $id = $id ?? \Illuminate\Support\Str::uuid();

    $drawerOpen = ($drawerType === 'dismissible' || $drawerType === 'dismissible-2') ? ($drawerOpen ?? false) : false;

    $bareApp = $bareApp ?? false;

    // TOP APP BAR MUST BE FIXED IF THE DRAWER IS DISMISSIBLE-2
    $topAppBarFixed = $drawerType === 'dismissible-2' ? true : ($topAppBarFixed ?? false);

    $frameContext = [
        'drawer' => [
            'title' => $drawerTitle ?? null,
            'subtitle' => $drawerSubtitle ?? null,
            'type' => $drawerType ?? null,
            'class' => ($drawerOpen && ($drawerType === 'dismissible' || $drawerType === 'dismissible-2')) ? 'mdc-drawer--open' : '',
            'contentItems' => $drawerContentItems,
        ],
        'top-app-bar' => [
            'title' => $topAppBarTitle ?? null,
            'dense' => $topAppBarDense ?? false,
            'prominent' => $topAppBarProminent ?? false,
            'fixed' => $topAppBarFixed ?? false,
            'short' => $topAppBarShort ?? false,
            'short-collapsed' => $topAppBarShortCollapsed ?? false,
            'action-items' => $topAppBarActionItems,
        ]
    ];

    $classFixedAdjust = ''
        . 'mdc-top-app-bar-'
        . ($frameContext['top-app-bar']['dense'] ? '-dense' : '')
        . ($frameContext['top-app-bar']['short'] ? '-short' : '')
        . ($frameContext['top-app-bar']['prominent'] ? '-prominent' : '')
        . '-fixed-adjust'
    ;

    // NOTE VALID COMBINATIONS ARE:
    //   .mdc-top-app-bar--fixed-adjust
    //   .mdc-top-app-bar--dense-fixed-adjust
    //   .mdc-top-app-bar--short-fixed-adjust
    //   .mdc-top-app-bar--prominent-fixed-adjust
    //   .mdc-top-app-bar--dense-prominent-fixed-adjust
@endphp

{{-- --------------- --}}
{{-- STANDARD DRAWER --}}
{{-- --------------- --}}

@if($drawerType === 'standard' || $drawerType === '' || $drawerType === 'none')
    @php
        $frameContext['drawer']['type'] = '';
    @endphp
    @unless($drawerType === 'none')
        <x-hyle::drawer :drawerContext="$frameContext['drawer']" :id="$id">
            <x-slot name="headerTop">{{ $drawerHeaderTop ?? null }}</x-slot>
        </x-hyle::drawer>
    @endunless
    <div class="mdc-drawer-app-content">
        <x-hyle-top-app-bar
            :id="$id"
            class="top-app-bar--{{ $id }}--root"
            :dense="$frameContext['top-app-bar']['dense']"
            :prominent="$frameContext['top-app-bar']['prominent']"
            :fixed="$frameContext['top-app-bar']['fixed']"
            :short="$frameContext['top-app-bar']['short']"
            :shortCollapsed="$frameContext['top-app-bar']['short-collapsed']"
            :hyle::actionItems="$contextualTopAppBar ? [] : $frameContext['top-app-bar']['action-items']"
            :hyle::contextualTopAppBar="$contextualTopAppBar"
            :hyle::contextualTopAppBarSemantic="$contextualTopAppBarSemantic ?? null"
        >
            <x-slot name="navigationIcon">
                @if(($contextualTopAppBarIcon ?? true) && $contextualTopAppBar)
                    <a href="{{ $contextualTopAppBarNavigationIconRoute }}" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="icon-button::{{ $id }}::top-app-bar::navigation-icon" aria-label="Close contextual page" data-mdc-auto-init="MDCRipple">close</a>
                @endif
            </x-slot>
            <x-slot name="title">{{ $frameContext['top-app-bar']['title'] }}</x-slot>
        </x-top-app-bar>

        <main class="frame--{{ $id }}--main frame-main-article" id="frame::{{ $id }}::main">
            <div class="{{ $classFixedAdjust }}"></div>

            {{ $banner ?? '' }}

            {{ $navRegion ?? '' }}
            
            @if($bareApp)
                {{ $slot }}
            @else
                <div class="mdc-layout-grid mdc-layout-grid--padding-top-0 mdc-layout-grid--padding-bottom-8">
                    <div class="mdc-layout-grid__inner">
                        <div
                            class="
                                mdc-layout-grid__cell
                                mdc-layout-grid__cell--span-12-desktop
                                mdc-layout-grid__cell--span-8-tablet
                                mdc-layout-grid__cell--span-4-phone
                            ">{{ $slot }}</div>
                    </div>
                </div>
            @endif
        </main>

{{ $footer ?? '' }}
    </div>

    {{ $frameFab ?? null }}

    @push('js')
        document.getElementById('list::{{ $id }}::root').MDCList.wrapFocus = true;
        // Required, otherwise the top app bar does not shift up upon scroll.
        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.setScrollTarget(document.getElementById('frame::{{ $id }}::main'));
    @endpush
    
    @push('css')
        body {
            display: flex;
            height: 100vh;
        }
        .mdc-drawer-app-content {
            flex: auto;
            overflow: auto;
            position: relative;
        }
        .frame--{{ $id }}--main {
            overflow: auto;
            height: 100%;
        }
        .top-app-bar--{{ $id }}--root {
            position: absolute;
        }
        .mdc-fab {
            z-index: 6;
        }
    @endpush
@endif

{{-- ---------------------- --}}
{{-- END OF STANDARD DRAWER --}}
{{-- ---------------------- --}}

{{-- ------------------ --}}
{{-- DISMISSIBLE DRAWER --}}
{{-- ------------------ --}}

@if($drawerType === 'dismissible')
    <x-hyle::drawer :drawerContext="$frameContext['drawer']" :id="$id">
        <x-slot name="headerTop">{{ $drawerHeaderTop ?? null }}</x-slot>
    </x-hyle::drawer>
    <div class="mdc-drawer-app-content">
        <x-hyle-top-app-bar
            :id="$id"
            class="top-app-bar--{{ $id }}--root"
            :dense="$frameContext['top-app-bar']['dense']"
            :prominent="$frameContext['top-app-bar']['prominent']"
            :fixed="$frameContext['top-app-bar']['fixed']"
            :short="$frameContext['top-app-bar']['short']"
            :shortCollapsed="$frameContext['top-app-bar']['short-collapsed']"
            :hyle::actionItems="$contextualTopAppBar ? [] : $frameContext['top-app-bar']['action-items']"
            :hyle::contextualTopAppBar="$contextualTopAppBar"
            :hyle::contextualTopAppBarSemantic="$contextualTopAppBarSemantic ?? null"
        >
            <x-slot name="navigationIcon">
                @if($contextualTopAppBar)
                    <a href="{{ $contextualTopAppBarNavigationIconRoute }}" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="icon-button::{{ $id }}::top-app-bar::navigation-icon" aria-label="Close contextual page" data-mdc-auto-init="MDCRipple">close</a>
                @endif
            </x-slot>
            <x-slot name="title">{{ $frameContext['top-app-bar']['title'] }}</x-slot>
        </x-top-app-bar>

        <main class="frame--{{ $id }}--main frame-main-article" id="frame::{{ $id }}::main">
            <div class="{{ $classFixedAdjust }}"></div>

            {{ $banner ?? '' }}

            {{ $navRegion ?? '' }}

            @if($bareApp)
                {{ $slot }}
            @else
                <div class="mdc-layout-grid mdc-layout-grid--padding-top-0 mdc-layout-grid--padding-bottom-8">
                    <div class="mdc-layout-grid__inner">
                        <div
                            class="
                                mdc-layout-grid__cell
                                mdc-layout-grid__cell--span-12-desktop
                                mdc-layout-grid__cell--span-8-tablet
                                mdc-layout-grid__cell--span-4-phone
                            ">{{ $slot }}</div>
                    </div>
                </div>
            @endif

        </main>

{{ $footer ?? '' }}
    </div>

    {{ $frameFab ?? null }}

    @push('js')
        document.getElementById('list::{{ $id }}::root').addEventListener('click', (event) => {
            if(null !== document.getElementById('frame::{{ $id }}::main').querySelector('input, button')) {
                document.getElementById('frame::{{ $id }}::main').querySelector('input, button').focus();
            }
        });

        document.body.addEventListener('MDCDrawer:closed', () => {
            if(null !== document.getElementById('frame::{{ $id }}::main').querySelector('input, button')) {
                document.getElementById('frame::{{ $id }}::main').querySelector('input, button').focus();
            }
        });

        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.setScrollTarget(document.getElementById('frame::{{ $id }}::main'));

        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.listen('MDCTopAppBar:nav', () => {
            document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open = !document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open;
        });
    @endpush
    
    @push('css')
        body {
            display: flex;
            height: 100vh;
        }
        .mdc-drawer-app-content {
            flex: auto;
            overflow: auto;
            position: relative;
        }
        .frame--{{ $id }}--main {
            overflow: auto;
            height: 100vh;
        }
        .top-app-bar--{{ $id }}--root {
            position: absolute;
        }
        .mdc-fab {
            z-index: 4;
        }
    @endpush
@endif

{{-- ------------------------- --}}
{{-- END OF DISMISSIBLE DRAWER --}}
{{-- ------------------------- --}}

{{-- -------------------- --}}
{{-- DISMISSIBLE DRAWER 2 --}}
{{-- -------------------- --}}

@if($drawerType === 'dismissible-2')
    @php
        $frameContext['drawer']['class'] .= " {$classFixedAdjust}";
        $frameContext['drawer']['type'] = 'dismissible';
    @endphp

    <x-hyle-top-app-bar
        :id="$id"
        class="top-app-bar--{{ $id }}--root"
        :dense="$frameContext['top-app-bar']['dense']"
        :prominent="$frameContext['top-app-bar']['prominent']"
        :fixed="$frameContext['top-app-bar']['fixed']"
        :short="$frameContext['top-app-bar']['short']"
        :shortCollapsed="$frameContext['top-app-bar']['short-collapsed']"
        :hyle::actionItems="$contextualTopAppBar ? [] : $frameContext['top-app-bar']['action-items']"
        :hyle::contextualTopAppBar="$contextualTopAppBar"
        :hyle::contextualTopAppBarSemantic="$contextualTopAppBarSemantic ?? null"
    >
        <x-slot name="navigationIcon">
            @if($contextualTopAppBar)
                <a href="{{ $contextualTopAppBarNavigationIconRoute }}" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="icon-button::{{ $id }}::top-app-bar::navigation-icon" aria-label="Close contextual page" data-mdc-auto-init="MDCRipple">close</a>
            @endif
        </x-slot>
        <x-slot name="title">{{ $frameContext['top-app-bar']['title'] }}</x-slot>
    </x-top-app-bar>

    <x-hyle::drawer :drawerContext="$frameContext['drawer']" :id="$id">
        <x-slot name="headerTop">{{ $drawerHeaderTop ?? null }}</x-slot>
    </x-hyle::drawer>

    <div class="mdc-drawer-app-content {{ $classFixedAdjust }}">
        <main class="frame--{{ $id }}--main frame-main-article" id="frame::{{ $id }}::main">
            {{ $banner ?? '' }}

            {{ $navRegion ?? '' }}

            @if($bareApp)
                {{ $slot }}
            @else
                <div class="mdc-layout-grid mdc-layout-grid--padding-top-0  mdc-layout-grid--padding-bottom-8">
                    <div class="mdc-layout-grid__inner">
                        <div
                            class="
                                mdc-layout-grid__cell
                                mdc-layout-grid__cell--span-12-desktop
                                mdc-layout-grid__cell--span-8-tablet
                                mdc-layout-grid__cell--span-4-phone
                            ">{{ $slot }}</div>
                    </div>
                </div>
            @endif
        </main>

{{ $footer ?? '' }}
    </div>

    {{ $frameFab ?? null }}

    @push('js')
        document.getElementById('list::{{ $id }}::root').addEventListener('click', (event) => {
            if(null !== document.getElementById('frame::{{ $id }}::main').querySelector('input, button')) {
                document.getElementById('frame::{{ $id }}::main').querySelector('input, button').focus();
            }
        });

        document.body.addEventListener('MDCDrawer:closed', () => {
            if(null !== document.getElementById('frame::{{ $id }}::main').querySelector('input, button')) {
                document.getElementById('frame::{{ $id }}::main').querySelector('input, button').focus();
            }
        });

        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.setScrollTarget(document.getElementById('frame::{{ $id }}::main'));

        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.listen('MDCTopAppBar:nav', () => {
            document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open = !document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open;
        });
    @endpush

    @push('css')
        body {
            display: flex;
            height: 100vh;
        }
        .mdc-drawer-app-content {
            flex: auto;
            overflow: auto;
            position: relative;
        }
        .frame--{{ $id }}--main {
            overflow: auto;
            height: 100%;
        }
        .top-app-bar--{{ $id }}--root {
            position: absolute;
            z-index: 7;
        }
        .mdc-fab {
            z-index: 7;
        }
    @endpush
@endif

{{-- ------------------------- --}}
{{-- END OF DISMISSIBLE DRAWER --}}
{{-- ------------------------- --}}


{{-- ------------ --}}
{{-- MODAL DRAWER --}}
{{-- ------------ --}}

@if($drawerType === 'modal')
    <x-hyle::drawer :drawerContext="$frameContext['drawer']" :id="$id">
        <x-slot name="headerTop">{{ $drawerHeaderTop ?? null }}</x-slot>
    </x-hyle::drawer>

    <div class="mdc-drawer-scrim"></div>

    <div id="frame::{{ $id }}::main">
        <x-hyle-top-app-bar
            id="{{ $id }}"
            :dense="$frameContext['top-app-bar']['dense']"
            :prominent="$frameContext['top-app-bar']['prominent']"
            :fixed="$frameContext['top-app-bar']['fixed']"
            :short="$frameContext['top-app-bar']['short']"
            :shortCollapsed="$frameContext['top-app-bar']['short-collapsed']"
            :hyle::actionItems="$contextualTopAppBar ? [] : $frameContext['top-app-bar']['action-items']"
            :hyle::contextualTopAppBar="$contextualTopAppBar"
            :hyle::contextualTopAppBarSemantic="$contextualTopAppBarSemantic ?? null"
        >
            <x-slot name="navigationIcon">
                @if($contextualTopAppBar)
                    <a href="{{ $contextualTopAppBarNavigationIconRoute }}" class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button" id="icon-button::{{ $id }}::top-app-bar::navigation-icon" aria-label="Close contextual page" data-mdc-auto-init="MDCRipple">close</a>
                @endif
            </x-slot>
            <x-slot name="title">{{ $frameContext['top-app-bar']['title'] }}</x-slot>
        </x-top-app-bar>

        <div class="{{ $classFixedAdjust }}"></div>

        {{ $banner ?? '' }}

        {{ $navRegion ?? '' }}

        @if($bareApp)
            {{ $slot }}
        @else
            <div class="mdc-layout-grid mdc-layout-grid--padding-top-0 mdc-layout-grid--padding-bottom-8">
                <div class="mdc-layout-grid__inner">
                    <div
                        class="
                            mdc-layout-grid__cell
                            mdc-layout-grid__cell--span-12-desktop
                            mdc-layout-grid__cell--span-8-tablet
                            mdc-layout-grid__cell--span-4-phone
                        ">{{ $slot }}</div>
                </div>
            </div>
        @endif
    </div>

    {{ $frameFab ?? null }}

    @push('js')
        // FOCUS MANAGEMENT

        document.getElementById('list::{{ $id }}::root').addEventListener('click', (event) => {
            document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open = false;
        });

        document.body.addEventListener('MDCDrawer:closed', () => {
            if(null !== document.getElementById('frame::{{ $id }}::main').querySelector('input, button')) {
                document.getElementById('frame::{{ $id }}::main').querySelector('input, button').focus();
            }

            // Added by amoschou:
            document.body.classList.remove('hyle-scroll-lock');
        });

        document.getElementById('top-app-bar::{{ $id }}::root').MDCTopAppBar.listen('MDCTopAppBar:nav', () => {
            document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open = !document.getElementById('drawer::{{ $id }}::root').MDCDrawer.open;
        });

        // Additional by amoschou
        document.body.addEventListener('MDCDrawer:opened', () => {
            document.body.classList.add('hyle-scroll-lock');
        });
    @endpush

    @push('css')
        .mdc-fab {
            z-index: 4;
        }
    @endpush
@endif

{{-- ------------------- --}}
{{-- END OF MODAL DRAWER --}}
{{-- ------------------- --}}

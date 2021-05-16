<header
    id="top-app-bar::{{ $id }}::root"
    {{ $attributes->whereDoesntStartWith('hyle::')->merge([
        'class' => $class
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
            @foreach($attributes['hyle::actionItems'] ?? [] as $item)
                @php $element = ($item['href'] ?? false) ? 'a' : 'button'; @endphp
                <{{ $element }}
                    class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    id="icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}"
                    aria-label="{{ $item['label'] }}"
                    data-mdc-auto-init="MDCRipple"
                    @if($item['href'] ?? false) href="{{ $item['href'] }}" @endif
                >{{
                    $item['icon']
                }}</{{ $element }}>
                @push('js')
                    document.getElementById('icon-button::{{ $id }}::top-app-bar::action-item-{{ $loop->index }}').MDCRipple.unbounded = true;
                @endpush
            @endforeach
        </section>
    </div>
</header>

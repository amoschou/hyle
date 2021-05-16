@php
    $sizes = [
        'large' => [
            'widthHeight' => [48, 48],
            'cxCy' => 24,
            'r' => 18,
            'strokeWidth' => [4, 3.2],
            'strokeDasharray' => 113.097,
            'strokeDashoffset' => [113.097, 56.549],
        ],
        'medium' => [
            'widthHeight' => [36, 32],
            'cxCy' => 16,
            'r' => 12.5,
            'strokeWidth' => [3, 2.4],
            'strokeDasharray' => 78.54,
            'strokeDashoffset' => [78.54, 39.27],
        ],
        'small' => [
            'widthHeight' => [24, 24],
            'cxCy' => 12,
            'r' => 8.75,
            'strokeWidth' => [2.5, 2],
            'strokeDasharray' => 54.978,
            'strokeDashoffset' => [54.978, 27.489],
        ],
    ];
    $size = 'large';
    $consts = $sizes[$size];
    $label = $label ?? 'Example Progress Bar';
@endphp
<div
    id="circular-progress::{{ $id }}::root"
    class="mdc-circular-progress"
    style="width:{{ $consts['widthHeight'][0] }}px;height:{{ $consts['widthHeight'][0] }}px;"
    role="progressbar"
    aria-label="{{ $label }}"
    aria-valuemin="0"
    aria-valuemax="1"
    data-mdc-auto-init="MDCCircularProgress"
>
    <div class="mdc-circular-progress__determinate-container">
        <svg
            class="mdc-circular-progress__determinate-circle-graphic"
            viewBox="0 0 {{ $consts['widthHeight'][1] }} {{ $consts['widthHeight'][1] }}"
            xmlns="http://www.w3.org/2000/svg"
        >
            <circle
                class="mdc-circular-progress__determinate-track"
                cx="{{ $consts['cxCy'] }}"
                cy="{{ $consts['cxCy'] }}"
                r="{{ $consts['r'] }}"
                stroke-width="{{ $consts['strokeWidth'][0] }}"
            />
            <circle
                class="mdc-circular-progress__determinate-circle"
                cx="{{ $consts['cxCy'] }}"
                cy="{{ $consts['cxCy'] }}"
                r="{{ $consts['r'] }}"
                stroke-dasharray="{{ $consts['strokeDasharray'] }}"
                stroke-dashoffset="{{ $consts['strokeDashoffset'][0] }}"
                stroke-width="{{ $consts['strokeWidth'][0] }}"
            />
        </svg>
    </div>
    <div class="mdc-circular-progress__indeterminate-container">
        <div class="mdc-circular-progress__spinner-layer">
            <div class="mdc-circular-progress__circle-clipper mdc-circular-progress__circle-left">
                <svg
                    class="mdc-circular-progress__indeterminate-circle-graphic"
                    viewBox="0 0 {{ $consts['widthHeight'][1] }} {{ $consts['widthHeight'][1] }}"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="{{ $consts['cxCy'] }}"
                        cy="{{ $consts['cxCy'] }}"
                        r="{{ $consts['r'] }}"
                        stroke-dasharray="{{ $consts['strokeDasharray'] }}"
                        stroke-dashoffset="{{ $consts['strokeDashoffset'][1] }}"
                        stroke-width="{{ $consts['strokeWidth'][0] }}"
                    />
                </svg>
            </div>
            <div class="mdc-circular-progress__gap-patch">
                <svg
                    class="mdc-circular-progress__indeterminate-circle-graphic"
                    viewBox="0 0 {{ $consts['widthHeight'][1] }} {{ $consts['widthHeight'][1] }}"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="{{ $consts['cxCy'] }}"
                        cy="{{ $consts['cxCy'] }}"
                        r="{{ $consts['r'] }}"
                        stroke-dasharray="{{ $consts['strokeDasharray'] }}"
                        stroke-dashoffset="{{ $consts['strokeDashoffset'][1] }}"
                        stroke-width="{{ $consts['strokeWidth'][1] }}"
                    />
                </svg>
            </div>
            <div class="mdc-circular-progress__circle-clipper mdc-circular-progress__circle-right">
                <svg
                    class="mdc-circular-progress__indeterminate-circle-graphic"
                    viewBox="0 0 {{ $consts['widthHeight'][1] }} {{ $consts['widthHeight'][1] }}"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="{{ $consts['cxCy'] }}"
                        cy="{{ $consts['cxCy'] }}"
                        r="{{ $consts['r'] }}"
                        stroke-dasharray="{{ $consts['strokeDasharray'] }}"
                        stroke-dashoffset="{{ $consts['strokeDashoffset'][1] }}"
                        stroke-width="{{ $consts['strokeWidth'][0] }}"
                    />
                </svg>
            </div>
        </div>
    </div>
</div>
@push('js')
    document.getElementById('circular-progress::{{ $id }}::root').MDCCircularProgress.determinate = {{ $indeterminate ? 'false' : 'true' }};
    @if(!$indeterminate)
        document.getElementById('circular-progress::{{ $id }}::root').MDCCircularProgress.progress = {{ $progress }};
    @endif
    document.getElementById('circular-progress::{{ $id }}::root').MDCCircularProgress.open();
@endpush

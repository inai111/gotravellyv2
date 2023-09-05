@props(['color'=>false])

<div @class([
    'toast show fade align-items-center',
    "text-bg-{$color}" => isset($color),
    'border-0' => isset($color),
]) role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            {{ $slot }}
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

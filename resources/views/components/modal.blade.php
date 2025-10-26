@props(['id' => 'modalID', 'title' => null, 'size' => 'md', 'backDrop' => false])

<div
    x-data="{
        show: false,
        modalId: @js($id)
    }"
    x-init="const modalEl = $refs.modal;
    modalEl.addEventListener('hidden.bs.modal', function(event) {
        $dispatch('hide:modal', { id: modalId });
    });"
    x-on:show:modal.window="if ($event.detail.id === modalId) show = true"
    x-on:hide:modal.window="if ($event.detail.id === modalId) show = false"
    x-effect="
        if (show) {
            let modalInstance = new bootstrap.Modal($refs.modal, { keyboard: true });
            modalInstance.show();
        } else {
            let instance = bootstrap.Modal.getInstance($refs.modal);
            if (instance) instance.hide();
        }
    "
    wire:ignore
>
    <div
        class="modal fade modal-{{ $size }}"
        id="{{ $id }}"
        tabindex="-1"
        x-ref="modal"
        @if ($backDrop) data-bs-backdrop="static" @endif
        {{ $attributes->merge() }}
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                @if ($title)
                    <div class="modal-header">
                        <h5 class="modal-title h4">{{ Str::title($title) }}</h5>
                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"
                            aria-label="Close"
                            @click="$dispatch('hide:modal', { id: modalId })"
                        ></button>
                    </div>
                @endif

                <div class="modal-body">
                    {{ $slot }}
                </div>
                {{ $footer ?? '' }}
            </div>
        </div>
    </div>
</div>
